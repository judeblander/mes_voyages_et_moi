<?php

if (!defined('ABSPATH')) {
    exit;
}

if (defined('WP_UNINSTALL_PLUGIN') === false) {
    echo "no way";
    exit;
}

define("NSC_BARA_PLUGIN_DIR", dirname(__FILE__));
define("NSC_BARA_PLUGIN_URL", plugin_dir_url(__FILE__));
define("NSC_BARA_SLUG_DBVERSION", "nsc_bara_db_version");

require dirname(__FILE__) . "/class/class-nsc_bara_languages.php";
require dirname(__FILE__) . "/class/class-nsc_bara_addon_configs.php";
require dirname(__FILE__) . "/class/class-nsc_bara_uninstall.php";

$uninstaller = new nsc_bara_uninstaller();
$uninstaller->nsc_bara_deleteOptions();
if (get_filesystem_method() === 'direct') {
    $uninstaller->nsc_bara_delete_folder();
}
