<?php 
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
if(is_plugin_active("imithemes-listing/listing.php")) {
$pageSidebar2 = get_post_meta(get_the_ID(),'imic_select_featured_from_list', true);
$pageSidebar = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list', true);
$sidebar_column = get_post_meta(get_the_ID(),'imic_sidebar_columns_layout',true);
if(!empty($pageSidebar)&&is_active_sidebar($pageSidebar)) {
$left_col = 12-$sidebar_column;
$class = $left_col;  
}else{
$class = 12;  
}
$list_slugs = array();
$blog_masonry = 2;
$post_author_id = get_post_field( 'post_author', get_the_ID() );
$this_user = get_user_meta($post_author_id,'imic_user_info_id',true);
$add = get_post_meta($this_user,'imic_user_zip_code',true);
$highlighted_specs = (isset($imic_options['highlighted_specs']))?$imic_options['highlighted_specs']:'';
$unique_specs = $imic_options['unique_specs'];
$specifications = get_post_meta(get_the_ID(),'feat_data',true);	
$unique_value = imic_vehicle_price(get_the_ID(),$unique_specs,$specifications);
$highlight_value = imic_vehicle_title(get_the_ID(),$highlighted_specs,$specifications);
$video = get_post_meta(get_the_ID(),'imic_plugin_video_url',true);
$featured_specifications = (isset($imic_options['side_specifications']))?$imic_options['side_specifications']:array();
$normal_specifications = (isset($imic_options['normal_specifications']))?$imic_options['normal_specifications']:array();
$normal_specification = array();
$related_specifications = (isset($imic_options['related_specifications']))?$imic_options['related_specifications']:array();
$browse_specification_switch = get_post_meta(get_the_ID(),'imic_browse_by_specification_switch',true);
$browse_listing = imic_get_template_url("template-listing.php");
$download_pdf = get_post_meta(get_the_ID(),'imic_plugin_car_manual',true);
$plan = get_post_meta(get_the_ID(),'imic_plugin_car_plan',true);
$plan_premium = get_post_meta($plan,'imic_pricing_premium_badge',true);
$userFirstName = get_the_author_meta('first_name', $post_author_id);
$userLastName = get_the_author_meta('last_name', $post_author_id);
$user_data = get_userdata(intval($post_author_id));
$userName = $user_data->display_name;
if(!empty($userFirstName) || !empty($userLastName)) {
	$userName = $userFirstName .' '. $userLastName; 
}
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
} else { }
$vehicle_status = get_post_meta(get_the_ID(),'imic_plugin_ad_payment_status',true);
// if($vehicle_status!=1) {
// 	echo '<div class="main" role="main">
//     	<div id="content" class="content full">
//         	<div class="container"><div class="row"><p>'.__('Yacht might be sold or not active','framework').'</p></div></div></div></div>';
// } else {
$save1 = (isset($_SESSION['saved_vehicle_id1']))?$_SESSION['saved_vehicle_id1']:'';
$save2 = (isset($_SESSION['saved_vehicle_id2']))?$_SESSION['saved_vehicle_id2']:'';
$save3 = (isset($_SESSION['saved_vehicle_id3']))?$_SESSION['saved_vehicle_id3']:'';
$user_id = get_current_user_id( );
$current_user_info_id = get_user_meta($user_id,'imic_user_info_id',true);
if($current_user_info_id!='') {
$saved_car_user = get_post_meta($current_user_info_id,'imic_user_saved_cars',true); }
if((empty($saved_car_user))||($current_user_info_id=='')||($saved_car_user=='')) { $saved_car_user = array($save1, $save2, $save3); }
$save_icon = (imic_value_search_multi_array(get_the_ID(),$saved_car_user))?'fa-star':'fa-star-o';
$save_icon_disable = (imic_value_search_multi_array(get_the_ID(),$saved_car_user))?'disabled':'';
$enquiry_form1 = (isset($imic_options['enquiry_form1']))?$imic_options['enquiry_form1']:'0';
$editor_form1 = (isset($imic_options['enquiry_form1_editor']))?$imic_options['enquiry_form1_editor']:'';
$enquiry_form2 = (isset($imic_options['enquiry_form2']))?$imic_options['enquiry_form2']:'0';
$editor_form2 = (isset($imic_options['enquiry_form2_editor']))?$imic_options['enquiry_form2_editor']:'';
$enquiry_form3 = (isset($imic_options['enquiry_form3']))?$imic_options['enquiry_form3']:'0';
$editor_form3 = (isset($imic_options['enquiry_form3_editor']))?$imic_options['enquiry_form3_editor']:'';
$classified_data = get_option('imic_classifieds');
$classified_data = (!empty($classified_data))?$classified_data:array();
$listing_details = (isset($imic_options['listing_details']))?$imic_options['listing_details']:0;
$specification_data_type = (isset($imic_options['specification_fields_type']))?$imic_options['specification_fields_type']:"0"; 

