<?php
/*
Template Name: Home Second
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
$pageSidebar2 = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list2', true);
if(!empty($pageSidebar2)&&is_active_sidebar($pageSidebar2)) {
$class2 = 9;  
}else{
$class2 = 12;  
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
$details_switch = get_post_meta($id,'imic_home_details_switch',true);
$seller_switch = get_post_meta($id,'imic_home_seller_section',true);
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
$default_image_src = (isset($imic_options['default_car_image']))?$imic_options['default_car_image']['url']:'';?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full padding-b0">
            <?php if(have_posts()):while(have_posts()):the_post();
			the_content();
			endwhile; endif; ?><?php 
			if(is_plugin_active("imithemes-listing/listing.php")) {
					if($vehicle_switch==1) {
						$vehicle_count = get_post_meta($id,'imic_home_vehicle_count',true);
						$vehicle_title = get_post_meta($id,'imic_home_vehicle_title',true);
						$vehicle_column = get_post_meta($id,'imic_home_vehicle_column',true);
				?>
            <div class="dark-bg parallax parallax1" style="background-image:url(images/slide3.jpg);">
                <div class="overlay-transparent padding-tb75">
                    <div class="container">
                        <!-- Recently Listed Vehicles -->
                        <section class="listing-block recent-vehicles">
                            <div class="text-align-center">
                                <h3><?php echo esc_attr($vehicle_title); ?></h3>
                            </div>
                            <div class="listing-container">
                                <div class="carousel-wrapper">
                                    <div class="row">
                                        <ul class="owl-carousel" id="vehicle-slider" data-columns="3" data-autoplay="<?php echo esc_attr($vehicle_speed); ?>" data-pagination="yes" data-arrows="yes" data-single-item="no" data-items-desktop="3" data-items-desktop-small="3" data-items-tablet="3" data-items-mobile="1" <?php if(isset($imic_options['enable_rtl']) && $imic_options['enable_rtl']== 1){ ?>data-rtl="rtl"<?php } else { ?> data-rtl="ltr" <?php } ?>>
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
										$detailed_specs = imic_filter_lang_specs($detailed_specs);
										$additional_specs = (isset($imic_options['additional_specs']))?$imic_options['additional_specs']:array();
										$additional_spec_type = get_post_meta($additional_specs, 'imic_plugin_spec_char_type', true);
										$additional_spec_slug = imic_the_slug($additional_specs);
										$additional_spec_slug = ($additional_spec_type==2)?'char_'.$additional_spec_slug:$additional_spec_slug;
										$category_rail = (isset($imic_options['category_rail']))?$imic_options['category_rail']:'0';
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
                                                <span class="vehicle-meta"><?php $total = 1; if(!empty($details_value)) { foreach($details_value as $value) { echo esc_attr($value).', '; if($total++==4) { break; } } } ?> <?php _e('by','framework'); ?> <abbr class="user-type" title="Listed by <?php echo esc_attr($author_role); ?>"><?php echo esc_attr($author_role); ?></abbr></span>
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
                    </div>
                </div>
            </div>
        	<div class="spacer-75"></div><?php } } ?>
            <div class="container">
            <?php if($details_switch==1) {
				$shortcode = get_post_meta($id,'imic_secondary_shortcode',true);
				$shortcode_column = get_post_meta($id,'imic_home_details_column',true);
				$rest_column = 12-$shortcode_column;
				$detail_tabs = get_post_meta($id,'details_tabs',true); ?>
            	<!-- Left Column -->
                <div class="row">
                    <div class="col-md-<?php echo esc_attr($shortcode_column); ?>">
                    	<!-- Welcome text -->
                        <?php echo do_shortcode($shortcode); ?>
                    </div>
            		<!-- Right Column -->
                    <div class="col-md-<?php echo esc_attr($rest_column); ?>">
                    	<!-- Additional Service -->
                        <?php if(!empty($detail_tabs[1])) {
							foreach($detail_tabs as $tabs): ?>
                        <div class="service-block">
                        <?php if($tabs['imic_details_tabs_url']!='') { ?>
                            <a href="<?php echo esc_url($tabs['imic_details_tabs_url']); ?>"><img src="<?php echo esc_url($tabs['imic_details_tabs_image']); ?>" alt=""></a><?php } ?>
                      	<?php if($tabs['imic_details_tabs_url']=='') { ?>
                            <img src="<?php echo esc_url($tabs['imic_details_tabs_image']); ?>" alt=""><?php } ?>
                            <div class="service-block-in">
                            <?php if($tabs['imic_details_tabs_url']!='') { ?>
                                <h4><a href="<?php echo esc_url($tabs['imic_details_tabs_url']); ?>"><?php echo esc_attr($tabs['imic_details_tabs_title']); ?></a></h4><?php } ?>
                           	<?php if($tabs['imic_details_tabs_url']=='') { ?>
                                <h4><?php echo esc_attr($tabs['imic_details_tabs_title']); ?></h4><?php } ?>
                                <p><?php echo esc_attr($tabs['imic_details_tabs_content']); ?></p>
                            </div>
                        </div>
                        <?php endforeach; } ?>
                    </div>
                </div>
                <div class="spacer-60"></div><?php } if($news_switch==1) {
					$latest_news_scroll = get_post_meta($id,'imic_home_news_auto_scroll',true);
					$news_vehicle_scroll_speed = get_post_meta($id,'imic_home_news_auto_scroll_speed',true);
					$news_vehicle_scroll_speed = ($news_vehicle_scroll_speed=='')?5000:$news_vehicle_scroll_speed;
					$news_speed = ($latest_news_scroll==1)?$news_vehicle_scroll_speed:'';
					$news_title = get_post_meta(get_the_ID(),'imic_home_news_title',true);
					$news_count = get_post_meta(get_the_ID(),'imic_home_news_count',true);
					$allnews_title = get_post_meta(get_the_ID(),'imic_home_allnews_title',true);
					$allnews_url = get_post_meta(get_the_ID(),'imic_home_allnews_url',true); ?>
                <section class="listing-block latest-news">
                    <div class="listing-header">
                    <?php if($allnews_url!='') { ?>
                        <a href="<?php echo esc_url($allnews_url); ?>" class="btn btn-sm btn-default pull-right"><?php echo esc_attr($allnews_title); ?> <i class="fa fa-long-arrow-right"></i></a><?php } ?>
                        <h3><?php echo esc_attr($news_title); ?></h3>
                    </div>
                    <div class="listing-container">
                        <div class="carousel-wrapper">
                            <div class="row">
                                <ul class="owl-carousel" id="news-slider" data-columns="3" data-autoplay="<?php echo esc_attr($news_speed); ?>" data-pagination="no" data-arrows="yes" data-single-item="no" data-items-desktop="3" data-items-desktop-small="2" data-items-tablet="2" data-items-mobile="1" <?php if(isset($imic_options['enable_rtl']) && $imic_options['enable_rtl']== 1){ ?>data-rtl="rtl"<?php } else { ?> data-rtl="ltr" <?php } ?>>
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
                                                        <?php echo esc_attr_e('Posted in: ','framework'); the_category(', '); ?>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php endwhile; endif; wp_reset_postdata(); ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section><?php } ?>
            </div>
          	<div class="spacer-75"></div><?php if($seller_switch==1) {
				if(is_plugin_active("imithemes-listing/listing.php")) {
				$seller_scroll = get_post_meta($id,'imic_home_seller_auto_scroll',true);
				$seller_vehicle_scroll_speed = get_post_meta($id,'imic_home_seller_auto_scroll_speed',true);
				$seller_vehicle_scroll_speed = ($seller_vehicle_scroll_speed=='')?5000:$seller_vehicle_scroll_speed;
				$seller_speed = ($seller_scroll==1)?$seller_vehicle_scroll_speed:'';
				$seller_title = get_post_meta(get_the_ID(),'imic_home_seller_title',true);
				$seller_count = get_post_meta($id,'imic_home_seller_count',true);
				$seller_image = get_post_meta($id,'imic_home_seller_parallax_image',true); 
				$image = wp_get_attachment_image_src( $seller_image, '', '' ); ?>
            <div class="dark-bg parallax parallax2" style="background-image:url(<?php echo esc_url($image[0]); ?>);">
                <div class="overlay-transparent padding-tb75">
                    <div class="container">
                        <!-- Recently Listed Vehicles -->
                        <section class="listing-block">
                            <div class="text-align-center">
                                <h3><?php echo esc_attr($seller_title); ?></h3>
                            </div>
                            <div class="listing-container">
                                <div class="carousel-wrapper">
                                    <div class="row">
                                        <ul class="owl-carousel carousel-fw" id="vehicle-slider" data-columns="3" data-autoplay="<?php echo esc_attr($seller_speed); ?>" data-pagination="no" data-arrows="yes" data-single-item="no" data-items-desktop="3" data-items-desktop-small="2" data-items-tablet="1" data-items-mobile="1" <?php if(isset($imic_options['enable_rtl']) && $imic_options['enable_rtl']== 1){ ?>data-rtl="rtl"<?php } else { ?> data-rtl="ltr" <?php } ?>>
                                        <?php $args_user = array('post_type'=>'user','meta_query'=>array(array('key'=>'imic_user_sold_cars','order'=>'ASC')));
										$user_listing = new WP_Query( $args_user );
										if ( $user_listing->have_posts() ) :
										while ( $user_listing->have_posts() ) :	
										$user_listing->the_post();
										$total_sale = get_post_meta(get_the_ID(),'imic_user_sold_cars',true);
										$company = get_post_meta(get_the_ID(),'imic_user_company',true);
										$tagline = get_post_meta(get_the_ID(),'imic_user_company_tagline',true);
										$user_id = get_post_meta(get_the_ID(),'imic_user_reg_id',true);
										$user_avatar = get_post_meta(get_the_ID(),'imic_user_logo',true);
										$image_avatar = wp_get_attachment_image_src( $user_avatar, '', '' );
										$user_info = get_userdata($user_id); ?>
                                            <li class="item">
                                                <div class="dealer-block">
                                                    <div class="dealer-block-inner" style="background-image:url(<?php if(!empty($image_avatar)) { echo esc_url($image_avatar[0]); } ?>);">
                                                        <div class="dealer-block-cont">
                                                            <div class="dealer-block-info">
                                                                <span class="label label-default"><?php echo esc_attr($total_sale); echo esc_attr_e(' sales','framework'); ?></span>
                                                                <?php if(has_post_thumbnail()) { ?><span class="dealer-avatar"><?php the_post_thumbnail(); ?></span><?php } ?>
                                                                <h5><a href="<?php echo esc_url(get_author_posts_url($user_id)); ?>"><?php echo esc_attr($company); ?></a></h5>
                                                                <span class="meta-data"><?php echo esc_attr($tagline); ?></span>
                                                            </div>
                                                            <div class="dealer-block-text">
                                                                <?php echo imic_excerpt(10); ?>
                                                                <div class="dealer-block-add">
                                                                    <span><?php echo esc_attr_e('Member since ','framework'); ?><strong><?php if(!empty($user_info)) { echo date("M, Y", strtotime($user_info->user_registered)); } ?></strong></span>
                                                                    <span><?php echo esc_attr_e('Active listings ','framework'); ?><strong><?php echo imic_count_user_posts_by_type($user_id,'cars'); ?></strong></span>
                                                                </div>
                                                            </div>
                                                            <div class="text-align-center"><a href="<?php echo esc_url(get_author_posts_url($user_id)); ?>" class="btn btn-default"><?php echo esc_attr_e('View profile','framework'); ?></a></div>
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
                    </div>
                </div>
            </div><?php } } ?>
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
                            <a href="<?php echo esc_url($url); ?>" class="btn btn-default btn-lg"><?php echo esc_attr_e('All make &amp; models','framework'); ?></a>
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
   	</div>
    <!-- End Body Content -->
<?php get_footer(); ?>