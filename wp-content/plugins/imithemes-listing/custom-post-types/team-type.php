<?php
/* ==================================================
  Team Post Type Functions
  ================================================== */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
add_action('init', 'team_register');
function team_register() {
    $labels = array(
        'name' => __('Team', 'framework'),
        'singular_name' => __('Team', 'framework'),
        'all_items'=> __('Team', 'framework'),
        'add_new' => __('Add New', 'framework'),
        'add_new_item' => __('Add New Team Member', 'framework'),
        'edit_item' => __('Edit Team Member', 'framework'),
        'new_item' => __('New Team Member', 'framework'),
        'view_item' => __('View Team', 'framework'),
        'search_items' => __('Search Team', 'framework'),
        'not_found' => __('No team member have been added yet', 'framework'),
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
        'supports' => array('title', 'editor', 'thumbnail','author'),
        'has_archive' => true,
		'menu_icon' => 'dashicons-groups',
    );
    register_post_type('team', $args);
}
?>