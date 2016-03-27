<?php 
/*
Template Name: Dealer Search
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
if(is_plugin_active("imithemes-listing/listing.php")) {
$pageSidebar = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list', true);
$sidebar_column = get_post_meta(get_the_ID(),'imic_sidebar_columns_layout',true);
if(!empty($pageSidebar)&&is_active_sidebar($pageSidebar)) {
$left_col = 12-$sidebar_column;
$class = $left_col;  
}else{
$class = 12;  
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
    	<div id="content" class="content full padding-b0">
        	<div class="container">
            <div class="row">
            <div class="col-md-<?php echo esc_attr($class); ?>">
            <?php if(have_posts()):while(have_posts()):the_post();
				the_content();
				echo '<div class="clearfix"></div>';
				endwhile; endif; ?>
                </div>
                <?php if(is_active_sidebar($pageSidebar)) { ?>
                    <!-- Sidebar -->
                    <div class="col-md-<?php echo esc_attr($sidebar_column); ?>">
                    	<?php dynamic_sidebar($pageSidebar); ?>
                    </div>
                    <?php } ?>
            </div>
            </div>
            <div id="dealer-search-result"></div>
            <?php $map_address = get_post_meta($id,'imic_dealer_map_address',true);
			wp_enqueue_script('imic_contact_map');
			wp_localize_script('imic_contact_map','contact',array('address'=>$map_address));
			$args_user = array('post_type'=>'user','posts_per_page'=>-1);
			$ids = array();
			$user_listing = new WP_Query( $args_user );
			if ( $user_listing->have_posts() ) :
			while ( $user_listing->have_posts() ) :	
			$user_listing->the_post();
			$ids[] = get_the_ID();
			endwhile; endif; wp_reset_postdata(); ?>
            <div class="spacer-60"></div>
        	<div class="dealer-search-map">
        		<div id="contact-map" style="height:500px;"></div>
                <div class="dealer-search-head">
                	<span class="search-icon-boxed"><?php foreach($ids as $id) { $latlong = get_post_meta($id,'imic_user_lat_long',true); if(!empty($latlong)) { $latlong = explode(",",$latlong); ?><div class="user-location" style="display:none;"><?php echo '<span class="user-id">'.esc_attr($id).'</span><span class="lat">'.esc_attr($latlong[0]).'</span><span class="long">'.esc_attr($latlong[1]).'</span></div>'; } } ?><img id="dealer-search-load" src="<?php echo get_template_directory_uri(); ?>/images/loader.gif" style="display:none;"><i class="fa fa-search"></i></span>
                    <div class="dealer-search-field">
                    	<input type="text" id="search-add" class="form-control input-lg" placeholder="<?php echo esc_attr_e('Enter your zip or address and click Search Icon','framework'); ?>">
                </div>
          	</div>
           	</div>
     	</div>
 	</div>
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