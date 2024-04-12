<?php

// if posted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // if posted certain values
  if( isset($_POST["username"]) && isset($_POST["useremail"]) && isset($_POST["current_url"]) ){

    function secure_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    // initializing
    $username = secure_input($_POST["username"]);
    $useremail = secure_input($_POST["useremail"]);
    $current_url = secure_input($_POST["current_url"]);

    // echo $current_url;

    // to get the options values
    require_once '../../../../../../wp-config.php';

    // initializing
    $client_id = '';
    $client_secret = '';
    $refresh_token = '';
    $template_id = '';
    $action_id = '';
    $host_domain = '';
    $signing_order = '';
    $recipient_role = '';
    $success_redirect = '';

    // assigning values got from wp options
    $client_id = get_option( ZOHO_SIGNUP_API_PLUGIN_NAME . '_client_id');
    $client_secret = get_option( ZOHO_SIGNUP_API_PLUGIN_NAME . '_client_secret');
    $refresh_token = get_option( ZOHO_SIGNUP_API_PLUGIN_NAME . '_refresh_token');
    $template_id = get_option( ZOHO_SIGNUP_API_PLUGIN_NAME . '_template_id');
    $action_id = get_option( ZOHO_SIGNUP_API_PLUGIN_NAME . '_action_id');
    $host_domain = get_option( ZOHO_SIGNUP_API_PLUGIN_NAME . '_host_domain');
    $signing_order = get_option( ZOHO_SIGNUP_API_PLUGIN_NAME . '_signing_order');
    $recipient_role = get_option( ZOHO_SIGNUP_API_PLUGIN_NAME . '_recipient_role');
    $success_redirect = get_option( ZOHO_SIGNUP_API_PLUGIN_NAME . '_successful_redirect_url');

    // print_r($template_data);

    // try catch block starts here
    try {

      $curl = curl_init();
    
      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://accounts.zoho.com/oauth/v2/token?refresh_token='.$refresh_token.'&client_id='.$client_id.'&client_secret='.$client_secret.'&redirect_uri=https%3A%2F%2Fsign.zoho.com&grant_type=refresh_token',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
          'Authorization: Zoho-oauthtoken null'
        ),
      ));
      
      $response1 = curl_exec($curl);
      
      curl_close($curl);
    
    } catch (Exception $e) {
    
      echo 'error';
      return;
    
    } finally{
      
      // error handling
      if($response1){
        $response1 = json_decode($response1, true); 
        if( !isset($response1["access_token"])){
          echo 'error';
          return;
        }
      }else{
        echo 'error';
        return;
      }

    
    //   print_r ($response1);
    //   // print_r ($response1["access_token"]);
    // }
    
      try {
    
      // // // new call
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://sign.zoho.com/api/v1/templates/'.$template_id.'/createdocument',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('is_quicksend' => 'true','data' => '{
          "templates": {
              "field_data": {
                  "field_text_data": {},
                  "field_boolean_data": {},
                  "field_date_data": {},
                  "field_radio_data": {}
              },
              "actions": [
                  {
                      "recipient_name": "'.$username.'",
                      "recipient_email": "'.$useremail.'",
                      "action_id": "'.$action_id.'",
                      "signing_order": '.$signing_order.',
                      "role": "'.$recipient_role.'",
                      "verify_recipient": false,
                      "private_notes": "",
                      "is_embedded": true
                  }
              ],
              "redirect_pages":
              {
                "sign_success":"'.$success_redirect.'",
                "sign_completed":"'.$success_redirect.'",
                "sign_declined": "'.$success_redirect.'",
                "sign_later": "'.$success_redirect.'"
              },
              "notes": ""
          }
      }' ),
        CURLOPT_HTTPHEADER => array(
          'Authorization: Zoho-oauthtoken ' . $response1["access_token"]
        ),
      ));

      $response2 = curl_exec($curl);

      curl_close($curl);
    
      } catch (Exception $e) {
    
        echo 'error';
        return;
    
      } finally{

      // error handling
        if($response2){
          $response2 = json_decode($response2, true); 
          if( isset($response2["status"]) ){
            if( $response2["status"] != "success" ){
              echo 'error';
              return;
            }
          }else{
            echo 'error';
            return;
          }
        }else{
          echo 'error';
          return;
        }
    
    
      //   print_r ($response2);
        
      //   // print_r ($response2["requests"]["request_id"]);
      //   // echo '<br>';
      //   // print_r ($response2["requests"]["actions"][0]["action_id"]);
      // }
      // }


    
        // try { 

        //   $curl = curl_init();

        //   curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'https://sign.zoho.com/api/v1/requests/'.$response2["requests"]["request_id"].'/submit',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_POSTFIELDS => array('data' => '{
        //       "requests":{
        //           "actions":[
        //               {
        //                   "is_embedded": true
        //               }
        //           ]
        //       }
        //   }'),
        //     CURLOPT_HTTPHEADER => array(
        //       'Authorization: Zoho-oauthtoken ' . $response1["access_token"]
        //     ),
        //   ));
          
        //   $response = curl_exec($curl);
          
        //   curl_close($curl);

        // } catch (Exception $e) {
    
        //   echo 'error';
        //   return;
      
        // } finally{

          //error handling
          // if($response3){
          //   $response3 = json_decode($response3, true); 
          //   if( isset($response3["status"]) ){
          //     if( $response3["status"] != "success" ){
          //       echo 'error';
          //       return;
          //     }
          //   }else{
          //     echo 'error';
          //     return;
          //   }
          // }else{
          //   echo 'error';
          //   return;
          // }



        // //   print_r ($response3);
        
        // //   // print_r ($response2["requests"]["request_id"]);
        // //   // echo '<br>';
        // //   // print_r ($response2["requests"]["actions"][0]["action_id"]);
        // // }
        // // }
        // // }



          try { 
            // // another request
            $curl = curl_init();
              
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://sign.zoho.com/api/v1/requests/'.$response2["requests"]["request_id"].'/actions/'.$response2["requests"]["actions"][0]["action_id"].'/embedtoken?host=' . urlencode($host_domain),
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_HTTPHEADER => array(
                'Authorization: Zoho-oauthtoken ' . $response1["access_token"]
              ),
            ));

            $response4 = curl_exec($curl);

            curl_close($curl);

          } catch (Exception $e) { 

            echo 'error';
            return;

            } finally{

              // error handling
              if($response4){
                $response4 = json_decode($response4, true); 
                if( isset($response4["status"]) ){
                  if( $response4["status"] != "success" ){
                    echo 'error';
                    return;
                  }
                }else{
                  echo 'error';
                  return;
                }
              }else{
                echo 'error';
                return;
              }

              echo $response4["sign_url"];

            } // 4th API request
    
        // } // 3rd API request

      } //  2nd API request
    
    } // try catch block ends here





  }  // if posted certain values ends


    
}   // if posted ends

?>