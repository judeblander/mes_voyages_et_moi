<?php
if (!defined('ABSPATH')) {
    exit;
}
// globals independent from wordpress
// Caution: this file is used in two places!!

define("NSC_BARA_PLUGIN_VERSION", "2.9.0");
define("NSC_BARA_PLUGIN_DIR", dirname(__FILE__));
define("NSC_BARA_DB_VERSION", "1.0");
define("NSC_BARA_SLUG_DBVERSION", "nsc_bara_db_version");
define("NSC_BARA_PLUGIN_SLUG", "beautiful-and-responsive-cookie-consent-addon");
define("NSC_BARA_UPDATE_TRANSIENT_NAME", 'nsc_bara_update_' . NSC_BARA_PLUGIN_SLUG . "_" . NSC_BARA_PLUGIN_VERSION);
