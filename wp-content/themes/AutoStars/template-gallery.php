<?php
/*
Template Name: Gallery
*/
get_header();
wp_enqueue_script( 'imic_jquery_flexslider' );
wp_enqueue_script('imic_magnific_gallery');
wp_enqueue_script('imic_sg');
if(is_home()) { $id = get_option('page_for_posts'); }
else { $id = get_the_ID(); }
$page_header = get_post_meta($id,'imic_pages_Choose_slider_display',true);
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
if(is_plugin_active("imithemes-listing/listing.php")) {
$pageSidebar = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list', true);
$sidebar_column = get_post_meta(get_the_ID(),'imic_sidebar_columns_layout',true);
if(!empty($pageSidebar)&&is_active_sidebar($pageSidebar)) {
$left_col = 12-$sidebar_column;
$class = $left_col;  
}else{
$class = 12;  
}
$title_content = get_post_meta($id,'imic_gallery_title_content',true);
$gallery_filter = get_post_meta(get_the_ID(),'imic_gallery_secondary_bar_type_status',true);
$column_class = get_post_meta(get_the_ID(),'imic_projects_columns_layout',true);
$gallery_pagination = get_post_meta(get_the_ID(),'imic_gallery_page_pagination',true);
$gallery_numbers = get_post_meta(get_the_ID(),'imic_gallery_number_show',true);
$gallery_numbers = ($gallery_numbers=='')?-1:$gallery_numbers;
$gallery_category = get_post_meta(get_the_ID(),'imic_advanced_gallery_taxonomy',true);
				if($gallery_category!=''){
				$gallery_categories= get_term_by('id',$gallery_category,'gallery-category');
				if(!empty($gallery_categories)){
				$gallery_category= $gallery_categories->slug; }}
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
            <div class="gallery-filter">
            <?php //Gallery Filters
				if($gallery_filter=='1'&&$gallery_category=='') { ?>
            <ul class="nav nav-pills sort-source" data-sort-id="gallery" data-option-key="filter">
              	<?php $gallery_cats = get_terms("gallery-category");?>
                                            <li data-option-value="*" class="active"><a href="#"> <?php echo esc_attr_e('Show All','framework'); ?></a></li>
                                     	<?php foreach($gallery_cats as $gallery_cat) { ?>
                                            <li data-option-value=".<?php echo esc_attr($gallery_cat->slug); ?>"><a href="#"><?php if($gallery_cat->description!='') { echo '<i class="fa '.$gallery_cat->description.'"></i>'; } ?> <span><?php echo esc_attr($gallery_cat->name); ?></span></a></li>
                                    	<?php } ?>
            </ul>
            </div>
            <?php } ?>
                <div class="row">
                <div class="col-md-<?php echo esc_attr($class); ?> col-sm-<?php echo esc_attr($class); ?>">
                <div class="row">
                  	<ul class="sort-destination gallery-grid" data-sort-id="gallery">
                    <?php //Query for Gallery Post Type
					$paged = (get_query_var('paged'))?get_query_var('paged'):1;
				$args_gallery = array('post_type'=>'gallery','gallery-category'=>$gallery_category,'paged'=>$paged,'posts_per_page'=>$gallery_numbers);
				$gallery_listing = new WP_Query( $args_gallery );
				if ( $gallery_listing->have_posts() ) :
				while ( $gallery_listing->have_posts() ) :	
				$gallery_listing->the_post();
				$post_format = get_post_format();
				$post_format = ($post_format=="")?"image":$post_format;
				get_template_part('gallery',$post_format); ?>
                        <?php endwhile; else:
						get_template_part('gallery','none');
						endif; ?>
                  	</ul>
                    
                    </div>
                    <?php if($gallery_pagination==1) { imic_pagination($gallery_listing->max_num_pages); } wp_reset_postdata();  ?>
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
<?php } else { ?>
<div class="main" role="main">
    	<div id="content" class="content full">
    		<div class="container">
            	<div class="text-align-center error-404">
            		<h1 class="huge"><?php echo esc_attr_e('Sorry','framework'); ?></h1>
              		<hr class="sm">
              		<p><strong><?php echo esc_attr_e('Sorry - Plugin not active','framework'); ?></strong></p>
					<p><?php echo esc_attr_e('Please install and activate required plugins of theme.','framework'); ?></p>
             	</div>
            </div>
        </div>
   	</div>
<?php } get_footer(); ?>