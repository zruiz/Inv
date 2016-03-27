jQuery(document).ready(function(){
	function imic_update_url_cats(key, value, url) {
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
function getUrlParams_cats() {
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
	jQuery(".get-child-cat").live('change',function() {
		//alert("saibaba");
		var $this_id = jQuery(this).parent().attr("id");
		var $slug = jQuery(this).val();
		var $blank = jQuery(this).find(':selected').data('val');
		var $page = jQuery(this).data('page');
		
		if($blank=="blank")
		{
			jQuery('#'+$this_id).nextAll('div').remove();
		}
		else
		{
			jQuery(jQuery(this).parent().parent().find("#loading-field")).show();
			jQuery("#child-field-loading").show();
			jQuery.ajax({
				type:'POST',
				url:classified.ajaxurl,
				async: false,
				data: {
					action:'imi_get_child_category',
					parents: $slug,
					ids: $this_id,
					pagess: $page,
				},
				success: function(data) {
					//alert(data);
					(jQuery('#'+$this_id).parent().find("#loading-field")).hide();
					jQuery("#child-field-loading").hide();
					jQuery('#'+$this_id).nextAll('div').remove();
					jQuery('#'+$this_id).parent().append(data);
					jQuery('.selectpicker').selectpicker({container:'body'});
				},
				erro: function(errorThrown) {
				
				}
			});
		}
		if($page=="ad")
		{
			jQuery(".waiting").fadeIn();
			var $id = jQuery("#vehicle-id").attr("class");
		jQuery.ajax({
            type: 'POST',
            url: classified.ajaxurl,
            data: {
                action: 'imic_set_ad_fields',
                slug: $slug,
				update:$id
            },
            success: function(data) {
				jQuery(".waiting").fadeOut();
				if(data!='blank')
				{
					jQuery("#addcustom").empty();
					jQuery("#addcustom").html(data);
					jQuery('.selectpicker').selectpicker({container:'body'});
				}
            },
            error: function(errorThrown) {
            }
        });
		jQuery.ajax({
            type: 'POST',
            url: classified.ajaxurl,
            data: {
                action: 'imic_set_tags_fields',
                slug: $slug,
				update:$id
            },
            success: function(data) {
				if(data!='blank')
				{
					jQuery("#dynamic-tags").empty();
					jQuery("#dynamic-tags").html(data);
				}
            },
            error: function(errorThrown) {
            }
        });
		}
		if($page!='')
		{
			history.pushState('', '', imic_update_url_cats("list-cat",$slug,''));
		}
		if($page!="ad"&&$page!='')
		{
		var $cat_vars = getUrlParams_cats();
		var $category = "1";
		jQuery(".waiting").fadeIn();
		jQuery.ajax({
            type: 'POST',
            url: classified.ajaxurl,
            data: {
                action: 'imic_search_result',
                values: $cat_vars,
				category: $category,
            },
            success: function(data) {
				jQuery(".waiting").fadeOut();
				if($page=="yes")
				{
					jQuery("#listing-with-filter").empty();
					jQuery("#listing-with-filter").html(data);
				}
				else
				{
					jQuery("#results-holder").empty();
					jQuery("#results-holder").html(data);
				}
				jQuery('ul.inline li').prepend('<i class="fa fa-caret-right"></i> ');
				jQuery(".format-standard").each(function(){
					jQuery(this).find(".media-box").append("<span class='zoom'><span class='icon'><i class='icon-plus'></i></span></span>");
				});
            },
            error: function(errorThrown) {
            }
        });
		}
	});
	jQuery(".matched-tags-list a").live("click",function(){
		if(jQuery(this).hasClass("act-tag"))
		{
			jQuery(this).removeClass("act-tag");
			jQuery(this).find("i").remove();
			
		}
		else
		{
			jQuery(this).addClass("act-tag");
			jQuery(this).append(" <i class=\"fa fa-check\"></i>");
		}
		$tags = [];
		jQuery(".matched-tags-list .act-tag").each(function(index, element) {
            $tags.push(jQuery(this).html());
        });
		var $category = "0";
		var $cat_vars = getUrlParams_cats();
		jQuery(".waiting").fadeIn();
		jQuery.ajax({
            type: 'POST',
            url: classified.ajaxurl,
            data: {
                action: 'imic_search_result',
                values: $cat_vars,
				tags: $tags,
				category: $category
            },
            success: function(data) {
				jQuery(".waiting").fadeOut();
				jQuery("#results-holder").empty();
				jQuery("#results-holder").html(data);
				jQuery('ul.inline li').prepend('<i class="fa fa-caret-right"></i> ');
				jQuery(".format-standard").each(function(){
					jQuery(this).find(".media-box").append("<span class='zoom'><span class='icon'><i class='icon-plus'></i></span></span>");
				});
            },
            error: function(errorThrown) {
            }
        });
	});
});