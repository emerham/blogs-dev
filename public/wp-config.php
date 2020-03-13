<?php
// Stolen shamelessly with some modifications from Mark Jaquith's WordPress
// Skeleton project: https://github.com/markjaquith/WordPress-Skeleton

// Load composer autoloader if it's available
if ( file_exists( __DIR__ . '/../vendor/autoload.php' ) ) {
	include( __DIR__ . '/../vendor/autoload.php' );
}

// ===================================================
// Load database info and local development parameters
// ===================================================
if ( file_exists( __DIR__ . '/local-config.php' ) ) {
	define( 'WP_LOCAL_DEV', true );
	include( __DIR__ . '/local-config.php' );
} else {
	define( 'WP_LOCAL_DEV', false );
	define( 'DB_NAME', '%%DB_NAME%%' );
	define( 'DB_USER', '%%DB_USER%%' );
	define( 'DB_PASSWORD', '%%DB_PASSWORD%%' );
	define( 'DB_HOST', '%%DB_HOST%%' ); // Probably 'localhost'
}

// ===========================================================
// No file edits unless explicitly allowed in local-config.php
// ===========================================================
if ( ! defined( 'DISALLOW_FILE_MODS' ) ) {
	define( 'DISALLOW_FILE_MODS', true );
}

// ========================
// Custom Content Directory
// ========================
define( 'WP_CONTENT_DIR', __DIR__ . '/content' );
define( 'WP_CONTENT_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/content' );

// ================================================
// You almost certainly do not want to change these
// ================================================
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

// ==============================================================
// Salts, for security
// Grab these from: https://api.wordpress.org/secret-key/1.1/salt
// ==============================================================
define( 'AUTH_KEY',         'x(^|95+=wYmx-^Z/p&ma6p|i%~|- 7;lL?%Q@$rZeU[P<|o3-aT]`#(vZL@/PXp*' );
define( 'SECURE_AUTH_KEY',  ';dUA;*e<H%KJCR+2JZakk:AfVi+|GU/&eV7K 89CW{~t{<]yiyf[Y%?mc<-3;^?D' );
define( 'LOGGED_IN_KEY',    'aiD:W$6vR]m,@z^ER|*Gc[9!O:=EUk1;Kh#HKTwBZ3)m_|.^?K=#q1($)W6m%QzD' );
define( 'NONCE_KEY',        '+?NIWDNNrr_xkilr@r@3{0N=-mL9!;!uhb-$]jC0K.NaV`zfaKdLjuM1@gjU>kh.' );
define( 'AUTH_SALT',        'VMLRW[^n8W<7DD$1uw@6*AI5JJr>9?q+g761RjsJ5M5n7t<V@{uOO>z-_BE*HlGa' );
define( 'SECURE_AUTH_SALT', ' z|2+*&8h.^Pk-~1$$qT-F`kce@dh(#Q-r}9k+=r`|c3RB#U_;WL1%X#Q#ezY5(t' );
define( 'LOGGED_IN_SALT',   'zTmMUwIQN+;HWZ5<Vsgxz(XdxuRn93m:@{N>fXV1H.2|m)FVe%-;<+0E_1Q.<DN%' );
define( 'NONCE_SALT',       '2dDIX-mSb=hnTM+,E3z=0-S+npmMJMZy|h?A&[l+IHxIJ8C;hcM767!FFW4nnU{i' );

// ==============================================================
// Table prefix
// Change this if you have multiple installs in the same database
// ==============================================================
$table_prefix = 'wp_';

// ================================
// Language
// Leave blank for American English
// ================================
define( 'WPLANG', '' );

// ===========
// Hide errors
// ===========
ini_set( 'display_errors', 0 );
define( 'WP_DEBUG_DISPLAY', false );

// =================================================================
// Debug mode
// Debugging? Enable these. Can also enable them in local-config.php
// =================================================================
// define( 'SAVEQUERIES', true );
// define( 'WP_DEBUG', true );

// ======================================
// Load a Memcached config if we have one
// ======================================
if ( file_exists( __DIR__ . '/memcached.php' ) ) {
	$memcached_servers = include( __DIR__ . '/memcached.php' );
        define( 'WP_CACHE_KEY_SALT', 'dev_blogs-' );
}

// ===========================================================================================
// This can be used to programatically set the stage when deploying (e.g. production, staging)
// ===========================================================================================
define( 'WP_STAGE', '%%WP_STAGE%%' );
define( 'STAGING_DOMAIN', '%%WP_STAGING_DOMAIN%%' ); // Does magic in WP Stack to handle staging domain rewriting

// ===================
// Bootstrap WordPress
// ===================
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/wp/' );
}
require_once( ABSPATH . 'wp-settings.php' );
