(function($) {
  "use strict";
$(document).ready(function(){
	$("#contact-site").click(function(){
		var $transaction = $(this).parent().find("#transaction").val();
		var $message = $("#payment-comment").val();
		var $plan = $("#plan_id").val();
		jQuery.ajax({
			type:'POST',
			url:common.ajaxurl,
			async: false,
			data: {
				action:'imic_contact_site_plans',
				transaction: $transaction,
				message: $message,
				plan: $plan
			},
			success: function(data) {
				$("#messages").empty();
				$("#messages").html(data);
			},
			erro: function() {
				
			}
		});
	});
});
})(jQuery);