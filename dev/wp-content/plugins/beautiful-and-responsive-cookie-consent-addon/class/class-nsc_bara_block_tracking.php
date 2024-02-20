<?php
if (!defined('ABSPATH')) {
    exit;
}

require NSC_BARA_PLUGIN_DIR . "/block-ressources-config.php";

class nsc_bara_tracking_blocker
{
    private $buffer_set;
    private $user_consent;
    private $blocked_services;

    public function nsc_bara_enqueue_blocking_scripts()
    {
        wp_register_script('nsc_bara_blocking_script', NSC_BARA_PLUGIN_URL . 'public/js/nscBlockScripts.js', array(), NSC_BARA_PLUGIN_VERSION, false);
        wp_add_inline_script('nsc_bara_blocking_script', $this->get_inline_scripts(false), 'before');
        wp_enqueue_script('nsc_bara_blocking_script');
    }

    public function nsc_bara_echo_blocking_scripts()
    {
        $this->nsc_bara_echo_include_scripts_with_tags();
        echo "\n" . '<script id="nsc_bara_blocking_scripts" data-pagespeed-no-defer data-cfasync nowprocket data-no-optimize="1" data-no-defer="1" type="text/javascript" src="' . NSC_BARA_PLUGIN_URL . 'public/js/nscBlockScripts.js?v=' . NSC_BARA_PLUGIN_VERSION . '"></script>' . "\n";
    }

    public function nsc_bara_echo_include_scripts_with_tags()
    {
        echo '<script id="nsc_bara_blocking_scripts_inline" data-pagespeed-no-defer data-cfasync nowprocket data-no-optimize="1" data-no-defer="1">' . $this->get_inline_scripts(true) . '</script>';
    }

    private function get_inline_scripts($escape)
    {

        $blockedScriptPerApi = get_option("nsc_bar_blockedScriptsDynamicApiCall", "0") === "1" ? true : false;
        $inline = 'window.nsc_bara_blocked_services = ' . json_encode($this->escape_services($this->nsc_bara_get_blocked_services(), $escape)) . ';';
        if ($blockedScriptPerApi === true) {
            $inline = 'window.nsc_bara_blocked_services = ' . json_encode($this->escape_services($this->nsc_bara_get_blocked_services_configured(), $escape)) . ';';
            $inline .= 'window.nsc_bara_blockedScriptsPerApi = ' . $blockedScriptPerApi . ' ? true : false;';
        }
        $inline .= 'window.nsc_bara_wp_rest_api_url = "' . esc_js(get_rest_url()) . '";';
        return $inline;
    }

    private function escape_services($services, $escape)
    {
        if ($escape === false) {
            return $services;
        }

        $escaped_services = array();
        foreach ($services as $service) {
            $escaped_service = array();
            $escaped_service["serviceId"] = esc_js($service["serviceId"]);
            $escaped_service["serviceName"] = esc_js($service["serviceName"]);
            $escaped_service["regExPattern"] = esc_js($service["regExPattern"]);
            $escaped_service["regExPatternWithScript"] = esc_js($service["regExPatternWithScript"]);
            $escaped_services[] = $escaped_service;
        }
        return $escaped_services;
    }

    public function nsc_bara_buffer_set()
    {
        if (!class_exists('nsc_bar_frontend') || !class_exists("nsc_bar_banner_configs")) {
            return false;
        }

        if (ob_start(array($this, 'nsc_bara_clean_buffer'), 20480)) {
            $this->buffer_set = true;
        }
    }

    public function nsc_bara_buffer_flush()
    {
        if ($this->buffer_set) {
            ob_end_flush();
        }
    }

    public function nsc_bara_clean_buffer($buffer)
    {
        $blocked_services = $this->nsc_bara_get_blocked_services();
        foreach ($blocked_services as $blocked_service) {
            if (empty($blocked_service["regExPatternWithScript"])) {
                continue;
            }
            $buffer = preg_replace($blocked_service["regExPatternWithScript"], "", $buffer);
        }
        return $buffer;
    }

    public function nsc_bara_exclude_inline_scripts_from_caching($patterns)
    {
        $patterns[] = "nsc_bara_blocked_services";
        return $patterns;
    }

    public function nsc_bara_get_blocked_services()
    {

        if (!empty($this->blocked_services)) {
            return $this->blocked_services;
        }

        // get the user setting
        $user_consent = $this->get_user_consents();
        $allowed_categories = $this->get_allowed_categories($user_consent);

        // get the setting in wp admin: which scripts are allowed with which consent
        $admin_settings_blocked_ressources = json_decode(get_option("nsc_bar_blocked_services", "[]"), true);

        // get the general list of services and there block regex pattern
        $services_to_block_configs_builtin = nsc_bara_get_blocked_resourcen_config();
        $addOnConfigs = new nsc_bara_addon_configs;
        $services_to_block_configs_custom = $addOnConfigs->get_custom_services_from_db();
        $services_to_block_configs = array_merge($services_to_block_configs_builtin, $services_to_block_configs_custom);

        $this->blocked_services = array();

        foreach ($admin_settings_blocked_ressources as $admin_settings_blocked) {
            // get categories which are allowed. Values from dataLayer are taken, e.g. cookieconsent_status
            $allowed = array_intersect($allowed_categories, $admin_settings_blocked["allowedWithConsents"]);
            if (empty($allowed)) {
                $this->blocked_services[] = $this->add_blocking_regex_string_to_blocked_services($admin_settings_blocked, $services_to_block_configs);
            }
        }
        return $this->blocked_services;
    }

