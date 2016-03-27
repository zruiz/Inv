(function($) {
  "use strict";
jQuery(document).ready(function(){
	function imic_ger_query_vars()
{
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
	function Update_compare_url(key, value, url) {
		if(value!=null) {
		if (value.indexOf('$') > -1) {
			value = value.replace('$', 'cu');
			//value = 'ss';
		} }
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
	jQuery('.compare-in-box').hide();
	if((jQuery('ul.saved-cars-box li').length) > 1) { jQuery(".compare-in-box").show(); }
	if((jQuery('table.saved-cars-box tr').length) > 1) { jQuery(".compare-in-box").show(); }
	jQuery(".saved-cars-box .checkb").live('click',function(){
		//$("input").prop('disabled', true);
		//$("input").prop('disabled', false);
		var ids = [];
		jQuery(".compare-check").each(function(){
			var $id = jQuery(this).attr("id");
			var $on = jQuery("#"+$id+":checked").val();
			//alert($on);
			if($on==0||$on==1) {
			var $saved_id = $id.split("-");
			ids.push($saved_id[1]); }
		});
		if(ids.length>3) { alert("You can not select more than 3 listing to compare"); } else {
		var ids = ids.join('-');
		var $check_length = jQuery(".saved-cars-box input:checkbox:checked").length;
		if ($check_length > 1) { jQuery(".compare-in-box").removeAttr('disabled');
		jQuery(".compare-in-box").text("Compare("+$check_length+")");
		var $url = jQuery(".compare-in-box").attr("href");
		var $new_url = Update_compare_url("compare",ids,$url);
		jQuery(".compare-in-box").attr("href", $new_url);
		}
		else { jQuery(".compare-in-box").attr('disabled','disabled');
		jQuery(".compare-in-box").text("Compare()"); } }
	});
	jQuery('.compare-viewed-box').hide();
	if((jQuery('ul#viewed-cars-listbox li').length) > 1) { jQuery(".compare-viewed-box").show(); }
	jQuery("#viewed-cars-listbox .checkb").live('click',function(){
		//$("input").prop('disabled', true);
		//$("input").prop('disabled', false);
		var viewed_ids = [];
		jQuery(".compare-viewed").each(function(){
			var $id_view = jQuery(this).attr("id");
			var $on = jQuery("#"+$id_view+":checked").val();
			if($on==0) {
			var $car_id = $id_view.split("-");
			viewed_ids.push($car_id[1]); }
		});
		var viewed_ids = viewed_ids.join('-');
		var $check_length = jQuery("#viewed-cars-listbox input:checkbox:checked").length;
		if ($check_length > 1) { jQuery(".compare-viewed-box").removeAttr('disabled');
		jQuery(".compare-viewed-box").text("Compare("+$check_length+")");
		var $url = jQuery(".compare-viewed-box").attr("href");
		var $new_url = Update_compare_url("compare",viewed_ids,$url);
		jQuery(".compare-viewed-box").attr("href", $new_url);
		}
		else { jQuery(".compare-viewed-box").attr('disabled','disabled');
		jQuery(".compare-viewed-box").text("Compare()"); }
	});
	jQuery(".save-car").live('click',function(){
		var cart = jQuery('.tools-bar');
		
		var $this_item = jQuery(this);
		if(jQuery(this).attr("rel")!="popup-save") {
        var imgtodrag = jQuery(this).parent().parent().parent().parent().parent('.result-item').find("img").eq(0);
        if (imgtodrag) {
            var imgclone = imgtodrag.clone()
                .offset({
                top: imgtodrag.offset().top,
                left: imgtodrag.offset().left
            })
                .css({
                'opacity': '0.5',
                    'position': 'absolute',
                    'height': '150px',
                    'width': '150px',
                    'z-index': '100'
            })
                .appendTo(jQuery('body'))
                .animate({
                'top': cart.offset().top + 10,
                    'left': cart.offset().left + 10,
                    'width': 75,
                    'height': 75
            }, 1000, 'easeInOutExpo');
            imgclone.animate({
                'width': 0,
                    'height': 0
            }, function () {
                jQuery(this).detach()
            });
        } }
		var $save_item = jQuery(this).attr('id');
		var $vehicle_id = jQuery(this).find(".vehicle-id").text();
		
		jQuery(this).attr('disabled','disabled');
		jQuery.ajax({
            type: 'POST',
            url: values.ajaxurl,
            data: {
                action: 'imic_vehicle_add',
                vehicle_id: $vehicle_id,
				save_item: $save_item,
            },
            success: function(data) {
				//alert(data);
				jQuery("li.blank").remove();
				jQuery($this_item).find("i").removeClass("fa-star-o");
				jQuery($this_item).find("i").addClass("fa-star");
				if($vehicle_id=="unsaved") { jQuery(".saved-cars-box li").remove(); }
				jQuery(".saved-cars-box").prepend(data);
				jQuery('.saved-cars-box li:gt(0):lt(' + (jQuery('.saved-cars-box li').length - 3) + ')').remove();
				if((jQuery('ul.saved-cars-box li').length) > 1) { jQuery(".compare-in-box").show(); }
				else { jQuery(".compare-in-box").hide(); }
            },
            error: function(errorThrown) {
            }
        });
		return false;
	});
	jQuery("#reset-filters-search").live('click',function(){
		var $vars = imic_ger_query_vars();
		//alert($vars);
		jQuery.each($vars,function(index,value){
			if(index!="page_id") {
				HistoryPush(Update_compare_url(index,null,''))
			    //history.pushState('', '', Update_compare_url(index,null,''));
				 }
		});
		jQuery("#search-tab").empty();
		jQuery.ajax({
            type: 'POST',
            url: values.ajaxurl,
            data: {
                action: 'imic_search_result',
                values: '',
				//paginate: $page_val,
            },
            success: function(data) {
				jQuery("#results-holder").empty();
				jQuery("#results-holder").html(data);
            },
            error: function(errorThrown) {
            }
        });
		return false;
	});
	jQuery(".save-search").live('click',function(){
		var $search_title = jQuery("#search-title").val();
		var $search_desc = jQuery("#search-desc").val();
		var $url = document.location.href;
		var $search_vehicle_id = jQuery(this).find(".search-vehicle-id").text();
		//alert($vehicle_id);
		jQuery.ajax({
            type: 'POST',
            url: values.ajaxurl,
			//processData: true,
			//contentType: 'application/json',
            data: {
                action: 'imic_save_search',
                search_title: $search_title,
				search_desc: $search_desc,
				search_url: $url,
				//images: $images_arr,
            },
            success: function(data) {
				jQuery("#blank-search").remove();
				if($search_vehicle_id=="unsaved") { jQuery("#search-saved li").remove(); }
				if(data=='') { jQuery("#messages").html("<div class=\"alert alert-error\">You have already saved this search</div>"); }
				else { jQuery("#messages").html("<div class=\"alert alert-success\">Successfully Saved</div>"); }
				jQuery("#search-saved").append(data);
            },
            error: function(errorThrown) {
            }
        });
	});
	jQuery(".delete-saved").live('click',function(e){
		var $saved_items = [], hash;
		var $delete_type = jQuery(this).attr("rel");
		if($delete_type=="specific-saved-ad") {
		var $save_id = jQuery(this).find(".saved-id").text();
		var $save_id_val = $save_id.split("-");
		$saved_items.push($save_id_val[1]); } else {
		jQuery(".remove-saved").each(function(e){
			var $id = '';
			$id = jQuery(this).attr('id');
			var $id_val = $id.split("-");
			//alert($id);
			var $on = jQuery("#"+$id+":checked").val();
			//alert($on);
			if($on=="1") {
				$saved_items.push($id_val[1]);
        		//$saved_items[e] = $id; 
			}
		}); }
		if($saved_items!='') {
		e.preventDefault();
    jQuery('#confirm-delete').modal({ backdrop: 'static', keyboard: false })
        .on('click', '#delete', function (e) {
		//alert($saved_items);
		jQuery.ajax({
            type: 'POST',
            url: values.ajaxurl,
			//processData: true,
			//contentType: 'application/json',
            data: {
                action: 'imi_remove_cars',
                saved: $saved_items,
            },
            success: function(data) {
				//alert(data);
				var i;
				for (i = 0; i < $saved_items.length; ++i) {
					var rowCount = jQuery('#saved-cars-table tr').length;
					//alert(rowCount);
					if(rowCount!=2) {
					jQuery("#saved-"+$saved_items[i]).parent().parent().remove(); }
					else {
						jQuery("#saved-cars-section").remove();
					}
					// do something with `substr[i]`
				}
				//jQuery("#search-saved").append(data);
            },
            error: function(errorThrown) {
            }
        });
	}); } });
	//Delete session saved cars
	jQuery(".delete-box-saved").live('click',function(e){
		var $li_element = jQuery(this);
		var $saved_items = [], hash;
		var $delete_type = jQuery(this).attr("rel");
		if($delete_type=="specific-saved-ad") {
		$saved_items.push(jQuery(this).find(".saved-id").text()); }
		jQuery(".remove-saved").each(function(e){
			$id = '';
			$id = jQuery(this).attr('id');
			//alert($id);
			$on = jQuery("#"+$id+":checked").val();
			//alert($on);
			if($on=="1") {
				$saved_items.push($id);
        		//$saved_items[e] = $id; 
			}
		});
		if($saved_items!='') {
		e.preventDefault();
    	jQuery('#confirm-delete').modal({ backdrop: 'static', keyboard: false })
        .on('click', '#delete', function (e) {
		jQuery.ajax({
            type: 'POST',
            url: values.ajaxurl,
            data: {
                action: 'imi_remove_cars',
                saved: $saved_items,
            },
            success: function(data) {
				jQuery('#confirm-delete').removeData("bs.modal");
				jQuery('#confirm-delete').hide();
				$li_element.parent().remove();
				if((jQuery('ul.saved-cars-box li').length) > 1) { jQuery(".compare-in-box").show(); }
				else { jQuery(".compare-in-box").hide(); }
            },
            error: function(errorThrown) {
            }
        });
	}); } });
	jQuery(".delete-search").live('click',function(e){
		var $search_items = [], hash;
		var $delete_type = jQuery(this).attr("id");
		//alert(jQuery(this).find(".search-id").text());
		if($delete_type=="specific-search-ad") {
		$search_items.push(jQuery(this).find(".search-id").text()); }
		jQuery(".remove-search").each(function(e){
			var $id = '';
			$id = jQuery(this).attr('id');
			//alert($id);
			var $on = jQuery("#"+$id+":checked").val();
			//alert($on);
			if($on=="1") {
				$search_items.push($id);
        		//$saved_items[e] = $id; 
			}
		});
		if($search_items!='') {
		e.preventDefault();
    jQuery('#confirm-delete').modal({ backdrop: 'static', keyboard: false })
        .on('click', '#delete', function (e) {
		//alert($saved_items);
		jQuery.ajax({
            type: 'POST',
            url: values.ajaxurl,
			//processData: true,
			//contentType: 'application/json',
            data: {
                action: 'imi_remove_search',
                search_items: $search_items,
            },
            success: function(data) {
				jQuery('#confirm-delete').removeData("bs.modal");
				jQuery('#confirm-delete').hide();
				if(data=="success") {
				var i;
				for (i = 0; i < $search_items.length; ++i) {
					var rowCount = jQuery('#search-cars-table tr').length;
					//alert(rowCount);
					if(rowCount!=2) {
					jQuery("#"+$search_items[i]).parent().parent().remove(); }
					else {
						jQuery("#search-cars-section").remove();
					}
					// do something with `substr[i]`
				} }
				//jQuery("#search-saved").append(data);
            },
            error: function(errorThrown) {
            }
        });
	}); } });
	//Delete Search Session
	jQuery(".delete-box-search").live('click',function(e){
		var $search_items = [], hash;
		var $delete_type = jQuery(this).attr("id");
		//alert(jQuery(this).find(".search-id").text());
		if($delete_type=="specific-search-ad") {
		$search_items.push(jQuery(this).find(".search-id").text()); }
		jQuery(".remove-search").each(function(e){
			$id = '';
			$id = jQuery(this).attr('id');
			//alert($id);
			$on = jQuery("#"+$id+":checked").val();
			//alert($on);
			if($on=="1") {
				$search_items.push($id);
        		//$saved_items[e] = $id; 
			}
		});
		//alert($search_items.length);
		if ($search_items.length > 0) {
		e.preventDefault();
    jQuery('#confirm-delete').modal({ backdrop: 'static', keyboard: false })
        .on('click', '#delete', function (e) {
		//alert($saved_items);
		jQuery.ajax({
            type: 'POST',
            url: values.ajaxurl,
			//processData: true,
			//contentType: 'application/json',
            data: {
                action: 'imi_remove_search',
                search_items: $search_items,
            },
            success: function(data) {
				jQuery('#confirm-delete').removeData("bs.modal");
				jQuery('#confirm-delete').hide();
				jQuery("#"+$delete_type).parent().remove();
            },
            error: function(errorThrown) {
            }
        });
	}); } });
	jQuery(".delete-ads").live('click',function(e){
		var $ads_items = [], hash;
		var $delete_type = jQuery(this).attr("id");
		if($delete_type=="specific-ad") {
		$ads_items.push(jQuery(this).find(".ad-id").text()); }
		jQuery(".remove-ads").each(function(e){
			var $id = '';
			$id = jQuery(this).attr('id');
			//alert($id);
			var $on = jQuery("#"+$id+":checked").val();
			//alert($on);
			if($on=="1") {
				$ads_items.push($id);
        		//$saved_items[e] = $id; 
			}
		});
		if($ads_items!='') {
		e.preventDefault();
    jQuery('#confirm-delete').modal({ backdrop: 'static', keyboard: false })
        .on('click', '#delete', function (e) {
		//alert($saved_items);
		jQuery.ajax({
            type: 'POST',
            url: values.ajaxurl,
			//processData: true,
			//contentType: 'application/json',
            data: {
                action: 'imi_remove_ads',
                ads: $ads_items,
            },
            success: function(data) {
				jQuery('#confirm-delete').removeData("bs.modal");
				jQuery('#confirm-delete').hide();
				if(data=="success") {
				var i;
				for (i = 0; i < $ads_items.length; ++i) {
					var rowCount = jQuery('#search-cars-table tr').length;
					//alert(rowCount);
					if(rowCount!=2) {
					jQuery("#"+$ads_items[i]).parent().parent().remove(); }
					else {
						jQuery("#ads-section").remove();
					}
					// do something with `substr[i]`
				} }
				//jQuery("#search-saved").append(data);
            },
            error: function(errorThrown) {
            }
        });
	}); } });
//Change status from dashboard manage
	jQuery(".deactivate-ad").live('click',function(e){
		var $this_button = jQuery(this);
		var $delete_type = jQuery(this).attr("id");
		var $ads_items = jQuery(this).find(".ad-id").text();
		var $ad_next_status = jQuery(this).find(".ad-next-status").text();
		jQuery.ajax({
            type: 'POST',
            url: values.ajaxurl,
			//processData: true,
			//contentType: 'application/json',
            data: {
                action: 'imi_update_status_ads',
                ads: $ads_items,
				next_status: $ad_next_status,
            },
            success: function(data) {
				jQuery($this_button).remove();
				jQuery("#ad-"+$ads_items).text(data);
            },
            error: function(errorThrown) {
            }
        });
	});
//Remove saved cars from session
jQuery(".session-save-car").live('click',function(){
	var $this_session = jQuery(this).attr("id");
	jQuery.ajax({
		type: 'POST',
		url: values.ajaxurl,
		data:{
			action: 'imic_remove_session_saved',
			sessions: $this_session
		},
		success: function(data) {
			jQuery("#"+$this_session).closest("li").remove();
		},
	});
	return false;
});
//Remove Default message li
var $viewed_list_length = jQuery("#viewed-cars-listbox li").length;
if($viewed_list_length>1) {
	jQuery('ul#viewed-cars-listbox li:first-child').remove();
}

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