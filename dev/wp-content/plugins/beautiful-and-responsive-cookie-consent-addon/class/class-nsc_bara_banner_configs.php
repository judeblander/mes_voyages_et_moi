<?php
if (!defined('ABSPATH')) {
    exit;
}

class nsc_bara_banner_configs_addon
{
    private $banner_config_array;
    private $banner_config_string;
    private $plugin_configs;
    private $current_language;

    private function get_current_language()
    {
        if (!empty($this->current_language)) {
            return $this->current_language;
        }
        $language = new nsc_bara_languages;
        $this->current_language = $language->nsc_bara_get_current_language();
        return $this->current_language;
    }

    public function nsc_bara_get_banner_settings_slug($addon_settings)
    {
        $current_lang = $this->get_current_language();
        if (!empty($addon_settings["lang"])) {
            $current_lang = $addon_settings["lang"];
        }

        $bannerSettingsOptionsString = "bannersettings_json";
        if (empty($current_lang) === false && $current_lang !== "xx") {
            $bannerSettingsOptionsString .= "_" . $current_lang;
        }
        return $bannerSettingsOptionsString;
    }

    public function nsc_bara_get_cookie_consent_categories()
    {
        if (!class_exists('nsc_bar_banner_configs')) {
            return;
        }

        $nsc_bara_banner_config = new nsc_bar_banner_configs();

        $consentType = $nsc_bara_banner_config->nsc_bar_get_cookie_setting("type", "");
        $consent_categories = array();

        if ($consentType === "opt-in" || $consentType === "opt-out") {
            $consent_categories[] = array("nameId" => "cookieconsent_status", "name" => "Allow after consent");
        }

        if ($consentType === "detailedRev" || $consentType === "detailedRevDeny" || $consentType === "detailed") {
            $availableConsentCategories = $nsc_bara_banner_config->nsc_bar_get_cookie_setting("cookietypes", "");
            foreach ($availableConsentCategories as $consent_category) {
                $consent_categories[] = array("nameId" => "cookieconsent_status_" . $consent_category["cookie_suffix"], "name" => $consent_category["label"]);
            }
        }

        // "info","detailed","detailedRev","opt-in","opt-out"

        return $consent_categories;
    }

    public function nsc_bara_add_stats_url_to_config_string($banner_configs_string)
    {
        $restUrl = get_rest_url();
        $banner_configs_array = json_decode($banner_configs_string, true);
        $banner_configs_array['statsUrl'] = $restUrl . "beautiful-and-responsive-cookie-consent/v1/stats";
        if (get_option("nsc_bar_send_open_event", "0") === "1") {
            $banner_configs_array['statsSendOnOpen'] = "true";
        }
        if (get_option("nsc_bar_enable_open_counter", "0") === "1") {
            $banner_configs_array['statsCountOpens'] = "true";
        }

        return json_encode($banner_configs_array);
    }

    public function nsc_bara_add_show_delay_to_banner($bannerInitString)
    {
        if (!class_exists('nsc_bar_banner_configs')) {
            return $bannerInitString;
        }
        $nsc_bara_banner_config = new nsc_bar_banner_configs();
        $delay = $nsc_bara_banner_config->nsc_bar_get_cookie_setting("delayBannerShow", "");
        if (empty($delay)) {
            return $bannerInitString;
        }

        $bannerInitString = "function() { setTimeout(" . $bannerInitString . "," . esc_attr($delay) . ")}";
        return $bannerInitString;
    }

}
