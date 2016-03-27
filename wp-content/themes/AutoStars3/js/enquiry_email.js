(function($) {
  "use strict";
jQuery(document).ready(function(){
	jQuery("form.enquiry-vehicle").submit(function(event){
		//alert("saideva");
		//alert(values.tmpurl+"/email_file.php");
            var formData = new FormData(jQuery(this)[0]);
			var this_form = jQuery(this);
			var $email = jQuery(this).find("input[name=Email]").val();
			if($email=='') { jQuery(this).find('.message').empty(); jQuery(this).find('.message').append('<div class="alert alert-error">'+values_enquiry.msg+'</div>'); }
			else {
				jQuery(this).find('.message').empty();
			jQuery(this).find('.message').append('<div class="alert alert-success">'+values_enquiry.sending+'</div>');
        jQuery.ajax({
                url: values_enquiry.tmpurl+"/email_file.php",
                type: "POST",
                data: formData,
                async: false,
                success: function(msg){
					//alert(msg);
					jQuery(this_form).find('.message').empty();
					jQuery(this_form).find('.message').append('<div class="alert alert-success">'+values_enquiry.success+'</div>');
					jQuery(this_form).closest('form').find("input[type=text], textarea").val("");
                   },
                cache: false,
                contentType: false,
                processData: false
            }); }
        //}
		return false;
        });  
});
})(jQuery);