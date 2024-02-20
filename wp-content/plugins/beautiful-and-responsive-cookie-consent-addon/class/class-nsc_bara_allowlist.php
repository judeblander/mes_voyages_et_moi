<?php
if (!defined('ABSPATH')) {
    exit;
}

class nsc_bara_allowlist
{

    private $config_string_block;

    public function __construct()
    {
        $this->config_string_block = json_decode('{
            "field_slug": "blacklistPage",
            "type": "textarea",
            "save_as": "array",
            "required": false,
            "extra_validation_name": "nsc_bara_validate_block_list",
            "pre_selected_value": "[]",
            "helpertext": "Add a comma separated list of pathnames, where the banner should not be shown. If you are not sure what the pathname of the specific page is, execute `location.pathname` in your browser console.",
            "name": "Block List",
            "save_in_db": false
          }');
    }

    public function nsc_bara_add_allow_block_list($pluginConfigs)
    {
        $tabsLength = count($pluginConfigs->setting_page_fields->tabs);
        for ($i = 0; $i < $tabsLength; $i++) {
            if ($pluginConfigs->setting_page_fields->tabs[$i]->tab_slug === "compliance_type") {
                $pluginConfigs->setting_page_fields->tabs[$i]->tabfields[] = $this->config_string_block;
            }
        }
        return $pluginConfigs;
    }
}
