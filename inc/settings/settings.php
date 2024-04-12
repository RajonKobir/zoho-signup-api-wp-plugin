<?php 

//  no direct access 
if( !defined('ABSPATH') ) : exit(); endif;

/**
 * Create Settings Menu
 */
function zoho_signup_api_settings_menu() {

    $hook = add_menu_page(
        __( 'Zoho Signup API', ZOHO_SIGNUP_API_PLUGIN_NAME ),
        __( 'Zoho Signup API', ZOHO_SIGNUP_API_PLUGIN_NAME ),
        'manage_options',
        ZOHO_SIGNUP_API_PLUGIN_NAME.'_settings_page',
        'zoho_signup_api_settings_template_callback',
        'dashicons-rest-api',
        10
    );

    add_action( 'admin_head-'.$hook, 'zoho_signup_api_image_uplaoder_assets', 10, 1 );

}
add_action('admin_menu', 'zoho_signup_api_settings_menu');



/**
 * Enqueue Image Uploader Assets
 */
function zoho_signup_api_image_uplaoder_assets() {
    wp_enqueue_media();  // loading necessary js for uploading
    wp_enqueue_style( ZOHO_SIGNUP_API_PLUGIN_NAME . '_image_uplaoder_css');
    wp_enqueue_script( ZOHO_SIGNUP_API_PLUGIN_NAME . '_image_uploader_js' );
}




/**
 * Settings Template Page
 */
