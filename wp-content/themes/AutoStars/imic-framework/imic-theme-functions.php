<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
/*
 *
 * 	imic Framework Theme Functions
 * 	------------------------------------------------
 * imic_theme_activation()
* imic_maintenance_mode()
* imic_custom_login_logo()
* imic_add_nofollow_cat()
* imic_admin_bar_menu()
* imic_analytics()
* imic_custom_styles()
* imic_custom_script()
* imic_content_filter()
* imic_register_sidebars()
* imic_custom_taxonomies_terms_links()
* imic_afterSavePost()
* IMIC_Custom_Nav()
* imic_get_all_types()
* imic_get_cat_list()
* imic_widget_titles()
* imic_RevSliderShortCode()
* imic_cat_count_flag()
* imic_get_all_sidebars()
* imic_register_meta_box()
* imic_wp_get_attachment()
* imic_gallery_flexslider()
* imic_social_staff_icon()
* imic_share_buttons()
* imic_custom_excerpt_length()
* imic_count_user_posts_by_type()
* imic_search_result()
* imic_matched_results()
* imic_get_all_integer_specifications()
* imic_create_vehicle()
* imic_add_query_vars_filter()
* imic_session_init()
* imic_search_array()
* imic_vehicle_add()
* imic_save_search()
* imic_sight()
* imi_remove_cars()
* imi_remove_search()
* imi_remove_ads()
* imic_sortable_specification()
* imic_queryToArray()
* ajax_login_init()
* ajax_login()
* imic_get_template_url()
* imic_get_template_id()
* imic_remove_property_image()
* update_property_featured_image()
* imic_agent_register()
* imic_search_dealers()
* imic_count_cars_by_specification()
* imic_remove_session_saved()
* imic_calcPay()
* imic_mortgage_calculator()
* imic_is_decimal()
* imic_price_guide()
* imic_update_user_info()
* imi_update_status_ads()
* find_car_with_position()
* find_car_with_image()
* imic_validate_payment()
* imic_add_dealer_role()
* imic_value_search_multi_array()
* imic_array_empty()
* imic_cars_status_columns()
* imic_cars_status_column_content()
* imic_agent_fields()
* imic_get_currency_symbol()
 */
/* THEME ACTIVATION
  ================================================== */
if (!function_exists('imic_theme_activation')) {
    function imic_theme_activation() {
        global $pagenow;
        if (is_admin() && 'themes.php' == $pagenow && isset($_GET['activated'])) {
            #provide hook so themes can execute theme specific functions on activation
            do_action('imic_theme_activation');
          }
    }
    add_action('admin_init', 'imic_theme_activation');
}
/* MAINTENANCE MODE
  ================================================== */
if (!function_exists('imic_maintenance_mode')) {
    function imic_maintenance_mode() {
        $options = get_option('imic_options');
        $custom_logo = array("url"=>"");
		$custom_logo_output = $maintenance_mode = "";
        if (isset($options['custom_admin_login_logo'])) {
            $custom_logo = $options['custom_admin_login_logo'];
        }
        $custom_logo_output = '<img src="' . $custom_logo['url'] . '" alt="maintenance" style="height: 62px!important;margin: 0 auto; display: block;" />';
        if (isset($options['enable_maintenance'])) {
            $maintenance_mode = $options['enable_maintenance'];
        } else {
            $maintenance_mode = false;
        }
        if ($maintenance_mode) {
            if (!current_user_can('edit_themes') || !is_user_logged_in()) {
                wp_die($custom_logo_output . '<p style="text-align:center">' . __('We are currently in maintenance mode, please check back shortly.', 'framework') . '</p>', __('Maintenance Mode', 'framework'));
            }
        }
    }
    add_action('get_header', 'imic_maintenance_mode');
}
/* CUSTOM LOGIN LOGO
  ================================================== */
if (!function_exists('imic_custom_login_logo')) {
    function imic_custom_login_logo() {
        $options = get_option('imic_options');
        $custom_logo = array("url"=>"");
        if (isset($options['custom_admin_login_logo'])) {
            $custom_logo = $options['custom_admin_login_logo'];
        }
        echo '<style type="text/css">
			    .login h1 a { background-image:url(' . $custom_logo['url'] . ') !important; background-size: auto !important; width: auto !important; height: 95px !important; }
			</style>';
    }
    add_action('login_head', 'imic_custom_login_logo');
}
/* CATEGORY REL FIX
  ================================================== */
if (!function_exists('imic_add_nofollow_cat')) {
    function imic_add_nofollow_cat($text) {
        $text = str_replace('rel="category tag"', "", $text);
        return $text;
    }
    add_filter('the_category', 'imic_add_nofollow_cat');
}
/* CUSTOM ADMIN MENU ITEMS
  ================================================== */
if (!function_exists('imic_admin_bar_menu')) {
    function imic_admin_bar_menu() {
        global $wp_admin_bar;
        if (current_user_can('manage_options')) {
            $theme_customizer = array(
                'id' => '2',
                'title' => __('Color Customizer', 'framework'),
                'href' => admin_url('/customize.php'),
                'meta' => array('target' => 'blank')
            );
            $wp_admin_bar->add_menu($theme_customizer);
        }
    }
    add_action('admin_bar_menu', 'imic_admin_bar_menu', 99);
}
/* ----------------------------------------------------------------------------------- */
/* Show analytics code in footer */
/* ----------------------------------------------------------------------------------- */
if (!function_exists('imic_analytics')) {
    function imic_analytics() {
        $options = get_option('imic_options');
        if ($options['tracking-code'] != "") {
            echo '<script>';
            echo $options['tracking-code'];
            echo '</script>';
        }
    }
    add_action('wp_head', 'imic_analytics');
}
/* CUSTOM CSS OUTPUT
  ================================================== */
if (!function_exists('imic_custom_styles')) {
    function imic_custom_styles() {
        $options = get_option('imic_options');
        // OPEN STYLE TAG
        echo '<style type="text/css">' . "\n";
        // Custom CSS
        $custom_css = $options['custom_css'];
		if ($options['enable-header-stick'] == 0) {
			echo '.site-header-wrapper{position:relative;}body.admin-bar .site-header-wrapper{top:0;}.body{padding-top:0!important;}.actions-bar.tsticky{top:0!important;}';
		}
        if ($options['theme_color_type'][0] == 1) {
            $primaryColor = $options['primary_theme_color'];
            echo '.text-primary, .btn-primary .badge, .btn-link,a.list-group-item.active > .badge,.nav-pills > .active > a > .badge, p.drop-caps:first-child:first-letter, .accent-color, .nav-np .next:hover, .nav-np .prev:hover, .basic-link, .pagination > li > a:hover,.pagination > li > span:hover,.pagination > li > a:focus,.pagination > li > span:focus, .accordion-heading:hover .accordion-toggle, .accordion-heading:hover .accordion-toggle.inactive, .accordion-heading:hover .accordion-toggle i, .accordion-heading .accordion-toggle.active, .accordion-heading .accordion-toggle.active, .accordion-heading .accordion-toggle.active i, .main-navigation > ul > li > ul > li a:hover, .main-navigation > ul > li:hover > a, .main-navigation > ul > li:hover > a > i, .top-navigation li a:hover, .search-form h3, .featured-block h4, .vehicle-cost, .icon-box-inline span, .post-title a, .post-review-block h3.post-title a:hover, .review-status strong, .testimonial-block blockquote:before, .testimonial-info span, .additional-images .owl-carousel .item-video i, .vehicle-enquiry-foot i, .vehicle-enquiry-head h4, .add-features-list li i, .comparision-table .price, .search-filters .accordion-heading.accordionize .accordion-toggle.active, .search-filters .accordion-heading.togglize .accordion-toggle.active, .search-filters .accordion-heading .accordion-toggle.active, .search-filters .accordion-heading:hover .accordion-toggle.active, .search-filters .accordion-heading:hover .accordion-toggle.active:hover, .search-filters .accordion-heading.accordionize .accordion-toggle.active i, .search-filters .accordion-heading.togglize .accordion-toggle.active i, .filter-options-list li a:hover, .calculator-widget .loan-amount, .map-agent h4 a, .pricing-column h3, .listing-form-steps li.active a .step-state, .listing-form-steps li:hover a .step-state, .result-item-pricing .price, .result-item-features li i, .users-sidebar .list-group li a:hover > i, .saved-cars-table .price, .post .post-title a:hover, a, .post-actions .comment-count a:hover, .pricing-column .features a:hover, a:hover, .service-block h4 a:hover, .saved-cars-table .search-find-results a:hover, .widget a:hover, .nav-tabs > li > a:hover, .list-group-item a:hover, .icon-box.ibox-plain .ibox-icon i,.icon-box.ibox-plain .ibox-icon img, .icon-box.ibox-border .ibox-icon i,.icon-box.ibox-border .ibox-icon img, .top-header .sf-menu > li:hover > a, .header-v2 .topnav > ul > li:hover > a, .header-v4 .search-function .search-trigger, .additional-triggers > li > a:hover, .woocommerce div.product span.price, .woocommerce div.product p.price, .woocommerce #content div.product span.price, .woocommerce #content div.product p.price, .woocommerce-page div.product span.price, .woocommerce-page div.product p.price, .woocommerce-page #content div.product span.price, .woocommerce-page #content div.product p.price, .woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price{
	color:'.esc_attr($primaryColor).';
}
.basic-link:hover, .continue-reading:hover{
	opacity:.8
}
p.drop-caps.secondary:first-child:first-letter, .accent-bg, .btn-primary,
.btn-primary.disabled,
.btn-primary[disabled],
fieldset[disabled] .btn-primary,
.btn-primary.disabled:hover,
.btn-primary[disabled]:hover,
fieldset[disabled] .btn-primary:hover,
.btn-primary.disabled:focus,
.btn-primary[disabled]:focus,
fieldset[disabled] .btn-primary:focus,
.btn-primary.disabled:active,
.btn-primary[disabled]:active,
fieldset[disabled] .btn-primary:active,
.btn-primary.disabled.active,
.btn-primary[disabled].active,
fieldset[disabled] .btn-primary.active,
.dropdown-menu > .active > a,
.dropdown-menu > .active > a:hover,
.dropdown-menu > .active > a:focus,
.nav-pills > li.active > a,
.nav-pills > li.active > a:hover,
.nav-pills > li.active > a:focus,
.pagination > .active > a,
.pagination > .active > span,
.pagination > .active > a:hover,
.pagination > .active > span:hover,
.pagination > .active > a:focus,
.pagination > .active > span:focus,
.label-primary,
.progress-bar-primary,
a.list-group-item.active,
a.list-group-item.active:hover,
a.list-group-item.active:focus,
.panel-primary > .panel-heading, .carousel-indicators .active, .flex-control-nav a:hover, .flex-control-nav a.flex-active, .media-box .media-box-wrapper, .media-box .zoom .icon, .media-box .expand .icon, .icon-box.icon-box-style1:hover .ico, .cart-bubble, .toggle-make a:hover, .search-trigger, .toggle-make a, .featured-block-image strong, .pass-actions:hover, .utility-icons > li > a:hover, .utility-icons > li:hover > a, .owl-theme .owl-page.active span, .owl-theme .owl-controls.clickable .owl-page:hover span, .seller-info, .search-icon-boxed, .logged-in-user:hover .user-dd-dropper, .testimonials-wbg .testimonial-block blockquote:after, .selling-choice > .btn-default.active, .fact-ico, .ibox-effect.ibox-dark .ibox-icon i:hover,.ibox-effect.ibox-dark:hover .ibox-icon i,.ibox-border.ibox-effect.ibox-dark .ibox-icon i:after, .icon-box .ibox-icon i,.icon-box .ibox-icon img, .icon-box .ibox-icon i,.icon-box .ibox-icon img, .icon-box.ibox-dark.ibox-outline:hover .ibox-icon i, .share-buttons-tc > li > a{
  background-color: '.esc_attr($primaryColor).';
}
.btn-primary:hover,
.btn-primary:focus,
.btn-primary:active,
.btn-primary.active,
.open .dropdown-toggle.btn-primary, .toggle-make a:hover, .toggle-make a:hover, .search-trigger:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce #content input.button.alt:hover, .woocommerce-page a.button.alt:hover, .woocommerce-page button.button.alt:hover, .woocommerce-page input.button.alt:hover, .woocommerce-page #respond input#submit.alt:hover, .woocommerce-page #content input.button.alt:hover, .woocommerce a.button.alt:active, .woocommerce button.button.alt:active, .woocommerce input.button.alt:active, .woocommerce #respond input#submit.alt:active, .woocommerce #content input.button.alt:active, .woocommerce-page a.button.alt:active, .woocommerce-page button.button.alt:active, .woocommerce-page input.button.alt:active, .woocommerce-page #respond input#submit.alt:active, .woocommerce-page #content input.button.alt:active, .wpcf7-form .wpcf7-submit{
  background: '.esc_attr($primaryColor).';
  opacity:.9
}
p.demo_store, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit.alt, .woocommerce #content input.button.alt, .woocommerce-page a.button.alt, .woocommerce-page button.button.alt, .woocommerce-page input.button.alt, .woocommerce-page #respond input#submit.alt, .woocommerce-page #content input.button.alt, .woocommerce span.onsale, .woocommerce-page span.onsale, .wpcf7-form .wpcf7-submit, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce .widget_layered_nav ul li.chosen a, .woocommerce-page .widget_layered_nav ul li.chosen a, .ticket-cost{
	background: '.esc_attr($primaryColor).';
}
.nav .open > a,
.nav .open > a:hover,
.nav .open > a:focus,
.pagination > .active > a,
.pagination > .active > span,
.pagination > .active > a:hover,
.pagination > .active > span:hover,
.pagination > .active > a:focus,
.pagination > .active > span:focus,
a.thumbnail:hover,
a.thumbnail:focus,
a.thumbnail.active,
a.list-group-item.active,
a.list-group-item.active:hover,
a.list-group-item.active:focus,
.panel-primary,
.panel-primary > .panel-heading, .btn-primary.btn-transparent, .icon-box.icon-box-style1 .ico, .user-login-btn:hover, .icon-box-inline span, .vehicle-enquiry-head, .selling-choice > .btn-default.active, .icon-box.ibox-border .ibox-icon, .icon-box.ibox-outline .ibox-icon, .icon-box.ibox-dark.ibox-outline:hover .ibox-icon, .header-v2 .site-header-wrapper, .dd-menu.topnav > ul > li > ul, .dd-menu.topnav > ul > li.megamenu > ul{
	border-color:'.esc_attr($primaryColor).';
}
.panel-primary > .panel-heading + .panel-collapse .panel-body, .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus, .main-navigation > ul > li ul, .navbar .search-form-inner, .woocommerce .woocommerce-info, .woocommerce-page .woocommerce-info, .woocommerce .woocommerce-message, .woocommerce-page .woocommerce-message{
	border-top-color:'.esc_attr($primaryColor).';
}
.panel-primary > .panel-footer + .panel-collapse .panel-body{
	border-bottom-color:'.esc_attr($primaryColor).';
}
.search-find-results, .dd-menu > ul > li > ul li ul{
	border-left-color:'.esc_attr($primaryColor).';
}
.ibox-border.ibox-effect.ibox-dark .ibox-icon i:hover,.ibox-border.ibox-effect.ibox-dark:hover .ibox-icon i {
	box-shadow:0 0 0 1px '.esc_attr($primaryColor).';
}
.ibox-effect.ibox-dark .ibox-icon i:after {
	box-shadow:0 0 0 2px '.esc_attr($primaryColor).';
}
@media only screen and (max-width: 767px) {
	.utility-icons.social-icons > li > a:hover{
		color:'.esc_attr($primaryColor).';
	}
}
/* Color Scheme Specific Classes */';
        }
        if ($custom_css) {
            echo "\n" . '/*========== User Custom CSS Styles ==========*/' . "\n";
            echo esc_attr($custom_css);
        }
        // CLOSE STYLE TAG
        echo "</style>" . "\n";
    }
    add_action('wp_head', 'imic_custom_styles');
}
/* CUSTOM JS OUTPUT
  ================================================== */
if (!function_exists('imic_custom_script')) {
    function imic_custom_script() {
        $options = get_option('imic_options');
        $custom_js = $options['custom_js'];
        if ($custom_js) {
            echo'<script type ="text/javascript">';
            echo $custom_js;
            echo '</script>';
        }
    }
    add_action('wp_footer', 'imic_custom_script');
}
/* SHORTCODE FIX
  ================================================== */
if (!function_exists('imic_content_filter')) {
    function imic_content_filter($content) {
        // array of custom shortcodes requiring the fix 
        $block = join("|", array("imic_button", "icon", "iconbox", "imic_image", "anchor", "paragraph", "divider", "heading", "alert", "blockquote", "dropcap", "code", "label", "container", "spacer", "span", "one_full", "one_half", "one_third", "one_fourth", "one_sixth","two_third", "progress_bar", "imic_count", "imic_tooltip", "imic_video", "htable", "thead", "tbody", "trow", "thcol", "tcol", "pricing_table", "pt_column", "pt_package", "pt_button", "pt_details", "pt_price", "list", "list_item", "list_item_dt", "list_item_dd", "accordions", "accgroup", "acchead", "accbody", "toggles", "togglegroup", "togglehead", "togglebody", "tabs", "tabh", "tab", "tabc", "tabrow", "section", "page_first", "page_last", "page", "modal_box", "imic_form", "fullcalendar", "staff","fullscreenvideo"));
        // opening tag
        $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content);
        // closing tag
        $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", "[/$2]", $rep);
        return $rep;
    }
    add_filter("the_content", "imic_content_filter");
}
/* REGISTER SIDEBARS
  ================================================== */
