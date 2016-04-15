<?php
add_action('init', 'listing_category_register');
function listing_category_register() {
	$listing_permalinks = get_option('imic_property_permalinks');
	$listing_permalink = empty($listing_permalinks['property_structure']) ? _x('cars', 'slug', 'imic-framework-admin') : $listing_permalinks['property_structure'];
    $args_c = array(
    "label" => __('Listings Categories','framework'),
    "singular_label" => __('listing Category','framework'),
    'public' => true,
    'hierarchical' => true,
    'show_ui' => true,
    'show_in_nav_menus' => true,
    'args' => array('orderby' => 'term_order'),
    'rewrite'=> array(
        'slug'=> empty( $listing_permalinks['property_structure'] ) ? _x( 'contract_types', 'slug', 'framework' ) : $listing_permalinks['contract_types'],
		'with_front'=> false,
        'hierarchical'=> true,
    ),
   'query_var' => true,
   'show_admin_column' => true,
);
register_taxonomy('listing-category', array('cars','specification'), $args_c);
register_taxonomy_for_object_type('listing-category','cars');
}