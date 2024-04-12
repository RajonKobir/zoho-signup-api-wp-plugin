<?php

//  no direct access 
if( !defined('ABSPATH') ) : exit(); endif;



// shortcode function
function zoho_signup_api_function($attr) {

    $args = shortcode_atts(array(

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

    ), $attr);

    // initializing 
    $api_key = '';
    $pageHTML = '';
    $signup_link = '';
    $terms_page_url = '';
    $terms_page_url = '';
    $spinner_image_file_id = '';
    $spinner_image_file_url = '';

    // getting values from wp option 
    // $base_url = get_option(ZOHO_SIGNUP_API_PLUGIN_NAME . '_api_base_url');
    // $account_address = get_option(ZOHO_SIGNUP_API_PLUGIN_NAME . '_account_address');
    // $contract_address = get_option(ZOHO_SIGNUP_API_PLUGIN_NAME . '_contract_address');
    // $api_token = get_option(ZOHO_SIGNUP_API_PLUGIN_NAME . '_api_token');
    $form_redirect_page_url = get_option( ZOHO_SIGNUP_API_PLUGIN_NAME . '_form_redirect_page_url' );
    $terms_page_url = get_option( ZOHO_SIGNUP_API_PLUGIN_NAME . '_terms_page_url' );
    $spinner_image_file_id = get_option( ZOHO_SIGNUP_API_PLUGIN_NAME . '_spinner_image_file_id' );
    $spinner_image_file_url = wp_get_attachment_url($spinner_image_file_id);
    // $spinner_image_file_src = wp_get_attachment_image_src($spinner_image_file_id);
    // $spinner_image_file_url = $spinner_image_file_src[0];

    // installing bootstrap
    $pageHTML .= '<link rel="stylesheet" href="' . ZOHO_SIGNUP_API_PLUGIN_URL . 'inc/shortcodes/includes/css/bootstrap.min.css">';

     // installing jquery
     $pageHTML .= '<script src="' . ZOHO_SIGNUP_API_PLUGIN_URL . 'inc/shortcodes/includes/js/jquery-1.12.0.min.js"></script>';

     // installing bootstrap js
     $pageHTML .= '<script src="' . ZOHO_SIGNUP_API_PLUGIN_URL . 'inc/shortcodes/includes/js/bootstrap.bundle.min.js"></script>';
    
     $pageHTML .= '<style>

     .zoho_signup_api_main_div{
        font-family: '.$args['font_family'].', sans-serif !important;
        color: '.$args['font_color'].';
     }
     .zoho_signup_api_form_title{
        text-align: '.$args['form_title_text_align'].';
        font-size: '.$args['form_title_font_size'].';
        font-weight: '.$args['form_title_font_weight'].';
        margin-top: '.$args['form_title_margin_top'].';
        margin-bottom: '.$args['form_title_margin_bottom'].';
     }
     .zoho_signup_api_form_sub_title{
        text-align: '.$args['form_sub_title_text_align'].';
        font-size: '.$args['form_sub_title_font_size'].';
        font-weight: '.$args['form_sub_title_font_weight'].';
        margin-bottom: '.$args['form_sub_title_margin_bottom'].';
     }

     .form-check-input:checked {
        background-color: green;
        border-color: green;
      }
      .zoho_signup_api_iframe_div {
          position: relative;
      }
      .zoho_signup_api_iframe_div .zoho_signup_api_spinner_image {
        position: absolute;
        top: '.$args['spinner_image_margin_top'].';
        left: 50%;
        width: '.$args['spinner_image_width_percentage'].'%;
        margin-left: -'.(floatval($args['spinner_image_width_percentage']) / 2).'%;
      }
      .zoho_signup_api_iframe_div iframe {
          background: transparent;
          z-index: 1;
          min-height: '.$args['iframe_min_height_before_load'].';
      }
      .special_iframe_class {
          min-height: '.$args['iframe_min_height_after_load'].';
      }

    </style>';


    $pageHTML .= "<div id='zoho_signup_api_main_div' class='zoho_signup_api_main_div'>";

      if(isset($_GET['signup_link'])){
        if($_GET['signup_link'] != ''){
          $signup_link = $_GET['signup_link'];
          $signup_link = urldecode($signup_link);
        }
      }

      if($signup_link != ''){

        $pageHTML .= "<div id='zoho_signup_api_iframe_div' class='zoho_signup_api_iframe_div' style:'margin: 0;
        padding: 0;'>";
    
        $pageHTML .= "<img id='zoho_signup_api_spinner_image' class='zoho_signup_api_spinner_image' src='".$spinner_image_file_url."' alt='Spinner Image' />";
  
        $pageHTML .= "<iframe id='zoho_signup_api_iframe' class='zoho_signup_api_iframe' src='".$signup_link."' width='100%' frameborder='0' style='overflow: hidden; border:none; ' allowfullscreen ></iframe>";
    
        $pageHTML .= "</div>";


        $pageHTML .= '<script>
    
        $( document ).ready(function() {
    
          $("#zoho_signup_api_iframe").load(function(){

            $("#zoho_signup_api_spinner_image").hide();
            $(this).addClass("special_iframe_class");

          });
    
        });
        
        </script>';



      }else{

        $pageHTML .= "<div id='zoho_signup_api_form_div' class='container-fluid zoho_signup_api_form_div'>";

        $pageHTML .= "<h1 class='zoho_signup_api_form_title'>".$args['form_title_text']."</h1>";
        $pageHTML .= "<p class='zoho_signup_api_form_sub_title'>".$args['form_sub_title_text']."</p>";
    
    
        $pageHTML .= "
    
        <div class='row'>
        <div class='mx-auto col-10 col-md-4 col-lg-4'>
    
        <form id='zoho_signup_api_main_form' onsubmit='return false' class='g-3 needs-validation' novalidate>
    
          <div class='form-group'>
            <label for='validationCustom01' class='form-label'>".$args['form_name_input_label']."</label>
            <input name='zoho_signup_api_name_field' id='zoho_signup_api_name_field' minlength='5' maxlength='50' type='text' class='form-control' id='validationCustom01' value='' required>
            <div class='valid-feedback'>
              Perfect!
            </div>
          </div>
    
          <div class='form-group'>
            <label for='validationCustom02' class='form-label'>".$args['form_email_input_label']."</label>
            <input name='zoho_signup_api_email_field' id='zoho_signup_api_email_field' type='email' class='form-control' id='validationCustom02' value='' required>
            <div class='valid-feedback'>
              Perfect!
            </div>
          </div>
    
          <div class='form-group'>
            <div class='form-check mt-3 mb-3'>
                <input class='form-check-input mt-1' type='checkbox' value='' id='invalidCheck' required style='margin-right: 0.5rem;'>
                  <label class='form-check-label ' for='invalidCheck'>
                    <a target='_blank' href='".$terms_page_url."' style='color: inherit; text-decoration: none; border: none;'>
                    ".$args['form_agreement_text']."
                    </a>
                  </label>
              <div class='invalid-feedback'>
                You must agree before submitting.
              </div>
            </div>
          </div>
    
          <div class='form-group text-center'>
            <button id='zoho_signup_api_submit_button' class='btn btn-success mb-3' type='submit' name='zoho_signup_api_submit_button'>".$args['form_submit_button_text']."</button>
          </div>
    
      </form>";
      
        $pageHTML .= "</div>";
  
        $pageHTML .= "<h6 id='result' class='result text-center text-danger'></h6>";


        $pageHTML .= '<script>
    
        $( document ).ready(function() {
    
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function () {
              "use strict"
            
              // Fetch all the forms we want to apply custom Bootstrap validation styles to
              var forms = document.querySelectorAll(".needs-validation")
            
              // Loop over them and prevent submission
              Array.prototype.slice.call(forms)
                .forEach(function (form) {
                  form.addEventListener("submit", function (event) {
                    if (!form.checkValidity()) {
                      event.preventDefault();
                      event.stopPropagation();
                    }else{
                        event.preventDefault();
                        $("#zoho_signup_api_submit_button").attr("disabled", true);
                        $("#zoho_signup_api_submit_button").html("Submitting...");
                        let username = $( "#zoho_signup_api_name_field" ).val();
                        let useremail = $( "#zoho_signup_api_email_field" ).val();
                        let post_url = "'.ZOHO_SIGNUP_API_PLUGIN_URL.'/inc/shortcodes/includes/post.php";
                        let current_url = $(location).attr("href");
                        // alert(current_url);
    
                        $.ajax({
                            type: "POST",
                            url: post_url,
                            data: {username, useremail, current_url}, 
                            success: function(result){
  
                            //  $("#result").html(result);
                             if(result == "error"){
  
                                $( "#zoho_signup_api_name_field" ).val("");
                                $( "#zoho_signup_api_email_field" ).val("");
                                $( "#invalidCheck" ).prop( "checked", false );
                                $("#zoho_signup_api_submit_button").attr("disabled", false);
                                $("#zoho_signup_api_submit_button").html("Submit");
                                $("#result").html("Something Went Wrong! Please Try Again Later!");
                                // setTimeout(function(){
                                //   $("#zoho_signup_api_form_div").hide();
                                //   $("#zoho_signup_api_iframe_div").show();
                                //   $("#zoho_signup_api_iframe").attr("src", "https://www.youtube.com/embed/_yuhV3udQ3o?si=gTgniuOPQMy8aw9L");
                                //   $("html, body").animate({
                                //       scrollTop: $("#zoho_signup_api_iframe_div").offset().top
                                //   }, 1000);
                                // }, 5000);
    
                             }else{
  
                                let form_redirect_page_url = "'.$form_redirect_page_url.'";
  
                                // $("#zoho_signup_api_iframe").attr("src", result);
                                // $("#zoho_signup_api_form_div").hide();
                                // $("#result").hide();
                                // $("#zoho_signup_api_iframe_div").show();
                                // $("html, body").animate({
                                //     scrollTop: $("#zoho_signup_api_iframe_div").offset().top
                                // }, 1000);
                                // $("#zoho_signup_api_iframe").load(function(){
                                //   $("#zoho_signup_api_spinner_image").hide();
                                //   $(this).height($(this).contents().height());
                                //   $(this).width($(this).contents().width());
                                // });
  
                                // $("#result").html(result);
    
                                // let link = encodeURI(result);
                                // $("#result").html(link);
  
                                // location.replace(result);
  
                                result = encodeURI(result);
                                result = encodeURIComponent(result);
                                location.replace(form_redirect_page_url + "?signup_link=" + result);
  
                                // location.replace("https://innovaprimarycare.com/zoho-test-2/" + "?link=" + link);
                                // window.open("https://innovaprimarycare.com/zoho-test-2/" + "?link=" + link, "_blank").focus();
    
                             }
    
                            }
    
                        });
    
                    }
            
                    form.classList.add("was-validated");
                  }, false)
                })
            })();
    
    
        
        });
        
        </script>';



      }




      $pageHTML .= "</div>";


      







    return $pageHTML;

}




