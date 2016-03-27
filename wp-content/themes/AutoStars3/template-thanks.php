<?php
/*
Template Name: Thank You
*/
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
$payment = '';
$plan_id=isset($_REQUEST['item_number'])?esc_attr($_REQUEST['item_number']):'';
$post_type = get_post_type($plan_id);
$plan_price = '';
if($post_type=='plan')
{
	$plan_price = get_post_meta($plan_id, 'imic_plan_price', true);
	$plan_price = floor($plan_price);
	$plan_listings_count = get_post_meta($plan_id, 'imic_plan_validity_listings', true);
	$plan_listings_count = esc_attr($plan_listings_count);
}
$transaction_id=isset($_REQUEST['tx'])?esc_attr($_REQUEST['tx']):'';
	if($transaction_id!='') 
	{
		$paypal_details = imic_validate_payment($transaction_id);
		if(!empty($paypal_details)) 
		{
			$st = $paypal_details['payment_status'];
			$payment_gross = $paypal_details['payment_gross'];
			$payment = floor($payment_gross);
		} 
	}
$ad_listing = imic_get_template_url('template-add-listing.php');
$listings = imic_get_template_url('template-listing.php');
global $current_user;
get_currentuserinfo();
$user_id = get_current_user_id( );
$current_user = wp_get_current_user();
$user_info_id = get_user_meta($user_id,'imic_user_info_id',true);
$confirm = ($plan_price==$payment)?1:'';
$st = ($confirm==1)?$st:__('Not Verified', 'framework');
$data = array();
if($confirm==1)
{
	$all_plans_user = get_post_meta($user_info_id, 'imic_user_plan_'.$plan_id, true);
	if(!empty($all_plans_user))
	{
		foreach($all_plans_user as $key=>$value)
		{
			$data[date('U')] = $value;
		}
	}
	else
	{
		$data[date('U')] = '';
	}
	$last_transaction_id = get_post_meta($user_info_id, 'imic_user_tr_id', false);
	$allowed_listings = get_post_meta($user_info_id, 'imic_allowed_listings_'.$plan_id, true);
	$updated_allowed_listings = $allowed_listings+$plan_listings_count;
	$user_all_plans = get_post_meta($user_info_id, 'imic_user_all_plans', false);
	if(!in_array($transaction_id, $last_transaction_id))
	{
		update_post_meta($user_info_id, 'imic_user_plan_'.$plan_id, $data);
		update_post_meta($user_info_id, 'imic_allowed_listings_'.$plan_id, $updated_allowed_listings);
		add_post_meta($user_info_id, 'imic_user_tr_id', $transaction_id, false);
		if(!in_array($plan_id, $user_all_plans))
		{
			add_post_meta($user_info_id, 'imic_user_all_plans', $plan_id, false);
		}
	}
}
?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
    		<div class="container">
            	<div class="text-align-center error-404">
            		<h1 class="huge"><?php esc_html_e('Thank You','vestige'); ?></h1>
              		<hr class="sm">
              		<p><strong><?php esc_html_e('Payment ','vestige'); echo esc_attr($st); ?></strong></p>
					<p><?php esc_html_e('Your payment status is ', 'vestige'); echo esc_attr($st); ?></p>
          <?php if($ad_listing!='') { ?>
          <a class="btn btn-primary" href="<?php echo esc_url($ad_listing); ?>"><?php esc_html_e('Ad Listing', 'framework'); ?></a>
          <?php } if($listings!='') { ?>
          <a class="btn btn-primary" href="<?php echo esc_url($listings); ?>"><?php esc_html_e('View Listings', 'framework'); ?></a>
          <?php } ?>
          <a data-toggle="modal" data-target="#Contact-site" class="btn btn-primary"><?php esc_html_e('Contact ', 'framework'); echo get_option('blogname'); ?></a>
             	</div>
            </div>
        </div>
   	</div>
<?php
global $current_user;
get_currentuserinfo();
$user_id = get_current_user_id( );
$current_user = wp_get_current_user();
$user_info_id = get_user_meta($user_id,'imic_user_info_id',true);
echo '<div id="Contact-site" class="modal fade" aria-hidden="true" aria-labelledby="mymodalLabel" role="dialog" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button class="close" aria-hidden="true" data-dismiss="modal" type="button">'.esc_attr__('×','framework').'</button>
<h4 id="mymodalLabel" class="modal-title">'.esc_attr__('Contact ','framework').get_option('blogname').'</h4>
</div>
<div class="modal-body">
<form method="post" id="contactsite" name="contactsite" class="clearfix" action="">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" value="'.get_the_title($user_info_id).'" id="paypal-title" disabled name="First Name"  class="form-control input-lg" placeholder="'.__('Name', 'framework').'*">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" value="'.$current_user->user_email.'" id="paypal-email" disabled name="email"  class="form-control input-lg" placeholder="'.__('Email', 'framework').'*">
                </div>
                
            </div>
						<div class="col-md-12">
                <div class="form-group">
                    <textarea class="form-control input-lg" id="payment-comment" placeholder="'.__('Message', 'framework').'"></textarea>
                </div>
                
            </div>
            <div class="col-md-12">
						<p>'.__('Your Payment Details and status will be forwarded to site manager, manager would try to contact you shortly', 'framework').'</p>
                <div class="form-group">
                    <div id="messages"></div>
                </div>
                
            </div>
						<div class="col-md-12">
						<div class="form-group">
						<input type="hidden" value="'.$transaction_id.'" id="transaction">
						<input type="hidden" value="'.$plan_id.'" id="plan_id">
						<input id="contact-site" name="submit" type="button" class="btn btn-default" value="'.__('Submit', 'framework').'">
						</div>
						</div>
        </div>
    </form>
</div>
<div class="modal-footer">

</div>
</div>
</div>
</div>';
get_footer();
?>