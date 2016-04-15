<?php
/* 
 * Plugin Name: IMITHEMES Classifieds
 * Plugin URI:  http://www.imithemes.com
 * Description: Adds classified feature in AutoStars theme
 * Author:      imithemes
 * Version:     1.0.5
 * Author URI:  http://www.imithemes.com
 * Copyright:   (c) 2015 imithemes. All rights reserved
 */

// Do not allow direct access to this file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
$path_imi = plugin_dir_path( __FILE__ );
/* Add Required Files
================================================== */
require_once $path_imi . '/listing-taxonomy.php';
require_once $path_imi . '/imi-functions.php';
require_once $path_imi . '/classifieds_admin.php';
if(!function_exists('imic_update_specification_metabox'))
{
function imic_update_specification_metabox()
{
	global $path_imi;
require_once $path_imi . '/meta_field.php';
}
add_action('after_setup_theme','imic_update_specification_metabox');
}
if (!function_exists('imic_enqueue_scripts_classified')) 
{
    function imic_enqueue_scripts_classified() 
	{
		$theme_info = wp_get_theme();
		wp_register_script('imic_child_cat',plugins_url( '/js/get-child-cat.js' , __FILE__ ), array(), $theme_info->get( 'Version' ), true);
		wp_enqueue_script('imic_child_cat');
		wp_localize_script('imic_child_cat','classified',array('ajaxurl'=>admin_url('admin-ajax.php')));
	}
	add_action('wp_enqueue_scripts', 'imic_enqueue_scripts_classified');
}