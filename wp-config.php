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
define( 'AUTH_KEY',          '06ex44Ely[uygNcn)i(;^yEKT9<X C:K 4vCU?<VFT6wl?HonF7rbF1</!eX#M4>' );
define( 'SECURE_AUTH_KEY',   '8>:Rr]>g>>ax@NsyWIM:^Dr&K7SJQRc6/u3a-?4Y5ca$dcKeT+BEtlk4V2t`5;O-' );
define( 'LOGGED_IN_KEY',     '(039h@`H:zT+^QajYbk5S-uK52HerV}IqA^s>joG/xB,`.C=UEn-r^z%sLW/L>?s' );
define( 'NONCE_KEY',         '1rOs7_SoAoC >P.,Ki`aSK h4#GwXh&4E_cdsNA0_)-MX!h$]:d9jb.=]q2JRDDc' );
define( 'AUTH_SALT',         'gUrw7)TcvDH0!b8osB)k3Z{4;NrV>g9DJx%E1Ir:&-}ifn~-olE5Qek&{Ylfs]C*' );
define( 'SECURE_AUTH_SALT',  ')h[,HM=.[g9pMiqK661bBC+<y@8(_ETNkdUa&>]@yPd*7NZcnZ/@13</?)2>@09`' );
define( 'LOGGED_IN_SALT',    '.9:`{-1xWB<uQ!r8 ?=/+wRfL{!fs!-ApeJ#yB]~QwkDyB*7phJnbMFJDw1XkLc!' );
define( 'NONCE_SALT',        ']TFz=L<S11$SWaNA!J&s6-o>-,$G]2UWl51Gt#!&$7vd4z+H@_`M%2%Bjs-jVQj~' );
define( 'WP_CACHE_KEY_SALT', 'LNUw)qmA%pA}mB?C :0s@OQ`G_za,N3_KS!8o,pn%(_AnId~7SG/OAkoB0!c|aAI' );


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