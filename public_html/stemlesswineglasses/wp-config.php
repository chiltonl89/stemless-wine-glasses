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
define('DB_NAME', 'feathet9_wor2');

/** MySQL database username */
define('DB_USER', 'feathet9_wor2');

/** MySQL database password */
define('DB_PASSWORD', 'DSXZs2x7');

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
define('AUTH_KEY',         '5C;+r8m3lkqt,c@}2}H_m&@SI]$2xQX#jaGI+W^^so[T=jeQbwo6YiWlWITMZAq>');
define('SECURE_AUTH_KEY',  '>=,tq7c^(Wd$l40Llp.b6YB5ARc)p6u+@lYqwj*)_fjjH4?Mww(|(pQY6[4RCgw|');
define('LOGGED_IN_KEY',    '(GS q;sphdQXGCcw-uYc5[$RI~+f&0w6[,*Ta^?cq^#RFkwM^&o|vQV9K*b+oux!');
define('NONCE_KEY',        '4Q8 [l~`C:rC::6}>n.I26~_[zz.Y,![ycw9/&Y-ROt0qg=59%oPlbg:Z)W45er8');
define('AUTH_SALT',        'xLyZ>D_+GeKeS4O/i|(lEoK*${|Omk3pnSd~w9;9#]&p+ku^T5.bkmr2~L4.?u{9');
define('SECURE_AUTH_SALT', 'i0Rk?|DUVF!V^le}Mj(($yF1*9Cre2t -zwvAYOR3TYk31^;^)1r0N+TxF{,I/;2');
define('LOGGED_IN_SALT',   '%oVsH,[`[dn o(V+k0j1[rE&|^2g|X|)nLQ(d2=yGx/3]y*fj^],lJ|4Hzyyz+|o');
define('NONCE_SALT',       'WL|wJoH~h93EnL-I{>:{~(g0P-(IEY`-i.laf6cSqe7[V)1KY`B}=,>>^D[-$648');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'nzt_';

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
