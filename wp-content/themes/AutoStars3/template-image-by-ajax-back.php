<?php
//Add Listing Page Section 4 Code
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
$post_id = $_REQUEST['edit-vehicle'];
$video = (isset($_REQUEST['vehicle-video']))?esc_url($_REQUEST['vehicle-video']):'';
$desc = (isset($_REQUEST['vehicle-detail']))?esc_attr($_REQUEST['vehicle-detail']):'';
$files = isset($_FILES['images'])?$_FILES['images']:$_REQUEST['listing_photos'];
echo esc_attr($post_id);
$attached_images = get_post_meta($post_id, 'imic_plugin_vehicle_images', false);
if($video!=''||$desc!='' || count($files)!=0) {
$content = array(
'ID' => $post_id,
'post_content' => $desc );
wp_update_post($content);
if(get_post_meta($post_id,'imic_plugin_ad_payment_status',true)=='') {
update_post_meta($post_id,'imic_plugin_ad_payment_status',0); }
update_post_meta($post_id,'imic_plugin_video_url',$video);
$pid = $post_id;
$steps = "listing-add-form-four";
$step = '';
	if($steps=="listing-add-form-one") {
		$step = 1;
	}elseif($steps=="listing-add-form-two"){
		$step = 2;
	}elseif($steps=="listing-add-form-three"){
		$step = 3;
	}elseif($steps=="listing-add-form-four"){
		$step = 4;
	}elseif($steps=="listing-add-form-five"){
		$step = 5;
	}
$already_step = get_post_meta($pid,'imic_plugin_ads_steps',true);
	if($already_step<$step) { //update_post_meta($pid,'imic_plugin_ads_steps',$step); 
	}
$i = 1;
////////// check input method and browser //////////////
$files  = array();

  if(Browser::isHTML5() && FRONT_MEDIA_ALLOW::check_file_input_method() == 0)
  {
    $files = isset($_FILES['images'])?$_FILES['images']:'';
  }
  else
  {
	  $list_photo = $_REQUEST['listing_photos'];
	  foreach($list_photo as $photo)
	  {
		  
			  if(!in_array($photo, $attached_images))
			  {
				  if ($i == 1) {
         	update_post_meta($pid, '_thumbnail_id', $photo);
       	   }
       	    add_post_meta($pid, 'imic_plugin_vehicle_images', $photo, false);
		  }
			$i++;
	  }  
  }
/////////////////////////
	if(!empty($files))
	{
	   foreach ($files['name'] as $key => $value) 
	   {
		if ($files['name'][$key]) {
			$file = array(
			'name' => $files['name'][$key],
			'type' => $files['type'][$key],
			'tmp_name' => $files['tmp_name'][$key],
			'error' => $files['error'][$key],
			'size' => $files['size'][$key]
			);
			$_FILES = array("sight" . $i => $file);
			$newuploadMulti = imic_sight("sight" . $i, $pid);
			if(!in_array($newuploadMulti, $attached_images))
			{
				if ($i == 1) {
					update_post_meta($pid, '_thumbnail_id', $newuploadMulti);
				}
				add_post_meta($pid, 'imic_plugin_vehicle_images', $newuploadMulti, false);
			}
		}
		$i++;
	 } 
   }
}
?>