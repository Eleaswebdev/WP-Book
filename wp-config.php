<?php
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
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',          '=h6P(<O}v0LUsyVN_/gBf<$Dc^?hr$S+ d! lp]LTfyXfcoI.!5&IJ8*rn@p.bVY' );
define( 'SECURE_AUTH_KEY',   'VQx/I2+e+j1nVw_$DxG}{};.;r3?hL`78.8_h<1td1NEINIhyk#8KQsCMf|mXLg0' );
define( 'LOGGED_IN_KEY',     '*>jdE/XL.Cp3R$I7o{Q,;8Wq=`OU9v{>2wFj;JLR@FNImEi5VuWh?8|t}BvM<7oC' );
define( 'NONCE_KEY',         'ek6!.CT]F,`IuCEg0?qI$Ed8)@<?CUx16gN<6N.jfVBj%g~*e;`)=N*,pTI%,?s8' );
define( 'AUTH_SALT',         'iOv0C5{3 @{OG:9u4et%rZYb7vX2*<BPWqt2D5iBeg_tX^oCIhLR8&*P>Ut[fm[m' );
define( 'SECURE_AUTH_SALT',  '*X@EZt|bk;J*:$~OH-:m<r!O5O.4It|=[)%zIhj.#7Q7hD}<S+XI0$}9$wc<i>^K' );
define( 'LOGGED_IN_SALT',    '.ijb$ ,yE:+v)$^}ph git%keNAy!Hf?<*?pM9|Imk$7&-1i;-kFoa/?V5pXGwbQ' );
define( 'NONCE_SALT',        '4M_)Ht|A$6wv*4%AptP.u1M1H%7!hN)oxKg#yKImxPPpvfH:W9$yrrBa9&I.%_=$' );
define( 'WP_CACHE_KEY_SALT', 'H/G,J$$gt%r&npPqn0lV+~^dWwLE!pD<6X+ad,K_NkBKD=/{Np|o:OdH5q$#=$U4' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
