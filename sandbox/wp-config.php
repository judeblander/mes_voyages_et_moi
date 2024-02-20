<?php
define( 'WP_CACHE', true );

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u503423796_tnDkE' );

/** Database username */
define( 'DB_USER', 'u503423796_11HA0' );

/** Database password */
define( 'DB_PASSWORD', 'ADpQ2HmlEp' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'nLgUud?wP ,Hy+Z|R-`L h6J2(q.X_aY{Sh!n4^#(*rHy)/[7nck0:Q*bd|X4Arn' );
define( 'SECURE_AUTH_KEY',   '9 |z7(0DyvcjAi7{hrQZ&2{-qe&+5UzHTpdLL~]#juL#$WlK1xy.bS]ZlA,L#uBn' );
define( 'LOGGED_IN_KEY',     ';uR. !5%DU`S,Ert<X|BhqMLXxfI[D6yRuO&xKhX(W3al^=dZ8,MfS|;={{L:yYW' );
define( 'NONCE_KEY',         '6pY sFc+r2K)oHX5YCO?oPC)$C^07PR3jHM}AmH!G{WV>M/s!UWY)kE>sVc1h,Cr' );
define( 'AUTH_SALT',         '+F= ;PF-N(RCaBIx;3-psB9u= $+WqV%aqSO-SsCE=?7FrZ[r@YC>=78,,|uNYb#' );
define( 'SECURE_AUTH_SALT',  'cgK?xwAD^h#fp80c?!*z2*XxS3UWqQ@Jsn]=pQN$m0*fO1#q!(^iR[BW+AwmxD_c' );
define( 'LOGGED_IN_SALT',    'n{wI822kdwVW/_zA!2i3[+_%D4odO4:+/u6;o~mU,tDmz7+JahWFL&0RbCmv|tkU' );
define( 'NONCE_SALT',        '.xJJpMa]f6@Y;0Qtbb{Q[K`)aLZL.#o8>P5,W#dA+^2wS.3Z{rhoZj1aky`M9f)T' );
define( 'WP_CACHE_KEY_SALT', 'f-8# M~_)Q479UksIuK]Iz)Hm]ow-/l.OH@not|3.,.BI7dOR/I `S%nuSJ*PzL(' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );


/* Add any custom values between this line and the "stop editing" line. */

define('DISALLOW_FILE_EDIT', false);

define( 'FS_METHOD', 'direct' );
define( 'WP_AUTO_UPDATE_CORE', false );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
