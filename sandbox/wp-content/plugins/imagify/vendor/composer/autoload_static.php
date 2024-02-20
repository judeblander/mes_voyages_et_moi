<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

use Composer\AutoloadWPMediaImagifyWordPressPlugin\ClassLoader as ClassLoaderWPMediaImagifyWordPressPlugin;


class ComposerStaticInit49a1cdf8dc57f57539cd34f9d3c0eac1
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Imagify\\ThirdParty\\WPRocket\\' => 28,
            'Imagify\\ThirdParty\\RegenerateThumbnails\\' => 40,
            'Imagify\\ThirdParty\\NGG\\' => 23,
            'Imagify\\ThirdParty\\FormidablePro\\' => 33,
            'Imagify\\ThirdParty\\EnableMediaReplace\\' => 38,
            'Imagify\\ThirdParty\\AS3CF\\' => 25,
            'Imagify\\Deprecated\\Traits\\' => 26,
            'Imagify\\' => 8,
        ),
        'D' => 
        array (
            'Dangoodman\\ComposerForWordpress\\' => 32,
        ),
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Imagify\\ThirdParty\\WPRocket\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc/3rd-party/wp-rocket/classes',
        ),
        'Imagify\\ThirdParty\\RegenerateThumbnails\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc/3rd-party/regenerate-thumbnails/classes',
        ),
        'Imagify\\ThirdParty\\NGG\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc/3rd-party/nextgen-gallery/classes',
        ),
        'Imagify\\ThirdParty\\FormidablePro\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc/3rd-party/formidable-pro/classes',
        ),
        'Imagify\\ThirdParty\\EnableMediaReplace\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc/3rd-party/enable-media-replace/classes',
        ),
        'Imagify\\ThirdParty\\AS3CF\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc/3rd-party/amazon-s3-and-cloudfront/classes',
        ),
        'Imagify\\Deprecated\\Traits\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc/deprecated/Traits',
        ),
        'Imagify\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes',
        ),
        'Dangoodman\\ComposerForWordpress\\' => 
        array (
            0 => __DIR__ . '/..' . '/dangoodman/composer-for-wordpress',
        ),
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Imagify' => __DIR__ . '/../..' . '/inc/classes/class-imagify.php',
        'Imagify_AS3CF_Attachment' => __DIR__ . '/../..' . '/inc/deprecated/classes/class-imagify-as3cf-attachment.php',
        'Imagify_AS3CF_Deprecated' => __DIR__ . '/../..' . '/inc/deprecated/classes/class-imagify-as3cf-deprecated.php',
        'Imagify_Abstract_Attachment' => __DIR__ . '/../..' . '/inc/deprecated/classes/class-imagify-abstract-attachment.php',
        'Imagify_Abstract_Background_Process' => __DIR__ . '/../..' . '/inc/classes/class-imagify-abstract-background-process.php',
        'Imagify_Abstract_Cron' => __DIR__ . '/../..' . '/inc/classes/class-imagify-abstract-cron.php',
        'Imagify_Abstract_DB' => __DIR__ . '/../..' . '/inc/classes/class-imagify-abstract-db.php',
        'Imagify_Abstract_DB_Deprecated' => __DIR__ . '/../..' . '/inc/deprecated/classes/class-imagify-abstract-db-deprecated.php',
        'Imagify_Abstract_Options' => __DIR__ . '/../..' . '/inc/classes/class-imagify-abstract-options.php',
        'Imagify_Admin_Ajax_Post' => __DIR__ . '/../..' . '/inc/classes/class-imagify-admin-ajax-post.php',
        'Imagify_Admin_Ajax_Post_Deprecated' => __DIR__ . '/../..' . '/inc/deprecated/classes/class-imagify-admin-ajax-post-deprecated.php',
        'Imagify_Assets' => __DIR__ . '/../..' . '/inc/classes/class-imagify-assets.php',
        'Imagify_Assets_Deprecated' => __DIR__ . '/../..' . '/inc/deprecated/classes/class-imagify-assets-deprecated.php',
        'Imagify_Attachment' => __DIR__ . '/../..' . '/inc/deprecated/classes/class-imagify-attachment.php',
        'Imagify_Auto_Optimization' => __DIR__ . '/../..' . '/inc/classes/class-imagify-auto-optimization.php',
        'Imagify_Auto_Optimization_Deprecated' => __DIR__ . '/../..' . '/inc/deprecated/classes/class-imagify-auto-optimization-deprecated.php',
        'Imagify_Cron_Library_Size' => __DIR__ . '/../..' . '/inc/classes/class-imagify-cron-library-size.php',
        'Imagify_Cron_Rating' => __DIR__ . '/../..' . '/inc/classes/class-imagify-cron-rating.php',
        'Imagify_Cron_Sync_Files' => __DIR__ . '/../..' . '/inc/classes/class-imagify-cron-sync-files.php',
        'Imagify_Custom_Folders' => __DIR__ . '/../..' . '/inc/classes/class-imagify-custom-folders.php',
        'Imagify_DB' => __DIR__ . '/../..' . '/inc/classes/class-imagify-db.php',
        'Imagify_Data' => __DIR__ . '/../..' . '/inc/classes/class-imagify-data.php',
        'Imagify_Enable_Media_Replace_Deprecated' => __DIR__ . '/../..' . '/inc/deprecated/classes/class-imagify-enable-media-replace-deprecated.php',
        'Imagify_File_Attachment' => __DIR__ . '/../..' . '/inc/deprecated/classes/class-imagify-file-attachment.php',
        'Imagify_Files_DB' => __DIR__ . '/../..' . '/inc/classes/class-imagify-files-db.php',
        'Imagify_Files_Iterator' => __DIR__ . '/../..' . '/inc/classes/class-imagify-files-iterator.php',
        'Imagify_Files_List_Table' => __DIR__ . '/../..' . '/inc/classes/class-imagify-files-list-table.php',
        'Imagify_Files_Recursive_Iterator' => __DIR__ . '/../..' . '/inc/classes/class-imagify-files-recursive-iterator.php',
        'Imagify_Files_Scan' => __DIR__ . '/../..' . '/inc/classes/class-imagify-files-scan.php',
        'Imagify_Files_Stats' => __DIR__ . '/../..' . '/inc/classes/class-imagify-files-stats.php',
        'Imagify_Filesystem' => __DIR__ . '/../..' . '/inc/classes/class-imagify-filesystem.php',
        'Imagify_Folders_DB' => __DIR__ . '/../..' . '/inc/classes/class-imagify-folders-db.php',
        'Imagify_NGG_Attachment' => __DIR__ . '/../..' . '/inc/deprecated/classes/class-imagify-ngg-attachment.php',
        'Imagify_NGG_Dynamic_Thumbnails_Background_Process' => __DIR__ . '/../..' . '/inc/deprecated/classes/class-imagify-ngg-dynamic-thumbnails-background-process.php',
        'Imagify_Notices_Deprecated' => __DIR__ . '/../..' . '/inc/deprecated/classes/class-imagify-notices-deprecated.php',
        'Imagify_Options' => __DIR__ . '/../..' . '/inc/classes/class-imagify-options.php',
        'Imagify_Regenerate_Thumbnails_Deprecated' => __DIR__ . '/../..' . '/inc/deprecated/classes/class-imagify-regenerate-thumbnails-deprecated.php',
        'Imagify_Requirements' => __DIR__ . '/../..' . '/inc/classes/class-imagify-requirements.php',
        'Imagify_Settings' => __DIR__ . '/../..' . '/inc/classes/class-imagify-settings.php',
        'Imagify_User' => __DIR__ . '/../..' . '/inc/deprecated/classes/class-imagify-user.php',
        'Imagify_Views' => __DIR__ . '/../..' . '/inc/classes/class-imagify-views.php',
        'Imagify_WP_Async_Request' => __DIR__ . '/../..' . '/inc/classes/Dependencies/deliciousbrains/wp-background-processing/classes/wp-async-request.php',
        'Imagify_WP_Background_Process' => __DIR__ . '/../..' . '/inc/classes/Dependencies/deliciousbrains/wp-background-processing/classes/wp-background-process.php',
    );

    public static function getInitializer(ClassLoaderWPMediaImagifyWordPressPlugin $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit49a1cdf8dc57f57539cd34f9d3c0eac1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit49a1cdf8dc57f57539cd34f9d3c0eac1::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit49a1cdf8dc57f57539cd34f9d3c0eac1::$classMap;

        }, null, ClassLoaderWPMediaImagifyWordPressPlugin::class);
    }
}
