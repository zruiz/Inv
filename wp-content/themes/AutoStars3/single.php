<?php 
get_header();
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
$blog_masonry = 2;
$post_author_id = get_post_field( 'post_author', get_the_ID() );
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
} ?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
      		<div class="container">
        		<div class="row">
          			<div class="col-md-<?php echo esc_attr($class); ?> single-post">
            			<header class="single-post-header clearfix">
                            <div class="post-actions">
                                <div class="post-date"><?php echo esc_attr(get_the_date(get_option('date_format'))); ?></div>
                                <div class="comment-count"><?php if (comments_open()) { echo comments_popup_link('<i class="fa fa-comment"></i>'.__('No comments yet','framework'), '<i class="fa fa-comment"></i>1', '<i class="fa fa-comment"></i>%','pull-right meta-data', 'comments-link',__('Comments are off for this post','framework')); } ?></div>
                            </div>
              				<h2 class="post-title"><?php echo get_the_title(); ?></h2>
            			</header>
            			<article class="post-content">
                        <?php if(has_post_thumbnail(get_the_ID())) { ?>
              				<div class="featured-image"> <?php the_post_thumbnail(); ?> </div><?php } ?>
              				<?php if(have_posts()):while(have_posts()):the_post();
									the_content();
								endwhile; endif; ?>
                            <!-- Review Block -->
                            <?php $rating = get_post_meta(get_the_ID(), 'imic_post_review', false);
							$review = get_post_meta(get_the_ID(),'imic_select_post_section',true);
									if($review!=1&&!empty($rating[0])) { 
									$total_rating = '';
									foreach ($rating[0] as $rate) {
										$total_rating += $rate[0];
								} $rates = $total_rating/count($rating[0]);
							?>
                            <div class="detailed-review-block">
                            	<div class="final-review">
                                    <div class="post-review-block">
                                        <div class="review-status">
                                            <strong><?php echo esc_attr(number_format((float)$rates, 2, '.', '')); ?></strong>
                                            <span><?php echo esc_attr_e('Out of 5','framework'); ?></span>
                                        </div>
                                        <div class="star-rating-container">
                                        	<div class="star-rating" style="width:<?php echo esc_attr((($rates/5)*100)); ?>%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="points-review">
                                	<div class="row">
                                    <?php 
										$total_fields = count($rating[0]); $half = $total_fields/2; $half = (imic_is_decimal($half))?$half+1:$half; $half = floor($half);
										$st = 1;
										foreach($rating[0] as $rate) {
										$total = count($rating[0]);
										$divide = $total/2;
                                    	if($st==1||$st==$half+1) {
										echo '<div class="col-md-6">'; } ?>
                                        	<div class="review-point">
                                            	<strong><?php echo esc_attr($rate[1]); ?></strong>
                                                <div class="star-rating-container">
                                                    <div class="star-rating" style="width:<?php echo esc_attr((($rate[0]/5)*100)); ?>%"></div>
                                                </div>
                                            </div>
                                  	<?php if(($st==$half)||($st==$total_fields)) { echo '</div>'; } $st++; } ?>
                                    </div>
                                </div>
                                </div><?php } ?>
                                <div class="post-meta">
                                <i class="fa fa-archive"></i>
                                <?php the_category(', '); ?></div>
                                <?php if (has_tag()) {
									echo'<div class="post-meta">';
									echo'<i class="fa fa-tags"></i> ';
									the_tags('', ', ');
									echo'</div>';
								} ?>
                            <!-- Pagination -->
                            <ul class="pager">
                                <li class="pull-left"><?php echo previous_post_link('%link', '&larr; Prev Post'); ?></li>
                                <li class="pull-right"><?php echo next_post_link('%link', 'Next Post &rarr;'); ?></a></li>
                            </ul>
                            <!-- About Author -->
                            <?php $post_author_id = get_post_field( 'post_author', get_the_ID() );
									$logged_user = get_user_meta($post_author_id,'imic_user_info_id',true);
									$content = '';
									if(!empty($logged_user)) {
									$post_id = get_post($logged_user);
									$content = $post_id->post_content;
									$content = apply_filters('the_content', $content);
									$content = str_replace(']]>', ']]>', $content); ?>
                            <section class="about-author">
                            <?php if(has_post_thumbnail($logged_user)) { ?>
                                <div class="img-thumbnail"> <?php echo get_the_post_thumbnail($logged_user, '600x400'); ?> </div><?php } ?>
                                <div class="post-author-content">
                                    <h3><?php echo esc_attr(get_the_author_meta( 'display_name', $post_author_id )); ?> <span class="label label-success"><?php echo esc_attr_e('Author','framework'); ?></span></h3>
                               		<?php echo str_replace(']]>', ']]>', $content); ?>
                                </div>
                            </section><?php } ?>
            			</article>
                        <!-- Post Comments -->
                        <?php if ( comments_open()) { comments_template('', true); } ?> 
                    </div>
                    	<?php if(is_active_sidebar($pageSidebar)) { ?>
                    <!-- Sidebar -->
                    <div class="col-md-<?php echo esc_attr($sidebar_column); ?>">
                    	<?php dynamic_sidebar($pageSidebar); ?>
                    </div>
                    <?php } ?>
                        </div>
                    </div>
                </div>
         	</div>
    <!-- End Body Content -->
<?php get_footer(); ?>