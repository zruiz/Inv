<?php
/* ==================================================
  Cars Post Type Functions
  ================================================== */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
add_action('init', 'cars_register');
add_action( 'init', 'cars_specification' );
function cars_specification()
{
	$labels = array(
        'name' => __('Listing Specifications', 'imic-listing'),
        'singular_name' => __('Listing Specification','imic-listing'),
        'add_new' => __('Add New', 'imic-listing'),
        'add_new_item' => __('Add New Specification', 'imic-listing'),
        'edit_item' => __('Edit Specification', 'imic-listing'),
        'new_item' => __('New Specification', 'imic-listing'),
        'view_item' => __('View Specification', 'imic-listing'),
        'search_items' => __('Search Specification', 'imic-listing'),
        'not_found' => __('No specifications have been added yet', 'imic-listing'),
        'not_found_in_trash' => __('Nothing found in Trash', 'imic-listing'),
        'parent_item_colon' => '',
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => 'edit.php?post_type=yachts',
        'show_in_nav_menus' => true,
        'hierarchical' => false,
        'rewrite' => true,
        'supports' => array('title'),
        'has_archive' => true,
		'menu_icon' => 'dashicons-editor-ul',
    );
     register_post_type('specification', $args);
}
function cars_register() {
	$listing_permalinks = get_option('imic_property_permalinks');
	$listing_permalink = empty($listing_permalinks['property_structure']) ? _x('yachts', 'slug', 'imic-framework-admin') : $listing_permalinks['property_structure'];
    $tags = array(
    "label" => __('Listing Features','imic-listing'),
    "singular_label" => __('Listing Feature','imic-listing'),
    'public' => true,
    'hierarchical' => false,
    'show_ui' => true,
    'show_in_nav_menus' => true,
    'args' => array('orderby' => 'term_order'),
    'rewrite'=> array(
        'slug'=> empty( $listing_permalinks['property_structure'] ) ? _x( 'yachts-tag', 'slug', 'framework' ) : $listing_permalinks['type_base'],
        'with_front'=> false,
        'hierarchical'=> true,
    ),
   'query_var' => true,
   'show_admin_column' => true,
);
register_taxonomy('yachts-tag', 'yachts',$tags);
    $labels = array(
        'name' => __('Listings', 'imic-listing'),
        'singular_name' => __('Listing','imic-listing'),
        'add_new' => __('Add New', 'imic-listing'),
        'add_new_item' => __('Add New Listing', 'imic-listing'),
        'edit_item' => __('Edit Listing', 'imic-listing'),
        'new_item' => __('New Listing', 'imic-listing'),
        'view_item' => __('View Listing', 'imic-listing'),
        'search_items' => __('Search Listings', 'imic-listing'),
        'not_found' => __('No listings have been added yet', 'imic-listing'),
        'not_found_in_trash' => __('Nothing found in Trash', 'imic-listing'),
        'parent_item_colon' => '',
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'hierarchical' => false,
        'rewrite' => $listing_permalink != "yachts" ? array(
            'slug' => untrailingslashit($listing_permalink),
            'with_front' => false,
            'feeds' => true) : false,
        'supports' => array('editor', 'thumbnail', 'author', 'title'),
        'has_archive' => true,
		'menu_icon' => 'dashicons-media-text',
        'taxonomies' => array('yachts-category')
    );
     register_post_type('yachts', $args);
	 register_taxonomy_for_object_type('yachts-tag','yachts');
}
?>