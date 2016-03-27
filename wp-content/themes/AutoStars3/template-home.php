<?php
/*
Template Name: Home
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
$pageSidebar = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list', true);
$sidebar_column = get_post_meta(get_the_ID(),'imic_sidebar_columns_layout',true);
if(!empty($pageSidebar)&&is_active_sidebar($pageSidebar)) {
$left_col = 12-$sidebar_column;
$class = $left_col;  
}else{
$class = 12;  
}
$latest_vehicle_scroll = get_post_meta($id,'imic_home_vehicle_auto_scroll',true);
$latest_vehicle_scroll_speed = get_post_meta($id,'imic_browse_by_auto_scroll_speed',true);
$latest_vehicle_scroll_speed = ($latest_vehicle_scroll_speed=='')?5000:$latest_vehicle_scroll_speed;
$vehicle_speed = ($latest_vehicle_scroll==1)?$latest_vehicle_scroll_speed:'';
$vehicle_switch = get_post_meta($id,'imic_home_vehicle_switch',true);
$modal_search_switch = get_post_meta($id,'',true);
$news_switch = get_post_meta($id,'imic_home_news_switch',true);
$testimonial_switch = get_post_meta($id,'imic_home_testimonial_switch',true);
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
} 
else { }
$default_image_src = (isset($imic_options['default_car_image']))?$imic_options['default_car_image']['url']:''; ?>
    <!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full padding-b0">
            <div class="container">
            <?php if(have_posts()):while(have_posts()):the_post();
					the_content();
					endwhile; endif; ?>
                <!-- Recently Listed Vehicles -->
                <?php 
					if($vehicle_switch==1) {
						if(is_plugin_active("imithemes-listing/listing.php")) {
						$vehicle_count = get_post_meta($id,'imic_home_vehicle_count',true);
						$vehicle_title = get_post_meta($id,'imic_home_vehicle_title',true);
						$vehicle_column = get_post_meta($id,'imic_home_vehicle_column',true);
				?>
                <section class="listing-block recent-vehicles">
                	<div class="listing-header">
                    	<h3><?php echo esc_attr($vehicle_title); ?></h3>
                    </div>
                    <div class="listing-container">
                        <div class="carousel-wrapper">
                            <div class="row">
                                <ul class="owl-carousel carousel-fw" id="vehicle-slider" data-columns="<?php echo esc_attr($vehicle_column); ?>" data-autoplay="<?php echo esc_attr($vehicle_speed); ?>" data-pagination="yes" data-arrows="no" data-single-item="no" data-items-desktop="<?php echo esc_attr($vehicle_column); ?>" data-items-desktop-small="3" data-items-tablet="2" data-items-mobile="1" <?php if(isset($imic_options['enable_rtl']) && $imic_options['enable_rtl']== 1){ ?>data-rtl="rtl"<?php } else { ?> data-rtl="ltr" <?php } ?>>
                                <?php 	
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
										if($specification_type==0)
										{
											$detailed_specs = (isset($imic_options['vehicle_specs']))?$imic_options['vehicle_specs']:array();
										
										}
										else
										{
											$detailed_specs = array();
										}
										$category_rail = (isset($imic_options['category_rail']))?$imic_options['category_rail']:'0';
										$additional_specs = (isset($imic_options['additional_specs']))?$imic_options['additional_specs']:array();
										$additional_spec_type = get_post_meta($additional_specs, 'imic_plugin_spec_char_type', true);
										$additional_spec_slug = imic_the_slug($additional_specs);
										$additional_spec_slug = ($additional_spec_type==2)?'char_'.$additional_spec_slug:$additional_spec_slug;
										$additional_specs_all = get_post_meta($additional_specs,'specifications_value',true);
										$highlighted_specs = (isset($imic_options['highlighted_specs']))?$imic_options['highlighted_specs']:array();
										$unique_specs = (isset($imic_options['unique_specs']))?$imic_options['unique_specs']:'';	
										$args_cars = array('post_type'=>'cars','posts_per_page'=>$vehicle_count,'post_status'=>'publish','meta_query'=>array('relation' => 'AND',array('key'=>'imic_plugin_ad_payment_status','value'=>'1','compare'=>'='),array('key' => 'imic_plugin_listing_end_dt','value' => date('Y-m-d'),'compare' => '>=')));
										$cars_listing = new WP_Query( $args_cars );
										if ( $cars_listing->have_posts() ) :
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
										$highlight_value = ($highlight_value!='')?$highlight_value:get_the_title();
										$details_value = imic_vehicle_all_specs(get_the_ID(),$detailed_specs,$specifications);
										$data_ser_type = (get_option('imic_specifications_upd_st')!=1)?0:get_option('imic_specifications_upd_st');
										if(!empty($additional_specs)) {
											if($data_ser_type=="0")
											{
												$image_key = array_search($additional_specs, $specifications['sch_title']);
												$additional_specs_value = $specifications['start_time'][$image_key];
											}
											else
											{
												 $img_char = imic_the_slug($additional_specs);
												 $additional_specs_value = get_post_meta(get_the_ID(), 'char_'.$img_char, true);
											}
										$this_key = find_car_with_position($additional_specs_all,$additional_specs_value);
										$img_src = $additional_specs_all[$this_key]['imic_plugin_spec_image']; }
										$badges = imic_vehicle_all_specs(get_the_ID(),$badge_ids,$specifications);
										?>
                                    <li class="item">
                                        <div class="vehicle-block format-standard">
                                        <?php if(has_post_thumbnail()) { ?>
                                            <a href="<?php echo esc_url(get_permalink()); ?>" class="media-box"><?php the_post_thumbnail(); ?></a><?php }
																						else 
																						{
																							echo '<a href="'.esc_url(get_permalink()).'" class="media-box"><img src="'.$default_image_src.'"></a>';
																						} ?>
                                            <div class="vehicle-block-content">
                                            <?php $start = 1; 
													$badge_position = array('vehicle-age','premium-listing','third-listing','fourth-listing');
													foreach($badges as $badge):
														$badge_class = ($start==1)?'default':'success';
														echo '<span class="label label-'.esc_attr($badge_class).' '.esc_attr($badge_position[$start-1]).'">'.esc_attr($badge).'</span>';
													$start++;
													if($start==4) { break; }
													endforeach;
													if(!empty($highlight_value)) { ?>
                                                <h5 class="vehicle-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_attr($highlight_value); ?></a></h5><?php } ?>
                                                <span class="vehicle-meta"><?php $total = 1; 
																								if(!empty($details_value)) 
																								{ 
																								foreach($details_value as $value) 
																								{ 
																								echo esc_attr($value).', '; 
																								if($total++==4) { break; } 
																								} 
																								} ?> <?php _e('by','framework'); ?> <abbr class="user-type" title="Listed by <?php echo esc_attr($author_role); ?>"><?php echo esc_attr($author_role); ?></abbr></span>
                                                <?php if($img_src!='') {
																									$speci_value = $additional_specs_all[$this_key]['imic_plugin_specification_values'];
																									$speci_value = str_replace(' ', '%20', $speci_value); ?>
                                                <a href="<?php echo esc_url(add_query_arg($additional_spec_slug, $speci_value,$browse_listing)); ?>" title="<?php _e('View all','framework'); echo esc_attr($additional_specs_all[$this_key]['imic_plugin_specification_values']); ?>" class="vehicle-body-type"><img src="<?php echo esc_url($additional_specs_all[$this_key]['imic_plugin_spec_image']); ?>" alt=""></a><?php } ?>
                                                <span class="vehicle-cost"><?php echo esc_attr($unique_value); ?></span>
                                                <?php 
												if($category_rail=="1"&&is_plugin_active("imi-classifieds/imi-classified.php"))
												{
													echo imic_get_cats_list(get_the_ID(), "list");
												}
												?>
                                            </div>
                                        </div>
                                    </li>
                                    <?php endwhile; endif; wp_reset_postdata(); ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="spacer-60"></div>
                <?php } } if($news_switch==1||$testimonial_switch==1) {
					$latest_news_scroll = get_post_meta($id,'imic_home_news_auto_scroll',true);
					$news_vehicle_scroll_speed = get_post_meta($id,'imic_home_news_auto_scroll_speed',true);
					$news_vehicle_scroll_speed = ($news_vehicle_scroll_speed=='')?5000:$news_vehicle_scroll_speed;
					$news_speed = ($latest_news_scroll==1)?$news_vehicle_scroll_speed:'';
					$news_title = get_post_meta(get_the_ID(),'imic_home_news_title',true);
					$news_count = get_post_meta(get_the_ID(),'imic_home_news_count',true);
					$allnews_title = get_post_meta(get_the_ID(),'imic_home_allnews_title',true);
					$allnews_url = get_post_meta(get_the_ID(),'imic_home_allnews_url',true); ?>
             	<div class="row">
                    <!-- Latest News -->
                    <div class="col-md-<?php echo esc_attr($class); ?> col-sm-6">
                        <section class="listing-block latest-news">
                            <div class="listing-header">
                            	<?php if($allnews_url!=''&&$allnews_url!='') { ?>
                            	<a href="<?php echo esc_url($allnews_url); ?>" class="btn btn-sm btn-default pull-right"><?php echo esc_attr($allnews_title); ?></a><?php } ?>
                                <h3><?php echo esc_attr($news_title); ?></h3>
                            </div>
                            <div class="listing-container">
                            	<div class="carousel-wrapper">
                                    <div class="row">
                                        <ul class="owl-carousel" id="news-slider" data-columns="2" data-autoplay="<?php echo esc_attr($news_speed); ?>" data-pagination="yes" data-arrows="yes" data-single-item="no" data-items-desktop="2" data-items-desktop-small="1" data-items-tablet="2" data-items-mobile="1" <?php if(isset($imic_options['enable_rtl']) && $imic_options['enable_rtl']== 1){ ?>data-rtl="rtl"<?php } else { ?> data-rtl="ltr" <?php } ?>>
                                        <?php $args_post = array('post_type'=>'post','posts_per_page'=>$news_count);
										$post_listing = new WP_Query( $args_post );
										if ( $post_listing->have_posts() ) : 
										while ( $post_listing->have_posts() ) :	
											$post_listing->the_post(); ?>
                                            <li class="item">
                                                <div class="post-block format-standard"><?php if(has_post_thumbnail()) { ?>
                                                    <a href="<?php echo esc_url(get_permalink()); ?>" class="media-box post-image"><?php the_post_thumbnail('600x400'); ?></a><?php } ?>
                                                    <div class="post-actions">
                                                        <div class="post-date"><?php echo esc_attr(get_the_date(get_option('date_format'),get_the_ID())); ?></div>
                                                        <div class="comment-count"><?php  comments_popup_link('<i class="icon-dialogue-text"></i>','<i class="icon-dialogue-text"></i>','<i class="icon-dialogue-text"></i>','comments-go','<i class="icon-dialogue-text"></i>'); ?></div>
                                                    </div>
                                                    <h3 class="post-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo get_the_title(); ?></a></h3>
                                                    <div class="post-content">
                                                        <?php echo imic_excerpt(10); ?>
                                                    </div>
                                                    <div class="post-meta">
                                                        <?php _e('Posted in: ','framework'); the_category(', '); ?>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php endwhile; endif; wp_reset_postdata(); ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                      	</section>
                		<div class="spacer-40"></div>
                        <!-- Latest Testimonials -->
                        <?php if($testimonial_switch==1) {
							if(is_plugin_active("imithemes-listing/listing.php")) {
							$testimonial_scroll = get_post_meta($id,'imic_home_home_testimonial_auto_scroll',true);
							$testimonial_vehicle_scroll_speed = get_post_meta($id,'imic_home_home_testimonial_auto_scroll_speed',true);
							$testimonial_vehicle_scroll_speed = ($testimonial_vehicle_scroll_speed=='')?5000:$testimonial_vehicle_scroll_speed;
							$testimonial_speed = ($testimonial_scroll==1)?$testimonial_vehicle_scroll_speed:'';
							$testimonial_title = get_post_meta(get_the_ID(),'imic_home_testimonial_title',true);
							$testimonial_count = get_post_meta(get_the_ID(),'imic_home_testimonial_count',true); ?>
                        <section class="listing-block latest-testimonials">
                            <div class="listing-header">
                                <h3><?php echo esc_attr($testimonial_title); ?></h3>
                            </div>
                            <div class="listing-container">
                            	<div class="carousel-wrapper">
                                    <div class="row">
                                        <ul class="owl-carousel carousel-fw" id="testimonials-slider" data-columns="2" data-autoplay="<?php echo esc_attr($testimonial_speed); ?>" data-pagination="no" data-arrows="no" data-single-item="no" data-items-desktop="2" data-items-desktop-small="1" data-items-tablet="1" data-items-mobile="1" <?php if(isset($imic_options['enable_rtl']) && $imic_options['enable_rtl']== 1){ ?>data-rtl="rtl"<?php } else { ?> data-rtl="ltr" <?php } ?>>
                                        <?php $args_testimonial = array('post_type'=>'testimonial','posts_per_page'=>$testimonial_count);
												$testimonial_listing = new WP_Query( $args_testimonial );
												if ( $testimonial_listing->have_posts() ) :
													while ( $testimonial_listing->have_posts() ) :	
														$testimonial_listing->the_post();
												$company = get_post_meta(get_the_ID(),'imic_company_name',true);
												$company_url = get_post_meta(get_the_ID(),'imic_company_url',true); ?>
                                            <li class="item">
                                                <div class="testimonial-block">
                                                    <blockquote>
                                                        <?php echo imic_excerpt(20); ?>
                                                    </blockquote>
                                                    <?php if(has_post_thumbnail()) {
														$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), '100x100' ); ?>
                                                    <div class="testimonial-avatar"><img src="<?php echo esc_url($thumb[0]); ?>" width="60" height="60"></div><?php } ?>
                                                    <div class="testimonial-info">
                                                        <div class="testimonial-info-in">
                                                            <strong><?php the_title(); ?></strong>
                                                            <?php if($company_url=='') { ?><span><?php echo esc_attr($company); ?></span>
															<?php } elseif($company!=''&&$company_url!='') { ?>
                                                            <a href="<?php echo esc_url($company_url); ?>"><span><?php echo esc_attr($company); ?></span></a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php endwhile; endif; wp_reset_postdata(); ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <?php } } ?>
                    </div><?php } ?>
                    <!-- Latest Reviews -->
                    <?php if(is_active_sidebar($pageSidebar)) { ?>
                    <div class="col-md-<?php echo esc_attr($sidebar_column); ?> col-sm-6 sidebar">
                        <?php dynamic_sidebar('main-sidebar'); ?>
                    </div>
                    <?php } ?>
              	</div>
           	</div>
            <div class="spacer-50"></div>
            <?php if($make_search_switch==1) {
				if(is_plugin_active("imithemes-listing/listing.php")) {
				$specification_scroll = get_post_meta($id,'imic_home_search_specification_auto_scroll',true);
				$specification_vehicle_scroll_speed = get_post_meta($id,'imic_home_search_specification_auto_scroll_speed',true);
				$specification_vehicle_scroll_speed = ($specification_vehicle_scroll_speed=='')?5000:$specification_vehicle_scroll_speed;
				$specification_speed = ($specification_scroll==1)?$specification_vehicle_scroll_speed:'';
				$search_by_spec_value = get_post_meta(get_the_ID(),'imic_search_by_specification',true);
				$title = get_post_meta(get_the_ID(),'imic_search_by_specification_title',true);
				$url = get_post_meta(get_the_ID(),'imic_search_by_specification_url',true);
				$search_listing = imic_get_template_url("template-listing.php");
				$spec_int = get_post_meta($search_by_spec_value,'imic_plugin_spec_char_type',true);
				if($spec_int==0) {
				$slug = imic_the_slug($search_by_spec_value); }
				else {
				$slug = "int_".imic_the_slug($search_by_spec_value); }
				if(!empty($search_by_spec_value)) {
				?>
            <div class="lgray-bg make-slider">
            	<div class="container">
                    <!-- Search by make -->
                    <div class="row">
                        <div class="col-md-3 col-sm-4">
                            <h3><?php echo esc_attr($title); ?> </h3>
                            <?php if($url!='') { ?>
                            <a href="<?php echo esc_url($url); ?>" class="btn btn-default btn-lg"><?php _e('All make &amp; models','framework'); ?></a><?php } ?>
                        </div>
                        <div class="col-md-9 col-sm-8">
                            <div class="row">
                                <ul class="owl-carousel" id="make-carousel" data-columns="5" data-autoplay="<?php echo esc_attr($specification_speed); ?>" data-pagination="no" data-arrows="no" data-single-item="no" data-items-desktop="5" data-items-desktop-small="4" data-items-tablet="3" data-items-mobile="3" <?php if(isset($imic_options['enable_rtl']) && $imic_options['enable_rtl']== 1){ ?>data-rtl="rtl"<?php } else { ?> data-rtl="ltr" <?php } ?>>
                                <?php $values = get_post_meta($search_by_spec_value,'specifications_value',true);
										if(!empty($values))
										{
										foreach($values as $value) {
											$imgs = $value['imic_plugin_spec_image']; ?>
                                    <li class="item"> <a href="<?php echo esc_url(add_query_arg($slug, $value['imic_plugin_specification_values'],$search_listing)); ?>"><img src="<?php echo esc_url($imgs); ?>" alt=""></a></li>
                             	<?php 	} 
										}?>
                            	</ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div><?php } } } ?>
        </div>
   	</div>
    <!-- End Body Content -->
<?php get_footer(); ?>