if (!function_exists('imic_register_sidebars')) {
    function imic_register_sidebars() {
        if (function_exists('register_sidebar')) {
			$options = get_option('imic_options');
			$footer_class = $options["footer_layout"];
            register_sidebar(array(
                'name' => __('Home Page Sidebar', 'framework'),
                'id' => 'main-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ));
			register_sidebar(array(
                'name' => __('Home Page Sidebar Second', 'framework'),
                'id' => 'main-sidebar-2',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ));
            register_sidebar(array(
                'name' => __('Contact Sidebar', 'framework'),
                'id' => 'inner-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ));
            register_sidebar(array(
                'name' => __('Page Sidebar', 'framework'),
                'id' => 'page-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ));
			register_sidebar(array(
                'name' => __('Details Page Sidebar', 'framework'),
                'id' => 'details-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ));
			register_sidebar(array(
                'name' => __('Post Sidebar', 'framework'),
                'id' => 'post-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ));
			register_sidebar(array(
                'name' => __('Car Sidebar', 'framework'),
                'id' => 'car-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ));
			register_sidebar(array(
                'name' => __('Shop Sidebar', 'framework'),
                'id' => 'shop-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ));
            register_sidebar(array(
                'name' => __('Footer Widgets', 'framework'),
                'id' => 'footer-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div class="col-md-'.$footer_class.' col-sm-'.$footer_class.' widget footer_widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h4 class="footer-widget-title">',
                'after_title' => '</h4>'
            ));
        }
    }
    add_action('init', 'imic_register_sidebars', 35);
}
if(!function_exists('imic_value_search_multi_array')) {
function imic_value_search_multi_array($value, $array) {
	if(!empty($array)) {
    if(in_array($value, $array)) {
          return true;
     }
     foreach($array as $item) {
          if(is_array($item) && imic_value_search_multi_array($value, $item))
               return true;
     }
   return false; }
}
}
if(!function_exists('imic_get_child_values_status'))
{
	function imic_get_child_values_status($arr)
	{
		foreach($arr as $tab)
		{
			$child_value = $tab['imic_plugin_specification_values_child'];
			if(!empty($child_value))
			{
				$result = 1;
				break;
			}
			else
			{
				$result = 0;
			}
		}
		return $result;
	}
}
// get taxonomies terms links
if (!function_exists('imic_custom_taxonomies_terms_links')) {
    function imic_custom_taxonomies_terms_links($id) {
    global $post;
	$out = '';
    // get post by post id
    $post = get_post($id);
    // get post type by post
    $post_type = $post->post_type;
    // get post type taxonomies
    $taxonomies = get_object_taxonomies($post_type);
    foreach ($taxonomies as $taxonomy) {   
        // get the terms related to post
        $terms = get_the_terms( $post->ID, $taxonomy );
        if ( !empty( $terms ) ) {
                foreach ( $terms as $term ){
                $out = $term->name;
        }
        }
    }
    return $out;
}
}
if(!function_exists('imic_langcode_post_id'))
{
	function imic_langcode_post_id($post_id)
	{
		if (class_exists('SitePress')) 
		{
    global $wpdb;
 
    $query = $wpdb->prepare('SELECT language_code FROM ' . $wpdb->prefix . 'icl_translations WHERE element_id="%d"', $post_id);
    $query_exec = $wpdb->get_row($query);
 
    return $query_exec->language_code;
		}
	}
}
if(!function_exists('imic_filter_lang_specs_admin'))
{
	function imic_filter_lang_specs_admin($specs, $id)
	{
		$new_specs = array();
		if((!empty($specs))&&(class_exists('SitePress')))
		{
			foreach($specs as $spec)
			{
				if(class_exists('SitePress')&&imic_langcode_post_id( $id )==imic_langcode_post_id( $spec ))
				{
					$new_specs[] = $spec;
				}
			}
		}
		else
		{
			$new_specs = $specs;
		}
		return $new_specs;
	}
}
//Listing Details update while updating through Admin
if (!function_exists('imic_afterSavePost')) {
function imic_afterSavePost()
{
	global $imic_options;
	$title = (isset($imic_options['highlighted_specs']))?$imic_options['highlighted_specs']:array();
	if((isset($_GET['post']))&&(!empty($title)))
	{ 
	$postId = $_GET['post'];
	$post_type = get_post_type($postId);
	if($post_type=='yachts')
		{
			$new_title = imic_filter_lang_specs_admin($title, $postId);
			$title = $new_title;
			$listing_end_date = get_post_meta($postId, 'imic_plugin_listing_end_dt', true);
			if($listing_end_date=='')
			{
				update_post_meta($postId, 'imic_plugin_listing_end_dt', '2020-01-01');
			}
			$specifications = get_post_meta($postId,'feat_data',true);
			$new_title = imic_vehicle_title($postId,$title,$specifications);
			$my_post = array(
			  'ID'           => $postId,
			  'post_title'   => $new_title,
		  );
  			wp_update_post( $my_post );
		}
	}
}
imic_afterSavePost(); 
}
//Add New Custom Menu Option
if ( !class_exists('IMIC_Custom_Nav')) {
class IMIC_Custom_Nav {
public function add_nav_menu_meta_boxes() {
   
add_meta_box(
'mega_nav_link',
__('Mega Menu','framework'),
array( $this, 'nav_menu_link'),
'nav-menus',
'side',
'low'
);
}
public function nav_menu_link() {
    
     global $_nav_menu_placeholder, $nav_menu_selected_id;
	$_nav_menu_placeholder = 0 > $_nav_menu_placeholder ? $_nav_menu_placeholder - 1 : -1;
    
        ?>
<div id="posttype-wl-login" class="posttypediv">
<div id="tabs-panel-wishlist-login" class="tabs-panel tabs-panel-active">
<ul id ="wishlist-login-checklist" class="categorychecklist form-no-clear">
<li>
<label class="menu-item-title">
<input type="checkbox" class="menu-item-object-id" name="menu-item[<?php echo esc_attr($_nav_menu_placeholder); ?>][menu-item-object-id]" value="<?php echo esc_attr($_nav_menu_placeholder); ?>"> <?php _e('Create Column','framework'); ?>
</label>
    <input type="hidden" class="menu-item-db-id" name="menu-item[<?php echo esc_attr($_nav_menu_placeholder); ?>][menu-item-db-id]" value="0">
    <input type="hidden" class="menu-item-object" name="menu-item[<?php echo esc_attr($_nav_menu_placeholder); ?>][menu-item-object]" value="page">
<input type="hidden" class="menu-item-parent-id" name="menu-item[<?php echo esc_attr($_nav_menu_placeholder); ?>][menu-item-parent-id]" value="0">
   <input type="hidden" class="menu-item-type" name="menu-item[<?php echo esc_attr($_nav_menu_placeholder); ?>][menu-item-type]" value="">
<input type="hidden" class="menu-item-title" name="menu-item[<?php echo esc_attr($_nav_menu_placeholder); ?>][menu-item-title]" value="<?php _e('Column','framework'); ?>">
<input type="hidden" class="menu-item-classes" name="menu-item[<?php echo esc_attr($_nav_menu_placeholder); ?>][menu-item-classes]" value="custom_mega_menu">
</li>
</ul>
</div>
<p class="button-controls">
<span class="add-to-menu">
<input type="submit" class="button-secondary submit-add-to-menu right" value="<?php _e('Add to Menu','framework'); ?>" name="add-post-type-menu-item" id="submit-posttype-wl-login">
<span class="spinner"></span>
</span>
</p>
</div>
<?php }
}
}
$custom_nav = new IMIC_Custom_Nav;
add_action('admin_init', array($custom_nav, 'add_nav_menu_meta_boxes'));
//Get All Post Types
if(!function_exists('imic_get_all_types')){
add_action( 'wp_loaded', 'imic_get_all_types');
function imic_get_all_types(){
   $args = array(
   'public'   => true,
   );
$output = 'names'; // names or objects, note names is the default
return $post_types = get_post_types($args, $output); 
}
}
/* -------------------------------------------------------------------------------------
  Get Cat List.
  ----------------------------------------------------------------------------------- */
if (!function_exists('imic_get_cat_list')) {
    function imic_get_cat_list() {
        $amp_categories_obj = get_categories('exclude=1');
         
        $amp_categories = array();
        if(count($amp_categories_obj)>0){
        foreach ($amp_categories_obj as $amp_cat) {
            $amp_categories[$amp_cat->cat_ID] = $amp_cat->name;
        }}
        return $amp_categories;
    }
}
/* VIDEO EMBED FUNCTIONS
  ================================================== */
if (!function_exists('imic_video_embed')) {
    function imic_video_embed($url, $width = 500, $height = 300) {
        if (strpos($url, 'youtube') || strpos($url, 'youtu.be')) {
            return imic_video_youtube($url, $width, $height);
        } else {
            return imic_video_vimeo($url, $width, $height);
        }
    }
}
/* Video Youtube
  ================================================== */
if (!function_exists('imic_video_youtube')) {
    function imic_video_youtube($url, $width = 560, $height = 315) {
        if($url!='') {
        if (stristr($url,'youtu.be/'))
        { preg_match('/(https:|http:|)(\/\/www\.|\/\/|)(.*?)\/(.{11})/i', $url, $video_id); return '<iframe itemprop="video" src="http://www.youtube.com/embed/' . $video_id[4] . '?wmode=transparent&autoplay=0" width="' . $width . '" height="' . $height . '" ></iframe>'; }
    else 
        { preg_match('/(https:|http:|):(\/\/www\.|\/\/|)(.*?)\/(embed\/|watch\?v=|(.*?)&v=|v\/|e\/|.+\/|watch.*v=|)([a-z_A-Z0-9]{11})/i', $url, $video_id); return '<iframe itemprop="video" src="http://www.youtube.com/embed/' . $video_id[6] . '?wmode=transparent&autoplay=0" width="' . $width . '" height="' . $height . '" ></iframe>';
        } }
    }
}
/* Video Vimeo
  ================================================== */
if (!function_exists('imic_video_vimeo')) {
   function imic_video_vimeo($url, $width = 500, $height = 281) {
       if($url!='') {
        preg_match('/https?:\/\/vimeo.com\/(\d+)$/', $url, $video_id);
        return '<iframe src="//player.vimeo.com/video/' . $video_id[1] . '?title=0&amp;byline=0&amp;autoplay=0&amp;portrait=0" width="' . $width . '" height="' . $height . '" allowfullscreen></iframe>'; }
    }
}
/* -------------------------------------------------------------------------------------
  Filter the Widget Title.
  ----------------------------------------------------------------------------------- */
if (!function_exists('imic_widget_titles')) {
    add_filter('dynamic_sidebar_params', 'imic_widget_titles', 20);
    function imic_widget_titles(array $params) {
        // $params will ordinarily be an array of 2 elements, we're only interested in the first element
        $widget = & $params[0];
        $id = $params[0]['id'];
        if ($id == 'footer-sidebar') {
            $widget['before_title'] = '<h4 class="widgettitle">';
            $widget['after_title'] = '</h4>';
        } else {
            $widget['before_title'] = '<h3 class="widgettitle">';
            $widget['after_title'] = '</h3>';
        }
        return $params;
    }
}
/* -------------------------------------------------------------------------------------
  Filter the Widget Text.
  ----------------------------------------------------------------------------------- */
add_filter('widget_text', 'do_shortcode');
/* -------------------------------------------------------------------------------------
  RevSlider ShortCode
  ----------------------------------------------------------------------------------- */
if(!function_exists('imic_RevSliderShortCode')){
function imic_RevSliderShortCode(){
     $slidernames = array();
    if(class_exists('RevSlider')){
     $sld = new RevSlider();
                $sliders = $sld->getArrSliders();
        if(!empty($sliders)){
           
        foreach($sliders as $slider){
          $title=$slider->getParam('title','false');
           $shortcode=$slider->getParam('shortcode','false');
            $slidernames[esc_attr($shortcode)]=$title;
        }}
           
}
return $slidernames;
        }}
/** -------------------------------------------------------------------------------------
 * Return 0 if category have any post
 ----------------------------------------------------------------------------------- */
if(!function_exists('imic_cat_count_flag')){
function imic_cat_count_flag(){
    $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
             $flag=1;
              if(!empty($term)){
                 $flag= $output=($term->count==0)?0:1;
              }
             global $cat;
             if(!empty($cat)){
                  $cat_data= get_category($cat);
                $flag=($cat_data->count==0)?0:1;
             }
             return $flag;
}}
//Get all Sidebars
if (!function_exists('imic_get_all_sidebars')) {
    function imic_get_all_sidebars() {
        $all_sidebars = array();
        global $wp_registered_sidebars;
        $all_sidebars = array('' => '');
        foreach ($wp_registered_sidebars as $sidebar) {
            $all_sidebars[$sidebar['id']] = $sidebar['name'];
        }
        return $all_sidebars;
    }
}
//Meta Box for Sidebar on all Posts/Page
if (!function_exists('imic_register_meta_box')) {
    add_action('admin_init', 'imic_register_meta_box');
    function imic_register_meta_box() {
        // Check if plugin is activated or included in theme
        if (!class_exists('RW_Meta_Box'))
            return;
        $prefix = 'imic_';
        $meta_box = array(
            'id' => 'template-sidebar1',
            'title' => __("Select Sidebar", 'framework'),
            'pages' => array('post', 'page', 'yachts', 'product'),
            'context' => 'normal',
            'fields' => array(
                array(
                    'name' => 'Select Sidebar from list',
                    'id' => $prefix . 'select_sidebar_from_list',
                    'desc' => __("Select Sidebar from list, if using page builder then please add sidebar from element only.", 'framework'),
                    'type' => 'select',
                    'options' => imic_get_all_sidebars(),
                ),
				array(
					'name' => __('Columns Layout', 'framework'),
					'id' => $prefix . 'sidebar_columns_layout',
					'desc' => __("Select Columns Layout .", 'framework'),
					'type' => 'select',
					'options' => array(
						'3' => __('One Fourth', 'framework'),
						'4' => __('One Third','framework'),
						'6' => __('Half','framework'),
							),
					'std' => 3,
			),
            )
        );
        new RW_Meta_Box($meta_box);
		$prefix = 'imic_';
        $meta_boxes = array(
            'id' => 'template-featured1',
            'title' => __("Select Featured Sidebar", 'framework'),
            'pages' => array('yachts'),
            'context' => 'normal',
            'fields' => array(
                array(
                    'name' => 'Featured Sidebar',
                    'id' => $prefix . 'select_featured_from_list',
                    'desc' => __("Select Sidebar for featured section of details page.", 'framework'),
                    'type' => 'select',
                    'options' => imic_get_all_sidebars(),
                ),
            )
        );
        new RW_Meta_Box($meta_boxes);
    }
}
//Get Attachment details
if (!function_exists('imic_wp_get_attachment')) {
function imic_wp_get_attachment( $attachment_id ) {
	$attachment = get_post( $attachment_id );
	if(!empty($attachment)) {
	return array(
		'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
		'caption' => $attachment->post_excerpt,
		'description' => $attachment->post_content,
		'href' => get_permalink( $attachment->ID ),
		'src' => $attachment->guid,
		'title' => $attachment->post_title
	); }
} }
/** -------------------------------------------------------------------------------------
 * Gallery Flexslider
 * @param ID of current Post.
 * @return Div with flexslider parameter.
  ----------------------------------------------------------------------------------- */
if (!function_exists('imic_gallery_flexslider')) {
    function imic_gallery_flexslider($id) {
		$speed = (get_post_meta(get_the_ID(), 'imic_gallery_slider_speed', true)!='')?get_post_meta(get_the_ID(), 'imic_gallery_slider_speed', true):5000;
        $pagination = get_post_meta(get_the_ID(), 'imic_gallery_slider_pagination', true);
        $auto_slide = get_post_meta(get_the_ID(), 'imic_gallery_slider_auto_slide', true);
        $direction = get_post_meta(get_the_ID(), 'imic_gallery_slider_direction_arrows', true);
        $effect = get_post_meta(get_the_ID(), 'imic_gallery_slider_effects', true);
        $pagination = !empty($pagination) ? $pagination : 'yes';
        $auto_slide = !empty($auto_slide) ? $auto_slide : 'yes';
        $direction = !empty($direction) ? $direction : 'yes';
        $effect = !empty($effect) ? $effect : 'slide';
        return '<div class="flexslider galleryflex" data-autoplay="' . $auto_slide . '" data-pagination="' . $pagination . '" data-arrows="' . $direction . '" data-style="' . $effect . '" data-pause="yes" data-speed='.$speed.'>';
    }
}
if (!function_exists('imic_social_staff_icon')) {
function imic_social_staff_icon($id = '') {
        $output = '';
		if($id=='') { $id = get_the_ID(); }
        $staff_icons = get_post_meta($id, 'imic_social_icon_list', false);
        if (!empty($staff_icons[0]) || get_post_meta($id, 'imic_staff_member_email', true) != '') {
            $output.='<ul class="social-icons-colored">';
            if (!empty($staff_icons[0])) {
                foreach ($staff_icons[0] as $list => $values) {
                    if (!empty($values[1])) {
                        $className = preg_replace('/\s+/', '-', strtolower($values[0]));
                        $className = 'fa fa-' . $className;
                        $output.='<li class="'.$values[0].'"><a href="' . $values[1] . '" target ="_blank"><i class="' . $className . '"></i></a></li>';
                    }
                }
            }
            if (get_post_meta($id, 'imic_staff_member_email', true) != '') {
                $output.='<li class="email"><a href="mailto:' . get_post_meta($id, 'imic_staff_member_email', true) . '"><i class="fa fa-envelope"></i></a></li>';
            }
            $output.='</ul>';
        }
        return $output;
    }
}
 /**
 * IMIC SHARE BUTTONS
 */
if(!function_exists('imic_share_buttons')){
function imic_share_buttons(){
$posttitle = get_the_title();
$postpermalink = get_permalink();
$postexcerpt = get_the_excerpt();
global $imic_options;
$facebook_share_alt = (isset($imic_options['facebook_share_alt']))?$imic_options['facebook_share_alt']:'';
$twitter_share_alt = (isset($imic_options['twitter_share_alt']))?$imic_options['twitter_share_alt']:'';
$google_share_alt = (isset($imic_options['google_share_alt']))?$imic_options['google_share_alt']:'';
$tumblr_share_alt = (isset($imic_options['tumblr_share_alt']))?$imic_options['tumblr_share_alt']:'';
$pinterest_share_alt = (isset($imic_options['pinterest_share_alt']))?$imic_options['pinterest_share_alt']:'';
$reddit_share_alt = (isset($imic_options['reddit_share_alt']))?$imic_options['reddit_share_alt']:'';
$linkedin_share_alt = (isset($imic_options['linkedin_share_alt']))?$imic_options['linkedin_share_alt']:'';
$email_share_alt = (isset($imic_options['email_share_alt']))?$imic_options['email_share_alt']:'';
$vk_share_alt = (isset($imic_options['vk_share_alt']))?$imic_options['vk_share_alt']:'';
			
            //echo '<div class="social-share-bar">';
			if($imic_options['sharing_style'] == '0'){
				if($imic_options['sharing_color'] == '0'){
					//echo '<h4><i class="fa fa-share-alt"></i> '.__('Share','framework').'</h4>';
            		echo '<ul class="utility-icons social-icons social-icons-colored branded">';
				}elseif($imic_options['sharing_color'] == '1'){
					//echo '<h4><i class="fa fa-share-alt"></i> '.__('Share','framework').'</h4>';
            		echo '<ul class="utility-icons social-icons social-icons-colored share-buttons-tc">';
				}elseif($imic_options['sharing_color'] == '2'){
					//echo '<h4><i class="fa fa-share-alt"></i> '.__('Share','framework').'</h4>';
            		echo '<ul class="utility-icons social-icons social-icons-colored share-buttons-gs">';
				}
			} elseif($imic_options['sharing_style'] == '1'){
				if($imic_options['sharing_color'] == '0'){
					//echo '<h4><i class="fa fa-share-alt"></i> '.__('Share','framework').'</h4>';
            		echo '<ul class="utility-icons social-icons social-icons-colored share-buttons-squared">';
				}elseif($imic_options['sharing_color'] == '1'){
					//echo '<h4><i class="fa fa-share-alt"></i> '.__('Share','framework').'</h4>';
            		echo '<ul class="utility-icons social-icons social-icons-colored share-buttons-tc share-buttons-squared">';
				}elseif($imic_options['sharing_color'] == '2'){
					//echo '<h4><i class="fa fa-share-alt"></i> '.__('Share','framework').'</h4>';
            		echo '<ul class="utility-icons social-icons social-icons-colored share-buttons-gs share-buttons-squared">';
				}
			};
                	echo '<li class="share-title"></li>';
					if($imic_options['share_icon']['1'] == '1'){
                   		echo '<li class="facebook"><a href="https://www.facebook.com/sharer/sharer.php?u=' . $postpermalink . '&amp;t=' . $posttitle . '" target="_blank" title="' . $facebook_share_alt . '"><i class="fa fa-facebook"></i></a></li>';
					}
					if($imic_options['share_icon']['2'] == '1'){
                     	echo '<li class="twitter"><a href="https://twitter.com/intent/tweet?source=' . $postpermalink . '&amp;text=' . $posttitle . ':' . $postpermalink . '" target="_blank" title="' . $twitter_share_alt . '"><i class="fa fa-twitter"></i></a></li>';
					}
					if($imic_options['share_icon']['3'] == '1'){
                    echo '<li class="google"><a href="https://plus.google.com/share?url=' . $postpermalink . '" target="_blank" title="' . $google_share_alt . '"><i class="fa fa-google-plus"></i></a></li>';
					}
					if($imic_options['share_icon']['4'] == '1'){
                    	echo '<li class="tumblr"><a href="http://www.tumblr.com/share?v=3&amp;u=' . $postpermalink . '&amp;t=' . $posttitle . '&amp;s=" target="_blank" title="' . $tumblr_share_alt . '"><i class="fa fa-tumblr"></i></a></li>';
					}
					if($imic_options['share_icon']['5'] == '1'){
                    	echo '<li class="pinterest"><a href="http://pinterest.com/pin/create/button/?url=' . $postpermalink . '&amp;description=' . $postexcerpt . '" target="_blank" title="' . $pinterest_share_alt . '"><i class="fa fa-pinterest"></i></a></li>';
					}
					if($imic_options['share_icon']['6'] == '1'){
                    	echo '<li class="reddit"><a href="http://www.reddit.com/submit?url=' . $postpermalink . '&amp;title=' . $posttitle . '" target="_blank" title="' . $reddit_share_alt . '"><i class="fa fa-reddit"></i></a></li>';
					}
					if($imic_options['share_icon']['7'] == '1'){
                    	echo '<li class="linkedin"><a href="http://www.linkedin.com/shareArticle?mini=true&url=' . $postpermalink . '&amp;title=' . $posttitle . '&amp;summary=' . $postexcerpt . '&amp;source=' . $postpermalink . '" target="_blank" title="' . $linkedin_share_alt . '"><i class="fa fa-linkedin"></i></a></li>';
					}
					if($imic_options['share_icon']['8'] == '1'){
                    	echo '<li class="email"><a href="mailto:?subject=' . $posttitle . '&amp;body=' . $postexcerpt . ':' . $postpermalink . '" target="_blank" title="' . $email_share_alt . '"><i class="fa fa-envelope"></i></a></li>';
					}
					if((isset($imic_options['share_icon']['9']))&&($imic_options['share_icon']['9'] == '1')){
                    	echo '<li class="vk"><a href="http://vk.com/share.php?url=' . $postpermalink . '" target="_blank" title="' . $vk_share_alt . '"><i class="fa fa-vk"></i></a></li>';
					}
                echo '</ul>
            ';
	}
}
/*======================
Change Excerpt Length*/
if (!function_exists('imic_custom_excerpt_length')) {
function imic_custom_excerpt_length( $length ) {
	return 520;
}
add_filter( 'excerpt_length', 'imic_custom_excerpt_length', 999 );
}
if(!function_exists('imic_count_user_posts_by_type')){
function imic_count_user_posts_by_type( $userid, $post_type = 'post' ) {
	global $wpdb;
	$where = get_posts_by_author_sql( $post_type, true, $userid );
	$count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts $where" );
  	return apply_filters( 'get_usernumposts', $count, $userid );
}}
if(!function_exists('imic_search_result')){
function imic_search_result() {
	//echo "sai";
	$data = (isset($_POST['values']))?$_POST['values']:'';
	$paginate = (isset($_POST['paginate']))?$_POST['paginate']:'';
	$category = (isset($_POST['category']))?$_POST['category']:'';
	$tags = (isset($_POST['tags']))?$_POST['tags']:array();
	global $imic_options;
$arrays = $term_array = $list_terms_ids = $list_terms_slug = array();
$order = $term_slug = $have_int = '';
$posts_page = get_option('posts_per_page');
$paged = (get_query_var('paged'))?get_query_var('paged'):'';
$value = $pagin = $offset = $off = '';
$count = 1;
$filters_type = (isset($imic_options['filters_type']))?$imic_options['filters_type']:'';
$data_page = ($filters_type==1)?'yes':'';
$default_image_src = (isset($imic_options['default_car_image']))?$imic_options['default_car_image']['url']:'';
if(!empty($data)) {
foreach($data as $key=>$value)
    {
		if($key!='page_id'&&$key!="lang") {
        $count = count($arrays);
		if(($value=="ASC")||($value=="DESC")) {
			$order = $value;
		} 
		elseif($key=="pg") {
			$posts_page = $value;
			$off = $value;
		}
		elseif($key=="paged") {
			$paged = $value;
			$posts_page = get_option('posts_per_page');
		}
		elseif($key=="list-cat")
		{
			$term_slug = $value;
			$category_id = get_term_by('slug', $value, 'listing-category');
			$term_id = $category_id->term_id;
			$parents = get_ancestors( $term_id, 'listing-category' );
			$list_terms = array();
			foreach($parents as $parent)
			{
				$list_term = get_term_by('id', $parent, 'listing-category');
				$list_terms_slug[] = $list_term->slug;
				$list_terms_ids[] = $list_term->term_id;
			}
			$list_terms[] = $value;
			$term_array[0] = array(
				'taxonomy' => 'listing-category',
				'field' => 'slug',
				'terms' => $list_terms,
				'operator' => 'IN');
		}
		else {
		if (strpos($key,'int_') !== false||strpos($key,'range_') !== false) {
			if(strpos($key,'range_') !== false)
			{
				$new_val = explode("-", $value);
				$value = $new_val[1];
				$pm_value = $new_val[0];
				$key = explode("_", $key);
				$key = "int_".$key[1];
				$arrays[$count++] = array(
                    'key' => $key,
                    'value' =>  $pm_value,
                    'compare' => '>=',
										'type' => 'numeric'
                    );
			}
			$arrays[$count] = array(
                    'key' => $key,
                    'value' =>  $value,
                    'compare' => '<=',
										'type' => 'numeric'
                    );
					$have_int = 1;
		}
		elseif (strpos($key,'char_') !== false||strpos($key,'child_') !== false) {
			$value = str_replace('%20', ' ', $value);
			$arrays[$count] = array(
                    'key' => $key,
                    'value' =>  $value,
                    'compare' => '=',
                    );
		}elseif (strpos($key,'options') !== false) {
            $arrays[$count] = array(
                    'key' => 'imic_plugin_ad_payment_status',
                    'value' =>  '1',
                    'compare' => '=',
                    );
        }
		 else {
        $arrays[$count] = array(
                    'key' => 'feat_data',
                    'value' =>  serialize(strval($value)),
                    'compare' => 'LIKE'
                    ); }
		}
	
   $count++; } 
   } 
   
   }
	$arrays[$count++] = array('key'=>'imic_plugin_ad_payment_status','value'=>'1','compare'=>'=');
	$arrays[$count++] = array('key'=>'imic_plugin_listing_end_dt','value'=>date('Y-m-d'),'compare'=>'>=');
	if($paged==1) { $offset = $off; 
	}
	elseif($paged>1) { $offs = $paged-1; $offset = $off+($posts_page*$offs);
	}
	if(!empty($tags))
	{
		$term_array[1] = array(
				'taxonomy' => 'yachts-tag',
				'field' => 'slug',
				'terms' => $tags,
				'operator' => 'IN');
	}
	if($data_page=="yes")
	{
	if($category==1) {
	$class_list = 12;
					$search_filter_custom = get_option('imic_classifieds');
					//print_r($search_filter_custom);
					if(!empty($search_filter_custom))
					{
					foreach($search_filter_custom as $key=>$value)
					{
						if($key==$term_id)
						{
							$filters = $value['filter'];
							if($filters!='')
							{
								$search_filters = explode(',',$filters);
							}
							break;
						}
						else
						{
							foreach($list_terms_ids as $id)
							{
								if($key==$id)
								{
									$filters = $value['filter'];
									if($filters!='')
									{
										$search_filters = explode(',',$filters);
									}
									break;
								}
							}
						}
					}
					}
							if(!empty($search_filters)) { ?>
                    <div class="col-md-3 search-filters" id="Search-Filters">
                    	<div class="filters-sidebar">
                            <h3><?php _e('Refine Search','framework'); ?></h3>
                            <div class="accordion" id="toggleArea">
                                <!-- Filter by Year -->
                                <?php $series = 1;
								$numeric_specs_type = (isset($imic_options['integer_specs_type']))?$imic_options['integer_specs_type']:0;
								$new_search_filters = imic_filter_lang_specs($search_filters);
								foreach($new_search_filters as $filter) {
								$integer = get_post_meta($filter,'imic_plugin_spec_char_type',true);
								$tabs = get_post_meta($filter,'specifications_value',true);
								$value_label = get_post_meta($filter, 'imic_plugin_value_label', true);
								$spec_slug = imic_the_slug($filter);
								if($integer==0) {
									$slug = $spec_slug;
									$comparision = "";
								 }
								elseif($integer==1) {
									if($numeric_specs_type==0)
									{
										$slug = "int_".$spec_slug;
										$comparision = "<span>".__("Less Than ","framework").'</span>';
									}
									else
									{
										$slug = "range_".$spec_slug;
										$comparision = '';
									}
								}
								else
								{
									$slug = "char_".$spec_slug;
									$comparision = "";
								}
								$get_child_filter = (imic_get_child_values_status($tabs)==1)?'get-child-filter':'';
								$slider_range_step = (isset($imic_options['range_steps']))?$imic_options['range_steps']:100;
								?>
                                <!-- Filter by Make -->
                                <div class="accordion-group panel">
                                    <div class="accordion-heading togglize"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#" href="#collapseTwo-<?php echo esc_attr($series); ?>"><?php echo get_the_title($filter); ?><i class="fa fa-angle-down"></i> </a> </div>
                                    <div id="collapseTwo-<?php echo esc_attr($series); ?>" class="accordion-body collapse">
                                        <div class="accordion-inner">
                                            <ul data-ids="<?php echo 'fieldfltr-'.($filter+2648); ?>" id="<?php echo esc_attr($slug); ?>" class="filter-options-list list-group search-fields">
                                            <?php if($integer==1&&$numeric_specs_type==1) { ?>
                                            <li><b><?php echo esc_attr($value_label); ?> <span class="left">0</span> - 
<span class="right">10000</span></b> <input id="ex2" type="text" class="span2" value="" data-slider-min="0" data-slider-max="100000" data-slider-step="<?php echo esc_attr($slider_range_step); ?>" data-slider-value="[0,10000]" data-imic-start="" data-imic-end=""/>
<br />
<!--<span class="left">0</span> - 
<span class="right">10000</span>-->
<a data-range="0-10000" class="range-val btn-primary btn-sm btn"><?php _e('Filter', 'framework'); ?></a></li>
                                            <?php } else { 
																						foreach($tabs as $tab) {
												if($series==1) { $prefix = ''; } else { $prefix = ''; }
												if($integer==0) {
													$specification = "feat_data"; }
												else {
													$specification = $slug; }
												$total_cars = imic_count_cars_by_specification($specification,$tab['imic_plugin_specification_values'], $term_slug); ?>
                                                <li class="list-group-item"><span class="badge"><?php echo esc_attr($total_cars); ?></span><?php echo $comparision; ?><a class="<?php echo $get_child_filter; ?>" href="#"><?php echo esc_attr($prefix.$tab['imic_plugin_specification_values']); ?></a></li>
                                           	<?php } } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php if(imic_get_child_values_status($tabs)==1) {
									$child_label = get_post_meta($filter,'imic_plugin_sub_field_label',true);
											echo '<div id="fieldfltr-'.(($filter*111)+2648).'">';
                                            echo '<div class="accordion-group panel">
                                    <div class="accordion-heading togglize"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#" href="#collapseTwo-sub'.esc_attr($series).'">'.$child_label.'<i class="fa fa-angle-down"></i> </a> </div>
                                    <div id="collapseTwo-sub'.esc_attr($series).'" class="accordion-body collapse">
                                        <div class="accordion-inner">
                                            <ul id="sub-'.esc_attr($slug).'" class="filter-options-list list-group search-fields">';
											echo '<li>'.__('Select ', 'framework').get_the_title($filter).'</li>';
                                            echo '</ul>
                                        </div>
                                    </div>
                                </div>';
										echo '</div>';
									
								} ?>
                                <?php $series++; } ?>
                            </div>
                            <!-- End Toggle -->
                    <?php $class_list = 9; }
						if(!empty($search_filters)) {						}
						else
						{
							echo ' <div class="col-md-3 search-filters">
							<div class="filters-sidebar">';
						}
						$list_tags = array();
						$tag = '';
						if($term_slug!='')
						{
                    		$listing_tags = get_terms('cars-tag',array('hide_empty'=>true));
							foreach($listing_tags as $tag)
							{
								$tag_description = get_option("taxonomy_".$tag->term_id."_metas");
								$tag_descriptions = explode(',',$tag_description['cats']);
								if (in_array($term_slug,$tag_descriptions))
								{
									$list_tags[] = $tag->slug;
								}
								else
								{
									foreach($list_terms_slug as $slug_c)
									{
										if (in_array($slug_c,$tag_descriptions))
										{
											$list_tags[] = $tag->slug;
											break;
										}
									}
								}
							}
						} ?>
                        
                                            <?php if(!empty($list_tags))
											{
												echo '<h3>'.__('Deep Search','framework').'</h3>
                                				<div class="widget_tag_cloud matched-tags-list">';
											foreach($list_tags as $tab) 
											{
												$tag_name = get_term_by('slug', $tab, 'cars-tag');
                                                echo '<a href="javascript:void(0);" class="">'.$tag_name->name.'</a>';
                                           	} 
											echo '</div><br/>';
											}
											else
											{
												//echo '<a href="javascript:void(0);">'.__('Filters not found, please select category.','framework').'</li>';
											}?>
                                
                                <!-- End Toggle -->
                            <a href="#" id="reset-filters-search" class="btn-default btn-sm btn"><i class="fa fa-refresh"></i> <?php _e('Reset search','framework'); ?></a>
                            <a id="saved-search" href="#" class="btn-primary btn-sm btn" data-target="#searchmodal" data-toggle="modal"><div class="vehicle-details-access" style="display:none;"><span class="vehicle-id"><?php echo esc_attr(get_the_ID()); ?></span></div><i class="fa fa-folder-o"></i> <?php _e('Save search','framework'); ?></a>
                    <?php $class_list = 9;
						echo ' </div>
                    	</div>';
					?>
                    <!-- Listing Results -->
                    <div class="col-md-<?php echo esc_attr($class_list); ?> results-container">
                        <div class="results-container-in">
                        	<div class="waiting" style="display:none;">
                            	<div class="spinner">
                                  	<div class="rect1"></div>
                                  	<div class="rect2"></div>
                                  	<div class="rect3"></div>
                                  	<div class="rect4"></div>
                                  	<div class="rect5"></div>
                                </div>
                            </div>
                            <div id="results-holder" class="results-list-view">
	<?php } } $logged_user_pin = '';			
	$user_id = get_current_user_id( );
										$logged_user = get_user_meta($user_id,'imic_user_info_id',true);
										$logged_user_pin = get_post_meta($logged_user,'imic_user_zip_code',true);
										$badges_type = (isset($imic_options['badges_type']))?$imic_options['badges_type']:'0';
										$specification_type = (isset($imic_options['short_specifications']))?$imic_options['short_specifications']:'0';
										if($badges_type=="0")
										{
											$badge_ids = (isset($imic_options['badge_specs']))?$imic_options['badge_specs']:array();
										}
										else
										{
											$badge_ids = array();
										}
										$args_cats = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');
										$classifieds_data = get_option('imic_classifieds');
										$img_src = '';
										$additional_specs = (isset($imic_options['additional_specs']))?$imic_options['additional_specs']:'';
										if($specification_type==0)
										{
											$detailed_specs = (isset($imic_options['specification_list']))?$imic_options['specification_list']:array();
										}
										else
										{
											$detailed_specs = array();
										}
										$detailed_specs = imic_filter_lang_specs($detailed_specs);
										$category_rail = (isset($imic_options['category_rail']))?$imic_options['category_rail']:'0';
										$additional_specs_all = get_post_meta($additional_specs,'specifications_value',true);
										$highlighted_specs = (isset($imic_options['highlighted_specs']))?$imic_options['highlighted_specs']:array();
										$unique_specs = (isset($imic_options['unique_specs']))?$imic_options['unique_specs']:'';	
										if($have_int==1)
										{
											$args_cars = array('post_type'=>'yachts','orderby' => 'meta_value_num','order' => $order,'tax_query'=>$term_array,'meta_query' => $arrays,'posts_per_page'=>$posts_page,'post_status'=>'publish','offset'=>$offset);
										}
										else
										{
											$args_cars = array('post_type'=>'yachts','order' => $order,'tax_query'=>$term_array,'meta_query' => $arrays,'posts_per_page'=>$posts_page,'post_status'=>'publish','offset'=>$offset);
										}
									$cars_listing = new WP_Query( $args_cars );
									if ( $cars_listing->have_posts() ) :
										while ( $cars_listing->have_posts() ) :	
											$cars_listing->the_post();
										if(is_plugin_active("imi-classifieds/imi-classified.php")) 
										{
											$badge_ids = imic_classified_badge_specs(get_the_ID(), $badge_ids);
											$detailed_specs = imic_classified_short_specs(get_the_ID(), $detailed_specs);
										}
										$badge_ids = imic_filter_lang_specs($badge_ids);
										$post_author_id = get_post_field( 'post_author', get_the_ID() );
										$user_info_id = get_user_meta($post_author_id,'imic_user_info_id',true);
										$car_pin = get_post_meta($user_info_id,'imic_user_lat_long',true);
										$car_pin = explode(',',$car_pin);
										$post_author_id = get_post_field( 'post_author', get_the_ID() );
										$user_info_id = get_user_meta($post_author_id,'imic_user_info_id',true);
										$author_role = get_option('blogname');
										if(!empty($user_info_id)) {
										$term_list = wp_get_post_terms($user_info_id, 'user-role', array("fields" => "names"));
										if(!empty($term_list)) {
										$author_role = $term_list[0]; }
										else { $author_role = get_option('blogname'); }
										}
										$save1 = (isset($_SESSION['saved_vehicle_id1']))?$_SESSION['saved_vehicle_id1']:'';
										$save2 = (isset($_SESSION['saved_vehicle_id2']))?$_SESSION['saved_vehicle_id2']:'';
										$save3 = (isset($_SESSION['saved_vehicle_id3']))?$_SESSION['saved_vehicle_id3']:'';
										$specifications = get_post_meta(get_the_ID(),'feat_data',true);
										$unique_value = imic_vehicle_price(get_the_ID(),$unique_specs,$specifications);
										$new_highlighted_specs = imic_filter_lang_specs_admin($highlighted_specs, get_the_ID());	
										$highlighted_specs = $new_highlighted_specs;
										$highlight_value = imic_vehicle_title(get_the_ID(),$highlighted_specs,$specifications);
										$highlight_value = ($highlight_value=='')?get_the_title():$highlight_value;
										$details_value = imic_vehicle_all_specs(get_the_ID(),$detailed_specs,$specifications);
										$badges = imic_vehicle_all_specs(get_the_ID(),$badge_ids,$specifications);
										$video = get_post_meta(get_the_ID(),'imic_plugin_video_url',true);
										$user_id = get_current_user_id( );
										$current_user_info_id = get_user_meta($user_id,'imic_user_info_id',true);
										if($current_user_info_id!='') {
										$saved_car_user = get_post_meta($current_user_info_id,'imic_user_saved_cars',true); }
										if((empty($saved_car_user))||($current_user_info_id=='')||($saved_car_user=='')) { $saved_car_user = array($save1, $save2, $save3); }
										$save_icon = (imic_value_search_multi_array(get_the_ID(),$saved_car_user))?'fa-star':'fa-star-o';
										$save_icon_disable = (imic_value_search_multi_array(get_the_ID(),$saved_car_user))?'disabled':'';
										?>
                                        <!-- Result Item -->
                                        <div class="result-item format-standard">
                                            <div class="result-item-image"><?php if(has_post_thumbnail()) { ?>
                                                <a href="<?php echo esc_url(get_permalink()); ?>" class="media-box"><?php the_post_thumbnail('600x400'); ?></a><?php }
																								else
																								{
																									echo '<a href="'.esc_url(get_permalink()).'" class="media-box"><img src="'.$default_image_src.'"></a>';
																								} ?>
                                                <?php $start = 0; 
													$badge_position = array('vehicle-age','premium-listing','third-listing','fourth-listing');
													if(!empty($badges)) {
													foreach($badges as $badge):
														$badge_class = ($start==0)?'default':'success';
														echo '<span class="label label-'.$badge_class.' '.$badge_position[$start].'">'.$badge.'</span>';
													$start++; if($start>3) { break; }
													endforeach; } ?>
                                                <div class="result-item-view-buttons">
                                                    <?php if($video!='') { ?>
                                                    <a href="<?php echo esc_attr($video); ?>" data-rel="prettyPhoto"><i class="fa fa-play"></i> <?php _e('View video','framework'); ?></a><?php } ?>
                                                    <a href="<?php echo esc_url(get_permalink()); ?>"><i class="fa fa-plus"></i> <?php _e('View details','framework'); ?></a>
                                                </div>
                                            </div>
                                            <div class="result-item-in">
                                                <h4 class="result-item-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_attr($highlight_value); ?></a>
                                                <?php 
												if($category_rail=="1"&&is_plugin_active("imi-classifieds/imi-classified.php"))
												{
													echo imic_get_cats_list(get_the_ID(), "dropdown");
												}
												?></h4>
                                                <div class="result-item-cont">
                                                    <div class="result-item-block col1">
                                                        <?php echo imic_excerpt(20); ?>
                                                    </div>
                                                    <div class="result-item-block col2">
                                                        <div class="result-item-pricing">
                                                            <div class="price"><?php echo esc_attr($unique_value); ?></div>
                                                        </div>
                                                        <div class="result-item-action-buttons">
                                                            <a <?php echo esc_attr($save_icon_disable); ?> id="" href="#" class="btn btn-default btn-sm save-car"><div class="vehicle-details-access" style="display:none;"><span class="vehicle-id"><?php echo esc_attr(get_the_ID()); ?></span></div><i class="fa <?php echo esc_attr($save_icon); ?>"></i> <?php _e('Save','framework'); ?></a>
                                                            <a href="<?php echo esc_url(get_permalink()); ?>" class="btn btn-default btn-sm"><?php _e('Enquire','framework'); ?></a><br>
                                                            <div class="view-distance"><div style="display:none;"><span class="car-lat"><?php echo esc_attr($car_pin[0]); ?></span><span class="car-long"><?php echo esc_attr($car_pin[1]); ?></span></div><a id="<?php echo get_the_ID(); ?>" href="#" class="distance-calc"><i class="fa fa-map-marker"></i> <?php _e('Distance from me?','framework'); ?></a>
                                                            <div class="input-group">
                                                              	<input type="text" value="<?php echo esc_attr($logged_user_pin); ?>" class="get-distance form-control input-sm" style="display:none;" placeholder="Enter Zipcode">
                                                              	<span class="input-group-btn">
                                                                	<a href="#" class="btn btn-default btn-sm search-dist" style="display:none;"><?php _e('Get','framework'); ?></a>
                                                              	</span>
                                                            </div></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="result-item-features">
                                                    <ul class="inline">
                                                    <?php if(!empty($details_value)) {
														foreach($details_value as $detail) {
															if(!empty($detail)) {
														echo '<li>'.$detail.'</li>'; }
													} } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endwhile; else: ?>
										<div class="text-align-center error-404">
              		<hr class="sm">
              		<p><strong><?php echo esc_attr_e('No listing found for this criteria','framework'); ?></strong></p>
					<p><?php echo esc_attr_e('Please search again with different filters.','framework'); ?></p>
             	</div>
                
										<?php endif; echo '<div class="clearfix"></div>'; 
										$paginate = ($paged=='')?1:$paged; 
										imic_listing_pagination("page-".$paginate, $cars_listing->max_num_pages, $paged); 
										wp_reset_postdata();
										if($data_page=="yes")
										{
											echo '</div></div></div>';
										}
	die();
}
add_action('wp_ajax_nopriv_imic_search_result', 'imic_search_result');
add_action('wp_ajax_imic_search_result', 'imic_search_result');
}
if(!function_exists('imic_matched_results')){
function imic_matched_results() {
	$vals = (isset($_POST['values']))?$_POST['values']:'';
	$ids = (isset($_POST['ids']))?$_POST['ids']:'';
	$posts_page = -1;
	//echo "sai";
	array_pop($vals);
	global $imic_options;
$arrays = array();
if((is_array($ids))&&(is_array($vals))) {
$data = array_combine($ids, $vals);
//print_r($data);
if(!empty($data)) {
	
	$count = 1;
foreach($data as $key=>$value)
    {
		if (strpos($key,'int') !== false) {
			$arrays[$count] = array(
                    'key' => $key,
                    'value' =>  $value,
                    'compare' => '<=',
					'type' => 'numeric'
                    );
		} else {
        $arrays[$count] = array(
                    'key' => 'feat_data',
                    'value' =>  $value,
                    'compare' => 'LIKE'
                    ); }
		$count++; }
	
   //} 
   		$arrays[$count+1] = array('key'=>'imic_plugin_ad_payment_status','value'=>'1','compare'=>'=');
   } 
   		$badges_type = (isset($imic_options['badges_type']))?$imic_options['badges_type']:'0';
		$specification_type = (isset($imic_options['short_specifications']))?$imic_options['short_specifications']:'0';
		if($badges_type=="0")
		{
			$badge_ids = $imic_options['badge_specs'];
		}
		else
		{
			$badge_ids = array();
		}
		if($specification_type==0)
		{
		$detailed_specs = $imic_options['specification_list'];
		}
		else
		{
			$detailed_specs = array();
		}
		$highlighted_specs = $imic_options['highlighted_specs'];
		$args_cars = array('post_type'=>'yachts','meta_query' => $arrays,'posts_per_page'=>-1,'post_status'=>'publish');
		$cars_listing = new WP_Query( $args_cars );
		if ( $cars_listing->have_posts() ) :
			while ( $cars_listing->have_posts() ) :	
				$cars_listing->the_post();
				if(is_plugin_active("imi-classifieds/imi-classified.php")) 
				{
					$badge_ids = imic_classified_badge_specs(get_the_ID(), $badge_ids);
					$detailed_specs = imic_classified_short_specs(get_the_ID(), $detailed_specs);
				}
				$specifications = get_post_meta(get_the_ID(),'feat_data',true);
				$details_value = imic_vehicle_all_specs(get_the_ID(),$detailed_specs,$specifications);
				$new_highlighted_specs = imic_filter_lang_specs_admin($highlighted_specs, get_the_ID());	
				$highlighted_specs = $new_highlighted_specs;
				$highlight_value = imic_vehicle_title(get_the_ID(),$highlighted_specs,$specifications);
				$highlight_value = ($highlight_value=='')?get_the_title(get_the_ID()):$highlight_value; ?>
              	<!-- Result Item -->
              	<div class="search-find-results">
             	<h5><?php echo esc_attr($highlight_value); ?></h5>
           		<ul class="inline">
         		<?php foreach($details_value as $detail) 
				{
					echo '<li>'.$detail.'</li>';
				} ?>
             	</ul>
         		<button id="matched-<?php echo get_the_ID()+2648; ?>" class="btn btn-info btn-sm save-searched-value">Select &amp; continue</button>
             	</div><?php
			endwhile; 
		else: ?>
		<div class="search-find-results">
    	<h5><?php _e('No Match Found','framework'); ?></h5>
      	</ul>
    	<a data-toggle="tab" href="#addcustom"><?php _e('Continue with Custom Details','framework'); ?></a>
     	</div>
	<?php endif; wp_reset_postdata(); 
	}
	else 
	{ ?>
        <div class="search-find-results">
    	<h5><?php _e('No Match Found','framework'); ?></h5>
   		</ul>
       	<a data-toggle="tab" href="#addcustom"><?php _e('Continue with Custom Details','framework'); ?></a>
      	</div>
<?php }
	die();
}
add_action('wp_ajax_nopriv_imic_matched_results', 'imic_matched_results');
add_action('wp_ajax_imic_matched_results', 'imic_matched_results');
}
if(!function_exists('imic_get_all_integer_specifications')){
function imic_get_all_integer_specifications($type) {
	$int_specs = array();
	$args_specification = array('post_type'=>'specification','posts_per_page'=>-1,'meta_query'=>array(array('key'=>'imic_plugin_spec_char_type','value'=>$type,'compare'=>'=')));
	$specification_listing = new WP_Query( $args_specification );
									if ( $specification_listing->have_posts() ) :
										while ( $specification_listing->have_posts() ) :	
											$specification_listing->the_post();
	$int_specs[] = imic_the_slug(get_the_ID());
	endwhile; endif; wp_reset_postdata();
	return $int_specs;
}
}
if(!function_exists('imic_create_vehicle'))
{
	function imic_create_vehicle() 
	{
		//echo "sainath";
		global $imic_options;
		$post_id = $_POST['post_id'];
		$steps = $_POST['steps'];
		$updating_values = '';
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$listing_view = (isset($_POST['listing_view']))?$_POST['listing_view']:'';
		$fields = (isset($_POST['values']))?$_POST['values']:'';
		$tags = (isset($_POST['tags']))?$_POST['tags']:array();
		$val = $id = $mids = '';
		$data = (isset($_POST['matched']))?$_POST['matched']:'';
		$mids = (isset($_POST['mids']))?$_POST['mids']:'';
		$category = (isset($_POST['category']))?$_POST['category']:'';
		$category = ($category!="none")?$category:'';
		$remain = (isset($_POST['remain']))?$_POST['remain']:'';
		$plans = (isset($_POST['plan']))?$_POST['plan']:'';
		$user_id = get_current_user_id( );
		$user_info_id = get_user_meta($user_id,'imic_user_info_id',true);
		$user_remaining_listings = get_post_meta($user_info_id, 'imic_allowed_listings_'.$plans, true);
		if(!empty($mids)) 
		{
			foreach($mids as $mid) 
			{
				$spec_ids = explode('-',$mid);
				$spec_id[] = $spec_ids[1]; 
			}
			$new_array = array();
			foreach($spec_id as $specs) 
			{
				$new_array[] = $specs-2648; 
			}
			$updating_values = array_combine($new_array, $fields); 
		}
		$listing_status = (isset($imic_options['opt_listing_status']))?$imic_options['opt_listing_status']:'draft';
		$my_post = array(
		 'post_title'    => 'listing',
		 'post_type'	=> 'yachts',
		 'post_status'	=> $listing_status,
		);
		if(empty($post_id)) 
		{
		$post_id = wp_insert_post( $my_post ); 
		update_post_meta($user_info_id, 'imic_allowed_listings_'.$plans, $user_remaining_listings-1);
		$user_plan_summary = get_post_meta($user_info_id, 'imic_user_plan_'.$plans, true);
		if(!empty($user_plan_summary))
		{
			foreach($user_plan_summary as $key=>$value)
			{
				$new_value[$key] = $value.','.$post_id;
			}
			update_post_meta($user_info_id, 'imic_user_plan_'.$plans, $new_value);
		}
		update_post_meta($post_id, 'imic_pages_Choose_slider_display', '1');
		update_post_meta($post_id, 'imic_browse_by_specification_switch', '2');
		$valid_with_plan = get_post_meta($plans, 'imic_plan_validity_expire_listing', true);
		//Listing not showing in front end if user doesn't set any plan
		$listing_end_date = get_post_meta($post_id, 'imic_plugin_listing_end_dt', true);
		if($listing_end_date==''&&$valid_with_plan!=1)
		{
			update_post_meta($post_id, 'imic_plugin_listing_end_dt', '2020-01-01');
		}
		}
		if($category!='')
		{
			$cat_slug = $category;
			$category_id = get_term_by('slug', $cat_slug, 'listing-category');
			$term_id = $category_id->term_id;
			$parents = get_ancestors( $term_id, 'listing-category' );
			$list_terms = array();
			foreach($parents as $parent)
			{
				$list_term = get_term_by('id', $parent, 'listing-category');
				$list_terms[] = $list_term->slug;
			}
			$list_terms[] = $cat_slug;
			wp_set_object_terms($post_id, $list_terms, 'listing-category');
		}
		if($data!='') 
		{
			$id = explode('-',$data);
			if(!empty($id)) 
			{
				$id = $id[1]-2648;
				$val = get_post_meta($id,'feat_data',true);
				$int_specs = imic_get_all_integer_specifications(1);
				$char_specs = imic_get_all_integer_specifications(2);
				foreach($int_specs as $int_spec) 
				{
					$pre_val = get_post_meta($id,'int_'.$int_spec,true);
					update_post_meta($post_id,'int_'.$int_spec,$pre_val);
				} 
				foreach($char_specs as $char_spec) 
				{
					$pre_val = get_post_meta($id,'char_'.$char_spec,true);
					update_post_meta($post_id,'char_'.$char_spec,$pre_val);
				} 
			}
		}
		if(!empty($mids)) 
		{
			$spec_in = array();
			$int_count = 0;
			foreach($mids as $mid) 
			{
			$specs_int = explode('-',$mid);
			if($specs_int[0]=="int") 
			{
				$post_data = get_post($specs_int[1]);
				$spec_slug = $post_data->post_name;
				update_post_meta($post_id,'int_'.$spec_slug,$fields[$int_count]);
			}
			elseif($specs_int[0]=="char") 
			{
				$spec_id = $specs_int[1]-2648;
				if(get_post_type($specs_int[1])=="specification")
				{
					$post_data = get_post($specs_int[1]);
					$spec_slug = $post_data->post_name;
					update_post_meta($post_id,'char_'.$spec_slug,$fields[$int_count]);
				}
				elseif(get_post_type($spec_id)=="specification")
				{
					$post_data = get_post($spec_id);
					$spec_slug = $post_data->post_name;
					update_post_meta($post_id,'char_'.$spec_slug,$fields[$int_count]);
				}
			}
			elseif($specs_int[0]=="child") 
			{
				$spec_id = $specs_int[1]-2648;
				$spec_id = $spec_id/111;
				$post_data = get_post($spec_id);
				$spec_slug = $post_data->post_name;
				update_post_meta($post_id,'child_'.$spec_slug,$fields[$int_count]);
			}
			$spec_in[] = $specs_int[1]; $int_count++; 
		}
		$int_val_array = array_combine($spec_in, $fields); 
	}
	$tags = array_map( 'intval', $tags );
	$tags = array_unique( $tags );
	wp_set_object_terms($post_id, $tags, 'cars-tag');
	if(!empty($tags)) 
	{
		foreach($tags as $tag) 
		{
			//wp_set_object_terms($post_id, $tag, 'cars-tag');
		}
	}
	$step = '';
	if($steps=="listing-add-form-one") 
	{
		$step = 1;
	}
	elseif($steps=="listing-add-form-two")
	{
		$step = 2;
	}
	elseif($steps=="listing-add-form-three")
	{
		$step = 3;
	}
	elseif($steps=="listing-add-form-four")
	{
		$step = 4;
	}
	elseif($steps=="listing-add-form-five"){
		$step = 5;
	}
	$already_step = get_post_meta($post_id,'imic_plugin_ads_steps',true);
	if($already_step<$step) 
	{ 
		update_post_meta($post_id,'imic_plugin_ads_steps',$step); 
	}
	update_post_meta($post_id,'imic_plugin_contact_phone',$phone);
	update_post_meta($post_id,'imic_plugin_contact_email',$email);
	update_post_meta($post_id,'imic_plugin_listing_view',$listing_view);
	$specs_ids = array();
	$ints = array();
	$args_specification = array('post_type'=>'specification','posts_per_page'=>'-1','post_status'=>'publish');
	$specification_listing = new WP_Query( $args_specification );
		if ( $specification_listing->have_posts() ) :
			while ( $specification_listing->have_posts() ) :	
				$specification_listing->the_post();
				$int = get_post_meta(get_the_ID(),'imic_plugin_spec_char_type',true);
				if($int==0) 
				{
					$specs_ids[] = get_the_ID(); 
				}
				else 
				{
					$ints[] = get_the_ID();
				}
			endwhile; 
		endif; wp_reset_postdata();
		foreach($ints as $in) 
		{
	}
	$specification_values = get_post_meta($post_id,'feat_data',true);
	if(empty($specification_values['start_time'])) 
	{
		for ($i = 0; $i < count( $specs_ids ); $i++ ) 
    {
			$id = $specs_ids[$i];
			$vals = get_post_meta($id,'specifications_value',true);
			if(imic_get_child_values_status($vals)==1) 
			{
				$feat_data['start_time'][]  = '';
        $feat_data['sch_title'][]  = $id*111;
			}
			$feat_data['start_time'][]  = 'select';
      $feat_data['sch_title'][]  = $id;
   	}
    if ( !empty($feat_data) ) 
		{
			update_post_meta( $post_id, 'feat_data', $feat_data ); 
		}
	}
	$specification_values = get_post_meta($post_id,'feat_data',true);
	if(!empty($specification_values['start_time']))
	{
		for ($i = 0; $i < count( $specification_values['start_time'] ); $i++ ) 
  	{
			$value = $specification_values['start_time'][$i];
			$id = $specification_values['sch_title'][$i];
			if(!empty($updating_values)) 
			{
				if($i==0) 
				{
					foreach($updating_values as $key=>$values) 
					{
						$key_id = array_search($key,$specification_values['sch_title']);
						if(!is_int($key_id)) 
						{
							if(get_post_type($key)=='specification') 
							{
								$vals = get_post_meta($key,'specifications_value',true);
								if(imic_get_child_values_status($vals)==1) 
								{
									$new_feat_data['start_time'][]  = $values;
									$new_feat_data['sch_title'][]  = $key*111;
								}
								$new_feat_data['start_time'][]  = $values;
								$new_feat_data['sch_title'][]  = $key;
							} 
						} 
					} 
				}
				if(isset($updating_values[$id])) 
				{ 
					$value = $updating_values[$id]; 
				} 
			}
			$new_feat_data['start_time'][]  = $value;
			$new_feat_data['sch_title'][]  = $id;
		}
	}
  if ( !empty($new_feat_data) ) 
	{
    update_post_meta( $post_id, 'feat_data', $new_feat_data ); 
	}
	$title = (isset($imic_options['highlighted_specs']))?$imic_options['highlighted_specs']:array();
	$specifications = get_post_meta($post_id,'feat_data',true);
	$new_highlighted_specs = imic_filter_lang_specs_admin($title, $post_id);	
	$title = $new_highlighted_specs;
	$new_title = imic_vehicle_title($post_id,$title,$specifications);
	$new_slug = sanitize_title( $new_title );
	$this_slug = imic_the_slug($post_id);
    if ( $this_slug != $new_slug )
    {
	$update_title = array(
	'ID'           => $post_id,
	'post_title'   => $new_title,
	'post_name' => $new_slug
	);
  	wp_update_post( $update_title );
	}
	if($val!='') 
	{
		update_post_meta($post_id,'feat_data',$val); 
	}
	echo esc_attr($post_id);
	die();
}
add_action('wp_ajax_nopriv_imic_create_vehicle', 'imic_create_vehicle');
add_action('wp_ajax_imic_create_vehicle', 'imic_create_vehicle');
}
/* ADD QUERY ARGUMENTS
   =========================================================*/
if(!function_exists('imic_add_query_vars_filter')) {
function imic_add_query_vars_filter( $vars ){
  $vars[] = "edit";
  $vars[] = "search";
  $vars[] = "saved";
  $vars[] = "profile";
  $vars[] = "account";
  $vars[] = "manage";
  $vars[] = "compare";
  $vars[] = "plans";
  $vars[] = "list-cat";
  return $vars;
}
add_filter( 'query_vars', 'imic_add_query_vars_filter' );
}
if(!function_exists('imic_session_init')) {
function imic_session_init() {
if (!session_id()) {
session_start();
}
}
$import = (isset($_GET['import']))?$_GET['import']:'';
if( (basename($_SERVER['SCRIPT_NAME'])!="import.php")&&($import!='wordpress')) {
//if(!is_admin()) { 
add_action( 'init', 'imic_session_init' ); }
}
if(!function_exists('imic_search_array')) {
function imic_search_array($needle, $haystack) {
     if(in_array($needle, $haystack)) {
          return true;
     }
     foreach($haystack as $element) {
          if(is_array($element) && imic_search_array($needle, $element))
               return true;
     }
   return false;
}
}
if(!function_exists('imic_vehicle_add')) {
function imic_vehicle_add() {
	//echo "sai";
	global $imic_options;
	$highlighted_specs = $imic_options['highlighted_specs'];
	$unique_specs = $imic_options['unique_specs'];
	if ( is_user_logged_in() ) { //echo "ss";
		if((isset($_SESSION['saved_vehicle_id1']))||(isset($_SESSION['saved_vehicle_id2']))||(isset($_SESSION['saved_vehicle_id3']))) { 
			$vehicle_1 = (isset($_SESSION['saved_vehicle_id1']))?$_SESSION['saved_vehicle_id1']:'';
			$vehicle_2 = (isset($_SESSION['saved_vehicle_id2']))?$_SESSION['saved_vehicle_id2']:'';
			$vehicle_3 = (isset($_SESSION['saved_vehicle_id3']))?$_SESSION['saved_vehicle_id3']:'';
			$ids = array($vehicle_1, $vehicle_2,$vehicle_3);
			$time = date('U');
			$car = array();
			$user_id = get_current_user_id( );
			$user_info_id = get_user_meta($user_id,'imic_user_info_id',true);
			$saved_cars_user = get_post_meta($user_info_id,'imic_user_saved_cars',true);
			if(!empty($saved_cars_user)) {
				foreach($saved_cars_user as $cars) {
					$car[] = $cars;
				} 	
			}
			foreach($ids as $id)
			{
				if($id!='')
				{
					if(!imic_search_array($id,$car)) 
					{
						$car[] = array($id, $time);
					}
				}
			}
		update_post_meta($user_info_id,'imic_user_saved_cars',$car);	
		$saved_cars = get_post_meta($user_info_id,'imic_user_saved_cars',true);
		$i = 0;
		foreach($saved_cars as $car) {
			$specifications = get_post_meta($car[0],'feat_data',true);
			$unique_values = imic_vehicle_price($car[0],$unique_specs,$specifications);
			$new_highlighted_specs = imic_filter_lang_specs_admin($highlighted_specs, $car[0]);	
			$highlighted_specs = $new_highlighted_specs;
			$highlight_values = imic_vehicle_title($car[0],$highlighted_specs,$specifications);
			$highlight_values = ($highlight_values=='')?get_the_title($car[0]):$highlight_values;
			echo '
                                    	<li>
                                        	<div class="checkb"><input class="compare-check" type="checkbox" value="0" id="saved-'.$car[0].'"></div>
                                            <div class="imageb"><a href="'.esc_url(get_permalink($car[0])).'">'.get_the_post_thumbnail($car[0]).'</a></div>
                                            <div class="textb">
                                            	<a href="'.esc_url(get_permalink($car[0])).'">'.$highlight_values.'</a>
                                                <span class="price">'.$unique_values.'</span>
                                           	</div>
                                            <div rel="specific-saved-ad" class="delete delete-box-saved"><div class="specific-id" style="display:none;"><span class="saved-id">'.$car[0].'</span></div><a href="#"><i class="icon-delete"></i></a></div>
                                        </li>';
		if($i++>=3) { break; }
		}
		unset($_SESSION['saved_vehicle_id1']);
		unset($_SESSION['saved_vehicle_id2']);
		unset($_SESSION['saved_vehicle_id3']);
		} else {
		$print = '';
		$car = array();
		$vehicle_id = $_POST['vehicle_id'];
		$date = date('U');
		$save_car_data = array($vehicle_id, $date);
		$user_id = get_current_user_id( );
		$user_info_id = get_user_meta($user_id,'imic_user_info_id',true);
		$saved_cars_user = get_post_meta($user_info_id,'imic_user_saved_cars',true);
		if(!empty($saved_cars_user)) {
		foreach($saved_cars_user as $cars) {
			$car[] = $cars;
		} }
		if(!imic_search_array($save_car_data[0],$car)) {
		$print = 1;
		$car[] = $save_car_data; }
		//print_r($car);
		update_post_meta($user_info_id,'imic_user_saved_cars',$car);
		if($print==1) {
			$specifications = get_post_meta($vehicle_id,'feat_data',true);
			if(!empty($specifications)) {
			$unique_values = imic_vehicle_price($vehicle_id,$unique_specs,$specifications);
			$new_highlighted_specs = imic_filter_lang_specs_admin($highlighted_specs, $vehicle_id);	
			$highlighted_specs = $new_highlighted_specs;
			$highlight_values = imic_vehicle_title($vehicle_id,$highlighted_specs,$specifications);
			$highlight_values = ($highlight_values=='')?get_the_title($vehicle_id):$highlight_values;
		echo '
                                    	<li>
                                        	<div class="checkb"><input class="compare-check" type="checkbox" value="0" id="saved-'.$vehicle_id.'"></div>
                                            <div class="imageb"><a href="'.esc_url(get_permalink($vehicle_id)).'">'.get_the_post_thumbnail($vehicle_id).'</a></div>
                                            <div class="textb">
                                            	<a href="'.esc_url(get_permalink($vehicle_id)).'">'.$highlight_values.'</a>
                                                <span class="price">'.$unique_values.'</span>
                                           	</div>
                                            <div rel="specific-saved-ad" class="delete delete-box-saved"><div class="specific-id" style="display:none;"><span class="saved-id">'.$vehicle_id.'</span></div><a href="#"><i class="icon-delete"></i></a></div>
                                        </li>'; } }
	} }
	else {
		if(empty($_SESSION['saved_vehicle_id1'])) {
	$vehicle_id = $_POST['vehicle_id']; }
	elseif(empty($_SESSION['saved_vehicle_id2'])) {
	$vehicle_id = $_POST['vehicle_id']; }
	elseif(empty($_SESSION['saved_vehicle_id3'])) {
	$vehicle_id = $_POST['vehicle_id']; }
		if(empty($_SESSION['saved_vehicle_id1'])) {
	$_SESSION['saved_vehicle_id1'] = $vehicle_id;
	$specifications = get_post_meta($_SESSION['saved_vehicle_id1'],'feat_data',true);
	$unique_value = imic_vehicle_price($_SESSION['saved_vehicle_id1'],$unique_specs,$specifications);
	$new_highlighted_specs = imic_filter_lang_specs_admin($highlighted_specs, $_SESSION['saved_vehicle_id1']);	
	$highlighted_specs = $new_highlighted_specs;
	$highlight_value = imic_vehicle_title($_SESSION['saved_vehicle_id1'],$highlighted_specs,$specifications);
	$highlight_value = ($highlight_value=='')?get_the_title($_SESSION['saved_vehicle_id1']):$highlight_value;
	echo '
                                    	<li>
                                        	<div class="checkb"><input class="compare-check" type="checkbox" value="0" id="saved-'.$_SESSION['saved_vehicle_id1'].'"></div>
                                            <div class="imageb"><a href="'.esc_url(get_permalink($_SESSION['saved_vehicle_id1'])).'">'.get_the_post_thumbnail($_SESSION['saved_vehicle_id1']).'</a></div>
                                            <div class="textb">
                                            	<a href="'.esc_url(get_permalink($_SESSION['saved_vehicle_id1'])).'">'.$highlight_value.'</a>
                                                <span class="price">'.$unique_value.'</span>
                                           	</div>
                                            <div id="one" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                                        </li>';
	 }
	elseif(empty($_SESSION['saved_vehicle_id2'])) {
		$_SESSION['saved_vehicle_id2'] = $vehicle_id;
		$specifications = get_post_meta($_SESSION['saved_vehicle_id2'],'feat_data',true);
	$unique_value = imic_vehicle_price($_SESSION['saved_vehicle_id2'],$unique_specs,$specifications);
	$new_highlighted_specs = imic_filter_lang_specs_admin($highlighted_specs, $_SESSION['saved_vehicle_id2']);	
	$highlighted_specs = $new_highlighted_specs;
	$highlight_value = imic_vehicle_title($_SESSION['saved_vehicle_id2'],$highlighted_specs,$specifications);
	$highlight_value = ($highlight_value=='')?get_the_title($_SESSION['saved_vehicle_id2']):$highlight_value;
		echo '
                                    	<li>
                                        	<div class="checkb"><input class="compare-check" type="checkbox" value="0" id="saved-'.$_SESSION['saved_vehicle_id2'].'"></div>
                                            <div class="imageb"><a href="'.esc_url(get_permalink($_SESSION['saved_vehicle_id2'])).'">'.get_the_post_thumbnail($_SESSION['saved_vehicle_id2']).'</a></div>
                                            <div class="textb">
                                            	<a href="'.esc_url(get_permalink($_SESSION['saved_vehicle_id2'])).'">'.$highlight_value.'</a>
                                                <span class="price">'.$unique_value.'</span>
                                           	</div>
                                            <div id="two" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                                        </li>';
	} elseif(empty($_SESSION['saved_vehicle_id3'])) {
		$_SESSION['saved_vehicle_id3'] = $vehicle_id;
		$specifications = get_post_meta($_SESSION['saved_vehicle_id3'],'feat_data',true);
	$unique_value = imic_vehicle_price($_SESSION['saved_vehicle_id3'],$unique_specs,$specifications);
	$new_highlighted_specs = imic_filter_lang_specs_admin($highlighted_specs, $_SESSION['saved_vehicle_id3']);	
	$highlighted_specs = $new_highlighted_specs;
	$highlight_value = imic_vehicle_title($_SESSION['saved_vehicle_id3'],$highlighted_specs,$specifications);
	$highlight_value = ($highlight_value=='')?get_the_title($_SESSION['saved_vehicle_id3']):$highlight_value;
		echo '
                                    	<li>
                                        	<div class="checkb"><input class="compare-check" type="checkbox" value="0" id="saved-'.$_SESSION['saved_vehicle_id3'].'"></div>
                                            <div class="imageb"><a href="'.esc_url(get_permalink($_SESSION['saved_vehicle_id3'])).'">'.get_the_post_thumbnail($_SESSION['saved_vehicle_id3']).'</a></div>
                                            <div class="textb">
                                            	<a href="'.esc_url(get_permalink($_SESSION['saved_vehicle_id3'])).'">'.$highlight_value.'</a>
                                                <span class="price">'.$unique_value.'</span>
                                           	</div>
                                            <div id="three" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                                        </li>';
		
	}
	else {
		echo '<li>'.__('Please login/register to add more','framework').'</li>';
	}
	//echo "sb"; 
	}
	die();
}
add_action('wp_ajax_nopriv_imic_vehicle_add', 'imic_vehicle_add');
add_action('wp_ajax_imic_vehicle_add', 'imic_vehicle_add');
}
if(!function_exists('imic_save_search')) {
function imic_save_search() {
	//echo "sai";
	$title = $_POST['search_title'];
	$desc = $_POST['search_desc'];
	$url = $_POST['search_url'];
	$created = date('U');
	$alert = 1;
	$exist = $print = '';
	if ( is_user_logged_in() ) { //echo "ss";
	if((isset($_SESSION['search_page1']))||(isset($_SESSION['search_page2']))||(isset($_SESSION['search_page3']))) { 
	$exist1 = $exist2 = $exist3 = $print1 = $print2 = $print3 = '';
			$vehicle_search_1 = (isset($_SESSION['search_page1']))?$_SESSION['search_page1']:array();
			$vehicle_search_2 = (isset($_SESSION['search_page2']))?$_SESSION['search_page2']:array();
			$vehicle_search_3 = (isset($_SESSION['search_page3']))?$_SESSION['search_page3']:array();
		$user_id = get_current_user_id( );
		$user_info_id = get_user_meta($user_id,'imic_user_info_id',true);
		$saved_searches_user = get_post_meta($user_info_id,'imic_user_saved_search',true);
		if(!empty($saved_searches_user)) {
		foreach($saved_searches_user as $searches) {
			if(!empty($vehicle_search_1)) { 
			if(!in_array($vehicle_search_1[2],$searches)) { $exist1 = 1; } else { $exist1 = 2; } }
			if(!empty($vehicle_search_2)) { 
			if(!in_array($vehicle_search_2[2],$searches)) { $exist2 = 2; } else { $exist2 = 2; } }
			if(!empty($vehicle_search_3)) { 
			if(!in_array($vehicle_search_3[2],$searches)) { $exist3 = 2; } else { $exist3 = 2; } }
			$search[] = $searches;
		} }
		if($exist1==1||$exist1=='') {
			$print1 = 1;
		if(!empty($vehicle_search_1)) {
		$search[] = $vehicle_search_1; } }
		if($exist2==1||$exist2=='') {
			$print2 = 1;
		if(!empty($vehicle_search_2)) {
		$search[] = $vehicle_search_2; } }
		if($exist3==1||$exist3=='') {
			$print3 = 1;
		if(!empty($vehicle_search_3)) {
		$search[] = $vehicle_search_3; } }
		//print_r($search);
		update_post_meta($user_info_id,'imic_user_saved_search',$search);
		if($print1==1) {
			if(!empty($vehicle_search_1)) {
		echo '<li>
             <div class="link"><a href="'.$vehicle_search_1[2].'">'.$vehicle_search_1[0].'</a></div>
             <div class="delete"><a href="javascript:void(0);"><i class="icon-delete"></i></a></div>
             </li>'; } }
			 if($print2==1) {
				 if(!empty($vehicle_search_2)) {
		echo '<li>
             <div class="link"><a href="'.$vehicle_search_2[2].'">'.$vehicle_search_2[0].'</a></div>
             <div class="delete"><a href="javascript:void(0);"><i class="icon-delete"></i></a></div>
             </li>'; } }
			 if($print3==1) {
				 if(!empty($vehicle_search_3)) {
		echo '<li>
             <div class="link"><a href="'.$vehicle_search_3[2].'">'.$vehicle_search_3[0].'</a></div>
             <div class="delete"><a href="javascript:void(0);"><i class="icon-delete"></i></a></div>
             </li>'; } }
		unset($_SESSION['search_page1']);
		unset($_SESSION['search_page2']);
		unset($_SESSION['search_page3']);
	} else {
		$search = array();
		$search_vals = array($title, $desc, $url, $created, $alert);
		$user_id = get_current_user_id( );
		$user_info_id = get_user_meta($user_id,'imic_user_info_id',true);
		$saved_searches_user = get_post_meta($user_info_id,'imic_user_saved_search',true);
		if(!empty($saved_searches_user)) {
		foreach($saved_searches_user as $searches) {
			if(!in_array($url,$searches)) { $exist = 1; } else { $exist = 2; }
			$search[] = $searches;
		} }
		if($exist==1||$exist=='') {
			$print = 1;
		$search[] = $search_vals; }
		//print_r($search);
		update_post_meta($user_info_id,'imic_user_saved_search',$search);
		if($print==1) {
		echo '<li>
             <div class="link"><a href="'.$url.'">'.$title.'</a></div>
             <div class="delete"><a href="javascript:void(0);"><i class="icon-delete"></i></a></div>
             </li>'; }
	} }
	else {
	if(empty($_SESSION['search_page1'])) {
	$vehicle_id = array($title,$desc,$url,date('U'),1); }
	elseif(empty($_SESSION['search_page2'])) {
	$vehicle_id = array($title,$desc,$url,date('U'),1); }
	elseif(empty($_SESSION['search_page3'])) {
	$vehicle_id = array($title,$desc,$url,date('U'),1); }
	if(empty($_SESSION['search_page1'])) {
		$_SESSION['search_page1'] = $vehicle_id;
		echo '<li>
                                        	<div class="link"><a href="'.$vehicle_id[2].'">'.$vehicle_id[0].'</a></div>
                                            <div id="four" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                                        </li>'; }
	elseif(empty($_SESSION['search_page2'])) {
		$_SESSION['search_page2'] = $vehicle_id;
		echo '<li>
                                        	<div class="link"><a href="'.$vehicle_id[2].'">'.$vehicle_id[0].'</a></div>
                                            <div id="five" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                                        </li>'; }
	elseif(empty($_SESSION['search_page3'])) {
		$_SESSION['search_page3'] = $vehicle_id;
		echo '<li>
                                        	<div class="link"><a href="'.$vehicle_id[2].'">'.$vehicle_id[0].'</a></div>
                                            <div id="six" class="delete session-save-car"><a href="#"><i class="icon-delete"></i></a></div>
                                        </li>'; }
										else {
		echo '<li>'.__('Please login/register to add more','framework').'</li>';
	}
	}
	
	die();
}
add_action('wp_ajax_nopriv_imic_save_search', 'imic_save_search');
add_action('wp_ajax_imic_save_search', 'imic_save_search');
}
if(!function_exists('imic_sight')) {
function imic_sight($file_handler,$post_id,$set_thu=false) {
	// check to make sure its a successful upload
	if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();
	require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	require_once(ABSPATH . "wp-admin" . '/includes/media.php');
	$attach_id = media_handle_upload( $file_handler, $post_id );
	return $attach_id;
}
}
if(!function_exists('imi_remove_cars')) {
function imi_remove_cars(){
	$saved = (isset($_POST['saved']))?$_POST['saved']:'';
	$new_val = array();
	$user_id = get_current_user_id( );
	$user_info_id = get_user_meta($user_id,'imic_user_info_id',true);
	$saved_cars_user = get_post_meta($user_info_id,'imic_user_saved_cars',true);
	foreach($saved_cars_user as $save) {
		if(!in_array($save[0],$saved)) {
		$new_val[]=$save; }
	}
	update_post_meta($user_info_id,'imic_user_saved_cars',$new_val);
	print_r($saved);
	die();
}
add_action('wp_ajax_nopriv_imi_remove_cars', 'imi_remove_cars');
add_action('wp_ajax_imi_remove_cars', 'imi_remove_cars');
}
if(!function_exists('imi_remove_search')) {
function imi_remove_search(){
	$searches = (isset($_POST['search_items']))?$_POST['search_items']:'';
	$new_val = array();
	$user_id = get_current_user_id( );
	$user_info_id = get_user_meta($user_id,'imic_user_info_id',true);
	$user_searches = get_post_meta($user_info_id,'imic_user_saved_search',true);
	foreach($user_searches as $search) {
		$res = preg_replace("/[^a-zA-Z]/", "", $search[0]);
		if(!in_array($res,$searches)) {
		$new_val[]=$search; }
	}
	update_post_meta($user_info_id,'imic_user_saved_search',$new_val);
	//print_r($saved);
	echo "success";
	die();
}
add_action('wp_ajax_nopriv_imi_remove_search', 'imi_remove_search');
add_action('wp_ajax_imi_remove_search', 'imi_remove_search');
}
if(!function_exists('imi_remove_ads')) {
function imi_remove_ads(){
	$ads = (isset($_POST['ads']))?$_POST['ads']:'';
	foreach($ads as $ad) {
	wp_delete_post($ad,true);
	}
	//print_r($saved);
	echo "success";
	die();
}
add_action('wp_ajax_nopriv_imi_remove_ads', 'imi_remove_ads');
add_action('wp_ajax_imi_remove_ads', 'imi_remove_ads');
}
if(!function_exists('imic_sortable_specification')) {
function imic_sortable_specification(){
    global $imic_options;
    $spec_value = $_POST['sorting'];
    $spec_id = $_POST['spec_id'];
    $field_id = $spec_id*111;
    $spec_multi_id = explode('-',$spec_id);
    $select_new_class = ($spec_multi_id[0]=="field")?"field-":"child-";
    $spec_id = $spec_multi_id[1]-2648;
    $numeric_specs_type = (isset($imic_options['integer_specs_type']))?$imic_options['integer_specs_type']:0;
    $spec_name = ($numeric_specs_type==0)?$spec_id*111:'child_'.imic_the_slug($spec_id);
    $specs = get_post_meta($spec_id,'specifications_value',true);
    $key = find_car_with_position($specs, $spec_value);
    $vals = $specs[$key]['imic_plugin_specification_values_child'];
    if(!empty($vals)) {
    $new_val = explode(',',$vals);
    echo '<label>Select '.get_post_meta($spec_id,'imic_plugin_sub_field_label',true).'</label>';
    echo '<select id="'.$select_new_class.(($spec_id*111)+2648).'" class="form-control selectpicker custom-cars-fields" name="'.($spec_name).'">'; 
	echo '<option value="" disabled selected>'.esc_attr__('All', 'framework').'</option>';
	foreach($new_val as $val) {
		echo '<option value="'.$val.'">'.$val.'</option>';
	}
	echo '</select>'; }
	die();
}
add_action('wp_ajax_nopriv_imic_sortable_specification', 'imic_sortable_specification');
add_action('wp_ajax_imic_sortable_specification', 'imic_sortable_specification');
}
if(!function_exists('imic_sortable_specification_filter')) {
function imic_sortable_specification_filter(){
	$spec_value = $_POST['sorting'];
	$spec_id = $_POST['spec_id'];
	$field_id = $spec_id*111;
	$spec_multi_id = explode('-',$spec_id);
	$spec_id = $spec_multi_id[1]-2648;
	$specs = get_post_meta($spec_id,'specifications_value',true);
	$key = find_car_with_position($specs, $spec_value);
	$vals = $specs[$key]['imic_plugin_specification_values_child'];
	if(!empty($vals)) {
	$new_val = explode(',',$vals);
	$child_label = get_post_meta($spec_id,'imic_plugin_sub_field_label',true);
	$integer = get_post_meta($spec_id,'imic_plugin_spec_char_type',true);
	$spec_slug = imic_the_slug($spec_id);
	if($integer==0) 
	{
		$slug = "feat_data";
		$child_field = 'variation-'.$spec_id;
	}
	elseif($integer==1) 
	{
		$slug = "int_".$spec_slug;
		$child_field = '';
	}
	else 
	{
		$slug = "child_".$spec_slug;
		$child_field = $slug;
	}
	echo '<div class="accordion-group panel">
                                    <div class="accordion-heading togglize"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#" href="#collapseTwo-sub'.esc_attr($spec_id).'">'.$child_label.'<i class="fa fa-angle-down"></i> </a> </div>
                                    <div id="collapseTwo-sub'.esc_attr($spec_id).'" class="accordion-body collapse">
                                        <div class="accordion-inner">
                                            <ul id="'.$child_field.'" class="filter-options-list new-filter-list list-group search-fields">';
											foreach($new_val as $val) {
												$total_cars = imic_count_cars_by_specification($slug, $val);
											echo '<li class="list-group-item"><span class="badge">'.esc_attr($total_cars).'</span><a href="#">'.esc_attr($val).'</a></li>';
											}
                                            echo '</ul>
                                        </div>
                                    </div>
                                </div>'; }
	die();
}
add_action('wp_ajax_nopriv_imic_sortable_specification_filter', 'imic_sortable_specification_filter');
add_action('wp_ajax_imic_sortable_specification_filter', 'imic_sortable_specification_filter');
}
if(!function_exists('imic_queryToArray')) {
function imic_queryToArray($qry)
        {
                $result = array();
                //string must contain at least one = and cannot be in first position
                if(strpos($qry,'=')) {
 
                 if(strpos($qry,'?')!==false) {
                   $q = parse_url($qry);
                   $qry = $q['query'];
                  }
                }else {
                        return false;
                }
 
                foreach (explode('&', $qry) as $couple) {
					if(strpos($couple, "=")) {
                        list ($key, $val) = explode('=', $couple);
                        $result[$key] = $val; }
                }
 
                return empty($result) ? false : $result;
        }
}
/*AJAX LOGIN FORM FUNCTION
  ================================================================*/
if(!function_exists('ajax_login_init')) {
function ajax_login_init(){
    wp_register_script('ajax-login-script', get_template_directory_uri() . '/js/ajax-login-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-login-script');
    wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'loadingmessage' => __('Sending user info, please wait...','framework')
    ));
    add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
}
if (!is_user_logged_in()) {
    add_action('init', 'ajax_login_init');
} }
if(!function_exists('ajax_login')) {
function ajax_login(){
    check_ajax_referer( 'ajax-login-nonce', 'security' );
    $info = array();
		if(filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)) {
      $user_withemail = get_user_by( 'email', $_POST['username'] );
			if(!is_wp_error($user_withemail))
			{
				$info['user_login'] = $user_withemail->user_login;
			}
			else
			{
				$info['user_login'] = 'abcd1234!@#$abcd';
			}
    }
		else
		{
			$info['user_login'] = $_POST['username'];
		}
    $info['user_password'] = $_POST['password'];
	if($_POST['rememberme']=='true') {
    $info['remember'] = true; }
	else{
	$info['remember'] = false; }
    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.','framework')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...','framework')));
    }
    die();
} }
/*AJAX RESET PASSWORD FUNCTION
  ================================================================*/
if(!function_exists('imic_reset_password_init')) {
function imic_reset_password_init(){
	wp_localize_script( 'ajax-login-script', 'reset_password', array( 
        'fillemail' => __('Please enter registered email', 'framework'),
				'invalidemail' => __('Email is not registered with us', 'framework')
    ));
    add_action( 'wp_ajax_nopriv_imic_reset_password', 'imic_reset_password' );
}
if (!is_user_logged_in()) {
    add_action('init', 'imic_reset_password_init');
} }
if(!function_exists('imic_reset_password')) {
function imic_reset_password(){
    $user_email = (isset($_POST['reset_email']))?$_POST['reset_email']:'';
		$user_verification_code = (isset($_POST['verification_code']))?$_POST['verification_code']:'';
		$reset_pass1 = (isset($_POST['reset_pass1']))?$_POST['reset_pass1']:'';
		$reset_pass2 = (isset($_POST['reset_pass2']))?$_POST['reset_pass2']:'';
		if($user_verification_code=='')
		{
			if($user_email!='')
			{
				if( email_exists( $user_email ))
				{
					$user = get_user_by( 'email', $user_email );
					$user_id = $user->ID;
					update_user_meta( $user_id, 'imic_reset_password_key', $user_id+date('U'));
					$user_verification_get = get_user_meta($user_id,'imic_reset_password_key',true);
					$to = $user_email;
					$subject = esc_attr__('Verification Code to reset password', 'framework');
					$body = esc_attr__('Please use this verification code to reset password', 'framework');
					$body .= esc_attr__('Verification Code', 'framework').' '.$user_verification_get;
					wp_mail( $to, $subject, $body );
					echo json_encode(array('valid'=>true, 'message'=>__('Please insert verification code, which you recieved in above email.','framework')));
				}
				else
				{
					echo json_encode(array('valid'=>false, 'message'=>__('Email is not registered with us.','framework')));
				}
			}
			else
			{
				//echo json_encode(array('valid'=>false, 'message'=>__('Please enter registered email address.','framework')));
			}
		}
		elseif($user_verification_code!=''&&$reset_pass1=='')
		{
			if($user_email!='')
			{
				if( email_exists( $user_email ))
				{
					$user = get_user_by( 'email', $user_email );
					$user_id = $user->ID;
					$user_verification_get = get_user_meta($user_id,'imic_reset_password_key',true);
					if($user_verification_code==$user_verification_get)
					{
						echo json_encode(array('authenticate'=>true, 'message'=>__('Generate New Password.','framework')));
					}
					else
					{
						echo json_encode(array('authenticate'=>false, 'message'=>__('Verification code does not match.','framework')));
					}
				}
				else
				{
					echo json_encode(array('valid'=>false, 'message'=>__('Email is not registered with us.','framework')));
				}
			}
		}
		else
		{
			$user_id_pass = '';
			if( email_exists( $user_email ))
			{
				$user = get_user_by( 'email', $user_email );
				$user_id_pass = $user->ID;
			}
			if(($reset_pass1!=''&&$reset_pass2!='')&&($reset_pass1==$reset_pass2)&&($user_id_pass!=''))
			{
				wp_set_password( $reset_pass2, $user_id_pass );
				echo json_encode(array('passauth'=>true, 'message'=>__('New Password Created, please login.','framework')));
			}
			else
			{
				echo json_encode(array('passauth'=>false, 'message'=>__('Password doesn not match.','framework')));
			}
		}
    die();
} }
/* GET TEMPLATE URL
   ================================================*/
if(!function_exists('imic_get_template_url')) {
function imic_get_template_url($TEMPLATE_NAME){
  $url;
 $pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => $TEMPLATE_NAME,
	'sort_order' => 'desc',
));
if(!empty($pages)) {
     $url = get_permalink($pages[0]->ID);
 return $url; }
}
}
/* GET TEMPLATE ID
   ================================================*/
if(!function_exists('imic_get_template_id')) {
function imic_get_template_id($TEMPLATE_NAME){
  $id = '';
$pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => $TEMPLATE_NAME,
	'sort_order' => 'desc',
));
if(!empty($pages)) {
     $id = $pages[0]->ID;
 return $id; }
}
}
//Remove Property Image using ajax
if(!function_exists('imic_remove_property_image')) {
	function imic_remove_property_image() {
		$thumb = $_POST['thumb_id'];
		$property = $_POST['property_id'];
		delete_post_meta($property,'imic_plugin_vehicle_images',$thumb);
		die();
	}
add_action('wp_ajax_nopriv_imic_remove_property_image', 'imic_remove_property_image');
add_action('wp_ajax_imic_remove_property_image', 'imic_remove_property_image');
}
if(!function_exists('update_property_featured_image')) {
function update_property_featured_image() {
	$property_id = $_POST['property_id'];
	$thumb_id = $_POST['thumb_id'];
	update_post_meta($property_id,'_thumbnail_id',$thumb_id);
	echo "success";
	die();
}
add_action('wp_ajax_nopriv_update_property_featured_image', 'update_property_featured_image');
add_action('wp_ajax_update_property_featured_image', 'update_property_featured_image');
}

if(!function_exists('imic_add_user_info')) {
function imic_add_user_info($user_id){
	$user_info = get_userdata($user_id);
  $my_post = array(
  'post_title'    => $user_info->user_login,
  'post_type'	=> 'user',
  'post_status'	=> 'publish',
  //'tax_input'	=> array('user-category'=>array('subsscriber'))
  //'post_category' => array(8,39)
);
if ( isset( $_POST['first_name'] ) ) {
// Insert the post into the database
$post_id = wp_insert_post( $my_post );
update_user_meta($user_id,'imic_user_info_id',$post_id);
wp_set_object_terms($post_id,$user_info->roles,'user-category');
update_post_meta($post_id,'imic_user_reg_id',$user_id); }
}
add_action('user_register','imic_add_user_info');
}
function imic_convert_integer($value)
{
	$strings = array('Zero', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine');
	$print_str = $strings[$value];
	return $print_str;
}
function imic_convert_string($value)
{ 
	switch($value)
	{
		case 'Zero':
		$print_int = 0;
		break;
		case 'One':
		$print_int = 1;
		break;
		case 'Two':
		$print_int = 2;
		break;
		case 'Three':
		$print_int = 3;
		break;
		case 'Four':
		$print_int = 4;
		break;
		case 'Five':
		$print_int = 5;
		break;
		case 'Six':
		$print_int = 6;
		break;
		case 'Seven':
		$print_int = 7;
		break;
		case 'Eight':
		$print_int = 8;
		break;
		case 'Nine':
		$print_int = 9;
		break;
	}
	return $print_int;
}
function imic_create_captcha()
{
	$operators = array('+', '-', '*');
	$operator_rand = rand(0, 2);
	$first_val = rand ( 0 , 20 );
	$second_val = rand ( 0 , 9 );
	if($operator_rand==1&&$first_val<=$second_val)
	{
		$first_val = $second_val+2;
	}
	elseif($operator_rand==2&&$first_val>=9)
	{
		$first_val = 2;
	}
	$second_value_string = imic_convert_integer($second_val);
	return $first_val. ' '.$operators[$operator_rand].' '. $second_value_string;
}
/**
 * Handles "activate" action for login page
 *
 */
if(!function_exists('imic_user_activation')) {
function imic_user_activation() {
    // Attempt to activate the user

    $errors = activate_new_user( $_GET['key'], $_GET['login'] );

    $redirect_to = 'wp-login.php';

    // Make sure there are no errors
    if ( ! is_wp_error( $errors ) )
        $redirect_to = add_query_arg( 'activation', 'complete',   $redirect_to );
    else
        $redirect_to = add_query_arg( 'activation', 'invalidkey', $redirect_to );

    wp_redirect( $redirect_to );
    exit;
}
add_action('user_activation','imic_user_activation');
}

/**
 * Handles activating a new user by user email confirmation
 *
 * @param string $key Hash to validate sending confirmation email
 * @param string $login User's username for logging in
 * @return bool|WP_Error True if successful, WP_Error otherwise
 */
function activate_new_user( $key, $login ) {
    global $wpdb;

    $key = preg_replace( '/[^a-z0-9]/i', '', $key );

    if ( empty( $key ) || ! is_string( $key ) )
        return new WP_Error( 'invalid_key', __( 'Invalid key 1', 'framework' ) );

    if ( empty( $login ) || ! is_string( $login ) )
        return new WP_Error( 'invalid_key', __( 'Invalid key 2', 'framework' ) );

    // Validate activation key
    $user = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpdb->users WHERE user_activation_key = %s AND user_login = %s", $key, $login ) );
    if ( empty( $user ) )
        return new WP_Error( 'invalid_key', __( 'Invalid key 3', 'framework' ) );

    do_action( 'imic_user_activation_post', $user->user_login, $user->user_email );

    // Allow plugins to short-circuit process and send errors
    $errors = new WP_Error();
    $errors = apply_filters( 'imic_user_activation_errors', $errors, $user->user_login, $user->user_email );

    // Return errors if there are any
    if ( $errors->get_error_code() )
        return $errors;

    // Clear the activation key
    $wpdb->update( $wpdb->users, array( 'user_activation_key' => '' ), array( 'user_login' => $login ) );

    // Set user role
    $user_object = new WP_User( $user->ID );
    $user_object->set_role( get_option( 'default_role' ) );

    do_action( 'new_user_activated', $user->ID );

    return true;
}

/**
 * Calls the "register_new_user" hook
 *
 * @param int $user_id The user's ID
 */
if(!function_exists('imic_new_user_activated')) {
function imic_new_user_activated( $user_id ) {
    //do_action( 'register_new_user', $user_id );

    $user = new WP_User( $user_id );
    $login = stripslashes( $user->user_login );
    $email = stripslashes( $user->user_email );

    $admin_mail_to = get_option('admin_email');
    $mail_subject = "Your broker account has been approved";
    $mail_content = __("Congratulations! Your broker account has been approved and you can now start uploading your listings.","framework"). "\r\n\r\n";
    $mail_content .= __("Best Regards,","framework"). "\r\n\r\n";
    $mail_content .= __("Invictus Team","framework"). "\r\n";
    $mail_content .= __("By Invitation Only Publishing, Inc.","framework"). "\r\n";
    $mail_content .= __("Harbour Towne Marina","framework"). "\r\n";
    $mail_content .= __("850 NE 3rd St, Suite 209","framework"). "\r\n";
    $mail_content .= __("Dania Beach, FL 33004","framework"). "\r\n";
    $mail_content .= __("Tel: 954-922-7700","framework"). "\r\n";
    $mail_content .= __("Fax: 954-337-2447","framework"). "\r\n";
    $mail_content .= __("celine@invictusmag.com","framework"). "\r\n";
    $mail_content .= __("www.invictusmag.com","framework"). "\r\n";
    $msg = wordwrap( $mail_content, 70 );
    // $dealer_headers = "From: $admin_mail_to" . PHP_EOL;
    // $dealer_headers .= "Reply-To: $admin_mail_to" . PHP_EOL;
    // $dealer_headers .= "MIME-Version: 1.0" . PHP_EOL;
    // $dealer_headers .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
    wp_mail($email, $mail_subject, $msg);

}
add_action('new_user_activated','imic_new_user_activated');
}

/**
 * Notifies a pending user to activate their account
 *
 * @since 6.0
 * @access public
 *
 * @param int $user_id The user's ID
 */
 function new_user_activation_notification( $user_id ) {
    global $wpdb, $current_site;

    $user = new WP_User( $user_id );

    $user_login = stripslashes( $user->user_login );
    $user_email = stripslashes( $user->user_email );

    //User Info
    $user_firstname = stripslashes( $user->user_firstname );
    $user_lastname = stripslashes( $user->user_lastname );
    $fullname = $user_firstname. " " . $user_lastname;
    $user_info_id = get_user_meta($user_id,'imic_user_info_id',true);
    $company = get_post_meta($user_info_id,'imic_user_company',true);
    $user_role = wp_get_post_terms($user_info_id, 'user-role'); 
    $role = $user_role[0];
    $user_role = $role->slug;

    // Generate an activation key
    $key = wp_generate_password( 20, false );

    // Set the activation key for the user
    $wpdb->update( $wpdb->users, array( 'user_activation_key' => $key ), array( 'user_login' => $user->user_login ) );

    if ( is_multisite() ) {
        $blogname = $current_site->site_name;
    } else {
        // The blogname option is escaped with esc_html on the way into the database in sanitize_option
        // we want to reverse this for the plain text arena of emails.
        $blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
    }

    $activation_url = add_query_arg( array( 'action' => 'activate', 'key' => $key, 'login' => rawurlencode( $user_login ) ), wp_login_url() );

    $title    = sprintf( __( '%s New Account Activation Required', 'framework' ), $blogname );
    $message  = sprintf( __( 'New user account at %s requires activation! ', 'framework' ), $blogname ) . "\r\n\r\n";
    $message .= __( 'To complete the activation of the account please click the following link: ', 'framework' ) . "\r\n\r\n";
    $message .=  $activation_url . "\r\n\r\n";
    $message .= __( "Broker Account Details","framework" ) . "\r\n";
    $message .= __( "Full Name: ","framework" ) . $fullname . "\r\n";
    $message .= __( "Company Name: ","framework" ) . $company . "\r\n";
    $message .= __( "Email: ","framework" ) . $user_email. "\r\n";
    $message .= __( "Role: ","framework" ) . $user_role. "\r\n";

    $title   = apply_filters( 'user_activation_notification_title',   $title,   $user_id );
    $message = apply_filters( 'user_activation_notification_message', $message, $activation_url, $user_id );

    //$address = 'info@invictusmag.com';
    $admin_mail_to = get_option('admin_email');
    $msg = wordwrap( $message, 100 );

    $header = "From: $address" . PHP_EOL;
    $header .= "Reply-To: $address" . PHP_EOL;
    $header .= "MIME-Version: 1.0" . PHP_EOL;
    $header .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";

    wp_mail( $admin_mail_to, $title, $msg);
}
/* Agent Register Funtion
  ================================================== */
if(!function_exists('imic_agent_register')) {
function imic_agent_register() {
	if(!$_POST) exit;
	// Email address verification, do not edit.
	function isEmail($email) {
		return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
	}
	
	
	if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");
	
	if ($_POST['roles'] == 'Broker' || $_POST['roles'] == 'Shipyard'){
        $firstname     = $_POST['firstname'];
        $lastname     = $_POST['lastname'];
        $company     = $_POST['company'];
    }
    $email    = $_POST['email'];
    $username     = $_POST['username'];
    $pwd1  = $_POST['pwd1'];
    $pwd2 = $_POST['pwd2'];

    if ($_POST['roles'] == 'Broker' || $_POST['roles'] == 'Shipyard'){
        if(trim($firstname) == '') {
            echo '<div class="alert alert-error">'.__('You must enter your first name.','framework').'</div>';
            exit();
        } else if(trim($lastname) == '') {
            echo '<div class="alert alert-error">'.__('You must enter your last name.','framework').'</div>';
            exit();
        } else if(trim($company) == '') {
            echo '<div class="alert alert-error">'.__('You must enter your company name.','framework').'</div>';
            exit();
        }
    }
    
	$captcha_question = $_POST['captcha_q'];
	$captcha_answer = $_POST['captcha_a'];
	$captcha_split = explode(' ', $captcha_question);
	if($captcha_split[1]=='+')
	{ 
		$second_val = imic_convert_string($captcha_split[2]);
		$exact_val = $captcha_split[0]+$second_val;
	}
	elseif($captcha_split[1]=='-')
	{ 
		$second_val = imic_convert_string($captcha_split[2]);
		$exact_val = $captcha_split[0]-$second_val;
	}
	else
	{ 
		$second_val = imic_convert_string($captcha_split[2]);
		$exact_val = $captcha_split[0]*$second_val;
	} 
	
	if(trim($username) == '') {
		echo '<div class="alert alert-error">'.__('You must enter your username.','framework').'</div>';
		exit();
	} else if(trim($email) == '') {
		echo '<div class="alert alert-error">'.__('You must enter email address.','framework').'</div>';
		exit();
	} else if(!isEmail($email)) {
		echo '<div class="alert alert-error">'.__('You must enter a valid email address.','framework').'</div>';
		exit();
	}else if(trim($pwd1) == '') {
		echo '<div class="alert alert-error">'.__('You must enter password.','framework').'</div>';
		exit();
	}else if(trim($pwd2) == '') {
		echo '<div class="alert alert-error">'.__('You must enter repeat password.','framework').'</div>';
		exit();
	}else if(trim($pwd1) != trim($pwd2)) {
		echo '<div class="alert alert-error">'.__('You must enter a same password.','framework').'</div>';
		exit();
	}
	elseif($exact_val!=$captcha_answer)
	{
		echo '<div class="alert alert-error">'.__('Captcha do not match.','framework').'</div>';
		exit();
	}
	
	
	$err = '';
	$success = '';
	
	global $wpdb, $PasswordHash, $current_user, $user_ID, $imic_options;
	
	if (isset($_POST['task']) && $_POST['task'] == 'register') {
		$username = esc_sql(trim($_POST['username']));
		$pwd1 = esc_sql(trim($_POST['pwd1']));
		$pwd2 = esc_sql(trim($_POST['pwd2']));
		$email = esc_sql(trim($_POST['email']));
		$role = (isset($_POST['roles']))?esc_sql(trim($_POST['roles'])):'';
		
	   //Email properties
	   	$dealer_msg = $imic_options['agent_register'];
		$admin_mail_to = get_option('admin_email');
		$mail_subject = $username ." registered successfully.";
		$admin_mail_content = "<p>".__("New user registered with following details.","framework")."</p>";
        $admin_mail_content .= __("Full Name: ","framework").$fullname. "\r\n";
        if ($_POST['roles'] == 'Broker' || $_POST['roles'] == 'Shipyard'){
            $admin_mail_content .= __("Company Name: ","framework").$company. "\r\n";
        }
        $admin_mail_content .= __("Email: ","framework").$email. "\r\n";
        $admin_mail_content .= __("Role: ","framework").$role. "\r\n";
		$admin_mail_content .= "<p>".__("Email: ","framework").$email."</p>";
        $admin_mail_content .= __("Role: ","framework").$role. "\r\n";
		$admin_msg = wordwrap( $admin_mail_content, 70 );
		$admin_headers = "From: $email" . PHP_EOL;
		$admin_headers .= "Reply-To: $email" . PHP_EOL;
		$admin_headers .= "MIME-Version: 1.0" . PHP_EOL;
		$admin_headers .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
		$dealer_headers = "From: $admin_mail_to" . PHP_EOL;
		$dealer_headers .= "Reply-To: $admin_mail_to" . PHP_EOL;
		$dealer_headers .= "MIME-Version: 1.0" . PHP_EOL;
		$dealer_headers .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
		if ($email == "" || $pwd1 == "" || $pwd2 == "" || $username == "") {
			$err = 'Please don\'t leave the required fields.';
		} else if ($pwd1 <> $pwd2) {
			$err = 'Password do not match.';
		} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$err = 'Invalid email address.';
		} else if (email_exists($email)) {
			$err = 'Email already exist.';
		} else {
	
			$user_id = wp_insert_user(
							array(
								'user_pass' => apply_filters('pre_user_user_pass', $pwd1), 
								'user_login' => apply_filters('pre_user_user_login', $username), 
								'user_email' => apply_filters('pre_user_user_email', $email), 
								'role' => 'pending_user')
							);
			$my_post = array(
  'post_title'    => $username,
  'post_type'	=> 'user',
  'post_status'	=> 'publish',
  //'tax_input'	=> array('user-category'=>array('subsscriber'))
  //'post_category' => array(8,39)
);
// Insert the post into the database
$post_id = wp_insert_post( $my_post );
update_user_meta($user_id,'imic_user_info_id',$post_id);
wp_set_object_terms($post_id,$role,'user-role');
update_post_meta($post_id,'imic_user_reg_id',$user_id);
wp_update_user( array( 'ID' => $user_id, 'first_name' => $firstname) );
wp_update_user( array( 'ID' => $user_id, 'last_name' => $lastname) );
update_post_meta($post_id,'imic_user_company',$company);
							
			if (is_wp_error($user_id)) {
                $err = 'Error on user creation.';
            } else {
                do_action('user_register', $user_id);
                $success = 'Thank you for your registration, you will be receiving an email once your account has been approved.';
                //$success = 'Thank you for your registration, you will be redirected in a moment.';
                                // $info_register = array();
                                // $info_register['user_login'] = $username;
                                // $info_register['user_password'] = $pwd1;
                                new_user_activation_notification($user_id); 
                                //wp_signon( $info_register, false );
                               }
		}
	}
	
	if (!empty($err)) :
		echo '<div class="alert alert-error">' . $err . '</div>';
	endif;
	
	if (!empty($success)) :
        wp_mail($admin_mail_to, $mail_subject, $admin_msg); 
        wp_mail($email, $mail_subject, $dealer_msg);
		echo '<div class="alert alert-success">' . $success . '</div>';
	endif;
    die();
}
add_action('wp_ajax_nopriv_imic_agent_register', 'imic_agent_register');
add_action('wp_ajax_imic_agent_register', 'imic_agent_register');
}
if(!function_exists('imic_search_dealers')) {
function imic_search_dealers() {
	//echo "saibaba";
	global $imic_options;
	$distance_measure = $imic_options['distance_calculate'];
	$users = (isset($_POST['values']))?$_POST['values']:array();
	ksort($users);
	$user_ids = array();
	if(!empty($users)) {
	foreach($users as $key=>$value) {
		$user_ids[] = $value;
	} }
	$args_user = array('post_type'=>'user','post__in'=>$user_ids,'orderby'=>'post__in','posts_per_page'=>-1);
	$user_listing = new WP_Query( $args_user );
									if ( $user_listing->have_posts() ) :
	global $wp_query;
	echo '<div class="main" role="main">
    	<div id="content" class="content full padding-b0">
        	<div class="container"><p>We have found '.$user_listing->found_posts.' dealers matching zipcode nearest to longest</p>
                <div class="dealers-search-result">
                    <div class="row">';
	while ( $user_listing->have_posts() ) :	
											$user_listing->the_post();
										$company = get_post_meta(get_the_ID(),'imic_user_company',true);
										$tagline = get_post_meta(get_the_ID(),'imic_user_company_tagline',true);
										$user_id = get_post_meta(get_the_ID(),'imic_user_reg_id',true);
										$user_avatar = get_post_meta(get_the_ID(),'imic_user_logo',true);
										$image_avatar = wp_get_attachment_image_src( $user_avatar, '', '' );
										$user_info = get_userdata($user_id);
	echo '
                        <div class="col-md-4 col-sm-4 dealer-block">
                            <div class="dealer-block-inner" style="background-image:url('.$image_avatar[0].');">
                            	<div class="dealer-block-cont">
                                    <div class="dealer-block-info">
                                        <span class="label label-default">'.floor(array_search (get_the_ID(), $users)).' '.$distance_measure.__(' away','framework').'</span>
                                        <span class="dealer-avatar">'.get_the_post_thumbnail().'</span>
                                        <h5><a href="'.get_author_posts_url($user_id).'">'.$company.'</a></h5>
                                        <span class="meta-data">'.$tagline.'</span>
                                    </div>
                                    <div class="dealer-block-text">
                                        '.imic_excerpt(10).'
                                        <div class="dealer-block-add">';
										if(!empty($user_info)) {
                                            echo '<span>'.__('Member since','framework').' <strong>'.date("M, Y", strtotime($user_info->user_registered)).'</strong></span>'; }
                                            echo '<span>'.__('Total listings','framework').' <strong>'.imic_count_user_posts_by_type($user_id,'yachts').'</strong></span>
                                        </div>
                                    </div>
                                    <div class="text-align-center"><a href="'.get_author_posts_url($user_id).'" class="btn btn-default">'.__('View profile','framework').'</a></div>
                               	</div>
                            </div>
                        </div>';
	endwhile;
	echo '</div></div></div></div></div>';
	endif; wp_reset_postdata();
	//print_r($user_ids);
	die();
}
add_action('wp_ajax_nopriv_imic_search_dealers', 'imic_search_dealers');
add_action('wp_ajax_imic_search_dealers', 'imic_search_dealers');
}
if(!function_exists('imic_count_cars_by_specification')) {
function imic_count_cars_by_specification($specification,$value, $slug = '') {
	$count = '';
	if (strpos($specification,'int') !== false) {
	$args_cars = array('post_type'=>'yachts', 'listing-category'=>$slug, 'posts_per_page'=>-1,'meta_query'=>array(array('key'=>$specification,'value'=>$value,'compare'=>'<=','type'=>'numeric'),array('key'=>'imic_plugin_ad_payment_status','value'=>1,'compare'=>'='))); }
	elseif ((strpos($specification,'char') !== false)||(strpos($specification,'child') !== false)) {
	$args_cars = array('post_type'=>'yachts', 'listing-category'=>$slug, 'posts_per_page'=>-1,'meta_query'=>array(array('key'=>$specification,'value'=>$value,'compare'=>'='),array('key'=>'imic_plugin_ad_payment_status','value'=>1,'compare'=>'='))); }
	else {
	$args_cars = array('post_type'=>'yachts', 'listing-category'=>$slug, 'posts_per_page'=>-1,'meta_query'=>array(array('key'=>$specification,'value'=>serialize(strval($value)),'compare'=>'LIKE'),array('key'=>'imic_plugin_ad_payment_status','value'=>1,'compare'=>'='))); }
	$cars_listing = new WP_Query( $args_cars );
	if ( $cars_listing->have_posts() ) :
	$count = $cars_listing->found_posts;
	endif; wp_reset_postdata();
	return $count;
}
}
if(!function_exists('imic_remove_session_saved')) {
function imic_remove_session_saved(){
	$session = $_POST['sessions'];
	if($session=="one") {
	unset($_SESSION['saved_vehicle_id1']); }
	elseif($session=="two") {
	unset($_SESSION['saved_vehicle_id2']); }
	elseif($session=="three") {
	unset($_SESSION['saved_vehicle_id3']); }	
	elseif($session=="four") {
	unset($_SESSION['search_page1']); }
	elseif($session=="five") {
	unset($_SESSION['search_page2']); }
	elseif($session=="six") {
	unset($_SESSION['search_page3']); }
	elseif($session=="seven") {
	unset($_SESSION['viewed_vehicle_id1']); }
	elseif($session=="eight") {
	unset($_SESSION['viewed_vehicle_id2']); }
	elseif($session=="nine") {
	unset($_SESSION['viewed_vehicle_id3']); }		
	die();
}
add_action('wp_ajax_nopriv_imic_remove_session_saved', 'imic_remove_session_saved');
add_action('wp_ajax_imic_remove_session_saved', 'imic_remove_session_saved');
}
if(!function_exists('imic_calcPay')) {
function imic_calcPay($MORTGAGE, $AMORTYEARS, $AMORTMONTHS, $INRATE, $COMPOUND, $FREQ, $DOWN){
$MORTGAGE = $MORTGAGE - $DOWN;
$compound = $COMPOUND/12;
$monTime = ($AMORTYEARS * 12) + (1 * $AMORTMONTHS);
$RATE = ($INRATE*1.0)/100;
$yrRate = $RATE/$COMPOUND;
$rdefine = pow((1.0 + $yrRate),$compound)-1.0;
$PAYMENT = ($MORTGAGE*$rdefine * (pow((1.0 + $rdefine),$monTime))) / ((pow((1.0 + $rdefine),$monTime)) - 1.0);
if($FREQ==12){
    return $PAYMENT;}
if($FREQ==26){
    return $PAYMENT/2.0;}
if($FREQ==52){
    return $PAYMENT/4.0;}
if($FREQ==24){
    $compound2 = $COMPOUND/$FREQ;
    $monTime2 = ($AMORTYEARS * $FREQ) + ($AMORTMONTHS * 2);
    $rdefine2 = pow((1.0 + $yrRate),$compound2)-1.0;
    $PAYMENT2 = ($MORTGAGE*$rdefine2 * (pow((1.0 + $rdefine2),$monTime2)))/  ((pow((1.0 + $rdefine2),$monTime2)) - 1.0);
    return $PAYMENT2;
}
}
}
if(!function_exists('imic_mortgage_calculator')) {
function imic_mortgage_calculator() {
	//echo "sai";
	$currency = $_POST['currency'];
	$principal = $_POST['loan_amount']; //Mortgage Amount 
$interest_rate = $_POST['interest']; //Interest Rate %
$down = $_POST['down_payment']; //10% down payment
$years = 0;
$months = $_POST['months'];
$compound = 2; //compound is always set to 2
$frequency = 12; //Number of months (Monthly (12), Semi-Monthly (24), Bi-Weekly(26) and Weekly(52) 
echo '<span class="meta-data">'.__('This is the payment you need to make per month','framework').'</span>';
echo '<span class="loan-amount">'.$currency.floor(imic_calcPay($principal, $years, $months, $interest_rate, $compound, $frequency, $down)).'<small>/'.__('month', 'framework').'</small><span>';
die();
}
add_action('wp_ajax_nopriv_imic_mortgage_calculator', 'imic_mortgage_calculator');
add_action('wp_ajax_imic_mortgage_calculator', 'imic_mortgage_calculator');
}
if(!function_exists('imic_is_decimal')) {
function imic_is_decimal( $val )
{
    return is_numeric( $val ) && floor( $val ) != $val;
}
}
if(!function_exists('imic_price_guide')) {
function imic_price_guide() {
	//echo "sai";
	global $imic_options;
	$get_id = $_POST['id'];
	$match_speci = (isset($imic_options['price_guide_specifications']))?$imic_options['price_guide_specifications']:array();
	$find_vals = (isset($imic_options['find_guide_specifications']))?$imic_options['find_guide_specifications']:'';
	$specification = get_post_meta($get_id,'feat_data',true);
	$query = array();
	if(!empty($match_speci)) {
	foreach($match_speci as $match) {
		$integer = get_post_meta($match,'imic_plugin_spec_char_type',true);
		$value_label = get_post_meta($match,'imic_plugin_value_label',true);
	$detailed_spec_key = array_search($match, $specification['sch_title']);
	$second_key = array_search($match*111, $specification['sch_title']);
		$slug = imic_the_slug($match);
		if($integer==1) {
			$query[] = "int_".$slug;
		}
		else {
			$query[] = $slug;
			if(is_int($second_key)) {
			$query[] = $value_label;
		}
		}
	} 
	$query_vars = imic_search_match($get_id,$match_speci,$specification);
	$query_val = array_combine($query, $query_vars);
	$count = 1;
	$arrays = array();
	//print_r($query_val);
	if(!empty($query_val)) { foreach($query_val as $key=>$value)
    {
        if(!get_query_var($key)) {
		if (strpos($key,'int') !== false) {
			$arrays[$count] = array(
                    'key' => $key,
                    'value' =>  $value,
                    'compare' => '<=',
					'type' => 'numeric'
                    );
		} else {
        $arrays[$count] = array(
                    'key' => 'feat_data',
                    'value' =>  urldecode($value),
                    'compare' => 'LIKE'
                    ); }
		}
	
   $count++; } 
   } 
   $arr = array();
   $args_cars = array('post_type'=>'yachts','meta_query' => $arrays,'posts_per_page'=>10,'post_status'=>'publish');
	$cars_listing = new WP_Query( $args_cars );
	if ( $cars_listing->have_posts() ) :
	while ( $cars_listing->have_posts() ) :	
	$cars_listing->the_post();
		$specifications = get_post_meta(get_the_ID(),'feat_data',true);
		$arr[] = imic_vehicle_price(get_the_ID(),$find_vals,$specifications);
	endwhile; 
	else: echo __('Sorry, No Idea for this listing','framework');
	endif; wp_reset_postdata();
	if(!empty($arr)) {
	if(count($arr)>1) {
		$min = min($arr);
		$max = max($arr);
		echo __('between ','framework') .$min.' - '.$max;
	}
	else {
		echo __('Appx ','framework').$arr[0];
	} } }
	else {
		echo __('Sorry, No Idea for this listing','framework');
	}
	die();
}
add_action('wp_ajax_nopriv_imic_price_guide', 'imic_price_guide');
add_action('wp_ajax_imic_price_guide', 'imic_price_guide');
}
if(!function_exists('imic_update_user_info')) {
function imic_update_user_info(){
	//echo "sai";
	$uid = (isset($_POST['uid']))?$_POST['uid']:'';
$uinfo = (isset($_POST['uinfo']))?$_POST['uinfo']:'';
$fname = (isset($_POST['fname']))?$_POST['fname']:'';
$lname = (isset($_POST['lname']))?$_POST['lname']:'';
$uphone = (isset($_POST['phone']))?$_POST['phone']:'';
$ucity = (isset($_POST['city']))?$_POST['city']:'';
$uzip = (isset($_POST['zip']))?$_POST['zip']:'';
$ustate = (isset($_POST['state']))?$_POST['state']:'';
$current_id = (isset($_POST['currentid']))?$_POST['currentid']:'';
$query_var = (isset($_POST['queryv']))?$_POST['queryv']:array();
$cat_slug = '';
if(!empty($query_var))
{
	foreach($query_var as $key=>$value)
	{
		if($key=="list-cat")
		{
			$cat_slug = $value;
		}
	}
}
$category_id = get_term_by('slug', $cat_slug, 'listing-category');
$term_id = $category_id->term_id;
$parents = get_ancestors( $term_id, 'listing-category' );
$list_terms = array();
foreach($parents as $parent)
{
	$list_term = get_term_by('id', $parent, 'listing-category');
	$list_terms[] = $list_term->slug;
}
$list_terms[] = $cat_slug;
wp_set_object_terms($current_id, $list_terms, 'listing-category');
if(!empty($uid)) {
	wp_set_object_terms($uinfo, $ustate, 'user-city');
	wp_update_user( array( 'ID' => $uid, 'first_name' => $fname, 'last_name' => $lname ) );
	update_post_meta($uinfo,'imic_user_city',$ucity);
	update_post_meta($uinfo,'imic_user_zip_code',$uzip);
	update_post_meta($uinfo,'imic_user_telephone',$uphone);
}
echo esc_attr($fname);
die();
}
add_action('wp_ajax_nopriv_imic_update_user_info', 'imic_update_user_info');
add_action('wp_ajax_imic_update_user_info', 'imic_update_user_info');
}
if(!function_exists('imi_update_status_ads')) {
function imi_update_status_ads(){
	//echo "sai";
	$ad_id = $_POST['ads'];
	$next_status = $_POST['next_status'];
	if($next_status==3) { echo __("Inactive","framework"); } elseif($next_status==1) { echo __("Active","framework"); }
	elseif($next_status==2) { 
	$post_author_id = get_post_field( 'post_author', $ad_id );
	$user_info_id = get_user_meta($post_author_id,'imic_user_info_id',true);
	$cu = get_post_meta($user_info_id,'imic_user_sold_cars',true);
	update_post_meta($user_info_id,'imic_user_sold_cars',$cu+1);
	echo __("Sold","framework"); }
	update_post_meta($ad_id,'imic_plugin_ad_payment_status',$next_status);
	die();
}
add_action('wp_ajax_nopriv_imi_update_status_ads', 'imi_update_status_ads');
add_action('wp_ajax_imi_update_status_ads', 'imi_update_status_ads');
}
if(!function_exists('find_car_with_position')) {
function find_car_with_position($cars, $position) {
    foreach($cars as $index => $car) {
        if($car['imic_plugin_specification_values'] == $position) return $index;
    }
    return FALSE;
}
}
if(!function_exists('find_car_with_image')) {
function find_car_with_image($cars, $position) {
    foreach($cars as $index => $car) {
        if($car['imic_plugin_spec_image'] == $position) return $index;
    }
    return FALSE;
}
}
if(!function_exists('imic_validate_payment')) {
function imic_validate_payment($tx) {
	// Init cURL
	$request = curl_init();
	global $imic_options;
	$paypal_payment = $imic_options['paypal_site'];
	$paypal_payment = ($paypal_payment=="1")?"https://www.paypal.com/cgi-bin/webscr":"https://www.sandbox.paypal.com/cgi-bin/webscr";
	// Set request options
	curl_setopt_array($request, array
	(
	  CURLOPT_URL => $paypal_payment,
	  CURLOPT_POST => TRUE,
	  CURLOPT_POSTFIELDS => http_build_query(array
		(
		  'cmd' => '_notify-synch',
		  'tx' => $tx,
		  'at' => $imic_options['paypal_token'],
		)),
	  CURLOPT_RETURNTRANSFER => TRUE,
	  CURLOPT_HEADER => FALSE,
	  // CURLOPT_SSL_VERIFYPEER => TRUE,
	  // CURLOPT_CAINFO => 'cacert.pem',
	));
	// Execute request and get response and status code
	$response = curl_exec($request);
	$status   = curl_getinfo($request, CURLINFO_HTTP_CODE);
	
	// Close connection
	curl_close($request);
	// Remove SUCCESS part (7 characters long)
	$response = substr($response, 7);
	
	// URL decode
	$response = urldecode($response);
	// Turn into associative array
	preg_match_all('/^([^=\s]++)=(.*+)/m', $response, $m, PREG_PATTERN_ORDER);
	$response = array_combine($m[1], $m[2]);
	
	// Fix character encoding if different from UTF-8 (in my case)
	if(isset($response['charset']) AND strtoupper($response['charset']) !== 'UTF-8')
	{
	  foreach($response as $key => &$value)
	  {
		$value = mb_convert_encoding($value, 'UTF-8', $response['charset']);
	  }
	  $response['charset_original'] = $response['charset'];
	  $response['charset'] = 'UTF-8';
	}
	// Sort on keys for readability (handy when debugging)
	ksort($response);
	return $response;
}
}
/* Add new Agent User Role
=================================*/
if(!function_exists('imic_add_dealer_role')) {
function imic_add_dealer_role() {
remove_role('dealer');
add_role('dealer', 'Dealer', array('read' => true,'edit_posts' => false,'delete_posts' => false, 'upload_files'=>true));
}
add_action("after_switch_theme", "imic_add_dealer_role", 10 ,  2);  
}
if(!function_exists('imicQuickEditProperty')){
add_filter('wp_dropdown_users', 'imicQuickEditProperty');
function imicQuickEditProperty($output)
{ global $post;
//global $post is available here, hence you can check for the post type here
$user_query = get_users( array( 'role' => 'subscriber' ) );
// This gets the array of ids of the subscribers
$subscribers_id = wp_list_pluck( $user_query, 'ID' );
// Now use the exclude parameter to exclude the subscribers
$users = get_users( array( 'exclude' => $subscribers_id ) );
$output = "<select id=\"post_author_override\" name=\"post_author_override\" class=\"\">";
foreach($users as $user)
{ 
$sel = ($post->post_author == $user->ID)?"selected='selected'":'';
$output .= '<option value="'.$user->ID.'"'.$sel.'>'.$user->user_login.'</option>';
}
$output .= "</select>";
return $output;
}} 
if(!function_exists('imic_array_empty')) {
function imic_array_empty($mixed) {
    if (is_array($mixed)) {
        foreach ($mixed as $value) {
            if (!imic_array_empty($value)) {
                return false;
            }
        }
    }
    elseif (!empty($mixed)) {
        return false;
    }
    return true;
}
}
//Manage Custom Columns for Cars Post Type 
if (!function_exists('imic_cars_status_columns')) {
    add_filter('manage_edit-cars_columns', 'imic_cars_status_columns');
    function imic_cars_status_columns($columns) {
        $columns['Status'] = __('Status', 'framework');
		//$columns['Recurring'] = __('Recurring', 'framework');
        return $columns;
    }
}
if (!function_exists('imic_cars_status_column_content')) {
    add_action('manage_cars_posts_custom_column', 'imic_cars_status_column_content', 10, 2);
    function imic_cars_status_column_content($column_name, $post_id) {
        switch ($column_name) {
            case 'Status':
                $status = get_post_meta($post_id, 'imic_plugin_ad_payment_status', true);
				if($status==0) {
					$val = __("Pending","framework"); }
				elseif($status==1) {
					$val = __("Completed","framework"); }
				elseif($status==2) {
					$val = __("Sold","framework"); }
				elseif($status==3) {
					$val = __("Inactive","framework"); }
				elseif($status==4) {
					$val = __("Under Review","framework"); }
                echo esc_attr($val);
                break;
        }
    }
}
/*AGENT FIELDS
  ===========================================================*/
if(!function_exists('imic_agent_fields')) {
function imic_agent_fields( $user ) {
$info_id = get_the_author_meta('imic_user_info_id', $user->ID);
?>
<h3><?php _e('User Info ID','framework'); ?></h3>
<table class="form-table">
<tr>
<th>
<label for="User Info ID"><?php _e('Dealers Info ID','framework'); ?></label>
</th>
<td>
<label><input type="text" name="imic_user_info_id" value ="<?php echo esc_attr($info_id); ?>" </label>
</td>
</tr>
</table>
<?php 
}
function imic_save_agent_field( $user_id ) {
$info_id = isset($_POST['imic_user_info_id']) ? wp_filter_post_kses($_POST['imic_user_info_id']) : '';
update_user_meta( $user_id,'imic_user_info_id', $info_id);
}
add_action( 'show_user_profile', 'imic_agent_fields');
add_action( 'edit_user_profile', 'imic_agent_fields');
add_action( 'personal_options_update', 'imic_save_agent_field' );
add_action( 'edit_user_profile_update', 'imic_save_agent_field' );
}
if(!function_exists('imic_get_currency_symbol')){
function imic_get_currency_symbol( $currency = '' ) {
	if ( ! $currency ) {
		$currency = 'USD';
	}
	switch ( $currency ) {
		case 'AED' :
			$currency_symbol = 'AED';
			break;
		case 'BDT':
			$currency_symbol = '&#2547;&nbsp;';
			break;
		case 'BRL' :
			$currency_symbol = '&#82;&#36;';
			break;
		case 'BGN' :
			$currency_symbol = '&#1083;&#1074;.';
			break;
		case 'AUD' :
		case 'CAD' :
		case 'CLP' :
		case 'MXN' :
		case 'NZD' :
		case 'HKD' :
		case 'SGD' :
                case 'COP' :
		case 'USD' :
			$currency_symbol = '&#36;';
			break;
		case 'EUR' :
			$currency_symbol = '&euro;';
			break;
		case 'CNY' :
		case 'RMB' :
		case 'JPY' :
			$currency_symbol = '&yen;';
			break;
		case 'RUB' :
			$currency_symbol = '&#8381;';
			break;
		case 'KRW' : $currency_symbol = '&#8361;'; break;
		case 'TRY' : $currency_symbol = '&#84;&#76;'; break;
		case 'NOK' : $currency_symbol = '&#107;&#114;'; break;
		case 'ZAR' : $currency_symbol = '&#82;'; break;
		case 'CZK' : $currency_symbol = '&#75;&#269;'; break;
		case 'MYR' : $currency_symbol = '&#82;&#77;'; break;
		case 'DKK' : $currency_symbol = 'kr.'; break;
		case 'HUF' : $currency_symbol = '&#70;&#116;'; break;
		case 'IDR' : $currency_symbol = 'Rp'; break;
		case 'INR' : $currency_symbol = '&#x20B9;'; break;
		case 'ISK' : $currency_symbol = 'Kr.'; break;
		case 'ILS' : $currency_symbol = '&#8362;'; break;
		case 'JMD' : $currency_symbol = '&#74;&#36;'; break;
		case 'PHP' : $currency_symbol = '&#8369;'; break;
		case 'PLN' : $currency_symbol = '&#122;&#322;'; break;
		case 'PKR' : $currency_symbol = '&#8360;'; break;
		case 'SEK' : $currency_symbol = '&#107;&#114;'; break;
		case 'CHF' : $currency_symbol = '&#67;&#72;&#70;'; break;
		case 'TWD' : $currency_symbol = '&#78;&#84;&#36;'; break;
		case 'THB' : $currency_symbol = '&#3647;'; break;
		case 'GBP' : $currency_symbol = '&pound;'; break;
		case 'RON' : $currency_symbol = 'lei'; break;
		case 'VND' : $currency_symbol = '&#8363;'; break;
		case 'NGN' : $currency_symbol = '&#8358;'; break;
		case 'HRK' : $currency_symbol = 'Kn'; break;
		default    : $currency_symbol = ''; break;
	}
	return $currency_symbol;
}
}
function get_top_level_term_id( $post_id, $taxonomy ) {
 
    $terms = wp_get_post_terms( $post_id, $taxonomy );
 
    $term = $terms[0];
    $term_id = $term->term_id;
 
    while( $term->parent ) {
        $term_id = $term->parent; 
        $term = get_term_by( 'id', $term_id, $taxonomy );
    }
    return $term_id;
}
function get_last_child_term_id( $post_id, $taxonomy, $output_single = false ) {
 
    $terms = wp_get_post_terms( $post_id, $taxonomy );
 	if ((!is_wp_error( $terms ))&&(!empty($terms)))
	{
    $new_terms = array();
    foreach( $terms as $term ) {
        $i = 0;
        $new_term = $term;
        while( $term->parent ) {
            $term_id = $term->parent; 
            $term = get_term_by( 'id', $term_id, $taxonomy );
            $i++;
        }
        if( $output_single ) {
            $new_terms[$i] = $new_term;
        } else {
            $new_terms[$i][] = $new_term;
        }
    }
 
    $array_last_index = count( $new_terms ) - 1;
 
    $terms = $new_terms[$array_last_index];
 
    if( $output_single ) {
        $term = $terms;
        $term_id = $term->slug;
        return $term_id;
    } else {
        $term_ids = array();
        foreach( $terms as $term ) {
            $term_ids[] = $term->slug;
        }
        return $term_ids;
    }
	}
}
if(!function_exists('imic_update_listing_date'))
{
	function imic_update_listing_date()
	{
		if(!is_admin())
		{
			$status_listing_update_date = get_option('imic_listing_date');
			if($status_listing_update_date!="snsd")
			{
				$query = new WP_Query(array('post_type' => 'yachts', 'posts_per_page'=>-1));
				if( $query->have_posts() )
				{
					while($query->have_posts())
					{
						$query->the_post();
						$listing_end_date = get_post_meta(get_the_ID(),'imic_plugin_listing_end_dt',true);
						if($listing_end_date=='')
						{
							update_post_meta(get_the_ID(), 'imic_plugin_listing_end_dt', '2020-01-01');
						}
					}
					update_option('imic_listing_date', 'snsd');
				}
				else
				{
					update_option('imic_listing_date', '');
				}
				wp_reset_postdata();
			}
		}
	}
	imic_update_listing_date();
}
if(!function_exists('imic_filter_lang_specs'))
{
	function imic_filter_lang_specs($specs, $listing_terms = array())
	{
		$new_specs = array();
		if((!empty($specs))&&(class_exists('SitePress')))
		{
			foreach($specs as $spec)
			{
				if(!empty($listing_terms))
				{
					if(class_exists('SitePress')&&ICL_LANGUAGE_CODE==imic_langcode_post_id( $spec ))
					{
						if(has_term( $listing_terms, 'listing-category', $spec ))
						{
							$new_specs[] = $spec;
						}
					}
				}
				else
				{
					if(class_exists('SitePress')&&ICL_LANGUAGE_CODE==imic_langcode_post_id( $spec ))
					{
							$new_specs[] = $spec;
					}
				}
			}
		}
		else
		{
			if(!empty($listing_terms))
			{
				foreach($specs as $spec)
				{
					if(has_term( $listing_terms, 'listing-category', $spec ))
					{
						$new_specs[] = $spec;
					}
				}
			}
			else
			{
				$new_specs = $specs;
			}
		}
		return $new_specs;
	}
}
if(!function_exists('imic_update_specifications_type'))
{
	function imic_update_specifications_type()
	{
		global $imic_options;
		$specifications_upd_st = get_option('imic_specifications_upd_st');
		$data_import_status = get_option('imic_data_imported_status');
		$listings_arg = array('post_type'=>'yachts', 'posts_per_page' => -1);
		if($specifications_upd_st==''&&$specifications_upd_st!=1)
		{
			$listing_posts = new WP_Query($listings_arg);
			$total_listings = $listing_posts->found_posts;
			wp_reset_postdata();
		}
		if($specifications_upd_st==''&&$specifications_upd_st!=1&&$data_import_status==1)
		{
			$specificiations_arg = array('post_type'=>'specification', 'posts_per_page'=>-1, 'meta_query'=>array(array('key'=>'imic_plugin_spec_char_type', 'value'=>0, 'compare'=>'=')));
			$specifications_posts = new WP_Query($specificiations_arg);
			if($specifications_posts->have_posts()):
				while($specifications_posts->have_posts()):
					$specifications_posts->the_post();
						update_post_meta(get_the_ID(), 'imic_plugin_spec_char_type', 2);
				endwhile;
			endif;
			wp_reset_postdata();
			$listings_arg = array('post_type'=>'yachts', 'posts_per_page' => -1);
			$listing_posts = new WP_Query($listings_arg);
			if($listing_posts->have_posts()):
				while($listing_posts->have_posts()):
					$listing_posts->the_post();
					$feat_data = get_post_meta(get_the_ID(), 'feat_data', true);
					
					if(isset($feat_data['start_time']))
					{
						foreach($feat_data['sch_title'] as $specs)
						{
							$this_slug = imic_the_slug($specs);
							if(imic_value_search_multi_array($specs, $feat_data)) 
							{
								$detailed_spec_key = array_search($specs, $feat_data['sch_title']);
								$second_key = array_search($specs*111, $feat_data['sch_title']);
								if(is_int($second_key)) 
								{ 
									$val = $feat_data['start_time'][$second_key];
							 		update_post_meta(get_the_ID(), 'child_'.$this_slug, $val);
								}
								if(is_int($detailed_spec_key)) 
								{
									$cur_spec = $feat_data['start_time'][$detailed_spec_key];
									if($cur_spec!='') 
									{ 
										update_post_meta(get_the_ID(), 'char_'.$this_slug, $cur_spec);
									} 
								}
							}
						}
					}
				endwhile;
			endif;
			wp_reset_postdata();
			update_option('imic_specifications_upd_st', 1);
		}
	}
	if(!is_admin())
	{
		imic_update_specifications_type();
	}
}
if(!function_exists('imic_encode_spaces'))
{
function imic_encode_spaces($string){
    return str_replace(' ', '%20', $string);
}
}
if(!function_exists("imic_list_child_specs"))
{
	function imic_list_child_specs()
	{
		$spec_id = (isset($_POST['specid']))?$_POST['specid']:'';
		$spec_val = (isset($_POST['parent']))?$_POST['parent']:'';
		$list_id = (isset($_POST['listid']))?$_POST['listid']:'';
		if($spec_id!=''&&$spec_val!='')
		{
			$char_slug = imic_the_slug($spec_id);
			$spec_value = '';
			$current_value = get_post_meta($list_id, 'child_'.$char_slug, true);
			$values = get_post_meta($spec_id,'specifications_value',true);
			echo '<select type="text" class="meta_feat_title rwmb-select" name="child_'.esc_attr($char_slug).'">';
              foreach($values as $value) {
								if($spec_val==$value['imic_plugin_specification_values'])
								{
									$child_vals = $value['imic_plugin_specification_values_child'];
									$child_vals = explode(',', $child_vals);
									break;
								}
							}
							foreach($child_vals as $val)
							{
								$selected = ($current_value==$val||$current_value==" ".$val)?'selected':'';
								echo '<option '.$selected.' value="'.$val.'">'.$val.'</option>';
							}
             echo '</select>';
		}
		die();
	}
	add_action('wp_ajax_nopriv_imic_list_child_specs', 'imic_list_child_specs');
	add_action('wp_ajax_imic_list_child_specs', 'imic_list_child_specs');
}
if(!function_exists('imic_contact_site_plans'))
{
	function imic_contact_site_plans()
	{
		$tx = (isset($_POST['transaction']))?$_POST['transaction']:'';
		$message = (isset($_POST['message']))?$_POST['message']:'';
		$plan_id = (isset($_POST['plan']))?$_POST['plan']:'';
		if($tx!='')
		{
			$paypal_details = imic_validate_payment($tx);
			if(!empty($paypal_details))
			{
				$st = $paypal_details['payment_status'];
				$payment_gross = $paypal_details['payment_gross'];
				global $current_user;
				get_currentuserinfo();
				$user_id = get_current_user_id( );
				$current_user = wp_get_current_user();
				$user_info_id = get_user_meta($user_id,'imic_user_info_id',true);
				$site_manager_email = get_option('admin_email');
				$manager_email = esc_attr($site_manager_email);
				$dealer_name = get_the_title($user_info_id);
				$e_subject = __('Payment Related Query','framework');
				$e_body = __("You have been contacted by $dealer_name ","framework"). PHP_EOL . PHP_EOL;
				$e_content = '';
				$e_content .= __("Name: ","framework").$dealer_name. PHP_EOL . PHP_EOL;
				$e_content .= __("Email: ","framework").$current_user->user_email. PHP_EOL . PHP_EOL;
				$e_content .= __("Plan: ","framework").get_the_title($plan_id). PHP_EOL . PHP_EOL;
				$e_content .= __("Transaction ID: ","framework").$paypal_details['txn_id']. PHP_EOL . PHP_EOL;
				$e_content .= __("Payment Status: ","framework").$paypal_details['payment_status']. PHP_EOL . PHP_EOL;
				$e_content .= __("Message: ","framework").$message. PHP_EOL . PHP_EOL;
				$e_reply = __("You can contact ","framework").$dealer_name.__(" via email, ","framework").$current_user->user_email;
				$msg = wordwrap( $e_body . $e_content . $e_reply, 70 );
				$headers = __("From: ","framework").$current_user->user_email. PHP_EOL;
				$headers .= __("Reply-To: ","framework").$current_user->user_email. PHP_EOL;
				$headers .= "MIME-Version: 1.0" . PHP_EOL;
				$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
				$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;
				if(mail($manager_email, $e_subject, $msg, $headers)) {
					echo "<div class=\"alert alert-success\">".__('Thank you', 'framework')." <strong>$dealer_name</strong>, ".__('your message has been submitted to us.', 'framework')."</div>";
				} else {
					echo '<div class="alert alert-error">ERROR!</div>';
				}
			}
		}
		die();
	}
	add_action('wp_ajax_nopriv_imic_contact_site_plans', 'imic_contact_site_plans');
	add_action('wp_ajax_imic_contact_site_plans', 'imic_contact_site_plans');
}
?>