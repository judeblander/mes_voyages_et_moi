<?php
if (!defined('ABSPATH')) {
    exit;
}

class nsc_bara_admin_settings_addon
{

    public function nsc_bara_get_additonal_tab_link()
    {
        $lang = new nsc_bara_languages;
        return "nsc_bara_language_selector=" . $lang->nsc_bara_get_current_language();
    }

    public function nsc_bara_get_addon_lang_description()
    {
        return "The default language is for all global settings and as fallback. Configure your banner first in default settings and then switch to a language for translation.";
    }

    public function nsc_bara_enqueue_script_on_admin_page($hook)
    {
        if ($hook == 'settings_page_nsc_bar-cookie-consent') {
            $banner_configs = new nsc_bara_banner_configs_addon;
            $consent_categories = $banner_configs->nsc_bara_get_cookie_consent_categories();
            wp_enqueue_script('nsc_bara_admin_iframeresizerjs', NSC_BARA_PLUGIN_URL . 'admin/js/iframeResizer/iframeResizer.min.js', array(), NSC_BARA_PLUGIN_VERSION, true);

            wp_register_script('nsc_bara_admin_js', NSC_BARA_PLUGIN_URL . 'admin/js/admin.v2.min.js', array(), NSC_BARA_PLUGIN_VERSION);
            wp_localize_script('nsc_bara_admin_js', 'php_vars', array(
                'restURL' => get_rest_url(),
                'nonce' => wp_create_nonce('wp_rest'),
            ));
            wp_enqueue_script('nsc_bara_admin_js');

            wp_enqueue_style('nsc_bara_admin_styles', NSC_BARA_PLUGIN_URL . 'admin/styles/nsc_bara_admin.css', array(), NSC_BARA_PLUGIN_VERSION);

            $builtInServices = array_values(nsc_bara_get_blocked_resourcen_config());
            $addOnConfigs = new nsc_bara_addon_configs;
            $customServices = array_values($addOnConfigs->get_custom_services_from_db());
            $servicesJson = json_encode(array_merge($builtInServices, $customServices));

            $inlineScript = "var nsc_bara_available_consent_categories = " . json_encode($consent_categories) . "; var nsc_bara_services_list = $servicesJson;";
            wp_add_inline_script('nsc_bara_admin_js', $inlineScript, "before");
        }
    }
}
