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
define('DB_NAME', 'usdevexpets_DB');

/** MySQL database username */
define('DB_USER', 'usdevexpets_usr');

/** MySQL database password */
define('DB_PASSWORD', 'k7by}#$<WZz');

/** MySQL hostname */
define('DB_HOST', '10.255.255.22');

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
define('AUTH_KEY',         'bDy{?pyR?RF|U;OAoj)=.#Ox:iEIs@_scH bQyVEN~W-$htF@#iTb5*U>CwiL+fi');
define('SECURE_AUTH_KEY',  'uV~ty)!L-Cr/+]p><:/Azfm.73zP~3ndI+6HEJ e{;BBB&|0qJFcj|OI#[yZ+#GZ');
define('LOGGED_IN_KEY',    '0$]Z.8~-hXA/u7I;IU[W9U(1Rlc6j|9>&nFUf;9|gN,yAHT-yccS6RUTGS]2>L~C');
define('NONCE_KEY',        'NK@l/$irudls+ap]O*H|oxW[R$XteiD1zm/ `::UVb(l,WpgvDm6G%$C]l.eY^Eb');
define('AUTH_SALT',        'iH?2dnsk5IGt9$+@hTY9(A|y&K2.p1%C9)Z.8kw92-EyD>PUhbp*<>Oo(x>rQnKi');
define('SECURE_AUTH_SALT', 'uRBo#F?ML`tXn=n?ZB-+T$H_?iK+YeQO+{s<a|~xUm)k^GmHV+j|<y r}Y,ESc&E');
define('LOGGED_IN_SALT',   'creg&wa}-zl7%M0H5!mO;KAuk{J;+_6L+w{{-}sX+Unlp;1c*Noq<%m.S768aCiz');
define('NONCE_SALT',       '*D(t(x|2ZK_}q0+emnTX KUJ?X~0mL-[Q$Cpg$Xr8>7WSd|?tIF!sR@`[i|-a%1v');
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

define('WP_DEBUG_LOG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
