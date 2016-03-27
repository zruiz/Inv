<?php get_header();
global $imic_options;
$user = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); 
$user_info_id = get_user_meta($user->ID,'imic_user_info_id',true);
$facebook = get_post_meta($user_info_id,'imic_user_facebook',true);
$twitter = get_post_meta($user_info_id,'imic_user_twitter',true);
$gplus = get_post_meta($user_info_id,'imic_user_gplus',true);
$pinterest = get_post_meta($user_info_id,'imic_user_pinterest',true);
$company = get_post_meta($user_info_id,'imic_user_company',true);
$userFirstName = get_the_author_meta('first_name', $user->ID);
$userLastName = get_the_author_meta('last_name', $user->ID);
$userName = $user->display_name;
if(!empty($userFirstName) || !empty($userLastName)) {
	$userName = $userFirstName .' '. $userLastName; 
}
$name = ($company!='')?$company:$userName;
$tagline = get_post_meta($user_info_id,'imic_user_company_tagline',true);
$website = get_post_meta($user_info_id,'imic_user_website',true);
$user_info = get_userdata($user->ID);
$user_avatar = get_post_meta($user_info_id,'imic_user_logo',true);
$image_avatar = wp_get_attachment_image_src( $user_avatar, '', '' );
?>
<div class="page-header parallax clearfix" style="background-image:url(<?php if(!empty($image_avatar)) { echo esc_url($image_avatar[0]); } ?>);">
<div class="container">
        <h1 class="page-title"></h1>
    </div>
