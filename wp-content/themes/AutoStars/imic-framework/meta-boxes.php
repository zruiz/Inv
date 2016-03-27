<?php
/* * ** Meta Box Functions **** */
$prefix = 'imic_';
global $meta_boxes;
load_theme_textdomain('framework', IMIC_FILEPATH . '/language');
$meta_boxes = array();
$meta_boxes[] = array(
    'id' => 'post_page_meta_box',
    'title' => __('Page/Post Header Options', 'framework'),
   'pages' => array('post','page','yachts', 'product'),
    'fields' => array(
		array(
            'name' => __('Choose Header Type', 'framework'),
            'id' => $prefix . 'pages_Choose_slider_display',
            'desc' => __("Select Banner Type.", 'framework'),
            'type' => 'select',
            'options' => array(
					'1' => __('Banner', 'framework'),
				  '2' => __('Banner Image', 'framework'),
                '3' => __('Flex Slider', 'framework'),
					'4' => __('Full Width Carousel','framework'),
					'0' => __('None','framework'),
                '5' => __('Revolution Slider', 'framework'),
            ),
			'std' => 2
        ),
		array(
				'name' => __( 'Banner Color', 'meta-box' ),
				'id' => $prefix.'pages_banner_color',
				'type' => 'color',
				),
		array(
            'name' => __('Banner Image', 'framework'),
            'id' => $prefix . 'header_image',
            'desc' => __("Upload banner image for header for this Page/Post.", 'framework'),
            'type' => 'image_advanced',
            'max_file_uploads' => 1
        ),
		/*array(
            'name' => __('Banner Description', 'framework'),
            'id' => $prefix . 'pages_banner_description',
            'desc' => __("Enter banner description.", 'framework'),
            'type' => 'text',
        ),*/
        array(
                   'name' => __('Select Revolution Slider from list','framework'),
                    'id' => $prefix . 'pages_select_revolution_from_list',
                    'desc' => __("Select Revolution Slider from list", 'framework'),
                    'type' => 'select',
                    'options' => imic_RevSliderShortCode(),
                ),
        //Slider Image
		array(
            'name' => __('Banner/Slider Height', 'framework'),
            'id' => $prefix . 'pages_slider_height',
            'desc' => __("Enter Height for Banner/Slider Ex-265.", 'framework'),
            'type' => 'text',
        ),
        array(
            'name' => __('Slider Image', 'framework'),
            'id' => $prefix . 'pages_slider_image',
            'desc' => __("Enter Slider Image.", 'framework'),
            'type' => 'image_advanced',
        ),
		array(
            'name' => __('Slider Pagination', 'framework'),
            'id' => $prefix . 'pages_slider_pagination',
            'desc' => __("Enable to show pagination for slider.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Enable', 'framework'),
                'no' => __('Disable', 'framework'),
            ),
        ),
		array(
            'name' => __('Slider Auto Slide', 'framework'),
            'id' => $prefix . 'pages_slider_auto_slide',
            'desc' => __("Select Yes to slide automatically.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Yes', 'framework'),
                'no' => __('No', 'framework'),
            ),
        ),
		array(
            'name' => __('Slider Direction Arrows', 'framework'),
            'id' => $prefix . 'pages_slider_direction_arrows',
            'desc' => __("Select Yes to show slider direction arrows.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Yes', 'framework'),
                'no' => __('No', 'framework'),
            ),
        ),
		array(
            'name' => __('Slider Effects', 'framework'),
            'id' => $prefix . 'pages_slider_effects',
            'desc' => __("Select effects for slider.", 'framework'),
            'type' => 'select',
            'options' => array(
                'fade' => __('Fade', 'framework'),
                'slide' => __('Slide', 'framework'),
            ),
        ),
		/*array(
            'name' => __('Slider Effects', 'framework'),
            'id' => $prefix . 'pages_nivo_effects',
            'desc' => __("Select effects for slider.", 'framework'),
            'type' => 'select',
            'options' => array(
                'sliceDown' => __('sliceDown', 'framework'),
                'sliceDownLeft' => __('sliceDownLeft', 'framework'),
				'sliceUp' => __('sliceUp', 'framework'),
                'sliceUpLeft' => __('sliceUpLeft', 'framework'),
				'sliceUpDown' => __('sliceUpDown', 'framework'),
                'sliceUpDownLeft' => __('sliceUpDownLeft', 'framework'),
				'fold' => __('fold', 'framework'),
                'fade' => __('fade', 'framework'),
				'random' => __('random', 'framework'),
                'slideInRight' => __('slideInRight', 'framework'),
				'slideInLeft' => __('slideInLeft', 'framework'),
                'boxRandom' => __('boxRandom', 'framework'),
				'boxRain' => __('boxRain', 'framework'),
				'boxRainReverse' => __('boxRainReverse', 'framework'),
				'boxRainGrow' => __('boxRainGrow', 'framework'),
				'boxRainGrowReverse' => __('boxRainGrowReverse', 'framework'),
            ),
        ),*/
        )
);
/* Contact Page Map Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'template-contact1',
    'title' => __('Banner Options','framework'),
   'pages' => array('page'),
   'show' => array(
// With all conditions below, use this logical operator to combine them. Default is 'OR'. Case insensitive. Optional.
'relation' => 'OR',
// List of page templates (used for page only). Array. Optional.
'template' => array( 'template-contact.php' ),
), 
    'fields' => array(
		array(
            'name' => __('Choose Banner Type', 'framework'),
            'id' => $prefix . 'contact_banner_type',
            'desc' => __("Select Banner Type.", 'framework'),
            'type' => 'select',
            'options' => array(
					'1' => __('Map', 'framework'),
				  '2' => __('Banner Options', 'framework'),
            ),
			'std' => '2'
        ),
		array(
            'name' => __('Address for Map', 'framework'),
            'id' => $prefix . 'contact_map_address',
            'desc' => __("Enter address for map.", 'framework'),
            'type' => 'text',
        ),
        )
);
/* Template Blog Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'template-blog-type',
    'title' => __('Post Select','framework'),
   'pages' => array('page'),
   'show' => array(
// With all conditions below, use this logical operator to combine them. Default is 'OR'. Case insensitive. Optional.
'relation' => 'OR',
// List of page templates (used for page only). Array. Optional.
'template' => array( 'template-blog.php' ),
), 
    'fields' => array(
		array(
            'name' => __('Post', 'framework'),
            'id' => $prefix . 'blog_post_type',
            'desc' => __("Select Post/Review.", 'framework'),
            'type' => 'select',
            'options' => array(
				'0' => __('Both', 'framework'),
				'1' => __('Posts', 'framework'),
				'2' => __('Reviews', 'framework'),
				  
            ),
			'std' => '0'
        ),
        )
);
/* Dealer Search Map Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'template-dealer-search',
    'title' => __('Map Address','framework'),
   'pages' => array('page'),
   'show' => array(
// With all conditions below, use this logical operator to combine them. Default is 'OR'. Case insensitive. Optional.
'relation' => 'OR',
// List of page templates (used for page only). Array. Optional.
'template' => array( 'template-dealer-search.php' ),
), 
    'fields' => array(
		array(
            'name' => __('Address for Map', 'framework'),
            'id' => $prefix . 'dealer_map_address',
            'desc' => __("Enter address for map.", 'framework'),
            'type' => 'text',
        ),
        )
);
/* Gallery & Post Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'gallery_meta_box',
    'title' => __('Gallery Fields', 'framework'),
    'pages' => array('gallery'),
    'fields' => array(
        // Gallery Video Url
        array(
            'name' => __('Video Url', 'framework'),
            'id' => $prefix . 'gallery_video_url',
            'desc' => __("Enter the Youtube or Vimeo URL.", 'framework'),
            'type' => 'url',
        ),
        // Gallery Link Url
        array(
            'name' => __('Link Url', 'framework'),
            'id' => $prefix . 'gallery_link_url',
            'desc' => __("Enter the Link URL.", 'framework'),
            'type' => 'url',
        ),
		array(
            'name' => __('Gallery Images', 'framework'),
            'id' => $prefix . 'gallery_images',
            'desc' => __("Upload images for gallery.", 'framework'),
            'type' => 'image_advanced',
            'max_file_uploads' => 30
        ),
		array(
            'name' => __('Slider Speed', 'framework'),
            'id' => $prefix . 'gallery_slider_speed',
            'desc' => __("Default Slider Speed is 5000.", 'framework'),
            'type' => 'text',
        ),
       array(
            'name' => __('Slider Pagination', 'framework'),
            'id' => $prefix . 'gallery_slider_pagination',
            'desc' => __("Enable to show pagination for slider.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Enable', 'framework'),
                'no' => __('Disable', 'framework'),
            ),
        ),
		array(
            'name' => __('Slider Auto Slide', 'framework'),
            'id' => $prefix . 'gallery_slider_auto_slide',
            'desc' => __("Select Yes to slide automatically.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Yes', 'framework'),
                'no' => __('No', 'framework'),
            ),
        ),
		array(
            'name' => __('Slider Direction Arrows', 'framework'),
            'id' => $prefix . 'gallery_slider_direction_arrows',
            'desc' => __("Select Yes to show slider direction arrows.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Yes', 'framework'),
                'no' => __('No', 'framework'),
            ),
        ),
		array(
            'name' => __('Slider Effects', 'framework'),
            'id' => $prefix . 'gallery_slider_effects',
            'desc' => __("Select effects for slider.", 'framework'),
            'type' => 'select',
            'options' => array(
                'fade' => __('Fade', 'framework'),
                'slide' => __('Slide', 'framework'),
            ),
        ),
        //Audio Display
        array(
            'name' => __('Audio', 'framework'),
            'id' => $prefix . 'gallery_uploaded_audio',
            'desc' => __("Upload Audio.", 'framework'),
            'type' => 'file_input',
        ),
    )
);
/* * **Gallery Page Meta Box1 *** */
$meta_boxes[] = array(
    'id' => 'template-gallery1',
    'title' => __('Gallery Metabox', 'framework'),
	'show' => array(
// With all conditions below, use this logical operator to combine them. Default is 'OR'. Case insensitive. Optional.
'relation' => 'OR',
// List of page templates (used for page only). Array. Optional.
'template' => array( 'template-gallery.php' ),
), 
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
           array(
            'name' => __('Enabled/Disable Sorting  Bar', 'framework'),
            'id' => $prefix . 'gallery_secondary_bar_type_status',
            'desc' => __("Select Enabled to active Sorting  Bar.", 'framework'),
            'type' => 'select',
            'options' => array(
		'1' => __('Enable', 'framework'),
		'0' => __('Disable','framework'),
            ),
	'std' => 0,
        ),
		array(
            'name' => __('Enabled/Disable Pagination', 'framework'),
            'id' => $prefix . 'gallery_page_pagination',
            'desc' => __("Select Enabled to active Pagination.", 'framework'),
            'type' => 'select',
            'options' => array(
		'1' => __('Enable', 'framework'),
		'0' => __('Disable','framework'),
            ),
	'std' => 0,
        ),
		array(
        'name'    => __( 'Gallery Category', 'framework' ),
        'id'      => $prefix . 'advanced_gallery_taxonomy',
        'desc' => __("Choose Gallery Category", 'framework'),
        'type'    => 'taxonomy_advanced',
        'options' => array(
                // Taxonomy name
                'taxonomy' => 'gallery-category',
                'type' => 'select',
                // Additional arguments for get_terms() function. Optional
                'args' => array('orderby' => 'count', 'hide_empty' => true)
                ),
				'std' => '',
            ),
		array(
			'name'  => __('Gallery to show on page', 'framework'),
			'id'    => $prefix."gallery_number_show",
			'desc'  =>  __("Enter number of galleries to show on page, blank will show all Gallery items.", 'framework'),
			'type' => 'text',
		),  
       array(
            'name' => __('Columns Layout', 'framework'),
            'id' => $prefix . 'projects_columns_layout',
            'desc' => __("Select Columns Layout .", 'framework'),
            'type' => 'select',
            'options' => array(
				'3' => __('One Fourth', 'framework'),
				'4' => __('One Third','framework'),
				'6' => __('Half','framework'),
					),
			'std' => 4,
	),
	array(
            'name' => __('Title/Content', 'framework'),
            'id' => $prefix . 'gallery_title_content',
            'desc' => __("Select title or content.", 'framework'),
            'type' => 'select',
            'options' => array(
		'0' => __('None', 'framework'),
		'1' => __('Title','framework'),
		'2' => __('Content','framework'),
		'3' => __('Both','framework'),
            ),
	'std' => 0,
        ),
       ));