$loggedUserFirstName = $current_user->user_firstname;
$loggedUserLastName = $current_user->user_lastname;
$loggedUserName = get_the_author_meta( 'display_name', $user_id );
if(!empty($loggedUserFirstName) || !empty($loggedUserLastName)) {
	$loggedUserName = $loggedUserFirstName .' '. $loggedUserLastName; 
}
$loggedUserEmail = $current_user->user_email;
?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
        	<div class="container">
            	<!-- Vehicle Details -->
                <article class="single-vehicle-details">
                    <div class="single-vehicle-title">
                    <?php if($plan_premium==1) { ?>
                        <span class="badge-premium-listing"><?php echo esc_attr_e('Premium listing','framework'); ?></span><?php } ?>
                        <h2 class="post-title"><?php echo esc_attr($highlight_value); ?></h2>
                    </div>
                    <div class="single-listing-actions">
                        <div class="btn-group pull-right" role="group">
                            <a <?php echo esc_attr($save_icon_disable); ?> href="#" rel="popup-save" class="btn btn-default save-car" title="<?php echo esc_attr_e('Save this listing','framework'); ?>"><i class="fa <?php echo esc_attr($save_icon); ?>"></i> <span><?php echo esc_attr_e('Save this listing','framework'); ?></span><div class="vehicle-details-access" style="display:none;"><span class="vehicle-id"><?php echo esc_attr(get_the_ID()); ?></span></div></a><?php if($enquiry_form1!=2) { ?>
                            <!-- <a href="#" data-toggle="modal" data-target="#infoModal" class="btn btn-default" title="<?php echo esc_attr_e('Request more info','framework'); ?>"><i class="fa fa-info"></i> <span><?php echo esc_attr_e('Request more info','framework'); ?></span></a> -->
                            <?php } if($enquiry_form2!=2) { ?>
                            <a href="#" data-toggle="modal" data-target="#testdriveModal" class="btn btn-default" title="<?php echo esc_attr_e('Book a test drive','framework'); ?>"><i class="fa fa-calendar"></i> <span><?php echo esc_attr_e('Book a test drive','framework'); ?></span></a><?php } if($enquiry_form3!=2) { ?>
                            <a href="#" data-toggle="modal" data-target="#offerModal" class="btn btn-default" title="<?php echo esc_attr_e('Make an offer','framework'); ?>"><i class="fa fa-dollar"></i> <span><?php echo esc_attr_e('Make an offer','framework'); ?></span></a>
                            <?php } if($download_pdf!='') { ?>
                            <a href="<?php echo IMIC_THEME_PATH; ?>/download/download.php?file=<?php echo esc_url($download_pdf); ?>" class="btn btn-default" title="<?php echo esc_attr_e('Deck Plan','framework'); ?>"><i class="fa fa-book"></i> <span><?php echo esc_attr_e('Deck Plan','framework'); ?></span></a><?php } ?>
                            <a href="javascript:void(0)" onclick="window.print();" class="btn btn-default" title="<?php echo esc_attr_e('Print','framework'); ?>"><i class="fa fa-print"></i> <span><?php echo esc_attr_e('Print','framework'); ?></span></a>
                        </div>
                        <div class="btn btn-info price">$<?php echo esc_attr(number_format((str_replace('$', '', $unique_value)))); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="single-listing-images">
                            
                            	<div class="listing-slider">
                                    <div id="listing-images" class="flexslider format-gallery">
                                    <?php $cars_images = get_post_meta(get_the_ID(),'imic_plugin_vehicle_images',false);
									  if(empty($cars_images)) 
									  { 
										  $attachments = get_attached_media( 'image', get_the_ID() );
										  if(!empty($attachments))
										  {
											  $cars_images = array();
											  foreach($attachments as $attachment)
											  {
												  $cars_images[] = $attachment->ID;
											  }
										  }
									  }?>
                                      <ul class="slides">
                                      	<?php foreach($cars_images as $car_image) { 
											$image = wp_get_attachment_image_src($car_image,'1000x800','');
											$image_full = wp_get_attachment_image_src($car_image,'full','');
										?>
                                        <?php if(isset($imic_options['switch_lightbox']) && $imic_options['switch_lightbox']== 0){
											$Lightbox_init = '<li class="media-box"><a href="' .esc_url($image_full[0]). '" data-rel="prettyPhoto[grouped]">';
										}elseif(isset($imic_options['switch_lightbox']) && $imic_options['switch_lightbox']== 1){
											$Lightbox_init = '<li class="media-box"><a href="' .esc_url($image_full[0]). '" class="magnific-gallery-image">';
										}
										echo $Lightbox_init; ?><img src="<?php echo esc_url($image[0]); ?>" alt=""></a> </li>
								  <?php } ?>
                                      </ul>
                                    </div>
                                    <?php 
									if(count($cars_images)>1) { ?>
                                    <div class="additional-images">
                                    <div id="listing-thumbs" class="flexslider">
                                      <ul class="slides">
                                      <?php $start = 1; foreach($cars_images as $car_image) { 
											$image = wp_get_attachment_image_src($car_image,'400x400','');
											$image_full = wp_get_attachment_image_src($car_image,'full','');
											if($video!=''&&$start==1) {
												if(isset($imic_options['switch_lightbox']) && $imic_options['switch_lightbox']== 0){
											$Lightbox_init = '<li class="format-video"><a href="' .esc_url($video). '" data-rel="prettyPhoto[grouped]" class="media-box">';
										}elseif(isset($imic_options['switch_lightbox']) && $imic_options['switch_lightbox']== 1){
											$Lightbox_init = '<li class="format-video"><a href="' .esc_url($video). '" class="magnific-video media-box">';
										}
										echo $Lightbox_init;
											echo '<img src="'.esc_url($image[0]).'" alt=""></a></li>'; } else { ?>
									<li> <a href="<?php echo esc_url($image_full[0]); ?>" class="media-box"><img src="<?php echo esc_url($image[0]); ?>" alt=""></a> </li>
								  <?php } $start++; } ?>
                                      </ul>
                                    </div></div><?php } ?>
                                  </div>
                            
                            
                            
                            </div>
                      	</div>
                        
                        <div class="col-md-4">
                        <?php if((!empty($featured_specifications))&&($listing_details==0)) { ?>
                            <div class="sidebar-widget widget">
                                <ul class="list-group">
                                <?php 
																$new_featured_specifications = imic_filter_lang_specs($featured_specifications);
																foreach($new_featured_specifications as $featured) 
																{
																	$field_type = get_post_meta($featured,'imic_plugin_spec_char_type',true);
																	$value_label = get_post_meta($featured,'imic_plugin_value_label',true);
																	$label_position = get_post_meta($featured,'imic_plugin_lable_position',true);
																	$badge_slug = imic_the_slug($featured);
																	$this_specification = get_post_meta(get_the_ID(), 'feat_data', true);
																	if($specification_data_type=="0")
																	{
																		$spec_key = array_search($featured, $this_specification['sch_title']);
																		$second_key = array_search($featured*111, $this_specification['sch_title']);
																	}
																	else
																	{
																		$spec_key = $second_key = '';
																	}
																	$feat_val = get_post_meta($id,'int_'.$badge_slug,true);
																	if($field_type==1&&$feat_val!='') 
																	{
																		if($label_position==0) 
																		{
																			echo '<li class="list-group-item"> <span class="badge">'.get_the_title($featured).'</span> '.$value_label.$feat_val.'</li>'; 
																		}
																		else 
																		{
																			echo '<li class="list-group-item"> <span class="badge">'.get_the_title($featured).'</span> '.get_post_meta($id,'int_'.$badge_slug,true).$value_label.'</li>'; 
																		}
																	} 
																	else 
																	{
																		if(is_int($spec_key)) 
																		{
																			$child_val = '';
																			if(is_int($second_key)) 
																			{ 
																				$child_val = ' '.$this_specification['start_time'][$second_key]; 
																			}
																			$spec_feat_val = $this_specification['start_time'][$spec_key];
																			if($spec_feat_val!='')
																			{
																				if($label_position==0) 
																				{
																					echo '<li class="list-group-item"> <span class="badge">'.get_the_title($featured).'</span> '.$value_label.$this_specification['start_time'][$spec_key].$child_val.'</li>'; 
																				}
																				else 
																				{
																					echo '<li class="list-group-item"> <span class="badge">'.get_the_title($featured).'</span> '.$this_specification['start_time'][$spec_key].$child_val.$value_label.'</li>'; 
																				} 
																			} 
																		}
																		else
																		{
																			$spec_slug = imic_the_slug($featured);
																			$spec_val_char = get_post_meta(get_the_ID(), 'char_'.$spec_slug, true);
																			$spec_val_char_child = get_post_meta(get_the_ID(), 'child_'.$spec_slug, true);
																			if($spec_val_char!=''&&$spec_val_char!="Select")
																			{
																				if($label_position==0) 
																				{
																					echo '<li class="list-group-item"> <span class="badge">'.get_the_title($featured).'</span> '.$value_label.$spec_val_char.' '.$spec_val_char_child.'</li>'; 
																				}
																				else 
																				{
																					echo '<li class="list-group-item"> <span class="badge">'.get_the_title($featured).'</span> '.$spec_val_char.' '.$spec_val_char_child.$value_label.'</li>'; 
																				} 
																			}
																		}
																	}
																} ?>
                                </ul>
                            </div><?php } else { 
								$args_terms = array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all');
								$this_terms = wp_get_post_terms(get_the_ID(),'listing-category',$args_terms);
								$get_val_term = '';
								foreach($this_terms as $term)
								{ 
									$list_slugs[] = $term->slug;
									if(array_key_exists($term->term_id, $classified_data))
									{ 
										if($classified_data[$term->term_id]['featured']!='')
										{
											$get_val_term = $term->term_id;
											break;
										}
									}
								}
								if(!empty($get_val_term))
								{ 
								$featured_specifications = $classified_data[$get_val_term]['featured'];
								$featured_specifications = explode(',', $featured_specifications);
								$normal_specification = $classified_data[$get_val_term]['detailed'];
								$normal_specification = explode(',', $normal_specification);
								?>
                            <div class="sidebar-widget widget">
                                <ul class="list-group">
                                <?php foreach($featured_specifications as $featured) {
									$field_type = get_post_meta($featured,'imic_plugin_spec_char_type',true);
										$value_label = get_post_meta($featured,'imic_plugin_value_label',true);
										$label_position = get_post_meta($featured,'imic_plugin_lable_position',true);
										$badge_slug = imic_the_slug($featured);
										$this_specification = get_post_meta(get_the_ID(), 'feat_data', true);
										if($specification_data_type=="0")
										{
											$spec_key = array_search($featured, $this_specification['sch_title']);
											$second_key = array_search($featured*111, $this_specification['sch_title']);
										}
										else
										{
											$spec_key = $second_key = '';
										}
										$feat_val = get_post_meta($id,'int_'.$badge_slug,true);
										if($field_type==1&&$feat_val!='') {
										if($label_position==0) {
										echo '<li class="list-group-item"> <span class="badge">'.get_the_title($featured).'</span> '.$value_label.get_post_meta($id,'int_'.$badge_slug,true).'</li>'; }
										else {
										echo '<li class="list-group-item"> <span class="badge">'.get_the_title($featured).'</span> '.get_post_meta($id,'int_'.$badge_slug,true).$value_label.'</li>'; }
									} else {
										if(is_int($spec_key)) { 
										$child_val = '';
										if(is_int($second_key)) 
										{ 
											$child_val = ' '.$this_specification['start_time'][$second_key]; 
										}
										$spec_feat_val = $this_specification['start_time'][$spec_key];
										if($spec_feat_val!='')
										{
										if($label_position==0) {
										echo '<li class="list-group-item"> <span class="badge">'.get_the_title($featured).'</span> '.$value_label.$this_specification['start_time'][$spec_key].$child_val.'</li>'; }
										else {
										echo '<li class="list-group-item"> <span class="badge">'.get_the_title($featured).'</span> '.$this_specification['start_time'][$spec_key].$child_val.$value_label.'</li>'; } } } } ?>
                                    
                              	<?php } ?>
                                </ul>
                            </div><?php } }
							dynamic_sidebar($pageSidebar2); ?>
                        </div>
                   	</div>
                 	<div class="spacer-50"></div>
                    <div class="row">
                    	<div class="col-md-8">
                            <div class="tabs vehicle-details-tabs">
                                <ul class="nav nav-tabs">
                                <?php $count = 1;
								$tab_data1 = get_post_meta(get_the_ID(),'imic_tab_area1',true);
								$tab_data2 = get_post_meta(get_the_ID(),'imic_tab_area2',true);
								$tab_data3 = get_post_meta(get_the_ID(),'imic_tab_area3',true);
								$tab_data4 = get_post_meta(get_the_ID(),'imic_tab_area4',true);
								$tabs = (isset($imic_options['details_tab']))?$imic_options['details_tab']:array();
								foreach($tabs as $tab) {
									$active_class = ($count==1)?"active":"";
									if(($tab['property_description']=="[tab-area1]")&&($tab_data1!='')) { ?>
                                    <li class="<?php echo esc_attr($active_class); ?>"> <a data-toggle="tab" href="#tab-<?php echo esc_attr($count); ?>"><?php echo esc_attr($tab['title']); ?></a></li>
                                    <?php }
									elseif(($tab['property_description']=="[tab-area2]")&&($tab_data2!='')) { ?>
                                    <li class="<?php echo esc_attr($active_class); ?>"> <a data-toggle="tab" href="#tab-<?php echo esc_attr($count); ?>"><?php echo esc_attr($tab['title']); ?></a></li>
                                    <?php }
									elseif(($tab['property_description']=="[tab-area3]")&&($tab_data3!='')) { ?>
                                    <li class="<?php echo esc_attr($active_class); ?>"> <a data-toggle="tab" href="#tab-<?php echo esc_attr($count); ?>"><?php echo esc_attr($tab['title']); ?></a></li>
                                    <?php }
									elseif(($tab['property_description']=="[tab-area4]")&&($tab_data4!='')) { ?>
                                    <li class="<?php echo esc_attr($active_class); ?>"> <a data-toggle="tab" href="#tab-<?php echo esc_attr($count); ?>"><?php echo esc_attr($tab['title']); ?></a></li>
                                    <?php } elseif(($tab['property_description']!="[tab-area1]")&&($tab['property_description']!="[tab-area2]")&&($tab['property_description']!="[tab-area3]")&&($tab['property_description']!="[tab-area4]")) { ?>
                                    <li class="<?php echo esc_attr($active_class); ?>"> <a data-toggle="tab" href="#tab-<?php echo esc_attr($count); ?>"><?php echo esc_attr($tab['title']); ?></a></li>
                                <?php } $count++; } ?>
                                </ul>
                                <div class="tab-content">
                                <?php $start = 1;
								foreach($tabs as $tab) {
									$active = ($start==1)?"active in":""; ?>
                                <div id="tab-<?php echo esc_attr($start); ?>" class="tab-pane fade <?php echo esc_attr($active); ?>" style="display:<?php echo ($tab['property_description']=="[location]")?"block":"" ?>">
                                <?php //$tab_content = $tab['imic_plugin_tab_content']; ?>
                                <?php if ( $tab['property_description']=='[content]' ) {
									if(have_posts()):while(have_posts()):the_post(); 
										the_content();
									endwhile; endif;
										}
										elseif( $tab['property_description']=="[specifications]") {
											if(!empty($normal_specifications)&&($listing_details==0)) {
											echo '<table class="table-specifications table table-striped table-hover">
                                                            <tbody>';
											$new_normal_specifications = imic_filter_lang_specs($normal_specifications);
											foreach($new_normal_specifications as $normal) {
									$field_type = get_post_meta($normal,'imic_plugin_spec_char_type',true);
									$value_labels = get_post_meta($normal,'imic_plugin_value_label',true);
										$label_positions = get_post_meta($normal,'imic_plugin_lable_position',true);
										$badge_slug = imic_the_slug($normal);
										$this_specification = get_post_meta(get_the_ID(), 'feat_data', true);
									if($field_type==1) {
										if($label_positions==0) {
											echo '<tr>
                                                            		<td>'.get_the_title($normal).'</td>
                                                            		<td>'.$value_labels.get_post_meta($id,'int_'.$badge_slug,true).'</td>
                                                            	</tr>'; }
										else {
											echo '<tr>
                                                            		<td>'.get_the_title($normal).'</td>
                                                            		<td>'.get_post_meta($id,'int_'.$badge_slug,true).$value_labels.'</td>
                                                            	</tr>'; }
									} else {
										if($specification_data_type=="0")
										{
											$spec_key = array_search($normal, $this_specification['sch_title']);
											$second_key = array_search($featured*111, $this_specification['sch_title']);
										}
										else
										{
											$spec_key = $second_key = '';
										}
										if(is_int($spec_key)) 
										{
											$child_val = '';
											if(is_int($second_key)) 
											{ 
												$child_val = ' '.$this_specification['start_time'][$second_key]; 
											}
											$value_this = $this_specification['start_time'][$spec_key];
											if($value_this!="select") 
											{
												if($label_positions==0) 
												{
													echo '<tr>
                        		<td>'.get_the_title($normal).'</td>
                         		<td>'.$value_labels.$value_this.$child_val.'</td>
                       		</tr>'; 
												}
												else 
												{
													echo '<tr>
                        	<td>'.get_the_title($normal).'</td>
                  				<td>'.$value_this.$child_val.$value_labels.'</td>
                       		</tr>'; 
												} 
											} 
										}
										else
										{
											$feat_slug_char = imic_the_slug($normal);
											$spec_key_val = get_post_meta(get_the_ID(), 'char_'.$feat_slug_char, true);
											$spec_key_val_child = get_post_meta(get_the_ID(), 'child_'.$feat_slug_char, true);
											if($spec_key_val!="select") 
											{
												if($label_positions==0) 
												{
													echo '<tr>
                        		<td>'.get_the_title($normal).'</td>
                         		<td>'.$value_labels.$spec_key_val.'</td>
                       		</tr>'; 
													if($spec_key_val_child!='')
													{
														$child_label = get_post_meta($normal, 'imic_plugin_sub_field_label', true);
														echo '<tr>
                        		<td>'.$child_label.'</td>
                         		<td>'.$spec_key_val_child.'</td>
                       		</tr>'; 
													}
												}
												else 
												{
													echo '<tr>
                        	<td>'.get_the_title($normal).'</td>
                  				<td>'.$spec_key_val.$value_labels.'</td>
                       		</tr>'; 
													if($spec_key_val_child!='')
													{
														$child_label = get_post_meta($normal, 'imic_plugin_sub_field_label', true);
														echo '<tr>
                        		<td>'.$child_label.'</td>
                         		<td>'.$spec_key_val_child.'</td>
                       		</tr>'; 
													}
												} 
											} 
										}
										} ?>
                                    
                              	<?php }
										echo '</tbody></table>'; } 
										else
										{
											echo '<table class="table-specifications table table-striped table-hover">
                                                            <tbody>';
											if(!empty($normal_specification))
											{
											foreach($normal_specification as $normal) {
									$field_type = get_post_meta($normal,'imic_plugin_spec_char_type',true);
									$value_labels = get_post_meta($normal,'imic_plugin_value_label',true);
										$label_positions = get_post_meta($normal,'imic_plugin_lable_position',true);
										$badge_slug = imic_the_slug($normal);
										$this_specification = get_post_meta(get_the_ID(), 'feat_data', true);
									if($field_type==1) {
										
										if($label_positions==0) {
											echo '<tr>
                                                            		<td>'.get_the_title($normal).'</td>
                                                            		<td>'.$value_labels.get_post_meta($id,'int_'.$badge_slug,true).'</td>
                                                            	</tr>'; }
										else {
											echo '<tr>
                                                            		<td>'.get_the_title($normal).'</td>
                                                            		<td>'.get_post_meta($id,'int_'.$badge_slug,true).$value_labels.'</td>
                                                            	</tr>'; }
									} else {
										
										if($specification_data_type=="0")
										{
											$spec_key = array_search($normal, $this_specification['sch_title']);
										}
										else
										{
											$spec_key = '';
										}
										if(is_int($spec_key)) {
										$value_this = $this_specification['start_time'][$spec_key];
										if($value_this!="select") {
										if($label_positions==0) {
											echo '<tr>
                                                            		<td>'.get_the_title($normal).'</td>
                                                            		<td>'.$value_labels.$value_this.'</td>
                                                            	</tr>'; }
										else {
											echo '<tr>
                                                            		<td>'.get_the_title($normal).'</td>
                                                            		<td>'.$value_this.$value_labels.'</td>
                                                            	</tr>'; } } } } ?>
                                    
                              	<?php } }
										echo '</tbody></table>';
										} }
										elseif( $tab['property_description']=="[features]") {
											echo '<ul class="add-features-list">';
											$features = get_the_terms(get_the_ID(),'yachts-tag');
											if(!empty($features))
											{
												$new_features = imic_filter_lang_specs($features);
												foreach($new_features as $feature) {
                                        	echo '<li>'.$feature->name.'</li>';
											}
											}
                                        	echo '</ul>';
										}
										elseif( $tab['property_description']=="[location]") {
											
											echo do_shortcode('[gmap address='.$add.']');
										}
										elseif(($tab['property_description']=="[tab-area1]")&&($tab_data1!='')) {
											echo do_shortcode($tab_data1);
										}
										elseif(($tab['property_description']=="[tab-area2]")&&($tab_data2!='')) {
											echo do_shortcode($tab_data2);
										}
										elseif(($tab['property_description']=="[tab-area3]")&&($tab_data3!='')) {
											echo do_shortcode($tab_data3);
										}
										elseif(($tab['property_description']=="[tab-area4]")&&($tab_data4!='')) {
											echo do_shortcode($tab_data4);
										}
										else {
											
											echo do_shortcode($tab['property_description']);
										}
										 ?>
                                </div>
                                <?php $start++; } ?>
                    		</div></div>
                            <div class="spacer-50"></div>
                            <!-- Recently Listed Vehicles -->
                            
                            
                                <?php $related_args = array();
									if(!empty($related_specifications)) {
										$this_specification = get_post_meta(get_the_ID(), 'feat_data', true);
										$related_args = imic_vehicle_all_specs(get_the_ID(),$related_specifications,$this_specification);
									} ?>
                                
                                <?php $current_car = get_the_ID(); 
								$arrays = array(); 
								$taxonomy_array = array();
								$value = $pagin = $offset = $off = ''; 
								$count = 1; 
								if(!empty($related_args)) 
								{ 
									foreach($related_args as $key=>$value)
									{
										if (strpos($key,'int') !== false) 
										{
											$arrays[$count] = array(
													'key' => $key,
													'value' =>  $value,
													'compare' => '<=',
													'type' => 'numeric'
													);
										} 
										else 
										{
											$arrays[$count] = array(
													'key' => 'feat_data',
													'value' =>  $value,
													'compare' => 'LIKE'
													);
													$count++; 
										} 
								   } 
   
   								}
								else
								{
									$taxonomy_array[0] = array(
									'taxonomy' => 'listing-category',
									'field' => 'slug',
									'terms' => $list_slugs,
									'operator' => 'IN');
								} 
   $arrays[$count+1] = array('key'=>'imic_plugin_ad_payment_status','value'=>'1','compare'=>'=');
	$logged_user_pin = '';			
	$user_id = get_current_user_id( );
										$logged_user = get_user_meta($user_id,'imic_user_info_id',true);
										$logged_user_pin = get_post_meta($logged_user,'imic_user_zip_code',true);
										$badges_type = (isset($imic_options['badges_type']))?$imic_options['badges_type']:'0';
										$specification_type = (isset($imic_options['short_specifications']))?$imic_options['short_specifications']:'0';
										if($badges_type=="0")
										{
										$badge_ids = (isset($imic_options['badge_specs']))?$imic_options['badge_specs']:array();
										}
										else
										{
											$badge_ids = array();
										}
										$img_src = '';
										if($specification_type==0)
										{
											$detailed_specs = (isset($imic_options['vehicle_specs']))?$imic_options['vehicle_specs']:array();
										
										}
										else
										{
											$detailed_specs = array();
										}
										$category_rail = (isset($imic_options['category_rail']))?$imic_options['category_rail']:'0';
										$additional_specs = (isset($imic_options['additional_specs']))?$imic_options['additional_specs']:'';
										$additional_specs_all = get_post_meta($additional_specs,'specifications_value',true);
										$highlighted_specs = (isset($imic_options['highlighted_specs']))?$imic_options['highlighted_specs']:array();
										$unique_specs = $imic_options['unique_specs'];	
										$args_cars = array('post_type'=>'yachts','tax_query'=>$taxonomy_array,'posts_per_page'=>10,'post_status'=>'publish', 'post__not_in'=>array($current_car));
									$cars_listing = new WP_Query( $args_cars );
									if ( $cars_listing->have_posts() ) :
									if(isset($imic_options['enable_rtl']) && $imic_options['enable_rtl']== 1){ $DIR = 'data-rtl="rtl"';} else { $DIR = 'data-rtl="ltr"'; }
									echo '<section class="listing-block recent-vehicles">
                                <div class="listing-header">
                                    <h3>'.__('Related Listings','framework').'</h3>
                                </div>
                                <div class="listing-container">
                                    <div class="carousel-wrapper">
                                        <div class="row">
                                            <ul class="owl-carousel carousel-fw" id="vehicle-slider" data-columns="3" data-autoplay="" data-pagination="yes" data-arrows="no" data-single-item="no" data-items-desktop="3" data-items-desktop-small="3" data-items-tablet="2" data-items-mobile="1" '.$DIR.'>';
									while ( $cars_listing->have_posts() ) :	
									$cars_listing->the_post();
										$additional_spec_slug = imic_the_slug($additional_specs);
										if(is_plugin_active("imi-classifieds/imi-classified.php")) 
										{
											$badge_ids = imic_classified_badge_specs(get_the_ID(), $badge_ids);
											$detailed_specs = imic_classified_short_specs(get_the_ID(), $detailed_specs);
										}
										$car_author = get_post_field( 'post_author', get_the_ID() );
										$user_info_id = get_user_meta($car_author,'imic_user_info_id',true);
										$author_role = get_option('blogname');
										if(!empty($user_info_id)) {
										$term_list = wp_get_post_terms($user_info_id, 'user-role', array("fields" => "names"));
										if(!empty($term_list)) {
										$author_role = $term_list[0]; }
										else { $author_role = get_option('blogname'); }
										}
										$specifications = get_post_meta(get_the_ID(),'feat_data',true);
										$unique_value = imic_vehicle_price(get_the_ID(),$unique_specs,$specifications);
										$highlight_value = imic_vehicle_title(get_the_ID(),$highlighted_specs,$specifications);
										$details_value = imic_vehicle_all_specs(get_the_ID(),$detailed_specs,$specifications);
										if(!empty($additional_specs)) {
										if($imic_options['specification_fields_type']=="0")
											{
												$image_key = array_search($additional_specs, $specifications['sch_title']);
												$additional_specs_value = $specifications['start_time'][$image_key];
											}
											else
											{
												 $img_char = imic_the_slug($additional_specs);
												 $additional_specs_value = get_post_meta(get_the_ID(), 'char_'.$img_char, true);
											}
										$this_key = find_car_with_position($additional_specs_all,$additional_specs_value);
										$img_src = $additional_specs_all[$this_key]['imic_plugin_spec_image']; }
										$badges = imic_vehicle_all_specs(get_the_ID(),$badge_ids,$specifications);
										?>
                                    <li class="item">
                                        <div class="vehicle-block format-standard">
                                        <?php if(has_post_thumbnail()) { ?>
                                            <a href="<?php echo esc_url(get_permalink()); ?>" class="media-box"><?php the_post_thumbnail('210x210'); ?></a><?php } ?>
                                            <div class="vehicle-block-content">
                                            <?php 
             //                                        $start = 1; 
													// $badge_position = array('vehicle-age','premium-listing','third-listing','fourth-listing');
													// foreach($badges as $badge):
													// 	$badge_class = ($start==1)?'default':'success';
													// 	echo '<span class="label label-'.esc_attr($badge_class).' '.esc_attr($badge_position[$start-1]).'">'.esc_attr($badge).'</span>';
													// $start++;
													// endforeach; 
												?>
                                                <h5 class="vehicle-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_attr($highlight_value); ?></a></h5>
                                                <span class="vehicle-meta"><?php foreach($details_value as $value) { echo esc_attr_e('by ','framework'); echo esc_attr($value); } ?>  </span>
                                                <?php if($img_src!='') { ?>
                                                <a href="<?php echo esc_url(add_query_arg($additional_spec_slug, $additional_specs_all[$this_key]['imic_plugin_specification_values'],$browse_listing)); ?>" title="<?php echo esc_attr_e('View all ','framework'); echo esc_attr($additional_specs_all[$this_key]['imic_plugin_specification_values']); ?>" class="vehicle-body-type"><img src="<?php echo esc_attr($additional_specs_all[$this_key]['imic_plugin_spec_image']); ?>" alt=""></a><?php } ?>
                                                <span class="vehicle-cost">$<?php echo esc_attr(number_format((str_replace('$', '', $unique_value)))); ?></span>
                                                <?php 
												if($category_rail=="1"&&is_plugin_active("imi-classifieds/imi-classified.php"))
												{
													echo imic_get_cats_list(get_the_ID(), "list");
												}
												?>
                                            </div>
                                        </div>
                                    </li>
                                    <?php endwhile; ?>
                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        
                            </section>
                                    <?php endif; wp_reset_postdata(); ?>
                                                    
                       	</div>
                        <!-- Vehicle Details Sidebar -->
                        <div class="col-md-4 vehicle-details-sidebar sidebar">
                        	<div class="vehicle-enquiry-foot">
                                    <span class="vehicle-enquiry-foot-ico"><i class="fa fa-phone"></i></span>
                                    <strong><?php echo get_post_meta(get_the_ID(),'imic_plugin_contact_phone',true); ?></strong><?php echo esc_attr_e('Broker Name:','framework'); ?> <a href="<?php echo esc_url(get_author_posts_url($post_author_id)); ?>"><?php echo esc_attr($userName); ?></a>
									 <div style="padding:10px 0;">
			                        	<input type="button" data-toggle="modal" data-target="#infoModal" class="btn btn-primary" value="Request more info">
			                        </div>
                                    <!-- <a href="#" data-toggle="modal" data-target="#infoModal" class="btn btn-default" title="<?php echo esc_attr_e('Request more info','framework'); ?>"><i class="fa fa-info"></i> <span><?php echo esc_attr_e('Request more info','framework'); ?></span></a> -->
                                </div>
                            <?php dynamic_sidebar($pageSidebar); ?>
                        </div>
                    </div>
                </article>
                <div class="clearfix"></div>
            </div>
        </div>
   	</div>
    <!-- End Body Content -->
<!-- REQUEST MORE INFO POPUP -->
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4><?php echo esc_attr_e('Request more info','framework'); ?></h4>
            </div>
            <div class="modal-body">
            <?php if($enquiry_form1==0) { ?>
            	<p><?php echo esc_attr_e('Please fill out the form below and someone will contact you in the next 24 hours.','framework'); ?></p>
                <form class="enquiry-vehicle">
                <input type="hidden" name="email_content" value="enquiry_form">
				<input type="hidden" name="Subject" id="subject" value="Request More Info">
                <input type="hidden" name="Vehicle_ID" value="<?php echo esc_attr(get_the_ID()); ?>">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
						<?php if(is_user_logged_in()) { ?>
                        	<input type="text" name="Name" class="form-control" placeholder="<?php echo esc_attr_e('Full Name','framework'); ?>" value="<?php echo esc_attr($loggedUserName); ?>">
                         <?php } else { ?>
                         	<input type="text" name="Name" class="form-control" placeholder="<?php echo esc_attr_e('Full Name','framework'); ?>">
                    	<?php } ?>
                    </div>
                    <div class="row">
                    	<div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
								<?php if(is_user_logged_in()) { ?>
		                        	<input type="text" name="Email" class="form-control" placeholder="<?php echo esc_attr_e('Email','framework'); ?>" value="<?php echo esc_attr($loggedUserEmail); ?>">
		                         <?php } else { ?>
                                 <input type="email" name="Email" class="form-control" placeholder="<?php echo esc_attr_e('Email','framework'); ?>">
                            	 <?php } ?>
                            </div>
                      	</div>
                    	<div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
								<?php if(is_user_logged_in()) { ?>
		                        	<input type="text" name="Phone" class="form-control" placeholder="<?php echo esc_attr_e('Phone','framework'); ?>" value="<?php echo get_post_meta($logged_user,'imic_user_telephone',true); ?>">
		                         <?php } else { ?>
                                <input type="text" name="Phone" class="form-control" placeholder="<?php echo esc_attr_e('Phone','framework'); ?>">
                            	<?php } ?>
                            </div>
                      	</div>
                   	</div>
             		<input type="submit" class="btn btn-primary pull-right" value="<?php echo esc_attr_e('Request Info','framework'); ?>">
                    <label class="btn-block"><?php echo esc_attr_e('Preferred Contact','framework'); ?></label>
                    <label class="checkbox-inline"><input name="Preferred Contact Email" value="yes" type="checkbox"> <?php echo esc_attr_e('Email','framework'); ?></label>
                    <label class="checkbox-inline"><input name="Preferred Contact Phone" value="yes" type="checkbox"> <?php echo esc_attr_e('Phone','framework'); ?></label>
                    <div class="message"></div>
                </form><?php } elseif($enquiry_form1==1) { echo do_shortcode($editor_form1); } ?>
           	</div>
        </div>
    </div>
</div>
<!-- BOOK TEST DRIVE POPUP -->
<div class="modal fade" id="testdriveModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4><?php echo esc_attr_e('Book a test drive','framework'); ?></h4>
            </div>
            <div class="modal-body">
            <?php if($enquiry_form2==0) { ?>
            	<p><?php echo esc_attr_e('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla convallis egestas rhoncus. Donec facilisis fermentum sem, ac viverra ante luctus vel. Donec vel mauris quam.','framework'); ?></p>
                <form class="enquiry-vehicle">
                <input type="hidden" name="email_content" value="enquiry_form">
				<input type="hidden" name="Subject" id="subject" value="Book a test drive">
                <input type="hidden" name="Vehicle_ID" value="<?php echo esc_attr(get_the_ID()); ?>">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" name="Name" class="form-control" placeholder="<?php echo esc_attr_e('Full Name','framework'); ?>">
                    </div>
                    <div class="row">
                    	<div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="email" name="Email" class="form-control" placeholder="<?php echo esc_attr_e('Email','framework'); ?>">
                            </div>
                      	</div>
                    	<div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input type="text" name="Phone" class="form-control" placeholder="<?php echo esc_attr_e('Phone','framework'); ?>">
                            </div>
                      	</div>
                   	</div>
                    <div class="row">
                    	<div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" name="Preferred Date" id="datepicker" class="form-control" placeholder="<?php echo esc_attr_e('Preferred Date','framework'); ?>">
                            </div>
                      	</div>
                    	<div class="col-md-6">
                            <div class="input-group input-append bootstrap-timepicker">
                                <span class="input-group-addon add-on"><i class="fa fa-clock-o"></i></span>
                                <input type="text" name="Preferred Time" id="timepicker" class="form-control" placeholder="<?php echo esc_attr_e('Preferred time','framework'); ?>">
                            </div>
                      	</div>
                   	</div>
             		<input type="submit" class="btn btn-primary pull-right" value="<?php echo esc_attr_e('Schedule Now','framework'); ?>">
                    <label class="btn-block"><?php echo esc_attr_e('Preferred Contact','framework'); ?></label>
                    <label class="checkbox-inline"><input name="Preferred Contact Email" value="yes" type="checkbox"> <?php echo esc_attr_e('Email','framework'); ?></label>
                    <label class="checkbox-inline"><input name="Preferred Contact Phone" value="yes" type="checkbox"> <?php echo esc_attr_e('Phone','framework'); ?></label>
                    <div class="message"></div>
                </form><?php } elseif($enquiry_form2==1) { echo do_shortcode($editor_form2); } ?>
           	</div>
        </div>
    </div>
</div>
<!-- MAKE AN OFFER POPUP -->
<div class="modal fade" id="offerModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4><?php echo esc_attr_e('Make an offer','framework'); ?></h4>
            </div>
            <div class="modal-body">
            <?php if($enquiry_form3==0) { ?>
            	<p><?php echo esc_attr_e('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla convallis egestas rhoncus. Donec facilisis fermentum sem, ac viverra ante luctus vel. Donec vel mauris quam.','framework'); ?></p>
                <form class="enquiry-vehicle">
                <input type="hidden" name="email_content" value="enquiry_form">
				<input type="hidden" name="Subject" id="subject" value="<?php echo esc_attr_e('Make an offer','framework'); ?>">
                <input type="hidden" name="Vehicle_ID" value="<?php echo esc_attr(get_the_ID()); ?>">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" name="Name" class="form-control" placeholder="<?php echo esc_attr_e('Full Name','framework'); ?>">
                    </div>
                    <div class="row">
                    	<div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="email" name="Email" class="form-control" placeholder="<?php echo esc_attr_e('Email','framework'); ?>">
                            </div>
                      	</div>
                    	<div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input type="text" name="Phone" class="form-control" placeholder="<?php echo esc_attr_e('Phone','framework'); ?>">
                            </div>
                      	</div>
                   	</div>
                    <div class="row">
                    	<div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                <input type="text" name="Offered Price" class="form-control" placeholder="<?php echo esc_attr_e('Offered Price','framework'); ?>">
                            </div>
                      	</div>
                    	<div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                <select name="Financing Required" type="text" class="form-control selectpicker">
                                	<option value="no" selected><?php echo esc_attr_e('Financing required?','framework'); ?></option>
                                	<option value="yes"><?php echo esc_attr_e('Yes','framework'); ?></option>
                                	<option value="no"><?php echo esc_attr_e('No','framework'); ?></option>
                                </select>
                            </div>
                      	</div>
                   	</div>
                    <textarea class="form-control" name="Additional Comments" placeholder="<?php echo esc_attr_e('Additional comments','framework'); ?>"></textarea>
             		<input type="submit" class="btn btn-primary pull-right" value="<?php echo esc_attr_e('Submit','framework'); ?>">
                    <div class="clearfix"></div>
                    <div class="message"></div>
                </form><?php } elseif($enquiry_form3==1) { echo do_shortcode($editor_form3); } ?>
           	</div>
        </div>
    </div>
</div>
<?php //Session for recently viewed cars
if(!isset($_SESSION['viewed_vehicle_id1'])) {
		$_SESSION['viewed_vehicle_id1'] = get_the_ID();
	} 
	elseif(!isset($_SESSION['viewed_vehicle_id2'])) {
		if($_SESSION['viewed_vehicle_id1']!=get_the_ID()) {
		$_SESSION['viewed_vehicle_id2'] = get_the_ID(); }
	}
	elseif(!isset($_SESSION['viewed_vehicle_id3'])) {
		if($_SESSION['viewed_vehicle_id1']!=get_the_ID()&&$_SESSION['viewed_vehicle_id2']!=get_the_ID()) {
		$_SESSION['viewed_vehicle_id3'] = get_the_ID(); }
	}
	else {
		unset($_SESSION['viewed_vehicle_id1']);
		if($_SESSION['viewed_vehicle_id2']!=get_the_ID()&&$_SESSION['viewed_vehicle_id3']!=get_the_ID()) {
		$_SESSION['viewed_vehicle_id1'] = get_the_ID();	}
}
//} //End of status view ?>
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
<?php } 
if(is_plugin_active("imi-classifieds/imi-classified.php"))
{
	imic_viewed_listing(get_the_ID());
}
get_footer(); ?>