</div>
<?php
if(is_plugin_active("imithemes-listing/listing.php")) { ?>
    <!-- End Page Header -->
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full dealer-prosite">
          	<header class="dealer-info">
        		<div class="container">
                	<div class="row">
                    	<div class="col-md-3 col-sm-4 col-xs-6">
                            <ul class="social-icons social-icons-colored inversed rounded">
                            <?php if($facebook!='') { ?>
                                <li class="facebook"><a href="<?php echo esc_url($facebook); ?>"><i class="fa fa-facebook"></i></a></li><?php } if($twitter!='') {  ?>
                                <li class="twitter"><a href="<?php echo esc_url($twitter); ?>"><i class="fa fa-twitter"></i></a></li><?php } if($gplus!='') { ?>
                                <li class="googleplus"><a href="<?php echo esc_url($gplus); ?>"><i class="fa fa-google-plus"></i></a></li><?php } if($pinterest!='') { ?>
                                <li class="pinterest"><a href="<?php echo esc_url($pinterest); ?>"><i class="fa fa-pinterest"></i></a></li><?php } ?>
                            </ul>
                        </div>
                        <?php $default_image = (isset($imic_options['default_dealer_image']))?$imic_options['default_dealer_image']:array('url'=>''); ?>
                        <div class="col-md-6 col-sm-4">
                        	<div class="dealer-avatar"><?php if(has_post_thumbnail($user_info_id)) { ?><?php echo get_the_post_thumbnail($user_info_id); ?><?php } else { ?><img src="<?php echo esc_url($default_image['url']); ?>" alt=""><?php } ?></div>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-6">
                            <div class="dealer-block-add">
                                <span><?php echo esc_attr_e('Member since ','framework'); ?><strong><?php echo esc_attr(date("M, Y", strtotime($user_info->user_registered)));?></strong></span>
                                <span><?php echo esc_attr_e('Active listings ','framework'); ?><strong><?php echo esc_attr(imic_count_user_posts_by_type($user->ID,'cars')); ?></strong></span>
                            </div>
                        </div>
                    </div>
           		</div>
         	</header>
            <div class="container">
                <div class="text-align-center">
                    <h2 class="margin-0"><?php echo esc_attr($name); ?></h2>
                    <?php if($tagline!='') { ?>
                    <p class="meta-data"><?php echo esc_attr($tagline); ?></p><?php } if($website!='') { ?>
                   	<a href="<?php echo esc_url($website); ?>" class="btn btn-default btn-rounded"><?php echo esc_attr_e('Visit website','framework'); ?></a><?php } ?>
                </div>
                <div class="spacer-75"></div>
            	<div class="row">
                	<?php $post_id = get_post($user_info_id);
						$content = $post_id->post_content;
						$content = apply_filters('the_content', $content);
						echo str_replace(']]>', ']]>', $content); ?>
                </div>
                <div class="spacer-75"></div>
                                <?php
								$badge_ids = $imic_options['badge_specs'];
								$additional_specs = $imic_options['additional_specs'];
										$detailed_specs = $imic_options['specification_list'];
										$additional_specs_all = get_post_meta($additional_specs,'specifications_value',true);
										$highlighted_specs = $imic_options['highlighted_specs'];
										$unique_specs = $imic_options['unique_specs'];	
									$args_cars = array('post_type'=>'cars','posts_per_page'=>-1,'post_status'=>'publish','author'=>$user->ID,'meta_query'=>array(array('key'=>'imic_plugin_ad_payment_status','value'=>'1','compare'=>'=')));
									$cars_listing = new WP_Query( $args_cars );
									if ( $cars_listing->have_posts() ) : ?>
										<!-- Recently Listed Vehicles -->
                            <section class="listing-block recent-vehicles">
                                <div class="listing-header">
                                    <h3><?php echo esc_attr_e('Our Recently Listed Vehicles','framework'); ?></h3>
                                </div>
                                <div class="listing-container">
                                    <div class="carousel-wrapper">
                                        <div class="row">
                                            <ul class="owl-carousel carousel-fw" id="vehicle-slider" data-columns="4" data-autoplay="" data-pagination="yes" data-arrows="no" data-single-item="no" data-items-desktop="4" data-items-desktop-small="3" data-items-tablet="2" data-items-mobile="1" <?php if(isset($imic_options['enable_rtl']) && $imic_options['enable_rtl']== 1){ ?>data-rtl="rtl"<?php } else { ?> data-rtl="ltr" <?php } ?>>
									<?php while ( $cars_listing->have_posts() ) :	
											$cars_listing->the_post();
										$specifications = get_post_meta(get_the_ID(),'feat_data',true);
										$unique_value = imic_vehicle_price(get_the_ID(),$unique_specs,$specifications);
										$new_highlighted_specs = imic_filter_lang_specs_admin($highlighted_specs, get_the_ID());
										$highlighted_specs = $new_highlighted_specs;
										$highlight_value = imic_vehicle_title(get_the_ID(),$highlighted_specs,$specifications);
										$details_value = imic_vehicle_all_specs(get_the_ID(),$detailed_specs,$specifications);
										$badges = imic_vehicle_all_specs(get_the_ID(),$badge_ids,$specifications);
										?>
                                    <li class="item">
                                        <div class="vehicle-block format-standard">
                                            <a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>" class="media-box"><?php the_post_thumbnail(); ?></a>
                                            <?php $start = 0; 
													$badge_position = array('vehicle-age','premium-listing','third-listing','fourth-listing');
													if(!empty($badges)) {
													foreach($badges as $badge):
														$badge_class = ($start==0)?'default':'success';
														echo '<span class="label label-'.esc_attr($badge_class).' '.esc_attr($badge_position[$start]).'">'.esc_attr($badge).'</span>';
													$start++; if($start>3) { break; }
													endforeach; } ?>
                                            <h5 class="vehicle-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_attr($highlight_value); ?></a></h5>
                                            <ul class="inline">
                                                <?php if(!empty($details_value)) {
													foreach($details_value as $detail) {
														if(!empty($detail)) {
														echo '<li>'.esc_attr($detail).'</li>'; }
													} } ?>
                                            </ul>
                                            <span class="vehicle-cost"><?php echo esc_attr($unique_value); ?></span>
                                        </div>
                                    </li>
                                    <?php endwhile; ?>
                                    </ul>
                            </div>
                        </div>
                    </div>
                </section>
                                    <?php endif; wp_reset_postdata(); ?>
           	</div>
        </div>
   	</div>
    <!-- End Body Content -->
<?php  } else { ?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
            <div class="container">
              	<div class="row">
                	<div class="col-md-9 posts-archive">
                    <?php if(have_posts()):while(have_posts()):the_post(); ?>
                  		<article <?php post_class('post format-standard'); ?>>
                    		<div class="row">
                            <?php $content_class = 12; if(has_post_thumbnail(get_the_ID())) { $content_class = 8; ?>
                      			<div class="col-md-4 col-sm-4"> <a href="<?php echo esc_url(get_permalink()); ?>"><?php the_post_thumbnail('600x400',array('class'=>'img-thumbnail')); ?></a> </div><?php } ?>
                      			<div class="col-md-<?php echo esc_attr($content_class); ?> col-sm-<?php echo esc_attr($content_class); ?>">
                                    <div class="post-actions">
                                        <div class="post-date"><?php echo esc_attr(get_the_date(get_option('date_format'))); ?></div>
                                        <div class="comment-count"><?php if (comments_open()) { echo comments_popup_link('<i class="fa fa-comment"></i>'.__('No comments yet','framework'), '<i class="fa fa-comment"></i>1', '<i class="fa fa-comment"></i>%','pull-right meta-data', 'comments-link',__('Comments are off for this post','framework')); } ?></div>
                                    </div>
                        			<h3 class="post-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h3>
                        			<?php echo imic_excerpt(35); ?>
                                     <a href="<?php echo esc_url(get_permalink()); ?>" class="continue-reading"><?php echo esc_attr_e('Continue reading','framework'); ?> <i class="fa fa-long-arrow-right"></i></a></p>
                                   	<div class="post-meta"><?php echo esc_attr_e('Posted in:','framework'); ?> <?php the_category(' '); ?></div>
                      			</div>
                    		</div>
                  		</article>
                        <?php endwhile; endif; if(function_exists('imic_pagination')) { imic_pagination(); } else { next_posts_link( 'Older Entries');
previous_posts_link( 'Newer Entries' ); } ?>
                    </div>
                    <!-- Start Sidebar -->
                    <?php if(is_active_sidebar('post-sidebar')) { ?>
                    <!-- Sidebar -->
                    <div class="col-md-3">
                    	<?php dynamic_sidebar('post-sidebar'); ?>
                    </div>
                    <?php } ?>
                    </div>
              	</div>
            </div>
        </div>
   	</div>
    <!-- End Body Content -->
<?php } get_footer(); ?>