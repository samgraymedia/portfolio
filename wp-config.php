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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'portfolio' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         'q38if%t;z<~0C^|YfS`]R>X/aUYVLy<I*w,0PrP4$_cdARSE$H0V^ri~-p}]UdYS' );
define( 'SECURE_AUTH_KEY',  '~[6AC7HbFH6b;#bHR1h/$IvNo:T|WB>kGKI4kWmX{;DrHzJN]th{{DZUX6L>!_.9' );
define( 'LOGGED_IN_KEY',    'WFU@C)8.$T8?XVEC+BaV-8+.8Lo).8wYo47Zq<!lrc)fqiGR+ORV!:}M`?Px=xB}' );
define( 'NONCE_KEY',        'u+!)<?@/;Ky(i:>6bx=E.iSy-*9>$s@|5qhj0t^qaaDs/x|D t=W|iQMJ*r?e}Rw' );
define( 'AUTH_SALT',        '[~4TC^hY<9Qykm]$|z31 1^OK*CKo%A-@Ta~Ko6bYAb$tWm|8~,^cZ~I%7J7jl~ ' );
define( 'SECURE_AUTH_SALT', 'JA[S*w7<8.ua2(88DP1G+SQgyY?U0`P&lCNnM,d==cemi/yxm$rHX`@V=lLRr*ML' );
define( 'LOGGED_IN_SALT',   'c,CZE+DIXX.w67;}-<[U`5;P?iS)BOAGw/o7e,mz+4u45@`vV1j|utoE:nae@*+L' );
define( 'NONCE_SALT',       '+B0kp^y|^u+,F}bJNtAy*J;!Hn5TD[JPK4RTH/HV:Vs@TIVTqC6PhZP0xQ7:LPIw' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */
	define( 'ACF_PRO_LICENSE', 'b3JkZXJfaWQ9MTQ1NjQyfHR5cGU9cGVyc29uYWx8ZGF0ZT0yMDE4LTExLTI0IDIxOjUzOjU0' );


define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', true);


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
