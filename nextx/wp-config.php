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
define( 'DB_NAME', 'nextx' );

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
define( 'AUTH_KEY',         '3#j60Kjyq$S%]K7vI~L]lr,Y04sq=$%t|@-33mXk^,65.A0mami(oM$p_O BAkY,' );
define( 'SECURE_AUTH_KEY',  ']O(648)}M>Empv)yWPAs#o&;!+g i~@#s:dL<Hd*70>MM6K,`F*tQ94p8gQ9,jk7' );
define( 'LOGGED_IN_KEY',    'mVlWv<mx,=)bA`yhd30#!TYR#FnYfl$BrF{Y%8k)EJQZ03D pj5jkkiX}BtleTbn' );
define( 'NONCE_KEY',        'zfi>*1wWD]#M[3j.=rMU4c _}U/+2re-1vSkwn1IN~r$UKB96N*N^j_U ^xR?YOY' );
define( 'AUTH_SALT',        'EUL0E:uBs`gb?cO@)]>8FkpX=WpbfJH Fu+pFA;[< bfImL0N,Rv{5VI{!~;4.]`' );
define( 'SECURE_AUTH_SALT', 'Ez6-$6Ael]r_hL@R{HckD,MYL8|@nGv&dz%Qu@,)UZ0OSutx3r$=9^eFEMI2VW0:' );
define( 'LOGGED_IN_SALT',   '-){]D A@z&>(i]d+!J66!-~u!uB4A~yZ?YjL5KSP^Z],p$;X+OHk[6+=-GAnzx=e' );
define( 'NONCE_SALT',       'mLS(?ZhNu*#X`Kl{r}X[;=)+D|;yF*rEGaW,kmduS?_y9Zw,p_z]EB3),,!zUcj.' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_next';

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



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
