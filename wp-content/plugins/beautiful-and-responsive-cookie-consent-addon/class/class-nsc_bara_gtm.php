<?php
if (!defined('ABSPATH')) {
    exit;
}

class nsc_bara_gtm
{
    public function nsc_bara_enqueue_gtm_scripts()
    {
        $gtm_id = esc_attr(get_option("nsc_bar_gtm_id", ''));
        if (empty($gtm_id)) {
            return "";
        }

        $bannerSettings = get_option("nsc_bar_banner_settings", array());

        $deps = array();
        if (get_option("nsc_bar_activate_banner", false) == true && get_option("nsc_bar_activate_service_blocking", "0") === "1" && get_option("nsc_bar_enqueueBlockingScripts", "0") === "1") {
            $deps = array("nsc_bara_blocking_script");
        }

        wp_register_script('nsc_bara_gtm_loader_js', NSC_BARA_PLUGIN_URL . 'public/js/nscGTM.js', $deps, NSC_BARA_PLUGIN_VERSION, false);
        wp_localize_script('nsc_bara_gtm_loader_js', 'nsc_bara_php_gtm_vars', array(
            'gtm_id' => esc_js($gtm_id),
            'dataLayerName' => esc_js($this->get_dataLayer_name()),
            'gtmHostname' => esc_js(get_option('nsc_bar_tagmanagerHostname', "www.googletagmanager.com")),
            'gtmUrl' => esc_js(get_option('nsc_bar_tagmanagerUrl', "")),

        ));
        wp_enqueue_script('nsc_bara_gtm_loader_js');
        add_filter("nsc_bar_filter_banner_init_dependencies", array($this, 'nsc_bara_filter_deps'), 10);
    }

    public function nsc_bara_filter_deps($deps)
    {
        $deps[] = 'nsc_bara_gtm_loader_js';
        return $deps;
    }

    private function get_dataLayer_name()
    {
        $bannerSettings = get_option("nsc_bar_bannersettings_json", "");
        if (empty($bannerSettings)) {
            return "dataLayer";
        }
        $bannerSettings = json_decode($bannerSettings, true);

        if (empty($bannerSettings) === false && isset($bannerSettings["dataLayerName"]) && empty($bannerSettings["dataLayerName"]) === false) {
            return $bannerSettings["dataLayerName"];
        }

        return "dataLayer";
    }

}
