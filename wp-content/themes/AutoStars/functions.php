<?php
update_option( 'siteurl', 'http://wp.loc' );
update_option( 'home', 'http://wp.loc' );
/* -----------------------------------------------------------------------------------
  Here we have all the custom functions for the theme
  Please be extremely cautious editing this file,
  When things go wrong, they tend to go wrong in a big way.
  You have been warned!
  ----------------------------------------------------------------------------------- */
/*
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
  ----------------------------------------------------------------------------------- */
define('IMIC_THEME_PATH', get_template_directory_uri());
define('IMIC_FILEPATH', get_template_directory());
/* -------------------------------------------------------------------------------------
  Load Translation Text Domain
  ----------------------------------------------------------------------------------- */
add_action('after_setup_theme', 'imic_theme_setup');
function imic_theme_setup() {
    load_theme_textdomain('framework', IMIC_FILEPATH . '/language');
}
/* -------------------------------------------------------------------------------------
  Menu option
  ----------------------------------------------------------------------------------- */
function register_menu() {
    register_nav_menu('primary-menu', __('Primary Menu', 'framework'));
    register_nav_menu('top-menu', __('Top Menu', 'framework'));
}
add_action('init', 'register_menu');
/* -------------------------------------------------------------------------------------
  Set Max Content Width (use in conjuction with ".entry-content img" css)
  ----------------------------------------------------------------------------------- */
if (!isset($content_width))
    $content_width = 680;
/* -------------------------------------------------------------------------------------
  Configure WP2.9+ Thumbnails & gets the current post type in the WordPress Admin
  ----------------------------------------------------------------------------------- */
if (function_exists('add_theme_support')) {
        add_theme_support('post-formats', array(
            'video', 'image', 'gallery', 'link'
        ));
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    set_post_thumbnail_size(958, 9999);
	//Mandatory
	add_image_size('100x100','100','100',true);
	add_image_size('600x400','600','400',true);
	add_image_size('400x400','400','400',true);
	add_image_size('330x206','330','206',true);
	add_image_size('1000x800','1000','800',true);
	add_image_size('200x125','200','125',true);
	add_image_size('210x210','210','210',true);
	add_image_size('800x500','800','500',true);
    add_theme_support('woocommerce');
}
add_action( 'init', 'imic_remove_post_type_support', 10 );
function imic_remove_post_type_support() {
    remove_post_type_support( 'post', 'post-formats' );
}
/* -------------------------------------------------------------------------------------
  Custom Gravatar Support
  ----------------------------------------------------------------------------------- */
if (!function_exists('imic_custom_gravatar')) {
    function imic_custom_gravatar($avatar_defaults) {
        $imic_avatar = get_template_directory_uri() . '/images/img_avatar.png';
        $avatar_defaults[$imic_avatar] = 'Custom Gravatar (/images/img_avatar.png)';
        return $avatar_defaults;
    }
    add_filter('avatar_defaults', 'imic_custom_gravatar');
}
/* -------------------------------------------------------------------------------------
  Load Theme Options
  ----------------------------------------------------------------------------------- */
require_once(IMIC_FILEPATH . '/includes/ReduxCore/framework.php');
require_once(IMIC_FILEPATH . '/includes/sample/sample-config.php');
include_once(IMIC_FILEPATH . '/imic-framework/imic-framework.php');
/* -------------------------------------------------------------------------------------
  For Paginate
  ----------------------------------------------------------------------------------- */
if (!function_exists('imic_pagination')) {
    function imic_pagination($pages = '', $range = 4) {
        $showitems = ($range * 2) + 1;
        global $paged;
        if (empty($paged))
            $paged = 1;
        if ($pages == '') {
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if (!$pages) {
                $pages = 1;
            }
        }
        if (1 != $pages) {
            echo '<ul class="pagination">';
            echo '<li><a href="' . get_pagenum_link(1) . '" title="'.__('First','framework').'"><i class="fa fa-chevron-left"></i></a></li>';
            for ($i = 1; $i <= $pages; $i++) {
                if (1 != $pages && (!($i >= $paged + $range + 3 || $i <= $paged - $range - 3) || $pages <= $showitems )) {
                    echo ($paged == $i) ? "<li class=\"active\"><span>" . $i . "</span></li>" : "<li><a href='" . get_pagenum_link($i) . "' class=\"\">" . $i . "</a></li>";
                }
            }
           echo '<li><a href="' . get_pagenum_link($pages) . '" title="'.__('Last','framework').'"><i class="fa fa-chevron-right"></i></a></li>';
            echo '</ul>';
        }
    }
}
/* -------------------------------------------------------------------------------------
  For Listing Pagination
  ----------------------------------------------------------------------------------- */
