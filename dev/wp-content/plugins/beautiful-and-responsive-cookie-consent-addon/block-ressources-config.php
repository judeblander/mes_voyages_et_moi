<?php
if (!defined('ABSPATH')) {
    exit;
}

function nsc_bara_get_blocked_resourcen_config()
{
    return array(
        'awinNew' => array('serviceId' => 'awinNew', 'serviceName' => 'AWIN', 'regExPattern' => '\/\/www\.dwin1\.com\/'),
        'facebookPixelNew' => array('serviceId' => 'facebookPixelNew', 'serviceName' => 'Facebook Pixel', 'regExPattern' => '\/\/connect\.facebook\.net|\/\/www\.facebook\.com\/tr'),
        'facebookSocialPluginsNew' => array('serviceId' => 'facebookSocialPluginsNew', 'serviceName' => 'Facebook Social Plugins', 'regExPattern' => '\/\/www\.facebook\.com\/plugins\/like\.php|\/\/www\.facebook.com\/plugins\/likebox\.php|\/\/www\.facebook\.com\/plugins\/share_button\.php|\/\/www\.facebook\.com\/.*\/plugins\/page\.php|admin\-ajax\.php\?action\=likeboxfrontend'),
        'googleAdsense' => array('serviceId' => 'googleAdsense', 'serviceName' => 'Google Adsense', 'regExPattern' => 'pagead2\.googlesyndication\.com\/pagead\/js\/adsbygoogle\.js'),
        'googleAdwordsConv' => array('serviceId' => 'googleAdwordsConv', 'serviceName' => 'Google AdWords Remarketing/Conversion Tag', 'regExPattern' => 'googleadservices\.com\/pagead\/conversion\.js|googleads\.g\.doubleclick\.net\/pagead\/viewthroughconversion'),
        'googleAnalytics' => array('serviceId' => 'googleAnalytics', 'serviceName' => 'Google Analytics', 'regExPattern' => 'google-analytics\.com\/analytics\.js'),
        'googleFontsNew' => array('serviceId' => 'googleFontsNew', 'serviceName' => 'Google Fonts', 'regExPattern' => '\/\/fonts\.googleapis\.com|\/\/fonts\.gstatic\.com'),
        'googleGTAG' => array('serviceId' => 'googleGTAG', 'serviceName' => 'Google Gtag', 'regExPattern' => 'googletagmanager\.com\/gtag\/js'),
        'googleMapsNew' => array('serviceId' => 'googleMapsNew', 'serviceName' => 'Google Maps', 'regExPattern' => '\/\/maps\.google\.com|\/\/google\.[\w\.]+\/maps\/|\/\/maps\.googleapis\.com'),
        'googleYoutube' => array('serviceId' => 'googleYoutube', 'serviceName' => 'YouTube', 'regExPattern' => 'youtube\.com\/embed\/'),
        'googleYoutubeNoCookie' => array('serviceId' => 'googleYoutubeNoCookie', 'serviceName' => 'YouTube - privacy mode (no cookie)', 'regExPattern' => 'youtube\-nocookie\.com\/embed\/'),
        'googleRecaptcha' => array('serviceId' => 'googleRecaptcha', 'serviceName' => 'Google Recaptcha', 'regExPattern' => 'google\.com\/recaptcha\/|gstatic\.com\/recaptcha\/'),
        'gtm' => array('serviceId' => 'gtm', 'serviceName' => 'Google Tag Manager', 'regExPattern' => 'www\.googletagmanager\.com\/gtm\.js'),
        'googleTranslateNew' => array('serviceId' => 'googleTranslateNew', 'serviceName' => 'Google Translate', 'regExPattern' => '\/\/translate\.(googleapis|google)\.com|\/\/gstatic\.com|\/\/translate-pa\.googleapis\.com'),
        'instagram' => array('serviceId' => 'instagram', 'serviceName' => 'Instagram', 'regExPattern' => 'instagram\.com\/embed\.js|platform\.instagram\.com\/.*\/embeds\.js'),
        'jetpackPluginStatsNew' => array('serviceId' => 'jetpackPluginStatsNew', 'serviceName' => 'Jetpack Stats', 'regExPattern' => '\/\/stats\.wp\.com'),
        'linkedInPixelNew' => array('serviceId' => 'linkedInPixelNew', 'serviceName' => 'LinkedIn Pixel', 'regExPattern' => '\/\/snap\.licdn\.com'),
        'matomo' => array('serviceId' => 'matomo', 'serviceName' => 'Matomo', 'regExPattern' => '\/piwik\.js|\/matomo\.js'),
        'twitterNew' => array('serviceId' => 'twitterNew', 'serviceName' => 'Twitter', 'regExPattern' => '\/\/platform\.twitter\.com'),
        'vimeo' => array('serviceId' => 'vimeo', 'serviceName' => 'Vimeo', 'regExPattern' => 'player\.vimeo\.com\/video'),
        'yandexMetricaNew' => array('serviceId' => 'yandexMetricaNew', 'serviceName' => 'Yandex Metrica', 'regExPattern' => '\/\/mc\.yandex\.ru'),
        'awin' => array('serviceId' => 'awin', 'serviceName' => 'AWIN (legacy)', 'regExPattern' => 'www\.dwin1\.com\/'),
        'facebookPixel' => array('serviceId' => 'facebookPixel', 'serviceName' => 'Facebook Pixel (legacy)', 'regExPattern' => 'connect\.facebook\.net|www\.facebook\.com\/tr'),
        'facebookSocialPlugins' => array('serviceId' => 'facebookSocialPlugins', 'serviceName' => 'Facebook Social Plugins (legacy)', 'regExPattern' => 'www\.facebook\.com\/plugins\/like\.php|www\.facebook.com\/plugins\/likebox\.php|www\.facebook\.com\/plugins\/share_button\.php|www\.facebook\.com\/.*\/plugins\/page\.php|admin\-ajax\.php\?action\=likeboxfrontend'),
        'googleFonts' => array('serviceId' => 'googleFonts', 'serviceName' => 'Google Fonts  (legacy)', 'regExPattern' => 'fonts\.googleapis\.com|fonts\.gstatic\.com'),
        'googleMaps' => array('serviceId' => 'googleMaps', 'serviceName' => 'Google Maps (legacy)', 'regExPattern' => 'maps\.google\.com|google\.[\w\.]+\/maps\/|maps\.googleapis\.com'),
        'googleTranslate' => array('serviceId' => 'googleTranslate', 'serviceName' => 'Google Translate (legacy)', 'regExPattern' => 'translate\.(googleapis|google)\.com|gstatic\.com|translate-pa\.googleapis\.com'),
        'instagram' => array('serviceId' => 'instagram', 'serviceName' => 'Instagram (legacy)', 'regExPattern' => 'instagram\.com\/embed\.js|platform\.instagram\.com\/.*\/embeds\.js'),
        'jetpackPluginStats' => array('serviceId' => 'jetpackPluginStats', 'serviceName' => 'Jetpack Stats (legacy)', 'regExPattern' => '\/\/stats\.wp\.com'),
        'linkedInPixel' => array('serviceId' => 'linkedInPixel', 'serviceName' => 'LinkedIn Pixel (legacy)', 'regExPattern' => 'snap\.licdn\.com'),
        'twitter' => array('serviceId' => 'twitter', 'serviceName' => 'Twitter (legacy)', 'regExPattern' => 'platform\.twitter\.com'),
        'yandexMetrica' => array('serviceId' => 'yandexMetrica', 'serviceName' => 'Yandex Metrica (legacy)', 'regExPattern' => 'mc\.yandex\.ru'),
    );
}
