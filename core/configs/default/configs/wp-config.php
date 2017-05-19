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
define('DB_NAME', getenv('DB_NAME'));

/** MySQL database username */
define('DB_USER', getenv('DB_USER'));

/** MySQL database password */
define('DB_PASSWORD', getenv('DB_PASSWORD'));

/** MySQL hostname */
define('DB_HOST', getenv('DB_HOST'));

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
define('AUTH_KEY',         '/yJOVYV<,./Xe J,{uLF59-RsXqeC|gXA;Xev0kogld>)_KmvaEskeTMM67wm)AV');
define('SECURE_AUTH_KEY',  '7h5Wj^Nafo7GU2C$pEf4|+*OfZ05}Bw;`RZbR`#k:ERUeBRkAqD{O@Wk/7jcyn~Z');
define('LOGGED_IN_KEY',    'cbpaj/X^?^7<YmMF-v8 +@:>jeUR8,gF]R(E$XfItH>|Fxi*Nk@}rX+N-:pn5QIw');
define('NONCE_KEY',        'EFGI 1?|NYgT9yeSdiX^IVGkc&#g;7wkTJ&=tj1)3^cnDkc;yfoQXo]fOUJRol9w');
define('AUTH_SALT',        'fl|1{,K_Q27XOGJtM.V^}MF67E4Tj*C_2DI,#rQIO@mz8o][T?!VgL$tow*@apV2');
define('SECURE_AUTH_SALT', 'vDZeGy?/^E~ggx7YDOF-A)U o%zG]9`X|,Z??A{E< UEf~opx9f0mKE tB h*w%)');
define('LOGGED_IN_SALT',   'M>zoa/Anz/R>BGOl|pi6-7]+@gT[;cm1OaJ ,`l&}<B0y4kpG+U;,tbA@X--HGHE');
define('NONCE_SALT',       'fb+gm</{{eOb4aq^-^k7!/J1xx=$C}WMP,(p)jjGS&#mC}e/PV(J,v)`%} N 1J6');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ap_';

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
