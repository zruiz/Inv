/*
 *
 *	Admin jQuery Functions
 *	------------------------------------------------
 *	Imic Framework
 * 	Copyright Imic 2014 - http://imicreation.com
 *
 */
 
(function($) {
  "use strict";
jQuery(window).load(function() {
    jQuery('#imic_number_of_post_cat').parent().parent().find('.rwmb-clone').each(function() {
        jQuery(this).find('.rwmb-button').hide();
    })
    jQuery('#imic_number_of_post_cat').parent().parent().find('.add-clone').hide();
jQuery('#wpseo_meta.postbox').show();
});
jQuery(function(jQuery) {
    // META FIELD DISPLAY ON TEMPLATE SELECT
     // Hide Revslider Metabox
    jQuery('#mymetabox_revslider_0').hide();
    // Map Display
    var $imic_contact_banner_type = jQuery('#imic_contact_banner_type');
    function map_display() {
		if($imic_contact_banner_type.val()=='1') {
			jQuery("#post_page_meta_box").hide();
			jQuery("#imic_contact_map_address").parent().parent().show();
		}
		else {
			jQuery("#post_page_meta_box").show();
			jQuery("#imic_contact_map_address").parent().parent().hide();
		}
    }
    map_display();
    $imic_contact_banner_type.change(function() {
        map_display();
    });
	//Breadcrumb Bar
	var $imic_breadcrumb_bar = jQuery('#imic_browse_by_specification_switch');
    function breadcrumb_bar() {
		if($imic_breadcrumb_bar.val()=='1') {
			jQuery("#imic_browse_by_specification_title").parent().parent().show();
			jQuery("#s2id_imic_browse_by_specification").parent().parent().show();
			jQuery("#imic_browse_by_auto_scroll").parent().parent().show();
			jQuery("#imic_browse_by_auto_scroll_speed").parent().parent().show();
		}
		else {
			jQuery("#imic_browse_by_specification_title").parent().parent().hide();
			jQuery("#s2id_imic_browse_by_specification").parent().parent().hide();
			jQuery("#imic_browse_by_auto_scroll").parent().parent().hide();
			jQuery("#imic_browse_by_auto_scroll_speed").parent().parent().hide();
		}
    }
    breadcrumb_bar();
    $imic_breadcrumb_bar.change(function() {
        breadcrumb_bar();
    });
	//Blog Maonsry classic Fields
	var $imic_blog_type = jQuery('#imic_blog_layout');
    function blog_fields_show() {
		if($imic_blog_type.val()=='1') {
			jQuery("#imic_blog_column").parent().parent().hide();
		}
		else {
			jQuery("#imic_blog_column").parent().parent().show();
		}
    }
    blog_fields_show();
    $imic_blog_type.change(function() {
        blog_fields_show();
    });
	//header options for page/post
	var $imic_pages_choose_slider_display = jQuery('#imic_pages_Choose_slider_display');
    function pages_slider_display() {
        var $imic_pages_slider_image = jQuery('#imic_pages_slider_image_description').parent().parent();
        var $imic_pages_slider_pagination = jQuery('#imic_pages_slider_pagination').parent().parent();
        var $imic_pages_slider_auto_slide = jQuery('#imic_pages_slider_auto_slide').parent().parent();
        var $imic_pages_slider_direction_arrows = jQuery('#imic_pages_slider_direction_arrows').parent().parent();
        var $imic_pages_slider_effects = jQuery('#imic_pages_slider_effects').parent().parent();
		var $imic_pages_nivo_effects = jQuery('#imic_pages_nivo_effects').parent().parent();
        var $imic_pages_select_revolution_from_list = jQuery('#imic_pages_select_revolution_from_list').parent().parent();
		var $imic_banner_image = jQuery('#imic_header_image_description').parent().parent();
		var $imic_pages_slider_height = jQuery('#imic_pages_slider_height').parent().parent();
		var $imic_pages_banner_description = jQuery('#imic_pages_banner_description').parent().parent();
            var $imic_pages_banner_color = jQuery('#imic_pages_banner_color').closest('.rwmb-field');
           if ($imic_pages_choose_slider_display.val() == 3) {
            $imic_pages_slider_image.show();
            $imic_pages_slider_pagination.show();
            $imic_pages_slider_auto_slide.show();
            $imic_pages_slider_direction_arrows.show();
            $imic_pages_slider_effects.show();
			 $imic_pages_slider_height.show();
            $imic_pages_select_revolution_from_list.hide();
			 $imic_banner_image.hide();
			 $imic_pages_banner_color.hide();
			 $imic_pages_nivo_effects.hide();
			 $imic_pages_banner_description.hide();
        }
		else if ($imic_pages_choose_slider_display.val() == 4) {
            $imic_pages_slider_image.show();
            $imic_pages_slider_pagination.show();
            $imic_pages_slider_auto_slide.show();
            $imic_pages_slider_direction_arrows.show();
			$imic_pages_nivo_effects.show();
            $imic_pages_slider_effects.hide();
			 $imic_pages_slider_height.show();
            $imic_pages_select_revolution_from_list.hide();
			 $imic_banner_image.hide();
			 $imic_pages_banner_color.hide();
			 $imic_pages_banner_description.hide();
        }
		else if($imic_pages_choose_slider_display.val() == 2) {
			  $imic_banner_image.show();
			  $imic_pages_banner_description.show();
			  $imic_pages_slider_image.hide();
            $imic_pages_slider_pagination.hide();
            $imic_pages_slider_auto_slide.hide();
            $imic_pages_slider_direction_arrows.hide();
            $imic_pages_slider_effects.hide();
            $imic_pages_select_revolution_from_list.hide();
			$imic_pages_slider_height.show();
			$imic_pages_banner_color.hide();
			$imic_pages_nivo_effects.hide();
		}
        else if($imic_pages_choose_slider_display.val() == 5) {
             $imic_pages_slider_image.hide();
            $imic_pages_slider_pagination.hide();
            $imic_pages_slider_auto_slide.hide();
            $imic_pages_slider_direction_arrows.hide();
            $imic_pages_slider_effects.hide();
			$imic_banner_image.hide();
			$imic_pages_slider_height.hide();
			$imic_pages_banner_color.hide();
			$imic_pages_nivo_effects.hide();
            $imic_pages_select_revolution_from_list.show();
        }
		else if($imic_pages_choose_slider_display.val() == 1) {
			$imic_pages_banner_color.show();
			$imic_pages_banner_description.show();
			$imic_pages_slider_image.hide();
            $imic_pages_slider_pagination.hide();
            $imic_pages_slider_auto_slide.hide();
            $imic_pages_slider_direction_arrows.hide();
            $imic_pages_slider_effects.hide();
			$imic_banner_image.hide();
			$imic_pages_slider_height.show();
            $imic_pages_select_revolution_from_list.hide();
			$imic_pages_nivo_effects.hide();
		}
		else {
			$imic_pages_slider_image.hide();
            $imic_pages_slider_pagination.hide();
            $imic_pages_slider_auto_slide.hide();
            $imic_pages_slider_direction_arrows.hide();
            $imic_pages_slider_effects.hide();
			$imic_banner_image.hide();
			$imic_pages_slider_height.hide();
            $imic_pages_select_revolution_from_list.hide();
			$imic_pages_banner_color.hide();
			$imic_pages_nivo_effects.hide();
			$imic_pages_banner_description.hide();
		}
    }
    pages_slider_display();
    $imic_pages_choose_slider_display.change(function() {
        pages_slider_display();
    });
   //Megamenu
     var megamenu = jQuery('.megamenu');
    megamenu.each(function() {
        checkCheckbox(jQuery(this));
    });
    megamenu.click(function() {
        checkCheckbox(jQuery(this));
    })
    function checkCheckbox(mega_check) {
        if (mega_check.is(':checked')) {
            mega_check.parents('.custom_menu_data').find('.enabled_mega_data').show();
        }
        else {
            mega_check.parents('.custom_menu_data').find('.enabled_mega_data').hide();
        }
    }
    var menu_post_type = jQuery('.enabled_mega_data .menu-post-type');
    function show_hide_post() {
        menu_post_type.each(function() {
            if (jQuery(this).val() == '') {
                jQuery(this).parents('.enabled_mega_data').find('.menu-post-id-comma').parent().parent().show();
                jQuery(this).parents('.enabled_mega_data').find('.menu-post').parent().parent().hide();
            }
            else {
                jQuery(this).parents('.enabled_mega_data').find('.menu-post-id-comma').parent().parent().hide();
                jQuery(this).parents('.enabled_mega_data').find('.menu-post').parent().parent().show();
            }
        })
    }
    show_hide_post();
    menu_post_type.on('change', function() {
        show_hide_post();
    });
    
	var imic_gallery_meta_box = jQuery('#gallery_meta_box');
     var $imic_post_video_option = jQuery('#imic_post_video_option').closest('.rwmb-field');
     var $gallery_video_url_wrapper = jQuery('#imic_gallery_video_url').closest('.rwmb-field');
        var $imic_post_mp4_video = jQuery('#imic_post_mp4_video').closest('.rwmb-field');
        var $imic_post_webm_video = jQuery('#imic_post_webm_video').closest('.rwmb-field');
        var $imic_post_ogg_video = jQuery('#imic_post_ogg_video').closest('.rwmb-field');
    var imic_gallery_link_url = jQuery('#imic_gallery_link_url').parent().parent();
    var imic_gallery_slider_images = jQuery('#imic_gallery_images_description').parent().parent();
    var imic_gallery_audio = jQuery('#imic_gallery_audio').parent().parent();
     var imic_gallery_audio_display = jQuery('#imic_gallery_audio_display').closest('.rwmb-field');
    var imic_gallery_audio_uploaded = jQuery('#imic_gallery_uploaded_audio_description').closest('.rwmb-field');;
   var imic_gallery_slider_all =jQuery('#imic_gallery_slider_pagination,#imic_gallery_slider_speed,#imic_gallery_slider_auto_slide,#imic_gallery_slider_direction_arrows,#imic_gallery_slider_effects').parent().parent();
   function checkPostFormat(radio_val) {
        if (jQuery.trim(radio_val) == 'video') {
            imic_gallery_meta_box.show();
            imic_gallery_link_url.hide();
            imic_gallery_slider_images.hide();
            imic_gallery_audio_display.hide();
            imic_gallery_audio_uploaded.hide();
            imic_gallery_slider_all.hide();
            imic_gallery_audio.hide();
            $imic_post_video_option.show();
          //video_option();
            imic_gallery_meta_box.find('#imic_gallery_slider_image_description').closest('.rwmb-field').show();
        }
        else if (jQuery.trim(radio_val) == 'link') {
            imic_gallery_meta_box.show();
            imic_gallery_link_url.show();
            imic_gallery_slider_images.hide();
            imic_gallery_audio.hide();
            imic_gallery_audio_display.hide();
            imic_gallery_slider_all.hide();
            imic_gallery_audio_uploaded.hide();
           $gallery_video_url_wrapper.hide();
           $imic_post_video_option.hide();
        $imic_post_mp4_video.hide();
        $imic_post_webm_video.hide();
        $imic_post_ogg_video.hide();
            imic_gallery_meta_box.find('#imic_gallery_slider_image_description').closest('.rwmb-field').show();
        }
        else if (jQuery.trim(radio_val) == 'gallery') {
            imic_gallery_meta_box.show();
            imic_gallery_link_url.hide();
            imic_gallery_slider_images.show();
            imic_gallery_audio.hide();
            imic_gallery_audio_display.hide();
            imic_gallery_audio_uploaded.hide();
            imic_gallery_slider_all.show();
         $gallery_video_url_wrapper.hide();
         $imic_post_video_option.hide();
        $imic_post_mp4_video.hide();
        $imic_post_webm_video.hide();
        $imic_post_ogg_video.hide();
            imic_gallery_meta_box.find('#imic_gallery_slider_image_description').closest('.rwmb-field').hide();
        }
         else if (jQuery.trim(radio_val) == 'audio') {
            imic_gallery_meta_box.show();
            imic_gallery_link_url.hide();
            imic_gallery_slider_images.hide();
            imic_gallery_slider_all.hide();
            $imic_post_video_option.hide();
            $gallery_video_url_wrapper.hide();
        $imic_post_mp4_video.hide();
        $imic_post_webm_video.hide();
        $imic_post_ogg_video.hide();
            imic_gallery_audio.show();
            imic_gallery_audio_display.show();
            imic_gallery_audio_uploaded.show();
            imic_gallery_meta_box.find('#imic_gallery_slider_image_description').closest('.rwmb-field').show();
            
        }
        else {
            imic_gallery_meta_box.hide();
            
        }
    }
    jQuery('.post-type-gallery .post-format,.post-type-post .post-format').click(function() {
        if (jQuery(this).is(':checked'))
        {
            var radio_val = jQuery(this).val();
            checkPostFormat(radio_val)
        }
    })
    jQuery('.post-type-gallery,.post-type-post').find('.post-format').each(function() {
        if (jQuery(this).is(':checked'))
        {
            var radio_val = jQuery(this).val();
            checkPostFormat(radio_val);
            
        }
    });
 });
  //Load Social Sites list for Staff Members
jQuery("#team_meta_box").on('click','#Social',function(){
	//alert("saibaba");
	var text_name = jQuery(this).find('input[type=text]').attr('name');
        jQuery( "body" ).data("text_name", text_name );
        jQuery("label#Social input").removeClass("fb");
	jQuery("label#Social").addClass("sfb");
	name = jQuery("label.sfb input").addClass("fb");
	var label = jQuery('label[for="'+jQuery(this).attr('id')+'"]');
	if(jQuery("#socialicons").length == 0) {
	jQuery("#team_meta_box").append("<div id=\"socialicons\"><div class=\"inside\"><div class=\"rwmb-meta-box\"><div class=\"rwmb-field rwmb-select-wrapper\"><div class=\"rwmb-label\"><label for=\"select_social_icons\">Select Social Icons</label></div><div class=\"rwmb-input\"><select class=\"rwmb-select\" id=\"social\"><option value\"select\">Select</option><option value=\"facebook\">facebook</option><option value=\"bitbucket\">bitbucket</option><option value=\"dribbble\">dribbble</option><option value=\"dropbox\">dropbox</option><option value=\"flickr\">flickr</option><option value=\"foursquare\">foursquare</option><option value=\"github\">github</option><option value=\"gittip\">gittip</option><option value=\"google-plus\">google-plus</option><option value=\"instagram\">instagram</option><option value=\"linkedin\">linkedin</option><option value=\"pagelines\">pagelines</option><option value=\"pinterest\">pinterest</option><option value=\"skype\">skype</option><option value=\"tumblr\">tumblr</option><option value=\"twitter\">twitter</option><option value=\"vimeo-square\">vimeo-square</option><option value=\"youtube\">youtube</option></select></div></div></div></div></div></div>");
	}
});
jQuery("#team_meta_box").on('change','div#socialicons select#social',function(text_id){
		text_name=jQuery( "body" ).data( "text_name" );
                jQuery("#socialicons").remove();
                jQuery("label[id='Social']").find('input[name$="'+text_name+'"]').val(this.value);
//		jQuery( 'input[name$="'+text_name+'"]').val(this.value);
		jQuery("input").removeClass("fb");
	});
        jQuery("label[for='imic_social_icon_list']").click(function(e){
            e.preventDefault();
        });
		
//Load Rating for Reviews
jQuery("#post_review_meta_box").on('click','#Rating',function(){
	//alert("saibaba");
	var text_name = jQuery(this).find('input[type=text]').attr('name');
        jQuery( "body" ).data("text_name", text_name );
        jQuery("label#Rating input").removeClass("fb");
	jQuery("label#Rating").addClass("sfb");
	name = jQuery("label.sfb input").addClass("fb");
	var label = jQuery('label[for="'+jQuery(this).attr('id')+'"]');
	if(jQuery("#socialicons").length == 0) {
	jQuery("#post_review_meta_box").append("<div id=\"socialicons\"><div class=\"inside\"><div class=\"rwmb-meta-box\"><div class=\"rwmb-field rwmb-select-wrapper\"><div class=\"rwmb-label\"><label for=\"select_social_icons\">Select Social Icons</label></div><div class=\"rwmb-input\"><select class=\"rwmb-select\" id=\"social\"><option value\"select\">Select</option><option value=\"1\">One</option><option value=\"2\">Two</option><option value=\"3\">Three</option><option value=\"4\">Four</option><option value=\"5\">Five</option></select></div></div></div></div></div></div>");
	}
});
jQuery("#post_review_meta_box").on('change','div#socialicons select#social',function(text_id){
		text_name=jQuery( "body" ).data( "text_name" );
                jQuery("#socialicons").remove();
                jQuery("label[id='Rating']").find('input[name$="'+text_name+'"]').val(this.value);
//		jQuery( 'input[name$="'+text_name+'"]').val(this.value);
		jQuery("input").removeClass("fb");
	});
        jQuery("label[for='imic_social_icon_list']").click(function(e){
            e.preventDefault();
        });
})(jQuery);