<?php
get_header();
//Template Banner Functionality
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
$pageSidebar = get_post_meta($id,'imic_select_sidebar_from_list', true);
$sidebar_column = get_post_meta($id,'imic_sidebar_columns_layout',true);
if(!empty($pageSidebar)&&is_active_sidebar($pageSidebar)) {
$left_col = 12-$sidebar_column;
$class = $left_col;  
}else{
$class = 12;  
} 
$blog_masonry = 0;
$browse_specification_switch = get_post_meta(get_the_ID(),'imic_browse_by_specification_switch',true);
$browse_listing = imic_get_template_url("template-listing.php");
if($browse_specification_switch==1) {
get_template_part('bar','one'); 
} elseif($browse_specification_switch==2) {
get_template_part('bar','two');
} elseif($browse_specification_switch==3) { 
get_template_part('bar','saved');
}
else
{
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
                	<div class="col-md-<?php echo esc_attr($class); ?> posts-archive">
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