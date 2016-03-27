<?php
/* ==================================================
  Plan Post Type Functions
  ================================================== */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
add_action('init', 'speaker_register');
function speaker_register() {
    $labels = array(
        'name' => __('Plans', 'framework'),
        'singular_name' => __('Plan', 'framework'),
        'all_items'=> __('Plans', 'framework'),
        'add_new' => __('Add New', 'framework'),
        'add_new_item' => __('Add New Payment Plan', 'framework'),
        'edit_item' => __('Edit Payment Plan', 'framework'),
        'new_item' => __('New Payment Plan', 'framework'),
        'view_item' => __('View Plans', 'framework'),
        'search_items' => __('Search Plans', 'framework'),
        'not_found' => __('No payment plans have been added yet', 'framework'),
        'not_found_in_trash' => __('Nothing found in Trash', 'framework'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
		'capability_type' => 'page',
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => false,
        'rewrite' => true,
        'supports' => array('title', 'editor','author'),
        'has_archive' => true,
		'menu_icon' => 'dashicons-cart',
    );
    register_post_type('plan', $args);
}
?>