function zoho_signup_api_settings_template_callback() {

    // installing bootstrap
    echo '<link rel="stylesheet" href="' . ZOHO_SIGNUP_API_PLUGIN_URL . 'inc/shortcodes/includes/css/bootstrap.min.css">';

    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

        <div class="row">

            <div class="col-md-12">
                <form action="options.php" method="post">

                    <?php 
                        // security field
                        settings_fields( ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page' );

                        // save settings button 
                        submit_button( 'Save Settings' );

                        // output settings section here
                        do_settings_sections(ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page');

                        ?>

                        <div class="text-right" style="text-align: right;">
                        <?php 
                            // save settings button
                            submit_button( 'Save Settings', 'primary', '', false );
                            ?>
                        </div>

                </form>
            </div>

            <br>
            <br>

            <div class="row" style="margin-top: 50px;">
            <div class="col-md-12 text-center mt-2">
                <h4>
                    Shortcode: [zoho_signup_api_shortcode]
                    </br>
                    Note: If you see any problem, please update the API credentials correctly.
                </h4>

                <h6>Default Parameter Values:</h6>
<pre>
    'font_family' => 'Roboto',
    'font_color' => '#000',
    'form_title_text' => 'SignForm signer information',
    'form_title_text_align' => 'center',
    'form_title_font_size' => '1.5rem',
    'form_title_font_weight' => 'bolder',
    'form_title_margin_top' => '5rem',
    'form_title_margin_bottom' => '1rem',
    'form_sub_title_text' => 'Please enter your name and email details to start signing',
    'form_sub_title_text_align' => 'center',
    'form_sub_title_font_size' => '1rem',
    'form_sub_title_font_weight' => 'bold',
    'form_sub_title_margin_bottom' => '2rem',
    'form_name_input_label' => 'Name',
    'form_email_input_label' => 'Email',
    'form_agreement_text' => 'Agree to terms and conditions',
    'form_submit_button_text' => 'Submit',
    'spinner_image_margin_top' => '7rem',
    'spinner_image_width_percentage' => '50', // only put the value of the percentage
    'iframe_min_height_before_load' => '50rem',
    'iframe_min_height_after_load' => '1800px !important',
</pre>
            <h4>Example Use:</h4>
            <h6>[ zoho_signup_api_shortcode form_title_margin_top=&quot;100px&quot; spinner_image_margin_top=&quot;2rem&quot; font_color=&quot;green&quot; ]</h6>

            </div>
            </div>



    </div>
    <?php 
}




/**
 * Settings Template
 */
add_action( 'admin_init', 'zoho_signup_api_settings_init' );

function zoho_signup_api_settings_init() {

    // Setup settings section 1
    add_settings_section(
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_section',
        'Zoho API Credentials',
        '',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
        array(
            'before_section' => '<div class="row"><div class="%s">',
            'after_section'  => '</div>',
            'section_class'  => 'col-md-6',
        )
    );

    // Setup settings section 1
    add_settings_section(
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_section2',
        'Other Info',
        '',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
        array(
            'before_section' => '<div class="%s">',
            'after_section'  => '</div></div>',
            'section_class'  => 'col-md-6',
        )
    );



// section 1 

    // Register input field
    register_setting(
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_client_id',
        array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => ''
        )
    );

    add_settings_field(
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_client_id',
        __( 'Zoho Signup Client ID', ZOHO_SIGNUP_API_PLUGIN_NAME ),
        'zoho_signup_api_client_id_field_callback',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_section'
    );


    // Register input field
    register_setting(
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_client_secret',
        array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => ''
        )
    );

    add_settings_field(
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_client_secret',
        __( 'Zoho Signup Client Secret', ZOHO_SIGNUP_API_PLUGIN_NAME ),
        'zoho_signup_api_client_secret_field_callback',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_section'
    );


    // Register input field
    register_setting(
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_refresh_token',
        array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => ''
        )
    );

    add_settings_field(
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_refresh_token',
        __( 'Zoho Signup Refresh Token', ZOHO_SIGNUP_API_PLUGIN_NAME ),
        'zoho_signup_api_refresh_token_field_callback',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_section'
    );


    // Register input field
    register_setting(
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_template_id',
        array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => ''
        )
    );

    add_settings_field(
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_template_id',
        __( 'Zoho Signup Template ID', ZOHO_SIGNUP_API_PLUGIN_NAME ),
        'zoho_signup_api_template_id_field_callback',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_section'
    );


    // Register input field
    register_setting(
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_action_id',
        array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => ''
        )
    );

    add_settings_field(
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_action_id',
        __( 'Zoho Signup Template Action ID', ZOHO_SIGNUP_API_PLUGIN_NAME ),
        'zoho_signup_api_action_id_field_callback',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_section'
    );


        // Register input field
        register_setting(
            ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
            ZOHO_SIGNUP_API_PLUGIN_NAME . '_signing_order',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
    
        add_settings_field(
            ZOHO_SIGNUP_API_PLUGIN_NAME . '_signing_order',
            __( 'Zoho Signup Signing Order', ZOHO_SIGNUP_API_PLUGIN_NAME ),
            'zoho_signup_api_signing_order_field_callback',
            ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
            ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_section'
        );
    
        // Register input field
        register_setting(
            ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
            ZOHO_SIGNUP_API_PLUGIN_NAME . '_recipient_role',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );

        add_settings_field(
            ZOHO_SIGNUP_API_PLUGIN_NAME . '_recipient_role',
            __( 'Recipient Role', ZOHO_SIGNUP_API_PLUGIN_NAME ),
            'zoho_signup_api_recipient_role_field_callback',
            ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
            ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_section'
        );


    // section 1 ends




// section 2 starts


    // Register input field
    register_setting(
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_host_domain',
        array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => ''
        )
    );

    add_settings_field(
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_host_domain',
        __( 'Host Domain', ZOHO_SIGNUP_API_PLUGIN_NAME ),
        'zoho_signup_api_host_domain_field_callback',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_section2'
    );


        // Register input field
        register_setting(
            ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
            ZOHO_SIGNUP_API_PLUGIN_NAME . '_form_redirect_page_url',
            array(
                'type' => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default' => ''
            )
        );
    
        add_settings_field(
            ZOHO_SIGNUP_API_PLUGIN_NAME . '_form_redirect_page_url',
            __( 'Form Redirect Blank Page URL', ZOHO_SIGNUP_API_PLUGIN_NAME ),
            'zoho_signup_api_form_redirect_page_url_field_callback',
            ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
            ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_section2'
        );



    // Register input field
    register_setting(
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_successful_redirect_url',
        array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => ''
        )
    );

    add_settings_field(
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_successful_redirect_url',
        __( 'Successful Signup Redirect URL', ZOHO_SIGNUP_API_PLUGIN_NAME ),
        'zoho_signup_api_successful_redirect_url_field_callback',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_section2'
    );


    // Register input field
    register_setting(
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_terms_page_url',
        array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => ''
        )
    );

    add_settings_field(
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_terms_page_url',
        __( 'Terms and Condition Page URL', ZOHO_SIGNUP_API_PLUGIN_NAME ),
        'zoho_signup_api_terms_page_url_field_callback',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_section2'
    );


    // Register image uploader field
    register_setting(
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_spinner_image_file_id',
        array(
            'type' => 'integer',
            'sanitize_callback' => 'sanitize_text_field',
            'default' => ''
        )
    );

    // Add image uploader fields
    add_settings_field(
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_spinner_image_file_id',
        __( 'Spinner Image Uplaoder', ZOHO_SIGNUP_API_PLUGIN_NAME ),
        'zoho_signup_api_spinner_image_file_id_callback',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_page',
        ZOHO_SIGNUP_API_PLUGIN_NAME . '_settings_section2'
    );



