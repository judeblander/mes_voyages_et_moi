<?php
if (!defined('ABSPATH')) {
    exit;
}

class nsc_bara_save_form_fields_addon
{

    private $language;

    public function __construct()
    {
        $this->language = new nsc_bara_languages;
    }

    // retrieves langueage configs from database will be overrided if nsc_bara_save_field_with_data_from_post === true with current post from lang xx
    //if nsc_bara_save_field_with_data_from_post === false, it will just write the json file without overridevalues with posted ones
    public function nsc_bara_get_all_languages_configs($default_language_configs)
    {
        $available_languages = $this->language->nsc_bara_get_available_languages();
        $language_configs = [];
        $banner_configs_addon = new nsc_bara_banner_configs_addon;
        foreach ($available_languages as $available_language) {
            $banner_configs_slug = $banner_configs_addon->nsc_bara_get_banner_settings_slug(array("lang" => $available_language["language_code"]));
            $language_configs[$available_language["language_code"]] = $this->get_language_config_with_default_cookietype_settings($banner_configs_slug, $default_language_configs);
        }

        return $language_configs;
    }

    public function nsc_bara_must_i_save_other_languages($updated)
    {
        $current_language = $this->language->nsc_bara_get_current_language();
        if ($current_language === "xx" && $updated === true) {
            return true;
        }
        return false;
    }

    public function nsc_bara_get_addon_settings($mode, $lang)
    {
        $settings = array();
        $settings['lang'] = $lang;
        $settings['mode'] = "only_translatable";

        if ($mode === "override") {
            $settings['mode'] = "only_non_translatable";
        }
        return $settings;
    }

    private function get_cookietype_configs($language_configs)
    {
        if (!class_exists("nsc_bar_banner_configs")) {
            return array();
        }

        $banner_configs_obj = new nsc_bar_banner_configs();
        $banner_configs_obj->nsc_bar_set_banner_config_array($language_configs);
        $cookie_types = $banner_configs_obj->nsc_bar_get_cookie_setting("cookietypes", null);
        if (empty($cookie_types)) {
            return array();
        }
        if (is_array($cookie_types) === false) {
            return array();
        }
        if ($this->has_string_keys($cookie_types) === true) {
            return array();
        }

        if (empty($cookie_types[0])) {
            return array();
        }

        return $cookie_types;
    }

    // cookietypes: translatable=true. Aber eigentlich soll nur das Label übersetzt werden. Das heißt beim speichern von der xx Sprache müssen wir für jede Sprache manuell die
    // Werte aus dem default objekt holen und damit die sprache objekte überschreiben. Ausser für das label, welches übersetzt werden soll.
    // theoretisch kann so, wenn man im FE disabled aushebelt andere configs für die sprachen setzten, die dann aber bei jedem speicher des default wieder mit den defaults überschrieben
    // werden.
    // $default_language_configs_after_save: the new configs already.

    private function get_language_config_with_default_cookietype_settings($banner_configs_slug, $default_language_configs_after_save)
    {

        if (!class_exists("nsc_bar_banner_configs")) {
            return array();
        }

        $banner_configs_obj = new nsc_bar_banner_configs();
        $banner_configs_obj->nsc_bar_set_banner_configs_slug($banner_configs_slug);
        $language_configs = $banner_configs_obj->nsc_bar_get_banner_config_array();

        $language_cookietypes = $this->get_cookietype_configs($language_configs);
        $default_cookietypes = $this->get_cookietype_configs($default_language_configs_after_save);

        if (count($language_cookietypes) > count($default_cookietypes)) {
            foreach ($language_cookietypes as $key => $language_cookietype_config) {
                $cookie_suffix_found_in_default = false;
                foreach ($default_cookietypes as $default_cc) {
                    if ($default_cc["cookie_suffix"] === $language_cookietype_config["cookie_suffix"]) {
                        $cookie_suffix_found_in_default = true;
                        break;
                    }
                }
                if ($cookie_suffix_found_in_default === false) {
                    unset($language_cookietypes[$key]);
                }
            }
        }

        $language_cookietypes = array_values($language_cookietypes);

        foreach ($default_cookietypes as $key => $default_cookietype_config) {
            if (empty($language_cookietypes[$key])) {
                $language_cookietypes[] = $default_cookietype_config;
                continue;
            }
            $language_cookietypes[$key]["checked"] = $default_cookietype_config["checked"];
            $language_cookietypes[$key]["disabled"] = $default_cookietype_config["disabled"];
            $language_cookietypes[$key]["cookie_suffix"] = $default_cookietype_config["cookie_suffix"];
        }

        $banner_configs_obj->nsc_bar_update_banner_setting("cookietypes", json_encode($language_cookietypes), "array");
        return $banner_configs_obj->nsc_bar_get_banner_config_array();
    }

    // it only determines if a field is overwritten by a posted value.
    // If you manipulate the settings object before your manipulation are save to DB as well. Because always the whole config obhejt is stored.
    public function nsc_bara_save_field_with_data_from_post($tabfield, $addon_settings)
    {
        if (!isset($tabfield->translatable)) {
            throw new Exception("translatable not set for " . $tabfield->field_slug . " !!!");
        }

        $lang = "xx";
        if (empty($addon_settings["lang"]) === false) {
            $lang = $addon_settings["lang"];
        }

        $mode = "only_translatable";
        if (empty($addon_settings["mode"]) === false) {
            $mode = $addon_settings["mode"];
        }

        if ($lang === "xx") {
            return true;
        }

        if ($mode === "only_translatable" && $tabfield->translatable == true) {
            return true;
        }

        if ($mode === "only_non_translatable" && $tabfield->translatable == false) {
            return true;
        }

        return false;
    }

    private function has_string_keys($array)
    {
        return count(array_filter($array, 'is_string', ARRAY_FILTER_USE_KEY)) > 0;
    }

}
