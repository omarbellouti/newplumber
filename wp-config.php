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
define('WP_CACHE', true);
define( 'WPCACHEHOME', 'C:\xampp\htdocs\lam\wp-content\plugins\wp-super-cache/' );
define( 'DB_NAME', 'lam' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define('AUTH_KEY',         ')5N%z5(PKK+P-]>S%|.H&>2k)9|0Cs_ewSl-_?:/](:3<r610+g|HGJ4gnWg+e$A');
define('SECURE_AUTH_KEY',  '[F6=-E*NX+/jQ<@9x8|P&[[Q#T-L@A}GM/]G[lZ$/08Fw9J|~+>Zt:%C*CxjT(>K');
define('LOGGED_IN_KEY',    'e|ndT[9 &d#g-G{INlyd<gvbx+piG]e6C<q!q^}dK:l-vfr4sGvB||sn3b5|B_Ti');
define('NONCE_KEY',        'K;)Wozp#:Xjj]SawM7!!K((*jFTwIe7`+wY*NU6:0Zjg46+px!+|RcHvlbGDR4Jy');
define('AUTH_SALT',        '^^=HUxj3+Iz<-O[ws6UNaWu[4A~@35,@Bfnj$t*vAm+UBdqd6sRZf0eQb|VG@D|N');
define('SECURE_AUTH_SALT', '$e#Tv<>is[V^#5SKU5v_Esk0`K%-lXr^:o2,Cki R>i_@n$ur%P!3sqRS{zbVC#b');
define('LOGGED_IN_SALT',   'f*T3SCA6k#wQYhY_O<x&Y3_.%&e6Dgj+0JQeD=C;+#.K_$j}EdW_mcak?YlAfi-K');
define('NONCE_SALT',       'C_7PxovnhYxB..l#ra_jz>Bg+h+1&AGhdm{/Veq]reO7: 09J`Z@otnsk+{Q=F0V');

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
