function ihc_delete_file_via_ajax(id, u_id, parent, name, hidden_id){
   	jQuery.ajax({
        type : "post",
        url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
        data : {
                   action: "ihc_delete_attachment_ajax_action",
                   attachemnt_id: id,
                   user_id: u_id,
                   field_name: name,
               },
        success: function (data) {   
        	jQuery(hidden_id).val('');
        	jQuery(parent + ' .ajax-file-upload-filename').remove();        	
        	jQuery(parent + ' .ihc-delete-attachment-bttn').remove();
        	if (jQuery(parent + ' .ihc-member-photo').length){
        		jQuery(parent + ' .ihc-member-photo').remove();
        		if (name=='ihc_avatar'){
        			jQuery(parent).prepend("<div class='ihc-no-avatar ihc-member-photo'></div>");
        			jQuery(parent + " .ihc-file-upload").css("display", 'block');
        		}        		
        	}
        	
        	if (jQuery(parent + " .ihc-file-name-uploaded").length){
        		jQuery(parent + " .ihc-file-name-uploaded").remove();
        	}
        	
        	if (jQuery(parent + ' .ajax-file-upload-progress').length){
        		jQuery(parent + ' .ajax-file-upload-progress').remove();
        	}
        	if (jQuery(parent + ' .ihc-icon-file-type').length){
        		jQuery(parent + ' .ihc-icon-file-type').remove();
        	}
        }
   });
}

function ihc_set_form_i(i_id, f_id, l_id){
	/*
	 * i_id = input hidden id
	 * f_id = form id
	 * l_id = level id
	 */
	if (jQuery("#ihc_coupon").val()){
		jQuery(f_id).append("<input type=hidden value=" + jQuery("#ihc_coupon").val() + " name=ihc_coupon />");
	}
	jQuery(i_id).val(l_id);
	jQuery(f_id).submit();
}       

function ihc_dh_selector(id, display){
	if (display){
		jQuery(id).css('visibility', 'visible');
	} else {
		jQuery(id).css('visibility', 'hidden');
	}
}

function ihc_set_level_ap(l){
	jQuery('#ihc_renew_level').val(l);
	jQuery('#ihc_form_ap_subscription_page').submit();
}

function ihc_run_social_reg(s){
	var form = jQuery("form#createuser");
	jQuery("form#createuser input, form#createuser textarea").each(function(){
		ihc_append_input(this.name, this.value, "#ihc_social_login_form");
	});
	ihc_append_input('sm_type', s, "#ihc_social_login_form");
	jQuery("#ihc_social_login_form").submit();
}

function ihc_append_input(n,v,w){
	jQuery(w).append("<input type=hidden value="+v+" name="+n+" />");
}

function ihc_buy_new_level(href){
	if (jQuery("#ihc_coupon").val()){
		//we have a coupon
		var url = href + "&ihc_coupon=" + jQuery("#ihc_coupon").val();
		window.location.href = url;
	} else {
		window.location.href = href;
	}
}

jQuery(document).ready(function(){
	jQuery('.ihc-mobile-bttn').on('click', function(){
		jQuery('.ihc-ap-menu').toggle();
	});	
});




function ihc_register_check_via_ajax(the_type){
	var target_id = '#' + jQuery('.ihc-form-create-edit [name='+the_type+']').parent().attr('id');
	var val1 = jQuery('.ihc-form-create-edit [name='+the_type+']').val();
	var val2 = '';
	
	if (the_type=='pass2'){
		val2 = jQuery('[name=pass1]').val();
	} else if (the_type=='confirm_email'){
		val2 = jQuery('[name=user_email]').val();
	}
	
   	jQuery.ajax({
        type : "post",
        url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
        data : {
                   action: "ihc_check_reg_field_ajax",
                   type: the_type,
                   value: val1,
                   second_value: val2
               },
        success: function (data) {
        	//remove prev notice, if its case
        	jQuery(target_id + ' .ihc-register-notice').remove();
        	jQuery('.ihc-form-create-edit [name='+the_type+']').removeClass('ihc-input-notice');
        	if (data==1){
        		// it's all good 

        	} else {
        		jQuery(target_id).append('<div class="ihc-register-notice">'+data+'</div>');
        		jQuery('.ihc-form-create-edit [name='+the_type+']').addClass('ihc-input-notice');
        	}
        }
   	});
}


