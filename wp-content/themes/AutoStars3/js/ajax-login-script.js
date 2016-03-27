(function($) {
  "use strict";
jQuery(document).ready(function($) {
	$('form#reset-pass').on('submit', function(e){
		//alert("saiji");
				if($('form#reset-pass #reset-email').val()=='')
				{
					$('form#reset-pass p.status').show().html();
					$('form#reset-pass p.status').show().html("<br/><div id=\"messages\"><div class=\"alert alert-error\">"+reset_password.fillemail+"</div></div>");
				}
				else
				{
					$('form#reset-pass p.status').show().html();
					$('form#reset-pass p.status').show().html("<br/><div id=\"messages\"><div class=\"alert alert-success\">"+ajax_login_object.loadingmessage+"</div></div>");
				}
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: { 
                'action': 'imic_reset_password', //calls wp_ajax_nopriv_ajaxlogin
                'reset_email': $('form#reset-pass #reset-email').val(),
								'verification_code': $('form#reset-pass #reset-verification').val(),
								'reset_pass1': $('form#reset-pass #reset-pass1').val(),
								'reset_pass2': $('form#reset-pass #reset-pass2').val(),
						}, 
            success: function(data){
							if(data.passauth==false)
							{
								$('form#reset-pass p.status').show().html();
								$('form#reset-pass p.status').show().html("<br/><div id=\"messages\"><div class=\"alert alert-error\">"+data.message+"</div></div>");
							}
							if(data.passauth==true)
							{
								$('form#reset-pass p.status').show().html();
								$('form#reset-pass p.status').show().html("<br/><div id=\"messages\"><div class=\"alert alert-success\">"+data.message+"</div></div>");
							}
							if(data.authenticate==true)
							{
								$("#show-pass-fields").show();
								$('form#reset-pass p.status').show().html();
								$('form#reset-pass p.status').show().html("<br/><div id=\"messages\"><div class=\"alert alert-success\">"+data.message+"</div></div>");
							}
							if(data.authenticate==false)
							{
								$("#show-pass-fields").hide();
								$('form#reset-pass p.status').show().html();
								$('form#reset-pass p.status').show().html("<br/><div id=\"messages\"><div class=\"alert alert-error\">"+data.message+"</div></div>");
							}
							if (data.valid == true)
								{
									//alert("saideva");
									$("#show-pass-fields").hide();
									$('form#reset-pass #reset-key').show();
									$('form#reset-pass #reset-code').hide();
									$('form#reset-pass #reset-new-pass').show();
									$('form#reset-pass p.status').show().html();
									$('form#reset-pass p.status').show().html("<br/><div id=\"messages\"><div class=\"alert alert-success\">"+data.message+"</div></div>");
                }
                if (data.valid == false)
								{
									//alert("saideva");
									$("#show-pass-fields").hide();
									$('form#reset-pass #reset-code').show();
									$('form#reset-pass #reset-new-pass').hide();
									$('form#reset-pass p.status').show().html();
									$('form#reset-pass p.status').show().html("<br/><div id=\"messages\"><div class=\"alert alert-error\">"+data.message+"</div></div>");
                }
            }
        });
        e.preventDefault();
    });
    // Perform AJAX login on form submit
    $('form#login').on('submit', function(e){
        $('form#login p.status').show().html("<br/><div id=\"messages\"><div class=\"alert alert-success\">"+ajax_login_object.loadingmessage+"</div></div>");
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: { 
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': $('form#login #loginname').val(), 
                'password': $('form#login #password').val(), 
				  'rememberme': $('form#login #rememberme').val(),
                'security': $('form#login #security').val() },
            success: function(data){
                $('form#login p.status').html("<br/><div class=\"input-group\"><div id=\"messages\"><div class=\"alert alert-error\">"+data.message+"</div></div></div>");
                if (data.loggedin == true){
					$('form#login p.status').html("<br/><div id=\"messages\"><div class=\"alert alert-success\">"+data.message+"</div></div>");
					document.location.href = jQuery('.redirect_login').val();
                }
            }
        });
        e.preventDefault();
    });
	$('form#login-popup').on('submit', function(e){
        $('form#login-popup p.status').show().html("<br/><div id=\"messages\"><div class=\"alert alert-success\">"+ajax_login_object.loadingmessage+"</div></div>");
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: { 
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': $('form#login-popup #loginname').val(), 
                'password': $('form#login-popup #password').val(), 
				  'rememberme': $('form#login-popup #rememberme').val(),
                'security': $('form#login-popup #security').val() },
            success: function(data){
                $('form#login-popup p.status').html("<br/><div class=\"input-group\"><div id=\"messages\"><div class=\"alert alert-error\">"+data.message+"</div></div></div>");
                if (data.loggedin == true){
					$('form#login-popup p.status').html("<br/><div id=\"messages\"><div class=\"alert alert-success\">"+data.message+"</div></div>");
					document.location.href = jQuery('.redirect_login').val();
                }
            }
        });
        e.preventDefault();
    });
});
})(jQuery);