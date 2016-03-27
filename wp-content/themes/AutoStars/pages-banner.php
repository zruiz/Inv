<?php 
global $imic_options,$id;
$image = $banner_type = '';
$animation = get_post_meta($id,'imic_pages_banner_animation',true);
$overlay = get_post_meta($id,'imic_pages_banner_overlay',true);
$overlay_class = ($overlay==1)?'page-header-overlay':'';
$type = get_post_meta($id,'imic_pages_Choose_slider_display',true);
if($type==1 || $type==2 || $type==3) {
$height = get_post_meta($id,'imic_pages_slider_height',true);
} else {
	$height = '';
}
$color = get_post_meta($id,'imic_pages_banner_color',true);
$banner_desc = get_post_meta($id,'imic_pages_banner_description',true);
$color = ($color!='' && $color!='#')?$color:'';
if($type==2) {
$image = get_post_meta($id,'imic_header_image',true);
$image_src = wp_get_attachment_image_src( $image, 'full', '', array() );
if(is_array($image_src)) { $image = $image_src[0]; } else { $image = $imic_options['header_image']['url']; } }
$post_type = get_post_type($id);
$title = '';
$title = get_the_title($id);
if($post_type=='event') {
$date = get_query_var('event_date');
if(empty($date)){
   $date= get_post_meta($id,'imic_event_start_dt',true);
}
$event_time=get_post_meta($id,'imic_event_start_dt',true);
$event_time = strtotime($event_time);
$event_end_time=get_post_meta($id,'imic_event_end_dt',true);
$event_end_time = strtotime($event_end_time);
$date = strtotime($date); }
if(is_page_template('template-contact.php')) {
	$banner_type = get_post_meta($id,'imic_contact_banner_type',true);
	$map_address = get_post_meta($id,'imic_contact_map_address',true);
}
if($banner_type==1) {
	wp_enqueue_script('imic_contact_map');
	wp_localize_script('imic_contact_map','contact',array('address'=>$map_address));
	echo '<div class="page-header parallax">
    	<div id="contact-map" style="width:100%;height:300px"></div>
    </div>';
}else { ?>
<div class="page-header parallax" style="background-image:url(<?php echo esc_url($image); ?>); background-color:<?php echo esc_attr($color) ?>; height:<?php echo esc_attr($height).'px' ?>;">
    	<div class="container">
        	<h1 class="page-title"><?php echo get_the_title(); ?></h1>
       	</div>
    </div>
<?php }