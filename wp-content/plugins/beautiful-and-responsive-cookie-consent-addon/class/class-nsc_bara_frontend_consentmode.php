<?php
if (!defined('ABSPATH')) {
    exit;
}

class nsc_bara_frontend_consentmode
{
    public function nsc_bara_enqueue_consentmode_default_script()
    {

        $banner_active = get_option("nsc_bar_activate_banner", false);
        $banner_active = apply_filters('nsc_bar_filter_banner_is_active', $banner_active);
        if ($banner_active != true) {
            return;
        }

        if (!class_exists("nsc_bar_banner_configs") || !class_exists("nsc_bar_frontend")) {
            return;
        }

        $bannerConfigs = new nsc_bar_banner_configs;
        $bannerArray = $bannerConfigs->nsc_bar_get_banner_config_array();
        if (empty($bannerArray['activateConsentMode'])) {
            $bannerArray['activateConsentMode'] = false;
        }

        $bannerArray['activateConsentMode'] = apply_filters('nsc_bara_filter_consent_mode_is_active', $bannerArray['activateConsentMode']);
        if ($bannerArray['activateConsentMode'] != true) {
            return;
        }

        $consentModeConfigs = array();
        if (!empty($bannerArray['consentModeConfig'])) {
            $consentModeConfigs = $bannerArray['consentModeConfig'];
        }

        $type = $bannerArray['type'];

        $gtagValue = array();

        // defaults
        $gtagValue["analytics_storage"] = array();
        $gtagValue["analytics_storage"]["default"] = "denied";

        $gtagValue["ad_storage"] = array();
        $gtagValue["ad_storage"]["default"] = "denied";

        $gtagValue["ad_personalization"] = array();
        $gtagValue["ad_personalization"]["default"] = "denied";

        $gtagValue["ad_user_data"] = array();
        $gtagValue["ad_user_data"]["default"] = "denied";

        $gtagValue["functionality_storage"] = array();
        $gtagValue["functionality_storage"]["default"] = "denied";

        $gtagValue["personalization_storage"] = array();
        $gtagValue["personalization_storage"]["default"] = "denied";

        $gtagValue["security_storage"] = array();
        $gtagValue["security_storage"]["default"] = "denied";

        $nsc_bar_frontend_banner = new nsc_bar_frontend();
        $cookies = $nsc_bar_frontend_banner->nsc_bar_get_dataLayer_banner_init_script("raw");

        foreach ($consentModeConfigs as $coMoCat => $optionsForGranted) {
            $allowedSettingsArray = $this->isGranted($optionsForGranted, $type, $cookies);
            $gtagValue[$coMoCat] = $allowedSettingsArray;
        }

        if (intval($bannerArray['consentModeWaitForUpdate'], 10) > 0) {
            $gtagValue["wait_for_update"] = intval($bannerArray['consentModeWaitForUpdate']);
        }

        $additionalComoSettings = array();
        $additionalComoSettings["ads_data_redaction"] = $bannerArray['coMoAdsDataRedaction'];
        $additionalComoSettings["url_passthrough"] = $bannerArray['coMoUrlPassThrough'];

        $dataLayerName = "dataLayer";
        if (!empty($bannerArray['dataLayerName'])) {
            $dataLayerName = $bannerArray['dataLayerName'];
        }

        $this->nsc_bara_echo_consentmode_script($gtagValue, $type, $additionalComoSettings, $dataLayerName);
    }

    private function isGranted($optionsForGranted, $type, $cookies)
    {

        $updated = false;
        if (empty($cookies["cookieconsent_status"]["value"]) === false) {
            $updated = true;
        }

        $grantedValues["default"] = "denied";
        if ($updated) {
            $grantedValues["update"] = "denied";
        }

        if (empty($optionsForGranted)) {
            return $grantedValues;
        }

        $cookieconsent_status_value = $cookies["cookieconsent_status"]["defaultValue"] === "dismiss" ? "allow" : $cookies["cookieconsent_status"]["defaultValue"];

        if (in_array($type, array("detailed", "detailedRev", "detailedRevDeny")) === false) {
            $grantedValues["default"] = in_array($this->dismissToAllow($cookies["cookieconsent_status"]["defaultValue"]), $optionsForGranted) ? "granted" : "denied";

            if ($updated) {
                $grantedValues["update"] = in_array($this->dismissToAllow($cookies["cookieconsent_status"]["value"]), $optionsForGranted) ? "granted" : "denied";
            }

            return $grantedValues;
        }

        foreach ($cookies as $dlKey => $dlValue) {
            foreach ($optionsForGranted as $option) {
                if (preg_match("/_" . $option . "$/", $dlKey) != false) {
                    $grantedValues["default"] = $dlValue["defaultValue"] === "allow" ? "granted" : "denied";
                    if ($updated) {
                        $grantedValues["update"] = $dlValue["value"] === "allow" ? "granted" : "denied";
                    }
                    return $grantedValues;
                }
            }
        }

        return $grantedValues;
    }

    private function dismissToAllow($cookieconsent_status_value)
    {
        $migratedValue = $cookieconsent_status_value === "dismiss" ? "allow" : $cookieconsent_status_value;
        return $migratedValue;
    }

    private function nsc_bara_echo_consentmode_script($gtagValue, $type, $additionalComoSettings, $dataLayerName)
    {

        $additionalSettingsString = '';

        foreach ($additionalComoSettings as $setting => $settingValue) {
            if (empty($settingValue)) {
                continue;
            }

            if ($settingValue == true) {
                $settingValue = true;
            }

            $additionalSettingsString .= 'gtag("set", "' . esc_js($setting) . '", ' . esc_js($settingValue) . ');';
        }

        $defaultGtags = $this->getGtagArrayByMethod("default", $gtagValue);

        $validator = new nsc_bara_input_validation();
        $cleanedGtagValuesDefault = $validator->nsc_bara_esc_array_for_js($defaultGtags);

        $updatedGtags = $this->getGtagArrayByMethod("update", $gtagValue);
        if (empty($updatedGtags) === false) {
            $cleanedGtagValuesUpdate = $validator->nsc_bara_esc_array_for_js($updatedGtags);
        }

        $dataLayerName = esc_js($dataLayerName);
        echo '<script id="nsc_bara_consent_mode_default_script" data-pagespeed-no-defer data-cfasync nowprocket data-no-optimize="1" data-no-defer="1" type="text/javascript">
        window["' . $dataLayerName . '"] = window["' . $dataLayerName . '"] || [];
        function gtag() {
            window["' . $dataLayerName . '"].push(arguments);
        }
        gtag("consent", "default", ' . json_encode($cleanedGtagValuesDefault) . ');
        ' . $additionalSettingsString . '
        window["' . $dataLayerName . '"].push({event:"consent_mode_default", "consentType": "' . esc_js($type) . '"});';

        if (empty($cleanedGtagValuesUpdate) === false) {
            echo 'gtag("consent", "update", ' . json_encode($cleanedGtagValuesUpdate) . '); window["' . $dataLayerName . '"].push({event:"consent_mode_update", "consentType": "' . esc_js($type) . '"});';
        }
        echo '</script>';
    }

    private function getGtagArrayByMethod($type, $gtagValue)
    {
        $gtagArray = array();
        foreach ($gtagValue as $comoCat => $consentSettings) {
            if (empty($consentSettings[$type]) === false) {
                $gtagArray[$comoCat] = $consentSettings[$type];
            }
        }
        return $gtagArray;
    }
}
