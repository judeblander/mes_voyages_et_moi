<?php
/*
Plugin Name: Beautiful and responsive cookie consent - premium add-on
Description: This premium add-on adds additional functionality to the free beautiful and responsive cookie consent plugin.
Author: Beautiful Cookie Banner
Version: 2.9.0
Author URI: https://beautiful-cookie-banner.com
Text Domain: bara-add-on-cookie-consent
License:     GPLv3
 */

if (!defined('ABSPATH')) {
    exit;
}

// Constants
require dirname(__FILE__) . "/globals.php";
define("NSC_BARA_PLUGIN_URL", plugin_dir_url(__FILE__));

require NSC_BARA_PLUGIN_DIR . "/class/class-nsc_bara_admin_error.php";
require NSC_BARA_PLUGIN_DIR . "/class/class-nsc_bara_input_validation.php";
require NSC_BARA_PLUGIN_DIR . "/class/class-nsc_bara_languages.php";
require NSC_BARA_PLUGIN_DIR . "/class/class-nsc_bara_addon_configs.php";
require NSC_BARA_PLUGIN_DIR . "/class/class-nsc_bara_updater.php";
require NSC_BARA_PLUGIN_DIR . "/class/class-nsc_bara_admin_settings.php";
require NSC_BARA_PLUGIN_DIR . "/class/class-nsc_bara_html_formfields.php";
require NSC_BARA_PLUGIN_DIR . "/class/class-nsc_bara_banner_configs.php";
require NSC_BARA_PLUGIN_DIR . "/class/class-nsc_bara_gtm.php";
require NSC_BARA_PLUGIN_DIR . "/class/class-nsc_bara_frontend_consentmode.php";
require NSC_BARA_PLUGIN_DIR . "/class/class-nsc_bara_save_form_fields.php";
require NSC_BARA_PLUGIN_DIR . "/class/class-nsc_bara_block_tracking.php";
require NSC_BARA_PLUGIN_DIR . "/class/class-nsc_bara_stats.php";
require NSC_BARA_PLUGIN_DIR . "/class/class-nsc_bara_settings_export.php";
require NSC_BARA_PLUGIN_DIR . "/class/class-nsc_bara_rest_api.php";
require NSC_BARA_PLUGIN_DIR . "/class/class-nsc_bara_allowlist.php";

function nsc_bara_add_settings_link($links)
{
    $settings_link = '<a href="options-general.php?page=nsc_bar-cookie-consent&tab=multilanguage">' . __('Settings') . '</a>';
    array_push($links, $settings_link);
    return $links;
}

$nsc_bara_addon_configs = new nsc_bara_addon_configs;
register_deactivation_hook(__FILE__, array($nsc_bara_addon_configs, "nsc_bara_deactivated"));

$nsc_bara_frontend_consentmode = new nsc_bara_frontend_consentmode();
add_action('wp_print_scripts', array($nsc_bara_frontend_consentmode, "nsc_bara_enqueue_consentmode_default_script"), -2147483648);

$nsc_bara_rest_api = new nsc_bara_rest_api();
add_action('rest_api_init', array($nsc_bara_rest_api, "nsc_bara_register_endpoints"));

$nsc_bara_is_admin = is_admin();

if ($nsc_bara_is_admin) {
    $nsc_bara_admin_settings = new nsc_bara_admin_settings_addon;
    add_filter("plugin_action_links_" . plugin_basename(__FILE__), 'nsc_bara_add_settings_link');

    add_action('admin_enqueue_scripts', array($nsc_bara_admin_settings, "nsc_bara_enqueue_script_on_admin_page"));
    add_action('plugins_loaded', array($nsc_bara_addon_configs, 'nsc_bara_check_for_needed_classes'));
    add_action('plugins_loaded', array($nsc_bara_addon_configs, 'nsc_bara_check_for_valid_license_key'));
    add_filter("nsc_bar_plugin_settings_as_an_object", array($nsc_bara_addon_configs, 'nsc_bara_remove_custom_service'));
    $nsc_bara_input_validation = new nsc_bara_input_validation;
    add_filter("nsc_bar_filter_input_validation", array($nsc_bara_input_validation, 'nsc_bara_validate_field_custom_save'), 10, 2);
}

$nsc_bara_TrackingBlocker = new nsc_bara_tracking_blocker;
add_filter("nsc_bar_plugin_settings_as_an_object", array($nsc_bara_TrackingBlocker, 'nsc_bara_add_enqueueScriptOption'), 10, 1);
if (get_option("nsc_bar_activate_banner", false) == true) {
    $nsc_bara_banner_configs = new nsc_bara_banner_configs_addon();
    $nsc_bara_gtm = new nsc_bara_gtm();

    add_action('wp_enqueue_scripts', array($nsc_bara_gtm, 'nsc_bara_enqueue_gtm_scripts'));

    if (get_option("nsc_bar_activate_stats", false) == true && !$nsc_bara_is_admin) {
        add_filter('nsc_bar_filter_json_config_string_before_js', array($nsc_bara_banner_configs, "nsc_bara_add_stats_url_to_config_string"));
    }
    add_filter('nsc_bar_filter_inline_script_initialize', array($nsc_bara_banner_configs, "nsc_bara_add_show_delay_to_banner"));
    $nsc_bara_allowlist = new nsc_bara_allowlist();
    add_filter("nsc_bar_plugin_settings_as_an_object", array($nsc_bara_TrackingBlocker, 'nsc_bara_add_enqueueScriptOption'), 10, 1);
    add_filter("nsc_bar_plugin_settings_as_an_object", array($nsc_bara_allowlist, 'nsc_bara_add_allow_block_list'), 10, 1);
}

if (get_option("nsc_bar_activate_service_blocking", false) == true && get_option("nsc_bar_activate_banner", false) == true) {

    if (get_option("nsc_bar_enqueueBlockingScripts", "0") === "1") {
        add_action('wp_enqueue_scripts', array($nsc_bara_TrackingBlocker, 'nsc_bara_enqueue_blocking_scripts'), -2147483647);
    } else {
        add_action('wp_head', array($nsc_bara_TrackingBlocker, 'nsc_bara_echo_blocking_scripts'), -2147483647);
    }
    add_action('wp_head', array($nsc_bara_TrackingBlocker, 'nsc_bara_buffer_set'), -2147483646);
    add_action('login_footer', array($nsc_bara_TrackingBlocker, 'nsc_bara_buffer_flush'), 2147483647);
    add_action('wp_footer', array($nsc_bara_TrackingBlocker, 'nsc_bara_buffer_flush'), 2147483647);
    add_filter('rocket_excluded_inline_js_content', array($nsc_bara_TrackingBlocker, 'nsc_bara_exclude_inline_scripts_from_caching'));
}

$nsc_bara_updater = new nsc_bara_auto_updater;
add_filter('plugins_api', array($nsc_bara_updater, 'nsc_bara_get_info'), 10, 3);
add_filter('pre_set_site_transient_update_plugins', array($nsc_bara_updater, 'nsc_bara_pre_set_site_transient_update_plugins'));

global $pagenow;
if ('plugins.php' === $pagenow) {
    $hook = "in_plugin_update_message-beautiful-and-responsive-cookie-consent-addon/nsc_bara-cookie-consent-addon.php";
    add_action($hook, array($nsc_bara_updater, 'nsc_bara_custom_update_message'), 20, 2);
}
