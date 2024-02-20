<?php
if (!defined('ABSPATH')) {
    exit;
}

class nsc_bara_rest_api
{

    public function nsc_bara_register_endpoints()
    {

        register_rest_route('beautiful-and-responsive-cookie-consent/v1', '/stats', array(
            'methods' => 'POST',
            'callback' => array($this, "nsc_bara_stats_endpoint"),
            'permission_callback' => '__return_true',
        ));

        register_rest_route('beautiful-and-responsive-cookie-consent/v1', '/customServices', array(
            'methods' => 'POST',
            'callback' => array($this, "nsc_bara_save_custom_services"),
            'permission_callback' => array($this, "nsc_bara_check_admin_permissions"),
        ));

        register_rest_route('beautiful-and-responsive-cookie-consent/v1', '/customServices', array(
            'methods' => 'GET',
            'callback' => array($this, "nsc_bara_get_custom_services"),
            'permission_callback' => array($this, "nsc_bara_check_admin_permissions"),
        ));

        register_rest_route('beautiful-and-responsive-cookie-consent/v1', '/settings', array(
            'methods' => 'GET',
            'callback' => array($this, "nsc_bara_get_settings"),
            'permission_callback' => array($this, "nsc_bara_check_admin_permissions"),
        ));

        register_rest_route('beautiful-and-responsive-cookie-consent/v1', '/settings', array(
            'methods' => 'POST',
            'callback' => array($this, "nsc_bara_update_settings"),
            'permission_callback' => array($this, "nsc_bara_check_admin_permissions"),
        ));

        if (get_option("nsc_bar_activate_service_blocking", "0") === "1") {
            $blocker = new nsc_bara_tracking_blocker;
            register_rest_route('beautiful-and-responsive-cookie-consent/v1', '/blockedServices', array(
                'methods' => 'GET',
                'callback' => array($blocker, "nsc_bara_get_blocked_services"),
                'permission_callback' => '__return_true',
            ));
        }
    }

    public function nsc_bara_stats_endpoint(WP_REST_Request $request)
    {
        $body = $request->get_json_params();
        $stats = new nsc_bara_stats;
        $stats->nsc_bara_save_stats($body);
    }

    public function nsc_bara_save_custom_services(WP_REST_Request $request)
    {
        $neededCapability = get_option("nsc_bar_capabilityCustom", "manage_options");
        if (current_user_can($neededCapability) === false) {
            return;
        }
        $sanitized_data = $this->sanitize_custom_services($request->get_json_params());
        update_option("nsc_bar_custom_services", json_encode($sanitized_data));
    }

    public function nsc_bara_get_settings(WP_REST_Request $request)
    {
        $neededCapability = get_option("nsc_bar_capabilityCustom", "manage_options");
        if (current_user_can($neededCapability) === false) {
            return;
        }

        $export_settings = new nsc_bara_settings_export;
        return $export_settings->nsc_bara_get_settings();
    }

    public function nsc_bara_update_settings(WP_REST_Request $request)
    {
        $neededCapability = get_option("nsc_bar_capabilityCustom", "manage_options");
        if (current_user_can($neededCapability) === false) {
            return;
        }
        $settingsToUpdate = $request->get_json_params();

        $export_settings = new nsc_bara_settings_export;
        $responseBody = $export_settings->nsc_bara_update_settings($settingsToUpdate);

        // Add your custom data to the response
        $response = rest_ensure_response($responseBody);
        $response->set_status(200);
        $response->header('Content-Type', 'application/json');
        return $response;
    }

    public function nsc_bara_get_custom_services(WP_REST_Request $request)
    {
        $addOnConfigs = new nsc_bara_addon_configs;
        return $addOnConfigs->get_custom_services_from_db();
    }

    public function nsc_bara_check_admin_permissions()
    {
        $neededCapability = get_option("nsc_bar_capabilityCustom", "manage_options");
        return current_user_can($neededCapability);
    }

    private function sanitize_custom_services($custom_services_array)
    {
        $sanitized_data = array();

        foreach ($custom_services_array as $serviceId => $serviceData) {
            if (isset($serviceData["serviceName"]) && is_string($serviceData["serviceName"]) &&
                isset($serviceData["regExPattern"]) && is_string($serviceData["regExPattern"]) &&
                isset($serviceData["type"]) && is_string($serviceData["type"])) {
                $sanitized_data[sanitize_text_field($serviceId)] = array(
                    "serviceName" => sanitize_text_field($serviceData["serviceName"]),
                    "regExPattern" => sanitize_text_field($serviceData["regExPattern"]),
                    "type" => sanitize_text_field($serviceData["type"]),
                    "serviceId" => sanitize_text_field($serviceId),
                );
            }
        }

        return $sanitized_data;
    }
}
