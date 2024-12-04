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
define( 'DB_NAME', 'tts-web_demo01' );

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
define( 'AUTH_KEY',         ';(DR&6Oo22?$nD9^D4]faoYBt=Cx~Kr/81y2gwl*`JyI9&zgAzY&9tHtEEj]Img+' );
define( 'SECURE_AUTH_KEY',  '>,xjr-)i6|q:|8dA|Qg}=md^TdU6D6g`|.Q?%%U_{8=<VC!!{IY<izmD4a^CVf>X' );
define( 'LOGGED_IN_KEY',    '+{V_0Yjz^/@v}N-[E/U%rCX4BL#fDR`8Agl:=fT2,*7OKLB&9W#q6>pE=yc<ZMlN' );
define( 'NONCE_KEY',        'zpAdwCd=/lO-.m$kehNAVJV^wT*_>)bn8F}%-wIw}r$<fVx1NtZ{WSU8{@WW%Nx ' );
define( 'AUTH_SALT',        'c3a@]Y^cH^m8~s&.?FxJ&95 WS1bi8I]B)X9xJh@Nw!,V%n8A5!993#_<_`6Xf P' );
define( 'SECURE_AUTH_SALT', 'FcHN~U+3Ex]$Sb)kG66j6`Na=<PC`b6b%i)TN.W53m7e9^iY9Ql^BB:d wVwM(lQ' );
define( 'LOGGED_IN_SALT',   'LqRkT0#]._MTXG*o_IVGE L|bT)(zGfy;aKl%B,pmsjKf3Jn:c9,&yD~,Pq7zy$m' );
define( 'NONCE_SALT',       '6M%to$&CxOHxM]`{B7zdM<]us%26XA9lDS;r0]q*Yi6f@U^Dpilq7ou!M^@l&0(4' );

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
