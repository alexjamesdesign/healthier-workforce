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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'iamsiuk_healthierworkforce_production' );

/** MySQL database username */
define( 'DB_USER', 'iamsiuk_healthierworkforce_user' );

/** MySQL database password */
define( 'DB_PASSWORD', 'uccfzu9kHwJ8fd' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '+G18wkHR?$jEDz5_RO07,lx1@B0C<`0S/v0I}/uESEbmoyBJ&$a:V9>4xlG_vYrE' );
define( 'SECURE_AUTH_KEY',  'R+mHza@[STmAkvx:c.iNLN(1cDu+P?n~_QL[(2Lwma*n=ivEP}qE|Q&SHorEa4K+' );
define( 'LOGGED_IN_KEY',    'LwyRA et~S~${C)Ir`XkzjaH^3XTYuGMrK}19;CrgY66wgSQacwWYq19bgJ@4c+M' );
define( 'NONCE_KEY',        'd.&#bP.PCZA1&[+4BThL #euWH@iJJQr]~W%_YxOEw|&x:a1oIL>tc,dL)[&R~z2' );
define( 'AUTH_SALT',        'W^D,42{3kx yM1B28p]?MRtepLT}gr`$1*BpHdusK21zCGE3LY1v(N!Vd>8p}`!-' );
define( 'SECURE_AUTH_SALT', 'rsqf4eleo@u9uspL4GRNUw]NOq]|9[-5eh-~4RBl,{aUf:dgiDZ,b7I&nwA BY/g' );
define( 'LOGGED_IN_SALT',   ' ~b3s4iYJ`JWgYA0KvDN!BtZjHFYm^7pe<i !^yZ8:9#bD5s[wMzw{E)S5m$Lia1' );
define( 'NONCE_SALT',       'yQ8w*%^c,sT*f;J|P4,GVXWgHJ5;-bGwhN:5,?a~&NoBBDxn8/EOM9f0ee&L !#g' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'adtrakwp_';

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
