(function($) {
  "use strict";
jQuery(document).ready(function(){
	var $sb;
	function imic_update_url(key, value, url) {
    if (!url) url = window.location.href;
    var re = new RegExp("([?&])" + key + "=.*?(&|#|$)(.*)", "gi"),
        hash;
    if (re.test(url)) {
        if (typeof value !== 'undefined' && value !== null)
            return url.replace(re, '$1' + key + "=" + value + '$2$3');
        else {
            hash = url.split('#');
            url = hash[0].replace(re, '$1$3').replace(/(&|\?)$/, '');
            if (typeof hash[1] !== 'undefined' && hash[1] !== null) 
                url += '#' + hash[1];
            return url;
        }
    }
    else {
        if (typeof value !== 'undefined' && value !== null) {
            var separator = url.indexOf('?') !== -1 ? '&' : '?';
            hash = url.split('#');
            url = hash[0] + separator + key + '=' + value;
            if (typeof hash[1] !== 'undefined' && hash[1] !== null) 
                url += '#' + hash[1];
            return url;
        }
        else
            return url;
    }
}
function getUrlParams_ads() {
    var result = {};
    var params = (window.location.search.split('?')[1] || '').split('&');
    for(var param in params) {
        if (params.hasOwnProperty(param)) {
            var paramParts = params[param].split('=');
            result[paramParts[0]] = decodeURIComponent(paramParts[1] || "");
        }
    }
    return result;
}
function imic_get_query_val(variable) {
    var query = window.location.search.substring(1);
    var vars = query.split('&');
    for (var i = 0; i < vars.length; i++) {
        var pair = vars[i].split('=');
        if (decodeURIComponent(pair[0]) == variable) {
            return decodeURIComponent(pair[1]);
        }
    }
    return "none";
}
if ( jQuery( "#not-valid" ).length ) {
		//history.pushState('', '', imic_update_url("edit",null,''));
		HistoryPush(imic_update_url("edit",null,''));
	}
jQuery(".find-cars").click(function(){
		var isValid = true;
		$sb = jQuery(this).attr("id");
		var $parent_div_id = jQuery(".listing-form-content > div.active").attr('id');
		var $search_val = [];
		var $search_ids = [];
		jQuery('#searchvehicle').find(".filter-option").each(function(e) { 
		if ( jQuery( this ).parent().parent().hasClass( "mandatory" ) ) {
				if(jQuery(this).text()=='Select') {
				jQuery(this).parent().addClass("input-error");
				isValid = false;
				jQuery(".loading-result-found").hide(); }
				else {
				jQuery(this).parent().removeClass("input-error");
				isValid = true;
				jQuery(".loading-result-found").show();
				}
			}
		$search_val.push(jQuery(this).text());
		});
		jQuery('#searchvehicle').find("select").each(function(e) { 
			$search_ids.push(jQuery(this).attr("id"));
		});
		$search_val.push(jQuery(this).text());
		
		if (isValid == false) {	return false; }
		jQuery.ajax({
            type: 'POST',
            url: values.ajaxurl,
            data: {
                action: 'imic_matched_results',
				ids: $search_ids,
                values: $search_val,
            },
            success: function(data) {
				//jQuery('.tabs-listing[data-rel='+$parent_div_id+']').addClass('completed');
				//jQuery(".completed").next().addClass('pending');
				jQuery(".loading-result-found").hide();
				jQuery("#finded-results").empty();
				jQuery("#finded-results").html(data);
				jQuery('ul.inline li').prepend('<i class="fa fa-caret-right"></i> ');
				//sai = $sb;
            },
            error: function(errorThrown) {
            }
        });
	});
	var $images;
	jQuery("input[name=sightMulti]").change(function() {
    var names = [];
    for (var i = 0; i < jQuery(this).get(0).files.length; ++i) {
        names.push(jQuery(this).get(0).files[i].name);
    }
    $images = jQuery("input[name=file]").val(names);
});
jQuery(".tabs-listing").live("click", function(){
	if(jQuery(this).hasClass("pending")||jQuery(this).hasClass("completed")||jQuery(this).hasClass("active"))
	{
		jQuery("#message").html();
	}
	else
	{
		jQuery(this).parent().find(".pending").addClass("active");
		jQuery("#message").html('<div class="alert alert-error">'+adds.tabs+'</div>');
	}
});
	jQuery(".save-searched-value").live('click',function() {
		$sb = jQuery(this).attr("id");
		var $matched_id = jQuery(this).attr('id');
		var $curr_obj = jQuery(this);
		var $images_arr = [], hash;
		var $parent_div_id = jQuery(".listing-form-content > div.active").attr('id');
		var $mileage = jQuery("#mileage-add").val();
		//var $price = jQuery("#price").val();
		var $price = jQuery("input[name=price]").val();
		var $phone = jQuery("#vehicle-contact-phone").val();
		var $email = jQuery("#vehicle-contact-email").val();
		var $selling_option = jQuery("input[name=Loan-Tenure]:checked").val();
		var $edit_post = jQuery("#vehicle-id").attr('class');
		var $mileage = jQuery("#mileage-add").val();
		var $category = imic_get_query_val('list-cat');
		var $search_val = [], hash;
		var $specs_ids = [], hash;
		var $tags = [], hash;
		var isValid = true;
		var notvalid = true;
		var valid = true;
		jQuery("#message").empty();
		if($matched_id=="ss") {
		if((jQuery("#listing-add-form-four").hasClass("active")) && (values.fileupload==1))
		{
		if(jQuery("#photoList").find('.col-md-2').length)
		{ }
		else
		{
		if(jQuery(".listing-images-uploads").val()=='')
		{
			jQuery("#message").empty(); 
			jQuery("#message").append('<div class="alert alert-error">'+adds.noimage+'</div>'); 
			jQuery("#photoimg").addClass("input-error");
			notvalid = false;
		}
		else
		{
			jQuery("#message").empty(); 
			jQuery("#photoimg").removeClass("input-error");
			valid = true;
		}
		if((notvalid==true)&&(valid==true)) { isValid = true; } else { isValid = false; }
		}
		}
		jQuery('.listing-form-content > div.active input.custom-cars-fields').each(function(e) { 
		if (jQuery( this ).hasClass( "mandatory" )) {
			if(jQuery(this).hasClass("finder"))
			{
			}
			else
			{
				var intRegex = /^\d+$/;
				var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
				if((jQuery(this).hasClass("integer-val"))&&(!floatRegex.test(jQuery(this).val())))
				{
					jQuery(this).addClass("input-error");
					notvalid = false; 
				}
				else if(jQuery(this).val()=='') 
				{
					jQuery(this).addClass("input-error");
					notvalid = false; 
				}
				else {
				jQuery(this).removeClass("input-error");
				valid = true;
				}
			}
			}
			if((notvalid==true)&&(valid==true)) 
			{ 
			isValid = true; 
			} 
			else 
			{ 
			isValid = false; 
			}
		}); }
		if($matched_id=="ss") {
		jQuery('.listing-form-content > div.active .custom-cars-fields .selectpicker span.filter-option, .listing-form-content > div.active input.custom-cars-fields').each(function(index, item) { 
		if ( jQuery( this ).parent().parent().hasClass( "mandatory" ) ) {
			if(jQuery(this).parent().parent().hasClass("finder"))
			{
				
			}
			else
			{
				if(jQuery(this).text()=='Select') {
				jQuery(this).parent().addClass("input-error");
				notvalid = false; }
				else {
				jQuery(this).parent().removeClass("input-error");
				valid = true;
				}
			}
			}
			if((notvalid==true)&&(valid==true)) 
			{ 
			isValid = true; 
			} 
			else 
			{ 
			isValid = false; 
			}
			if(jQuery(item).is(':input')) { $search_val.push(jQuery(item).val()); }
		else { $search_val.push(jQuery(item).text()); }
		}); }
		if($matched_id=="ss") 
		{
		      jQuery('.listing-form-content > div.active input.custom-cars-fields, .listing-form-content > div.active select.custom-cars-fields').each(function(index, item) {
			$specs_ids.push(jQuery(item).attr('id'));
		   }); 
		}
		if($edit_post!='') 
		{
			jQuery('.vehicle-tags').each(function(e) {
				var $id = '';
				$id = jQuery(this).attr('id');
				var $on = jQuery("#"+$id+":checked").val();
					if($on=="1") 
					{
						$tags.push($id);
						//$tags[$on+$id] = $id; Was used to make unique index of tags (Now we are using tag ID instead of slug)
					}
			}); 
		}
		if($matched_id=="ss") 
		{
		  if (isValid == false) 
			{	
			jQuery('html, body').animate({
        scrollTop: jQuery("#main-form-content").offset().top
    }, 2000);
			return false; 
			} 
		}
		jQuery("#vehicle-id").removeClass();
		if($matched_id!="ss") { $matched_id = $matched_id; } else { $matched_id = ""; }
		jQuery("#loading-listing-save").show();
		jQuery.ajax({
            type: 'POST',
            url: values.ajaxurl,
			async: false,
            data: {
                action: 'imic_create_vehicle',
                matched: $matched_id,
				values: $search_val,
				mids: $specs_ids,
				post_id: $edit_post,
				tags: $tags,
				phone: $phone,
				email: $email,
				price: $price,
				listing_view: $selling_option,
				steps: $parent_div_id,
				category: $category,
				remain: adds.remain,
				plan: adds.plans
            },
            success: function(data) {
				var $total_percent = jQuery('.completed').length;
				var $total = $total_percent*20;
				    jQuery(".listing-form-progress .progress-bar").
				      attr("data-appear-progress-animation",$total+"%").
				      width($total+"%");
				if(data!='') {
				jQuery("#vehicle-id").addClass(data);
				jQuery("#vehicle-id").val(data);
				jQuery(".custom-create-vehicle").prop('disabled',true); }
				var sai = $matched_id;
				/* add whenever user come after plan selected */
				if(imic_get_query_val("plans")!==''||imic_get_query_val("plans")!=='none')
				{
					if(imic_get_query_val("edit")===''||imic_get_query_val("edit")==='none')
					{
					  var edited_url = imic_update_url("edit",data,'');
					  HistoryPush(edited_url);
					}
				}
				jQuery('#results-holder').each(function() {
				jQuery(this).find('.result-item').matchHeight();
			});
			jQuery('html, body').animate({
        scrollTop: jQuery("#main-form-content").offset().top
    }, 2000);
            },
            error: function(errorThrown) {
            }
        });
	});
	jQuery( ".tabs-listing" ).click(function(e){
		if(jQuery(this).hasClass("completed")||jQuery(this).hasClass("pending")) {
		jQuery(this).attr('data-toggle','tab'); }
		else {
		jQuery(this).attr('data-toggle','');
		}
	});
	 jQuery("#loading").hide();
       if(window.File && window.FileList && window.FileReader && jQuery("#photoimg").length>0){
        document.getElementById("photoimg").addEventListener("change", function(event){
            jQuery('#photoList_new').empty();
            var files = event.target.files; //FileList object
            for(var i = 0; i< files.length; i++){
                var file = files[i];
                if(!file.type.match('image')){ continue; }
                var multiPhotoReader = new FileReader();
                multiPhotoReader.addEventListener("load",function(event){
                    var img = event.target;
                    var div = document.createElement("div");
					div.setAttribute("class", 'col-md-2 col-sm-2');
                    div.innerHTML = "<img class='thumbnail' width='127' height ='95' src='" + img.result + "'" +
                            "title='" + img.name + "'/>";
					document.getElementById("photoList_new").insertBefore(div,null);            
});
                multiPhotoReader.readAsDataURL(file);
            }                               
        });
    }
	var clkBtn = "";
      jQuery('input[type="submit"]').click(function(evt) {
        clkBtn = evt.target.id;
		});
	jQuery("form[name='uploadfrm']").submit(function(event){
		var $parent_div_id = jQuery(".listing-form-content > div.active").attr('id');
		var $video = jQuery("#vehicle-video").val();
		var $detail = jQuery("#vehicle-detail").val();
		var isValid = true;
		 var btnID = clkBtn;
		 var saibaba = $sb;
		 //alert(saibaba);
		 if(btnID=="final-pay") { isValid = false; }
		 if(saibaba!="find-matched-cars") {
		var $edit_post = jQuery("#vehicle-id").attr('class');
            jQuery("#loading").show();
			
			if(window.FileReader && values.isDefault==0)
			{

		      var formData = new FormData(jQuery(this)[0]);
               jQuery.ajax({
                url: values.tmpurl+"/template-image-by-ajax-back.php",
                type: "POST",
                data: formData,
                async: false,
			    cache: false,
                contentType: false,
                processData: false,
                success: function(msg){
					jQuery("#loading-listing-save").hide();
					jQuery("#message").empty();
					jQuery("#message").append('<div class="alert alert-success">'+adds.successaved+'</div>');
					jQuery('#photoimg').val(''); 
					jQuery('.tabs-listing[data-rel='+$parent_div_id+']').addClass('completed');
					jQuery('.tabs-listing[data-rel='+$parent_div_id+']').removeClass('active pending');
					jQuery('#'+$parent_div_id).removeClass('active in');
					jQuery('#'+$parent_div_id).next().addClass('active in');
					jQuery('.tabs-listing[data-rel='+$parent_div_id+']').next().addClass('pending active');
				var $total_percent = jQuery('.completed').length;
				var $total = $total_percent*20;
				jQuery(".listing-form-progress .progress-bar").attr("data-appear-progress-animation",$total+"%").width($total+"%");
                    jQuery("#loading").hide();
                   },

            }); 
			}
			else
			{
              var formData = $('#uploadfrm').serialize();
              jQuery.ajax({
                url: values.tmpurl+"/template-image-by-ajax-back.php",
                type: "POST",
                data: formData,
                success: function(msg){
					jQuery("#loading-listing-save").hide();
					jQuery("#message").empty();
					jQuery("#message").append('<div class="alert alert-success">'+adds.successaved+'</div>');
					jQuery('#photoimg').val(''); 
					jQuery('.tabs-listing[data-rel='+$parent_div_id+']').addClass('completed');
					jQuery('.tabs-listing[data-rel='+$parent_div_id+']').removeClass('active pending');
					jQuery('#'+$parent_div_id).removeClass('active in');
					jQuery('#'+$parent_div_id).next().addClass('active in');
					jQuery('.tabs-listing[data-rel='+$parent_div_id+']').next().addClass('pending active');
				var $total_percent = jQuery('.completed').length;
				var $total = $total_percent*20;
				jQuery(".listing-form-progress .progress-bar").attr("data-appear-progress-animation",$total+"%").width($total+"%");
                    jQuery("#loading").hide();
                   },

            }); 
		   }
		 }
			
		if(isValid==true) { return false; }
        });  
		
		jQuery(".sortable-specs").live('change',function() {
		var $spec_id = jQuery(this).attr("id");
		var $par = jQuery(this).parent();
		
		var $select_sort_val = jQuery("#"+$spec_id+" option:selected").val();
		if($select_sort_val=="0") {
			jQuery($par).find(".sorting-dynamic").hide();
		}
		else {
			jQuery($par).find(".sorting-dynamic").show();
		}
		var $spec_val_sort = jQuery(this).val();
		jQuery.ajax({
            type: 'POST',
            url: values.ajaxurl,
            data: {
                action: 'imic_sortable_specification',
				sorting: $spec_val_sort,
				spec_id: $spec_id
            },
            success: function(data) {
				var $dyna_div = $spec_id;
				$dyna_div = $dyna_div.split("-");
				var $dyna_id = $dyna_div[1]-2648;
				$dyna_id = ($dyna_id*111)+2648;
				//alert($dyna_div[0]+"-"+$dyna_id);
				jQuery("#"+$spec_id+":hidden").html();
				jQuery("."+$dyna_div[0]+"-"+$dyna_id).html(data);
				if($spec_val_sort=="0") { jQuery(".sorting-dynamic").hide(); }
				jQuery('.selectpicker').selectpicker({container:'body'});
				jQuery("#main-section-listing").scrollTop($("#main-section-listing").scrollTop() + 100);
            },
            error: function(errorThrown) {
            }
        });
		return false;
	}); 
	
	jQuery("#find-price").click(function(){
		jQuery.ajax({
			type:'POST',
			url: values.ajaxurl,
			data: {
				action: 'imic_price_guide',
				id: jQuery("#vehicle-id").attr("class"),
			},
			success: function(data){
				jQuery("#price-guide").empty();
				jQuery("#price-guide").append(data);
			},
			error: function(errorThrown) {
				
			}
		});
	});
	jQuery(".tabs-listing").click(function(){
		jQuery("#message").empty();
	});
	//Select Plan between listing
		jQuery(".select-plan").click(function(){
			var $id = jQuery(this).find(".plan-id").text();
			var $title = jQuery(this).find(".plan-title").text();
			var $url = jQuery(this).find(".plan-url").text();
			var $price = jQuery(this).find(".plan-price-sh").text();
			var $thanks = jQuery(this).find(".plan-thanks").text();
			var $vehicle_id = jQuery("#vehicle-id").attr("class");
			var edited_url = imic_update_url("plans",$id,'');
			if(imic_get_query_val("edit")===''||imic_get_query_val("edit")==='none')
			{
			  edited_url+='&edit='+$vehicle_id;
			}
			  HistoryPush(edited_url); 
			 //history.pushState('', '', imic_update_url("plans",$id,''));
			//history.pushState('', '', imic_update_url("edit",$vehicle_id,''));
			jQuery(".current-plan").empty();
			jQuery(".current-plan").append($title);
			jQuery("#plan-select").hide();
			
			jQuery("input[name=amount]").val($price);
			jQuery("input[name=item_name]").val($title);
			jQuery("input[name=item_number]").val($id);
			//alert($thanks);
			var $url_thanks = imic_update_url("plans",$id,$thanks);
			var $new_url = imic_update_url("edit",$vehicle_id,$url_thanks);
			jQuery("input[name=return]").val($new_url);
			if($url=='') { $url = $new_url; }
			jQuery('#uploadfrm').attr('action', $url);
			jQuery('#plan-select').modal('hide')
			//jQuery("#plan-select").dialog("close");
			//jQuery("a#ss").attr("href",$url);
			return false;
		});
	//Add vehicle id to url
		/*jQuery("#final-pay").click(function(){
			jQuery('#plan-select').removeData("bs.modal");
			jQuery('#plan-select').hide();
			
		});*/
	//Add User Info while Listing
	jQuery("#final-pay").click(function(){
		var $uid = jQuery("#uid").val();
		var $uinfo = jQuery("#uinfo").val();
		var $fname = jQuery("#fname").val();
		var $lname = jQuery("#lname").val();
		var $uzip = jQuery("#uzip").val();
		var $uphone = jQuery("#uphone").val();
		var $ucity = jQuery("#ucity").val();
		var $ustate = jQuery("#ustate").val();
		var $id = jQuery("#vehicle-id").attr("class");
		/* HistoryPush(imic_update_url("edit",$id,'')); */
		//history.pushState('', '', imic_update_url("edit",$id,''));
		var $form_action = jQuery('#uploadfrm').attr('action');
		jQuery("#message").empty();
		if($fname=='') { jQuery("#fname").addClass("input-error"); } else { jQuery("#fname").removeClass("input-error"); }
		if($lname=='') { jQuery("#lname").addClass("input-error"); } else { jQuery("#lname").removeClass("input-error"); }
		if($uphone=='') { jQuery("#uphone").addClass("input-error"); } else { jQuery("#uphone").removeClass("input-error"); }
		if($uzip=='') { jQuery("#uzip").addClass("input-error"); } else { jQuery("#uzip").removeClass("input-error"); }
		if($ucity=='') { jQuery("#ucity").addClass("input-error"); } else { jQuery("#ucity").removeClass("input-error"); }
		if($fname!=''&&$lname!=''&&$uphone!=''&&$uzip!=''&&$ucity!='') {
			if(values.plans=="1"&&adds.remain!="1") 
			{
						
				if((imic_get_query_val("plans")=="")||(imic_get_query_val("plans")==="none")||($form_action==''))
				 {
					 jQuery("#message").empty(); 
					 jQuery("#message").append('<div class="alert alert-error">'+adds.selectplan+'</div>'); 
					 return false;
				 } 
				else 
				{
				    jQuery("#message").empty();
				} 
			}
			else 
			{ 
				var $form_action = jQuery('#uploadfrm').attr('action');
				var $vehicle_ids = jQuery("#vehicle-id").attr("class");
				var $url_thank = imic_update_url("edit",$vehicle_ids,$form_action);
				jQuery('#uploadfrm').attr('action', $url_thank);
			}
			if(adds.remain=="1") 
			{
				var $form_actions = jQuery('#uploadfrm').attr('action');
				var $vehicle_ids = jQuery("#vehicle-id").attr("class");
				var $url_thanks = imic_update_url("tx",$vehicle_ids*4,$form_actions);
				jQuery('#uploadfrm').attr('action', $url_thanks);
			}
			jQuery("#loading-listing-save").show();
			var $query_vars_val = getUrlParams_ads();
		jQuery.ajax({
			type:'POST',
			url:values.ajaxurl,
			async: false,
			data: {
				action:'imic_update_user_info',
				uid: $uid,
				uinfo: $uinfo,
				fname: $fname,
				lname: $lname,
				phone: $uphone,
				zip: $uzip,
				city: $ucity,
				state: $ustate,
				currentid: $id,
				queryv: $query_vars_val
			},
			success: function(data) {
				jQuery("#loading-listing-save").hide();
			},
			erro: function(errorThrown) {
				
			}
		}); }
		if(values.plans=="1") {
			if($fname==''||$lname==''||$uphone==''||$uzip==''||$ucity=='') { return false; }
		}
	});
	
	/* check if browser supprt html5 or not. */
	function IsHtml5Support()
	{
		if(!!window.FileReader)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	/* custom history push */
	function HistoryPush(query)
	{
		if(IsHtml5Support())
		{
			 history.pushState('', '', query);
		}
		else 
		{
			 window.location.href = query;
		}
	}
});
})(jQuery);