    public function nsc_bara_get_blocked_services_configured()
    {
        // get the setting in wp admin: which scripts are allowed with which consent
        $admin_settings_blocked_ressources = json_decode(get_option("nsc_bar_blocked_services", "[]"), true);

        // get the general list of services and there block regex pattern
        $services_to_block_configs_builtin = nsc_bara_get_blocked_resourcen_config();
        $addOnConfigs = new nsc_bara_addon_configs;
        $services_to_block_configs_custom = $addOnConfigs->get_custom_services_from_db();
        $services_to_block_configs = array_merge($services_to_block_configs_builtin, $services_to_block_configs_custom);

        $blocked_services_configured = array();

        foreach ($admin_settings_blocked_ressources as $admin_settings_blocked) {
            $blocked_services_configured[] = $this->add_blocking_regex_string_to_blocked_services($admin_settings_blocked, $services_to_block_configs);
        }
        return $blocked_services_configured;
    }

    private function add_blocking_regex_string_to_blocked_services($admin_settings_blocked, $services_to_block_configs)
    {
        // get categories which are allowed. Values from dataLayer are taken, e.g. cookieconsent_status
        $serviceId = $admin_settings_blocked["serviceId"];
        $patternWithScript = '/<[^<]*' . $services_to_block_configs[$serviceId]["regExPattern"] . '[^>]*>/';
        $patternWithScript = str_replace("|", "[^>]*>|<[^<]*", $patternWithScript);
        $services_to_block_configs[$serviceId]["regExPatternWithScript"] = $patternWithScript;
        return $services_to_block_configs[$serviceId];
    }

    public function nsc_bara_add_enqueueScriptOption($pluginConfigs)
    {
        $config_string_block_enqueu = json_decode('{
            "field_slug": "enqueueBlockingScripts",
            "type": "checkbox",
            "save_as": "string",
            "required": false,
            "extra_validation_name": false,
            "pre_selected_value": false,
            "helpertext": "Normally you should leave this unchecked. If you have problems with the blocking of scripts, you can activate this option. If activated the blocking scripts will be injected with the wp_enqueue_script function. When deactivated they are echoed, which is a bit faster, but more aggressive.",
            "name": "Enqueue Blocking Scripts",
            "save_in_db": true
          }');

        $config_string_block_apiCall = json_decode('{
            "field_slug": "blockedScriptsDynamicApiCall",
            "type": "checkbox",
            "save_as": "string",
            "required": false,
            "extra_validation_name": false,
            "pre_selected_value": false,
            "helpertext": "Normally you can leave this unchecked. If you have problems with caching, e.g. LiteSpeed plugin, activating this will solve it. When activated the blocking status will be retrieved asynchronous via an API call. If deactivated the blocking status will be echoed directly in the page. But if you cache the page, echoing is not working anymore.",
            "name": "Load blocking scripts via API",
            "save_in_db": true
          }');

        if (empty($config_string_block_enqueu)) {
            throw new Exception("Error: Could not create config for enqueueBlockingScripts JSON is INVALID!");
        }

        $tabsLength = count($pluginConfigs->setting_page_fields->tabs);
        for ($i = 0; $i < $tabsLength; $i++) {
            if ($pluginConfigs->setting_page_fields->tabs[$i]->tab_slug === "block_services") {
                $pluginConfigs->setting_page_fields->tabs[$i]->tabfields[] = $config_string_block_apiCall;
                $pluginConfigs->setting_page_fields->tabs[$i]->tabfields[] = $config_string_block_enqueu;
            }
        }
        return $pluginConfigs;
    }

    private function get_user_consents()
    {
        if (!empty($this->user_consent)) {
            return $this->user_consent;
        }
        if (class_exists("nsc_bar_banner_configs") && class_exists("nsc_bar_frontend")) {
            $nsc_bara_banner_config = new nsc_bar_banner_configs();
            $nsc_bara_frontend_banner = new nsc_bar_frontend();
            $nsc_bara_frontend_banner->nsc_bar_set_json_configs($nsc_bara_banner_config);
            $this->user_consent = $nsc_bara_frontend_banner->nsc_bar_get_dataLayer_banner_init_script(true);
            return $this->user_consent;
        }

        return array();
    }

    private function get_allowed_categories($user_consent)
    {
        $allowedCategories = array();
        foreach ($user_consent as $consent_cat => $value) {
            if ($value === "allow") {
                $allowedCategories[] = $consent_cat;
            }
        }
        return $allowedCategories;
    }
}