// section 2 ends




}
// Settings Template ends here 



// Text field template
function zoho_signup_api_client_id_field_callback() {
    $zoho_signup_api_input_field = get_option(ZOHO_SIGNUP_API_PLUGIN_NAME . '_client_id');
    ?>
    <input type="text" name="<?php echo ZOHO_SIGNUP_API_PLUGIN_NAME;?>_client_id" class="regular-text" placeholder='Zoho Signup Client ID...' value="<?php echo isset($zoho_signup_api_input_field) && $zoho_signup_api_input_field != '' ? $zoho_signup_api_input_field : ''; ?>" />
    <?php 
}


// Text field template
function zoho_signup_api_client_secret_field_callback() {
    $zoho_signup_api_input_field = get_option(ZOHO_SIGNUP_API_PLUGIN_NAME . '_client_secret');
    ?>
    <input type="password" name="<?php echo ZOHO_SIGNUP_API_PLUGIN_NAME;?>_client_secret" class="regular-text" placeholder='Zoho Signup Client Secret...' value="<?php echo isset($zoho_signup_api_input_field) && $zoho_signup_api_input_field != '' ? $zoho_signup_api_input_field : ''; ?>" />
    <?php 
}

// Text field template
function zoho_signup_api_refresh_token_field_callback() {
    $zoho_signup_api_input_field = get_option(ZOHO_SIGNUP_API_PLUGIN_NAME . '_refresh_token');
    ?>
    <input type="password" name="<?php echo ZOHO_SIGNUP_API_PLUGIN_NAME;?>_refresh_token" class="regular-text" placeholder='Zoho Signup Refresh Token...' value="<?php echo isset($zoho_signup_api_input_field) && $zoho_signup_api_input_field != '' ? $zoho_signup_api_input_field : ''; ?>" />
    <?php 
}

// Text field template
function zoho_signup_api_template_id_field_callback() {
    $zoho_signup_api_input_field = get_option(ZOHO_SIGNUP_API_PLUGIN_NAME . '_template_id');
    ?>
    <input type="text" name="<?php echo ZOHO_SIGNUP_API_PLUGIN_NAME;?>_template_id" class="regular-text" placeholder='Zoho Signup Template ID...' value="<?php echo isset($zoho_signup_api_input_field) && $zoho_signup_api_input_field != '' ? $zoho_signup_api_input_field : ''; ?>" />
    <?php 
}

// Text field template
function zoho_signup_api_action_id_field_callback() {
    $zoho_signup_api_input_field = get_option(ZOHO_SIGNUP_API_PLUGIN_NAME . '_action_id');
    ?>
    <input type="text" name="<?php echo ZOHO_SIGNUP_API_PLUGIN_NAME;?>_action_id" class="regular-text" placeholder='Zoho Signup Template Action ID...' value="<?php echo isset($zoho_signup_api_input_field) && $zoho_signup_api_input_field != '' ? $zoho_signup_api_input_field : ''; ?>" />
    <?php 
}

// Text field template
function zoho_signup_api_signing_order_field_callback() {
    $zoho_signup_api_input_field = get_option(ZOHO_SIGNUP_API_PLUGIN_NAME . '_signing_order');
    ?>
    <input type="text" name="<?php echo ZOHO_SIGNUP_API_PLUGIN_NAME;?>_signing_order" class="regular-text" placeholder='Zoho Signup Signing Order...(Default 1)' value="<?php echo isset($zoho_signup_api_input_field) && $zoho_signup_api_input_field != '' ? $zoho_signup_api_input_field : ''; ?>" />
    <?php 
}