function ihc_get_checkbox_radio_value(type, selector){
	if (type=='radio'){
		var r = jQuery('[name='+selector+']:checked').val();
		if (typeof r!='undefined'){
			return r;
		}
	} else {
		var arr = [];
		jQuery('[name=\''+selector+'[]\']:checked').each(function(){
			arr.push(this.value);
		});
		if (arr.length>0){
			return arr.join(',');
		}		
	}
	return '';
}

function ihc_register_check_via_ajax_rec(types_arr){
	jQuery('.ihc-register-notice').remove();
	var fields_to_send = [];
	
	for (var i=0; i<types_arr.length; i++){
		
		jQuery('.ihc-form-create-edit [name='+types_arr[i]+']').removeClass('ihc-input-notice');
		
		var field_type = jQuery('[name=' + types_arr[i] + ']').attr('type');
		if (typeof field_type=='undefined'){
			var field_type = jQuery('[name=\'' + types_arr[i] + '[]\']').attr('type');	
		}
		
		if (field_type=='checkbox' || field_type=='radio'){
			var val1 = ihc_get_checkbox_radio_value(field_type, types_arr[i]);
		} else {
			var val1 = jQuery('[name='+types_arr[i]+']').val();
		}
		var val2 = '';
		
		if (types_arr[i]=='pass2'){
			val2 = jQuery('[name=pass1]').val();
		} else if (types_arr[i]=='confirm_email'){
			val2 = jQuery('[name=user_email]').val();
		} else if (types_arr[i]=='tos') {
			if (jQuery('[name=tos]').is(':checked')){
				val1 = 1;
			} else {
				val1 = 0;
			}
		}		
		fields_to_send.push({type: types_arr[i], value: val1, second_value: val2});
	}
	
   	jQuery.ajax({
        type : "post",
        url : decodeURI(window.ihc_site_url)+'/wp-admin/admin-ajax.php',
        data : {
                   action: "ihc_check_reg_field_ajax",
                   fields_obj: fields_to_send
               },
        success: function (data) {
        	var obj = JSON.parse(data);
        	var must_submit = 1;
        	for (var j=0; j<obj.length; j++){
        		var field_type = jQuery('[name=' + obj[j].type + ']').attr('type');
        		if (typeof field_type=='undefined'){
        			var field_type = jQuery('[name=\'' + obj[j].type + '[]\']').attr('type');	
        		}
 
            	if (field_type=='radio'){
            		var target_id = jQuery('.ihc-form-create-edit [name='+obj[j].type+']').parent().parent().attr('id');
            	} else if (field_type=='checkbox' && obj[j].type!='tos'){
            		var target_id = jQuery('.ihc-form-create-edit [name=\''+obj[j].type+'[]\']').parent().parent().attr('id');
            	} else {
            		var target_id = jQuery('.ihc-form-create-edit [name='+obj[j].type+']').parent().attr('id');
            	}

            	if (obj[j].value==1){
            		// it's all good 
            	} else {
            		//errors
            		jQuery('#'+target_id).append('<div class="ihc-register-notice">'+obj[j].value+'</div>');
            		jQuery('.ihc-form-create-edit [name=' + obj[j].type + ']').addClass('ihc-input-notice');
            		must_submit = 0;
            	}            	
        	}
        	
        	if (must_submit==1){
    			window.must_submit=1;
    			jQuery(".ihc-form-create-edit").submit();     		
        	} else {
    			return false;        		
        	}      	
        }
   	});  
   	
}