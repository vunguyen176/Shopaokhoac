<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'congvu');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '8[L@$Ti*.gH%R2huOnGSzx 3LL&(bqDWsK2R[Yn>LuO[+e&ez<9I`}qf_-ftb4R0');
define('SECURE_AUTH_KEY',  '6?)Wd0<nX|0V?X4i!gf7~OE8fl<Q88A6#h@}s9_ecGX{n3Z%KcO:>8h 9`Yz}|39');
define('LOGGED_IN_KEY',    '@j*)Xgs4SY%9cNi&VmUAG%6@UN4R9+@a$0luLnS9.f elpX2tJpzP+gj6iU~I|,7');
define('NONCE_KEY',        '%:X~]p>}N3g7*!_oD$u}f/2jbt*{FF^/XU5XmhIqKU!q=1RWr89YJ7Q,dUXa}3E,');
define('AUTH_SALT',        'M&>4MD|o21.tag%z9/Uq1zrzAv6_-P^d^!j=2bc%3v*j&%duTj@pBh@zJIsGJIAJ');
define('SECURE_AUTH_SALT', '%F=>)XQIIC7wrb(tO11|RxiC%X.r62w4C:ms1Ec@Zvy.C|{0rU+9Q,LcLo6%DZB9');
define('LOGGED_IN_SALT',   '1]:GyiL=cg>z95V04_ZH=z~<O=@:onJu_~)_Y)hR6It)0>ihVaX`W=))OC?^tM$}');
define('NONCE_SALT',       '7mP6H#}yX+[Z~=vTyt;8gk[ow9lo1&/XXc!-?HT_n8y(5^y?h? W[pfL#jQv~;RK');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
