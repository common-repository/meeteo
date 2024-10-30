<?php

/*
*		Plugin Name: Meeteo
*		Plugin URI: http://meeteo.io
*		Description: Display upcoming webinars, available services on any post or page. Use widget or shortcode to display information.
*		Version: 1.1.1
*		Author: Bikesh maharjan
*		Author URI:  http://bkesh.com.np
*		Text Domain: meeteo
*		Licence: GPL2
*/

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'MEETEO_PLUGIN_SLUG', 'meeteo' );
define( 'MEETEO_PLUGIN_VERSION', '1.0.0' );
define( 'MEETEO_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'MEETEO_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'MEETEO_PLUGIN_ADMIN_ASSETS_URL', MEETEO_PLUGIN_DIR_URL . 'assets/admin' );
define( 'MEETEO_PLUGIN_FRONT_ASSETS_URL', MEETEO_PLUGIN_DIR_URL . 'assets/frontend' );
define( 'MEETEO_PLUGIN_VIEWS_PATH', MEETEO_PLUGIN_DIR_PATH . 'includes/views' );
define( 'MEETEO_PLUGIN_INCLUDES_PATH', MEETEO_PLUGIN_DIR_PATH . 'includes' );
define( 'MEETEO_PLUGIN_LANGUAGE_PATH', trailingslashit( basename( MEETEO_PLUGIN_DIR_PATH ) ) . 'languages/' );



// the main plugin class
require_once MEETEO_PLUGIN_INCLUDES_PATH . '/MeeteoIgniter.php';

add_action( 'plugins_loaded', 'Meeteo\WPApi\MeeteoIgniter::instance', 99 );
register_activation_hook( __FILE__, 'Meeteo\WPApi\MeeteoIgniter::activate' );
register_deactivation_hook( __FILE__, 'Meeteo\WPApi\MeeteoIgniter::deactivate' );