/* Contact Page Map Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'template-contact2',
    'title' => __('Contact Options','framework'),
   'pages' => array('page'),
   'show' => array(
// With all conditions below, use this logical operator to combine them. Default is 'OR'. Case insensitive. Optional.
'relation' => 'OR',
// List of page templates (used for page only). Array. Optional.
'template' => array( 'template-contact.php' ),
), 
    'fields' => array(
		array(
            'name' => __('Contact Email', 'framework'),
            'id' => $prefix . 'contact_email',
            'desc' => __("Enter contact email, if left blank admin email will be used.", 'framework'),
            'type' => 'text',
        ),
        )
);
/* Listing Type Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'template-listing4',
    'title' => __('Listing Type','framework'),
   'pages' => array('page'),
   'show' => array(
// With all conditions below, use this logical operator to combine them. Default is 'OR'. Case insensitive. Optional.
'relation' => 'OR',
// List of page templates (used for page only). Array. Optional.
'template' => array( 'template-listing.php' ),
), 
    'fields' => array(
		array(
            'name' => __('Listing Type', 'framework'),
            'id' => $prefix . 'default_listing_type',
            'desc' => __("Select default listing type.", 'framework'),
            'type' => 'select',
            'options' => array(
		'list' => __('List', 'framework'),
		'grid' => __('Grid','framework'),
            ),
	'std' => 'list',
        ),
        )
);
 /* Speaker 
 Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'user_meta_box',
    'title' => __('Social Information', 'framework'),
    'pages' => array('user'),
    'fields' => array(
		array(
            'name' => __('Facebook', 'framework'),
            'id' => $prefix . 'user_facebook',
            'desc' => __("Enter Facebook URL.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Twitter', 'framework'),
            'id' => $prefix . 'user_twitter',
            'desc' => __("Enter Twitter URL.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Google Plus', 'framework'),
            'id' => $prefix . 'user_gplus',
            'desc' => __("Enter Google Plus URL.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Pinterest', 'framework'),
            'id' => $prefix . 'user_pinterest',
            'desc' => __("Enter Pinterest URL.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
    )
);
 /* Speaker Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'team_meta_box',
    'title' => __('Social Information', 'framework'),
    'pages' => array('team'),
    'fields' => array(
		array(
            'name' => __('Email', 'framework'),
            'id' => $prefix . 'staff_member_email',
            'desc' => __("Enter the team member's Email.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
                    'name'  => __('Social Icon', 'framework'),
                    'id'    => $prefix."social_icon_list",
                    'desc'  =>  __('Enter Social Icon and Url.', 'framework'),
                    'type'  => 'text_list',
                    'clone' => true,
                    'options' => array(
                            '0' => __('Social', 'framework'),
                            '1' => __('Url', 'framework'))
                      ),
    )
);
/* Post Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'post_review_meta_box',
    'title' => __('Post Information', 'framework'),
    'pages' => array('post'),
    'fields' => array(
		array(
            'name' => __('Post Section', 'framework'),
            'id' => $prefix . 'select_post_section',
            'desc' => __("Select Post or Review.", 'framework'),
            'type' => 'select',
            'options' => array(
			'1' => __('Post', 'framework'),
			'0' => __('Review','framework'),
            ),
			'std' => 1,
        ),
		array(
                    'name'  => __('Review', 'framework'),
                    'id'    => $prefix."post_review",
                    'desc'  =>  __('Enter Ratings and Features.', 'framework'),
                    'type'  => 'text_list',
                    'clone' => true,
                    'options' => array(
                            '0' => __('Rating', 'framework'),
                            '1' => __('Features', 'framework'))
                      ),
    )
);
$meta_boxes[] = array(
    'id' => 'browse-specification',
    'title' => __('Secondary Bar', 'framework'),
    'pages' => array('page', 'post', 'yachts'),
    'fields' => array(
	array(
            'name' => __('Bar type', 'framework'),
            'id' => $prefix . 'browse_by_specification_switch',
            'desc' => __("Select bar option.", 'framework'),
            'type' => 'select',
            'options' => array(
			'1' => __('Browse/Social Bar', 'framework'),
			'2' => __('Breadcrumb', 'framework'),
			'3' => __('Saved Yachts Bar','framework'),
			'4' => __('Categories Bar','framework'),
			'0' => __('None','framework'),
            ),
			'std' => 1,
        ),
		array(
            'name' => __('Auto Scroll', 'framework'),
            'id' => $prefix . 'browse_by_auto_scroll',
            'desc' => __("Select auto scroll.", 'framework'),
            'type' => 'select',
            'options' => array(
			'1' => __('Yes', 'framework'),
			'0' => __('No', 'framework'),
            ),
			'std' => 1,
        ),
		array(
            'name' => __('Scroll Speed', 'framework'),
            'id' => $prefix . 'browse_by_auto_scroll_speed',
            'desc' => __("Enter scroll speed 1000 = 1sec default is 5000.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Section Title', 'framework'),
            'id' => $prefix . 'browse_by_specification_title',
            'desc' => __("Enter browse by specification title.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
			'name' => __( 'Specifications', 'meta-box' ),
			'id' => $prefix."browse_by_specification",
			'type' => 'post',
			// Post type
			'post_type' => 'specification',
			// Field type, either 'select' or 'select_advanced' (default)
			'field_type' => 'select_advanced',
			'placeholder' => __( 'Select Specification for search', 'meta-box' ),
			// Query arguments (optional). No settings means get all published posts
			'query_args' => array(
			'post_status' => 'publish',
			'posts_per_page' => - 1,
			)
			),
    )
);
$meta_boxes[] = array(
    'id' => 'sort-specification',
    'title' => __('Sort by specification', 'framework'),
    'pages' => array('page'),
	'show' => array(
// With all conditions below, use this logical operator to combine them. Default is 'OR'. Case insensitive. Optional.
'relation' => 'OR',
// List of page templates (used for page only). Array. Optional.
'template' => array( 'template-listing.php' ),
), 
    'fields' => array(
	array(
            'name' => __('Enabled/Disable sort by specification Section', 'framework'),
            'id' => $prefix . 'sort_by_specification_switch',
            'desc' => __("Select Enabled to active Sort by specification section.", 'framework'),
            'type' => 'select',
            'options' => array(
			'1' => __('Enable', 'framework'),
			'0' => __('Disable','framework'),
            ),
			'std' => 1,
        ),
		array(
			'name' => __( 'Specifications', 'meta-box' ),
			'id' => $prefix."sort_by_specification",
			'multiple' => true,
			'desc' => __("Select integer specification for sorting.", 'framework'),
			'type' => 'post',
			// Post type
			'post_type' => 'specification',
			// Field type, either 'select' or 'select_advanced' (default)
			'field_type' => 'select_advanced',
			'placeholder' => __( 'Select Specification for search', 'meta-box' ),
			// Query arguments (optional). No settings means get all published posts
			'query_args' => array(
			'post_status' => 'publish',
			'posts_per_page' => - 1,
			)
			),
    )
);
  /* Speaker Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'template-home1',
    'title' => __('Yacht Section', 'framework'),
    'pages' => array('page'),
	 'show' => array(
// With all conditions below, use this logical operator to combine them. Default is 'OR'. Case insensitive. Optional.
'relation' => 'OR',
// List of page templates (used for page only). Array. Optional.
'template' => array( 'template-home.php', 'template-home-second.php', 'template-home-third.php' ),
), 
    'fields' => array(
		array(
            'name' => __('Enabled/Disable Yacht Listing', 'framework'),
            'id' => $prefix . 'home_vehicle_switch',
            'desc' => __("Select Enabled to active Yacht Listing.", 'framework'),
            'type' => 'select',
            'options' => array(
			'1' => __('Enable', 'framework'),
			'0' => __('Disable','framework'),
            ),
			'std' => 1,
        ),
		array(
            'name' => __('Auto Scroll', 'framework'),
            'id' => $prefix . 'home_vehicle_auto_scroll',
            'desc' => __("Select auto scroll.", 'framework'),
            'type' => 'select',
            'options' => array(
			'1' => __('Yes', 'framework'),
			'0' => __('No', 'framework'),
            ),
			'std' => '1',
        ),
		array(
            'name' => __('Scroll Speed', 'framework'),
            'id' => $prefix . 'home_vehicle_auto_scroll_speed',
            'desc' => __("Enter scroll speed 1000 = 1sec default is 5000.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Section Title', 'framework'),
            'id' => $prefix . 'home_vehicle_title',
            'desc' => __("Enter Yacht section title.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Column', 'framework'),
            'id' => $prefix . 'home_vehicle_column',
            'desc' => __("Select Column Layout.", 'framework'),
            'type' => 'select',
            'options' => array(
				'6' => __('Six Columns','framework'),
				'4' => __('Four Columns', 'framework'),
				'3' => __('Three Columns','framework'),
				'2' => __('Two Columns','framework'),
					),
			'std' => 3,
        ),
		array(
            'name' => __('Yacht Count', 'framework'),
            'id' => $prefix . 'home_vehicle_count',
            'desc' => __("Select the yacht count.", 'framework'),
			'type' => 'select',
            'options' => array(
				'1' => __('1','framework'),
				'2' => __('2', 'framework'),
				'3' => __('3','framework'),
				'4' => __('4','framework'),
				'5' => __('5','framework'),
				'6' => __('6', 'framework'),
				'7' => __('7','framework'),
				'8' => __('8','framework'),
				'9' => __('9','framework'),
				'10' => __('10', 'framework'),
				'11' => __('11','framework'),
				'12' => __('12','framework'),
				'13' => __('13','framework'),
				'14' => __('14', 'framework'),
				'15' => __('15','framework'),
				'16' => __('16','framework'),
				'17' => __('17','framework'),
				'18' => __('18', 'framework'),
				'19' => __('19','framework'),
				'20' => __('20','framework'),
					),
			'std' => 4,
        ),
    )
);
$meta_boxes[] = array(
		'title' => __( 'Details', 'rwmb' ),
		 'pages' => array('page'),
		 'show' => array(
// With all conditions below, use this logical operator to combine them. Default is 'OR'. Case insensitive. Optional.
'relation' => 'OR',
// List of page templates (used for page only). Array. Optional.
'template' => array( 'template-home-second.php' ),
), 
		 
		'fields' => array(
		array(
            'name' => __('Enabled/Disable Details Section', 'framework'),
            'id' => $prefix . 'home_details_switch',
            'desc' => __("Select Enabled to active Details Section.", 'framework'),
            'type' => 'select',
            'options' => array(
			'1' => __('Enable', 'framework'),
			'0' => __('Disable','framework'),
            ),
			'std' => 1,
        ),
		array(
            'name' => __('Column', 'framework'),
            'id' => $prefix . 'home_details_column',
            'desc' => __("Select Column Layout.", 'framework'),
            'type' => 'select',
            'options' => array(
				'3' => __('Four Columns', 'framework'),
				'4' => __('Three Columns','framework'),
				'6' => __('Two Columns','framework'),
					),
			'std' => 3,
        ),
		array(
			'name'  => __('Secondry Shortcode', 'framework'),
			'id'    => $prefix."secondary_shortcode",
			'desc'  =>  __("Enter Shortcode.", 'framework'),
			'type' =>  'wysiwyg',
                        'options' => array(
                        'textarea_rows' => 4,
                        'teeny'         => false,
                        'media_buttons' => true,
						'tinymce'		=> true,
				),
		),
			array(
			'id' => 'details_tabs',
			'name' => __( '', 'rwmb' ),
			'type' => 'group', // Group type
			'clone' => true, // Can be cloned?
			// List of child fields
			'fields' => array(
		array(
            'name' => __('Title', 'framework'),
            'id' => $prefix . 'details_tabs_title',
                'desc' => __("Enter title for tabs.", 'framework'),
            'type' => 'text',
			'clone' => false,
            'std' => '',
			'columns' => 6, // Display child field in grid columns
        ),
		array(
            'name' => __('URL', 'framework'),
            'id' => $prefix . 'details_tabs_url',
                'desc' => __("Enter URL for tabs.", 'framework'),
            'type' => 'text',
			'clone' => false,
            'std' => '',
			'columns' => 6, // Display child field in grid columns
        ),
		
array(
            'name' => __('Image', 'framework'),
            'id' => $prefix . 'details_tabs_image',
            'desc' => __("Insert details tabs image.", 'framework'),
            'type' => 'file_input',
			'clone' => false,
            'std' => '',
			'columns' => 6, // Display child field in grid columns
        ),
		array(
'name' => __( 'Content', 'framework' ),
'id' => $prefix."details_tabs_content",
'type' => 'textarea',
'columns' => 6, // Display child field in grid columns
),
		))),
);
$meta_boxes[] = array(
		'title' => __( 'Extra Tabs', 'rwmb' ),
		 'pages' => array('yachts'), 
		 'id' => 'yachts-tabs',
		'fields' => array(
		array(
			'name'  => __('Tab Area 1', 'framework'),
			'id'    => $prefix."tab_area1",
			'desc'  =>  __("Use this area in Theme Options by adding [tab-area1], to show in details page.", 'framework'),
			'type' =>  'wysiwyg',
                        'options' => array(
                        'textarea_rows' => 2,
                        'teeny'         => false,
                        'media_buttons' => true,
						'tinymce'		=> true,
				),
			),
		array(
			'name'  => __('Tab Area 2', 'framework'),
			'id'    => $prefix."tab_area2",
			'desc'  =>  __("Use this area in Theme Options by adding [tab-area2], to show in details page.", 'framework'),
			'type' =>  'wysiwyg',
                        'options' => array(
                        'textarea_rows' => 2,
                        'teeny'         => false,
                        'media_buttons' => true,
						'tinymce'		=> true,
				),
			),
		array(
			'name'  => __('Tab Area 3', 'framework'),
			'id'    => $prefix."tab_area3",
			'desc'  =>  __("Use this area in Theme Options by adding [tab-area3], to show in details page.", 'framework'),
			'type' =>  'wysiwyg',
                        'options' => array(
                        'textarea_rows' => 2,
                        'teeny'         => false,
                        'media_buttons' => true,
						'tinymce'		=> true,
				),
			),
		array(
			'name'  => __('Tab Area 4', 'framework'),
			'id'    => $prefix."tab_area4",
			'desc'  =>  __("Use this area in Theme Options by adding [tab-area4], to show in details page.", 'framework'),
			'type' =>  'wysiwyg',
                        'options' => array(
                        'textarea_rows' => 2,
                        'teeny'         => false,
                        'media_buttons' => true,
						'tinymce'		=> true,
				),
			),
		),
);
  /* Blog Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'template-blog1',
    'title' => __('Blog Section', 'framework'),
    'pages' => array('page'),
	 'show' => array(
// With all conditions below, use this logical operator to combine them. Default is 'OR'. Case insensitive. Optional.
'relation' => 'OR',
// List of page templates (used for page only). Array. Optional.
'template' => array( 'template-blog.php'),
), 
    'fields' => array(
		array(
            'name' => __('Blog Layout', 'framework'),
            'id' => $prefix . 'blog_layout',
            'desc' => __("Select blog layout.", 'framework'),
            'type' => 'select',
            'options' => array(
			'1' => __('Classic', 'framework'),
			'0' => __('Masonry','framework'),
            ),
			'std' => 1,
        ),
		array(
            'name' => __('Column', 'framework'),
            'id' => $prefix . 'blog_column',
            'desc' => __("Select Column Layout.", 'framework'),
            'type' => 'select',
            'options' => array(
				'6' => __('Six Columns','framework'),
				'4' => __('Four Columns', 'framework'),
				'3' => __('Three Columns','framework'),
				'2' => __('Two Columns','framework'),
					),
			'std' => 3,
        ),
		array(
            'name' => __('Post Count', 'framework'),
            'id' => $prefix . 'blog_post_count',
            'desc' => __("Select the post count.", 'framework'),
			'type' => 'select',
            'options' => array(
				'1' => __('1','framework'),
				'2' => __('2', 'framework'),
				'3' => __('3','framework'),
				'4' => __('4','framework'),
				'5' => __('5','framework'),
				'6' => __('6', 'framework'),
				'7' => __('7','framework'),
				'8' => __('8','framework'),
				'9' => __('9','framework'),
				'10' => __('10', 'framework'),
				'11' => __('11','framework'),
				'12' => __('12','framework'),
				'13' => __('13','framework'),
				'14' => __('14', 'framework'),
				'15' => __('15','framework'),
				'16' => __('16','framework'),
				'17' => __('17','framework'),
				'18' => __('18', 'framework'),
				'19' => __('19','framework'),
				'20' => __('20','framework'),
					),
			'std' => 4,
        ),
    )
);
$meta_boxes[] = array(
    'id' => 'template-home2',
    'title' => __('Latest News Section', 'framework'),
    'pages' => array('page'),
	'show' => array(
// With all conditions below, use this logical operator to combine them. Default is 'OR'. Case insensitive. Optional.
'relation' => 'OR',
// List of page templates (used for page only). Array. Optional.
'template' => array( 'template-home.php', 'template-home-second.php' ),
), 
    'fields' => array(
		array(
            'name' => __('Enabled/Disable Latest News', 'framework'),
            'id' => $prefix . 'home_news_switch',
            'desc' => __("Select Enabled to active Latest News.", 'framework'),
            'type' => 'select',
            'options' => array(
			'1' => __('Enable', 'framework'),
			'0' => __('Disable','framework'),
            ),
			'std' => 1,
        ),
		array(
            'name' => __('Auto Scroll', 'framework'),
            'id' => $prefix . 'home_news_auto_scroll',
            'desc' => __("Select auto scroll.", 'framework'),
            'type' => 'select',
            'options' => array(
			'1' => __('Yes', 'framework'),
			'0' => __('No', 'framework'),
            ),
			'std' => '1',
        ),array(
            'name' => __('Scroll Speed', 'framework'),
            'id' => $prefix . 'home_news_auto_scroll_speed',
            'desc' => __("Enter scroll speed 1000 = 1sec default is 5000.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Section Title', 'framework'),
            'id' => $prefix . 'home_news_title',
            'desc' => __("Enter Yacht section title.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('All News Title', 'framework'),
            'id' => $prefix . 'home_allnews_title',
            'desc' => __("Enter Yacht section title.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('All News URL', 'framework'),
            'id' => $prefix . 'home_allnews_url',
            'desc' => __("Enter Yacht section title.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('News Count', 'framework'),
            'id' => $prefix . 'home_news_count',
            'desc' => __("Select the News count.", 'framework'),
			'type' => 'select',
            'options' => array(
				'1' => __('1','framework'),
				'2' => __('2', 'framework'),
				'3' => __('3','framework'),
				'4' => __('4','framework'),
				'5' => __('5','framework'),
				'6' => __('6', 'framework'),
				'7' => __('7','framework'),
				'8' => __('8','framework'),
				'9' => __('9','framework'),
				'10' => __('10', 'framework'),
				'11' => __('11','framework'),
				'12' => __('12','framework'),
				'13' => __('13','framework'),
				'14' => __('14', 'framework'),
				'15' => __('15','framework'),
				'16' => __('16','framework'),
				'17' => __('17','framework'),
				'18' => __('18', 'framework'),
				'19' => __('19','framework'),
				'20' => __('20','framework'),
					),
			'std' => 4,
        ),
    )
);
	
$meta_boxes[] = array(
    'id' => 'template-home3',
    'title' => __('Testimonial Section', 'framework'),
    'pages' => array('page'),
	'show' => array(
// With all conditions below, use this logical operator to combine them. Default is 'OR'. Case insensitive. Optional.
'relation' => 'OR',
// List of page templates (used for page only). Array. Optional.
'template' => array('template-home.php'),
), 
    'fields' => array(
		array(
            'name' => __('Enabled/Disable Testimonial Section', 'framework'),
            'id' => $prefix . 'home_testimonial_switch',
            'desc' => __("Select Enabled to active Testimonial Section.", 'framework'),
            'type' => 'select',
            'options' => array(
			'1' => __('Enable', 'framework'),
			'0' => __('Disable','framework'),
            ),
			'std' => 1,
        ),
		array(
            'name' => __('Auto Scroll', 'framework'),
            'id' => $prefix . 'home_testimonial_auto_scroll',
            'desc' => __("Select auto scroll.", 'framework'),
            'type' => 'select',
            'options' => array(
			'1' => __('Yes', 'framework'),
			'0' => __('No', 'framework'),
            ),
			'std' => '1',
        ),
		array(
            'name' => __('Scroll Speed', 'framework'),
            'id' => $prefix . 'home_testimonial_auto_scroll_speed',
            'desc' => __("Enter scroll speed 1000 = 1sec default is 5000.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Section Title', 'framework'),
            'id' => $prefix . 'home_testimonial_title',
            'desc' => __("Enter Testimonial section title.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Testimonial Count', 'framework'),
            'id' => $prefix . 'home_testimonial_count',
            'desc' => __("Select the Testimonials count.", 'framework'),
			'type' => 'select',
            'options' => array(
				'1' => __('1','framework'),
				'2' => __('2', 'framework'),
				'3' => __('3','framework'),
				'4' => __('4','framework'),
				'5' => __('5','framework'),
				'6' => __('6', 'framework'),
				'7' => __('7','framework'),
				'8' => __('8','framework'),
				'9' => __('9','framework'),
				'10' => __('10', 'framework'),
				'11' => __('11','framework'),
				'12' => __('12','framework'),
				'13' => __('13','framework'),
				'14' => __('14', 'framework'),
				'15' => __('15','framework'),
				'16' => __('16','framework'),
				'17' => __('17','framework'),
				'18' => __('18', 'framework'),
				'19' => __('19','framework'),
				'20' => __('20','framework'),
					),
			'std' => 4,
        ),
    )
);
$meta_boxes[] = array(
    'id' => 'template-home4',
    'title' => __('Top Seller Section', 'framework'),
    'pages' => array('page'),
	 'show' => array(
// With all conditions below, use this logical operator to combine them. Default is 'OR'. Case insensitive. Optional.
'relation' => 'OR',
// List of page templates (used for page only). Array. Optional.
'template' => array('template-home-second.php' ),
), 
    'fields' => array(
		array(
            'name' => __('Enabled/Disable Top Seller Section', 'framework'),
            'id' => $prefix . 'home_seller_section',
            'desc' => __("Select Enabled to active Seller Section.", 'framework'),
            'type' => 'select',
            'options' => array(
			'1' => __('Enable', 'framework'),
			'0' => __('Disable','framework'),
            ),
			'std' => 1,
        ),
		array(
            'name' => __('Auto Scroll', 'framework'),
            'id' => $prefix . 'home_seller_auto_scroll',
            'desc' => __("Select auto scroll.", 'framework'),
            'type' => 'select',
            'options' => array(
			'1' => __('Yes', 'framework'),
			'0' => __('No', 'framework'),
            ),
			'std' => '1',
        ),
		array(
            'name' => __('Scroll Speed', 'framework'),
            'id' => $prefix . 'home_seller_auto_scroll_speed',
            'desc' => __("Enter scroll speed 1000 = 1sec default is 5000.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Parallax Image', 'framework'),
            'id' => $prefix.'home_seller_parallax_image',
            'desc' => __("Select Parallax Image", 'framework'),
            'type' => 'image_advanced',
        ),
		array(
            'name' => __('Section Title', 'framework'),
            'id' => $prefix . 'home_seller_title',
            'desc' => __("Enter Top Seller section title.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Seller Count', 'framework'),
            'id' => $prefix . 'home_seller_count',
            'desc' => __("Select the Seller count.", 'framework'),
			'type' => 'select',
            'options' => array(
				'1' => __('1','framework'),
				'2' => __('2', 'framework'),
				'3' => __('3','framework'),
				'4' => __('4','framework'),
				'5' => __('5','framework'),
				'6' => __('6', 'framework'),
				'7' => __('7','framework'),
				'8' => __('8','framework'),
				'9' => __('9','framework'),
				'10' => __('10', 'framework'),
				'11' => __('11','framework'),
				'12' => __('12','framework'),
				'13' => __('13','framework'),
				'14' => __('14', 'framework'),
				'15' => __('15','framework'),
				'16' => __('16','framework'),
				'17' => __('17','framework'),
				'18' => __('18', 'framework'),
				'19' => __('19','framework'),
				'20' => __('20','framework'),
					),
			'std' => 4,
        ),
		
    )
);
$meta_boxes[] = array(
    'id' => 'template-home6',
    'title' => __('Search by specification', 'framework'),
    'pages' => array('page'),
	'show' => array(
// With all conditions below, use this logical operator to combine them. Default is 'OR'. Case insensitive. Optional.
'relation' => 'OR',
// List of page templates (used for page only). Array. Optional.
'template' => array('template-home.php', 'template-home-second.php' ),
), 
    'fields' => array(
	array(
            'name' => __('Enabled/Disable Search by specification Section', 'framework'),
            'id' => $prefix . 'search_by_specification_switch',
            'desc' => __("Select Enabled to active Search by specification section.", 'framework'),
            'type' => 'select',
            'options' => array(
			'1' => __('Enable', 'framework'),
			'0' => __('Disable','framework'),
            ),
			'std' => 1,
        ),
		array(
            'name' => __('Auto Scroll', 'framework'),
            'id' => $prefix . 'home_search_specification_auto_scroll',
            'desc' => __("Select auto scroll.", 'framework'),
            'type' => 'select',
            'options' => array(
			'1' => __('Yes', 'framework'),
			'0' => __('No', 'framework'),
            ),
			'std' => '1',
        ),
		array(
            'name' => __('Scroll Speed', 'framework'),
            'id' => $prefix . 'home_search_specification_auto_scroll_speed',
            'desc' => __("Enter scroll speed 1000 = 1sec default is 5000.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Section Title', 'framework'),
            'id' => $prefix . 'search_by_specification_title',
            'desc' => __("Enter search by specification title.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Section URL', 'framework'),
            'id' => $prefix . 'search_by_specification_url',
            'desc' => __("Enter all yachts URL.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
			'name' => __( 'Specifications', 'meta-box' ),
			'id' => $prefix."search_by_specification",
			'type' => 'post',
			// Post type
			'post_type' => 'specification',
			// Field type, either 'select' or 'select_advanced' (default)
			'field_type' => 'select_advanced',
			'placeholder' => __( 'Select Specification for search', 'meta-box' ),
			// Query arguments (optional). No settings means get all published posts
			'query_args' => array(
			'post_status' => 'publish',
			'posts_per_page' => - 1,
			)
			),
    )
);
$meta_boxes[] = array(
		'title' => __( 'Pricing Options', 'rwmb' ),
		 'pages' => array('page'),
		 'show' => array(
// With all conditions below, use this logical operator to combine them. Default is 'OR'. Case insensitive. Optional.
'relation' => 'OR',
// List of page templates (used for page only). Array. Optional.
'template' => array( 'template-home-third.php' ),
), 
		 
		'fields' => array(
		array(
            'name' => __('Enabled/Disable Pricing Section', 'framework'),
            'id' => $prefix . 'home_pricing_switch',
            'desc' => __("Select Enabled to active Pricing Section.", 'framework'),
            'type' => 'select',
            'options' => array(
			'1' => __('Enable', 'framework'),
			'0' => __('Disable','framework'),
            ),
			'std' => 1,
        ),	
		array(
            'name' => __('Section Title', 'framework'),
            'id' => $prefix . 'home_pricing_title',
            'desc' => __("Enter Pricing section title.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Column', 'framework'),
            'id' => $prefix . 'home_pricing_column',
            'desc' => __("Select Column Layout.", 'framework'),
            'type' => 'select',
            'options' => array(
			'two' => __('Two Columns','framework'),
				'three' => __('Three Columns', 'framework'),
				'four' => __('Four Columns','framework'),
					),
			'std' => "three",
        ),
		)
);
$meta_boxes[] = array(
    'id' => 'template-home8',
    'title' => __('Parallax Section', 'framework'),
    'pages' => array('page'),
	 'show' => array(
// With all conditions below, use this logical operator to combine them. Default is 'OR'. Case insensitive. Optional.
'relation' => 'OR',
// List of page templates (used for page only). Array. Optional.
'template' => array('template-home-third.php' ),
), 
    'fields' => array(
		array(
            'name' => __('Enabled/Disable Parallax Section', 'framework'),
            'id' => $prefix . 'home_third_parallax_section',
            'desc' => __("Select Enabled to active Parallax Section.", 'framework'),
            'type' => 'select',
            'options' => array(
			'1' => __('Enable', 'framework'),
			'0' => __('Disable','framework'),
            ),
			'std' => 1,
        ),
		array(
            'name' => __('Parallax Image', 'framework'),
            'id' => $prefix.'home_third_parallax_image',
            'desc' => __("Select Parallax Image", 'framework'),
            'type' => 'image_advanced',
        ),
		array(
			'name'  => __('Shortcode', 'framework'),
			'id'    => $prefix."home_third_shortcode",
			'desc'  =>  __("Enter Shortcode.", 'framework'),
			'type' =>  'wysiwyg',
                        'options' => array(
                        'textarea_rows' => 4,
                        'teeny'         => false,
                        'media_buttons' => true,
						'tinymce'		=> true,
				),
		),
		
    )
);
$meta_boxes[] = array(
    'id' => 'user-details',
    'title' => __('User Information', 'framework'),
    'pages' => array('user'),
    'fields' => array(
		array(
            'name' => __('User ID', 'framework'),
            'id' => $prefix . 'user_reg_id',
            'desc' => __("User Registration ID, please do not edit this field until required.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Sold Yachts', 'framework'),
            'id' => $prefix . 'user_sold_cars',
            'desc' => __("Number of listings sold by this user.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('City', 'framework'),
            'id' => $prefix . 'user_city',
            'desc' => __("User City.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Pin Code', 'framework'),
            'id' => $prefix . 'user_zip_code',
            'desc' => __("User Zip code.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
             'id' => $prefix . 'user_lat_long',
			'name' => __( 'Location', 'meta-box' ),
			'type' => 'map',
			'std' => '-6.233406,-35.049906,15', // 'latitude,longitude[,zoom]' (zoom is optional)
			'style' => 'width: 500px; height: 400px',
			'address_field' => 'imic_user_zip_code', // Name of text field where address is entered. Can be list of text fields, separated by commas (for ex. city, state)
			),
		array(
            'name' => __('Company', 'framework'),
            'id' => $prefix . 'user_company',
            'desc' => __("User company name.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('User Company Tagline', 'framework'),
            'id' => $prefix . 'user_company_tagline',
            'desc' => __("User Company Tagline.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('User Website', 'framework'),
            'id' => $prefix . 'user_website',
            'desc' => __("User Website.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('User Telephone', 'framework'),
            'id' => $prefix . 'user_telephone',
            'desc' => __("User Telephone.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('User Banner', 'framework'),
            'id' => $prefix.'user_logo',
            'desc' => __("User Logo", 'framework'),
            'type' => 'image_advanced',
        ),
		/*array(
            'name' => __('Prosite', 'framework'),
            'id' => $prefix . 'user_prosite',
            'desc' => __("Activate prosite.", 'framework'),
            'type' => 'select',
            'options' => array(
			'1' => __('Enable', 'framework'),
			'0' => __('Disable','framework'),
            ),
			'std' => 0,
        ),
		array(
            'name' => __('Private Listing', 'framework'),
            'id' => $prefix . 'show_private_listing',
            'desc' => __("Allow to view private listings", 'framework'),
            'type' => 'select',
            'options' => array(
			'1' => __('Yes', 'framework'),
			'0' => __('No','framework'),
            ),
			'std' => 1,
        ),*/
		
    )
);
$meta_boxes[] = array(
    'id' => 'testimonial-details',
    'title' => __('Testimonial Information', 'framework'),
    'pages' => array('testimonial'),
    'fields' => array(
		array(
            'name' => __('Company', 'framework'),
            'id' => $prefix . 'company_name',
            'desc' => __("Enter Company Name.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Company URL', 'framework'),
            'id' => $prefix . 'company_url',
            'desc' => __("Enter Company URL", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		
    )
);
$meta_boxes[] = array(
    'id' => 'plans-details',
    'title' => __('Plan Information', 'framework'),
    'pages' => array('plan'),
    'fields' => array(
		array(
            'name' => __('Price', 'framework'),
            'id' => $prefix . 'plan_price',
            'desc' => __("Enter Plan Price.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Currency', 'framework'),
            'id' => $prefix . 'plan_currency',
            'desc' => __("Enter Plan Currency.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
        array(
            'name' => __('Currency Position', 'framework'),
            'id' => $prefix . 'plan_currency_position',
            'desc' => __("Select Position of Currency.", 'framework'),
            'type' => 'select',
            'options' => array(
            '1' => __('Prefix', 'framework'),
            '0' => __('Postfix','framework'),
            ),
            'std' => 1,
        ),
		array(
            'name' => __('Enabled/Disable Premium Badge', 'framework'),
            'id' => $prefix . 'pricing_premium_badge',
            'desc' => __("Select Enabled to have Primium Badge.", 'framework'),
            'type' => 'select',
            'options' => array(
			'1' => __('Enable', 'framework'),
			'0' => __('Disable','framework'),
            ),
			'std' => 0,
        ),
		/*array(
            'name' => __('Show Hide Contact Details', 'framework'),
            'id' => $prefix . 'pricing_hide_contacts',
            'desc' => __("Select Hide to make contact details private.", 'framework'),
            'type' => 'select',
            'options' => array(
			'1' => __('Show', 'framework'),
			'0' => __('Hide','framework'),
            ),
			'std' => 1,
        ),*/
		array(
            'name' => __('Highlighted', 'framework'),
            'id' => $prefix . 'pricing_highlight',
            'desc' => __("Select Yes to highlight this plan.", 'framework'),
            'type' => 'select',
            'options' => array(
			'0' => __('No', 'framework'),
			'1' => __('Yes','framework'),
            ),
			'std' => 0,
        ),
		array(
            'name' => __('Advantage', 'framework'),
            'id' => $prefix . 'plan_advantage',
            'desc' => __("Enter Plan Advantage.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
    )
);
$meta_boxes[] = array(
    'id' => 'plans-details1',
    'title' => __('Periodic Listing', 'framework'),
    'pages' => array('plan'),
    'fields' => array(
		array(
            'name' => __('Number of Days', 'framework'),
            'id' => $prefix . 'days_periodic_listing',
            'desc' => __("Enter number of days for listing active, Ex-10.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
    )
);
/* * ******************* META BOX REGISTERING ********************** */
/**
 * Register meta boxes
 *
 * @return void
 */
function imic_register_meta_boxes() {
    global $meta_boxes;
    // Make sure there's no errors when the plugin is deactivated or during upgrade
    if (class_exists('RW_Meta_Box')) {
        foreach ($meta_boxes as $meta_box) {
            new RW_Meta_Box($meta_box);
        }
    }
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking Page template, categories, etc.
add_action('admin_init', 'imic_register_meta_boxes');
/* * ******************* META BOX CHECK ********************** */
/**
 * Check if meta boxes is included
 *
 * @return bool
 */
function rw_maybe_include($template_file) {
    // Include in back-end only
    if (!defined('WP_ADMIN') || !WP_ADMIN)
        return false;
    // Always include for ajax
    if (defined('DOING_AJAX') && DOING_AJAX)
        return true;
    // Check for post IDs
    $checked_post_IDs = array();
    if (isset($_GET['post']))
        $post_id = $_GET['post'];
    elseif (isset($_POST['post_ID']))
        $post_id = $_POST['post_ID'];
    else
        $post_id = false;
    $post_id = (int) $post_id;
    if (in_array($post_id, $checked_post_IDs))
        return true;
    // Check for Page template
    $checked_templates = array($template_file);
    $template = get_post_meta($post_id, '_wp_page_template', true);
    if (in_array($template, $checked_templates))
        return true;
// If no condition matched
    return false;
}
?>