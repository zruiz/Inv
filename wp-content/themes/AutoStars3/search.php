<?php get_header();
global $imic_options;
$event_image = $imic_options['header_image']['url'];
$pageSidebar = 'page-sidebar';
if(is_active_sidebar('page-sidebar')) {
$class = 9;  
}else{
$class = 12;  
}
?>
<!-- Start Page header -->
    <div class="page-header parallax" style="background-image:url(<?php echo esc_url($event_image); ?>);">
    	<div class="container">
        	<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'framework' ), get_search_query() ); ?></h1>
       	</div>
    </div><?php if(function_exists('bcn_display')) { ?>
    <!-- Utiity Bar -->
    <div class="utility-bar">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-8 col-sm-6 col-xs-8">
                    <ol class="breadcrumb">
                        <?php bcn_display(); ?>
                    </ol>
            	</div>
                <div class="col-md-4 col-sm-6 col-xs-4">
                </div>
            </div>
      	</div>
    </div><?php } ?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
            <div class="container">
              	<div class="row">
                	<div class="col-md-<?php echo esc_attr($class); ?> posts-archive">
                    <?php if(have_posts()):while(have_posts()):the_post(); ?>
                  		<article class="post format-standard">
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
                        <?php endwhile; else: ?>
						<article class="post format-standard">
                    		<div class="row">
                        			<h3 class="post-title"><?php echo esc_attr_e('sorry, no posts to display','framework'); ?></h3>
                      			</div>
                    		</div>
                  		</article>
						<?php endif; echo imic_pagination(); ?>
                    </div>
                    <!-- Start Sidebar -->
                    <?php if(is_active_sidebar('page-sidebar')) { ?>
                    <!-- Sidebar -->
                    <div class="col-md-3">
                    	<?php dynamic_sidebar('page-sidebar'); ?>
                    </div>
                    <?php } ?>
                    </div>
              	</div>
            </div>
        </div>
   	</div>
    <!-- End Body Content -->
<?php get_footer(); ?>