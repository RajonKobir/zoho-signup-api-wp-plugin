;(function($) {
    'use strict';
    $('.zoho_signup_api_upload_image_button').click( function(event) {

        event.preventDefault();

        var send_attachment_bkp = wp.media.editor.send.attachment;

        var button = $(this);

        wp.media.editor.send.attachment = function(props, attachment) {

            event.preventDefault();

            if(attachment.subtype == 'jpg' || attachment.subtype == 'jpeg' || attachment.subtype == 'png' || attachment.subtype == 'gif'){

                $(button).parent().prev().attr('src', attachment.url);
                // $(button).parent().prev().html(attachment.url);

                $(button).prev().val(attachment.id);
    
                wp.media.editor.send.attachment = send_attachment_bkp;

            }else{

                alert('Please Select or Upload an Image File!');
                
            }



        }

        wp.media.editor.open(button);

        return false;

    });



    // The "Remove" button (remove the value from input type='hidden')

    $('.zoho_signup_api_remove_image_button').click( function() {

        var answer = confirm('Are you sure to remove this?');

        if (answer == true) {

            // var src = $(this).parent().prev().attr('data-src');
            var src = $(this).parent().prev().html('');

            // $(this).parent().prev().attr('src', src);

            $(this).prev().prev().val('');

        }

        return false;

    });

})(jQuery);