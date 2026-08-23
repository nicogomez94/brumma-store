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
define( 'AUTH_KEY',          's!p*u@{^lI,CRl*X,xIu&ht3JV)nV)[wKWGQg_U/C8R+<({|aAB($#zx-r/3?6T0' );
define( 'SECURE_AUTH_KEY',   'N7:h~}XE)zcAvZ. q#`G, <}8ds-9r{/29?r8o!-5k.k6[p0MA4gi<60x/e&wF+d' );
define( 'LOGGED_IN_KEY',     ',1`|!bvh3*/I[S_+@z@(#O-^$gn[?./ptQh 7Kf3`?]eJd,N+Xt<f0qOrM@uwj@Z' );
define( 'NONCE_KEY',         '>`A^?jc!(vP*hrXb? lbVWlt<Eb7h@[q}Uyig$r0RB)bw?OD{9S]dn%E^x%k!UE~' );
define( 'AUTH_SALT',         'zSb)%/j#k|#kliemz}V78d%bWec}.X?m3x:h8l?0?_2:|wCqbQubxNx8tW@%RQZX' );
define( 'SECURE_AUTH_SALT',  '`ZCNS}!3N><kE0ie/`vQqb4y*LoC;p$<PKosy{0y~H.L)9ckha$HF>S%y|1VXsC`' );
define( 'LOGGED_IN_SALT',    'X%j$w@ClD_?R`$bc<Bfj*HJllntxGvf*^<lE_`k@:9}JeJWz>GurKd$|,pJz~FGL' );
define( 'NONCE_SALT',        'Uj<Y|bU>tr67J,.svXIk{+0VP$9FNAOfXG?6.E3^=$)2.A.#3*nCJ]//-gk)u2yV' );
define( 'WP_CACHE_KEY_SALT', '#fRg~9K3#U`85[CZ[eOk9X4U~1LYGDdn%PWq3tCXQj,y6{:Q#{]|x+c$6V/Q5=gF' );


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
