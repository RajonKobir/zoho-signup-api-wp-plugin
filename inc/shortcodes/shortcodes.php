<?php

//  no direct access 
if( !defined('ABSPATH') ) : exit(); endif;

/**
 *  WordPress Shortcode
*/

// including the function file
require_once 'zoho-signup-api.php';

// Register the shortcode
add_shortcode('zoho_signup_api_shortcode', 'zoho_signup_api_function');

