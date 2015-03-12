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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'stages_wordpress');

/** MySQL database username */
define('DB_USER', 'stages_wordpress');

/** MySQL database password */
define('DB_PASSWORD', 'p@ss3nGer');

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
define('AUTH_KEY',         'j)(RVqY2v.<! }|s??1-58gm8Qx>z0`)-g++f*#O1+sq]K_5ka{k5iqwik(6u.r[');
define('SECURE_AUTH_KEY',  'q|_QLudOl0(-j+4w`J%?+o-*lDlI/4G%9P2*>Bb;5Q_%o*mI{hDok(_h6>z+pAvO');
define('LOGGED_IN_KEY',    '}ayJbPpr|53>%:#QFEFI,pf+Gzs^,)bZdLnpDE)9iI~&:{|H|&E@hnL9hM+<CAWy');
define('NONCE_KEY',        '`rOjIQ%-E1Th8eYA&-&ZUA;x{zBh0(D>L<leY3R0}OP,{MIZRWz-42-s|rP_ex#.');
define('AUTH_SALT',        'WF9L|3:Ve+]rdAHt=zWW{4.d-m{/h 0_@KGfBE8y$YS0iHXWA:)VQqlE 8Z3HajQ');
define('SECURE_AUTH_SALT', 'W7C@~ntgf?O-;m``|~@ Htej;/(?L;IH-TA(iXwHNjB^~>*:,|p3R`rc0M8>E[+e');
define('LOGGED_IN_SALT',   '6_H3L{*$[PRHy;Jo|Kkj ,.ocz0 k;hRs[Vt1 w|Qsg]qb[m Kbck`;(2q5]QMHV');
define('NONCE_SALT',       'tPb7TD4a-V!4=TlJ2/:w(hF<7qt`C-MLQB+,>HP+k/ xMF]BL~jC;AXh#|F 7,Xa');

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
