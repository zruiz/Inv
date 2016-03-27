<?php
add_action('admin_menu', 'imic_classifieds_menu');
function import_custom_scripts ()
{ 
	$theme_info = wp_get_theme();
	wp_enqueue_script('jquery-ui-sortable');
	//wp_enqueue_script('jquery-ui-draggable');
	wp_enqueue_script( 'imic_add_fields', plugins_url( '/js/add-dynamic-fields.js' , __FILE__ ), array(), $theme_info->get( 'Version' ), true); 
	wp_enqueue_style( 'imic_admin_css', plugins_url( '/css/settings-admin.css' , __FILE__ )); 
}
function imic_classifieds_menu() {
	$import_submenu = add_submenu_page( 'themes.php', 'Classifieds Settings', 'Classifieds Settings', 'manage_options', 'classifieds-settings', 'imic_classifieds_add_specs' );
   	add_action( 'admin_enqueue_scripts','import_custom_scripts' );
}

function imic_classifieds_add_specs() { ?>
<?php
$ss = get_option('imic_classifieds');
if(isset($_POST['save_values'])){
if(isset($_POST['reset_classified']))
{
	//update_option('imic_classifieds','');
}
else
{
	
	if(isset($_POST['speci_category']))
{
	$classifieds = array();
	for ($i = 0; $i < count( $_POST['speci_category']); $i++ ) 
	{
		if ( '' != $_POST['speci_category'][ $i ] ) 
      	{
			$classifieds[$_POST['speci_category'][$i]]  = array('badge'=>$_POST['saved_badges'][ $i ],'lists'=>$_POST['saved_lists'][$i],'filter'=>$_POST['saved_filters'][$i],'ad'=>$_POST['saved_ad'][$i],'featured'=>$_POST['saved_featured'][$i],'detailed'=>$_POST['saved_detailed'][$i]);
       	}
	}
	update_option('imic_classifieds',$classifieds);
	$ss = get_option('imic_classifieds');
} 
}
}
?>
<form action="" method="post" name="save_classified_settings">
            <div id="field_wrap">
            <h1><?php _e('Classified Settings','framework'); ?></h1>
            <p><?php _e('Add Section for specifications uses on website.','framework'); ?></p>
            <?php if(!empty($ss))
			{
			foreach($ss as $key=>$value) { 
			$badges = $value['badge'];
			$badges = explode(",",$badges);
			$lists = $value['lists'];
			$lists = explode(",",$lists);
			$filter = $value['filter'];
			$filter = explode(",",$filter);
			$ad = $value['ad'];
			$ad = explode(",",$ad);
			$featured = $value['featured'];
			$featured = explode(",",$featured);
			$detailed = $value['detailed'];
			$detailed = explode(",",$detailed); ?>
            <div class="main-section postbox">
            <label><h3><?php _e('Section','framework'); ?></h3></label>
            <div class="list-cats">
            
            <label><?php _e('Select category','framework'); ?></label>
            <select name="speci_category[]">
            <option value="" disabled><?php _e('Select','framework'); ?></option>
            
            <?php 
			$list_cat = get_terms('listing-category');
			foreach($list_cat as $cat) 
			{
				$ids = array(); ?>
            <option <?php echo ($key==$cat->term_id)?'selected':''; ?> value="<?php echo $cat->term_id; ?>"><?php echo $cat->name; ?></option>
            <?php } ?>
            </select>
            
            </div>
            
            <br>
            <?php
			$specification = get_posts(array('post_type'=>'specification','posts_per_page'=>-1,'post_status'=>'publish','orderby'=>'title','order'=>'ASC'));
			foreach($specification as $post) 
			{
				$ids[]=$post->ID; 
			} 
			wp_reset_postdata(); ?>
            <div class="spec-filter">
            
            <label><?php _e('Select Filters','framework'); ?></label>
            <select name="speci_filters" class="add-speci">
            <option value="" disabled selected><?php _e('Select','framework'); ?></option>
            
            <?php 
			foreach($ids as $id) 
			{
				$style_filter = (in_array($id,$filter))?"style='display:none;'":""; ?>
            <option <?php echo $style_filter; ?> value="<?php echo $id; ?>"><?php echo get_the_title($id); ?></option>
            <?php } ?>
            </select>
            <br><br>
            <label><?php _e('Filters Specifications','framework'); ?></label>
            <ul class="selected-specs connectedSortable inline">
            <?php foreach($filter as $filters)
			{
				if($filters!='')
				{
					echo '<li class="sort" id="'.$filters.'">'.get_the_title($filters).' <span class="del-spec">X</span></li>';
				}
			} ?>
            </ul>
            <input type="hidden" name="saved_filters[]" value="<?php echo $value['filter']; ?>" class="save_ids regular-text">
            
            </div>
            <br>
            <div class="spec-ad">
            
            <label><?php _e('Select Ad Listing Specifications','framework'); ?></label>
            <select name="speci_ad" class="add-speci">
            <option value="" disabled selected><?php _e('Select','framework'); ?></option>
            
            <?php 
			foreach($ids as $id) 
			{
				$style_ads = (in_array($id,$ad))?"style='display:none;'":""; ?>
            <option <?php echo $style_ads; ?> value="<?php echo $id; ?>"><?php echo get_the_title($id); ?></option>
            <?php } ?>
            </select>
            <br><br>
            <label><?php _e('Ad Listing Specifications','framework'); ?></label>
            <ul class="selected-specs connectedSortable inline">
            <?php foreach($ad as $ads)
			{
				if($ads!='')
				{
					echo '<li class="sort" id="'.$ads.'">'.get_the_title($ads).' <span class="del-spec">X</span></li>';
				}
			} ?>
            </ul>
            <input type="hidden" name="saved_ad[]" value="<?php echo $value['ad']; ?>" class="save_ids regular-text">
            
            </div>
            <br>
            <div class="spec-badge">
            <label><?php _e('Select Badges','framework'); ?></label>
            <select name="speci_badges" class="add-speci">
            <option value="" disabled selected><?php _e('Select','framework'); ?></option>
            
            <?php 
			foreach($ids as $id) 
			{
				$style_badges = (in_array($id,$badges))?"style='display:none;'":""; ?>
            <option <?php echo $style_badges; ?> value="<?php echo $id; ?>"><?php echo get_the_title($id); ?></option>
            <?php } ?>
            </select>
            <br><br>
            <label><?php _e('Badges Specifications','framework'); ?></label>
            <ul class="selected-specs connectedSortable inline">
            <?php foreach($badges as $badge)
			{
				if($badge!='')
				{
					echo '<li class="sort" id="'.$badge.'">'.get_the_title($badge).' <span class="del-spec">X</span></li>';
				}
			} ?>
            </ul>
            <input type="hidden" name="saved_badges[]" value="<?php echo $value['badge']; ?>" class="save_ids regular-text">
            
            </div>
            <br>
            <div class="spec-short">
            <label><?php _e('Select Short Specifications','framework'); ?></label>
            <select name="speci_lists" class="add-speci">
            <option value="" disabled selected><?php _e('Select','framework'); ?></option>
            
            <?php 
			foreach($ids as $id) 
			{
				$style_lists = (in_array($id,$lists))?"style='display:none;'":""; ?>
            <option <?php echo $style_lists; ?> value="<?php echo $id; ?>"><?php echo get_the_title($id); ?></option>
            <?php } ?>
            </select>
            <br><br>
            <label><?php _e('Short Specifications','framework'); ?></label>
            <ul class="selected-specs connectedSortable inline">
            <?php foreach($lists as $list)
			{
				if($list!='')
				{
					echo '<li class="sort" id="'.$list.'">'.get_the_title($list).' <span class="del-spec">X</span></li>';
				}
			} ?>
            </ul>
            <input type="hidden" name="saved_lists[]" value="<?php echo $value['lists']; ?>" class="save_ids regular-text">
            
            </div>
            <br>
            <div class="spec-featured">
            <label><?php _e('Select Featured Specifications','framework'); ?></label>
            <select name="speci_featured" class="add-speci">
            <option value="" disabled selected><?php _e('Select','framework'); ?></option>
            
            <?php 
			foreach($ids as $id) 
			{
				$style_lists = (in_array($id,$featured))?"style='display:none;'":""; ?>
            <option <?php echo $style_lists; ?> value="<?php echo $id; ?>"><?php echo get_the_title($id); ?></option>
            <?php } ?>
            </select>
            <br><br>
            <label><?php _e('Featured Specifications','framework'); ?></label>
            <ul class="selected-specs connectedSortable inline">
            <?php foreach($featured as $feat)
			{
				if($feat!='')
				{
					echo '<li class="sort" id="'.$feat.'">'.get_the_title($feat).' <span class="del-spec">X</span></li>';
				}
			} ?>
            </ul>
            <input type="hidden" name="saved_featured[]" value="<?php echo $value['featured']; ?>" class="save_ids regular-text">
          
            </div>
            <br>
            <div class="spec-detailed">
            <label><?php _e('Select Detailed Specifications','framework'); ?></label>
            <select name="speci_featured" class="add-speci">
            <option value="" disabled selected><?php _e('Select','framework'); ?></option>
            
            <?php 
			foreach($ids as $id) 
			{
				$style_lists = (in_array($id,$detailed))?"style='display:none;'":""; ?>
            <option <?php echo $style_lists; ?> value="<?php echo $id; ?>"><?php echo get_the_title($id); ?></option>
            <?php } ?>
            </select>
            <br><br>
            <label><?php _e('Detailed Specifications','framework'); ?></label>
            <ul class="selected-specs connectedSortable inline">
            <?php foreach($detailed as $detail)
			{
				if($detail!='')
				{
					echo '<li class="sort" id="'.$detail.'">'.get_the_title($detail).' <span class="del-spec">X</span></li>';
				}
			} ?>
            </ul>
            <input type="hidden" name="saved_detailed[]" value="<?php echo $value['detailed']; ?>" class="save_ids regular-text">
            
            </div>
            <br>
            <div>
            <input class="button" type="button" value="<?php _e('Remove','framework'); ?>" onclick="remove_field(this)" /></div>
            </div>
            <?php } } ?>
            </div>
            <!--Dynamic Section Start-->
			<div id="master-row" style="display:none;">
            <div class="main-section postbox">
            <label><h3><?php _e('Section','framework'); ?></h3></label>
            <div class="list-cats">
            <label><?php _e('Select category','framework'); ?></label>
            <select name="speci_category[]">
            <option value="" disabled selected><?php _e('Select','framework'); ?></option>
            
            <?php 
			$list_cat = get_terms('listing-category');
			foreach($list_cat as $cat) 
			{ ?>
            <option value="<?php echo $cat->term_id; ?>"><?php echo $cat->name; ?></option>
            <?php } ?>
            </select>
            </div>
            <br>
            <?php
			$specification = get_posts(array('post_type'=>'specification','posts_per_page'=>-1,'post_status'=>'publish','orderby'=>'title','order'=>'ASC'));
			foreach($specification as $post) 
			{
				$ids[]=$post->ID; 
			} 
			wp_reset_postdata(); ?>
            <div class="spec-filter">
            <label><?php _e('Select Filters','framework'); ?></label>
            <select name="speci_filters" class="add-speci">
            <option value="" disabled selected><?php _e('Select','framework'); ?></option>
            
            <?php 
			foreach($ids as $id) 
			{ ?>
            <option value="<?php echo $id; ?>"><?php echo get_the_title($id); ?></option>
            <?php } ?>
            </select>
            <br><br>
            <label><?php _e('Filter Specifications','framework'); ?></label>
            <ul class="selected-specs inline"></ul>
            <input type="hidden" name="saved_filters[]" value="" class="save_ids regular-text">
            </div>
            <br>
            <div class="spec-ad">
            <label><?php _e('Select Ad Listing Fields','framework'); ?></label>
            <select name="speci_ad" class="add-speci">
            <option value="" disabled selected><?php _e('Select','framework'); ?></option>
            
            <?php 
			foreach($ids as $id) 
			{ ?>
            <option value="<?php echo $id; ?>"><?php echo get_the_title($id); ?></option>
            <?php } ?>
            </select>
            <br><br>
            <label><?php _e('Ad Listing Specifications','framework'); ?></label>
            <ul class="selected-specs inline"></ul>
            <input type="hidden" name="saved_ad[]" value="" class="save_ids regular-text">
            
            </div>
            <br>
            <div class="spec-badge">
            <label><?php _e('Select Badges','framework'); ?></label>
            <select name="speci_badges" class="add-speci">
            <option value="" disabled selected><?php _e('Select','framework'); ?></option>
            
            <?php 
			foreach($ids as $id) 
			{ ?>
            <option value="<?php echo $id; ?>"><?php echo get_the_title($id); ?></option>
            <?php } ?>
            </select>
            <br><br>
            <label><?php _e('Badges Specifications','framework'); ?></label>
            <ul class="selected-specs inline"></ul>
            <input type="hidden" name="saved_badges[]" value="" class="save_ids regular-text">
            </div>
            <br>
            <div class="spec-short">
            <label><?php _e('Select Short Specifications','framework'); ?></label>
            <select name="speci_lists" class="add-speci">
            <option value="" disabled selected><?php _e('Select','framework'); ?></option>
            
            <?php 
			foreach($ids as $id) 
			{ ?>
            <option value="<?php echo $id; ?>"><?php echo get_the_title($id); ?></option>
            <?php } ?>
            </select>
            <br><br>
            <label><?php _e('Short Specifications','framework'); ?></label>
            <ul class="selected-specs inline"></ul>
            <input type="hidden" name="saved_lists[]" value="" class="save_ids regular-text">
            
            </div>
            <br>
            <div class="spec-detailed">
            <label><?php _e('Select Featured Specifications','framework'); ?></label>
            <select name="speci_featured" class="add-speci">
            <option value="" disabled selected><?php _e('Select','framework'); ?></option>
            
            <?php 
			foreach($ids as $id) 
			{ ?>
            <option value="<?php echo $id; ?>"><?php echo get_the_title($id); ?></option>
            <?php } ?>
            </select>
            <br><br>
            <label><?php _e('Featured Specifications','framework'); ?></label>
            <ul class="selected-specs inline"></ul>
            <input type="hidden" name="saved_featured[]" value="" class="save_ids regular-text">
            </div>
            <br>
            <div class="spec-featured">
            <label><?php _e('Select Detailed Specifications','framework'); ?></label>
            <select name="speci_detailed" class="add-speci">
            <option value="" disabled selected><?php _e('Select','framework'); ?></option>
            
            <?php 
			foreach($ids as $id) 
			{ ?>
            <option value="<?php echo $id; ?>"><?php echo get_the_title($id); ?></option>
            <?php } ?>
            </select>
            <br><br>
            <label><?php _e('Detailed Specifications','framework'); ?></label>
            <ul class="selected-specs inline"></ul>
            <input type="hidden" name="saved_detailed[]" value="" class="save_ids regular-text">
            </div>
            <br>
            <div>
            <input class="button" type="button" value="<?php _e('Remove','framework'); ?>" onclick="remove_field(this)" /></div>
            </div>
            </div>
            <input type="button" onClick="add_field_row();" value="<?php _e('Add','framework'); ?>">
            <input type="submit" name="save_values" value="<?php _e('Save','framework'); ?>">
            <!--<input type="submit" name="reset_classified" value="<?php _e('Reset','framework'); ?>">-->
            </form>
			<?php
}