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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'webadmin');

/** MySQL database password */
define('DB_PASSWORD', '!l1k3r0cks');

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
define('AUTH_KEY',         '3hq`_,}8ag,?*DY.pArcm>#NjIrOUg5?4!#cnDw|&W?^!<y$|IWV+xA!kL3(Y-[,');
define('SECURE_AUTH_KEY',  'KIL xEA)>lST`3o/mjE^abTbeU%`e&0HgYaX;}f@?/%rX(tpQ]=}kS>_fj:B5cP[');
define('LOGGED_IN_KEY',    '_I$nt_JB&h./M:/o+?V*g;1I;4?7y7Th/!1=uB,STaIo3nU]wP84~}Fo.uM0-.o9');
define('NONCE_KEY',        ';>:i5f#RMN5UA1^ka74HlD65Kvt}h*LnM^v}!A230C58=?SllP/Gn1OhXE$.lG[s');
define('AUTH_SALT',        'Xo2C@2`+3O$kk{Hn8IjY48P0++]PEH%//TkB3}[: UB6pR.>5;.PlOY+D)vF,R0V');
define('SECURE_AUTH_SALT', 'Us3!NMp?>O{ZBg{+V/^{IA859 O(zSMC^UWZXjVc7^j!8}[U;:@5@;N, cSfsxz9');
define('LOGGED_IN_SALT',   'S(dmeCj>74kvQJXahay0kK?AQ#OzcjTf.xV]tC6n! S+M8gD&N8?>g@:>_TET>>B');
define('NONCE_SALT',       '}1vTHPWVvc+[sV]Lc3 _O0%~OhbBN}lDTJ5lfz-AS7^kj5A:[%J^f+O2DOnC^n*i');

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
