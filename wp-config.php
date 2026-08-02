<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'sunstex' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '@_b5-l=h-8![+5@TfC+Pk5lc(aS)W<H0`sCeN+uJa6!;8~sDpmZo=^l||``XB`41' );
define( 'SECURE_AUTH_KEY',  'R4<W=cqXwCA5s^kB^+z(V)m.v?BqFB8Wo#F-Ltd_:RQ8Pxsq3w#4FJqBzwmWlPDJ' );
define( 'LOGGED_IN_KEY',    '}2kEq_}U!s;7BR:0#|RBR2H;msX^@(sxH],}zOXIQ&7kKKKHQmng(~pREWo21mSr' );
define( 'NONCE_KEY',        'Jco3HI D_QI@{qR*+gO@J6(~s&zt#s7SV/IGTtmy-,XQc]uG{Woc<wweV.2HW?NW' );
define( 'AUTH_SALT',        'Vp@q6<&tEh2I`QEy!Gv$[a{d=-kN5an7U,&AczF:]VDe,.,_`<0lT!`HuL&ik02+' );
define( 'SECURE_AUTH_SALT', '}vSrk9g. =+D8+nr:Q-A@dvF#HGTQZ<UHF|}etfCZqr,~pflcpkZ4wR**UVu<Ms6' );
define( 'LOGGED_IN_SALT',   'Y/pAcCl9k5GN;!3Rk>w|nS`dTmvqfPqM2 4?iL t)K;CU)f&@tV}p<R6o27%e7gk' );
define( 'NONCE_SALT',       '!,$&q47RSHN@P[1SvC0@R]G{elOv?$o-2iPhKJJd)<< !Ck(y:9i%@)DGoa1uB[^' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'st_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
