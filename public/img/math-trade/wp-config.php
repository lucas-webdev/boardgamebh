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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'bgbh_com_br');

/** Database username */
define('DB_USER', 'bgbh');

/** Database password */
define('DB_PASSWORD', 'Bgbh2023#');

/** Database hostname */
define('DB_HOST', 'mysql.bgbh.com.br');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

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
define('AUTH_KEY', 'X(jLuO5KkOf?cs8I_[(`P`tN>VPfd@<?');
define('SECURE_AUTH_KEY', 'FZ5AmsjU(-^!PcU J@*aq%J=R0qPnkW$');
define('LOGGED_IN_KEY', 'N>_(bOaSo[HMH4kT8]DJO*QkV:g?OZ(f');
define('NONCE_KEY', '7e[y O}MFFb3*>XIv/!K&}aTYW,1mV=K');
define('AUTH_SALT', 'Ez$8Kn3dM1}[bW]LYkZiT5*r!>O,,}4#');
define('SECURE_AUTH_SALT', ':@F5XXka.l_b,b?hu7ecCrY:$8taxlKU');
define('LOGGED_IN_SALT', 'JepTBA8l#U!-NYslCH`wYj(pHf{X3S,n');
define('NONCE_SALT', '44u6jEkF{k8g*t_<1*kf/+g3|-lP!<fw');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wptask_';

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
define('WP_DEBUG', false);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (! defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

if (! defined('FS_METHOD')) define('FS_METHOD', 'direct');
