<?php
/*
Template Name: Home Third
*/
get_header();
global $imic_options;
//Get Page Banner Type
if(is_home()) { $id = get_option('page_for_posts'); }
else { $id = get_the_ID(); }
$page_header = get_post_meta($id,'imic_pages_Choose_slider_display',true);
if($page_header==3) {
	get_template_part( 'pages', 'flex' );
}
elseif($page_header==4) {
	get_template_part( 'pages', 'nivo' );
}
elseif($page_header==5) {
	get_template_part( 'pages', 'revolution' );
}
elseif($page_header==1||$page_header==2) {
	get_template_part( 'pages', 'banner' );
}
else {
	//get_template_part( 'pages', 'banner' );
}
$pageSidebar2 = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list', true);
if(!empty($pageSidebar2)&&is_active_sidebar($pageSidebar2)) {
$class2 = 9;  
}else{
$class2 = 12;  
}
$vehicle_switch = get_post_meta($id,'imic_home_vehicle_switch',true);
$parallax_switch = get_post_meta($id,'imic_home_third_parallax_section',true);
$pricing_switch = get_post_meta($id,'imic_home_pricing_switch',true);
$make_search_switch = get_post_meta($id,'imic_search_by_specification_switch',true);
$browse_specification_switch = get_post_meta(get_the_ID(),'imic_browse_by_specification_switch',true);
$browse_listing = imic_get_template_url("template-listing.php");
if($browse_specification_switch==1) {
get_template_part('bar','one'); 
} elseif($browse_specification_switch==2) {
get_template_part('bar','two');
} elseif($browse_specification_switch==3) { 
get_template_part('bar','saved');
}
if($browse_specification_switch==4)
{
	get_template_part('bar', 'category');
} else { }
$default_image_src = (isset($imic_options['default_car_image']))?$imic_options['default_car_image']['url']:''; ?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full padding-b0">
             <?php if(have_posts()):while(have_posts()):the_post();
						 				echo '<div class="container">';
										the_content();
										endwhile; endif;
									echo '</div>'; ?>
                <?php if($vehicle_switch==1) {
					if(is_plugin_active("imithemes-listing/listing.php")) {
					$vehicle_count = get_post_meta($id,'imic_home_vehicle_count',true);
					$vehicle_title = get_post_meta($id,'imic_home_vehicle_title',true);
					$vehicle_column = get_post_meta($id,'imic_home_vehicle_column',true);
					$args_cars = array('post_type'=>'cars','posts_per_page'=>$vehicle_count,'post_status'=>'publish','meta_query'=>array('relation' => 'AND',array('key'=>'imic_plugin_ad_payment_status','value'=>'1','compare'=>'='),array('key' => 'imic_plugin_listing_end_dt','value' => date('Y-m-d'),'compare' => '>=')));
					$cars_listing = new WP_Query( $args_cars );
					if ( $cars_listing->have_posts() ) :
					 ?>
                    <!-- Listing Results -->
                    <div class="container">
                <div class="row">
                    <div class="col-md-<?php echo esc_attr($class2); ?> results-container">
                        <section class="listing-block trending-listing">
                            <div class="listing-header">
                            	<div class="toggle-view pull-right">
                                    <div class="btn-group">
                                        <a href="#" class="btn btn-default active" id="results-list-view"><i class="fa fa-th-list"></i></a>
                                        <a href="#" class="btn btn-default" id="results-grid-view"><i class="fa fa-th"></i></a>
                                    </div>
                                </div>
                                <h2><?php echo esc_attr($vehicle_title); ?></h2>
                            </div>
                            <div class="listing-container">
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
                                    <?php 
										$badges_type = (isset($imic_options['badges_type']))?$imic_options['badges_type']:'0';
										$specification_type = (isset($imic_options['short_specifications']))?$imic_options['short_specifications']:'0';
										$logged_user_pin = '';			
										$user_id = get_current_user_id( );
										$logged_user = get_user_meta($user_id,'imic_user_info_id',true);
										$logged_user_pin = get_post_meta($logged_user,'imic_user_zip_code',true);
										if($badges_type=="0")
										{
										$badge_ids = (isset($imic_options['badge_specs']))?$imic_options['badge_specs']:array();
										}
										else
										{
											$badge_ids = array();
										}
										$img_src = '';
										$additional_specs = (isset($imic_options['additional_specs']))?$imic_options['additional_specs']:'';
										if($specification_type==0)
										{
										$detailed_specs = (isset($imic_options['specification_list']))?$imic_options['specification_list']:'';
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
										if(!empty($car_pin)) { $car_pin = explode(',',$car_pin); $lat = $car_pin[0]; $long = $car_pin[1]; }
										else { $lat = 0; $long = 0; }
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
													if(!empty($badges)) {
													$badge_position = array('vehicle-age','premium-listing','third-listing','fourth-listing');
													foreach($badges as $badge):
														$badge_class = ($start==0)?'default':'success';
														echo '<span class="label label-'.$badge_class.' '.$badge_position[$start].'">'.$badge.'</span>';
													$start++; if($start>3) { break; }
													endforeach; } ?>
                                                <div class="result-item-view-buttons">
                                                <?php if($video!='') { ?>
                                                    <a href="<?php echo esc_attr($video); ?>" data-rel="prettyPhoto"><i class="fa fa-play"></i> <?php echo esc_attr_e('View video','framework'); ?></a><?php } ?>
                                                    <a href="<?php echo esc_url(get_permalink()); ?>"><i class="fa fa-plus"></i> <?php echo esc_attr_e('View details','framework'); ?></a>
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
                                                            <a <?php echo esc_attr($save_icon_disable); ?> rel="popup-save" id="" href="#" class="btn btn-default btn-sm save-car"><div class="vehicle-details-access" style="display:none;"><span class="vehicle-id"><?php echo esc_attr(get_the_ID()); ?></span></div><i class="fa <?php echo esc_attr($save_icon); ?>"></i> <?php echo esc_attr_e('Save','framework'); ?></a>
                                                            <a href="<?php echo esc_url(get_permalink()); ?>" class="btn btn-default btn-sm"><?php echo esc_attr_e('Enquire','framework'); ?></a><br>
                                                            <div class="view-distance"><div style="display:none;"><span class="car-lat"><?php echo esc_attr($lat); ?></span><span class="car-long"><?php echo esc_attr($long); ?></span></div><a id="<?php echo esc_attr(get_the_ID()); ?>" href="#" class="distance-calc"><i class="fa fa-map-marker"></i> <?php echo esc_attr_e('Distance from me?','framework'); ?></a>
                                                            <div class="input-group input-group-sm">
                                                              	<input type="text" value="<?php echo esc_attr($logged_user_pin); ?>" class="get-distance form-control input-sm" style="display:none;" placeholder="Enter Zipcode">
                                                              	<span class="input-group-btn">
                                                                	<a href="#" class="btn btn-default btn-sm search-dist" style="display:none;"><?php echo esc_attr_e('Get','framework'); ?></a>
                                                              	</span>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="result-item-features">
                                                    <ul class="inline">
                                                    <?php if(!empty($details_value)) { foreach($details_value as $detail) {
														if(!empty($detail)) {
														echo '<li>'.$detail.'</li>'; }
													} } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endwhile; ?>
                                    </div>
                                </div>
                           	</div>
                       	</section>
                    </div>
                    
                    <div class="col-md-3">
                        <?php dynamic_sidebar($pageSidebar2); ?></div>
               	</div>
           	</div>
            <div class="spacer-50"></div><?php endif; wp_reset_postdata(); } } if($pricing_switch==1) {
				if(is_plugin_active("imithemes-listing/listing.php")) {
				$column = get_post_meta(get_the_ID(),'imic_home_pricing_column',true);
				$pricing_title = get_post_meta($id,'imic_home_pricing_title',true); ?>
            <div class="lgray-bg padding-tb45">
            	<div class="container">
                    <div class="text-align-center">
                        <h2><?php echo esc_attr($pricing_title); ?></h2>
                    </div>
                    <div class="spacer-10"></div>
                    <div class="pricing-table <?php echo esc_attr($column); ?>-cols margin-0">
                    <?php 	$add_listing = imic_get_template_url('template-add-listing.php');
							$args_plan = array('post_type'=>'plan','post_status'=>'publish','posts_per_page'=>-1);
							$plan_listing = new WP_Query( $args_plan );
							if ( $plan_listing->have_posts() ) :
							while ( $plan_listing->have_posts() ) :	
							$plan_listing->the_post();
							$highlight = get_post_meta(get_the_ID(),'imic_pricing_highlight',true);
							$highlight_class = ($highlight==1)?"highlight accent-color":"";
							$advantage = get_post_meta(get_the_ID(),'imic_plan_advantage',true);
							$price = get_post_meta(get_the_ID(),'imic_plan_price',true);
							$currency = (isset($imic_options['paypal_currency']))?$imic_options['paypal_currency']:'USD';
							$currency = imic_get_currency_symbol($currency); ?>
                        <div class="pricing-column <?php echo esc_attr($highlight_class); ?>">
                            <h3><?php echo get_the_title(); ?><span class="highlight-reason"><?php echo esc_attr($advantage); ?></span></h3>
                            <div class="pricing-column-content">
                            <?php if($price!="free"||$price!=0) { ?>
                                <h4> <?php if(($price!="")&&($price!="free")) { ?><span class="dollar-sign"><?php echo esc_attr($currency); ?></span> <?php } echo esc_attr($price); ?> </h4><?php } else { ?>
                                <?php echo '<h4>'; echo esc_attr_e('Free','framework'); echo '</h4>'; } ?>
                                <span class="interval"><?php _e('Until Sold','framework'); ?></span>
                                <?php the_content(); ?>
                                <a class="btn btn-primary" href="<?php echo esc_url(add_query_arg('plan',get_the_ID(),$add_listing)); ?>"><?php _e('Create Ad Now','framework'); ?></a>
                            </div>
                        </div>
                        <?php endwhile; endif; wp_reset_postdata(); ?>
                    </div>
           			<div class="spacer-30"></div>
                </div>
          	</div>
            <?php } } if($parallax_switch==1) {
				$image_parallax = get_post_meta($id,'imic_home_third_parallax_image',true);
				$image = wp_get_attachment_image_src($image_parallax,'full');
				$parallax_title = get_post_meta($id,'imic_home_third_shortcode',true); ?>
            <div class="dark-bg parallax parallax1" style="background-image:url(<?php echo esc_url($image[0]); ?>);">
                <div class="overlay-transparent padding-tb125">
                    <div class="container">
                    	<?php echo do_shortcode($parallax_title); ?>
                    </div>
              	</div>
          	</div>
            <?php } ?>
        </div>
   	</div>
    <!-- End Body Content -->
<?php get_footer(); ?>