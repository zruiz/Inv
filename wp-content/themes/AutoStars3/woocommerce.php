<?php 
get_header();
global $imic_options;
if(is_product_category()) {
$pageSidebar = 'shop-sidebar';
if(!empty($pageSidebar)&&is_active_sidebar($pageSidebar)) {
$class = 9;  
}else{
$class = 12;  
}
$sidebar_column = 3;
global $wp_query;
$cat = $wp_query->get_queried_object();
$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
$image = wp_get_attachment_url( $thumbnail_id ); 
$banner_image = esc_url($imic_options['header_image']['url']);
$image = ($image)?$image:$banner_image; ?>
<!-- Start Page header -->
    <div class="page-header parallax" style="background-image:url(<?php echo esc_url($image); ?>);">
    	<div class="container">
        	<h1 class="page-title"><?php echo esc_attr(single_term_title("", false)); ?></h1>
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
    </div>
<?php } } else {
if(is_home()) { $id = get_option('page_for_posts'); }
elseif(is_shop()){
    $id = woocommerce_get_page_id('shop');
  }
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
} }
?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
        	<div class="container">
            <div class="row">
            <div class="col-md-<?php echo esc_attr($class); ?>">
            <?php woocommerce_content(); imic_pagination(); ?>
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
<?php get_footer(); ?>