if (!function_exists('imic_listing_pagination')) {
    function imic_listing_pagination($ajax = '', $pages = '', $paged = 1, $range = 4) {
        $showitems = ($range * 2) + 1;
        if ($pages == '') {
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if (!$pages) {
                $pages = 1;
            }
        }
        if (1 != $pages) {
            echo '<ul class="pagination" id="page-paginate">';
            echo '<li><a class="" href="javascript:void(0);" title="'.__('First','framework').'" id="left-1"><i class="fa fa-chevron-left"></i></a></li>';
            for ($i = 1; $i <= $pages; $i++) {
                if (1 != $pages && (!($i >= $paged + $range + 3 || $i <= $paged - $range - 3) || $pages <= $showitems )) {
					$active = ($ajax=='page-'.$i)?'active':'';
                    echo ($paged == $i) ? "<li class='".$active."'><a id='page-" . $i . "' href=\"javascript:void(0);\">" . $i . "</a></li>" : "<li class='".$active."'><a id='page-" . $i . "' href='javascript:void(0);' class=\"\">" . $i . "</a></li>";
                }
            }
           echo '<li><a class="" href="javascript:void(0);" title="'.__('Last','framework').'" id="right-'.$pages.'"><i class="fa fa-chevron-right"></i></a></li>';
            echo '</ul>';
        }
    }
}
/* -------------------------------------------------------------------------------------
  For Remove Dimensions from thumbnail image
  ----------------------------------------------------------------------------------- */
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10);
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10);
function remove_thumbnail_dimensions($html) {
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}
/* -------------------------------------------------------------------------------------
  Excerpt More and  length
  ----------------------------------------------------------------------------------- */
if (!function_exists('imic_custom_read_more')) {
    function imic_custom_read_more() {
        return '... ';
    }
}
if (!function_exists('imic_excerpt')) {
    function imic_excerpt($limit = 50) {
        return wp_trim_words(get_the_excerpt(), $limit, imic_custom_read_more());
    }
}
/* 	Comment Styling
  /*----------------------------------------------------------------------------------- */
if (!function_exists('imic_comment')) {
    function imic_comment($comment, $args, $depth) {
        $isByAuthor = false;
        if ($comment->comment_author_email == get_the_author_meta('email')) {
            $isByAuthor = true;
        }
        $GLOBALS['comment'] = $comment;
        ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
            <div class="post-comment-block">
                <div id="comment-<?php comment_ID(); ?>">
                    <div class="img-thumbnail"><?php echo get_avatar($comment, $size = '80'); ?></div>
                    <div class="post-comment-content">
        <?php
         echo preg_replace('/comment-reply-link/', 'comment-reply-link btn btn-default btn-xs pull-right', get_comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => __('Reply','framework')))), 1);
       echo '<h5>' . get_comment_author() .__(' says','framework').'</h5>';
        ?>            
                    <span class="meta-data">
            <?php
            echo get_comment_date();
            echo esc_attr_e(' at ', 'framework');
            echo get_comment_time();
            ?>
                    </span>
            <?php if ($comment->comment_approved == '0') : ?>
                        <em class="moderation"><?php echo esc_attr_e('Your comment is awaiting moderation.', 'framework') ?></em>
                        <br />
            <?php endif; ?>
            <?php comment_text() ?>
                </div></div>
            </div>
            <?php
        }
    }
