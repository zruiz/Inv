<?php
       load_theme_textdomain('imic-framework-admin', IMIC_FILEPATH. '/language/');
	// Create TinyMCE's editor button & plugin for IMIC Framework Shortcodes
	add_action('init', 'imic_sc_button'); 
	
	function imic_sc_button() {  
	   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )  
	   {  
	     add_filter('mce_external_plugins', 'imic_add_tinymce_plugin');  
	     add_filter('mce_buttons', 'imic_register_shortcode_button');  
	   }  
	} 
	
	function imic_register_shortcode_button($button) {  
	    array_push($button, 'separator', 'imicframework_shortcodes' );  
	    return $button;  
	}
	
	function imic_add_tinymce_plugin($plugins) {  
	    $plugins['imicframework_shortcodes'] = get_template_directory_uri() . '/imic-framework/imic-shortcodes/imic-tinymce.editor.plugin.js';  
	    return $plugins;  
	} 
	
	
	
	/* ==================================================
	
	SHORTCODES OUTPUT
	
	================================================== */
	
	/* STAFF SHORTCODE
	================================================== */
	
	function imic_staff($atts, $content = null) {
		extract(shortcode_atts(array(
			"title" => "",
			"number" => "",
			"column" => 4,
		), $atts));
		
		$output = '';
		if(is_plugin_active("imithemes-listing/listing.php")) {
			$args_team = array('post_type'=>'team','posts_per_page'=>$number);
			$output .= '<hr class="fw">
                <div class="text-align-center"><h2 class="uppercase">'.$title.'</h2></div>
                <div class="spacer-20"></div>
            	<div class="row">
				<ul class="sort-destination gallery-grid" data-sort-id="gallery">';
        	$team_listing = new WP_Query( $args_team );
			if ( $team_listing->have_posts() ) :
			while ( $team_listing->have_posts() ) :	
			$team_listing->the_post();
			$social = imic_social_staff_icon();
			$output .= '<li class="col-md-'.$column.' col-sm-'.$column.' grid-item format-image">
                        <div class="grid-item-inner">
                            <a data-toggle="modal" data-target="#team-modal-'.(get_the_ID()+2648).'" href="#" class="media-box"> '.get_the_post_thumbnail(get_the_ID(),'600x400').' </a>
                            <div class="grid-content">
                                <h3 class="post-title"><a data-toggle="modal" data-target="#team-modal-'.(get_the_ID()+2648).'" href="#" class="">'.get_the_title().'</a></h3><p>'.imic_excerpt(10).'</p>'.$social.'</div>
                        </div>
                    </li>';
				$output .= '<div class="modal fade team-modal" id="team-modal-'.(get_the_ID()+2648).'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">'.__('Team Members','framework').'</h4>
                          </div>
                            <div class="modal-body">
                                <div class="staff-item">
                                <div class="row">
                                    <div class="col-md-5 col-sm-6">
                                    	'.get_the_post_thumbnail(get_the_ID(),'600x400',array('class'=>'img-thumbnail')).'
                                    </div>
                                    <div class="col-md-7 col-sm-6">
                                    	<h3>'.get_the_title().'</h3>';
                                        $post_id = get_post(get_the_ID());
											$content = $post_id->post_content;
											$content = apply_filters('the_content', $content);
											$content = str_replace(']]>', ']]>', $content);
											$output .= $content;
                                    $output .= '</div>
                                </div>
                            </div>
                            </div>
                        </div>
                      </div>
                    </div>';
			endwhile; endif; 
                    $output .= '</ul></div>';
		wp_reset_postdata(); }
		return $output;
	}
	add_shortcode('staff', 'imic_staff');
	
	/* DEALERS SHORTCODE
	================================================== */
	function imic_dealers($atts, $content = null) {
		extract(shortcode_atts(array(
			"title" => "",
			"number" => "5",
			"type" => "",
		), $atts));
		
		$output = '';
	$args_user = array('post_type'=>'user', 'posts_per_page'=>$number, 'user-role'=>$type);
	$user_listing = new WP_Query( $args_user );
									if ( $user_listing->have_posts() ) :
	global $wp_query;
	$output .= '<div class="main" role="main">
    	<div id="content" class="content full padding-b0">
        	<div class="container">
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
	$output .= '
                        <div class="col-md-4 col-sm-4 dealer-block">
                            <div class="dealer-block-inner" style="background-image:url('.$image_avatar[0].');">
                            	<div class="dealer-block-cont">
                                    <div class="dealer-block-info">
                                        <span class="dealer-avatar">'.get_the_post_thumbnail().'</span>
                                        <h5><a href="'.get_author_posts_url($user_id).'">'.$company.'</a></h5>
                                        <span class="meta-data">'.$tagline.'</span>
                                    </div>
                                    <div class="dealer-block-text">
                                        '.imic_excerpt(10).'
                                        <div class="dealer-block-add">';
										if(!empty($user_info)) {
                                            $output .= '<span>'.__('Member since','framework').' <strong>'.date("M, Y", strtotime($user_info->user_registered)).'</strong></span>'; }
                                            $output .= '<span>'.__('Total listings','framework').' <strong>'.imic_count_user_posts_by_type($user_id,'cars').'</strong></span>
                                        </div>
                                    </div>
                                    <div class="text-align-center"><a href="'.get_author_posts_url($user_id).'" class="btn btn-default">'.__('View profile','framework').'</a></div>
                               	</div>
                            </div>
                        </div>';
	endwhile;
	$output .= '</div></div></div></div></div>';
	endif; wp_reset_postdata();
	return $output;
	}
	add_shortcode('dealers', 'imic_dealers');
	
	/* LISTING SHORTCODE
	================================================== */
	
	function imic_listing($atts, $content = null) {
		extract(shortcode_atts(array(
			"title" => "",
			"number" => "",
			"column" => 4,
			"cats" => '',
			"tags" => '',
			"specs" => '',
			"view" => '0'
		), $atts));
		
		$output = '';
		if($view=='0')
		{
			$layout = "list";
		}
		elseif($view=='1')
		{
			$layout = "grid";
		}
		global $imic_options;
		$arrays = $term_array = array();
		$count = 0;
		if($specs!='')
		{
			$specs = explode(',', $specs);
			foreach($specs as $spec)
			{
				$arrays[$count] = array(
                    	'key' => 'feat_data',
                    	'value' =>  $value,
                    	'compare' => 'LIKE'
              		); 
				$count++;
			}
		}
		$arrays[$count++] = array('key'=>'imic_plugin_ad_payment_status','value'=>'1','compare'=>'=');
		$arrays[$count++] = array('key'=>'imic_plugin_listing_end_dt','value'=>date('Y-m-d'),'compare'=>'>=');
		if($cats!='')
		{
			$cats = explode(',', $cats);
			$term_array[0] = array(
				'taxonomy' => 'listing-category',
				'field' => 'slug',
				'terms' => $cats,
				'operator' => 'IN');
		}
		if($tags!='')
		{
			$tags = explode(',', $tags);
			$term_array[1] = array(
				'taxonomy' => 'cars-tag',
				'field' => 'slug',
				'terms' => $tags,
				'operator' => 'IN');
		}
		$logged_user_pin = '';			
		$user_id = get_current_user_id( );
		$logged_user = get_user_meta($user_id,'imic_user_info_id',true);
		$logged_user_pin = get_post_meta($logged_user,'imic_user_zip_code',true);
		if($imic_options['badges_type']=="0")
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
		$additional_spec_type = get_post_meta($additional_specs, 'imic_plugin_spec_char_type', true);
		$additional_spec_slug = imic_the_slug($additional_specs);
		$additional_spec_slug = ($additional_spec_type==2)?'char_'.$additional_spec_slug:$additional_spec_slug;
		if($imic_options['short_specifications']==0)
		{
			$detailed_specs = (isset($imic_options['specification_list']))?$imic_options['specification_list']:array();
		}
		else
		{
			$detailed_specs = array();
		}
		$category_rail = (isset($imic_options['category_rail']))?$imic_options['category_rail']:'0';
		$browse_listing = imic_get_template_url("template-listing.php");
		$additional_specs_all = get_post_meta($additional_specs,'specifications_value',true);
		$highlighted_specs = (isset($imic_options['highlighted_specs']))?$imic_options['highlighted_specs']:array();
		$unique_specs = (isset($imic_options['unique_specs']))?$imic_options['unique_specs']:'';	
		$args_cars = array ('post_type'=>'cars','tax_query'=>$term_array,'meta_query' => $arrays,'posts_per_page'=>$number,'post_status'=>'publish');
		$cars_listing = new WP_Query( $args_cars );
		if ( $cars_listing->have_posts() ) :
		if($view=='0'||$view=='1')
		{
		$output .= '
					
					<div class="listing-header">
					<h3>'.esc_attr($title).'</h3>
					</div><div class="listing-container">
					<div class="results-'.$layout.'-view">';
		}
		else
		{
			if(isset($imic_options['enable_rtl']) && $imic_options['enable_rtl']== 1){ $DIR = 'data-rtl="rtl"';} else { $DIR = 'data-rtl="ltr"'; }
			$output .= '<section class="listing-block recent-vehicles">
                	<div class="listing-header">
                    	<h3>'.esc_attr($title).'</h3>
                    </div>
                    <div class="listing-container">
                        <div class="carousel-wrapper">
                            <div class="row">
                                <ul class="owl-carousel carousel-fw" id="vehicle-slider" data-columns="4" data-autoplay="5000" data-pagination="yes" data-arrows="no" data-single-item="no" data-items-desktop="4" data-items-desktop-small="3" data-items-tablet="2" data-items-mobile="1" '.$DIR.'>';
		}
			while ( $cars_listing->have_posts() ) :	
				$cars_listing->the_post();
				
				if($view=='0'||$view=='1')
				{
					if(is_plugin_active("imi-classifieds/imi-classified.php")) 
					{
						$badge_ids = imic_classified_badge_specs(get_the_ID(), $badge_ids);
						$detailed_specs = imic_classified_short_specs(get_the_ID(), $detailed_specs);
					}
					$saved_car_user = array();
					$post_author_id = get_post_field( 'post_author', get_the_ID() );
					$user_info_id = get_user_meta($post_author_id,'imic_user_info_id',true);
					$car_pin = get_post_meta($user_info_id,'imic_user_lat_long',true);
					if(!empty($car_pin)) 
					{ 
						$car_pin = explode(',',$car_pin); $lat = $car_pin[0]; $long = $car_pin[1]; 
					}
					else { $lat = 0; $long = 0; }
					$author_role = get_option('blogname');
					if(!empty($user_info_id)) 
					{
						$term_list = wp_get_post_terms($user_info_id, 'user-role', array("fields" => "names"));
						if(!empty($term_list)) 
						{
							$author_role = $term_list[0]; 
						}
						else 
						{ 
							$author_role = get_option('blogname'); 
						}
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
					if($current_user_info_id!='') 
					{
						$saved_car_user = get_post_meta($current_user_info_id,'imic_user_saved_cars',true); 
					}
					if((empty($saved_car_user))||($current_user_info_id=='')||($saved_car_user=='')) 
					{ 
						$saved_car_user = array($save1, $save2, $save3); 
					}
					$save_icon = (imic_value_search_multi_array(get_the_ID(),$saved_car_user))?'fa-star':'fa-star-o';
					$save_icon_disable = (imic_value_search_multi_array(get_the_ID(),$saved_car_user))?'disabled':'';
                	$output .= '<div class="result-item format-standard">
								<div class="result-item-image">';
					if(has_post_thumbnail()) 
					{
                  		$output .= '<a href="'.esc_url(get_permalink()).'" class="media-box">'.get_the_post_thumbnail(get_the_ID(),'600x400').'</a>'; 
					}
                	$start = 0; 
					$badge_position = array('vehicle-age','premium-listing','third-listing','fourth-listing');
					if(!empty($badges)) 
					{
						foreach($badges as $badge):
							$badge_class = ($start==0)?'default':'success';
							$output .= '<span class="label label-'.esc_attr($badge_class).' '.esc_attr($badge_position[$start]).'">'.esc_attr($badge).'</span>';
							$start++; 
							if($start>3) 
							{ 
								break; 
							}
						endforeach; 
					}
             	$output .= '<div class="result-item-view-buttons">';
            	if($video!='') 
				{
               		$output .= '<a href="'.esc_attr($video).'" data-rel="prettyPhoto"><i class="fa fa-play"></i> '.__('View video','framework').'</a>'; 	
				}
              	$output .= '<a href="'.esc_url(get_permalink()).'"><i class="fa fa-plus"></i> '.__('View details','framework'); 
				$output .= '</a>
                </div>
               	</div>
            	<div class="result-item-in">
            	<h4 class="result-item-title"><a href="'.esc_url(get_permalink()).'">'.esc_attr($highlight_value).'</a>';
				if($category_rail=="1"&&is_plugin_active("imi-classifieds/imi-classified.php"))
				{
					$output .= imic_get_cats_list(get_the_ID(), "dropdown");
				}
				$output .= '</h4>';
            	$output .= '<div class="result-item-cont">
             	<div class="result-item-block col1">
             	'.imic_excerpt(20).'
              	</div>
             	<div class="result-item-block col2">
              	<div class="result-item-pricing">
             	<div class="price">'.esc_attr($unique_value).'</div>
            	</div>
              	<div class="result-item-action-buttons">
         		<a '.esc_attr($save_icon_disable).' href="#" rel="popup-save" class="btn btn-default btn-sm save-car"><div class="vehicle-details-access" style="display:none;"><span class="vehicle-id">'.esc_attr(get_the_ID()).'</span></div><i class="fa '.esc_attr($save_icon).'"></i> '.__('Save','framework').'</a>
            	<a href="'.esc_url(get_permalink()).'" class="btn btn-default btn-sm">'.__('Enquire','framework').'</a><br>
             	<div class="view-distance"><div style="display:none;"><span class="car-lat">'.esc_attr($lat).'</span><span class="car-long">'.esc_attr($long).'</span></div><a id="'.esc_attr(get_the_ID()).'" href="#" class="distance-calc"><i class="fa fa-map-marker"></i> '.__('Distance from me?','framework').'</a>';
           		$output .= '<div class="input-group">
            	<input type="text" value="'.esc_attr($logged_user_pin).'" class="get-distance form-control input-sm" style="display:none;" placeholder="Enter Zipcode">
       			<span class="input-group-btn">
               	<a href="#" class="btn btn-default btn-sm search-dist" style="display:none;">'.__('Get','framework').'</a>
            	</span>
           		</div></div>
            	</div>
            	</div>
             	</div>
              	<div class="result-item-features">
         		<ul class="inline">';
                                                    if(!empty($details_value)) {
														foreach($details_value as $detail) {
															if(!empty($detail)) {
														$output .= '<li>'.$detail.'</li>'; }
													} }
                                                    $output .= '</ul>
                                                </div>
                                            </div>
                                        </div>';
										}
										//Carousel listing start
										else
										{
											if(is_plugin_active("imi-classifieds/imi-classified.php")) 
											{
												$badge_ids = imic_classified_badge_specs(get_the_ID(), $badge_ids);
												$detailed_specs = imic_classified_short_specs(get_the_ID(), $detailed_specs);
											}
											$post_author_id = get_post_field( 'post_author', get_the_ID() );
										$user_info_id = get_user_meta($post_author_id,'imic_user_info_id',true);
										$author_role = get_option('blogname');
										if(!empty($user_info_id)) {
										$term_list = wp_get_post_terms($user_info_id, 'user-role', array("fields" => "names"));
										if(!empty($term_list)) {
										$author_role = $term_list[0]; }
										else { $author_role = get_option('blogname'); }
										}
										$specifications = get_post_meta(get_the_ID(),'feat_data',true);
										$unique_value = imic_vehicle_price(get_the_ID(),$unique_specs,$specifications);
										$new_highlighted_specs = imic_filter_lang_specs_admin($highlighted_specs, get_the_ID());	
										$highlighted_specs = $new_highlighted_specs;
										$highlight_value = imic_vehicle_title(get_the_ID(),$highlighted_specs,$specifications);
										$highlight_value = ($highlight_value!='')?$highlight_value:get_the_title(get_the_ID());
										$details_value = imic_vehicle_all_specs(get_the_ID(),$detailed_specs,$specifications);
										if(!empty($additional_specs)) {
										$image_key = array_search($additional_specs, $specifications['sch_title']);
										$additional_specs_value = $specifications['start_time'][$image_key];
										$this_key = find_car_with_position($additional_specs_all,$additional_specs_value);
										$img_src = $additional_specs_all[$this_key]['imic_plugin_spec_image']; }
										$badges = imic_vehicle_all_specs(get_the_ID(),$badge_ids,$specifications);
                                    $output .= '<li class="item">
                                        <div class="vehicle-block format-standard">';
                                        if(has_post_thumbnail()) {
                                            $output .= '<a href="'.esc_url(get_permalink()).'" class="media-box">'.get_the_post_thumbnail(get_the_ID()).'</a>'; }
                                            $output .= '<div class="vehicle-block-content">';
                                            $start = 1; 
													$badge_position = array('vehicle-age','premium-listing','third-listing','fourth-listing');
													foreach($badges as $badge):
														$badge_class = ($start==1)?'default':'success';
														$output .= '<span class="label label-'.esc_attr($badge_class).' '.esc_attr($badge_position[$start-1]).'">'.esc_attr($badge).'</span>';
													$start++;
													if($start==4) { break; }
													endforeach;
													if(!empty($highlight_value)) {
                                                $output .= '<h5 class="vehicle-title"><a href="'.esc_url(get_permalink()).'">'.esc_attr($highlight_value).'</a></h5>'; }
                                                $output .= '<span class="vehicle-meta">';
												$total = 1; 
												if(!empty($details_value)) 
												{ 
												foreach($details_value as $value) 
												{ 
												$output .= esc_attr($value).', '; 
												if($total++==4) { break; } 
												} 
												} 
												 $output .= __('by','framework').'
												 <abbr class="user-type" title="'.__('Listed by ','framework').esc_attr($author_role).'">'.esc_attr($author_role).'</abbr></span>';
                                                if($img_src!='') {
													$speci_value = $additional_specs_all[$this_key]['imic_plugin_specification_values'];
													$speci_value = str_replace(' ', '%20', $speci_value);
                                                $output .= '<a href="'.esc_url(add_query_arg($additional_spec_slug, $speci_value,$browse_listing)).'" title="'.__('View all','framework'). esc_attr($additional_specs_all[$this_key]['imic_plugin_specification_values']).'" class="vehicle-body-type"><img src="'.esc_url($additional_specs_all[$this_key]['imic_plugin_spec_image']).'" alt=""></a>'; }
                                                $output .= '<span class="vehicle-cost">'.esc_attr($unique_value).'</span>';
												if($category_rail=="1"&&is_plugin_active("imi-classifieds/imi-classified.php"))
												{
													$output .= imic_get_cats_list(get_the_ID(), "list");
												}
                                            $output .= '</div>
                                        </div>
                                    </li>';
										}
                                        endwhile; 
										if($view=='0'||$view=='1')
										{
										$output .= '</div></div>';
										}
										else
										{
											$output .= '</ul>
                            </div>
                        </div>
                    </div>
                </section>';
										}
										else:
										$output .= '<div class="text-align-center error-404">
														<hr class="sm">
														<p><strong>'.esc_attr__('Sorry - No listing found for this criteria','framework').'</strong></p>
														<p>'.esc_attr__('Please search again with different filters.','framework').'</p>
             										</div>';
			endif;
		wp_reset_postdata();
		return $output;
	}
	add_shortcode('listing', 'imic_listing');
	
	/* MOST VIEWED SHORTCODE
	================================================== */
	
	function imic_mostviewed($atts, $content = null) {
		extract(shortcode_atts(array(
			"title" => "",
			"number" => "5",
			"view" => '1'
		), $atts));
		
		$output = '';
		$starts = 1;
		$most_viewed = array();
		global $imic_options;
		$default_image_src = (isset($imic_options['default_car_image']))?$imic_options['default_car_image']['url']:'';
		if($view==1||$view==3)
		{
		$logged_user_pin = '';			
		$user_id = get_current_user_id( );
		$logged_user = get_user_meta($user_id,'imic_user_info_id',true);
		$logged_user_pin = get_post_meta($logged_user,'imic_user_zip_code',true);
		if($imic_options['badges_type']=="0")
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
		$additional_spec_slug = imic_the_slug($additional_specs);
		if($imic_options['short_specifications']==0)
		{
			$detailed_specs = (isset($imic_options['specification_list']))?$imic_options['specification_list']:array();
		}
		else
		{
			$detailed_specs = array();
		}
		$category_rail = (isset($imic_options['category_rail']))?$imic_options['category_rail']:'0';
		$browse_listing = imic_get_template_url("template-listing.php");
		$additional_specs_all = get_post_meta($additional_specs,'specifications_value',true);
		$highlighted_specs = (isset($imic_options['highlighted_specs']))?$imic_options['highlighted_specs']:array();
		$unique_specs = (isset($imic_options['unique_specs']))?$imic_options['unique_specs']:'';
		if($view==1)
		{	
			$most_viewed = get_option('imic_most_viewed');
			$most_viewed = (!empty($most_viewed))?$most_viewed:array();
		}
		elseif($view==3)
		{
			$args_cars = array('post_type'=>'cars','orderby' => 'meta_value','meta_query'=>array('relation' => 'AND',array('key'=>'imic_plugin_ad_payment_status','value'=>'1','compare'=>'='),array('key' => 'imic_plugin_listing_end_dt','value' => date('Y-m-d'),'compare' => '>=')), 
                              'meta_key' => 'imic_most_visited',
                              'order'=>'DESC','posts_per_page'=>$number);
			$cars_listing = new WP_Query( $args_cars );
			if ( $cars_listing->have_posts() ) :
				while ( $cars_listing->have_posts() ) :	
					$cars_listing->the_post();
					$most_viewed[] = get_the_ID();
				endwhile;
			endif; wp_reset_postdata();
		}
		if(!empty($most_viewed))
		{ 
			$output .= '<section class="listing-block recent-vehicles">
                	<div class="listing-header">
                    	<h3>'.esc_attr($title).'</h3>
                    </div>
                    <div class="listing-container">
                        <div class="carousel-wrapper">
                            <div class="row">
                                <ul class="owl-carousel carousel-fw" id="vehicle-slider" data-columns="4" data-autoplay="5000" data-pagination="yes" data-arrows="no" data-single-item="no" data-items-desktop="4" data-items-desktop-small="3" data-items-tablet="2" data-items-mobile="1">';
			foreach($most_viewed as $most)
			{
				$listing_status = get_post_status( $most );
				if($listing_status=="publish")
				{
				if(is_plugin_active("imi-classifieds/imi-classified.php")) 
				{
					$badge_ids = imic_classified_badge_specs($most, $badge_ids);
					$detailed_specs = imic_classified_short_specs($most, $detailed_specs);
				}
				$post_author_id = get_post_field( 'post_author', $most);
				$user_info_id = get_user_meta($post_author_id,'imic_user_info_id',true);
				$author_role = get_option('blogname');
				if(!empty($user_info_id)) 
				{
					$term_list = wp_get_post_terms($user_info_id, 'user-role', array("fields" => "names"));
					if(!empty($term_list)) 
					{
						$author_role = $term_list[0]; 
					}
					else 
					{ 
						$author_role = get_option('blogname'); 
					}
				}
				$specifications = get_post_meta($most,'feat_data',true);
				$unique_value = imic_vehicle_price($most,$unique_specs,$specifications);
				$new_highlighted_specs = imic_filter_lang_specs_admin($highlighted_specs, $most);	
				$highlighted_specs = $new_highlighted_specs;
				$highlight_value = imic_vehicle_title($most,$highlighted_specs,$specifications);
				$highlight_value = ($highlight_value!='')?$highlight_value:get_the_title(get_the_ID());
				$details_value = imic_vehicle_all_specs($most,$detailed_specs,$specifications);
				if(!empty($additional_specs)) 
				{
					$image_key = array_search($additional_specs, $specifications['sch_title']);
					$additional_specs_value = $specifications['start_time'][$image_key];
					$this_key = find_car_with_position($additional_specs_all,$additional_specs_value);
					$img_src = $additional_specs_all[$this_key]['imic_plugin_spec_image']; 
				}
				$badges = imic_vehicle_all_specs($most,$badge_ids,$specifications);
            	$output .= '<li class="item">
            	<div class="vehicle-block format-standard">';
            	if(has_post_thumbnail($most)) 
				{
                	$output .= '<a href="'.esc_url(get_permalink($most)).'" class="media-box">'.get_the_post_thumbnail($most).'</a>'; 
				}
				else
				{
					$output .= '<a href="'.esc_url(get_permalink()).'" class="media-box"><img src="'.$default_image_src.'"></a>';
				}
           		$output .= '<div class="vehicle-block-content">';
        		$start = 1; 
				$badge_position = array('vehicle-age','premium-listing','third-listing','fourth-listing');
				foreach($badges as $badge):
					$badge_class = ($start==1)?'default':'success';
					$output .= '<span class="label label-'.esc_attr($badge_class).' '.esc_attr($badge_position[$start-1]).'">'.esc_attr($badge).'</span>';
					$start++;
					if($start==4) 
					{ 
						break; 
					}
				endforeach;
				if(!empty($highlight_value)) 
				{
           			$output .= '<h5 class="vehicle-title"><a href="'.esc_url(get_permalink($most)).'">'.esc_attr($highlight_value).'</a></h5>'; 
				}
       			$output .= '<span class="vehicle-meta">';
				$total = 1; 
				if(!empty($details_value)) 
				{ 
					foreach($details_value as $value) 
					{ 
						$output .= esc_attr($value).', '; 
						if($total++==4) 
						{ 
							break; 
						} 
					} 
				} 
				$output .= __('by','framework').'
				<abbr class="user-type" title="'.__('Listed by ','framework').esc_attr($author_role).'">'.esc_attr($author_role).'</abbr></span>';
         		if($img_src!='') 
				{
            		$output .= '<a href="'.esc_url(add_query_arg($additional_spec_slug, $additional_specs_all[$this_key]['imic_plugin_specification_values'],$browse_listing)).'" title="'.__('View all','framework'). esc_attr($additional_specs_all[$this_key]['imic_plugin_specification_values']).'" class="vehicle-body-type"><img src="'.esc_url($additional_specs_all[$this_key]['imic_plugin_spec_image']).'" alt=""></a>'; 
				}
        		$output .= '<span class="vehicle-cost">'.esc_attr($unique_value).'</span>';
				if($category_rail=="1"&&is_plugin_active("imi-classifieds/imi-classified.php"))
				{
					$output .= imic_get_cats_list($most, "list");
				}
         		$output .= '</div>
        		</div>
        		</li>';
				if($starts==$number)
				{
					break;
				}
				$starts++;
			}
			}
			$output .= '</ul>
                            </div>
                        </div>
                    </div>
                </section>';
		}
		}
		return $output;
	}
	add_shortcode('mostviewed', 'imic_mostviewed');
	
	/* CATEGORIZE SHORTCODE
	================================================== */
	
	function imic_categorize($atts, $content = null) {
		extract(shortcode_atts(array(
			"title" => "",
			//"cats" => 4,
		), $atts));
		
		$output = '';
		$listing_page_url = imic_get_template_url("template-listing.php");
		$output .= '<div class="search-form">
                    <div class="search-form-inner">
					<h3>'.esc_attr($title).'</h3>
					<div class="row parent-category-row">';
		$list_cats = get_terms('listing-category',array('parent' => 0,'number' => 10,'hide_empty' => false));
		foreach($list_cats as $cat)
		{
			$listing_sub_cats = array();
			$output .= '<div class="col-md-2 col-sm-2"><ul>';
			$output .= '<li><a href="'.esc_url(add_query_arg('list-cat',$cat->slug,$listing_page_url)).'">'.$cat->name.'</a></li>';
			$listing_sub_cats = get_terms('listing-category',array('parent' => $cat->term_id));
			if(!empty($listing_sub_cats))
			{
				$output .= '<ul>';
				foreach($listing_sub_cats as $cats)
				{
					$listing_sub_cats_third = array();
					$output .= '<li><a href="'.esc_url(add_query_arg('list-cat',$cats->slug,$listing_page_url)).'">'.$cats->name.'</a></li>';
					$listing_sub_cats_third = get_terms('listing-category',array('parent' => $cats->term_id));
					if(!empty($listing_sub_cats_third))
					{
						$output .= '<ul>';
						foreach($listing_sub_cats_third as $cats_t)
						{
							$output .= '<li><a href="'.esc_url(add_query_arg('list-cat',$cats_t->slug,$listing_page_url)).'">'.$cats_t->name.'</a></li>';
						}
						$output .= '</ul>';
					}
				}
				
				$output .= '</ul>';
			}
			$output .= '</ul></div>';
		}
		$output .= '</div></div></div></div>';
		return $output;
	}
	add_shortcode('categorize', 'imic_categorize');
	
	/* SIDEBAR SHORTCODES
  =================================================*/
function imic_sidebar($atts, $content = null) {
    extract(shortcode_atts(array(
        "id" => "",
		"column" => 4
     ), $atts));
	 ob_start();
dynamic_sidebar($id);
$html = ob_get_contents();
ob_end_clean();
return $html;
}
add_shortcode('sidebar', 'imic_sidebar'); 

/* FEATURED CATEGORIES SHORTCODES
  =================================================*/
function imic_featured_cats($atts, $content = null) {
    extract(shortcode_atts(array(
        "title" => "",
     ), $atts));
	$output = '';
	$badges = array();
	$listing_page_url = imic_get_template_url("template-listing.php");
	$list_cat = get_terms('listing-category',array('parent' => 0,'number' => 100,'hide_empty' => false));
	if(!empty($list_cat))
	{	
		if(isset($imic_options['enable_rtl']) && $imic_options['enable_rtl']== 1){ $DIR = 'data-rtl="rtl"';} else { $DIR = 'data-rtl="ltr"'; }
		$output .= '<section class="listing-block recent-vehicles">
     	<div class="listing-header">
      	<h3>'.esc_attr($title).'</h3>
      	</div>
     	<div class="listing-container">
       	<div class="carousel-wrapper">
      	<div class="row">
      	<ul class="owl-carousel carousel-fw" id="vehicle-slider" data-columns="5" data-autoplay="5000" data-pagination="yes" data-arrows="no" data-single-item="no" data-items-desktop="5" data-items-desktop-small="3" data-items-tablet="2" data-items-mobile="1" '.$DIR.'>';
		foreach($list_cat as $cat)
		{
			$badges = $badge_slug = array();
			$cat_image = get_option("listing-category".$cat->term_id.'_image_term_id');
			$cat_image = ($cat_image!='')?$cat_image:'';
			$listing_cats = get_term_children($cat->term_id, 'listing-category');
			if(!empty($listing_cats))
			{
				foreach($listing_cats as $cats)
				{
					$category_id = get_term_by('term_id', $cats, 'listing-category');
					$badges[] = $category_id->name;
					$badge_slug[] = $category_id->slug;
					if(count($badges)==4)
					{
						break;
					}
				}
			}
			$output .= '<li class="item">
            	<div class="vehicle-block format-standard">';
                	$output .= '<img src="'.$cat_image.'">'; 
					if(!empty($badges))
					{
           	$output .= '<div class="vehicle-block-content">';
			$badge_position = array('vehicle-age','premium-listing','third-listing','fourth-listing');
			$pos = 1;
			foreach($badges as $badge)
			{
				//$list_term = get_term_by('term_id', $badge, 'listing-category');
				$output .= '<a href="'.esc_url(add_query_arg('list-cat',$badge_slug[$pos-1],$listing_page_url)).'"><span class="label label-default '.$badge_position[$pos-1].'">'.$badge.'</span></a>';
				$pos++;
			}
					}
			$output .= '<h5 class="vehicle-title"><a href="'.esc_url(add_query_arg('list-cat',$cat->slug,$listing_page_url)).'">'.$cat->name.'</a></h5>'; 
			if(!empty($badges))
			{
         	$output .= '</div>';
			}
			$output .= '</div>
        	</li>';
		}
		$output .= '</ul>
     	</div>
     	</div>
       	</div>
      	</section>';
	}
	return $output;
}
add_shortcode('featcat', 'imic_featured_cats'); 
	
	/* SEARCH SHORTCODE
	================================================== */
	
	function imic_search($atts, $content = null) {
		extract(shortcode_atts(array(
			"title" => "",
			"option" => 1,
			"column" => 12,
		), $atts));
		
		$output = '';
		global $imic_options;
		$form_class = ($option==1)?'search1':'search2';
$listing_url = imic_get_template_url("template-listing.php");
$listing_id = imic_get_template_id('template-listing.php');
$output = '<form class="'.$form_class.'" method="get" action="'.esc_url($listing_url).'">
                        <input type="hidden" value="'.esc_attr($listing_id).'" name="page_id">
                            <div class="row">';
							if($option==1) {
                            $search_fields = (isset($imic_options['search_widget1']))?$imic_options['search_widget1']:array();
                            $numeric_specs_type = (isset($imic_options['integer_specs_type']))?$imic_options['integer_specs_type']:0;
 							} else {
							$search_fields = (isset($imic_options['search_widget2']))?$imic_options['search_widget2']:array(); }
							$numeric_specs_type = (isset($imic_options['integer_specs_type']))?$imic_options['integer_specs_type']:0;
									$count = 1;
									if(!empty($search_fields)) {
									foreach($search_fields as $field):
										//if(class_exists('SitePress')&&ICL_LANGUAGE_CODE==imic_langcode_post_id( $field ))
										{
										$specs = get_post_meta($field,'specifications_value',true);
										$int = get_post_meta($field,'imic_plugin_spec_char_type',true);
										$value_label = get_post_meta($field, 'imic_plugin_value_label', true);
										if($int==0) 
										{
											$spec_slug = imic_the_slug($field); 
										}
										elseif($int==1)
										{
											if($numeric_specs_type==0)
											{
												$spec_slug = "int_".imic_the_slug($field);
											}
											else
											{
												$spec_slug = "range_".imic_the_slug($field);
												$min_val = get_post_meta($field, 'imic_plugin_range_min_value', true);
												$max_val = get_post_meta($field, 'imic_plugin_range_max_value', true);
												$steps = get_post_meta($field, 'imic_plugin_range_steps', true);
												$min_val = ($min_val!='')?$min_val:0;
												$max_val = ($max_val!='')?$max_val:100000;
												$steps = ($steps!='')?$steps:1000;
											}
										}
										elseif($int==2)
										{
											$spec_slug = "char_".imic_the_slug($field); 
										}
										$get_child = (imic_get_child_values_status($specs)==1)?'get-child-field':'';
										$output .= '<div class="col-md-4 col-sm-4">';
										if($int==1)
										{ ?>
											<b><?php $output .= esc_attr(get_the_title($field)); $output .= ' ('.$value_label.")"; ?> 
											   <?php $output .= '<input class="search-range" type="hidden" name="'.esc_attr($spec_slug).'" value="">';?> 
											   <?php //$output .= '<span class="left">'.esc_attr($min_val).'</span> - '?>
											   <?php $output .= '<div class="hidden-slider" style="display:none;"> <input id="ex2" type="text" class="span2" value="" data-slider-min="'.esc_attr($min_val).'" data-slider-max="'. esc_attr($max_val).'" data-slider-step="'. esc_attr($steps).'" data-slider-value="['. esc_attr($min_val).','. esc_attr($max_val).']" data-imic-start="" data-imic-end=""/></div><input class="form-control" id="range1_'.esc_attr($spec_slug).'" type="text" class="span3" value="" placeholder="Min"/> <input class="form-control" id="range2_'.esc_attr($spec_slug).'" type="text" class="span3" value="" placeholder="Max" />';?>
											   <?php //$output .= '<span class="right">'.esc_attr($max_val).'</span></b><div class="hidden-slider" style="display:none;"> <input id="ex2" type="text" class="span2" value="" data-slider-min="'.esc_attr($min_val).'" data-slider-max="'. esc_attr($max_val).'" data-slider-step="'. esc_attr($steps).'" data-slider-value="['. esc_attr($min_val).','. esc_attr($max_val).']" data-imic-start="" data-imic-end=""/></div><input class="form-control" id="1" type="text" class="span2" value=""/> <input class="form-control" id="2" type="text" class="span2" value=""/>';?>
										<?php }
										else
										{
                                        $output .= '<label>'.get_the_title($field).'</label>';
										if(!imic_array_empty($specs)) {
                                       	$output .= '<select data-empty="true" id="field-'.($field+2648).'" name="'.esc_attr($spec_slug).'" class="form-control selectpicker '.$get_child.'">
                                                <option disabled value="" selected>'.__('Any','framework').'</option>';
												foreach($specs as $spec) {
													$output .= '<option value="'.esc_attr($spec['imic_plugin_specification_values']).'">'.esc_attr($spec['imic_plugin_specification_values']).'</option>';
												}
                                       	$output .= '</select>';
										
										}
										else {
											$output .= '<input type="text" name="'.esc_attr($spec_slug).'" value="" class="form-control">';
										}
										}
                                     	$output .= '</div>';
										if(imic_get_child_values_status($specs)==1) {
											//echo "saibaba";
											$child_label = get_post_meta($field,'imic_plugin_sub_field_label',true);
											$output .= '<div class="col-md-'.esc_attr($column).' col-sm-'.esc_attr($column).'" id="'.$option.'field-'.(($field*111)+2648).'">
                                            <label>'.$child_label.'</label>';
	                                       	$output .= '<select data-empty="true" name="'.esc_attr($child_label).'" class="form-control selectpicker">
	                                                <option disabled value="" selected>'.__('Select ','framework').get_the_title($field).'</option>';
	                                       	$output .= '</select>';
											$output .= '</div>';
										}
										//}
										// else
										// {
										// 	$specs = get_post_meta($field,'specifications_value',true);
										// 	$int = get_post_meta($field,'imic_plugin_spec_char_type',true);
										// 	if($int==0) 
										// 	{
										// 		$spec_slug = imic_the_slug($field); 
										// 	}
										// 	else 
										// 	{
										// 		$spec_slug = "int_".imic_the_slug($field); 
										// 	}
										// 	$get_child = (imic_get_child_values_status($specs)==1)?'get-child-field':'';
										// 	$output .= '<div class="col-md-'.esc_attr($column).' col-sm-'.esc_attr($column).'">
          //                                   <label>'.get_the_title($field).'</label>';
										// 	if(!imic_array_empty($specs)) 
										// 	{
          //            			$output .= '<select data-empty="true" id="'.$option.'field-'.($field+2648).'" name="'.esc_attr($spec_slug).'" class="form-control selectpicker '.$get_child.'">
          //                                       <option disabled value="" selected>'.__('Any','framework').'</option>';
										// 		foreach($specs as $spec) {
										// 			$output .= '<option value="'.esc_attr($spec['imic_plugin_specification_values']).'">'.esc_attr($spec['imic_plugin_specification_values']).'</option>';
										// 		}
          //                              	$output .= '</select>';
										
										// }
										// else {
										// 	$output .= '<input type="text" name="'.esc_attr($spec_slug).'" value="" class="form-control">';
										// }
          //                            	$output .= '</div>';
										// if(imic_get_child_values_status($specs)==1) {
										// 	//echo "saibaba";
										// 	$child_label = get_post_meta($field,'imic_plugin_sub_field_label',true);
										// 	$output .= '<div class="col-md-'.esc_attr($column).' col-sm-'.esc_attr($column).'" id="'.$option.'field-'.(($field*111)+2648).'">
          //                                   <label>'.$child_label.'</label>';
          //                              	$output .= '<select data-empty="true" name="'.esc_attr($child_label).'" class="form-control selectpicker">
          //                                       <option disabled value="" selected>'.__('Select ','framework').get_the_title($field).'</option>';
          //                              	$output .= '</select>';
										// $output .= '</div>';
										// }
										}
									endforeach; }
									else {
										$output .= '<div class="col-md-12">';
										$output .= esc_attr__('Please select search fields from Theme Options','framework');
										$output .= '</div>';
									}
                            $output .= '</div>
                                    <div class="row">
                                    <div class="col-md-6">
                                    </div>
                                        <div class="col-md-6">
                                            <input type="submit" class="btn btn-block btn-info btn-lg" value="'.esc_attr__('Search','framework').'">
                                        </div>
                                    </div>
                        </form>';
		return $output;
	}
	add_shortcode('search', 'imic_search');
	
	/* TESTIMONIAL SHORTCODE
	================================================== */
	
	function imic_testimonial($atts, $content = null) {
		extract(shortcode_atts(array(
			"title" => "",
			"number" => "",
			"type" => "",
		), $atts));
		global $imic_options;
		$output = '';
		if(is_plugin_active("imithemes-listing/listing.php")) {
		if($type==1) { $class = "carousel-wrapper"; $item = 2; }
		else { $class= "carousel-wrapper testimonials-wbg accent-bg sm-margint"; $item = 1; }
			$args_testimonial = array('post_type'=>'testimonial','posts_per_page'=>$number);
			if(isset($imic_options['enable_rtl']) && $imic_options['enable_rtl']== 1)
			{ 
				$DIR = 'data-rtl="rtl"';
			} 
			else 
			{ 
				$DIR = 'data-rtl="ltr"'; 
			}
			if($type==1) {
			$output .= '<header>
                        	<h3>'.$title.'</h3>
                        </header><div class="spacer-40"></div>'; }
          	$output .= '<div class="'.$class.'">
                            <div class="row">
                                <ul class="owl-carousel carousel-fw" id="testimonials-slider" data-columns="'.$item.'" data-pagination="yes" data-arrows="no" data-single-item="no" data-items-desktop="'.$item.'" data-items-desktop-small="'.$item.'" data-items-tablet="'.$item.'" data-items-mobile="1" '.$DIR.'>';
			$testimonial_listing = new WP_Query( $args_testimonial );
			if ( $testimonial_listing->have_posts() ) :
			while ( $testimonial_listing->have_posts() ) :	
			$testimonial_listing->the_post();
			$company = get_post_meta(get_the_ID(),'imic_company_name',true);
			$company_url = get_post_meta(get_the_ID(),'imic_company_url',true);
			$output .= '<li class="item">
                                        <div class="testimonial-block">
                                            <blockquote>
                                                '.imic_excerpt(15).'
                                            </blockquote>';
											if(has_post_thumbnail()) {
												$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), '100x100' );
                                            $output .= '<div class="testimonial-avatar"><img src="'.$thumb[0].'" width="60" height="60"></div>'; }
                                            $output .= '<div class="testimonial-info">
                                                <div class="testimonial-info-in">
                                                    <strong>'.get_the_title().'</strong>';
													if($company_url!='') {
														$output .= '<span><a href="'.$company_url.'">'.$company.'</a></span>'; }
													else {
														$output .= '<span>'.$company.'</span>'; }
                                                $output .= '</div>
                                            </div>
                                        </div>
                                    </li>';
			endwhile; endif; 
                    $output .= '</ul></div></div>';
		wp_reset_postdata(); }
		return $output;
	}
	add_shortcode('testimonial', 'imic_testimonial');
	
	/* SPECIFICATION SHORTCODE
	================================================== */
	
	function imic_browse_listing($atts, $content = null) {
		extract(shortcode_atts(array(
			"title" => "",
			"value" => "",
			"specs" => "",
		), $atts));
		
		$output = '';
		if(is_plugin_active("imithemes-listing/listing.php")) {
		$browse_listing = imic_get_template_url("template-listing.php");
		if(!empty($specs)) {
		$specification_img = get_post_meta($specs,'specifications_value',true);
		$spec_int = get_post_meta($specs,'imic_plugin_spec_char_type',true);
		if($spec_int==0) {
        $slug = imic_the_slug($specs); }
        elseif($spec_int==1) {
        $slug = "int_".imic_the_slug($specs); }
        else
        {
            $slug = "char_".imic_the_slug($specs);
        } 
		$output .= '<ul class="body-type-widget">';
												foreach($specification_img as $img) { 
												$speci_value = $img['imic_plugin_specification_values'];
												$speci_value = str_replace(' ', '%20', $speci_value);
                                                    $output .= '<li> <a href="'.esc_url(add_query_arg($slug, $speci_value,$browse_listing)).'">';
												if($img['imic_plugin_spec_image']!='') {
													$output .= '<img src="'.$img['imic_plugin_spec_image'].'" alt="">'; }
												if($value==1) {
												$output .= '<span>'.$img['imic_plugin_specification_values'].'</span></a></li>'; }
												else { $output .= '</a></li>'; }
												}
                                                $output .= '</ul>
                                                <a href="'.$browse_listing.'" class="basic-link">'.__('view all','framework').'</a>'; } }
		return $output;
	}
	add_shortcode('browse_listing', 'imic_browse_listing');
	
	/* PLAN SHORTCODE
	================================================== */
	
	function imic_plan($atts, $content = null) {
		extract(shortcode_atts(array(
			"title" => "",
			"number" => 1,
			"term"=>""
		), $atts));
		global $imic_options;
		$output = '';
		if(is_plugin_active("imithemes-listing/listing.php")) {
			$add_listing = imic_get_template_url('template-add-listing.php');
			$output .= '<div class="spacer-30"></div>
                <div class="pricing-table three-cols margin-0">';
			$args_plan = array('post_type'=>'plan','post_status'=>'publish','posts_per_page'=>$number, 'plan-category'=>$term);
							$plan_listing = new WP_Query( $args_plan );
							if ( $plan_listing->have_posts() ) :
							while ( $plan_listing->have_posts() ) :
							$plan_listing->the_post();
							$plan_price = get_post_meta(get_the_ID(),'imic_plan_price',true);
							$plan_period = get_post_meta(get_the_ID(), 'imic_plan_validity', true);	
							$plan_period_time = get_post_meta(get_the_ID(), 'imic_plan_validity_weeks', true);
							$plan_period_listing = get_post_meta(get_the_ID(), 'imic_plan_validity_listings', true);	
							$plan_listing_draft = get_post_meta(get_the_ID(), 'imic_plan_validity_expire_listing', true);
							if($plan_period!='0'&&is_user_logged_in()&&$plan_period!=''&&$plan_price!=''&&$plan_price!='free')
							{
								$plan_btn_val = __('Pay Now', 'framework');
								$plan_url = '';
								$modal = 'data-toggle="modal" data-target="#'.get_the_ID().'-PaypalModal"';
							}
							elseif($plan_period!='0'&&!is_user_logged_in()&&$plan_period!=''&&$plan_price!=''&&$plan_price!='free')
							{
								$plan_btn_val = __('Log In/Register', 'framework');
								$plan_url = '';
								$modal = 'data-toggle="modal" data-target="#PaymentModal"';
							}
							else
							{
								$plan_btn_val = __('Create Ad Now', 'framework');
								$plan_url = add_query_arg('plans',get_the_ID(),$add_listing);
								$modal = '';
							}
							$highlight = get_post_meta(get_the_ID(),'imic_pricing_highlight',true);
							$highlight_class = ($highlight==1)?"highlight accent-color":"";
							$advantage = get_post_meta(get_the_ID(),'imic_plan_advantage',true);
                                                    $plan_currency = get_post_meta(get_the_ID(), 'imic_plan_currency', true);
                            $plan_currency_position = get_post_meta(get_the_ID(), 'imic_plan_currency_position', true);
                        $output .= '<div class="pricing-column '.$highlight_class.'">';
                        $output .= '<h3>'.get_the_title().'<span class="highlight-reason">'.$advantage.'</span></h3>';
                        $output .= '<div class="pricing-column-content">';
                        if($plan_currency_position==1)
                        {
                            $output .= '<h4><span class="dollar-sign">'.$plan_currency.'</span>'.get_post_meta(get_the_ID(),'imic_plan_price',true).'</h4>';
                        }
                        else
                        {
                            $output .= '<h4>'.get_post_meta(get_the_ID(),'imic_plan_price',true).'<span class="dollar-sign">'.$plan_currency.'</span></h4>';
                        }
                   		$output .= '<span class="interval">'.__('Until Sold','framework').'</span>';
						$post_id = get_post(get_the_ID());
						$content = $post_id->post_content;
						$content = apply_filters('the_content', $content);
						$output .= str_replace(']]>', ']]>', $content);
                     	$output .= '<a '.$modal.' class="btn btn-primary" href="'.esc_url($plan_url).'">'.$plan_btn_val.'</a>';
                  		$output .= '</div>';
											if($plan_period!='0'&&is_user_logged_in()&&$plan_period!='')
						{
							$paypal_currency = $imic_options['paypal_currency'];
							$paypal_email = $imic_options['paypal_email'];
							$paypal_site = $imic_options['paypal_site'];
							global $current_user;
							get_currentuserinfo();
							$user_id = get_current_user_id( );
							$current_user = wp_get_current_user();
							$user_info_id = get_user_meta($user_id,'imic_user_info_id',true);
							$thanks_url = imic_get_template_url('template-thanks.php');
							$paypal_site = ($paypal_site=="1")?"https://www.paypal.com/cgi-bin/webscr":"https://www.sandbox.paypal.com/cgi-bin/webscr";
							$output .= '<div id="'.get_the_ID().'-PaypalModal" class="modal fade" aria-hidden="true" aria-labelledby="mymodalLabel" role="dialog" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button class="close" aria-hidden="true" data-dismiss="modal" type="button">'.esc_attr__('×','framework').'</button>
<h4 id="mymodalLabel" class="modal-title">'.esc_attr__('Payment Information','framework').'</h4>
</div>
<div class="modal-body">
<form method="post" id="planpaypalform" name="planpaypalform" class="clearfix" action="'.esc_url($paypal_site).'">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" value="'.get_the_title($user_info_id).'" id="paypal-title" disabled name="First Name"  class="form-control input-lg" placeholder="'.__('Name', 'framework').'*">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" value="'.$current_user->user_email.'" id="paypal-email" disabled name="email"  class="form-control input-lg" placeholder="'.__('Email', 'framework').'*">
                </div>
                
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <div id="messages"></div>
                </div>
                
            </div>
						<input type="hidden" name="rm" value="2">
                                            <input type="hidden" name="amount" value="'.esc_attr($plan_price).'">
                                            <input type="hidden" name="cmd" value="_xclick">
                                            <input type="hidden" name="business" value="'.esc_attr($paypal_email).'">
                                            <input type="hidden" name="currency_code" value="'.esc_attr($paypal_currency).'">
                                            <input type="hidden" name="item_name" value="'.get_the_title(get_the_ID()).'">
                                            <input type="hidden" name="item_number" value="'.esc_attr(get_the_ID()).'">
                                            <input type="hidden" name="return" value="'.esc_url($thanks_url).'" />
						<div class="col-md-12">
						<div class="form-group">
						<input id="paypal-plan" name="submit" type="submit" class="btn btn-default" value="'.__('Proceed to Payment', 'framework').'">
						</div>
						</div>
        </div>
    </form>
</div>
<div class="modal-footer">

</div>
</div>
</div>
</div>';
						}
											$output .= '</div>';
                        endwhile; endif; wp_reset_postdata();
						$output .= '</div>'; }
		return $output;
	}
	add_shortcode('plan', 'imic_plan');
	
	/* PRICING TABLE SHORTCODE
	================================================== */
	function imic_pricing_table($atts, $content = null) {
		extract(shortcode_atts(array(
		'column' => '',
		),$atts));
		$output = '';
		$column = ($column==4)?'four':'three';
		$output = '<div class="pricing-table '.$column.'-cols margin-40">'. do_shortcode($content).'</div>';
		return $output;
	}
	add_shortcode('pricingtable', 'imic_pricing_table');
	
	function imic_pricing_table_heading( $atts, $content = null ) {
		extract(shortcode_atts(array(
		'active' => '',
		),$atts));
		$output = '';
		$active_class = '';
		if($active!='') { $active_class = ' highlight accent-color'; }
		$output = '<div class="pricing-column '.$active_class.'"><h3>'. do_shortcode($content);		
		return $output;
	}
	add_shortcode('headingss', 'imic_pricing_table_heading');
	function imic_pricing_table_reason( $atts, $content = null ) {
		$output = '<span class="highlight-reason">'. do_shortcode($content).'</span>';		
		return $output;
	}
	add_shortcode('reason', 'imic_pricing_table_reason');
	function imic_pricing_table_price( $atts, $content = null ) {
		extract(shortcode_atts(array(
		'currency' => '',
		),$atts));
		$output = '</h3><div class="pricing-column-content"><h4> <span class="dollar-sign">'.$currency.' </span> '. do_shortcode($content);		
		return $output;
	}
	add_shortcode('price', 'imic_pricing_table_price');
	
	function imic_pricing_table_interval( $atts, $content = null ) {
		$output = '</h4><span class="interval">';
		$output .= do_shortcode($content) .'</span><ul class="features" style="height: 157px;">';
		
		return $output;
	}
	add_shortcode('interval', 'imic_pricing_table_interval');
	function imic_pricing_table_row( $atts, $content = null ) {
		$output = '<li>';
		$output .= do_shortcode($content) .'</li>';
		
		return $output;
	}
	add_shortcode('row', 'imic_pricing_table_row');
	function imic_pricing_table_url( $atts, $content = null ) {
		$output = '</ul><a class="btn btn-primary" href="'.do_shortcode($content) .'">'.__('Sign up now!','framework').'</a></div></div>';
		
		return $output;
	}
	add_shortcode('url', 'imic_pricing_table_url');
	
	/* BUTTON SHORTCODE
	================================================== */
	
	function imic_button($atts, $content = null) {
		extract(shortcode_atts(array(
			"colour"		=> "",
			"type"			=> "",
			"link" 			=> "#",
			"target"		=> '_self',
			"size"		=> '',
			"extraclass"   => ''
		), $atts));
		
		$button_output = "";
		$button_class = 'btn '. $colour .' '. $extraclass .' '. $size;
		$buttonType = ($type == 'disabled')? 'disabled="disabled"' : '';
						
		$button_output .= '<a class="'.$button_class.'" href="'.$link.'" target="'.$target.'" '.$buttonType.'>' . do_shortcode($content) . '</a>';		
		return $button_output;
	}
	add_shortcode('imic_button', 'imic_button');
	
	
	/* ICON SHORTCODE
	================================================== */
		
	function imic_icon($atts, $content = null) {
		extract(shortcode_atts(array(
			"image"			=> ""
		), $atts));
		
		return '<i class="fa ' .$image. '"></i>';
	}
	add_shortcode('icon', 'imic_icon');
	
	/* VIDEO SHORTCODE
	================================================== */
		
	function imic_video($atts, $content = null) {
		extract(shortcode_atts(array(
			"url"			=> "",
			"width" => "",
			"height" => "",
			"full" => ""
		), $atts));
		$video_code = imic_video_embed($url,$width,$height);
		if($full==0) {
		return $video_code; }
		else {
		return '<div class="fw-video">'.$video_code.'</div>'; }
	}
	add_shortcode('video', 'imic_video');
	
	/* GOOGLE MAP SHORTCODE
	================================================== */
	
	function imic_gmap($atts, $content = null) {
		extract(shortcode_atts(array(
			"address"			=> '',
		), $atts));
		
		$output = '';
		wp_enqueue_script('imic_google_map');
		wp_enqueue_script('imic_gmap');
		wp_localize_script('imic_gmap','gmap',array('address'=>$address));
		$output .= '<div id="googleMap"></div><div class="spacer-20"></div>';
		return $output;
	}
	add_shortcode('gmap', 'imic_gmap');
	
	/* ICON BOX SHORTCODE
	================================================== */
		
	function imic_icon_box($atts, $content = null) {
		extract(shortcode_atts(array(
			"icon_image"	=> "",
			"line_icon" => "",
			"title"			=> "",
			"description"	=> "",
			"link" => "",
			"type" => "",
			"shade" => "",
			"outline" => "",
			"effect" => "",
			"box" => "",
                    //"icon_box" => ""
		), $atts));
                    $output = '<div class="icon-box '.$type.' '.$shade.' '.$outline.' '.$effect.' '.$box.'">';
					if($link!='') {
					$output .= '<a href="'.$link.'"><div class="ibox-icon">';
					if($icon_image!='') {
					$output .= '<i class="fa '.$icon_image.'"></i></div>'; }
					else {
					$output .= '<i class="'.$line_icon.'"></i></div>'; }	
					$output .= '<h3>'.$title.'</h3></a>'; }
					else {
					$output .= '<div class="ibox-icon">';
					if($icon_image!='') {
					$output .= '<i class="fa '.$icon_image.'"></i></div>'; }
					else {
					$output .= '<i class="'.$line_icon.'"></i></div>'; }	
					$output .= '<h3>'.$title.'</h3>'; }
					$output .= '<p>'.$description.'</p>
					</div>';
                return $output;
	}
	add_shortcode('icon_box', 'imic_icon_box');
	/* COLUMN SHORTCODES
	================================================== */
	function imic_one_full( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"extra" => '',
			"anim" => '',
		), $atts));
		$animation = (!empty($anim)) ? 'data-appear-animation="'.$anim.'"' : '';
	    return '<div class="col-md-12 ' . $extra . '" '. $animation .'>' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_full', 'imic_one_full');
	
	function imic_one_half( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"extra" => '',
			"anim" => '',
		), $atts));
		$animation = ($anim != 0) ? 'data-appear-animation="bounceInRight"' : '';
	    return '<div class="col-md-6 ' . $extra . '" '. $animation .'>' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_half', 'imic_one_half');
	
	function imic_one_third( $atts, $content = null ) {
	   extract(shortcode_atts(array(
			"extra" => '',
			"anim" => ''
		), $atts));
		$animation = ($anim != 0) ? 'data-appear-animation="bounceInRight"' : '';
	    return '<div class="col-md-4 ' . $extra . '" '. $animation .'>' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_third', 'imic_one_third');
	function imic_one_fourth( $atts, $content = null ) {
	   extract(shortcode_atts(array(
			"extra" => '',
			"anim" => ''
		), $atts));
		$animation = ($anim != 0) ? 'data-appear-animation="bounceInRight"' : '';
	    return '<div class="col-md-3 ' . $extra . '" '. $animation .'>' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_fourth', 'imic_one_fourth');
	function imic_one_sixth( $atts, $content = null ) {
	   extract(shortcode_atts(array(
			"extra" => '',
			"anim" => ''
		), $atts));
		$animation = ($anim != 0) ? 'data-appear-animation="bounceInRight"' : '';
	    return '<div class="col-md-2 ' . $extra . '" '. $animation .'>' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_sixth', 'imic_one_sixth');
	
	function imic_two_third( $atts, $content = null ) {
	   extract(shortcode_atts(array(
			"extra" => '',
			"anim" => ''
		), $atts));
		$animation = ($anim != 0) ? 'data-appear-animation="bounceInRight"' : '';
	    return '<div class="col-md-8 ' . $extra . '" '. $animation .'>' . do_shortcode($content) . '</div>';
	}
	add_shortcode('two_third', 'imic_two_third');
	
	function imic_custom( $atts, $content = null ) {
	   extract(shortcode_atts(array(
			"extra" => '',
			"anim" => ''
		), $atts));
		$animation = ($anim != 0) ? 'data-appear-animation="bounceInRight"' : '';
	    return '<div class=" ' . $extra . '" '. $animation .'>' . do_shortcode($content) . '</div>';
	}
	add_shortcode('custom', 'imic_custom');
	/* TABLE SHORTCODES
	================================================= */
	function imic_table_wrap( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"type" => ''
		), $atts));
		$output = '<table class="table '.$type.'">';
		$output .= do_shortcode($content) .'</table>';
		
		return $output;
		
	}
	add_shortcode('htable', 'imic_table_wrap');
	function imic_table_headtag( $atts, $content = null ) {
		$output = '<thead>'. do_shortcode($content) .'</thead>';		
		return $output;
	}
	add_shortcode('thead', 'imic_table_headtag');
	function imic_table_body( $atts, $content = null ) {
		$output = '<tbody>'. do_shortcode($content) .'</tbody>';		
		return $output;
	}
	add_shortcode('tbody', 'imic_table_body');
	
	function imic_table_row( $atts, $content = null ) {
		$output = '<tr>';
		$output .= do_shortcode($content) .'</tr>';
		
		return $output;
	}
	add_shortcode('trow', 'imic_table_row');
	
	function imic_table_column( $atts, $content = null ) {
	
		$output = '<td>';
		$output .= do_shortcode($content) .'</td>';
		
		return $output;
	}
	add_shortcode('tcol', 'imic_table_column');
	function imic_table_head( $atts, $content = null ) {
		$output = '<th>';
		$output .= do_shortcode($content) .'</th>';
		
		return $output;
	}
	add_shortcode('thcol', 'imic_table_head');
	
	/* TYPOGRAPHY SHORTCODES
	================================================= */
	// Anchor tag
	function imic_anchor( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"href"			=> '',
			"extra"			=> ''
		), $atts));
	   return '<a href="'.$href.'" class="'.$extra.'" >' . do_shortcode($content) . ' </a>';
	}
	add_shortcode('anchor', 'imic_anchor');
	// Div tag
	function imic_div( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"extra"			=> ''
		), $atts));
	   return '<div class="'.$extra.'">' . do_shortcode($content) . ' </div>';
	}
	add_shortcode('div', 'imic_div');
	// Section tag
	function imic_section( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"extra"			=> ''
		), $atts));
	   return '<section class="'.$extra.'">' . do_shortcode($content) . ' </section>';
	}
	add_shortcode('section', 'imic_section');
	// Spacer tag
	function imic_spacer( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"extra"			=> '',
			"size" => '',
		), $atts));
	   return '<div class="'.$size.' '.$extra.'">' . do_shortcode($content) . ' </div>';
	}
	add_shortcode('spacer', 'imic_spacer');
	// Alert tag
	function imic_alert( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"type"			=> '',
			"close"			=> ''
		), $atts));
		$closeButton = ($close == 'true') ? '<a class="close" data-dismiss="alert" href="#">&times;</a>' : '';
	   return '<div class="alert '. $type .' fade in">  ' .$closeButton . do_shortcode($content) . ' </div>';
	}
	add_shortcode('alert', 'imic_alert');
	
	// Heading Tag
	function imic_heading_tag($atts, $content = null) {
		extract(shortcode_atts(array(
		   "size" => '',
		   "extra" => '',
		   "icon" => '',
		   "type" => ''
		), $atts));
		if($icon!='') {
		$output = '<'.$size.' class="'.$extra.'"><i class="fa '.$icon.'"></i> '.do_shortcode($content).'</'.$size.'>';
		}
		else {
		$output = '<'.$size.' class="'.$extra.'">' . do_shortcode($content) .'</'.$size.'>';
		}
		return $output;
	}
	add_shortcode("heading", "imic_heading_tag");
	
	// Divider Tag
	function imic_divider_tag($atts, $content = null) {
		extract(shortcode_atts(array(
		   "extra" => '',
		), $atts));
		
		return '<hr class="'. $extra .'">';
	}
	add_shortcode("divider", "imic_divider_tag");
	
	// Paragraph type 
	function imic_paragraph($atts, $content = null) {
		extract(shortcode_atts(array(
		   "extra" => '',
		), $atts));
		
		return '<p class="' . $extra . '">'. do_shortcode($content) .'</p>';
	}
	add_shortcode("paragraph", "imic_paragraph");
	
	// Span type 
	function imic_span($atts, $content = null) {
		extract(shortcode_atts(array(
		   "extra" => '',
		), $atts));
		
		return '<span class="' . $extra . '">'. do_shortcode($content) .'</span>';
	}
	add_shortcode("span", "imic_span");	
	
	// Container type 
	function imic_container($atts, $content = null) {
		extract(shortcode_atts(array(
		   "extra" => '',
		), $atts));
		
		return '<div class="' . $extra . '">'. do_shortcode($content) .'</div>';
	}
	add_shortcode("container", "imic_container");
	
	// Dropcap type 
	function imic_dropcap($atts, $content = null) {
		extract(shortcode_atts(array(
		   "type" => '',
		), $atts));
		
		return '<p class="drop-caps ' . $type . '">'. do_shortcode($content) .'</p>';
	}
	add_shortcode("dropcap", "imic_dropcap");
		
	// Blockquote type
	function imic_blockquote($atts, $content = null) {
		extract(shortcode_atts(array(
		   "name" => '',
		), $atts));
		if(!empty($name)){ $authorName= '<cite>- '.$name.'</cite>'; }else{ $authorName= ''; } 
		return '<blockquote><p>'. do_shortcode($content) .'</p>' . $authorName . '</blockquote>';
	}
	add_shortcode("blockquote", "imic_blockquote");
	
	// Code type
	function imic_code($atts, $content = null) {
		extract(shortcode_atts(array(
		   "type" => '',
		), $atts));
		
		if($type=='inline'){ 
			return '<code>'. do_shortcode($content) .'</code>'; 
		}else{ 
			return '<pre>'. do_shortcode($content) .'</pre>'; 
		} 
		
	}
	add_shortcode("code", "imic_code");
		
	// Label Tag
	function imic_label_tag($atts, $content = null) {
		extract(shortcode_atts(array(
		   "type" => '',
		), $atts));
		$output = '<span class="label '.$type.'">' . do_shortcode($content) .'</span>';
		
		return $output;
	}
	add_shortcode("label", "imic_label_tag");	
	
	
	/* LISTS SHORTCODES
	================================================= */
	function imic_list( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"type" => '',
			"extra" => '',
			"icon" => ''
		), $atts));
				
		if($type == 'ordered'){
			$output = '<ol>' . do_shortcode($content) .'</ol>';
		}else if($type == 'desc'){
			$output = '<dl>' . do_shortcode($content) .'</dl>';
		} else{
			$output = '<ul class="'.$type .' '. $extra .'">' . do_shortcode($content) .'</ul>';		
		}
		
		return $output;		
	}
	add_shortcode('list', 'imic_list');
	
	function imic_list_item( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"icon" => '',
			"type" => ''
		), $atts));
		
		if(($type == 'icon')||($type == 'inline')){
			$output = '<li><i class="fa '.$icon.'"></i> ' . do_shortcode($content) .'</li>';
		}else{
			$output = '<li>' . do_shortcode($content) .'</li>';
		}
		return $output;		
	}
	add_shortcode('list_item', 'imic_list_item');
	
	function imic_list_item_dt( $atts, $content = null ) {		
		$output = '<dt>' . do_shortcode($content) .'</dt>';
		
		return $output;		
	}
	add_shortcode('list_item_dt', 'imic_list_item_dt');
	
	function imic_list_item_dd( $atts, $content = null ) {		
		$output = '<dd>' . do_shortcode($content) .'</dd>';
		
		return $output;		
	}
	add_shortcode('list_item_dd', 'imic_list_item_dd');
	function imic_page_first( $atts, $content = null ) {
		return '<li><a href="#"><i class="fa fa-chevron-left"></i></a></li>';		
	}
	add_shortcode('page_first', 'imic_page_first');
	
	function imic_page_last( $atts, $content = null ) {
		return '<li><a href="#"><i class="fa fa-chevron-right"></i></a></li>';		
	}
	add_shortcode('page_last', 'imic_page_last');	
	
	function imic_page( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"class" => ''
		), $atts));
		
		return '<li class="'.$class.'"><a href="#">'. do_shortcode($content) .' </a></li>';		
	}
	add_shortcode('page', 'imic_page');	
	
	/* TABS SHORTCODES
	================================================= */
	function imic_tabs( $atts, $content = null ) {
		return '<div class="tabs">'. do_shortcode($content) .'</div>';
	}
	add_shortcode('tabs', 'imic_tabs');
	
	function imic_tabh( $atts, $content = null ) {
		return '<ul class="nav nav-tabs">'. do_shortcode($content) .'</ul>';		
	}
	add_shortcode('tabh', 'imic_tabh');
	
	function imic_tab( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"id" => '',
			"class" => ''
		), $atts));
		
		return '<li class="'.$class.'"> <a data-toggle="tab" href="#'.$id.'"> '. do_shortcode($content) .' </a> </li>';		
	}
	add_shortcode('tab', 'imic_tab');	
	
	function imic_tabc( $atts, $content = null ) {		
		return '<div class="tab-content">'. do_shortcode($content) .'</div>';	
	}
	add_shortcode('tabc', 'imic_tabc');
	
	function imic_tabrow( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"id" => '',
			"class" => ''
		), $atts));
				
		$output = '<div id="'.$id.'" class="tab-pane '.$class.'">' . do_shortcode($content) .'</div>';
		
		return $output;		
	}
	add_shortcode('tabrow', 'imic_tabrow');
	/* ACCORDION SHORTCODES
	================================================= */
	function imic_accordions( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"id" => ''
		), $atts));
		
		return '<div class="accordion" id="accordion' .$id. '">'. do_shortcode($content) .'</div>';
	}
	add_shortcode('accordions', 'imic_accordions');
	
	function imic_accgroup( $atts, $content = null ) {
		return '<div class="accordion-group panel">'. do_shortcode($content) .'</div>';		
	}
	add_shortcode('accgroup', 'imic_accgroup');
	
	function imic_acchead( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"id" => '',
			"class" => '',
			"tab_id" =>''
		), $atts));
		
		$output = '<div class="accordion-heading accordionize"> <a class="accordion-toggle '. $class .'" data-toggle="collapse" data-parent="#accordion' .$id. '" href="#' .$tab_id. '"> '. do_shortcode($content) .' <i class="fa fa-angle-down"></i> </a> </div>';
		
		return $output;
	}
	add_shortcode('acchead', 'imic_acchead');	
	
	function imic_accbody( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"tab_id" => '',
			"in" => ''
		), $atts));
		
		$output = '<div id="' . $tab_id . '" class="accordion-body ' . $in . ' collapse">
					  <div class="accordion-inner"> '. do_shortcode($content) .' </div>
					</div>';
		
		return $output;		
	}
	add_shortcode('accbody', 'imic_accbody');
	/* TOGGLE SHORTCODES
	================================================= */
	function imic_toggles( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"id" => ''
		), $atts));
		
		return '<div class="accordion" id="toggle' .$id. '">'. do_shortcode($content) .'</div>';
	}
	add_shortcode('toggles', 'imic_toggles');
	
	function imic_togglegroup( $atts, $content = null ) {
		return '<div class="accordion-group panel">'. do_shortcode($content) .'</div>';		
	}
	add_shortcode('togglegroup', 'imic_togglegroup');
	
	function imic_togglehead( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"id" => '',
			"tab_id" =>''
		), $atts));
		
		$output = '<div class="accordion-heading togglize"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#" href="#' .$tab_id. '"> '. do_shortcode($content) .' <i class="fa fa-plus-circle"></i> <i class="fa fa-minus-circle"></i> </a> </div>';
	
		return $output;
	}
	add_shortcode('togglehead', 'imic_togglehead');	
	
	function imic_togglebody( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"tab_id" => ''
		), $atts));
		
		$output = '<div id="' . $tab_id . '" class="accordion-body collapse">
              <div class="accordion-inner"> '. do_shortcode($content) .'  </div>
            </div>';
		
		return $output;		
	}
	add_shortcode('togglebody', 'imic_togglebody');
	/* PROGRESS BAR SHORTCODE
	================================================= */
	function imic_progress_bar($atts) {
		extract(shortcode_atts(array(
			"percentage" => '',
			"name" => '',
			"type" => '',
			"value" => '',
			"colour" => ''
		), $atts));
		
		if ($type == 'progress-striped') { $typeClass = $type; } else { $typeClass = ""; }
		if ($colour == 'progress-bar-warning' ) { $warningText = '(warning)'; } else { $warningText = ""; }
		
		$service_bar_output = '';
		$progress_text = '';
		if($name!='') {
				$service_bar_output = '<div class="progress-label"> <span>' . $name . '</span> </div>';
		}
		$service_bar_output .= '<div class="progress '. $typeClass .'">';
		
		if($type == 'progress-striped'){
        	$service_bar_output .= '<div class="progress-bar ' . $colour . '" style="width: ' . $value . '%">';
			$service_bar_output .= '<span class="sr-only">' . $value . '% Complete (success)</span>';
			$service_bar_output .= '</div>';        
		}else if($type == 'colored'){
			if(!empty($warningText)){ $spanClass=''; $progress_text = $value.'% Complete '.$warningText; }else{ $spanClass='sr-only'; $progress_text = ''; }
          	$service_bar_output .= '<div class="progress-bar ' . $colour . '" style="width: ' . $value . '%"> <span class="'.$spanClass.'">' . $progress_text.'</span> </div>';
		}else{
			$service_bar_output .= '<div class="progress-bar progress-bar-primary" data-appear-progress-animation="'.$value.'%"> <span class="progress-bar-tooltip">' . $value . '%</span> </div>';
		}
        $service_bar_output .= '</div>';
		
		return $service_bar_output;
	}
	
	add_shortcode('progress_bar', 'imic_progress_bar');
	
	
	/* TOOLTIP SHORTCODE
	================================================= */
	function imic_tooltip($atts, $content = null) {
		extract(shortcode_atts(array(
			"title" => '',
			"link" => '#',
			"direction" => 'top'
		), $atts));
				
		$tooltip_output = '<a href="'.$link.'" rel="tooltip" data-toggle="tooltip" data-original-title="'.$title.'" data-placement="'.$direction.'">'.do_shortcode($content).'</a>';
		return $tooltip_output;
	}
	
	add_shortcode('imic_tooltip', 'imic_tooltip');
	/* WORDPRESS LINK SHORTCODE
	================================================= */
	function imic_wordpress_link() {
		return '<a href="http://wordpress.org/" target="_blank">WordPress</a>';
	}
	add_shortcode('wp-link', 'imic_wordpress_link');
	
	/* COUNT SHORTCODE
	================================================= */
	function imic_count($atts) {
		extract(shortcode_atts(array(
			"speed" => '2000',
			"to" => '',
			"icon" => '',
			"subject" => '',
			"textstyle" => ''
		), $atts));
		
		$count_output = '';
		if ($speed == "") {$speed = '2000'; }
		$count_output .= '<div class="col-lg-3 col-md-3 col-sm-3 cust-counter">';
		$count_output .= '<div class="fact-ico"> <i class="fa ' . $icon . ' fa-4x"></i> </div>';
		$count_output .= '<div class="clearfix"></div>';
		$count_output .= '<div class="timer" data-perc="'.$speed.'"> <span class="count">' .$to. '</span></div>';
		$count_output .= '<div class="clearfix"></div>';
		if ($textstyle == "h3") {
			$count_output .= '<h3>'.$subject.'</h3></div>';		
		} else if ($textstyle == "h6") {
			$count_output .= '<h6>'.$subject.'</h6></div>';		
		} else {
			$count_output .= '<span class="fact">'.$subject.'</span></div>';
		}
		
		return $count_output;
	}
	
	add_shortcode('imic_count', 'imic_count');
	
	/* MODAL BOX SHORTCODE
	================================================== */
	function imic_modal_box($atts, $content = null) {
		extract(shortcode_atts(array(
			"id"			=> "",
			"title" 	=> "",
			"text"	=> "",
			"button" => ""
		), $atts));
		
		$modalBox = '<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#'.$id.'">'.$button.'</button>
            <div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="'.$id.'Label" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="'.$id.'Label">'.$title.'</h4>
                  </div>
                  <div class="modal-body"> '. $text .' </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default inverted" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>';
				
		return $modalBox;
		
	}
	add_shortcode('modal_box', 'imic_modal_box');
	
	/* FORM SHORTCODE
	================================================== */
	function imic_form_code($atts, $content = null) {
   extract(shortcode_atts(array(
        "form_email" => '',
        "form_title" => '',
                    ), $atts));
     if(!empty($form_email)){
        $admin_email = $form_email; 
      }else{
      $admin_email = get_option('admin_email');
       }
       $contact_title='';
       if(!empty($form_title)){
        $contact_title = '<h2>'.$form_title.'</h2>'; 
       }
$formCode = '<form action="'.IMIC_THEME_PATH.'/mail/contact.php" type="post" class="contact-form clearfix" id="contactform">
<div class="row">
<div class="col-md-6">
<div class="form-group">
<input type="text" id="fname" name="fname"  class="form-control input-lg" placeholder="'.__('Name','framework').' *">
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<input type="text" id="lname" name="Last Name"  class="form-control input-lg" placeholder="'.__('Last name','framework').'">
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<input type="email" id="email" name="email"  class="form-control input-lg" placeholder="'.__('Email','framework').' *">
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<input type="text" id="phone" name="phone" class="form-control input-lg" placeholder="'.__('Phone','framework').'">
</div>
</div>
<div class="col-md-6">
<div class="form-group">
 <label id="captcha"><?php '.imic_create_captcha().'</label>
	<input id="captcha_val" type="text" placeholder="'.esc_html__('Insert Captcha', 'framework').'">
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="form-group">
<textarea cols="6" rows="7" id="comments" name="comments" class="form-control input-lg" placeholder="'.__('Message','framework').'"></textarea>
<input type ="hidden" name ="image_path" id="image_path" value ="'.IMIC_THEME_PATH.'">
<input type ="hidden" name ="recipients" id="recipients" value ="">
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<input id="submit" name="submit" type="submit" class="btn btn-primary btn-lg btn-block" value="'.__('Submit','framework').'">
</div>
</div>
<div class="clearfix"></div>
</form><div id="message"></div>';
    return $formCode;
}
	add_shortcode('imic_form', 'imic_form_code');
         /* Event Calendar SHORTCODE
  ================================================= */
