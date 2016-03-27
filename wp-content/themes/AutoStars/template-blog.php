<?php
/*
Template Name: Blog
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
$pageSidebar = get_post_meta($id,'imic_select_sidebar_from_list', true);
$sidebar_column = get_post_meta($id,'imic_sidebar_columns_layout',true);
if(!empty($pageSidebar)&&is_active_sidebar($pageSidebar)) {
$left_col = 12-$sidebar_column;
$class = $left_col;  
}else{
$class = 12;  
}
$post_count = get_post_meta($id,'imic_blog_post_count',true);
$post_count = ($post_count!='')?$post_count:get_option('posts_per_page');
$column = get_post_meta($id,'imic_blog_column',true);
$layout = get_post_meta($id,'imic_blog_layout',true);
$classic_class = ($layout==1)?'posts-archive':'';
$post_type = get_post_meta($id,'imic_blog_post_type',true);
$array = array();
if($post_type==1) {
	$array = array('key'=>'imic_select_post_section','value'=>'1','compare'=>'=');
}
elseif($post_type==2) {
	$array = array('key'=>'imic_select_post_section','value'=>'0','compare'=>'=');
}
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
} else { }?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
            <div class="container">
            <div class="row">
                <div class="col-md-<?php echo esc_attr($class.' '.$classic_class); ?>">
                <?php $paged = (get_query_var('paged'))?get_query_var('paged'):1;
				$args_post = array('post_type'=>'post','paged'=>$paged,'posts_per_page'=>$post_count,'meta_query'=>array($array)); ?>
                <?php if($layout==0) { ?>
            	<ul class="grid-holder col-<?php echo esc_attr($column); ?> posts-grid">
                <?php $post_listing = new WP_Query( $args_post );
					if ( $post_listing->have_posts() ) :
					while ( $post_listing->have_posts() ) :	
					$post_listing->the_post(); ?>
              		<li class="grid-item post format-standard">
                		<div class="grid-item-inner">
                        <?php if(has_post_thumbnail(get_The_ID())) { ?>
                        	<a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>" class="media-box"><?php the_post_thumbnail('600x400'); ?></a><?php } ?>
                  			<div class="grid-content">
                                <div class="post-actions">
                                    <div class="post-date"><?php echo esc_attr(date_i18n(get_option('date_format'))); ?></div>
                                    <div class="comment-count"><?php if (comments_open()) { echo comments_popup_link('<i class="fa fa-comment"></i>'.__('No comments yet','framework'), '<i class="fa fa-comment"></i>1', '<i class="fa fa-comment"></i>%','pull-right meta-data', 'comments-link',__('Comments are off for this post','framework')); } ?></div>
                                </div>
                                <h3 class="post-title"><a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><?php echo get_the_title(); ?></a></h3>
                                <?php echo imic_excerpt(35); ?>
                                <a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>" class="continue-reading"><?php echo esc_attr_e('Continue reading','framework'); ?> <i class="fa fa-long-arrow-right"></i></a></p>
                                <div class="post-meta"><?php echo esc_attr_e('Posted in:','framework'); ?> <?php the_category(', '); ?></div>
                      		</div>
                		</div>
                 	</li>
            	<?php endwhile; else: ?>
					<li class="grid-item post format-standard">
                		<div class="grid-item-inner">
                  			<div class="grid-content">
                                <h3 class="post-title"><?php echo esc_attr_e('No Posts to display','framework'); ?></h3>
                      		</div>
                		</div>
                 	</li>
				<?php endif; ?>
               	</ul>
                <?php } else {
						$post_listing = new WP_Query( $args_post );
					if ( $post_listing->have_posts() ) :
					while ( $post_listing->have_posts() ) :	
					$post_listing->the_post();
						$thumb_class = 12; ?>
				<article class="post format-standard">
                    		<div class="row">
                            <?php if(has_post_thumbnail(get_the_ID())) { $thumb_class = 8; ?>
                      			<div class="col-md-4 col-sm-4"> <a href="<?php echo esc_url(get_permalink()); ?>"><?php the_post_thumbnail('600x400',array('class'=>'img-thumbnail')); ?></a> </div><?php } ?>
                      			<div class="col-md-<?php echo esc_attr($thumb_class); ?> col-sm-<?php echo esc_attr($thumb_class); ?>">
                                    <div class="post-actions">
                                        <div class="post-date"><?php echo esc_attr(get_the_date(get_option('date_format'))); ?></div>
                                        <div class="comment-count"><?php if (comments_open()) { echo comments_popup_link('<i class="fa fa-comment"></i>'.__('No comments yet','framework'), '<i class="fa fa-comment"></i>1', '<i class="fa fa-comment"></i>%','pull-right meta-data', 'comments-link',__('Comments are off for this post','framework')); } ?></div>
                                    </div>
                        			<h3 class="post-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h3>
                        			<?php echo imic_excerpt(35); ?>
                                    <a href="<?php echo esc_url(get_permalink()); ?>" class="continue-reading"><?php echo esc_attr_e('Continue reading','framework'); ?> <i class="fa fa-long-arrow-right"></i></a></p>
                                   	<div class="post-meta"><?php echo esc_attr_e('Posted in:','framework'); ?> <?php the_category(', '); ?></div>
                      			</div>
                    		</div>
                  		</article>
				<?php endwhile; else: ?>
					<li class="grid-item post format-standard">
                		<div class="grid-item-inner">
                  			<div class="grid-content">
                                <h3 class="post-title"><?php echo esc_attr_e('No Posts to display','framework'); ?></h3>
                      		</div>
                		</div>
                 	</li>
				<?php endif; } imic_pagination($post_listing->max_num_pages); wp_reset_postdata(); ?>
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