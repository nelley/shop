<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info frsom your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'namimoch_shop');

/** MySQL database username */
define('DB_USER', 'root'); // for Local Enviroment
//define('DB_USER', 'namimoch_root'); // for Real Enviroment

/** MySQL database password */
define('DB_PASSWORD', ''); // for Local Enviroment
//define('DB_PASSWORD', '143Nami0016Mochi!'); /// for Real Enviroment


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
define('AUTH_KEY',         'GnT7Z+HI] zUvU?gl*D+75irb<IUe)PodYQ$mJ*!6Gn6NrMK)-1=T^5pLc0CI>_m');
define('SECURE_AUTH_KEY',  'MSe)j~blq#Y|oKuEbkG|OCJjFn{W-9xwV|DOe:24G9c44oBx:|aQjfWHs;#fMD5U');
define('LOGGED_IN_KEY',    'f.g;h<b4+1SFu~gh8CuR0z/J}9/tQW2xu3!^5j47 ~ZnVG^Op#kJ|c_-M-,<2$IV');
define('NONCE_KEY',        'mbeN1@9&mF2$*c:l+t!twAnu9Trp1H)OG%4}~Az[tDdJRxc|c9mtt=yx8Oi>m2DQ');
define('AUTH_SALT',        ';P,>+hc!l3QoSCVYr,_P-BO%p)*l[&5x`wMt=V;,;OHzPxj &l<@&2ATeKDG+-Y^');
define('SECURE_AUTH_SALT', '@x)Biga3;/T/V0)+.@tNLm/)E2,Q_$R_1}l |lUk=aHjIe|_2oGLsYXGSl;RHd=+');
define('LOGGED_IN_SALT',   '`fkH--+Ijj3-Iu@^4ko3N@n`-E_gr:LZl.~.>d+[&5MX+((Dj2nsmL.tqXuKsM_T');
define('NONCE_SALT',       ']t4eYs&Vj?B:C_}Y|# az6XK5+(mt+j4qisO9M)|+V<:iSr@Mqt:Le*ao<f2VV2M');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
