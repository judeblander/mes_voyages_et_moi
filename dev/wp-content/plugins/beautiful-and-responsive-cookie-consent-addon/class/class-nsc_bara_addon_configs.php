<?php
if (!defined('ABSPATH')) {
    exit;
}

class nsc_bara_addon_configs
{
    private $settings_as_object;
    private $active_tab;
    private $language;
    private $current_language;

    public function nsc_bara_add_addon_settings($parent_settings)
    {
        if (empty($this->current_language)) {
            $this->language = new nsc_bara_languages;
            $this->current_language = $this->language->nsc_bara_get_current_language();
        }

        $this->nsc_bara_get_settings_as_object();
        $new_tabs = [];

        foreach ($parent_settings->setting_page_fields->tabs as $parent_key => $parent_tab) {
            // is a placeholder in parent menu, so must be removed here.
            if ($parent_tab->tab_slug !== "statistics") {
                $parent_tab->tabfields = $this->add_addon_fields_to_all_fields($parent_tab->tabfields);
                if ($parent_tab->tab_description === "premium_addon_desc.html") {
                    $parent_tab->tab_description = "";
                }
                $new_tabs[] = $parent_tab;
            }
            foreach ($this->settings_as_object->tabs as $key => $addon_tab) {
                if (isset($addon_tab->position) && $parent_key === $addon_tab->position) {
                    unset($addon_tab->position);
                    $new_tabs[] = $addon_tab;
                }
            }
        }
        $parent_settings->setting_page_fields->tabs = $new_tabs;

        $parent_settings->settings_page_configs->capability = get_option("nsc_bar_capabilityCustom", "manage_options");

        return $parent_settings;
    }

    public function nsc_bara_return_plugin_upload_base_dir()
    {
        global $wp_filesystem;

        if (empty($wp_filesystem)) {
            require_once ABSPATH . '/wp-admin/includes/file.php';
            WP_Filesystem();
        }

        $base_dir = $wp_filesystem->wp_content_dir() . 'nsc-bara-beautiful-cookie-banner-addon-files';
        if (!$wp_filesystem->exists($base_dir)) {
            $wp_filesystem->mkdir($base_dir);
        }
        return $base_dir;
    }

    public function nsc_bara_store_file($array_sub_dirs, $file_name, $content, $htaccessProtection)
    {

        $storage_dir = $this->nsc_bara_return_plugin_upload_base_dir();

        global $wp_filesystem;
        foreach ($array_sub_dirs as $sub_dir) {
            $storage_dir .= "/" . $sub_dir;
            if (!$wp_filesystem->exists($storage_dir)) {
                $wp_filesystem->mkdir($storage_dir);
            }
            if (!$wp_filesystem->is_writable($storage_dir)) {
                return false;
            }

            if ($htaccessProtection) {
                $htaccess = $storage_dir . '/.htaccess';
                if (!$wp_filesystem->exists($htaccess)) {
                    if (!$wp_filesystem->put_contents($htaccess, 'Deny from all', FS_CHMOD_FILE)) {
                        return false;
                    }
                }
            }
        }
        $targetFile = $storage_dir . "/" . $file_name;
        file_put_contents($targetFile, $content . "\n", FILE_APPEND);
        chmod($targetFile, 0640);
        return true;
    }

    public function nsc_bara_check_for_needed_classes()
    {
        $needed_classes = array("nsc_bar_banner_configs", "nsc_bar_plugin_configs", "nsc_bar_save_form_fields", "nsc_bar_frontend");
        $all_needed_available = true;
        foreach ($needed_classes as $needed_class) {
            if (class_exists($needed_class) === false) {
                $all_needed_available = false;
                break;
            }
        }

        if ($all_needed_available === false) {
            $admin_error_obj = new nsc_bara_admin_error;
            $admin_error_obj->nsc_bara_set_admin_error("'Beautiful and responsive cookie consent - premium add-on' requires the free 'Beautiful and responsive cookie consent' plugin to be installed. Please install it from the wordpress plugin directory.");
            $admin_error_obj->nsc_bara_display_errors();
        }

    }