function imic_the_slug($id, $echo=true){
  $post_data = get_post($id, ARRAY_A);
    $slug = $post_data['post_name'];
    return $slug; 
}
function imic_vehicle_price($id, $specs, $this_specification = array()) {
	global $imic_options;
	$data_type = (isset($imic_options['specification_fields_type']))?$imic_options['specification_fields_type']:'0';
	$unique_value = '';
	if(!empty($specs)) 
	{
		$int = get_post_meta($specs,'imic_plugin_spec_char_type',true);
		$value_label = get_post_meta($specs,'imic_plugin_value_label',true); 
		$label_position = get_post_meta($specs,'imic_plugin_lable_position',true);
		if($int==0||$int==2) 
		{
			if($int=="0")
			{
				if(imic_value_search_multi_array($specs,$this_specification)) 
				{
					$unique_key = array_search($specs, $this_specification['sch_title']);
					if(is_int($unique_key)) 
					{
						if($label_position==0) 
						{
							$unique_value = $value_label.$this_specification['start_time'][$unique_key].' ';  
						}
						else 
						{
							$unique_value = $this_specification['start_time'][$unique_key].$value_label.' ';  
						}
					} 
				} 
			}
			else
			{
				$price_id_slug = imic_the_slug($specs);
				$char_price = get_post_meta($id, 'char_'.$price_id_slug, true);
				if($label_position==0) 
				{
					$unique_value = $value_label.$char_price.' ';  
				}
				else 
				{
					$unique_value = $char_price.$value_label.' ';  
				}
			}
		}
		else 
		{ 
			$slug = imic_the_slug($specs);
			$int_value = get_post_meta($id,'int_'.$slug,true);
			if($int_value!='') 
			{
				if($label_position==0) 
				{
					$unique_value = $value_label.$int_value; 
				}
				else 
				{
					$unique_value = $int_value.$value_label; 
				}
			}	 
		}
	} //}
	return $unique_value;
}
function imic_vehicle_title($id, $specs, $this_specification) 
{
	$highlight_value = '';
	global $imic_options;
	$data_type = (isset($imic_options['specification_fields_type']))?$imic_options['specification_fields_type']:'0';
	if(!empty($specs)) 
	{
		$highlight_value = '';
		foreach($specs as $highlight) 
		{
			$val = '';
			$int = get_post_meta($highlight,'imic_plugin_spec_char_type',true);
			$value_label = get_post_meta($highlight,'imic_plugin_value_label',true);
			$label_position = get_post_meta($highlight,'imic_plugin_lable_position',true);
			if($int==0||$int==2) 
			{
				if($int=="0")
				{
					if(imic_value_search_multi_array($highlight,$this_specification)) 
					{
						$highlight_key = array_search($highlight, $this_specification['sch_title']);
						$second_key = array_search($highlight*111, $this_specification['sch_title']);
						if(is_int($highlight_key)) 
						{
							if($int==0) 
							{
								if($data_type=="0")
								{
									if(is_int($second_key)) 
									{ 
										$val = ' '.$this_specification['start_time'][$second_key]; 
									}
									if($label_position==0) 
									{
										$highlight_value .= $value_label.$this_specification['start_time'][$highlight_key].$val.' '; 
									}
									else 
									{
										$highlight_value .= $this_specification['start_time'][$highlight_key].$val.$value_label.' '; 
									}
								}
							}
						}
					}
				}
				else
				{
					$title_id_slug = imic_the_slug($highlight);
					$char_title = get_post_meta($id, 'char_'.$title_id_slug, true);
					if($label_position==0) 
					{
						$highlight_value .= $value_label.$char_title.' '; 
					}
					else 
					{
						$highlight_value .= $char_title.$value_label.' '; 
					}
				}
			}
			else 
			{
				$slug = imic_the_slug($highlight);
				if($label_position==0) 
				{
					$highlight_value .= $value_label.get_post_meta($id,'int_'.$slug,true).' '; 
				}
				else 
				{
					$highlight_value .= get_post_meta($id,'int_'.$slug,true).$value_label.' '; 
				}
			}
	  }
	}
	return $highlight_value;
}
function imic_vehicle_all_specs($id, $specs, $this_specification) 
{
	global $imic_options;
	$data_type = (isset($imic_options['specification_fields_type']))?$imic_options['specification_fields_type']:'0';
	$details_value = array();
	if(!empty($specs)) 
	{
		$details_value = array();
		foreach($specs as $details) 
		{
			$val = '';
			$int_type = get_post_meta($details,'imic_plugin_spec_char_type',true);
			$value_label = get_post_meta($details,'imic_plugin_value_label',true);
			$label_position = get_post_meta($details,'imic_plugin_lable_position',true);
			if($int_type=="0")
			{
				if(imic_value_search_multi_array($details,$this_specification)) 
				{
					$detailed_spec_key = array_search($details, $this_specification['sch_title']);
					$second_key = array_search($details*111, $this_specification['sch_title']);
					if($int_type==1) 
					{
						$slug = imic_the_slug($details);
						if($label_position==0) 
						{
							$details_value[] = $value_label.get_post_meta($id,'int_'.$slug,true); 
						}
						else 
						{
							$details_value[] = get_post_meta($id,'int_'.$slug,true).$value_label; 
						}
					} 
					else 
					{
						if(is_int($second_key)) 
						{ 
							$val = ' '.$this_specification['start_time'][$second_key]; 
						}
						if(is_int($detailed_spec_key)) 
						{
							if($label_position==0) 
							{
								$cur_spec = $this_specification['start_time'][$detailed_spec_key];
								if($cur_spec!='') 
								{ 
									$spec = $cur_spec; 
								} 
								else 
								{ 
									$spec = ''; 
								} 
								$details_value[] = $value_label.$spec.$val; 
							}
							else 
							{
								$details_value[] = $this_specification['start_time'][$detailed_spec_key].$val.$value_label; 
							} 
						}
					} 
				}
			}
			else
			{
				$specs_id_slug = imic_the_slug($details);
				$char_specs = get_post_meta($id, 'char_'.$specs_id_slug, true);
				if($int_type==1) 
				{
					$slug = imic_the_slug($details);
					if($label_position==0) 
					{
						$details_value[] = $value_label.get_post_meta($id,'int_'.$slug,true); 
					}
					else 
					{
						$details_value[] = get_post_meta($id,'int_'.$slug,true).$value_label; 
					}
				} 
				else
				{
					if($label_position==0) 
					{
						$details_value[] = $value_label.$char_specs; 
					}
					else
					{
						$details_value[] = $char_specs.$value_label; 
					}
				}
			}
		}
	}
	return $details_value;
}
function imic_search_match($id, $specs, $this_specification) 
{
	$details_value = array();
	if(!empty($specs)) 
	{
		$details_value = array();
		foreach($specs as $details) 
		{
			$val = '';
			$int_type = get_post_meta($details,'imic_plugin_spec_char_type',true);
			$value_label = get_post_meta($details,'imic_plugin_value_label',true);
			$label_position = get_post_meta($details,'imic_plugin_lable_position',true);
			//if(imic_value_search_multi_array($details,$this_specification)) {
			$detailed_spec_key = array_search($details, $this_specification['sch_title']);
			$second_key = array_search($details*111, $this_specification['sch_title']);
			if($int_type=="1") 
			{
				$slug = imic_the_slug($details);
				if($label_position==0) 
				{
					$details_value[] = get_post_meta($id,'int_'.$slug,true); 
				}
				else 
				{
					$details_value[] = get_post_meta($id,'int_'.$slug,true); 
				}
			} 
			elseif($int_type=="2") 
			{
				$slug = imic_the_slug($details);
				if($label_position==0) 
				{
					$details_value[] = get_post_meta($id,'char_'.$slug,true); 
				}
				else 
				{
					$details_value[] = get_post_meta($id,'char_'.$slug,true); 
				}
			} 
			else 
			{
				if(is_int($second_key)) 
				{ 
					$val = ' '.$this_specification['start_time'][$second_key]; 
				}
				if(is_int($detailed_spec_key)) 
				{
					if($label_position==0) 
					{
						$cur_spec = $this_specification['start_time'][$detailed_spec_key];
						if($cur_spec!='') 
						{ 
							$spec = $cur_spec; 
						} 
						else 
						{ 
							$spec = ''; 
						} 
						$details_value[] = $spec;
						if($val!='') 
						{
							$details_value[] = $val; 
						} 
					}
					else 
					{
						$details_value[] = $this_specification['start_time'][$detailed_spec_key];
						if($val!='') 
						{
							$details_value[] = $val; 
						} 
					} 
				}
			}
		}
	}
	return $details_value;
}
function imic_vehicle_compare_specs($id, $specs, $this_specification) 
{
	$details_value = array();
	if(!empty($specs)) 
	{
		$details_value = array();
		foreach($specs as $details) 
		{
			$val = '';
			$int_type = get_post_meta($details,'imic_plugin_spec_char_type',true);
			$value_label = get_post_meta($details,'imic_plugin_value_label',true);
			$label_position = get_post_meta($details,'imic_plugin_lable_position',true);
			$detailed_spec_key = (array_search($details, $this_specification['sch_title']))?array_search($details, $this_specification['sch_title']):'';
			$second_key = (array_search($details*111, $this_specification['sch_title']))?array_search($details*111, $this_specification['sch_title']):'';
			if($int_type==1) 
			{
				$slug = imic_the_slug($details);
				if($label_position==0) 
				{
					$details_value[] = $value_label.get_post_meta($id,'int_'.$slug,true); 
				}
				else 
				{
					$details_value[] = get_post_meta($id,'int_'.$slug,true).$value_label; 
				}
			} 
			elseif($int_type==2) 
			{
				$slug = imic_the_slug($details);
				if($label_position==0) 
				{
					$details_value[] = $value_label.get_post_meta($id,'char_'.$slug,true); 
				}
				else 
				{
					$details_value[] = get_post_meta($id,'char_'.$slug,true).$value_label; 
				}
			} 
			else 
			{
				if(is_int($second_key)&&$second_key!='') 
				{ 
					$val = ' '.$this_specification['start_time'][$second_key]; 
				} 
				else 
				{ 
					$val = ''; 
				}
				if($label_position==0) 
				{
					if($detailed_spec_key!='') 
					{ 
						$cur_spec = $this_specification['start_time'][$detailed_spec_key]; 
					} 
					else 
					{ 
						$cur_spec = ''; 
					}
					if($cur_spec!='') 
					{ 
						$spec = $cur_spec; 
					} 
					else 
					{ 
						$spec = ''; 
					} 
					$details_value[] = $value_label.$spec.$val; 
				}
				else 
				{
					$details_value[] =$spec.$val.$value_label; 
				} 
			}
		}
	}
	return $details_value;
}
/** remove redux menu under the tools **/
add_action( 'admin_menu', 'imic_remove_redux_menu',12 );
function imic_remove_redux_menu() {
    remove_submenu_page('tools.php','redux-about');
}
if( ! current_user_can( 'administrator' ) ) {
        add_filter( 'show_admin_bar', '__return_false' );
}
?>