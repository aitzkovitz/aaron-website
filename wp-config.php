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



define( 'DB_CREDENTIALS_PATH', dirname( ABSPATH ) ); // cache it for multiple use
define( 'WP_LOCAL_SERVER', file_exists( DB_CREDENTIALS_PATH . '/local-config-aaronitzkovitz.php' ) );

date_default_timezone_set('America/New_York');

/**
* Load DB credentials
*/

if ( WP_LOCAL_SERVER )
    require DB_CREDENTIALS_PATH . '/local-config-aaronitzkovitz.php';
else
    require DB_CREDENTIALS_PATH . '/production-config.php';


/**
* Authentication Unique Keys and Salts.
*
* Change these to different unique phrases!
* You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
* You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
*/

if ( ! defined( 'AUTH_KEY' ) )
	define('AUTH_KEY',         'p56.Mf<Q-*2a*+&9-~K6)J#8h)LDVoPQ8|y^88wJ;#nv0silA_j@ZM#Bz7wS>_*K');
if ( ! defined( 'SECURE_AUTH_KEY' ) )
	define('SECURE_AUTH_KEY',  '2_;#V59]PUz~E:2zOQ=j +M+-i2hRjYW?E{Fc$7MT)]:=<4Im,z#|-S?m&t+cm*0');
if ( ! defined( 'LOGGED_IN_KEY' ) )
	define('LOGGED_IN_KEY',    'D|I4<mtx.Ie1my-R%1D<^U>WYFwf6Ej3?9$|!a&hqN{#ndYQg|4mIg0_l2dPw98^');
if ( ! defined( 'NONCE_KEY' ) )
	define('NONCE_KEY',        ',kA!|q?+s!N<I<Q3$/LqsWF<ByGsj8pUc4&8.Cv:V+$Qi{BX?}G3mK+x-UeAO~#%');
if ( ! defined( 'AUTH_SALT' ) )
	define('AUTH_SALT',        '0:07&^A?z6WR!1%p[H?D~(*)3517<~Vo[-oq!6{tm%`8{,xc$SH#?sQ%D+Y8oDVY');
if ( ! defined( 'SECURE_AUTH_SALT' ) )
	define('SECURE_AUTH_SALT', '=R4[=z,eIDSu8S9;UstQe.lgNvGo6{kb,!kMEy,#|JP%=l&n6`J?#%hXMj16]CxT');
if ( ! defined( 'LOGGED_IN_SALT' ) )
	define('LOGGED_IN_SALT',   '!eV/ F/,yykE[_/mv9 +(_H:G%*6 `(=],s--j_((Z@gm_ X-U;[2RFdo.gW|tk!');
if ( ! defined( 'NONCE_SALT' ) )
	define('NONCE_SALT',       'EQI+(9Wka%MEj=nV)%%^ze?kr0[mGj|zk7^/d-0tJH`Tu(^5sG.=bc8KVa[kt;7g');


/**
* WordPress Database Table prefix.
*
* You can have multiple installations in one database if you give each a unique
* prefix. Only numbers, letters, and underscores please!
*/

$table_prefix = 'wpfp_';

/**
* WordPress Localized Language, defaults to English.
*
* Change this to localize WordPress. A corresponding MO file for the chosen
* language must be installed to wp-content/languages. For example, install
* de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
* language support.
*/

define( 'WPLANG', '' );

/**
* For developers: WordPress debugging mode.
*
* Change this to true to enable the display of notices during development.
* It is strongly recommended that plugin and theme developers use WP_DEBUG
* in their development environments.
*/

if ( WP_LOCAL_SERVER || WP_DEV_SERVER ) {

    define( 'WP_DEBUG', true );
    define( 'WP_DEBUG_LOG', true ); // Stored in wp-content/debug.log
    define( 'WP_DEBUG_DISPLAY', false );

    define( 'SCRIPT_DEBUG', true );
    define( 'SAVEQUERIES', true );
	
} else if ( WP_STAGING_SERVER ) {

    define( 'WP_DEBUG_DISPLAY', false );
    define( 'WP_DEBUG_LOG', true );

} else {
	
    define( 'WP_DEBUG', true );
    define( 'WP_DEBUG_LOG', true );

}


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');