// Text field template
function zoho_signup_api_recipient_role_field_callback() {
    $zoho_signup_api_input_field = get_option(ZOHO_SIGNUP_API_PLUGIN_NAME . '_recipient_role');
    ?>
    <input type="text" name="<?php echo ZOHO_SIGNUP_API_PLUGIN_NAME;?>_recipient_role" class="regular-text" placeholder='Recipient Role...' value="<?php echo isset($zoho_signup_api_input_field) && $zoho_signup_api_input_field != '' ? $zoho_signup_api_input_field : ''; ?>" />
    <?php 
}






// Text field template
function zoho_signup_api_host_domain_field_callback() {
    $zoho_signup_api_input_field = get_option(ZOHO_SIGNUP_API_PLUGIN_NAME . '_host_domain');
    ?>
    <input type="text" name="<?php echo ZOHO_SIGNUP_API_PLUGIN_NAME;?>_host_domain" class="regular-text" placeholder='Host Domain...' value="<?php echo isset($zoho_signup_api_input_field) && $zoho_signup_api_input_field != '' ? $zoho_signup_api_input_field : ''; ?>" />
    <?php 
}


// Text field template
function zoho_signup_api_form_redirect_page_url_field_callback() {
    $zoho_signup_api_input_field = get_option(ZOHO_SIGNUP_API_PLUGIN_NAME . '_form_redirect_page_url');
    ?>
    <input type="text" name="<?php echo ZOHO_SIGNUP_API_PLUGIN_NAME;?>_form_redirect_page_url" class="regular-text" placeholder='Form Redirect Blank Page URL...' value="<?php echo isset($zoho_signup_api_input_field) && $zoho_signup_api_input_field != '' ? $zoho_signup_api_input_field : ''; ?>" />
    
    <p class="description">
		<?php esc_html_e( 'Put here the same page URL, if you do not want to load the iframe in a different page.' ); ?>
	</p>

    <?php 
}

// Text field template
function zoho_signup_api_successful_redirect_url_field_callback() {
    $zoho_signup_api_input_field = get_option(ZOHO_SIGNUP_API_PLUGIN_NAME . '_successful_redirect_url');
    ?>
    <input type="text" name="<?php echo ZOHO_SIGNUP_API_PLUGIN_NAME;?>_successful_redirect_url" class="regular-text" placeholder='Successful Signup Redirect URL...' value="<?php echo isset($zoho_signup_api_input_field) && $zoho_signup_api_input_field != '' ? $zoho_signup_api_input_field : ''; ?>" />
    

    <?php 
}

// Text field template
function zoho_signup_api_terms_page_url_field_callback() {
    $zoho_signup_api_input_field = get_option(ZOHO_SIGNUP_API_PLUGIN_NAME . '_terms_page_url');
    ?>
    <input type="text" name="<?php echo ZOHO_SIGNUP_API_PLUGIN_NAME;?>_terms_page_url" class="regular-text" placeholder='Terms and Condition Page URL...' value="<?php echo isset($zoho_signup_api_input_field) && $zoho_signup_api_input_field != '' ? $zoho_signup_api_input_field : ''; ?>" />
    

    <?php 
}


/**
 * Image Uploader Template
 */

 function zoho_signup_api_spinner_image_file_id_callback() {

    $zoho_signup_api_image_id = get_option(ZOHO_SIGNUP_API_PLUGIN_NAME . '_spinner_image_file_id');

    ?>
    <div class="zoho_signup_api-upload-wrap">

        <!-- <p class="zoho_signup_api_json_url"><?php //echo esc_url(wp_get_attachment_url(isset($zoho_signup_api_image_id) ? (int) $zoho_signup_api_image_id : 0)); ?></p> -->
        <img data-src="" src="<?php echo esc_url(wp_get_attachment_url(isset($zoho_signup_api_image_id) ? (int) $zoho_signup_api_image_id : 0)); ?>" width="250" />

        <div class="zoho_signup_api-upload-action">
            <input type="hidden" name="<?php echo ZOHO_SIGNUP_API_PLUGIN_NAME;?>_spinner_image_file_id" value="<?php echo esc_attr(isset($zoho_signup_api_image_id) ? (int) $zoho_signup_api_image_id : 0); ?>" />
            <button type="button" class="zoho_signup_api_upload_image_button"><span class="dashicons dashicons-plus"></span></button>
            <button type="button" class="zoho_signup_api_remove_image_button"><span class="dashicons dashicons-minus"></span></button>
        </div>
    </div>
    <?php 
}



?>