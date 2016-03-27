<?php
/*
Template Name: Contact
*/
get_header();
global $imic_options;
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
}?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
        	<div class="container">
            <div class="listing-header margin-40">
                <h2><?php echo get_the_title(); ?></h2>
          	</div>
            <?php if(have_posts()):while(have_posts()):the_post();
					the_content();
					endwhile; endif; ?>
                <div class="row">
                	<?php if(is_active_sidebar($pageSidebar)) { ?>
                    <!-- Sidebar -->
                    <div class="col-md-<?php echo esc_attr($sidebar_column); ?>">
                    	<?php dynamic_sidebar($pageSidebar); ?>
                    </div>
                    <?php } ?>
                    <div class="col-md-<?php echo esc_attr($class); ?> col-sm-6">
                       	<form method="post" id="contactform" name="contactform" class="contact-form clearfix" action="<?php echo IMIC_THEME_PATH; ?>/mail/contact.php">
                        	<div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type="text" id="fname" name="First Name"  class="form-control input-lg" placeholder="<?php echo esc_attr_e('First name','framework'); ?>*">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="lname" name="Last Name"  class="form-control input-lg" placeholder="<?php echo esc_attr_e('Last name','framework'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" id="email" name="email"  class="form-control input-lg" placeholder="<?php echo esc_attr_e('Email','framework'); ?>*">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="phone" name="phone" class="form-control input-lg" placeholder="<?php echo esc_attr_e('Phone','framework'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <textarea cols="6" rows="7" id="comments" name="comments" class="form-control input-lg" placeholder="<?php echo esc_attr_e('Message','framework'); ?>"></textarea>
                                    </div>
                                     <label id="captcha"><?php echo imic_create_captcha(); ?></label>
                    <input id="captcha_val" type="text" placeholder="<?php esc_html_e('Insert Captcha', 'framework'); ?>">
                                    <input type ="hidden" name ="image_path" id="image_path" value ="<?php echo IMIC_THEME_PATH; ?>">
                            <input type ="hidden" name ="recipients" id="recipients" value ="<?php echo esc_attr(get_the_ID()+2648); ?>">
                                    <input id="submit" name="submit" type="submit" class="btn btn-primary btn-lg btn-block" value="<?php echo esc_attr_e('Submit now!','framework'); ?>">
                                </div>
                          	</div>
                            
                		</form>
                        <div class="clearfix"></div>
                        <div id="message"></div>
                    </div>
               	</div>
           	</div>
        </div>
   	</div>
    <!-- End Body Content -->
<?php get_footer(); ?>