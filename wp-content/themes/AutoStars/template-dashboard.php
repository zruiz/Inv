<?php
/*
Template Name: Dashboard
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
$compare_url = imic_get_template_url('template-compare.php');
$pageSidebar2 = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list2', true);
if(!empty($pageSidebar2)&&is_active_sidebar($pageSidebar2)) {
$class2 = 9;  
}else{
$class2 = 12;  
}
$required_value = $total_ads = $st = '';
global $current_user;
//get_currentuserinfo();
$user_id = get_current_user_id( );
$user_info_id = get_user_meta($user_id,'imic_user_info_id',true);
$user_name = get_the_title($user_info_id);
$saved_cars = get_post_meta($user_info_id,'imic_user_saved_cars',true);
$saved_search = get_post_meta($user_info_id,'imic_user_saved_search',true);
$listing_url = imic_get_template_url('template-add-listing.php');
$args_cars = array('post_type'=>'yachts','author'=>$current_user->ID,'posts_per_page'=>-1,'post_status'=>array('publish','draft'));
$cars_listing = new WP_Query( $args_cars );
if ( $cars_listing->have_posts() ) :
while ( $cars_listing->have_posts() ) :	
$cars_listing->the_post();
	$total_ads = $cars_listing->post_count;
endwhile; endif; wp_reset_postdata();
//$ads_count = ($_SERVER['QUERY_STRING']=='')?1:-1;
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
<?php 
$listing_status = (isset($imic_options['opt_listing_status']))?$imic_options['opt_listing_status']:'';
$payment_status = ($listing_status=="draft")?"4":"1";
$opt_plans = $imic_options['opt_plans'];
$payment_gross = "free";
$vehicle = esc_attr(get_query_var('edit'));
$plans = esc_attr(get_query_var('plans'));
$listing_end_status = get_post_meta($plans, 'imic_days_periodic_listing', true);
$listing_end_status = ($listing_end_status!='')?$listing_end_status:500;
$listing_date = date('Y-m-d', strtotime("+".$listing_end_status." days"));
if($opt_plans==1) 
{
	$transaction_id=isset($_REQUEST['tx'])?esc_attr($_REQUEST['tx']):'';
	if($transaction_id!='') 
	{
		$paypal_details = imic_validate_payment($transaction_id);
		if(!empty($paypal_details)) 
		{
			$st = $paypal_details['payment_status'];
			$payment_gross = $paypal_details['payment_gross'];
			if($st=="Completed") 
			{
				if($payment_status=="1") 
				{ 
					update_post_meta($vehicle,'imic_plugin_ads_steps',5); 
				} 
				update_post_meta($vehicle,'imic_plugin_ad_payment_status',$payment_status);
				update_post_meta($vehicle,'imic_plugin_paid_price',$payment_gross); 
			} 
		} 
		update_post_meta($vehicle,'imic_plugin_car_plan',$plans); 
		update_post_meta($vehicle, 'imic_plugin_listing_end_dt', $listing_date);
	}
	$plan_price = get_post_meta($plans,'imic_plan_price',true);
	if($plan_price=='free') 
	{
		$st = "free";
		if($payment_status=="1") 
		{ 
			update_post_meta($vehicle,'imic_plugin_ads_steps',5); 
		} 
		update_post_meta($vehicle,'imic_plugin_ad_payment_status',$payment_status);
		update_post_meta($vehicle,'imic_plugin_paid_price',$payment_gross); 
		update_post_meta($vehicle,'imic_plugin_car_plan',$plans);
		update_post_meta($vehicle, 'imic_plugin_listing_end_dt', $listing_date);
	} 
} 
else 
{
	$st = "free";
	if($payment_status=="1") 
	{ 
		update_post_meta($vehicle,'imic_plugin_ads_steps',5); 
	} 
	update_post_meta($vehicle,'imic_plugin_ad_payment_status',$payment_status);
	update_post_meta($vehicle,'imic_plugin_paid_price',''); 
	update_post_meta($vehicle,'imic_plugin_car_plan','N/A');
	update_post_meta($vehicle, 'imic_plugin_listing_end_dt', $listing_date);
}
$specification_type = (isset($imic_options['short_specifications']))?$imic_options['short_specifications']:'0';
?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full dashboard-pages">
        	<div class="container">
            	<div class="dashboard-wrapper">
                    <div class="row">
                        
                        <?php if(!is_user_logged_in()) {
							echo '<div class="col-md-12 col-sm-12">';
							echo '<p>'.__('Login or Register to access this page','framework').'</p>';
							echo '<a class="btn btn-primary" data-toggle="modal" data-target="#PaymentModal">'.__('Login/Register','framework').'</a>';
							echo '</div>';
						} else { ?>
                        <div class="col-md-3 col-sm-4 users-sidebar-wrapper">
                            <!-- SIDEBAR -->
                            <div class="users-sidebar tbssticky">
                            	<?php  
                            	$user_role = array();
                            	$user_role = wp_get_post_terms($user_info_id, 'user-role'); 
								$role = $user_role[0];
                            	//var_dump(wp_get_post_terms($user_info_id, 'user-role')); 
                            	//var_dump($role->slug);
                            	//die();
                            	if($role->slug == 'broker' || $role->slug == 'shipyard') { ?>
                            	  <a href="<?php echo esc_url($listing_url); ?>" class='btn btn-block btn-primary add-listing-btn'><?php echo esc_attr_e('New Ad listing','framework'); ?></a>
	                            <?php } ?>
                                <ul class="list-group">
                                    <li class="list-group-item <?php if($_SERVER['QUERY_STRING']=='') { echo "active"; } ?>"> <a href="<?php echo get_permalink(); ?>"><i class="fa fa-home"></i> <?php echo esc_attr_e('My Account','framework'); ?></a></li>
                                    <?php if(!empty($saved_search)) { ?>
                                    <li class="list-group-item <?php if(get_query_var('search')==1) { echo "active"; } ?>"> <span class="badge"><?php echo count($saved_search); ?></span> <a href="<?php echo esc_url(add_query_arg('search',1,get_permalink())); ?>"><i class="fa fa-folder-o"></i> <?php echo esc_attr_e('Saved Searches','framework'); ?></a></li><?php } if(!empty($saved_cars)) { ?>
                                    <li class="list-group-item <?php if(get_query_var('saved')==1) { echo "active"; } ?>"> <span class="badge"><?php echo count($saved_cars); ?></span> <a href="<?php echo esc_url(add_query_arg('saved',1,get_permalink())); ?>"><i class="fa fa-star-o"></i> <?php echo esc_attr_e('Saved Yachts','framework'); ?></a></li><?php } ?>
                                    <?php if($role->slug == 'broker' || $role->slug == 'shipyard') { ?>
                                    <li class="list-group-item"> <a href="<?php echo esc_url($listing_url); ?>"><i class="fa fa-plus-square-o"></i> <?php echo esc_attr_e('Create new Ad','framework'); ?></a></li><?php if($total_ads!='') { ?>
                                    <li class="list-group-item <?php if(get_query_var('manage')==1) { echo "active"; } ?>"> <span class="badge"><?php echo esc_attr($total_ads); ?></span> <a href="<?php echo esc_url(add_query_arg('manage',1,get_permalink())); ?>"><i class="fa fa-edit"></i> <?php echo esc_attr_e('Manage Ads','framework'); ?></a></li><?php } ?>
                                    <?php } ?>
                                    <li class="list-group-item <?php if(get_query_var('profile')==1) { echo "active"; } ?>"> <a href="<?php echo esc_url(add_query_arg('profile',1,get_permalink())); ?>"><i class="fa fa-user"></i> <?php echo esc_attr_e('My Profile','framework'); ?></a></li>
                                    <!--<li class="list-group-item <?php if(get_query_var('account')==1) { echo "active"; } ?>"> <a href="<?php echo esc_url(add_query_arg('account',1,get_permalink())); ?>"><i class="fa fa-cog"></i> <?php echo esc_attr_e('Account Settings','framework'); ?></a></li>-->
                                    <li class="list-group-item"> <a href="<?php echo wp_logout_url(home_url()); ?>"><i class="fa fa-sign-out"></i> <?php echo esc_attr_e('Log Out','framework'); ?></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-9 col-sm-8">
                        <?php if(($st=="Completed"||$st=="free")&&($vehicle!='')) {
							echo '<div class="alert alert-success fade in">
							<a class="close" href="#" data-dismiss="alert">×</a>
							<strong>Well done!</strong>
							'.__('Thanks for submitting your listing. You can visit dashboard for further reference','framework').'
							</div> ';
						//Email properties
						$success_msg = $imic_options['payment_success_mail'];
						$listing_contact_email = '';
						$admin_mail_to = ($listing_contact_email=='')?get_option('admin_email'):$listing_contact_email;
						$mail_subject = $user_name .__(' successfully added a new listing.','framework');
						$admin_mail_content = "<p>".$user_name.__(" has added a new listing.","framework")."</p>";
						$admin_mail_content .= "<p>".__("Name: ","framework").$user_name."</p>";
						$admin_mail_content .= "<p>".__("Email: ","framework").$current_user->user_email."</p>";
						$admin_mail_content .= "<p>".__("Listing: ","framework")."<a href='".get_permalink( $vehicle)."'>Preview Listing</a></p>";
						$admin_msg = wordwrap( $admin_mail_content, 70 );
						$admin_headers = "From: $current_user->user_email" . PHP_EOL;
						$admin_headers .= "Reply-To: $current_user->user_email" . PHP_EOL;
						$admin_headers .= "MIME-Version: 1.0" . PHP_EOL;
						$admin_headers .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
						$dealer_headers = "From: $admin_mail_to" . PHP_EOL;
						$dealer_headers .= "Reply-To: $admin_mail_to" . PHP_EOL;
						$dealer_headers .= "MIME-Version: 1.0" . PHP_EOL;
						$dealer_headers .= "Content-Type: text/html; charset=\"iso-8859-1\"\n"; 
						wp_mail($admin_mail_to, $mail_subject, $admin_msg, $admin_headers);	
						wp_mail($current_user->user_email, $mail_subject, $success_msg);	
						}
						if((esc_attr(get_query_var('search'))!=1)&&(esc_attr(get_query_var('saved'))!=1)&&(esc_attr(get_query_var('profile'))!=1)&&(esc_attr(get_query_var('account'))!=1)) {
								echo '<h2>'.__('My Account','framework').'</h2>';
                            if(have_posts()):while(have_posts()):the_post();
							the_content();
							endwhile; endif;
										$additional_specs = $imic_options['unique_specs'];
										$detailed_title = $imic_options['highlighted_specs'];
										$ads_count = (get_query_var('manage')!=1)?1:-1;
							$args_cars = array('post_type'=>'yachts','author'=>$user_id,'posts_per_page'=>$ads_count,'post_status'=>array('publish','draft'));
                        $cars_listing = new WP_Query( $args_cars );
						if ( $cars_listing->have_posts() ) : ?>
                            <div id="ads-section" class="dashboard-block">
                            	<div class="dashboard-block-head"><?php if(($total_ads>1)&&(esc_attr(get_query_var('manage'))!=1)) { ?>
                                	<a href="<?php echo esc_url(add_query_arg('manage','1',get_permalink())); ?>" class="btn btn-default btn-sm pull-right"><?php echo esc_attr_e('See all Ads ','framework'); echo '('.$total_ads.')'; ?></a><?php } ?>
                            		<h3><?php echo esc_attr_e('My Listings','framework'); ?></h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered dashboard-tables saved-cars-table">
                                        <thead>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td><?php echo esc_attr_e('Description','framework'); ?></td>
                                                <td><?php echo esc_attr_e('Price','framework'); ?></td>
                                                <td><?php echo esc_attr_e('Timestamp','framework'); ?></td>
                                                <td><?php echo esc_attr_e('Status','framework'); ?></td>
                                                <td><?php echo esc_attr_e('Actions','framework'); ?></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php while ( $cars_listing->have_posts() ) :	
											$cars_listing->the_post();
										$last_term = get_last_child_term_id(get_the_ID(),'listing-category',true);
										$plan_id = get_post_meta(get_the_ID(),'imic_plugin_car_plan',true);
										$statuses = get_post_meta(get_the_ID(),'imic_plugin_ad_payment_status',true);
										$status = "";
										if($statuses==0) { $status = __("Pending","framework"); $label = "warning"; }
										elseif($statuses==1) { $status = __("Active","framework"); $label = "success"; }
										elseif($statuses==2) { $status = __("Sold","framework"); $label = "primary"; }
										elseif($statuses==3) { $status = __("Inactive","framework"); $label = "info"; }
										elseif($statuses==4) { $status = __("Under Review","framework"); $label = "info"; }
										$specifications = get_post_meta(get_the_ID(),'feat_data',true);
										$default_image_vehicle = (isset($imic_options['default_car_image']))?$imic_options['default_car_image']:array('url'=>'');
										if($specification_type==0)
										{
										$detailed_specs = (isset($imic_options['vehicle_specs']))?$imic_options['vehicle_specs']:array();
										}
										else
										{
											$detailed_specs = array();
										}
										if(is_plugin_active("imi-classifieds/imi-classified.php")) 
										{
											$detailed_specs = imic_classified_short_specs(get_the_ID(), $detailed_specs);
										}
										//print_r($detailed_specs);
										$details_value = imic_vehicle_all_specs(get_the_ID(),$detailed_specs,$specifications);
										$price = imic_vehicle_price(get_the_ID(),$additional_specs,$specifications);
										$title = imic_vehicle_title(get_the_ID(),$detailed_title,$specifications);
										$title = ($title=='')?get_the_title():$title;
										if($plan_id!=''&&$last_term!='')
										{
											$edit_url = array('edit'=>get_the_ID(), 'plans'=>$plan_id, 'list-cat'=>$last_term);
										}
										elseif($plan_id==''&&$last_term!='')
										{
											$edit_url = array('edit'=>get_the_ID(), 'list-cat'=>$last_term);	
										}
										elseif($plan_id!=''&&$last_term=='')
										{
											$edit_url = array('edit'=>get_the_ID(), 'plans'=>$plan_id);	
										}
										else
										{
											$edit_url = array('edit'=>get_the_ID());	
										}?>
                                            <tr>
                                                <td valign="middle"><input id="<?php echo esc_attr(get_the_ID()); ?>" value="1" class="remove-ads" type="checkbox"></td>
                                                <td>
                                                    <!-- Result -->
                                                    <?php if(has_post_thumbnail()) { ?>
                                                    <a href="<?php echo esc_url(add_query_arg($edit_url,$listing_url)); ?>" class="car-image"><?php the_post_thumbnail(); ?></a><?php } else { ?>
                                                    <a href="<?php echo esc_url(add_query_arg($edit_url,$listing_url)); ?>" class="car-image"><img src="<?php echo esc_url($default_image_vehicle['url']); ?>"></a><?php } ?>
                                                    <div class="search-find-results">
                                                    <?php if($statuses==1) { ?>
                                                        <h5><a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><?php echo esc_attr($title); ?></a></h5>
                                                   	<?php } else { ?>
                                                    	<h5><?php echo esc_attr($title); ?></h5>
                                                  	<?php } ?>
                                                        <ul class="inline">
                                                    <?php foreach($details_value as $detail) {
														if((!empty($detail))&&($detail!='select')) {
														echo '<li>'.$detail.'</li>'; }
													} ?>
                                                    </ul>
                                                    </div>
                                                </td>
                                                <td><span class="price"><?php echo esc_attr($price); ?></span></td>
                                                <td><span class="text-success"><?php echo esc_attr_e('Created on','framework'); ?></span> <?php echo esc_attr(get_the_date(get_option('date_format'))); echo esc_attr_e(' @ ','framework'); echo esc_attr(get_the_date(get_option('time_format'))); ?></td>
                                                <td align="center"><span id="ad-<?php echo esc_attr(get_the_ID()); ?>" class="label label-<?php echo esc_attr($label); ?>"><?php echo esc_attr($status); ?></span></td>
                                                <td align="center">
                                                <?php if($statuses!=2) { if($statuses==1) { ?>
                                                <button class="text-default deactivate-ad" title="<?php echo esc_attr_e('Archive','framework'); ?>"><i class="fa fa-archive"></i><div class="specific-id" style="display:none;"><span class="ad-id"><?php echo esc_attr(get_the_ID()); ?></span><span class="ad-next-status">3</span></div></button>
												<button class="text-default deactivate-ad" title="<?php echo esc_attr_e('Sold','framework'); ?>"><i class="fa fa-ban"></i><div class="specific-id" style="display:none;"><span class="ad-id"><?php echo esc_attr(get_the_ID()); ?></span><span class="ad-next-status">2</span></div></button><?php } ?>
                                                <?php if($statuses==3) { ?>
                                                <button class="text-default deactivate-ad" title="<?php echo esc_attr_e('Activate','framework'); ?>"><i class="fa fa-refresh"></i><div class="specific-id" style="display:none;"><span class="ad-id"><?php echo esc_attr(get_the_ID()); ?></span><span class="ad-next-status">1</span></div></button><?php } } ?>
                                               	<button id="specific-ad" class="text-danger delete-ads" title="<?php echo esc_attr_e('Delete','framework'); ?>"><i class="fa fa-times"></i><div class="specific-id" style="display:none;"><span class="ad-id"><?php echo esc_attr(get_the_ID()); ?></span></div></button>
                                                <a href="<?php echo esc_url(add_query_arg($edit_url,$listing_url)); ?>" class="text-default" title="<?php echo esc_attr_e('Edit','framework'); ?>"><i class="fa fa-pencil"></i></a>
                                                </td>
                                            </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                               	</div>
                                <button id="selected-ads" class="btn btn-default btn-sm delete-ads"><?php echo esc_attr_e('Delete Selected','framework'); ?></button>
                            </div>
                            <?php else: ?>
                            <!-- <div class="dashboard-block">
                            	<div class="dashboard-block-head">
                            		<h3><?php echo esc_attr_e('My Ads','framework'); ?></h3>
                                </div>
                                <div class="table-responsive">
                                <p><?php echo esc_attr_e('You have not created any Ads yet.','framework'); ?></p>
                                </div>
                            </div> -->
                            <?php endif; wp_reset_postdata(); } ?>
                            <?php if($role->slug == 'broker' || $role->slug == 'shipyard') {?>
							<?php if((esc_attr(get_query_var('search'))!=1)&&(esc_attr(get_query_var('manage'))!=1)&&(esc_attr(get_query_var('profile'))!=1)&&(esc_attr(get_query_var('account'))!=1)) {
							
							?>
                            <div id="saved-cars-section" class="dashboard-block">
                            	<div class="dashboard-block-head">
                                <?php if((count($saved_cars)>3)&&(esc_attr(get_query_var('saved'))!=1)) { ?>
                                	<a href="<?php echo esc_url(add_query_arg('saved',1,get_permalink())); ?>" class="btn btn-default btn-sm pull-right"><?php echo esc_attr_e('See all yachts ','framework'); echo '('.count($saved_cars).')'; ?></a><?php } ?>
                            		<h3><?php echo esc_attr_e('Saved Yachts','framework'); ?></h3>
                                </div>
                                <div class="table-responsive">
                                <?php if(!empty($saved_cars)) {  ?>
                                    <table id="saved-cars-table" class="table table-bordered dashboard-tables saved-cars-table saved-cars-box">
                                        <thead>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td><?php echo esc_attr_e('Description','framework'); ?></td>
                                                <td><?php echo esc_attr_e('Price','framework'); ?></td>
                                                <td><?php echo esc_attr_e('Timestamp','framework'); ?></td>
                                                <td><?php echo esc_attr_e('Actions','framework'); ?></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $additional_specs = $imic_options['unique_specs'];
										if($specification_type==0)
										{
										$detailed_specs = (isset($imic_options['vehicle_specs']))?$imic_options['vehicle_specs']:array();
										}
										else
										{
											$detailed_specs = array();
										}
										$detailed_title = $imic_options['highlighted_specs'];
										$saved_four = 1;
											foreach($saved_cars as $save) {
											$specifications = get_post_meta($save[0],'feat_data',true);
											$details_value = imic_vehicle_all_specs($save[0],$detailed_specs,$specifications);
											if(is_plugin_active("imi-classifieds/imi-classified.php")) 
											{
												$details_value = imic_classified_short_specs($save, $details_value);
											}
										$price = imic_vehicle_price($save[0],$additional_specs,$specifications);
										$title = imic_vehicle_title($save[0],$detailed_title,$specifications);
										?>
                                            <tr>
                                                <td valign="middle" class="checkb"><input id="saved-<?php echo esc_attr($save[0]); ?>" value="1" class="remove-saved compare-check" type="checkbox"></td>
                                                <td>
                                                    <!-- Result -->
                                                    <a href="<?php echo esc_url(get_permalink($save[0])); ?>" class="car-image"><?php echo get_the_post_thumbnail($save[0]); ?></a>
                                                    <div class="search-find-results">
                                                        <h5><a href="<?php echo esc_url(get_permalink($save[0])); ?>"><?php echo esc_attr($title); ?></a></h5>
                                                        <ul class="inline">
                                                    <?php foreach($details_value as $detail) {
														if(!empty($detail)) {
														echo '<li>'.$detail.'</li>'; }
													} ?>
                                                    </ul>
                                                    </div>
                                                </td>
                                                <td><span class="price"><?php echo esc_attr($price); ?></span></td>
                                                <td><span class="text-success"><?php echo esc_attr_e('Saved on','framework'); ?></span> <?php echo esc_attr(date(get_option('date_format'),$save[1])); echo esc_attr_e(' @ ','framework'); echo esc_attr(date(get_option('time_format'),$save[1])); ?></td>
                                                <td align="center"><button rel="specific-saved-ad" class="text-danger delete-saved" title="<?php echo esc_attr_e('Delete','framework'); ?>"><i class="fa fa-times"></i><div class="specific-id" style="display:none;"><span class="saved-id"><?php echo "saved-".esc_attr($save[0]); ?></span></div></button></td>
                                            </tr>
                                      	<?php if(esc_attr(get_query_var('saved')!=1)) { if($saved_four++>2) { break; } } } ?>
                                        </tbody>
                                    </table>
                               	</div>
                                <button rel="selected-saved-ad" class="btn btn-default btn-sm delete-saved"><?php echo esc_attr_e('Delete Selected','framework'); ?></button>
                                <a href="<?php echo esc_url($compare_url); ?>" id="compare-selected" class="btn btn-default btn-sm compare-in-box"><?php echo esc_attr_e('Compare Selected','framework'); ?></a><?php } else { ?>
                                <p><?php echo esc_attr_e('You don\'t have any saved listing in your dashboard','framework'); ?></p></div>
                                <?php } ?>
                            </div>
							<?php }
							if((esc_attr(get_query_var('manage'))!=1)&&(esc_attr(get_query_var('saved'))!=1)&&(esc_attr(get_query_var('profile'))!=1)&&(esc_attr(get_query_var('account'))!=1)) {
							 ?>
                            <div id="search-cars-section" class="dashboard-block">
                            	<div class="dashboard-block-head"><?php if((count($saved_search)>3)&&(esc_attr(get_query_var('search')!=1))) { ?>
                                	<a href="<?php echo esc_url(add_query_arg('search',1,get_permalink())); ?>" class="btn btn-default btn-sm pull-right"><?php echo esc_attr_e('See all searches ','framework'); echo '('.count($saved_search).')'; ?></a><?php } ?>
                            		<h3><?php echo esc_attr_e('Saved Searches','framework'); ?></h3>
                                </div>
                                <div class="table-responsive"><?php if(!empty($saved_search)) { ?>
                                    <table id="search-cars-table" class="table table-bordered dashboard-tables saved-searches-table">
                                        <thead>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td><?php echo esc_attr_e('Custom search name','framework'); ?></td>
                                                <td><?php echo esc_attr_e('Details','framework'); ?></td>
                                                <!--<td><?php echo esc_attr_e('Receive alerts','framework'); ?></td>-->
                                                <td><?php echo esc_attr_e('Timestamp','framework'); ?></td>
                                                <td><?php echo esc_attr_e('Actions','framework'); ?></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $count = $search_four = 1;
										foreach($saved_search as $search) {
											$res = preg_replace("/[^a-zA-Z]/", "", $search[0]); ?>
                                            <tr>
                                                <td valign="middle"><input value="1" id="<?php echo esc_attr($res); ?>" class="remove-search" type="checkbox"></td>
                                                <td><a href="<?php echo esc_url($search[2]); ?>" class="search-name"><?php echo esc_attr($search[0]); ?></a></td>
                                                <td><?php echo esc_attr($search[1]); ?></td>
                                                <!--<td><a href="#"><select class="form-control selectpicker input-sm"><option>Enable</option><option>Disable</option></select></a></td>-->
                                                <td><span class="text-success"><?php echo esc_attr_e('Saved on','framework'); ?></span> <?php echo esc_attr(date(get_option('date_format'),$search[3])); echo esc_attr_e(' @ ','framework'); echo esc_attr(date(get_option('time_format'),$search[3])); ?></td>
                                                <td align="center"><button id="specific-search-ad" class="text-danger delete-search" title="<?php echo esc_attr_e('Delete','framework'); ?>"><i class="fa fa-times"></i><div class="specific-id" style="display:none;"><span class="search-id"><?php echo esc_attr($res); ?></span></div></button></td>
                                            </tr>
                                       	<?php $count++; if(esc_attr(get_query_var('search')!=1)) { if($search_four++>3) { break; } } } ?>
                                        </tbody>
                                    </table><?php 
									echo '</div>
                                <button id="selected-search-ad" class="btn btn-default btn-sm delete-search">'.__('Delete Selected','framework').'</button>';
									} else { ?>
                                    <p><?php echo esc_attr_e('You don\'t have any saved searches in your dashboard','framework'); ?></p></div><?php } ?>
                               	
                            </div>
                            <?php } }
							if(get_query_var('profile')==1) {
								$msg = $msg_update = '';
							$othertextonomies = $city_type_value = '';
							if ('POST' == $_SERVER['REQUEST_METHOD']) {
								require_once(ABSPATH . 'wp-admin/includes/user.php');
    //check_admin_referer('update-profile_' . $user_id);
	
    $errors = edit_user($user_id);
	$first_name = ($_POST['first-name']);
	$last_name = esc_sql(trim($_POST['last-name']));
	$user_phone = esc_sql(trim($_POST['user-phone']));
	$sub_phone = esc_sql(trim($_POST['sub-phone']));
	$user_address = esc_sql(trim($_POST['user-address']));
	$user_city = esc_sql(trim($_POST['user-city']));
	$user_zip = esc_sql(trim($_POST['user-zip']));
	$user_state = esc_sql(trim($_POST['user-state']));
	$sub_city = esc_sql(trim($_POST['sub-city']));
	$sub_zip = esc_sql(trim($_POST['sub-zip']));
	$sub_state = esc_sql(trim($_POST['sub-state']));
	$user_old_pass = esc_sql(trim($_POST['user-pass']));
	$new_pass1 = esc_sql(trim($_POST['user-new-pass1']));
	$new_pass2 = esc_sql(trim($_POST['user-new-pass2']));
	$facebook = esc_sql(trim($_POST['user-facebook']));
	$twitter = esc_sql(trim($_POST['user-twitter']));
	$gplus = esc_sql(trim($_POST['user-gplus']));
	$ustate = esc_sql(trim($_POST['user-state']));
	$pinterest = esc_sql(trim($_POST['user-pinterest']));
	$company_name = esc_sql(trim($_POST['company-name']));
	$company_tagline = esc_sql(trim($_POST['company-tagline']));
	$company_url = esc_sql(trim($_POST['website-url']));
	$dealer_content = esc_sql(trim($_POST['dealer_content']));
	if($first_name!='') {
		$ss = wp_update_user( array( 'ID' => $user_id, 'first_name' => $first_name, 'last_name' => $last_name ) ); }
	if(empty($first_name)) { $msg .= __('Please fill first name','framework')."\r\n"; }
	// if(empty($user_zip)) { $msg .= __('Please fill zip code','framework')."\r\n"; }
		if($msg=='') {
        	if($role->slug == 'broker' || $role->slug == 'shipyard') {
				wp_set_object_terms($user_info_id, $ustate, 'user-city');
				if(file_exists($_FILES['bannerimage']['tmp_name']) || is_uploaded_file($_FILES['bannerimage']['tmp_name'])) {		
				$newupload = imic_sight('bannerimage',$user_info_id); 
				update_post_meta($user_info_id,'imic_user_logo',$newupload); }
				if(file_exists($_FILES['userimage']['tmp_name']) || is_uploaded_file($_FILES['userimage']['tmp_name'])) {	
				$newupload1 = imic_sight('userimage',$user_info_id);
				update_post_meta($user_info_id,'_thumbnail_id',$newupload1); }
				update_post_meta($user_info_id,'imic_user_zip_code',$user_zip);
				update_post_meta($user_info_id,'imic_user_city',$user_city);
				update_post_meta($user_info_id,'imic_user_telephone',$user_phone);
				update_post_meta($user_info_id,'imic_user_company',$company_name);
				update_post_meta($user_info_id,'imic_user_company_tagline',$company_tagline);
				update_post_meta($user_info_id,'imic_user_website',$company_url);
				update_post_meta($user_info_id,'imic_user_facebook',$facebook);
				update_post_meta($user_info_id,'imic_user_twitter',$twitter);
				update_post_meta($user_info_id,'imic_user_gplus',$gplus);
				update_post_meta($user_info_id,'imic_user_pinterest',$pinterest);
				$dealer_post_content = array(
					  'ID'           => $user_info_id,
					  'post_content' => $dealer_content,
				  );
		  		wp_update_post( $dealer_post_content );
		  	} else {

		  		update_user_meta($user_id,'phone',$sub_phone);
		  		update_user_meta($user_id,'addr1',$user_address);
				update_user_meta($user_id,'city',$sub_city);
				update_user_meta($user_id,'thestate',$sub_state);
				update_user_meta($user_id,'zip',$sub_zip);
		  	} 
		$user = get_user_by( 'login', $current_user->user_login );
		if ( $user && wp_check_password( $user_old_pass, $user->data->user_pass, $user->ID) ) {
			if($new_pass1==$new_pass2) {
				$msg_update .= __('Password Updated Successfully','framework');
		   wp_set_password( $new_pass1, $user->ID ); } else {
		   		$msg .= __('Please confirm password again','framework'); }
		    }
		}
		if($msg=='') { $msg_update =  __('Profile Updated Successfully','framework'); } }
																 ?>
                            
                            <h2><?php echo esc_attr_e('My Profile','framework'); ?></h2>
                            <div class="dashboard-block">
                            <?php if($msg!='') { ?>
                            <div id="message"><div class="alert alert-error"><?php echo esc_attr($msg); ?></div></div><?php } elseif($msg_update!='') { ?>
                            <div id="message"><div class="alert alert-success"><?php echo esc_attr($msg_update); ?></div></div><?php } ?>
                                <div class="tabs profile-tabs">
                                    <ul class="nav nav-tabs">
                                        <li class="active"> <a data-toggle="tab" href="#personalinfo" aria-controls="personalinfo" role="tab"><?php echo esc_attr_e('Personal Info','framework'); ?></a></li>
                                        <!-- <li> <a data-toggle="tab" href="#socialinfo" aria-controls="socialinfo" role="tab"><?php echo esc_attr_e('Social Info','framework'); ?></a></li> -->
                                        <?php 
                                    	$user_role = array();
                        				$user_role = wp_get_post_terms($user_info_id, 'user-role'); 
										$role = $user_role[0];
                                    	if($role->slug == 'subscriber') { ?>
                                        <li> <a data-toggle="tab" href="#billinginfo" aria-controls="billinginfo" role="tab"><?php echo esc_attr_e('Billing Info','framework'); ?></a></li>
                                        <?php } ?>
                                        <li> <a data-toggle="tab" href="#changepassword" aria-controls="changepassword" role="tab"><?php echo esc_attr_e('Change Password','framework'); ?></a></li>
                                    </ul>
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="tab-content">
                                        <!-- SOCIAL INFO -->
                                            <div id="personalinfo" class="tab-pane fade active in">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                            	<label><?php echo esc_attr_e('First name*','framework'); ?></label>
                                                                <input name="first-name" value="<?php echo esc_attr($current_user->user_firstname); ?>" type="text" class="form-control" placeholder="" >
                                                            </div>
                                                            <div class="col-md-6">
                                                            	<label><?php echo esc_attr_e('Last name','framework'); ?></label>
                                                                <input name="last-name" value="<?php echo esc_attr($current_user->user_lastname); ?>" type="text" class="form-control" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                            	<label><?php echo esc_attr_e('Email','framework'); ?>*</label>
                                                                <input name="user-email" value="<?php echo esc_attr($current_user->user_email); ?>" type="text" class="form-control" placeholder="mail@example.com" disabled>
                                                            </div>
                                                             <?php if($role->slug == 'broker' || $role->slug == 'shipyard') { ?>
                                                            <div class="col-md-6">
                                                            	<label><?php echo esc_attr_e('Phone','framework'); ?></label>
                                                                <input name="user-phone" value="<?php echo get_post_meta($user_info_id,'imic_user_telephone',true); ?>" type="text" class="form-control" placeholder="000-00-0000">
                                                            </div>
                                                            <?php } else { ?>
                                                            <div class="col-md-6">
                                                            	<label><?php echo esc_attr_e('Phone','framework'); ?></label>
                                                                <input name="sub-phone" value="<?php echo get_user_meta($user_id,'phone',true); ?>" type="text" class="form-control" placeholder="000-00-0000">
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                        <?php if($role->slug == 'broker' || $role->slug == 'shipyard') { ?>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                            	<label><?php echo esc_attr_e('Company Name','framework'); ?></label>
                                                                <input name="company-name" value="<?php echo get_post_meta($user_info_id,'imic_user_company',true); ?>" type="text" class="form-control" placeholder="">
                                                            </div>
                                                            <div class="col-md-6">
                                                            	<!-- <label><?php echo esc_attr_e('Company Tagline','framework'); ?></label>
                                                                <input name="company-tagline" value="<?php echo get_post_meta($user_info_id,'imic_user_company_tagline',true); ?>" type="text" class="form-control" placeholder=""> -->
                                                            </div>
                                                        </div>
                                                        <label><?php echo esc_attr_e('Website','framework'); ?></label>
                                                                <input name="website-url" value="<?php echo get_post_meta($user_info_id,'imic_user_website',true); ?>" type="text" class="form-control" placeholder="">
                                                                <?php
																$post_id = get_post($user_info_id);
																$content = $post_id->post_content;
																// $content = apply_filters('the_content', $content);
																// $content = str_replace(']]>', ']]>', $content); ?>
                                                      	<label><?php echo esc_attr_e('Description','framework'); ?></label>
                                                      	<textarea class="form-control" rows="5" name="dealer_content"><?php echo do_shortcode($content); ?></textarea>
                                                      	<div class="row">
                                                            <div class="col-md-6">
                                                            <?php $user_avatar = get_post_meta($user_info_id,'imic_user_logo',true);
															$image_avatar = wp_get_attachment_image_src( $user_avatar, '', '' );
															if(!empty($image_avatar)) {  ?>
                                                            <img src="<?php echo esc_url($image_avatar[0]); ?>" width="150" height="150">
                                                            <?php } ?>
                                                            	<!-- <label><?php echo esc_attr_e('Banner Image','framework'); ?></label>
                                                                <input name="bannerimage" type="file"> -->
                                                            </div>
                                                            <div class="col-md-6">
                                                            <?php if(has_post_thumbnail($user_info_id)) {
															echo get_the_post_thumbnail($user_info_id,'200x200'); } ?>
                                                            	<!-- <label><?php echo esc_attr_e('Company/User Image','framework'); ?></label>
                                                                <input name="userimage" type="file"> -->
                                                            </div>
                                                        </div>
                                                        <?php } else { ?>
                                                        <div class="row">
                                                    	<div class="col-md-12">
                                                         <div class="row">
                                                        	<div class="col-md-6">
                                                        		<label><?php echo esc_attr_e('Mailing Address','framework'); ?></label>
                                                                <input type="text" name="user-address" class="form-control" value="<?php echo get_user_meta($user_id,'addr1',true); ?>" placeholder="Address">
                                                            </div>
                                                            <?php $ustate = ''; $user_state = wp_get_post_terms($user_info_id, 'user-city');
															if(!empty($user_state)) { $ustate = $user_state[0]->slug; }
															$user_city = get_terms('user-city',array('hide_empty'=>false,'orderby'=>'name')); ?>

                                                        	<div class="col-md-6">
                                                        		<label><?php echo esc_attr_e('City','framework'); ?></label>
                                                                <input type="text" name="sub-city" class="form-control" value="<?php echo get_user_meta($user_id,'city',true); ?>" placeholder="City">
                                                            </div>

                                                            <div class="col-md-6">
                                                        		<label><?php echo esc_attr_e('State','framework'); ?></label>
                                                                <input type="text" name="sub-state" class="form-control" value="<?php echo get_user_meta($user_id,'thestate',true); ?>" placeholder="State">
                                                            </div>

                                                           <!--  <div class="col-md-6">
				                                            <label><?php echo esc_attr_e('Select State','framework'); ?></label>
				                                            <select id="ustate" name="user-state" class="form-control selectpicker">
				                                                <option><?php echo esc_attr_e('Select','framework'); ?></option>
				                                                <?php foreach($user_city as $city) { 
				                                                	//$ustate = get_user_meta($user_id,'thestate',true);
				                                                ?>
				                                                <option <?php echo ($ustate==$city->slug)?'selected':''; ?> value="<?php echo esc_attr($city->slug); ?>"><?php echo esc_attr($city->name); ?></option>
				                                                <?php } ?>
				                                            </select>
				                                            </div> -->
                                                        
                                                            <div class="col-md-6">
                                                        		<label><?php echo esc_attr_e('Zip','framework'); ?></label>
                                                                <input name="sub-zip" value="<?php echo get_user_meta($user_id,'zip',true); ?>" type="text" class="form-control" placeholder="" >
                                                            </div>
                                                       	 </div>
                                                        
			                                            </div>
			                                            </div>
                                               			<?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- SOCIAL INFO -->
                                            <div id="socialinfo" class="tab-pane fade">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                            	<label><?php echo esc_attr_e('Facebook','framework'); ?></label>
                                                                <input name="user-facebook" value="<?php echo get_post_meta($user_info_id,'imic_user_facebook',true); ?>" type="text" class="form-control" placeholder="" >
                                                            </div>
                                                            <div class="col-md-6">
                                                            	<label><?php echo esc_attr_e('Twitter','framework'); ?></label>
                                                                <input name="user-twitter" value="<?php echo get_post_meta($user_info_id,'imic_user_twitter',true); ?>" type="text" class="form-control" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                            	<label><?php echo esc_attr_e('Google Plus','framework'); ?></label>
                                                                <input name="user-gplus" value="<?php echo get_post_meta($user_info_id,'imic_user_gplus',true); ?>" type="text" class="form-control" placeholder="">
                                                            </div>
                                                            <div class="col-md-6">
                                                            	<label><?php echo esc_attr_e('Pinterest','framework'); ?></label>
                                                                <input name="user-pinterest" value="<?php echo get_post_meta($user_info_id,'imic_user_pinterest',true); ?>" type="text" class="form-control" placeholder="">
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                            </div>
                                            <!-- PROFIE BILLING INFO -->
                                            <div id="billinginfo" class="tab-pane fade">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="row">
                                                        
                                                        <div class="col-md-6">
                                                        		<label><?php echo esc_attr_e('City','framework'); ?></label>
                                                                <input type="text" name="user-city" class="form-control" value="<?php echo get_post_meta($user_info_id,'imic_user_city',true); ?>" placeholder="">
                                                            </div>
                                                            <div class="col-md-6">
                                                        		<label><?php echo esc_attr_e('Zip','framework'); ?></label>
                                                                <input name="user-zip" value="<?php echo get_post_meta($user_info_id,'imic_user_zip_code',true); ?>" type="text" class="form-control" placeholder="" >
                                                            </div>
                                                       	</div>
                                                        <?php $ustate = ''; $user_state = wp_get_post_terms($user_info_id, 'user-city');
											if(!empty($user_state)) { $ustate = $user_state[0]->slug; }
											$user_city = get_terms('user-city',array('hide_empty'=>false,'orderby'=>'name')); ?>
                                            <label><?php echo esc_attr_e('Select State','framework'); ?></label>
                                            <select id="ustate" name="user-state" class="form-control selectpicker">
                                                <option><?php echo esc_attr_e('Select','framework'); ?></option>
                                                <?php foreach($user_city as $city) { ?>
                                                <option <?php echo ($ustate==$city->slug)?'selected':''; ?> value="<?php echo esc_attr($city->slug); ?>"><?php echo esc_attr($city->name); ?></option>
                                                <?php } ?>
                                            </select>
                                                  	</div>
                                               	</div>
                                            </div>
                                            <!-- PROFIE CHANGE PASSWORD -->
                                            <div id="changepassword" class="tab-pane fade">
                                            	<div class="row">
                                                    <div class="col-md-8">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                        		<label><?php echo esc_attr_e('Old Password','framework'); ?></label>
                                                                <input name="user-pass" type="password" class="form-control" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                        		<label><?php echo esc_attr_e('New password','framework'); ?></label>
                                                                <input name="user-new-pass1" type="password" class="form-control" placeholder="">
                                                            </div>
                                                            <div class="col-md-6">
                                                        		<label><?php echo esc_attr_e('Confirm new password','framework'); ?></label>
                                                                <input name="user-new-pass2" type="password" class="form-control" placeholder="">
                                                            </div>
                                                        </div>
                                                  	</div>
                                               	</div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-info"><?php echo esc_attr_e('Update details','framework'); ?></button>
                                        
                                    </form>
                                </div>
                            </div>
                            <?php }
							if(get_query_var('account')==1) { ?>
                            <!--<h2>My Alerts Settings</h2>
                            <div class="dashboard-block">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Saved Car Alerts</h3>
                                            </div>
                                            <div class="panel-body">
                                              	<label class="checkbox-inline"><input type="checkbox" checked>Send me notification email when price changes or a special offer is available</label>
                                                <div class="spacer-10"></div>
                                              	<label class="checkbox-inline"><input type="checkbox" checked>Send me notification email when the car has been sold</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Saved Searches Alerts</h3>
                                            </div>
                                            <div class="panel-body">
                                              	<label class="checkbox-inline"><input type="checkbox" checked>Send me notification email when a vehicle gets available for my search</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Subscribe to our Newsletter</h3>
                                            </div>
                                            <div class="panel-body">
                                              	<label class="checkbox-inline"><input type="checkbox" checked>Send me latest news and offers Newsletter</label>
                                          		<p class="small">We send our latest offers and news every week to our verified users. </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                         	</div>-->
                            <?php } ?>
                        </div><?php } ?>
                    </div>
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