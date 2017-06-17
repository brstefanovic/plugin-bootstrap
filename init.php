<?php

/** Global Variables */
define( 'PLTMP_REQUIRED_PHP_VERSION', '5.4' );
define( 'PLTMP_REQUIRED_WP_VERSION',  '4.4' );
define( 'PLTMP_REQUIRED_WP_NETWORK',  FALSE );
define( 'PLTMP_PATH'               ,  dirname(__FILE__));
define( 'PLTMP_SLUG'               , 'plugin-bootstrap/plugin-bootstrap.php');
define( 'PLTMP_URL'                ,  plugin_dir_url( __FILE__ ));
define( 'PLTMP_DEBUG'              ,  FALSE);
/** Global Variables */

/** Define Global JS/CSS */
$PLTMP_GLOBAL  = array(
	'JS'  => array(

	),
	'CSS' => array(

	)
);


/** Turn on error reporting if debug is on */
if (PLTMP_DEBUG) {
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
}

/** Include all dependencies */
$files = glob(PLTMP_PATH.'/inc/PLTMP_*');
foreach($files as $f) { require_once ( $f ); }
/** Include all dependencies */

/** Start the plugin */
if ( PLTMP_Helper::verifyRequirements() ) {
	PLTMP_Init::init();
} else {
	add_action( 'admin_notices', function(){
		global $wp_version;
		require_once(PLTMP_PATH . '/pages/notices/requirements-error.php');
	} );
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	deactivate_plugins( PLTMP_SLUG );
}