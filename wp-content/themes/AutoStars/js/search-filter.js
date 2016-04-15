(function($) {
  "use strict";
jQuery(document).ready(function(){
	var $select_sort_val = jQuery(".sorting-dynamic option:selected").val();
	if($select_sort_val=="0") {
	}
	var $query_var, $query_val;
	function UpdateQueryString(key, value, url) {
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
function getUrlParams() {
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
function imic_get_query_vals(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
//alert(getUrlParams());
function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
		if(hash[0]!="page_id") {
        vars.push(hash[1]);
        vars[hash[0]] = hash[1]; }
    }
    return vars;
}
		jQuery("#quick-paginate a").click(function(){
			var $page_val = jQuery(this).text();
			jQuery("#quick-paginate a").removeClass("active");
			jQuery(this).addClass('active');
			 HistoryPush(UpdateQueryString("paged",null,''));
			 HistoryPush(UpdateQueryString("pg",$page_val,''));
			//history.pushState('', '', UpdateQueryString("pg",$page_val,''));
			//history.pushState('', '', UpdateQueryString("paged",null,''));
			var $vars = getUrlParams();
			//jQuery("#search-tab").empty();
			jQuery(".waiting").fadeIn();
			jQuery.ajax({
            type: 'POST',
            url: values.ajaxurl,
            data: {
                action: 'imic_search_result',
                values: $vars,
				paginate: $page_val,
            },
            success: function(data) {
				jQuery(".waiting").fadeOut();
				jQuery("#page-paginate").remove();
				jQuery("#results-holder").empty();
				jQuery("#results-holder").html(data);
				jQuery('ul.inline li').prepend('<i class="fa fa-caret-right"></i> ');
				jQuery(".format-standard").each(function(){
					jQuery(this).find(".media-box").append("<span class='zoom'><span class='icon'><i class='icon-plus'></i></span></span>");
				});
				jQuery('#results-holder').each(function() {
				jQuery(this).find('.result-item').matchHeight();
			});
            },
            error: function(errorThrown) {
            }
        });
			return false;
		});
		
		jQuery("#page-paginate a").live('click',function(){
			var $page_val = jQuery(this).attr("id");
			var $page_id = $page_val.split("-");
			jQuery("#page-paginate li").removeClass("active");
			jQuery(this).parent().addClass('active');
			HistoryPush(UpdateQueryString("pg",null,''));
			HistoryPush(UpdateQueryString("paged",$page_id[1],''));
			//history.pushState('', '', UpdateQueryString("pg",null,''));
			//history.pushState('', '', UpdateQueryString("paged",$page_id[1],''));
			var $vars = getUrlParams();
			//jQuery("#search-tab").empty();
			jQuery(".waiting").fadeIn();
			jQuery.ajax({
            type: 'POST',
            url: values.ajaxurl,
            data: {
                action: 'imic_search_result',
                values: $vars,
				paginate: $page_id[1],
            },
            success: function(data) {
				//alert(data);
				jQuery("#page-paginate").remove();
				jQuery(".waiting").fadeOut();
				jQuery("#results-holder").empty();
				jQuery("#results-holder").html(data);
				jQuery('ul.inline li').prepend('<i class="fa fa-caret-right"></i> ');
				jQuery(".format-standard").each(function(){
					jQuery(this).find(".media-box").append("<span class='zoom'><span class='icon'><i class='icon-plus'></i></span></span>");
				});
				jQuery('body,html').animate({ scrollTop: "212" }, 750, 'easeOutExpo' );
				jQuery("#"+$page_val).addClass("active");
				var time = 500;
				jQuery('#results-holder').each(function() {
					setTimeout( function(){ jQuery(this).find('.result-item').matchHeight(); }, time);
      		time += 1500;
				});
            },
            error: function(errorThrown) {
            }
        });
			return false;
		});
	//jQuery(".search-price").click(function(){
		jQuery("#search-tab li").live('click',function() {
			var $element = jQuery(this).attr('id');
			jQuery("li#"+$element).remove();
			//alert($element);

			HistoryPush(UpdateQueryString($element,null,''));
			//history.pushState('', '', UpdateQueryString($element,null,''));
			var $vars = getUrlParams();

			console.log($vars);

			jQuery(".waiting").fadeIn();
        jQuery.ajax({
            type: 'POST',
            url: values.ajaxurl,
            data: {
                action: 'imic_search_result',
                values: $vars,
            },
            success: function(data) {
				jQuery("#page-paginate").remove();
				jQuery(".waiting").fadeOut();
				jQuery("#results-holder").empty();
				jQuery("#results-holder").html(data);
				jQuery('ul.inline li').prepend('<i class="fa fa-caret-right"></i> ');
				jQuery(".format-standard").each(function(){
					//jQuery(this).find(".media-box").append("<span class='zoom'><span class='icon'><i class='icon-plus'></i></span></span>");
				});
            },
            error: function(errorThrown) {
            }
        });
		});
		jQuery(".sort-para").live('click',function() {
			var $vars = getUrlParams();
			//alert($vars);
			jQuery.each($vars,function(index,value){
				if(index!="page_id") {
				//HistoryPush( UpdateQueryString(index,null,''));
				//history.pushState('', '', UpdateQueryString(index,null,''));
				 }
			});
			jQuery(".sorter li").removeClass("active");
			jQuery(this).addClass("active");
			var $var = jQuery(this).find(".price-var").text();
			var $val = jQuery(this).find(".price-val").text();
			var $order = jQuery(this).find(".price-order").text();
			HistoryPush(UpdateQueryString($var,$val,''));
			HistoryPush(UpdateQueryString("order",$order,''));
			//history.pushState('', '', UpdateQueryString($var,$val,''));
			//history.pushState('', '', UpdateQueryString("order",$order,''));
			$vars = getUrlParams();
			//alert($vars);
			jQuery(".waiting").fadeIn();
        	jQuery.ajax({
            type: 'POST',
            url: values.ajaxurl,
            data: {
                action: 'imic_search_result',
                values: $vars,
            },
            success: function(data) {
				jQuery("#page-paginate").remove();
				jQuery(".waiting").fadeOut();
				jQuery("#results-holder").empty();
				jQuery("#results-holder").html(data);
				jQuery('ul.inline li').prepend('<i class="fa fa-caret-right"></i> ');
				jQuery(".format-standard").each(function(){
					jQuery(this).find(".media-box").append("<span class='zoom'><span class='icon'><i class='icon-plus'></i></span></span>");
				});
				jQuery('#results-holder').each(function() {
				jQuery(this).find('.result-item').matchHeight();
			});
            },
            error: function(errorThrown) {
            }
        });
		});
		jQuery(".search-fields li a").live('click',function() {
			$query_var = jQuery(this).parent().parent().attr('id');
			$query_val = jQuery(this).text(); // gets text contents of clicked li
//});		
			if($query_val=="Filter")
			{
				$query_val = jQuery(this).attr("data-range");
			}
			jQuery("li#"+$query_var).remove();
			jQuery("#search-tab").append('<li id="'+$query_var+'"><a href="javascript:void(0);">'+$query_val+' <i class="fa fa-times"></i></a></li>');
    //$query_val = $query_val;
	HistoryPush(UpdateQueryString($query_var,$query_val,''));
    //history.pushState('', '', UpdateQueryString($query_var,$query_val,''));
		var $vars = getUrlParams();

		jQuery(".waiting").fadeIn();
        jQuery.ajax({
            type: 'POST',
            url: values.ajaxurl,
            data: {
                action: 'imic_search_result',
                values: $vars,
            },
            success: function(data) {
				jQuery("#page-paginate").remove();
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
return false;
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