    public function nsc_bara_check_for_valid_license_key()
    {
        $infos = get_transient(NSC_BARA_UPDATE_TRANSIENT_NAME);
        if (empty($infos) || empty($infos->global_wp_message)) {
            return true;
        }
        $admin_error_obj = new nsc_bara_admin_error;
        $admin_error_obj->nsc_bara_set_admin_error($infos->global_wp_message);
        $admin_error_obj->nsc_bara_display_errors();
    }

    public function get_custom_services_from_db()
    {
        $custom_services_string = get_option("nsc_bar_custom_services", '{}');

        return json_decode($custom_services_string, true);
    }

    public function nsc_bara_remove_custom_service($settings)
    {
        for ($i = 0; $i < count($settings->setting_page_fields->tabs); $i++) {
            if ($settings->setting_page_fields->tabs[$i]->tab_slug === "block_services") {
                $tabfields = $settings->setting_page_fields->tabs[$i]->tabfields;
                $indexToRemove = -1;
                for ($x = 0; $x < count($tabfields); $x++) {
                    if ($tabfields[$x]->field_slug === "custom_services") {
                        $indexToRemove = $x;
                    }
                }
                if ($indexToRemove > -1) {
                    array_splice($settings->setting_page_fields->tabs[$i]->tabfields, $indexToRemove, 1);
                }
                break;
            }
        }
        return $settings;
    }

    private function add_addon_fields_to_all_fields($tabfields)
    {
        $new_tabfields = [];
        foreach ($tabfields as $mainkey => $field) {

            $newField = (object) array_merge((array) $field, (array) $this->settings_as_object->additional_fields->default);
            foreach ($this->settings_as_object->additional_fields->override_default_fields as $addon_field) {
                if ($addon_field->field_slug === $field->field_slug) {
                    $newField = (object) array_merge((array) $newField, (array) $addon_field->fields);
                }
            }
            if ($this->current_language !== "xx" && $newField->translatable == true && $newField->save_in_db == true) {
                $newField->field_slug = $newField->field_slug . "_" . $this->current_language;
            }
            $new_tabfields[] = $newField;
        }
        return $new_tabfields;
    }

    public function nsc_bara_get_settings_as_object()
    {
        if (!empty($this->settings_as_object)) {
            return $this->settings_as_object;
        }

        $settings = file_get_contents(NSC_BARA_PLUGIN_DIR . "/addon-plugin-configs.json");
        $settings = $this->replace_variables_in_string("PLUGIN_URL", NSC_BARA_PLUGIN_URL, $settings);
        $settings = $this->replace_variables_in_string("PLUGIN_URL_ENCODED", urlencode(NSC_BARA_PLUGIN_URL), $settings);
        $settings = json_decode($settings);
        if (empty($settings)) {
            throw new Exception($this->settingsFile . " was not readable. Make sure it contains valid json.");
        }
        $this->settings_as_object = $settings;
        return $settings;
    }

    private function replace_variables_in_string($varname, $replace_value, $string)
    {
        $string = str_replace("{{" . $varname . "}}", $replace_value, $string);
        return $string;
    }

    public function nsc_bara_deactivated()
    {
        $bannerConfigs = new nsc_bar_banner_configs;
        $bannerConfigs->nsc_bar_update_banner_setting("activateConsentMode", false, "boolean");
        $bannerConfigs->nsc_bar_update_banner_setting("revokeBtnType", "textOnly", "string");
        $bannerConfigs->nsc_bar_update_banner_setting("animateRevokable", true, "boolean");
        $bannerConfigs->nsc_bar_update_banner_setting("closeXClickStatus", "default", "string");
        $bannerConfigs->nsc_bar_update_banner_setting("buttonOrderAllowFirst", true, "boolean");
        $bannerConfigs->nsc_bar_save_banner_settings();
    }
}
