<?php
if (!defined('ABSPATH')) {
    exit;
}

class nsc_bara_languages
{
    private $auto_detect;
    private $lang_source;
    private $src_cookie_name;
    private $language_extractor_regex;
    private $available_language_codes;
    private $valid_language_codes;
    private $current_lang;

    public function __construct()
    {
        $this->auto_detect = false;
        if (get_option("nsc_bar_auto_detect_ml_plugin", true) == true) {
            $this->auto_detect = true;
            return;
        }
        $this->lang_source = get_option("nsc_bar_ml_source", "url");
        $this->src_cookie_name = get_option("nsc_bar_ml_cookie_name", "");
        $this->language_extractor_regex = get_option("nsc_bar_language_extractor_regex", "/[a-z]{2}/");
        $this->available_language_codes = strtolower(get_option("nsc_bar_ml_available_language_codes", "en,fr,de"));
    }

    public function nsc_bara_get_current_language()
    {
        if (empty($this->current_lang) === false) {
            $this->current_lang;
        }

        $this->current_lang = "xx";

        if (isset($_GET["nsc_bara_language_selector"]) && is_admin()) {
            $GET_language = sanitize_text_field($_GET["nsc_bara_language_selector"]);
            $this->current_lang = $GET_language;
            return $this->current_lang;
        }

        if (is_admin()) {
            return $this->current_lang;
        }

        if ($this->auto_detect === true) {
            $current_lang = apply_filters('wpml_current_language', null);
        } else {
            $current_lang = $this->get_custom_current_language();
        }

        if (empty($current_lang) === false) {
            $this->current_lang = $current_lang;
            return $this->current_lang;
        }

        return $this->current_lang;
    }

    public function nsc_bara_get_available_languages()
    {

        $listToReturn = array(array(
            "language_code" => "xx",
            "translated_name" => "Default",
            "native_name" => "Default",
        ));

        if ($this->auto_detect === true) {
            return $this->get_wpml_languages($listToReturn);
        }

        $languages = explode(",", $this->available_language_codes);
        $languages_look_up = $this->get_languages_lookup();
        foreach ($languages as $language_code) {
            if (empty($languages_look_up[$language_code])) {
                $listToReturn[] = array(
                    "language_code" => $language_code,
                    "native_name" => $language_code,
                    "translated_name" => $language_code,
                );
                continue;
            }
            $listToReturn[] = array(
                "language_code" => $language_code,
                "native_name" => $languages_look_up[$language_code]["nativeName"],
                "translated_name" => $languages_look_up[$language_code]["name"],
            );
        }
        return $listToReturn;
    }

    private function get_valid_language_codes()
    {
        if (empty($this->valid_language_codes) === false) {
            return $this->valid_language_codes;
        }

        $language_codes = array();
        if ($this->auto_detect === true) {
            $languages = $this->get_wpml_languages(array());
            if (empty($languages) === false) {
                foreach ($languages as $lang) {
                    $language_codes[] = strtolower($lang["language_code"]);
                }
            }
        } else {
            $language_codes = explode(",", $this->available_language_codes);
        }

        $language_codes[] = "xx";

        $this->valid_language_codes = $language_codes;
        return $this->valid_language_codes;
    }

    private function get_custom_current_language()
    {
        $available_languages = explode(",", $this->available_language_codes);
        $current_language = $this->extract_language_code_from_string();
        if (in_array($current_language, $available_languages) === false) {
            return "xx";
        }

        return $current_language;

    }

    private function extract_language_code_from_string()
    {
        $string_to_check = $this->get_string_to_check_for_language();
        $regex = str_replace("/", "\/", $this->language_extractor_regex);
        $regex = str_replace(".", "\.", $regex);
        $found = preg_match('/' . $regex . '/', $string_to_check, $matches);
        if ($found !== 1 || empty($matches[0]) === true) {
            return "xx";
        }

        $result = $matches[0];
        if (empty($matches[1]) === false) {
            $result = $matches[1];
        }
        return preg_replace('/[^a-z]/', '', strtolower($result));
    }

    private function get_string_to_check_for_language()
    {
        if ($this->lang_source === "cookie" && isset($_COOKIE[$this->src_cookie_name])) {
            return sanitize_text_field($_COOKIE[$this->src_cookie_name]);
        }

        if ($this->lang_source === "url") {
            $link = home_url() . $_SERVER['REQUEST_URI'];
            return $link;
        }
        return "";
    }

    private function get_wpml_languages($listToReturn)
    {

        $languages = apply_filters('wpml_active_languages', null, 'orderby=id&order=desc');

        if (empty($languages)) {
            return $listToReturn;
        }

        foreach ($languages as $language) {
            // at very early stage object it is not available. cookie handler loads it too early
            if (!isset($language["native_name"])) {
                continue;
            }

            $listToReturn[] = array(
                "language_code" => strtolower(sanitize_text_field($language["code"])),
                "native_name" => sanitize_text_field($language["native_name"]),
                // at very early stage 'translated_name' it is not available, e.g. when saving.
                "translated_name" => isset($language["translated_name"]) ? sanitize_text_field($language["translated_name"]) : sanitize_text_field($language["native_name"]),
                "english_name" => isset($language["english_name"]) ? sanitize_text_field($language["english_name"]) : sanitize_text_field($language["native_name"]),
            );
        }
        return $listToReturn;
    }

    private function get_languages_lookup()
    {
        $lookup = file_get_contents(NSC_BARA_PLUGIN_DIR . "/languages_lookup.json");
        $lookup = json_decode($lookup, true);
        if (empty($lookup)) {
            throw new Exception("language look up file was not readable. Make sure it contains valid json.");
        }
        return $lookup;
    }
}
