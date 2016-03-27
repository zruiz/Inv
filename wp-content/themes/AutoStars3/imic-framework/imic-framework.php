<?php
if (!defined('ABSPATH'))
exit; // Exit if accessed directly
define('ImicFrameworkPath', dirname(__FILE__));
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
/*
* Here you include files which is required by theme
*/
require_once(ImicFrameworkPath . '/imic-theme-functions.php');
/* for front media attachment */
include_once(ImicFrameworkPath . '/modrator/wp_media_custom.php');
if(is_plugin_active("imithemes-listing/listing.php")) {
/* META BOX IN USER ROLE TAXONOMY
==================================================== */
require_once(ImicFrameworkPath . '/user-role-fields.php');
/* META BOX FRAMEWORK
================================================== */
require_once(ImicFrameworkPath . '/meta-box/meta-box.php');
require_once(ImicFrameworkPath . '/meta-box/inc/field.php');
require_once(ImicFrameworkPath . '/meta-box/meta-box-group/meta-box-group.php');
require_once(ImicFrameworkPath . '/meta-box/meta-box-group/group.php');
require_once(ImicFrameworkPath . '/meta-box/meta-box-show-hide/meta-box-show-hide.php');
require_once(ImicFrameworkPath . '/meta-boxes.php');
if(!is_plugin_active("imi-classifieds/imi-classified.php")) 
{
	require_once(ImicFrameworkPath . '/meta_fields.php');
}
}
/* SHORTCODES
 ================================================== */
require_once (ImicFrameworkPath . '/shortcodes.php');
/* Category Extra Field Option
================================================== */
require_once(ImicFrameworkPath . '/listing_category_image.php');
/* MEGA MENU
	================================================== */  
