<?php
if (!defined('ABSPATH')) {
    exit;
}

class nsc_bara_stats
{
    public function nsc_bara_save_stats($stats_array)
    {
        $stats_array = $this->sanitize_stats_string($stats_array);
        $this->store_log_files($stats_array);
        $this->sent_hit_to_ga($stats_array);
    }

    private function sent_hit_to_ga($stats_array)
    {
        $measurement_id = get_option("nsc_bar_ga_measurement_id_stats", '');
        $api_secret = get_option("nsc_bar_ga_api_secret_stats", '');
        if (empty($measurement_id) || empty($api_secret)) {
            return;
        }

        $query_params = array(
            'api_secret' => $api_secret,
            'measurement_id' => $measurement_id,
            'dr' => sanitize_text_field($stats_array["referrer"]),
        );

        $query_str = http_build_query($query_params);
        $paramsArray = array();
        $cookieConsentString = "";
        foreach ($stats_array['cookieTypeConsent'] as $cookieType) {
            $paramsArray[$cookieType['name']] = sanitize_text_field($cookieType['status']);
            $cookieConsentString .= sanitize_text_field($cookieType['name']) . " -> " . sanitize_text_field($cookieType['status']) . ", ";
        }

        $titleString = sanitize_text_field($stats_array["mainStatus"]);
        if (!empty($cookieConsentString)) {
            $titleString .= ": " . $cookieConsentString;
        }
        $paramsArray["page_location"] = sanitize_text_field($stats_array["href"]);
        $paramsArray["page_title"] = $titleString;
        $paramsArray["page_referrer"] = sanitize_text_field($stats_array["referrer"]);
        $paramsArray["banner_open_count"] = sanitize_text_field($stats_array["openCount"]);

        $post_data = array(
            'client_id' => time() . "." . rand(),
            'non_personalized_ads' => true,
            'events' => array(
                array(
                    'name' => sanitize_text_field($stats_array["mainStatus"]),
                    'params' => $paramsArray,
                ),
            ),
        );

        $this->do_request($query_str, $post_data);
    }

    private function do_request($query_str, $data)
    {
        $args = array(
            'method' => 'POST',
            'headers' => array(
                'Content-Type' => 'application/json',
            ),
            'body' => json_encode($data),
        );

        $trackUrl = 'https://www.google-analytics.com/mp/collect?' . $query_str;
        $request = wp_remote_post($trackUrl, $args);
    }

    private function store_log_files($content)
    {
        if (get_option("nsc_bar_store_consents_log", "0") !== "1") {
            return;
        }

        if ($content["mainStatus"] === "banner_open") {
            return;
        }

        $userIpData = $this->get_user_IP();
        $content["user_ip"] = $userIpData["ipaddress"];
        $content["user_ip_source"] = $userIpData["source"];
        $content["datetime"] = gmdate('Y-m-d\TH:i:s\Z');
        $year = gmdate('Y');
        $month = gmdate('m');
        $bara_configs = new nsc_bara_addon_configs;
        $bara_configs->nsc_bara_store_file(array("consent-logs", $year, $month), "beautiful-consents-" . gmdate('Y-m-d') . ".ndjson", json_encode($content), true);
    }

    private function get_user_IP()
    {
        $headerFieldsToCheck = array(
            'HTTP_X_REAL_IP',
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR',
        );

        foreach ($headerFieldsToCheck as $headerField) {

            if (isset($_SERVER[$headerField]) === false) {
                continue;
            }

            $ipArray = explode(',', $_SERVER[$headerField]);

            if (is_array($ipArray) === false) {
                continue;
            }

            $ipArray = array_map('trim', $ipArray);
            $ipArray = filter_var_array($ipArray, FILTER_VALIDATE_IP);
            $ipString = implode(',', $ipArray);
            $ipString = trim($ipString, ",");

            if (empty($ipString) === false) {
                return array("ipaddress" => $ipString, "source" => $headerField);
            }

        }

        return array("ipaddress" => "unknown", "source" => "fallback");
    }

    private function sanitize_stats_string($data)
    {
        $sanitized_data = array();

        // sanitize the "href" value
        if (isset($data["href"]) && is_string($data["href"])) {
            $sanitized_data["href"] = esc_url_raw($data["href"]);
        }

        // sanitize the "referrer" value
        if (isset($data["referrer"]) && is_string($data["referrer"])) {
            $sanitized_data["referrer"] = esc_url_raw($data["referrer"]);
        }

        // sanitize the "cookieName" value
        if (isset($data["cookieName"]) && is_string($data["cookieName"])) {
            $sanitized_data["cookieName"] = sanitize_text_field($data["cookieName"]);
        }

        // sanitize the "mainStatus" value
        if (isset($data["mainStatus"]) && is_string($data["mainStatus"])) {
            $sanitized_data["mainStatus"] = sanitize_text_field($data["mainStatus"]);
        }

        // sanitize the "openCount" value
        if (isset($data["openCount"]) && is_int($data["openCount"])) {
            $sanitized_data["openCount"] = intval($data["openCount"]);
        }

        // sanitize the "cookieTypeConsent" value
        if (isset($data["cookieTypeConsent"]) && is_array($data["cookieTypeConsent"])) {
            $cookie_type_consent = array();

            foreach ($data["cookieTypeConsent"] as $cookie) {
                if (isset($cookie["name"]) && is_string($cookie["name"]) &&
                    isset($cookie["status"]) && is_string($cookie["status"])) {
                    $cookie_type_consent[] = array(
                        "name" => sanitize_text_field($cookie["name"]),
                        "status" => sanitize_text_field($cookie["status"]),
                    );
                }
            }

            $sanitized_data["cookieTypeConsent"] = $cookie_type_consent;
        }
        return $sanitized_data;
    }
}
