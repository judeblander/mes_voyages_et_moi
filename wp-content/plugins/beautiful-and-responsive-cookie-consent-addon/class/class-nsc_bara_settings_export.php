<?php
if (!defined('ABSPATH')) {
    exit;
}

class nsc_bara_settings_export
{

    public function nsc_bara_get_settings()
    {
        $settings = $this->get_all_settings();

        return $settings;

    }

    public function nsc_bara_update_settings($settingsToUpdate)
    {
        if (!class_exists('nsc_bar_save_form_fields')) {
            return false;
        }

        $save = new nsc_bar_save_form_fields;
        $successFullyUpdated = $save->nsc_bar_save_settings_api($settingsToUpdate);

        for ($x = 0; $x < count($settingsToUpdate); $x++) {
            $optionName = $settingsToUpdate[$x]["option_name"];
            unset($settingsToUpdate[$x]["option_value"]);
            if (in_array($optionName, $successFullyUpdated)) {
                $settingsToUpdate[$x]["update_success"] = true;
                continue;
            }
            $settingsToUpdate[$x]["update_success"] = false;
        }
        return $settingsToUpdate;

    }

    private function get_all_settings()
    {
        global $wpdb;
        $options = $wpdb->get_results("select * from $wpdb->options where option_name like 'nsc_bar_%' or option_name like 'nsc_bara_%'");
        $names = array();
        foreach ($options as $option) {
            $names[] = array("option_name" => $option->option_name, "option_value" => $option->option_value);
        }
        return $names;
    }
}