require_once(ImicFrameworkPath . '/imic-megamenu/imic-megamenu.php');
/* PLUGIN INCLUDES
================================================== */
require_once(ImicFrameworkPath . '/plugin-includes.php');
/* WIDGETS INCLUDES
================================================== */
require_once(ImicFrameworkPath . '/widgets/cars.php');
require_once(ImicFrameworkPath . '/widgets/registration.php');
require_once(ImicFrameworkPath . '/widgets/mortgage.php');
require_once(ImicFrameworkPath . '/widgets/enquiry.php');
require_once(ImicFrameworkPath . '/widgets/reviews.php');
require_once(ImicFrameworkPath . '/widgets/latest_posts.php');
require_once(ImicFrameworkPath . '/widgets/Newsletter/newsletter.php');
require_once(ImicFrameworkPath . '/widgets/twitter_feeds/twitter_feeds.php');
/* LOAD STYLESHEETS
================================================== */
if (!function_exists('imic_enqueue_styles')) {
function imic_enqueue_styles() {
global $imic_options;
$theme_info = wp_get_theme();
			$color_file = (isset($imic_options['theme_color_scheme']))?$imic_options['theme_color_scheme']:'';
			wp_register_style('imic_bootstrap', IMIC_THEME_PATH . '/css/bootstrap.css', array(), $theme_info->get( 'Version' ), 'all');
			wp_register_style('imic_fontawesome', IMIC_THEME_PATH . '/css/font-awesome.min.css', array(), $theme_info->get( 'Version' ), 'all');
			wp_register_style('imic_lineicons', IMIC_THEME_PATH . '/css/line-icons.min.css', array(), $theme_info->get( 'Version' ), 'all');
			wp_register_style('imic_animations', IMIC_THEME_PATH . '/css/animations.css', array(), $theme_info->get( 'Version' ), 'all');
			wp_register_style('imic_bootstrap_theme', IMIC_THEME_PATH . '/css/bootstrap-theme.css', array(), $theme_info->get( 'Version' ), 'all');
			wp_register_style('imic_main', get_stylesheet_uri(), array(), $theme_info->get( 'Version' ), 'all');
			wp_register_style('imic_prettyPhoto', IMIC_THEME_PATH . '/vendor/prettyphoto/css/prettyPhoto.css', array(), $theme_info->get( 'Version' ), 'all');
			wp_register_style('imic_magnific', IMIC_THEME_PATH . '/vendor/magnific/magnific-popup.css', array(), $theme_info->get( 'Version' ), 'all');
			wp_register_style('imic_owl_carousel', IMIC_THEME_PATH . '/vendor/owl-carousel/css/owl.carousel.css', array(), $theme_info->get( 'Version' ), 'all');
			wp_register_style('imic_owl_theme', IMIC_THEME_PATH . '/vendor/owl-carousel/css/owl.theme.css', array(), $theme_info->get( 'Version' ), 'all');
			wp_register_style('imic_nivo_default', IMIC_THEME_PATH . '/vendor/nivoslider/themes/default/default.css', array(), $theme_info->get( 'Version' ), 'all');
			wp_register_style('imic_nivo_slider', IMIC_THEME_PATH . '/vendor/nivoslider/nivo-slider.css', array(), $theme_info->get( 'Version' ), 'all');
			wp_register_style('imic_custom_css', IMIC_THEME_PATH . '/css/custom.php', array(), $theme_info->get( 'Version' ), 'all');
			wp_register_style('imic_colors', IMIC_THEME_PATH . '/colors/' . $color_file, array(), $theme_info->get( 'Version' ), 'all');
       		wp_register_style('imic_bootstraprtl_css', IMIC_THEME_PATH . '/css/bootstrap-rtl.min.css', array(), $theme_info->get( 'Version' ), 'all');
        	wp_register_style('imic_rtl_css', IMIC_THEME_PATH . '/css/rtl.css', array(), $theme_info->get( 'Version' ), 'all');
			//**Enqueue STYLESHEETPATH**//
			wp_enqueue_style('imic_bootstrap');
			wp_enqueue_style('imic_bootstrap_theme');
			wp_enqueue_style('imic_fontawesome');
			wp_enqueue_style('imic_lineicons');
			wp_enqueue_style('imic_animations');
			wp_enqueue_style('imic_main');
			if(isset($imic_options['switch_lightbox']) && $imic_options['switch_lightbox']== 0){
				wp_enqueue_style('imic_prettyPhoto');
			}elseif(isset($imic_options['switch_lightbox']) && $imic_options['switch_lightbox']== 1){
				wp_enqueue_style('imic_magnific');
			}
			wp_enqueue_style('imic_owl_carousel');
			wp_enqueue_style('imic_owl_theme');
			$color = (isset($imic_options['theme_color_type']))?$imic_options['theme_color_type']:array('');
			if ($color[0] == 0) {
			wp_enqueue_style('imic_colors');
			}
			if(isset($imic_options['enable_rtl']) && $imic_options['enable_rtl']== 1){
				wp_enqueue_style('imic_bootstraprtl_css');
				wp_enqueue_style('imic_rtl_css');
			}
			//**End Enqueue STYLESHEETPATH**//
		}
		add_action('wp_enqueue_scripts', 'imic_enqueue_styles', 99);
}
if (!function_exists('imic_enqueue_scripts')) {
    function imic_enqueue_scripts() {
        global $imic_options;
		$theme_info = wp_get_theme();
       $sticky_menu = (isset($imic_options['enable-header-stick']))?$imic_options['enable-header-stick']:'';
	   $basic = __('Basic Search','framework');
        $advanced = __('Advanced Search','framework');
				$mortgage_message = __('Please fill all fields', 'framework');
				$enquiry_email_msg = __('Please enter Email', 'framework');
				$enquiry_form_sending = __('Sending Information...', 'framework');
				$enquiry_form_success = __('Details forwarded to dealer', 'framework');
				$exceed_msg = __('You can not select more than 3 listings to compare', 'framework');
				$compares = __('Compare ', 'framework');
				$already_saved = __('You have already saved this search', 'framework');
				$success_saved = __('Successfully Saved', 'framework');
	   $distance_measure = (isset($imic_options['distance_calculate']))?$imic_options['distance_calculate']:'miles';
        //**register script**//
		wp_register_script('imic_jquery_modernizr', IMIC_THEME_PATH . '/js/modernizr.js', array(), $theme_info->get( 'Version' ), true);
		wp_register_script('imic_jquery_prettyphoto', IMIC_THEME_PATH . '/vendor/prettyphoto/js/prettyphoto.js', array(), $theme_info->get( 'Version' ), true);
		wp_register_script('imic_jquery_magnific', IMIC_THEME_PATH . '/vendor/magnific/jquery.magnific-popup.min.js', array(), $theme_info->get( 'Version' ), true);
		wp_register_script('imic_jquery_ui_plugins', IMIC_THEME_PATH . '/js/ui-plugins.js', array(), $theme_info->get( 'Version' ), true);
		wp_register_script('imic_jquery_helper_plugins', IMIC_THEME_PATH . '/js/helper-plugins.js', array(), $theme_info->get( 'Version' ), true);
		wp_register_script('imic_owl_carousel_min', IMIC_THEME_PATH . '/vendor/owl-carousel/js/owl.carousel.min.js', array(), $theme_info->get( 'Version' ), true);
		wp_register_script('imic_password_checker', IMIC_THEME_PATH . '/vendor/password-checker.js', array(), $theme_info->get( 'Version' ), true);
		wp_register_script('imic_jquery_bootstrap', IMIC_THEME_PATH . '/js/bootstrap.js', array(), $theme_info->get( 'Version' ), true);
		wp_register_script('imic_jquery_init', IMIC_THEME_PATH . '/js/init.js', array('imic_jquery_flexslider'), $theme_info->get( 'Version' ), true);
		wp_register_script('imic_google_map','http://maps.google.com/maps/api/js?sensor=false',array(),$theme_info->get( 'Version' ),true);
		wp_register_script('imic_gmap',IMIC_THEME_PATH . '/js/googleMap.js',array(),$theme_info->get( 'Version' ),true);
		wp_register_script('imic_jquery_flexslider', IMIC_THEME_PATH . '/vendor/flexslider/js/jquery.flexslider.js', array(), $theme_info->get( 'Version' ), true);
		wp_register_script('imic_nivo_slider', IMIC_THEME_PATH . '/vendor/nivoslider/jquery.nivo.slider.js', array(), $theme_info->get( 'Version' ), true);
		wp_register_script('imic_search_filter', IMIC_THEME_PATH . '/js/search-filter.js', array(), $theme_info->get( 'Version' ), true);
		wp_register_script('imic_add_listing', IMIC_THEME_PATH . '/js/add-listing.js', array(), $theme_info->get( 'Version' ), true);
		wp_register_script('imic_vehicle_add', IMIC_THEME_PATH . '/js/vehicle-add.js', array(), $theme_info->get( 'Version' ), true);
		wp_register_script('imic_contact_map', IMIC_THEME_PATH . '/js/contact-map.js', array(), $theme_info->get( 'Version' ), true);
		wp_register_script('imic_agent_register', IMIC_THEME_PATH . '/js/agent-register.js', array(), $theme_info->get( 'Version' ), true);
		wp_register_script('imic_search_location', IMIC_THEME_PATH . '/js/search_location.js', array(), $theme_info->get( 'Version' ), true);
		wp_register_script('imic_enquiry_email', IMIC_THEME_PATH . '/js/enquiry_email.js', array(), $theme_info->get( 'Version' ), true);
		wp_register_script('imic_bootstrap_slider', IMIC_THEME_PATH . '/js/bootstrap-slider.js', array(), $theme_info->get( 'Version' ), true);
		wp_register_script('imic_common_scripts', IMIC_THEME_PATH . '/js/common_scripts.js', array(), $theme_info->get( 'Version' ), true);
        //**End register script**//
        //**Enqueue script**//
		wp_enqueue_script('imic_jquery_modernizr');
		wp_enqueue_script('jquery');
		wp_enqueue_script('imic_bootstrap_slider');
        if(isset($imic_options['switch_lightbox']) && $imic_options['switch_lightbox'] == 0){
			wp_enqueue_script('imic_jquery_prettyphoto');
		}elseif(isset($imic_options['switch_lightbox']) && $imic_options['switch_lightbox'] == 1){
			wp_enqueue_script('imic_jquery_magnific');
		}
		wp_enqueue_script('imic_jquery_ui_plugins');
		wp_enqueue_script('imic_jquery_helper_plugins');
		wp_enqueue_script('imic_jquery_bootstrap');
		wp_enqueue_script('imic_password_checker');
		wp_enqueue_script('imic_jquery_init');
		wp_enqueue_script('imic_owl_carousel_min');
		wp_enqueue_script('imic_google_map');
		wp_enqueue_script('imic_search_location');
		wp_localize_script('imic_search_location','searches',array('ajaxurl'=>admin_url('admin-ajax.php'),'measure'=>$distance_measure));
		wp_localize_script('imic_search_filter','values',array('ajaxurl'=>admin_url('admin-ajax.php'),'tmpurl'=>get_template_directory_uri()));
		wp_enqueue_script('imic_common_scripts');
		wp_localize_script('imic_common_scripts','common',array('ajaxurl'=>admin_url('admin-ajax.php')));
		wp_enqueue_script('imic_vehicle_add');
		wp_localize_script('imic_vehicle_add','dashboard',array('ajaxurl'=>admin_url('admin-ajax.php'), 'exceed'=>$exceed_msg, 'compmsg'=>$compares, 'asaved'=>$already_saved, 'ssaved'=>$success_saved));
		wp_localize_script('imic_jquery_init','values',array('ajaxurl'=>admin_url('admin-ajax.php'),'tmpurl'=>get_template_directory_uri(),'basic'=>$basic,'advanced'=>$advanced));
		wp_localize_script('imic_jquery_init','overform',array('basic'=>$basic,'advanced'=>$advanced, 'mortgage'=>$mortgage_message));
		wp_enqueue_script('imic_enquiry_email');
		wp_localize_script('imic_enquiry_email','values_enquiry',array('ajaxurl'=>admin_url('admin-ajax.php'),'tmpurl'=>get_template_directory_uri(), 'msg'=>$enquiry_email_msg, 'sending'=>$enquiry_form_sending , 'success'=>$enquiry_form_success));
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
        //**End Enqueue script**//
    }
    add_action('wp_enqueue_scripts', 'imic_enqueue_scripts');
}
/* LOAD BACKEND SCRIPTS
  ================================================== */
function imic_admin_scripts() {
	$theme_info = wp_get_theme();
     wp_register_script('imic-admin-functions', IMIC_THEME_PATH . '/js/imic_admin.js', 'jquery', $theme_info->get( 'Version' ), TRUE);
     wp_enqueue_script('imic-admin-functions');
	 if(isset($_REQUEST['taxonomy'])){
      wp_register_script('imic-upload', IMIC_THEME_PATH . '/js/imic-upload.js', 'jquery', NULL, TRUE);
      wp_enqueue_media();
      wp_enqueue_script('imic-upload');
  }
	 }
add_action('admin_init', 'imic_admin_scripts');
/* LOAD BACKEND STYLE
  ================================================== */
function imic_admin_styles() {
    add_editor_style(IMIC_THEME_PATH . '/css/editor-style.css');
	add_editor_style(IMIC_THEME_PATH . '/css/font-awesome.min.css');
    echo '<style>.imic-image-select-repeatable-bg-image{width:50px;}#upload_category_button,#upload_category_button_remove{width:auto !important;}</style>';
}
add_action('admin_head', 'imic_admin_styles');
?>