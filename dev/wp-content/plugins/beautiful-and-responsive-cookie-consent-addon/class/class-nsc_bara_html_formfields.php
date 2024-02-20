<?php
if (!defined('ABSPATH')) {
    exit;
}

class nsc_bara_html_formfields_addon
{
    private $current_language;
    private $languages;

    public function __construct()
    {
        $language = new nsc_bara_languages;
        $this->languages = $language->nsc_bara_get_available_languages();
    }

    private function get_current_language()
    {
        if (!empty($this->current_language)) {
            return $this->current_language;
        }
        $language = new nsc_bara_languages;
        $this->current_language = $language->nsc_bara_get_current_language();
        return $this->current_language;
    }

    public function nsc_bara_get_language_dropdown()
    {
        $form = '<form id="nsc_bar_language_form" action="' . get_admin_url() . 'options-general.php" method="GET">';
        $form .= '<select onchange="document.getElementById(\'nsc_bar_language_form\').submit();" name="nsc_bara_language_selector" id="nsc_bar_countries_select">';

        if (!empty($this->languages)) {
            $current_lang = $this->get_current_language();
            foreach ($this->languages as $language) {
                $selected = "";
                if ($current_lang === $language["language_code"]) {
                    $selected = "selected";
                }
                $form .= '<option ' . $selected . ' value="' . esc_attr($language["language_code"]) . '">' . esc_attr($language["translated_name"]) . '</option>';
            }
        }
        $form .= '</select>';
        $ignoreGetParameter = array("nsc_bara_language_selector", "post_type");
        foreach ($_GET as $name => $value) {
            if (in_array($name, $ignoreGetParameter)) {
                continue;
            }
            $name = esc_attr(sanitize_text_field($name));
            $value = esc_attr(sanitize_text_field($value));
            $form .= '<input type="hidden" name="' . $name . '" value="' . $value . '">';
        }

        $form .= '</form>';
        return $form;
    }

    public function nsc_bara_is_disabled($field)
    {
        $current_lang = $this->get_current_language();
        if ($field->translatable == false && $current_lang !== "xx") {
            return "disabled";
        }
        return "";

    }

}
