<?php
if (!defined('ABSPATH')) {
    exit;
}

class nsc_bara_input_validation
{
    private $admin_error_obj;

    public function __construct()
    {
        $this->admin_error_obj = new nsc_bara_admin_error;
    }

    public function nsc_bara_validate_field_custom_save($return, $extra_validation_value)
    {
        switch ($extra_validation_value) {
            case "nsc_bara_check_license_key":
                $return = $this->nsc_bara_check_license_key($return);
                break;
            case "nsc_bara_check_file_system_access":
                $return = $this->nsc_bara_check_file_system_access($return);
                break;
            case "nsc_bara_validate_block_list":
                $return = $this->nsc_bara_validate_block_list($return);
                break;
            case "nsc_bara_capabilityCustom":
                $return = $this->nsc_bara_capabilityCustom($return);
                break;
            case "nsc_bar_check_json_blocked_services":
                $return = $this->nsc_bar_check_json_blocked_services($return);
                break;
            case "nsc_bara_gtm_id":
                $return = $this->nsc_bara_gtm_id($return);
                break;
            case "nsc_bara_hostname":
                $return = $this->nsc_bara_hostname($return);
                break;
            case "nsc_bara_url":
                $return = $this->nsc_bara_url($return);
                break;
        }
        $this->admin_error_obj->nsc_bara_display_errors();
        return $return;
    }

    public function nsc_bara_hostname($hostname)
    {
        $hostname = sanitize_text_field($hostname);
        if (preg_match("/^[a-zA-Z0-9ßäöüÄÜÖ\-\.]+$/", $hostname) === 0) {
            $this->admin_error_obj->nsc_bara_set_admin_error("The hostname '" . esc_html($hostname) . "' is invalid. Falling back to default hostname.");
            return "www.googletagmanager.com";
        }
        return $hostname;
    }

    public function nsc_bara_url($url)
    {
        $url = sanitize_text_field($url);
        if (empty($url)) {
            return $url;
        }

        if (preg_match("/^[\wÄÜÖäöüß\-_\.\+\*\#\%\/\?\:@\&=]+$/", $url) === 0) {
            $this->admin_error_obj->nsc_bara_set_admin_error("The url '" . esc_html($url) . "' is invalid.");
            return null;
        }
        return $url;
    }

    public function nsc_bara_gtm_id($gtm_id)
    {
        $gtm_id = trim($gtm_id);
        if (empty($gtm_id)) {
            return "";
        }
        $gtm_id = sanitize_text_field($gtm_id);
        if (preg_match("/^GTM-[A-Z0-9]+$/", $gtm_id) === 0) {
            $this->admin_error_obj->nsc_bara_set_admin_error("The Google Tag Manager ID is invalid. This is how a valid would look like: GTM-23SDFG");
            return null;
        }
        return $gtm_id;
    }

    public function nsc_bar_check_json_blocked_services($json_string)
    {
        if ($json_string === "[]") {
            return $json_string;
        }

        $data = json_decode($json_string, true);
        if (empty($data)) {
            return null;
        }
        $sanitized_data = array();

        foreach ($data as $service) {
            if (isset($service["allowedWithConsents"]) && is_array($service["allowedWithConsents"]) &&
                isset($service["serviceId"]) && is_string($service["serviceId"])) {
                $sanitized_data[] = array(
                    "allowedWithConsents" => array_map('sanitize_text_field', $service["allowedWithConsents"]),
                    "serviceId" => sanitize_text_field($service["serviceId"]),
                );
            }
        }

        return json_encode($sanitized_data);

    }

    public function nsc_bara_custom_services($json_string)
    {
        $custom_services = json_decode($json_string, true);
        $customServiceIds = [];
        $custom_services_to_return = [];
        foreach ($custom_services as $key => $custom_service) {
            if (empty($custom_service["serviceName"]) || empty($custom_service["regExPattern"])) {
                continue;
            }
            if (empty($custom_service["type"]) || !in_array($custom_service["type"], array("Custom"))) {
                continue;
            }

            if (empty($custom_service["serviceId"])) {
                $custom_service["serviceId"] = "cust" . preg_replace("/[^A-Za-z0-9]/", '', $custom_service["serviceName"]);
            }

            if (in_array($custom_service["serviceId"], $customServiceIds)) {
                $this->admin_error_obj->nsc_bara_set_admin_error("Service could not be saved. Another one with a similiar name exist already. Input Name: " . $custom_service["serviceName"]);
                continue;
            }
            $custom_services_to_return[$key] = $custom_service;
        }
        $this->admin_error_obj->nsc_bara_display_errors();
        return json_encode($custom_services_to_return);
    }

    // to make this work parent plugin must be > 2.6.4
    public function nsc_bara_check_license_key($licenseKey)
    {
        delete_transient(NSC_BARA_UPDATE_TRANSIENT_NAME);
        return $licenseKey;
    }

    public function nsc_bara_check_file_system_access($enable_logging)
    {
        if (get_filesystem_method() !== 'direct') {
            $this->admin_error_obj->nsc_bara_set_admin_error("Storing consent data in a local log only works, if there a a direct access to the file system.");
            return "0";
        }
        return $enable_logging;
    }

    public function nsc_bara_validate_block_list($string)
    {
        if ($string === "") {
            return "[]";
        }
        $list = explode(",", $string);
        $trimmedList = array();
        foreach ($list as $url) {
            $trimmedList[] = trim($url);
        }
        $trimmedList = json_encode($trimmedList);
        return $trimmedList;
    }

    public function nsc_bara_capabilityCustom($string)
    {
        if (current_user_can($string) === false) {
            $this->admin_error_obj->nsc_bara_set_admin_error("Please choose a capability your current role has. Otherwise you will lock yourself out, from this setting page. You chose: " . esc_attr($string));

            $oldCapability = get_option("nsc_bar_capabilityCustom", "manage_options");
            return $oldCapability;
        }
        return $string;
    }

    public function nsc_bara_esc_array_for_js($array_to_escape)
    {
        $escapedArray = array();
        foreach ($array_to_escape as $key => $value) {
            $escKey = esc_js($key);
            if (!is_array($value)) {
                $escValue = esc_js($value);
                $escapedArray[$escKey] = $escValue;
            }

            if (is_array($value)) {
                foreach ($value as $key_of_v => $value_of_v) {
                    $escKey_v = esc_js($key_of_v);
                    $escValue_v = esc_js($value_of_v);
                    $escapedArray[$escKey][$escKey_v] = $escValue_v;
                }
            }
        }
        return $escapedArray;
    }

}
