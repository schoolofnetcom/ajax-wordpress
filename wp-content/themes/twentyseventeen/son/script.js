jQuery(document).ready( function() {

    jQuery(".user_like_button").click( function(e) {
       e.preventDefault(); 

       post_id = jQuery(this).attr("data-post_id");
       nonce = jQuery(this).attr("data-nonce");

       url = '/wp-admin/admin-ajax.php';

       data = {
          action: "son_like_action", 
          post_id : post_id, 
          nonce: nonce
       };
 
       jQuery.ajax({
          type : "post",
          dataType : "json",
          url : url,
          data : data,
          success: function(response) {
             if(response.type == "success") {
                jQuery("#number_of_likes").html(response.like_number);
             }
          },
          error: function(response) {
             alert("Your like could not be added")
          }
       });

    });

});