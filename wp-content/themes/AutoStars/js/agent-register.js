/* ==================================================
	Register Form Ajax Call
================================================== */
(function($) {
  "use strict";
jQuery(document).ready(function() {
	jQuery(".register-form").submit(function(event) {
		jQuery("#message").slideUp(750,function() {
		jQuery('#message').hide();
	
		jQuery('#submit')
		   .after('<img src="' + jQuery('#image_path').val() + '/images/assets/ajax-loader.gif" class="loader" />')
		   .attr('disabled','disabled');
		jQuery.ajax({
			type: 'POST',
			url: agent_register.ajaxurl,
			data: {
				action: 'imic_agent_register',
				role: jQuery('#role').val(),
				username: jQuery('#username').val(),
				email: jQuery('#email').val(),
				pwd1: jQuery('#pwd1').val(),
				pwd2: jQuery('#pwd2').val(),
				task: jQuery('#task').val(),
				roles: jQuery('#user-role').val(),
				captcha_q: jQuery('#captcha').text(),
				captcha_a: jQuery('#captcha_val').val()
				},
			success: function(data) {
				document.getElementById('message').innerHTML = data;
				jQuery('#message').slideDown('slow');
				jQuery('.register-form img.loader').fadeOut('slow',function(){jQuery(this).remove()});
				jQuery('#submit').removeAttr('disabled');
				if(data.match('successfully') != null) { document.getElementById('registerform').reset();
                                document.location.href = jQuery('.redirect_register').val(); }
			},
			error: function(errorThrown) {
			}
		});
		});
		return false;
	});
	jQuery(".register-form-popup").submit(function(event) {
		jQuery("#message-popup").slideUp(750,function() {
		jQuery('#message-popup').hide();
	
		jQuery('#submit-popup')
		   .after('<img src="' + jQuery('#image_path').val() + '/images/assets/ajax-loader.gif" class="loader" />')
		   .attr('disabled','disabled');
		jQuery.ajax({
			type: 'POST',
			url: agent_register.ajaxurl,
			data: {
				action: 'imic_agent_register',
				//role: jQuery('#role-popup').val(),
				username: jQuery('#username-popup').val(),
				email: jQuery('#email-popup').val(),
				pwd1: jQuery('#pwd1-popup').val(),
				pwd2: jQuery('#pwd2-popup').val(),
				task: jQuery('#task-popup').val(),
				roles: jQuery('#user-role-popup').val(),
				captcha_q: jQuery('#captcha-popup').text(),
				captcha_a: jQuery('#captcha_val-popup').val()
				},
			success: function(data) {
				
				document.getElementById('message-popup').innerHTML = data;
				jQuery('#message-popup').slideDown('slow');
				jQuery('.register-form-popup img.loader').fadeOut('slow',function(){jQuery(this).remove()});
				jQuery('#submit-popup').removeAttr('disabled');
				if(data.match('successfully') != null) { document.getElementById('registerformpopup').reset();
                                document.location.href = jQuery('.redirect_register').val();
				}
			},
			error: function(errorThrown) {
			}
		});
		});
		return false;
	});
});
})(jQuery);