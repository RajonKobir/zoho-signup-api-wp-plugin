<?php 
/**
 * Init Styles & scripts
 *
 * @return void
 */

//  no direct access 
if( !defined('ABSPATH') ) : exit(); endif;

function zoho_signup_api_admin_styles_scripts() {

    wp_register_style( ZOHO_SIGNUP_API_PLUGIN_NAME . '_image_uplaoder_css', ZOHO_SIGNUP_API_PLUGIN_URL . 'admin/css/image-uploader.css', '', rand() );

    // wp_enqueue_style( ZOHO_SIGNUP_API_PLUGIN_NAME . '_custom_style', ZOHO_SIGNUP_API_PLUGIN_URL . 'admin/css/custom.css', '', rand());

    wp_register_script( ZOHO_SIGNUP_API_PLUGIN_NAME . '_image_uploader_js', ZOHO_SIGNUP_API_PLUGIN_URL . 'admin/js/image-uploader.js', array('jquery'), rand(), true );


}
add_action( 'admin_enqueue_scripts', 'zoho_signup_api_admin_styles_scripts' );