function event_calendar($atts) {
    extract(shortcode_atts(array(
        "category_id" => '',
		"filter" => '',
		"preview" => '',
                    ), $atts));
		wp_enqueue_style('imic_fullcalendar_css');
		wp_enqueue_style('imic_fullcalendar_print');
	global $imic_options;
	$facebook = $imic_options['share_icon'][1];
	$twitter = $imic_options['share_icon'][2];
	$google = $imic_options['share_icon'][3];
	$tumblr = $imic_options['share_icon'][4];
	$pinterest = $imic_options['share_icon'][5];
	$reddit = $imic_options['share_icon'][6];
	$linkedin = $imic_options['share_icon'][7];
	$email_share = $imic_options['share_icon'][8];
       	$event_preview = $preview;
		$term_output = '';
		if($filter==1) { 
		$e_terms = get_terms('event-category');
		$term_output .= '<div class="events-listing-header"><ul class="sort-calendar sort-source"><li class="e1Div active" id=""><a href="javascript:void(0)">'.__('All','framework').'</a></li>';
		if($imic_options['google_feed_id']!='') { 
		$term_output .= '<li class="e1Div" id="google"><a href="javascript:void(0)">'.__('Google','framework').'</a></li>'; }
		foreach($e_terms as $term) {
		$term_output .= '<li class="e1Div" id="'.$term->term_id.'"><a href="javascript:void(0)">'.$term->name.'</a></li>'; }
		$term_output .= '</ul></div>'; }
		//$google_feeds = $imic_options['google_feed'];
		$google_api_key = $imic_options['google_feed_key'];
		$google_calendar_id = $imic_options['google_feed_id'];
        $monthNamesValue = $imic_options['calendar_month_name'];
        $monthNames = (empty($monthNamesValue)) ? array() : explode(',', trim($monthNamesValue));
        $monthNamesShortValue = $imic_options['calendar_month_name_short'];
        $monthNamesShort = (empty($monthNamesShortValue)) ? array() : explode(',', trim($monthNamesShortValue));
        $dayNamesValue = $imic_options['calendar_day_name'];
        $dayNames = (empty($dayNamesValue)) ? array() : explode(',', trim($dayNamesValue));
        $dayNamesShortValue = $imic_options['calendar_day_name_short'];
        $dayNamesShort = (empty($dayNamesShortValue)) ? array() : explode(',', trim($dayNamesShortValue));
		wp_enqueue_script('imic_fullcalendar');
		wp_enqueue_script('imic_gcal');
		wp_enqueue_script('imic_calender_events');
		wp_enqueue_script('imic_jquery_countdown');
		wp_localize_script('imic_jquery_countdown', 'upcoming_data', array('c_time' =>time()));
		wp_enqueue_script('imic_counter_init');
		$format=ImicConvertDate(get_option('time_format'));
        wp_localize_script('imic_calender_events', 'calenderEvents', array('homeurl' => get_template_directory_uri(), 'monthNames' => $monthNames, 'monthNamesShort' => $monthNamesShort, 'dayNames' => $dayNames, 'dayNamesShort' => $dayNamesShort,'time_format'=>$format,'start_of_week'=>get_option('start_of_week'),'googlekey'=>$google_api_key,'googlecalid'=>$google_calendar_id,'ajaxurl' => admin_url('admin-ajax.php'),'preview'=>$event_preview,'facebook'=>$facebook,'twitter'=>$twitter,'google'=>$google,'tumblr'=>$tumblr,'pinterest'=>$pinterest,'reddit'=>$reddit,'linkedin'=>$linkedin,'email'=>$email_share));
		if($event_preview==1) {
			$output = '';
			$events = imic_recur_events('future','',''); ksort($events); foreach($events as $key=>$value) { $id = $value; break; }
			$date_converted=date('Y-m-d',$key );
    $custom_event_url= imic_query_arg($date_converted,$id);
	$output .= '<ul class=" sort-destination events-ajax-caller">';
	$output .= '<li class="event-item event-dynamic">';
	$output .= '<div class="grid-item-inner">';
	$output .= '<div class="preview-event-bar">
                            <div id="counter" class="counter-preview top-header" data-date="'.$key.'">
                         		<div class="timer-col"> <span id="days"></span> <span class="timer-type">'.__('d','framework').'</span> </div>
                        		<div class="timer-col"> <span id="hours"></span> <span class="timer-type">'.__('h','framework').'</span> </div>
                      			<div class="timer-col"> <span id="minutes"></span> <span class="timer-type">'.__('m','framework').'</span> </div>
                         		<div class="timer-col"> <span id="seconds"></span> <span class="timer-type">'.__('s','framework').'</span> </div>
                            </div>
                        </div>';
	$event_address = get_post_meta($id,'imic_event_address2',true);
	
	if ( '' != get_the_post_thumbnail($id) ) { 
	$output .= '<a href="'.esc_url($custom_event_url).'" class="media-box">'.get_the_post_thumbnail($id,'full').'</a>'; }
	$output .= '<div id="load-preview-events" class="load-events" style="display:none;"><img src="'.IMIC_THEME_PATH.'/images/loader.gif"></div>';
	$output .= '<div class="grid-content">';
	$output .= '<h3><a class="event-title" href="'.esc_url($custom_event_url).'">'.get_the_title($id).'</a></h3>';
	$address1 = get_post_meta($id,'imic_event_address1',true);
	$address2 = get_post_meta($id,'imic_event_address2',true);
  	$output .= '<span class="meta-data"><i class="fa fa-calendar"></i> <span class="event-date">'.esc_attr(date_i18n(get_option('date_format'),$key)).'</span>'.__(' at ','framework').'<span class="event-time">'.esc_attr(date_i18n(get_option('time_format'), $key)).'</span></span>
                                    <span class="meta-data event-location-address"><i class="fa fa-map-marker"></i> '.esc_attr($event_address).'</span>';
	$output .= '</div>';
	$output .= '<div class="grid-footer clearfix">';
	$event_registration = get_post_meta($value,'imic_event_registration',true); if($event_registration==1) {
   	$output .= '<a id="register-'.($value+2648).'|'.$key.'" href="#" class="pull-right btn btn-sm btn-primary btn-sm event-tickets event-register-button">'.__('Register','framework').'</a>'; }
 	$output .= '<ul class="action-buttons">';
	if ($imic_options['switch_sharing'] == 1 && $imic_options['share_post_types']['3'] == '1') {
  	$output .= '<li title="Share event"><a href="#" data-trigger="focus" data-placement="right" data-content="" data-toggle="popover" data-original-title="Share Event" class="event-share-link"><i class="icon-share"></i></a></li>'; } 
	$event_map = get_post_meta($value,'imic_event_address2',true); if($event_map!='') {
 	$output .= '<li title="Get directions" class="hidden-xs"><a href="#" class="cover-overlay-trigger event-direction-link"><i class="icon-compass"></i></a></li>'; } 
	$event_contact_info = get_post_meta($value,'imic_event_manager',true); if($event_contact_info!='') {
   	$output .= '<li title="Contact event manager"><a id="contact-'.($value+2648).'|'.$key.'" href="#" data-toggle="modal" data-target="#Econtact" class="event-contact-link"><i class="icon-mail"></i></a></li>'; } 
  	$output .= '</ul></div>';
	
    $output .= '</div></div></li></ul>';
			return '<div class="row"><div class="col-md-9">'.$term_output.'<div id="calendar"><div id ="'.$category_id.'" class ="event_calendar calendar"></div></div></div><div class="col-md-3"><h2 class="title ">'.__('Event Preview','framework').'</h2><div id="events-preview-box">'.$output.'</div></div>';
		}else {
			return $term_output.'<div id="calendar"><div id ="'.$category_id.'" class ="event_calendar calendar"></div></div>'; }
}
add_shortcode('event_calendar', 'event_calendar');
?>