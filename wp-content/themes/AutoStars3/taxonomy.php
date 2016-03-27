<?php
get_header();
global $imic_options;
$listing_image = $imic_options['header_image']['url'];
$class = 12;
if(is_active_sidebar('car-sidebar'))
{
	$class = 8;
}
?>
<div class="page-header parallax" style="background-image:url(<?php echo esc_url($listing_image); ?>);">
    	<div class="container">
        	<h1 class="page-title"><?php echo esc_attr(single_term_title("", false)); ?></h1>
       	</div>
    </div>
    <!-- End Page Header -->
    <!-- Breadcrumbs -->
    <div class="lgray-bg breadcrumb-cont">
    	<div class="container">
        <?php if(function_exists('bcn_display'))
    { ?>
          	<ol class="breadcrumb">
            	<?php bcn_display(); ?>
          	</ol>
		<?php } ?>
        </div>
    </div>
    <div class="main" role="main">
    	<div id="content" class="content full">
        	<div class="container">
            	<div class="row">
            		<div class="col-md-<?php echo esc_attr($class); ?>">
                    <div class="results-list-view">
            		<?php
					$logged_user_pin = '';			
					$user_id = get_current_user_id( );
					$logged_user = get_user_meta($user_id,'imic_user_info_id',true);
					$logged_user_pin = get_post_meta($logged_user,'imic_user_zip_code',true);
					$badges_type = (isset($imic_options['badges_type']))?$imic_options['badges_type']:'0';
					$specification_type = (isset($imic_options['short_specifications']))?$imic_options['short_specifications']:'0';
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
						$detailed_specs = (isset($imic_options['specification_list']))?$imic_options['specification_list']:array();
					}
					else
					{
						$detailed_specs = array();
					}
					$category_rail = (isset($imic_options['category_rail']))?$imic_options['category_rail']:'0';
					$additional_specs_all = get_post_meta($additional_specs,'specifications_value',true);
					$highlighted_specs = (isset($imic_options['highlighted_specs']))?$imic_options['highlighted_specs']:array();
					$unique_specs = (isset($imic_options['unique_specs']))?$imic_options['unique_specs']:'';
					if(have_posts()):
						while(have_posts()):
							the_post();
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
								else 
								{ 
									$lat = 0; $long = 0; 
								}
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
								?>
                                <!-- Result Item -->
                                <div class="result-item format-standard">
                                <div class="result-item-image"><?php if(has_post_thumbnail()) { ?>
                         		<a href="<?php echo esc_url(get_permalink()); ?>" class="media-box"><?php the_post_thumbnail('600x400'); ?></a><?php } ?>
                            	<?php $start = 0; 
								$badge_position = array('vehicle-age','premium-listing','third-listing','fourth-listing');
								if(!empty($badges)) 
								{
									foreach($badges as $badge):
										$badge_class = ($start==0)?'default':'success';
										echo '<span class="label label-'.esc_attr($badge_class).' '.esc_attr($badge_position[$start]).'">'.esc_attr($badge).'</span>';
										$start++; 
										if($start>3) 
										{ 
											break; 
										}
									endforeach; 
								} ?>
                              	<div class="result-item-view-buttons">
                        		<?php if($video!='') 
								{ ?>
                               		<a href="<?php echo esc_attr($video); ?>" data-rel="prettyPhoto"><i class="fa fa-play"></i> <?php _e('View video','framework'); ?></a><?php } ?>
                                	<a href="<?php echo esc_url(get_permalink()); ?>"><i class="fa fa-plus"></i> <?php _e('View details','framework'); ?></a>
                             	</div>
                       		</div>
                       		<div class="result-item-in">
                           		<h4 class="result-item-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_attr($highlight_value); ?></a>
                           		<?php 
								if($category_rail=="1"&&is_plugin_active("imi-classifieds/imi-classified.php"))
								{
									echo imic_get_cats_list(get_the_ID(), "dropdown");
								}
								?>
                                </h4>               
                         	<div class="result-item-cont">
                          		<div class="result-item-block col1">
                              	<?php echo imic_excerpt(20); ?>
                           		</div>
                          		<div class="result-item-block col2">
                                	<div class="result-item-pricing">
                                   		<div class="price"><?php echo esc_attr($unique_value); ?></div>
                                 	</div>
                                   	<div class="result-item-action-buttons">
                                   	<a <?php echo esc_attr($save_icon_disable); ?> href="#" class="btn btn-default btn-sm save-car"><div class="vehicle-details-access" style="display:none;"><span class="vehicle-id"><?php echo esc_attr(get_the_ID()); ?></span></div><i class="fa <?php echo esc_attr($save_icon); ?>"></i> <?php _e('Save','framework'); ?></a>
                                 	<a href="<?php echo esc_url(get_permalink()); ?>" class="btn btn-default btn-sm"><?php _e('Enquire','framework'); ?></a><br>
                              		<div class="view-distance"><div style="display:none;"><span class="car-lat"><?php echo esc_attr($lat); ?></span><span class="car-long"><?php echo esc_attr($long); ?></span></div><a id="<?php echo esc_attr(get_the_ID()); ?>" href="#" class="distance-calc"><i class="fa fa-map-marker"></i> <?php _e('Distance from me?','framework'); ?></a>
                                		<div class="input-group">
                                       		<input type="text" value="<?php echo esc_attr($logged_user_pin); ?>" class="get-distance form-control input-sm" style="display:none;" placeholder="Enter Zipcode">
                                       		<span class="input-group-btn">
                                      		<a href="#" class="btn btn-default btn-sm search-dist" style="display:none;"><?php _e('Get','framework'); ?></a>
                                     		</span>
                                  		</div>
                                   	</div>
              					</div>
                    		</div>
                  		</div>
                     	<div class="result-item-features">
                   		<ul class="inline">
                    	<?php if(!empty($details_value)) 
								{
									foreach($details_value as $detail) 
									{
										if(!empty($detail)) 
										{
											echo '<li>'.$detail.'</li>'; 
										}
									} 
								} ?>
                  		</ul>
                	</div>
        		</div>
      		</div>
            <?php endwhile;
			endif;
			?>
            </div>
            		</div>
                    <?php if(is_active_sidebar('car-sidebar'))
					{ ?>
            		<div class="col-md-4">
            			<?php dynamic_sidebar('car-sidebar'); ?>
            		</div>
                    <?php } ?>
            	</div>
            </div>
		</div>
	</div>
<?php
get_footer();
?>