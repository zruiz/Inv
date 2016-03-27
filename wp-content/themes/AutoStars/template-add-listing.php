<?php
/*
Template Name: Add Listing
*/
get_header();
global $imic_options;
$paypal_site = '';
$opt_plans = $imic_options['opt_plans'];
$listing_status_set = $imic_options['opt_listing_status'];
$file_upload = (isset($imic_options['filetype_required']))?$imic_options['filetype_required']:'0';
wp_localize_script('imic_add_listing','values',array('ajaxurl'=>admin_url('admin-ajax.php'),'tmpurl'=>get_template_directory_uri(),'plans'=>$opt_plans,'isDefault'=>FRONT_MEDIA_ALLOW::check_file_input_method(), 'fileupload' => $file_upload));
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
	wp_enqueue_script('imic_add_listing');
$pageSidebar2 = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list2', true);
if(!empty($pageSidebar2)&&is_active_sidebar($pageSidebar2)) {
$class2 = 9;  
}else{
$class2 = 12;  
}
$update_id = (get_query_var('edit'))?get_query_var('edit'):'';
$thanks = imic_get_template_url('template-dashboard.php');
$paypal_site = $imic_options['paypal_site'];
$paypal_currency = $imic_options['paypal_currency'];
$paypal_email = $imic_options['paypal_email'];
$plan = get_query_var('plans');
$plan_price = '';
if($plan) {
	$plan_price = get_post_meta($plan,'imic_plan_price',true);
	if($plan_price!=0&&$plan_price!=''&&$plan_price!='free') {
	$paypal_site = ($paypal_site=="1")?"https://www.paypal.com/cgi-bin/webscr":"https://www.sandbox.paypal.com/cgi-bin/webscr"; }
	else {
	if(($plan!='')&&($update_id!='')) {
	$paypal_site = add_query_arg(array('plans'=>$plan,'edit'=>$update_id),$thanks);}
	else { $paypal_site = ''; }
	}
}
$required_value = '';
$vehicle_switch = get_post_meta($id,'imic_home_vehicle_switch',true);
$parallax_switch = get_post_meta($id,'imic_home_third_parallax_section',true);
$pricing_switch = get_post_meta($id,'imic_home_pricing_switch',true);
$tab_class1 = $tab_class2 = $tab_class3 = $tab_class4 = $tab_class5 = $animation = $active_tab1 = $active_tab2 = $active_tab3 = $active_tab4 = $active_tab5 = '';
$vehicle_author_id = get_post_field( 'post_author', $update_id);
global $current_user;
get_currentuserinfo();
$user_id = get_current_user_id( );
$update_id = ($user_id==$vehicle_author_id)?$update_id:'';
if(is_user_logged_in())
{
	echo ($user_id==$vehicle_author_id)?'':'<div id="not-valid"></div>';
}
$user_info_id = get_user_meta($user_id,'imic_user_info_id',true);
$urole = ''; $user_role = wp_get_post_terms($user_info_id, 'user-role');
$list_ad = array('order'=>'');
if(!empty($user_role)) { $urole = $user_role[0]->term_id; $list_ad = get_option('taxonomy_'.$urole.'_metas'); }
if($list_ad['order']!="0") {
$payment_status = get_post_meta($update_id,'imic_plugin_ad_payment_status',true);
$payment_status = '';
if($update_id!='') {
	$payment_status = get_post_meta($update_id,'imic_plugin_ad_payment_status',true);
	$steps_completed = get_post_meta($update_id,'imic_plugin_ads_steps',true);
if($steps_completed>=0) {
	$tab_class1 = ($steps_completed==0)?'pending':'completed';
	$animation = ($steps_completed==0)?(0)."%":(20)."%";
	$active_tab1 = "active";
}if($steps_completed>=1){
	$tab_class2 = ($steps_completed==1)?'pending':'completed';
	$animation = ($steps_completed==1)?(20)."%":(40)."%";
	$active_tab1 = '';
	$active_tab2 = "active";
}if($steps_completed>=2){
	$tab_class3 = ($steps_completed==2)?'pending':'completed';
	$animation = ($steps_completed==2)?(40)."%":(60)."%";
	$active_tab1 = $active_tab2 = '';
	$active_tab3 = "active";
}if($steps_completed>=3){
	$tab_class4 = ($steps_completed==3)?'pending':'completed';
	$animation = ($steps_completed==3)?(60)."%":(80)."%";
	$active_tab1 = $active_tab2 = $active_tab3 = '';
	$active_tab4 = "active";
}if($steps_completed>=4){
	$tab_class5 = ($steps_completed==4)?'pending':'completed';
	$animation = ($steps_completed==4)?(80)."%":(100)."%";
	$active_tab1 = $active_tab2 = $active_tab3 = $active_tab4 = '';
	$active_tab5 = "active";
}
	$specifications = get_post_meta($update_id,'feat_data',true);
	//$tab_class = 'completed';
	//$animation = (100).'%';
}
else {
	$active_tab1 = "active";
}
$default_form = (is_plugin_active("imi-classifieds/imi-classified.php"))?'1':$imic_options['ad_listing_order'];
$active_form_search = ($default_form=='0')?'active':'';
$active_custom_form = ($default_form=='1')?'active':'';
$active_tab_search = ($default_form=='0')?'active in':'';
$active_tab_custom = ($default_form=='1')?'active in':'';
$paypal_site = ($opt_plans==1)?$paypal_site:$thanks;
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
}
$specification_data_type = (isset($imic_options['specification_fields_type']))?$imic_options['specification_fields_type']:"0"; ?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
        	<div class="container">
            	
                <?php
			if(is_plugin_active("imi-classifieds/imi-classified.php")) 
			{
				echo '<div class="row">';
			$selected_cat = get_query_var('list-cat');
			$list_termss = array();
			if($selected_cat) 
			{
				$category_ids = get_term_by('slug', $selected_cat, 'listing-category');
				$term_ids = $category_ids->term_id;
				$parent = get_ancestors( $term_ids, 'listing-category' );
				foreach($parent as $parents)
				{
					$list_term = get_term_by('id', $parents, 'listing-category');
					$list_termss[] = $list_term->slug;
				}
				$list_termss[] = $selected_cat; 
			} 
			$listing_cats = get_terms('listing-category',array('parent' => 0,'number' => 10,'hide_empty' => false));
			if(!empty($listing_cats))
			{
										echo '<div class="col-md-3 col-sm-3 act-cat" id="list-1">';
										echo '<label>'.__('Select Category').'</label>';
										echo '<select data-page="ad" data-empty="true" name="list-cat" class="form-control selectpicker get-child-cat">';
										echo '<option value="" selected disabled>'.__('Select','framework').'</option>';
										$this_cat = $act = '';
										foreach($listing_cats as $cat)
										{
											$term_children = get_terms('listing-category',array('parent' => $cat->term_id));
											$disabled = (empty($term_children))?'blank':'';
											if($this_cat!="selected"&&$act!=1)
											{
												$cat_id = (in_array($cat->slug,$list_termss))?$cat->term_id:'';
												$counter = (in_array($cat->slug,$list_termss))?1:0;
											}
											$this_cat = (in_array($cat->slug,$list_termss))?'selected':'';
											if($this_cat=="selected") { $act = 1; }
											echo '<option '.$this_cat.' data-val="'.$disabled.'" value="'.$cat->slug.'">'.$cat->name.'</option>';
										}
										echo '</select>';
										echo '</div>';
			}
									if(get_query_var('list-cat'))
									{ 
										while($counter<=count($list_termss)&&($cat_id!=''))
										{
											$meet = 0;
											$listing_cats = get_terms('listing-category',array('parent' => $cat_id));
											if(!empty($listing_cats))
											{
											echo '<div class="col-md-3 col-sm-3 act-cat" id="list-'.($counter+1).'">';
											echo '<label>'.__('Select Category').'</label>';
											echo '<select data-empty="true" name="list-cat" class="form-control selectpicker get-child-cat">';
											echo '<option value="" selected disabled>'.__('Select','framework').'</option>';
											$this_cat = $act = '';
											foreach($listing_cats as $cat)
											{
												$term_children = get_term_children($cat->term_id, 'listing-category');
												$disabled = (empty($term_children))?'blank':'';
												if($this_cat!="selected"&&$act!=1)
												{
												$cat_id = (in_array($cat->slug,$list_termss))?$cat->term_id:'';
												}
												$this_cat = (in_array($cat->slug,$list_termss))?'selected':'';
												if($this_cat=="selected") { $act = 1; }
												echo '<option '.$this_cat.' data-val="'.$disabled.'" value="'.$cat->slug.'">'.$cat->name.'</option>';
											}
											echo '</select>';
											echo '</div>'; }
											$counter++;
										}
									}
									echo '<div class="col-md-3 col-sm-3 loading-fields" id="loading-field" style="display:none;"><label>'.__('Select Category','framework').'</label><input class="form-control" type="text" value="'.__('Loading...','framework').'"></div></div>'; }
										?><div class="row">
                	<div class="col-md-4 col-sm-4 listing-form-wrapper">
                    	<!-- SIDEBAR -->
                    	<div class="listing-form-steps-wrapper">
                    		<!-- AD LISTING PROGRESS BAR -->
                        	<div class="listing-form-progress">
                                <div class="progress-label"> <span><?php echo esc_attr_e('Ad Completeness','framework'); ?></span> </div>
                            	<div class="progress progress-striped">
                                    <div class="progress-bar progress-bar-primary" data-appear-progress-animation="<?php echo esc_attr($animation); ?>"></div>
                              	</div>
                            </div>
                    		<!-- AD LISTING FORM STEPS -->
                            <ul class="listing-form-steps">
                                <li class="tabs-listing <?php echo esc_attr($tab_class1.' '.$active_tab1); ?>" data-target="#listing-add-form-one" data-rel="listing-add-form-one" data-toggle="tab">
                                    <a href="javascript:void(0);">
                                        <span class="step-state"></span>
                                        <span class="step-icon"><i class="fa fa-user"></i></span>
                                        <strong class="step-title"><?php echo esc_attr_e('Create Listing','framework'); ?></strong>
                                        <span class="step-desc"><?php echo esc_attr_e('Enter your listing specifications','framework'); ?></span>
                                    </a>
                                </li>
                                <li class="tabs-listing <?php echo esc_attr($tab_class2.' '.$active_tab2); ?>" data-target="#listing-add-form-two" data-rel="listing-add-form-two" data-toggle="tab">
                                    <a href="javascript:void(0);">
                                        <span class="step-state"></span>
                                        <span class="step-icon"><i class="fa fa-list-alt"></i></span>
                                        <strong class="step-title"><?php echo esc_attr_e('Add Features','framework'); ?></strong>
                                        <span class="step-desc"><?php echo esc_attr_e('Add features of your listing','framework'); ?></span>
                                    </a>
                                </li>
                                <li class="tabs-listing <?php echo esc_attr($tab_class3.' '.$active_tab3); ?>" data-target="#listing-add-form-three" data-rel="listing-add-form-three" data-toggle="tab">
                                    <a href="javascript:void(0);">
                                        <span class="step-state"></span>
                                        <span class="step-icon"><i class="fa fa-edit"></i></span>
                                        <strong class="step-title"><?php echo esc_attr_e('Add details','framework'); ?></strong>
                                        <span class="step-desc"><?php echo esc_attr_e('Your contact details ','framework'); ?>&amp;<?php echo esc_attr_e(' more','framework'); ?></span>
                                    </a>
                                </li>
                                <li class="tabs-listing <?php echo esc_attr($tab_class4.' '.$active_tab4); ?>" data-target="#listing-add-form-four" data-rel="listing-add-form-four" data-toggle="tab">
                                    <a href="javascript:void(0);">
                                        <span class="step-state"></span>
                                        <span class="step-icon"><i class="fa fa-image"></i></span>
                                        <strong class="step-title"><?php echo esc_attr_e('Add photos ','framework'); ?>&amp;<?php echo esc_attr_e(' comments','framework'); ?></strong>
                                        <span class="step-desc"><?php echo esc_attr_e('Add some pics ','framework'); ?>&amp;<?php echo esc_attr_e(' description','framework'); ?></span>
                                    </a>
                                </li>
                                <li class="tabs-listing <?php echo esc_attr($tab_class5.' '.$active_tab5); ?>" data-target="#listing-add-form-five" data-rel="listing-add-form-five" data-toggle="tab">
                                    <a href="javascript:void(0);">
                                        <span class="step-state"></span>
                                        <span class="step-icon"><i class="fa fa-envelope-o"></i></span>
                                        <strong class="step-title"><?php echo esc_attr_e('Publish Listing','framework'); ?></strong>
                                        <span class="step-desc"><?php echo esc_attr_e(' Submit your listing for approval','framework'); ?></span>
                                        <!-- <span class="step-desc"><?php echo esc_attr_e('Pay ','framework'); ?>&amp;<?php echo esc_attr_e(' publish your listing','framework'); ?></span> -->
                                    </a>
                                </li>
                                <img id="loading-listing-save" src="<?php echo IMIC_THEME_PATH; ?>/images/loader.gif" style="display:none;">
                                <div id="message"></div>
                            </ul>
                       	</div>
                    </div>
                    <?php $search_fields = (isset($imic_options['search_vehicle']))?$imic_options['search_vehicle']:array();
					$additional_details = (isset($imic_options['vehicle_more_details']))?$imic_options['vehicle_more_details']:array(); ?>
                    <div class="col-md-8 col-sm-8">
                    <div class="waiting" style="display:none;">
                            	<div class="spinner">
                                  	<div class="rect1"></div>
                                  	<div class="rect2"></div>
                                  	<div class="rect3"></div>
                                  	<div class="rect4"></div>
                                  	<div class="rect5"></div>
                                </div>
                            </div>
                    	<!-- AD LISTING FORM -->
                     	<form name="uploadfrm" id="uploadfrm" method="post" enctype="multipart/form-data" action="<?php echo esc_url($paypal_site); ?>">
                        <input type="hidden" name="_auto" value="1">
                        <input type="hidden" name="edit-vehicle" id="vehicle-id" value="<?php echo esc_attr($update_id); ?>" class="<?php echo esc_attr($update_id); ?>">
                    		<section class="listing-form-content">
                    			<!-- AD LISTING FORM STEP ONE -->
                      			<div id="listing-add-form-one" class="tab-pane fade <?php echo ($active_tab1!='')?$active_tab1.' in':''; ?>">
                        			<h3><?php echo esc_attr_e('Enter your yacht specifications','framework'); ?></h3>
                            		<!-- <div class="lighter"><p><?php echo esc_attr_e('Listing can be added with a starting point of choosing your yacht wither by searching listing using Shipyard, Model, Year or can add a completely unique listing.','framework'); ?></p></div> -->
                                    <?php if($imic_options['ad_listing_fields']==0) { ?>
                                    <div class="spacer-10"></div>
                                    <?php } ?>
                                    <div class="tabs listing-step-tabs">
                                    <?php if($imic_options['ad_listing_fields']==0) { ?>
                                        <ul class="nav nav-tabs" style="display:none;">
                                            <li class="<?php echo $active_form_search; ?>"> <a data-toggle="tab" href="#searchvehicle" aria-controls="searchvehicle" role="tab"><?php echo esc_attr_e('Search yacht by Shipyard, Model, Year','framework'); ?></a></li>
                                            <li class="custom-vehicle-details <?php echo $active_custom_form; ?>" style="display:none;"> <a data-toggle="tab" href="#addcustom" aria-controls="addcustom" role="tab"><?php echo esc_attr_e('Add custom yacht details','framework'); ?></a></li>
                                        </ul>
                                        <?php } ?>
                                        <div class="tab-content">
                    						<!-- YACHT SEARCH AD LISTING -->
                                            <?php $first = 0; if(!empty($search_fields)) { $first = 1;
											if($imic_options['ad_listing_fields']==0)
											{ ?>
                                            <div id="searchvehicle" class="tab-pane fade <?php echo $active_tab_search; ?>">
                                                <div class="alert alert-warning fade in">
                                                    <strong><?php echo esc_attr_e('Find','framework'); ?></strong><?php echo esc_attr_e(' your listing using the dropdowns below. First select its Shipyard, then Model and later select its Year. ','framework'); ?><a data-toggle="tab" href="#addcustom"><?php echo esc_attr_e('Add custom yacht details','framework'); ?></a>
                                                </div>
                                                <div class="row">
                                                <?php if(!empty($search_fields)) { echo '<div class="col-md-6">';
													foreach($search_fields as $field) { 
													$editable = get_post_meta($field,'imic_plugin_status_after_payment',true);
													$disable = (($editable==0)&&($payment_status!=0))?'disabled':'';
													$post_data = get_post($field);
													$spec_slug = $post_data->post_name;
													$values = get_post_meta($field,'specifications_value',true);
													$required = get_post_meta($field,'imic_plugin_required_mandatory',true);
													$integer = get_post_meta($field,'imic_plugin_spec_char_type',true);
													$slug = imic_the_slug($field);
													if($integer==0)
													{
														$input_id = 'field-'.($field+2648);
													}
													elseif($integer==1)
													{
														$input_id = 'int_'.$slug;
													}
													else
													{
														$input_id = 'char_'.$slug;
													}
													$required = ($required==1)?'mandatory':'';
													echo '<label>Select '.get_the_title($field).'</label>';
													if(!empty($values[0]['imic_plugin_specification_values'])) {
                                                        echo '<select id="'.esc_attr($input_id).'" name="'.basename(get_permalink($field)).'" '.$disable.' class="sortable-specs form-control selectpicker search-cars-fields '.$required.'">';
														echo '<option value="0">'.__('Select','framework').'</option>';
														if($update_id!='') {
															if($integer==0) {
															$key = array_search($field,$specifications['sch_title']);
															$required_value = $specifications['start_time'][$key];
															} 
															elseif($integer==2)
															{
																$required_value = get_post_meta($update_id,'char_'.$spec_slug,true);
															}
															else {
															$required_value = get_post_meta($update_id,'int_'.$spec_slug,true);
															}
														}
														$key_select = $count = 0;
														foreach($values as $value) {
															$required_select = ($required_value==$value['imic_plugin_specification_values'])?'selected':'';
															if($required_select!='') { $key_select = $count; }
                                                            echo '<option '.esc_attr($required_select).' value="'.$value['imic_plugin_specification_values'].'">'.$value['imic_plugin_specification_values'].'</option>';
															$count++;
														}
                                                        echo '</select>';
														$child_field_class = ($integer==0)?"field-":"char-";
														$child_field_class_select = ($integer==0)?"field-":"child-";
														echo '<div class="'.$child_field_class.(($field*111)+2648).' sorting-dynamic">';
														if((!empty($values[$key_select]['imic_plugin_specification_values_child']))) {
															echo '<label>Select '.get_post_meta($field,'imic_plugin_sub_field_label',true).'</label>';
															echo '<select '.esc_attr($disable).' id="'.$child_field_class_select.(($field*111)+2648).'" name="'.($field*111).'" class="form-control selectpicker search-cars-fields">';
														echo '<option value="0">'.__('Select ','framework').get_the_title($field).'</option>';
														if($update_id!='') {
															$key = array_search($field*111,$specifications['sch_title']);
															$required_value = $specifications['start_time'][$key];
														$child_vals = $values[$key_select]['imic_plugin_specification_values_child'];
														if(!empty($child_vals)) {
															$child_values = explode(',',$child_vals);
														}
														foreach($child_values as $value) {
															$required_select = ($required_value==$value)?'selected':'';
                            		echo '<option '.esc_attr($required_select).' value="'.$value.'">'.$value.'</option>';
														} 
														}
                          		echo '</select>'; }
														echo '</div>';
														}
														else {
															if($update_id!='') {
															$required_value = '';
															$key = array_search($field,$specifications['sch_title']);
															$required_value = $specifications['start_time'][$key];
														}
														echo '<input '.esc_attr($disable).' type="text" id="'.$input_id.'" value="'.$required_value.'" name="'.basename(get_permalink($field)).'" class="form-control custom-cars-fields '.esc_attr($required).'" placeholder="'.get_the_title($field).'*">'; }
													
												} } $status_vehicle = get_post_meta($update_id,'imic_plugin_ad_payment_status',true);
											if($status_vehicle=="3"||$status_vehicle=="0") {
												if(is_user_logged_in()) { ?>
                                                        <input type="submit" id="find-matched-cars" class="btn btn-primary pull-right find-cars" value="<?php echo esc_attr_e('Find','framework'); ?>"><?php } else { echo '<a class="btn btn-primary pull-right" data-toggle="modal" data-target="#PaymentModal">'.__('Login/Register','framework').'</a>'; } } ?>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="col-md-6">
                                                    	<div id="finded-results">
                                                        	<!-- Result -->
                                                        	<div class="loading-result-found" style="display:none;"><?php _e('Searching...','framework'); ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><?php } } $second_active = ($first==0)?"active in":"";
																						if(is_user_logged_in()) {
																						 ?>
                    						<!-- CUSTOM VEHICLE LISTING -->
                                            <div id="addcustom" class="tab-pane fade <?php echo esc_attr($second_active); echo esc_attr($active_tab_custom); ?>">
                                            <?php }
																						else
																						{
																								echo '<div data-toggle="modal" data-target="#PaymentModal" id="addcustom" class="tab-pane fade '.esc_attr($second_active).' '.esc_attr($active_tab_custom).'">';
																						}
																						if($imic_options['ad_listing_fields']==0) { ?>
                                                <div class="alert alert-warning fade in">
                                                    <?php echo esc_attr_e('Yacht ad listing can take few days to review. ','framework'); ?>
                                                    <!-- <a data-toggle="tab" href="#searchvehicle"><?php echo esc_attr_e('Try search again','framework'); ?></a> -->
                                                </div>
                                          	<?php } ?>
                                                <div class="row">
                                                    <?php 
													if(get_query_var('list-cat')!='')
													{
														$category_slug = get_query_var('list-cat');
														$term_id = get_term_by('slug', $category_slug, 'listing-category');
														$parents = get_ancestors( $term_id->term_id, 'listing-category' );
														$term_id = $term_id->term_id;
														$classifieds_details = get_option('imic_classifieds');
														$classifieds_details = (!empty($classifieds_details))?get_option('imic_classifieds'):array();
														if ((array_key_exists($term_id, $classifieds_details))&&(!empty($classifieds_details))) 
														{
															$custom_details = $classifieds_details[$term_id]['ad'];
															$custom_details = explode(',', $custom_details);
														}
														else
														{
															foreach($parents as $parent)
															{ 
																$list_term = get_term_by('id', $parent, 'listing-category');
																if ((array_key_exists($list_term->term_id, $classifieds_details))&&(!empty($classifieds_details))) 
																{
																	$custom_details = $classifieds_details[$list_term->term_id]['ad'];
																	$custom_details = explode(',', $custom_details);
																	break;
																}
															}
														}
														if(empty($custom_details[0]))
														{
															$custom_details = $imic_options['custom_vehicle_details'];
														}
													}
													else
													{
														$custom_details = (isset($imic_options['custom_vehicle_details']))?$imic_options['custom_vehicle_details']:array();
													}
													
									if(!empty($custom_details)) 
									{ 
									$total_fields = count($custom_details); 
													$half = $total_fields/2; 
													$half = (imic_is_decimal($half))?$half+1:$half; 
													$half = floor($half); 
													$st = 1;
										foreach($custom_details as $field) 
										{ 
											$label = get_post_meta($field,'imic_plugin_value_label',true);
											$editable = get_post_meta($field,'imic_plugin_status_after_payment',true);
											if(!is_user_logged_in())
											{
												$editable = 0;
												$payment_status = 1;
											}
											$disable = (($editable==0)&&($payment_status!=0))?'disabled':'';
											if($st==1||$st==$half+1) 
											{
												echo '<div class="col-md-6">'; 
											}
											$values = get_post_meta($field,'specifications_value',true);
											$post_data = get_post($field);
											$spec_slug = $post_data->post_name;
											$required = get_post_meta($field,'imic_plugin_required_mandatory',true);
											$integer = get_post_meta($field,'imic_plugin_spec_char_type',true);
											$sub_fields = get_post_meta($field,'imic_plugin_sub_field_switch',true);
											$sortable_class = ($sub_fields==1)?"sortable-specs":"";
											if($integer==0)
											{
												$input_id = 'field-'.($field+2648);
											}
											elseif($integer==2)
											{
												$input_id = 'char-'.($field+2648);
											}
											else
											{
												$input_id = 'int-'.$field;
											}
											$required = ($required==1)?'mandatory':'';
											$int_value = ($integer==1)?'integer-val':'';
											echo '<label>'.get_the_title($field).'</label>';
											if((count($values)>1)&&($integer==0||$integer==2)) 
											{
                                            	echo '<select '.$disable.' name="'.basename(get_permalink($field)).'" id="'.$input_id.'" class="'.$sortable_class.' form-control selectpicker custom-cars-fields '.$required.'">';
												echo '<option value="0">'.__('Select','framework').'</option>';
												if($update_id!='') 
												{
													if($integer==0) 
													{
														$key = array_search($field,$specifications['sch_title']);
														$required_value = $specifications['start_time'][$key];
													} 
													elseif($integer==2)
													{
														$required_value = get_post_meta($update_id,'char_'.$spec_slug,true);
													}
													else 
													{
														$required_value = get_post_meta($update_id,'int_'.$spec_slug,true);
													}
												}
												$key_select = $count = 0;
												foreach($values as $value) 
												{
													$required_select = ($required_value==$value['imic_plugin_specification_values'])?'selected':'';
													if($required_select!='') 
													{ 
														$key_select = $count; 
													}
                                                   	echo '<option '.esc_attr($required_select).' value="'.$value['imic_plugin_specification_values'].'">'.$value['imic_plugin_specification_values'].'</option>';
													$count++;
												} 
												echo '</select>';
												if(($sub_fields==1&&$integer==0)||($sub_fields==1&&$integer==2)) 
												{
													$child_field_class = ($integer==0)?"field-":"char-";
													$child_field_class_select = ($integer==0)?"field-":"child-";
													echo '<div class="'.$child_field_class.(($field*111)+2648).' sorting-dynamic">';
													if((!empty($values[$key_select]['imic_plugin_specification_values_child']))) 
													{
														echo '<label>Select '.get_post_meta($field,'imic_plugin_sub_field_label',true).'</label>';
														echo '<select '.$disable.' id="'.$child_field_class_select.(($field*111)+2648).'" name="'.($field*111).'" class="form-control selectpicker custom-cars-fields">';
														echo '<option value="0">'.__('Select ','framework').get_the_title($field).'</option>';
														if($update_id!='') 
														{
															if($specification_data_type=="0")
															{
																$key = array_search($field*111,$specifications['sch_title']);
																$required_value = $specifications['start_time'][$key];
															}
															else
															{
																$child_field_slug = imic_the_slug($field);
																$required_value = get_post_meta($field, 'char_'.$child_field_slug, true);
															}
																$child_vals = $values[$key_select]['imic_plugin_specification_values_child'];
																if(!empty($child_vals)) 
															{
																$child_values = explode(',',$child_vals);
															}
															foreach($child_values as $value) 
															{
																$required_select = ($required_value==$value)?'selected':'';
                                                            	echo '<option '.$required_select.' value="'.$value.'">'.$value.'</option>';
															} 
														}
                                                        echo '</select>'; 
													}
													echo '</div>';
												} 
											}
											else 
											{
												if($update_id!='') 
												{
													$required_value = '';
													if($integer==0) 
													{
														$key = array_search($field,$specifications['sch_title']);
														$required_value = $specifications['start_time'][$key];
													}
													elseif($integer==2)
													{
														$required_value = get_post_meta($update_id,'char_'.$spec_slug,true);
													}
													else 
													{
														$required_value = get_post_meta($update_id,'int_'.$spec_slug,true); }
													}
													if($label!='') 
													{
														echo '<div class="input-group">
														<input '.$disable.' type="text" id="'.$input_id.'" value="'.$required_value.'" name="'.basename(get_permalink($field)).'" class="form-control custom-cars-fields '.$required.' '.$int_value.'" placeholder="'.get_the_title($field).'">
														<span class="input-group-addon">'.$label.'</span></div>'; 
													}
													else 
													{
														echo '<input '.$disable.' type="text" id="'.$input_id.'" value="'.$required_value.'" name="'.basename(get_permalink($field)).'" class="form-control custom-cars-fields '.$required.' '.$int_value.'" placeholder="'.get_the_title($field).'">'; 
													}	
												}
                                               	if(($st==$half)) 
												{ 
													echo '</div>'; 
												} 
												$st++;   
											} 
										} 
										else { echo '<div class="col-md-12 col-sm-12"><h3>'.__('Please select category','framework').'</h3></div>'; } 
										if(is_user_logged_in()) 
										{ ?>
                                        	<button id="ss" class="btn btn-info pull-right save-searched-value"><?php echo esc_attr_e('Save','framework'); ?> &amp; <?php echo esc_attr_e('continue','framework'); ?></button><?php } else { //echo '<a class="btn btn-primary pull-right" data-toggle="modal" data-target="#PaymentModal">'.__('Login/Register','framework').'</a>'; 
										}
										if(!empty($custom_details)) { echo '</div>'; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                    			<!-- AD LISTING FORM STEP TWO -->
                      			<div id="listing-add-form-two" class="tab-pane fade <?php echo ($active_tab2!='')?$active_tab2.' in':''; ?>">
                        			<h3><?php echo esc_attr_e('Add additional features your yacht have','framework'); ?></h3>
                            		<div class="lighter"><p><?php echo esc_attr_e('Features added can either factory fitted or after market features.','framework'); ?></p></div>
                                    <div class="panel panel-default">
                                        <div id="featcontainer">
											<!-- <label for="featcontent" class="screen-reader-text"><?php _e( 'Yacht Features' ); ?></label> -->
											<?php
											//$featcontent = (!empty(get_post_meta($update_id,'imic_tab_area1',true))) ? get_post_meta($update_id,'imic_tab_area1',true) : '';
											$featcontent = get_post_meta($update_id,'imic_tab_area1',true);
											$quicktags_settings = array( 'buttons' => 'strong,em,link,block,del,ins,img,ul,ol,li,code,close' );
											wp_editor( $featcontent, 'featcontent', array( 'media_buttons' => false, 'tinymce' => true, 'quicktags' => false) );
											?>
										</div>
                                   	</div>
                                	
                                   <?php if(is_user_logged_in()) { ?>
                                                        <button id="ss" class="btn btn-info pull-right save-searched-value"><?php echo esc_attr_e('Save ','framework'); ?>&amp;<?php echo esc_attr_e(' continue','framework'); ?></button><?php } else { echo '<a class="btn btn-primary pull-right" data-toggle="modal" data-target="#PaymentModal">'.__('Login/Register','framework').'</a>'; } ?>
                                </div>
                            
                    			<!-- AD LISTING FORM STEP THREE -->
                      			<div id="listing-add-form-three" class="tab-pane fade <?php echo ($active_tab3!='')?$active_tab3.' in':''; ?>">
                                	<h3><?php echo esc_attr_e('Tell us more about your listing specific details','framework'); ?></h3>
                            		<div class="lighter"><p><?php echo esc_attr_e('Be specific and clear about this details to make your listing selling quickly.','framework'); ?></p></div>
                                    <div class="row">
                                    	<div class="col-md-6">
                                       		<?php if(!empty($additional_details)) { 
													foreach($additional_details as $field) {
													$label = get_post_meta($field,'imic_plugin_value_label',true);
													$editable = get_post_meta($field,'imic_plugin_status_after_payment',true);
													$disable = (($editable==0)&&($payment_status!=0))?'disabled':'';
													$values = get_post_meta($field,'specifications_value',true);
													$post_data = get_post($field);
													$spec_slug = $post_data->post_name;
													$required = get_post_meta($field,'imic_plugin_required_mandatory',true);
													$integer = get_post_meta($field,'imic_plugin_spec_char_type',true);
													if($integer==0)
													{
														$input_id = 'field-'.($field+2648);
													}
													elseif($integer==2)
													{
														$input_id = 'char-'.$field;
													}
													else
													{
														$input_id = 'int-'.$field;
													}
													$sub_fields = get_post_meta($field,'imic_plugin_sub_field_switch',true);
													$sortable_class = ($sub_fields==1)?"sortable-specs":"";
													$required = ($required==1)?'mandatory':'';
													$int_value = ($integer==1)?' integer-val':'';
													echo '<label>'.get_the_title($field).'</label>';
														if((count($values)>1)&&($integer==0||$integer==2)) {
                                                        echo '<select '.$disable.' name="'.basename(get_permalink($field)).'" id="'.$input_id.'" class="'.$sortable_class.' form-control selectpicker custom-cars-fields '.$required.'">';
														echo '<option value="0">'.__('Select','framework').'</option>';
														if($update_id!='') {
															if($integer==0) {
															$key = array_search($field,$specifications['sch_title']);
															$required_value = $specifications['start_time'][$key];
															} 
															elseif($integer==2)
															{
																$required_value = get_post_meta($update_id,'char_'.$spec_slug,true);
															}
															else {
															$required_value = get_post_meta($update_id,'int_'.$spec_slug,true);
															}
														}
														$key_select = $count = 0;
														foreach($values as $value) {
															$required_select = ($required_value==$value['imic_plugin_specification_values'])?'selected':'';
															if($required_select!='') { $key_select = $count; }
                                                            echo '<option '.$required_select.' value="'.$value['imic_plugin_specification_values'].'">'.$value['imic_plugin_specification_values'].'</option>';
															$count++;
														} echo '</select>';
														if($sub_fields==1&&($integer==0||$integer==2)) 
														{
															$child_field_class = ($integer==0)?"field-":"char-";
															$child_field_class_select = ($integer==0)?"field-":"child-";
															echo '<div class="'.$child_field_class.(($field*111)+2648).' sorting-dynamic">';
															if((!empty($values[$key_select]['imic_plugin_specification_values_child']))) 
															{
																echo '<label>Select '.get_post_meta($field,'imic_plugin_sub_field_label',true).'</label>';
																echo '<select '.$disable.' id="'.$child_field_class_select.(($field*111)+2648).'" name="'.($field*111).'" class="form-control selectpicker custom-cars-fields">';
														echo '<option value="0">'.__('Select ','framework').get_the_title($field).'</option>';
														if($update_id!='') {
															if($specification_data_type=="0")
															{
																$key = array_search($field*111,$specifications['sch_title']);
																$required_value = $specifications['start_time'][$key];
															}
															else
															{
																$child_field_slug = imic_the_slug($field);
																$required_value = get_post_meta($field, 'char_'.$child_field_slug, true);
															}
														$child_vals = $values[$key_select]['imic_plugin_specification_values_child'];
														//print_r($child_vals);
														if(!empty($child_vals)) {
															$child_values = explode(',',$child_vals);
														}
														//print_r($child_values);
														foreach($child_values as $value) {
															$required_select = ($required_value==$value)?'selected':'';
                                                            echo '<option '.$required_select.' value="'.$value.'">'.$value.'</option>';
														} }
                                                        echo '</select>'; }
														echo '</div>';
														 } }
														else {
														if($update_id!='') {
															$required_value = '';
															if($integer==0) {
															$key = array_search($field,$specifications['sch_title']);
															$required_value = $specifications['start_time'][$key]; }
															elseif($integer==2)
															{
																$required_value = get_post_meta($update_id,'char_'.$spec_slug,true);
															}
															else {
															$required_value = get_post_meta($update_id,'int_'.$spec_slug,true); }
														}
														if($label!='') {
														echo '<div class="input-group"><input '.esc_attr($disable).' type="text" id="'.esc_attr($input_id).'" value="'.$required_value.'" name="'.basename(get_permalink($field)).'" class="form-control custom-cars-fields '.esc_attr($required).esc_attr($int_value).'" placeholder="'.get_the_title($field).'"><span class="input-group-addon">'.$label.'</span></div>'; }
														else {
														echo '<input '.$disable.' type="text" id="'.$input_id.'" value="'.$required_value.'" name="'.basename(get_permalink($field)).'" class="form-control custom-cars-fields '.esc_attr($required).esc_attr($int_value).'" placeholder="'.get_the_title($field).'">'; }	
														}
													
												} }
												if($update_id) { $car_phone_no = get_post_meta($update_id,'imic_plugin_contact_phone',true);
												$car_email_ad = get_post_meta($update_id,'imic_plugin_contact_email',true); }
												else { $car_phone_no = get_post_meta($user_info_id,'imic_user_telephone',true);
												$car_email_ad = $current_user->user_email; }
												 ?>
                                            <hr class="fw">
                                            <h3><?php echo esc_attr_e('How can buyers contact you?','framework'); ?></h3>
                            				<div class="lighter"><p><?php echo esc_attr_e('Make sure to enter them right as your Ad listing depends on this only.','framework'); ?></p></div>
                                           	<label><?php echo esc_attr_e('Enter Your Phone Number*','framework'); ?></label>
                                           	<input value="<?php echo esc_attr($car_phone_no); ?>" id="vehicle-contact-phone" type="text" class="form-control" placeholder="000-00-0000"  >
                                           	<label><?php echo esc_attr_e('Enter Your Email Address','framework'); ?></label>
                                           	<input value="<?php echo esc_attr($car_email_ad); ?>" id="vehicle-contact-email" type="email" class="form-control" placeholder="mail@example.com">
                                			
                                            <?php if(is_user_logged_in()) { ?>
                                                        <button id="ss" class="btn btn-info pull-right save-searched-value"><?php echo esc_attr_e('Save ','framework'); ?>&amp;<?php echo esc_attr_e(' continue','framework'); ?></button><?php } else { echo '<a class="btn btn-primary pull-right" data-toggle="modal" data-target="#PaymentModal">'.__('Login/Register','framework').'</a>'; } ?>
                                        </div>
                                        <div class="col-md-5 col-md-offset-1">
                                        	<div class="panel panel-info price-suggestion" style="display:none;">
                                              	<div class="panel-heading">
                                               	 	<h3 id="find-price" class="panel-title"><?php echo esc_attr_e('Price Guide','framework'); ?> <i class="fa fa-search pull-right"></i></h3>
                                              	</div>
                                              	<div class="panel-body">
                                                    <div class="input-group">
                                                        <!--<button id="find-price" class="btn btn-info pull-right">Save &amp; continue</button>
                                                        <span class="input-group-addon">$</span>-->
                                                    </div>
                                                    <p id="price-guide" class="small"></p>
                                              	</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                    			<!-- AD LISTING FORM STEP FOUR -->
                      			<div id="listing-add-form-four" class="tab-pane fade <?php echo ($active_tab4!='')?$active_tab4.' in':''; ?>">
                                    <h3><?php echo esc_attr_e('Upload your listing photos','framework'); ?></h3>
                                    <div class="lighter"><p><?php echo esc_attr_e('Registered listing owners should include at least one picture.','framework'); ?></p></div>
                                    <?php $content = '';
										if($update_id!='')
										{
											$post_id = get_post($update_id);
											$content = $post_id->post_content;
											//$content = apply_filters('the_content', $content);
										} ?>
                                    <div class="image-placeholder" id="photoList_new"> </div>
                                    <?php $property_sights_value = get_post_meta($update_id,'imic_plugin_vehicle_images',false);
                                            echo'<div class="image-placeholder" id="photoList">';
                                            if (!empty($property_sights_value)) {
                                                foreach ($property_sights_value as $property_sights) {
                                                    $default_featured_image = get_post_meta($update_id, '_thumbnail_id', true);
                                                    if ($default_featured_image == $property_sights) {
                                                        $def_class = 'default-feat-image';
                                                    } else {
                                                        $def_class = '';
                                                    }
                                                    echo '<div class="col-md-2 col-sm-2">';
                                                    echo '<div id="property-img"><div id="property-thumb" class="' . esc_attr($def_class) . '"><a id="feat-image" class="accent-color default-image" data-original-title="Set as default image" data-toggle="tooltip" style="text-decoration:none;" href="javascript:void(0);"><div class="property-details" style="display:none;"><span class="property-id">' . $update_id . '</span><span class="thumb-id">' . $property_sights . '</span></div><img src="' . wp_get_attachment_thumb_url($property_sights) . '" class="image-placeholder" id="filePhoto2" alt=""/></a>';
                                                    if (get_query_var('edit')) {
                                                        echo '<input rel="' . $update_id . '" type="button" id="' . $property_sights . '" value="Remove" class="btn btn-sm btn-default remove-image">';
                                                    }
                                                    echo '</div></div>';
                                                    echo '</div>';
                                                }
                                            }
                                            echo '</div>';
                                            ?>
                                         <?php FRONT_MEDIA_ALLOW::wp_media_upload_button(); ?>
                               <hr class="fw">
                               <h3><?php echo esc_attr_e('Provide a hosted video URL of your listing','framework'); ?></h3>
                                    <div class="lighter"><p><?php echo esc_attr_e('As per our experience and selling stats we found that listings with video available sell more faster than the one which do not have any video.','framework'); ?></p>
                                    </div>
                                    <input value="<?php echo get_post_meta($update_id,'imic_plugin_video_url',true); ?>" name="vehicle-video" id="vehicle-video" type="text" class="form-control" placeholder="Youtube/Video URL">
                                    <hr class="fw">
                                    <h3><?php echo esc_attr_e('Add some comments about your listing','framework'); ?></h3>
                                    <div class="lighter"><p><?php echo esc_attr_e('Enter here some impressive wording about your yacht to attract more buyers interested in your Ad listing. This will appear on the search results page as well.','framework'); ?></p></div>
                                    <textarea name="vehicle-detail" id="vehicle-detail" class="form-control" rows="10"><?php echo $content; ?></textarea>
                                    
                                    <?php if(is_user_logged_in()) { ?>
                                                        <button type="submit" name="upload" id="ss" class="btn btn-info pull-right save-searched-value"><?php echo esc_attr_e('Save ','framework'); ?>&amp;<?php echo esc_attr_e(' continue','framework'); ?></button><?php } else { echo '<a class="btn btn-primary pull-right" data-toggle="modal" data-target="#PaymentModal">'.__('Login/Register','framework').'</a>'; } ?>
                                </div>
                            
                    			<!-- AD LISTING FORM STEP FIVE -->
                      			<div id="listing-add-form-five" class="tab-pane fade <?php echo ($active_tab5!='')?$active_tab5.' in':''; ?>">
                                	<h3><?php echo esc_attr_e('About the listing approval process','framework'); ?></h3>
                            		<div class="lighter"><p><?php echo esc_attr_e('To make sure listings are safe and appropriate for everyone, all listings go through an approval process using the Invictvs ads policies. Most listings are reviewed within 1 business day. However, some reviews take longer because the listing requires a more complex review. Once the listing is approved and published any user of our website will be able to contact you about the listing.','framework'); ?></p></div>
                                    <div class="btn-group selling-choice" data-toggle="buttons">
                                    <?php $listing_view = get_post_meta($update_id,'imic_plugin_listing_view',true); ?>
                                        <label class="btn btn-default <?php echo ($listing_view=="all"||$listing_view=="")?"active":""; ?>" style="display:none;">
                                            <input type="radio" name="Loan-Tenure" id="option1" autocomplete="off" value="all" <?php echo ($listing_view=="all"||$listing_view=="")?"checked":""; ?>> 
                                            <i class="fa fa-group"></i> <strong><?php echo esc_attr_e('Submit Your listing for Approval','framework'); ?></strong>
                                        </label>
                                        <!-- <label class="btn btn-default <?php echo ($listing_view=="dealer")?"active":""; ?>">
                                            <input type="radio" name="Loan-Tenure" id="option2" value="dealer" autocomplete="off" <?php echo ($listing_view=="dealer")?"checked=\"checked\"":""; ?>>  <i class="fa fa-user"></i><strong><?php echo esc_attr_e('Sell Your listing to dealers','framework'); ?></strong>
                                        </label> -->
                                    </div>
                                    <hr class="fw">
                                    <?php if($opt_plans!=0) { ?>
                                	<h3><?php echo esc_attr_e('Enter your billing info','framework'); ?></h3>
                            		<div class="lighter"><p><?php echo esc_attr_e('Payment are accepted using Paypal secure payment gateway and you will be redirected to Paypal payment page.','framework'); ?></p></div>
                                    <?php } ?>
                                    <div class="row">
                                    	<div class="col-md-6">
                                        <?php if($opt_plans!=0) { ?>
                                        	<div class="row">
                                            	<div class="col-md-6">
                                                <input type="hidden" id="uid" value="<?php echo esc_attr($user_id); ?>">
                                                <input type="hidden" id="uinfo" value="<?php echo esc_attr($user_info_id); ?>">
                                           			<label><?php echo esc_attr_e('First name','framework'); ?>*</label>
                                                	<input id="fname" value="<?php echo esc_attr($current_user->user_firstname); ?>" type="text" class="form-control" placeholder=""  >
                                               	</div>
                                            	<div class="col-md-6">
                                           			<label><?php echo esc_attr_e('Last name','framework'); ?></label>
                                                	<input id="lname" value="<?php echo esc_attr($current_user->user_lastname); ?>" type="text" class="form-control" placeholder="">
                                               	</div>
                                            </div>
                                        	<div class="row">
                                            	<div class="col-md-6">
                                           			<label><?php echo esc_attr_e('Email','framework'); ?>*</label>
                                                	<input value="<?php echo esc_attr($current_user->user_email); ?>" type="text" class="form-control" placeholder="mail@example.com" disabled >
                                               	</div>
                                            	<div class="col-md-6">
                                           			<label><?php echo esc_attr_e('Phone','framework'); ?></label>
                                                	<input id="uphone" value="<?php echo esc_attr(get_post_meta($user_info_id,'imic_user_telephone',true)); ?>" type="text" class="form-control" placeholder="000-00-0000">
                                               	</div>
                                            </div>
                                        	<div class="row">
                                            	<div class="col-md-6">
                                           			<label><?php echo esc_attr_e('City','framework'); ?>*</label>
                                                	<input id="ucity" value="<?php echo get_post_meta($user_info_id,'imic_user_city',true); ?>" type="text" class="form-control" placeholder="">
                                               	</div>
                                            	<div class="col-md-6">
                                           			<label><?php echo esc_attr_e('Zip','framework'); ?>*</label>
                                                	<input id="uzip" value="<?php echo get_post_meta($user_info_id,'imic_user_zip_code',true); ?>" type="text" class="form-control" placeholder=""  >
                                               	</div>
                                            </div>
                                            <?php $ustate = ''; $user_state = wp_get_post_terms($user_info_id, 'user-city');
											if(!empty($user_state)) { $ustate = $user_state[0]->slug; }
											$user_city = get_terms('user-city',array('hide_empty'=>false,'orderby'=>'name')); ?>
                                            <label><?php echo esc_attr_e('Select State','framework'); ?>*</label>
                                            <select id="ustate" class="form-control selectpicker">
                                                <option><?php echo esc_attr_e('Select','framework'); ?></option>
                                                <?php foreach($user_city as $city) { ?>
                                                <option <?php echo ($ustate==$city->slug)?'selected':''; ?> value="<?php echo esc_attr($city->slug); ?>"><?php echo esc_attr($city->name); ?></option>
                                                <?php } ?>
                                            </select>
                                            <input type="hidden" name="rm" value="2">
                                            <input type="hidden" name="amount" value="<?php echo esc_attr($plan_price); ?>">
                                            <input type="hidden" name="cmd" value="_xclick">
                                            <input type="hidden" name="business" value="<?php echo esc_attr($paypal_email); ?>">
                                            <input type="hidden" name="currency_code" value="<?php echo esc_attr($paypal_currency); ?>">
                                            <input type="hidden" name="item_name" value="<?php echo get_the_title($plan); ?>">
                                            <input type="hidden" name="item_number" value="<?php echo esc_attr($plan); ?>">
                                            <input type="hidden" name="return" value="<?php echo esc_url(add_query_arg( array('plans' => $plan, 'edit' => get_query_var('edit')),$thanks)); ?>" />
                                            <?php } $status_vehicle = get_post_meta($update_id,'imic_plugin_ad_payment_status',true);
											if($status_vehicle=="3"||$status_vehicle=="0"||$status_vehicle=="") { ?>
                                			
                                            <?php if(is_user_logged_in()) { ?>
                                                        <input type="submit" id="final-pay" class="btn btn-info btn-block" value="<?php if($opt_plans!=0) { echo __('Pay','framework'); ?> &amp; <?php } echo __('Submit Listing','framework'); ?>"><?php } else { echo '<a class="btn btn-primary pull-right" data-toggle="modal" data-target="#PaymentModal">'.__('Login/Register','framework').'</a>'; } if($opt_plans!=0) { ?>
											<p class="small"><?php echo esc_attr_e('You will be redirected to Paypal secure payment page for the payment which can be done using your Paypal account or via Credit Card','framework'); ?></p><?php } }
											if($opt_plans!=0) { ?>
                                        </div>
                                        <div class="col-md-5 col-md-offset-1">
                                        <?php if($payment_status<=0&&$opt_plans==1) { ?>
                                        	<div class="panel panel-info selected-price-plan">
                                              	<div class="panel-heading">
                                               	 	<h3 class="panel-title"><?php echo esc_attr_e('Your advert plan','framework'); ?></h3>
                                              	</div>
                                              	<div class="panel-body">
                                                <span class="plan-blocked current-plan"><?php echo (get_query_var('plans'))?get_the_title(get_query_var('plans')):__('Select Plan','framework'); ?></span>
                                                <a data-target="#plan-select" data-toggle="modal" href="#" class="basic-link"><?php echo esc_attr_e('Change','framework'); ?></a>
                                              	</div>
                                            </div><?php } ?>
                                        </div>
                                    </div><?php } ?>
                                </div>
                        	</section>
                      	</form>
                    </div>
                </div>
           	</div>
        </div>
   	</div>
    <!-- End Body Content -->
<!--Modal Plans-->
<div id="plan-select" class="modal fade" aria-hidden="true" aria-labelledby="mymodalLabel" role="dialog" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button class="close" aria-hidden="true" data-dismiss="modal" type="button"><?php echo esc_attr_e('×','framework'); ?></button>
<h4 id="mymodalLabel" class="modal-title"><?php echo esc_attr_e('Plans','framework'); ?></h4>
</div>
<div class="modal-body">
<div class="pricing-table three-cols margin-0">
                    <?php 	$add_listing = imic_get_template_url('template-add-listing.php');
							$args_plan = array('post_type'=>'plan','post_status'=>'publish','posts_per_page'=>-1);
							$plan_listing = new WP_Query( $args_plan );
							if ( $plan_listing->have_posts() ) :
							while ( $plan_listing->have_posts() ) :	
							$plan_listing->the_post();
							$highlight = get_post_meta(get_the_ID(),'imic_pricing_highlight',true);
							$highlight_class = ($highlight==1)?"highlight accent-color":"";
							$price = get_post_meta(get_the_ID(),'imic_plan_price',true);
							$currency = (isset($imic_options['paypal_currency']))?$imic_options['paypal_currency']:'USD';
							$currency = imic_get_currency_symbol($currency);
							$plan_currency = get_post_meta(get_the_ID(), 'imic_plan_currency', true);
                            $plan_currency_position = get_post_meta(get_the_ID(), 'imic_plan_currency_position', true);
							if($price!=0||$price!='free') { $paypal_site = ($paypal_site=="1")?"https://www.paypal.com/cgi-bin/webscr":"https://www.sandbox.paypal.com/cgi-bin/webscr"; }
							else {
							$paypal_site = ''; }
							$advantage = get_post_meta(get_the_ID(),'imic_plan_advantage',true); ?>
                        <div class="pricing-column <?php echo esc_attr($highlight_class); ?>">
                        <h3><?php echo get_the_title(); ?><span class="highlight-reason"><?php echo esc_attr($advantage); ?></span></h3>
                            <div class="pricing-column-content">
                                                        <?php if($plan_currency_position==1)
                        {
                            echo '<h4><span class="dollar-sign">'.$plan_currency.'</span>'.$price.'</h4>';
                        }
                        else
                        {
                            echo '<h4>'.$price.'<span class="dollar-sign">'.$plan_currency.'</span></h4>';
                        } ?>
                                <span class="interval"><?php echo esc_attr_e('Until Sold','framework'); ?></span>
                                <?php the_content(); ?>
                                <a data-dismiss="modal" class="btn btn-primary select-plan"><div style="display:none;"><span class="plan-id"><?php echo esc_attr(get_the_ID()); ?></span><span class="plan-title"><?php echo get_the_title(); ?></span><span class="plan-price-sh"><?php echo esc_attr($price); ?></span><span class="plan-thanks"><?php echo esc_url($thanks); ?></span><span class="plan-url"><?php echo esc_url($paypal_site); ?></span></div><?php echo esc_attr_e('Select','framework'); ?></a>
                            </div>
                        </div>
                        <?php endwhile; endif; wp_reset_postdata(); ?>
                    </div>
</div>
<div class="modal-footer">
<button class="btn btn-default inverted" data-dismiss="modal" type="button"><?php echo esc_attr_e('Close','framework'); ?></button>
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
              		<p><strong><?php echo esc_attr_e('You do not have rights to ad listing.','framework'); ?></strong></p>
					<p><?php echo esc_attr_e('Please register with another role which have sufficient rights to ad listing.','framework'); ?></p>
             	</div>
            </div>
        </div>
   	</div>

<?php } } else { ?>
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