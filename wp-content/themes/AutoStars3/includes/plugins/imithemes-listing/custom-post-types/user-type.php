<?php
/* ==================================================
  User Post Type Functions
  ================================================== */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
add_action('init', 'user_register');
function user_register() {
    $args_c = array(
    "label" => __('Users Role','framework'),
    "singular_label" => __('User Role','framework'),
    'public' => true,
    'hierarchical' => true,
    'show_ui' => true,
    'show_in_nav_menus' => true,
    'args' => array('orderby' => 'term_order'),
    'rewrite' => false,
   'query_var' => true,
   'show_admin_column' => true,
);
register_taxonomy('user-role', 'user',$args_c);
$city_args = array(
    "label" => __('User City', "imic-framework-admin"),
    "singular_label" => __('User City', "imic-framework-admin"),
    'public' => true,
    'hierarchical' => true,
    'show_ui' => true,
    'show_in_nav_menus' => true,
    'args' => array('orderby' => 'term_order'),
    'rewrite' => false,
    'query_var' => true,
	'show_admin_column' => true,
);
register_taxonomy('user-city', 'user', $city_args);
    $labels = array(
        'name' => __('Users Info', 'framework'),
        'singular_name' => __('User','framework'),
        'add_new' => __('Add New', 'framework'),
        'add_new_item' => __('Add New User', 'framework'),
        'edit_item' => __('Edit User', 'framework'),
        'new_item' => __('New User', 'framework'),
        'view_item' => __('View Users', 'framework'),
        'search_items' => __('Search Users', 'framework'),
        'not_found' => __('No users have been added yet', 'framework'),
        'not_found_in_trash' => __('Nothing found in Trash', 'framework'),
        'parent_item_colon' => '',
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'hierarchical' => false,
        'rewrite' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'has_archive' => true,
		'menu_icon' => 'dashicons-businessman',
        'taxonomies' => array('user-role')
    );
     register_post_type('user', $args);
     register_taxonomy_for_object_type('user-role','user');
	 register_taxonomy_for_object_type('user-city','user');
}
?>