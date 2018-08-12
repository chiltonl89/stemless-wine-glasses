<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'feathet9_wor3');

/** MySQL database username */
define('DB_USER', 'feathet9_wor3');

/** MySQL database password */
define('DB_PASSWORD', 'Zr9Ynw7v');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'kD3Ji:;Pw,GR:c-k7Ufz<I! :}f/|@,n([3U-/UJ&Ved,Gs|4)+J`1@uL[V+hJm;');
define('SECURE_AUTH_KEY',  'oiF#)qI ]&jD-o.y.i$*]41T ^z(u?iQKfOOnS^!~i{^4} An{)ef d,e(NpP=7S');
define('LOGGED_IN_KEY',    '1NwVY2wUC3BzA|fcA13=?LiwE)XNQm7{/bVZ)dCEsK-30Qk*o`8fYEi&)@zu)k7x');
define('NONCE_KEY',        '3|okd|.T1q+YXy`+Z+Ti%y)zkN[wH0fU)tXo`s+U_]3tsXO1s4kzS=)yP8||D[Z?');
define('AUTH_SALT',        '.P^/uUqw0^;>j0_*w.!27sa9oRn;7a6,gb7F&q!|9bDuFAp:`!_}X$_:ejQE_oV,');
define('SECURE_AUTH_SALT', 'sfvE)=TG$@;G$Nc_hO}<Dt<R<#V$iTP1/?)l[IbQxpU]s>f&w16:0ahH38z}P-IK');
define('LOGGED_IN_SALT',   '0HDL VVEWxX#(-p~qg@?iM(1bm0#>&%mcCOXET$VG5(bi0 iQy=R!p0z,TxCu m(');
define('NONCE_SALT',       '|5efS ii-F++l.r|by ~rn+~k)53qWIhE?P|xK /n1f;j2)1pF8Q;Z[+Fxa:|{@V');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'laq_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

define( 'AUTOSAVE_INTERVAL', 300 );
define( 'WP_POST_REVISIONS', 5 );
define( 'EMPTY_TRASH_DAYS', 7 );
define( 'WP_CRON_LOCK_TIMEOUT', 120 );
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
