<?php
/*
Plugin Name: Zoho Signup API
Description: Zoho Signup API used as a shortcode.
Version: 1.0
Author: Rajon Kobir
Author URI: https://github.com/RajonKobir
*/

//  no direct access 
if( !defined('ABSPATH') ) : exit(); endif;

// Define plugin constants 
define( 'ZOHO_SIGNUP_API_PLUGIN_PATH', trailingslashit( plugin_dir_path(__FILE__) ) );
define( 'ZOHO_SIGNUP_API_PLUGIN_URL', trailingslashit( plugins_url('/', __FILE__) ) );
define( 'ZOHO_SIGNUP_API_PLUGIN_NAME', 'zoho_signup_api' );

//  is admin
if( is_admin() ) {

    // add admin css and js 
    require_once ZOHO_SIGNUP_API_PLUGIN_PATH . '/admin/admin.php';

    //  add settings page 
    require_once ZOHO_SIGNUP_API_PLUGIN_PATH . '/inc/settings/settings.php';

}

//  add shortcodes
require_once ZOHO_SIGNUP_API_PLUGIN_PATH . '/inc/shortcodes/shortcodes.php';




?>