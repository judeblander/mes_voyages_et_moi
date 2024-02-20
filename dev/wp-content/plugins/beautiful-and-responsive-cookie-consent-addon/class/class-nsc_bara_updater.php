<?php
if (!defined('ABSPATH')) {
    exit;
}

class nsc_bara_auto_updater
{
    private $parent_main_file_path;

    public function __construct()
    {
        $this->parent_main_file_path = WP_PLUGIN_DIR . "/beautiful-and-responsive-cookie-consent/nsc_bar-cookie-consent.php";
    }

    public function nsc_bara_pre_set_site_transient_update_plugins($transient)
    {

        $update = $this->get_remote_infos();

        if (empty($update)) {
            return $transient;
        }

        if (version_compare(NSC_BARA_PLUGIN_VERSION, $update->new_version) === -1) {
            $transient->response['beautiful-and-responsive-cookie-consent-addon/nsc_bara-cookie-consent-addon.php'] = $update;
        } else {
            $transient->no_update['beautiful-and-responsive-cookie-consent-addon/nsc_bara-cookie-consent-addon.php'] = (object) $update;
        }

        return $transient;
    }

    public function nsc_bara_get_info($res, $action, $args)
    {

        if ('plugin_information' !== $action) {
            return false;
        }

        if (NSC_BARA_PLUGIN_SLUG !== $args->slug) {
            return $res;
        }

        $remote_infos = $this->get_remote_infos();

        if (empty($remote_infos) === true) {
            return false;
        }
        return $remote_infos;
    }

    public function nsc_bara_custom_update_message($plugin_data, $r)
    {
        $args = new stdClass();
        $args->slug = NSC_BARA_PLUGIN_SLUG;

        $infos = $this->nsc_bara_get_info(null, 'plugin_information', $args);

        if (empty($infos->update_message)) {
            return "";
        }

        return print "<br><br><strong style='color:red;'>" . $infos->update_message . "</strong><br>";
    }

    private function get_remote_infos()
    {
        $cachingTimeInHours = 24;
        $cached_infos = get_transient(NSC_BARA_UPDATE_TRANSIENT_NAME);
        if (empty($cached_infos) === false) {
            return $cached_infos;
        }

        $api_url = "https://updater.beautiful-wp.com/beautiful-cookie-banner/" . $this->get_lk() . "/info.json";

        $remote_infos = $this->get($api_url);
        if (empty($remote_infos)) {
            return false;
        }

        $remote_infos = $this->set_arrays_in_infos($remote_infos);

        $cachingTimeInSeconds = 60 * 60 * $cachingTimeInHours;
        set_transient(NSC_BARA_UPDATE_TRANSIENT_NAME, $remote_infos, $cachingTimeInSeconds);
        return $remote_infos;
    }

    private function set_arrays_in_infos($infos)
    {
        $infos->sections = json_decode(json_encode($infos->sections), true);
        $infos->banners = json_decode(json_encode($infos->banners), true);
        $infos->icons = json_decode(json_encode($infos->icons), true);
        $infos->compatibility = json_decode(json_encode($infos->compatibility), true);
        return $infos;
    }

    private function get($api_url)
    {
        $parentVersion = "false";
        if (file_exists($this->parent_main_file_path) && function_exists("get_plugin_data")) {
            $parentPluginData = get_plugin_data($this->parent_main_file_path);
            if (!empty($parentPluginData["Version"])) {
                $parentVersion = $parentPluginData["Version"];
            }
        }

        $error = get_transient('nsc_bara_update_server_error');
        if ($error == true) {
            return false;
        }

        $response = wp_remote_get($api_url, array(
            'headers' => array(
                'pluginversion' => NSC_BARA_PLUGIN_VERSION,
                'pluginslug' => NSC_BARA_PLUGIN_SLUG,
                'wpversion' => get_bloginfo("version"),
                'parentversion' => $parentVersion,
                'wpsiteurl' => site_url(),
                'wphomeurl' => home_url(),
                'phpversion' => phpversion(),
            ),
            'httpversion' => '1.1',
        ));

        $response_code = wp_remote_retrieve_response_code($response);
        if ($response === false || !in_array($response_code, array(200, 204))) {
            set_transient('nsc_bara_update_server_error', true, 43200); // 12 hours cache
            return false;
        }

        return $this->getBody($response);
    }

    private function getBody($response)
    {
        $raw_body = wp_remote_retrieve_body($response);
        $save_body = sanitize_text_field($raw_body);

        $response_body = json_decode($save_body);
        if ($response_body === null && !empty($save_body)) {
            return false;
        }

        return $response_body;
    }

    private function get_lk()
    {
        $lk = get_option("nsc_bar_license_key");
        if (empty($lk) === true) {
            $lk = "please_add_a_license_key";
        }
        return $lk;
    }

}
