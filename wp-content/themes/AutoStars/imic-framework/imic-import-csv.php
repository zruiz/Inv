<?php
add_action('admin_menu', 'imic_import_csv_listing_menu');
function import_custom_css()
{ wp_enqueue_style( 'stylesheet_name', 'stylesheet.css'); }

function import_custom_js ()
{ wp_enqueue_script( 'imic_import_fields', get_template_directory_uri().'/js/import_fields.js'); }
function imic_import_csv_listing_menu() {
	$import_submenu = add_submenu_page( 'themes.php', 'Import CSV', 'Import CSV', 'manage_options', 'import-csv', 'imic_import_csv_listing' );
   	add_action( 'admin_print_styles-' . $import_submenu, 'import_custom_css' );
   	add_action( 'admin_print_scripts-' . $import_submenu, 'import_custom_js' );
}

function imic_import_csv_listing() {
	echo '<div class="wrap"><div id="icon-tools" class="icon32"></div>';
		echo '<h2>'.esc_attr__('Import CSV file for listing','framework').'</h2>';
	echo '</div>';
				$spec_data = array();
				$listing_specs = array('post_type'=>'specification','posts_per_page'=>-1,'meta_query'=>array(array('key'=>'imic_plugin_spec_char_type','value'=>'0','compare'=>'=')));
				$cars_listings = new WP_Query( $listing_specs );
				if ( $cars_listings->have_posts() ) :
				while ( $cars_listings->have_posts() ) :
				$cars_listings->the_post();
				$spec_data[get_the_ID()]=get_the_title();
				endwhile; endif; wp_reset_postdata();
				if(isset($_POST['save_values'])) {
					//echo "sainath";
					$feat_data = array();
					for ($i = 0; $i < count( $_POST['csv_label'] ); $i++ ) {
						if($_POST['csv_label'][ $i ]!='') {
						$feat_data[$_POST['csv_specification'][ $i ]]  = $_POST['csv_label'][ $i ]; }
					}
					update_option('imic_csv_values',$feat_data);
					update_option('imic_csv_attachment',$_POST['attachment-btn']);
				}
				if(isset($_POST['add_csv'])) {
					$saved_options = get_option('imic_csv_values');
				$file = $_FILES['upload_csv']['tmp_name'];
				//echo $file;
				$array = $fields = array(); $i = 0;
$handle = @fopen($file, "r");
if ($handle) {
    while (($row = fgetcsv($handle, 4096)) !== false) {
        if (empty($fields)) {
            $fields = $row;
            continue;
        }
        foreach ($row as $k=>$value) {
            $array[$i][$fields[$k]] = $value; 
        }
        $i++;
    }
	$save_val_ids = array();
	$start = 1;
	foreach($array as $single_array) {
		if($start==1) {
		foreach($single_array as $key=>$value) {
		$save_ids = array_search($key, $saved_options);
		//$s_id = array_search($key, $spec_data);
		//echo $saved_options[$save_ids];
		if(array_search($key, $saved_options)&&($save_ids!='0')&&($save_ids!='thumbnail')&&($save_ids!='content')&&($save_ids!='unique')) 
		{ 
			$save_val_ids[] = $save_ids; 
		}
		//elseif(($save_ids!='thumbnail')&&($save_ids!='unique'))
		else 
		{
			
			if(!array_search($key, $spec_data)) {
			$specs_post = array(
			  'post_title'    => $key,
			  'post_status'   => 'publish',
			  'post_type'	  => 'specification'
			);
			// Insert the specification into the database
			$spec_id = wp_insert_post( $specs_post );
			if($save_ids!='thumbnail') {
			update_post_meta($spec_id,'imic_plugin_show_for_vehicle',1); }
			$save_val_ids[] = $spec_id;
			}
			else {
				$spec_id = array_search($key, $spec_data);
				$save_val_ids[] = $spec_id; 
			}
		}
		}
		}
		else
		{
			$feat_data = $urls = array();
			$content = '';
			$i = 0;
		foreach($single_array as $key=>$value) 
		{
			if($start!=1) 
			{
				$save_ids = array_search($key, $saved_options);
				//if(array_search($key, $spec_data))  {
				//if(is_int($save_ids)) {
					if($save_ids=="thumbnail") {
						$urls = explode(",", $value);
						
					}
					elseif($save_ids=="content") {
						$content = $value;
					} 
					else {
					$feat_data['start_time'][] = $value;
					$feat_data['sch_title'][] = $save_val_ids[$i]; }
					//echo "saibaba"; $save_val_ids[] = $s_id; 
				//} 
			}
		$i++; }
		$listing_post = array(
			  'post_title'    => 'listing',
			  'post_status'   => 'publish',
			  'post_type'	  => 'yachts',
			  'post_content'  => $content
			);
			// Insert the specification into the database
			$listing_id = wp_insert_post( $listing_post );
		update_post_meta( $listing_id, 'feat_data', $feat_data );
		if(get_option('imic_csv_attachment')=="1") {
		if(!empty($urls)) {
			$counter = 1;
		foreach($urls as $url) {
			require_once(ABSPATH . 'wp-admin' . '/includes/image.php');
			require_once(ABSPATH . 'wp-admin' . '/includes/file.php');
			require_once(ABSPATH . 'wp-admin' . '/includes/media.php');
			$upload = media_sideload_image($url, $listing_id, '');
			if ( is_wp_error( $upload ) ) {
				//echo "sorry, images could not be uploaded";
			}
			else {
			$attachments = get_posts( array(
			'post_type' => 'attachment',
			'number_posts' => 1,
			'post_status' => null,
			'post_parent' => $listing_id,
			'orderby' => 'post_date',
			'order' => 'DESC',
			) );
			$thumbnail_id = $attachments[0]->ID; 
			if($counter==1) {
			update_post_meta($listing_id, '_thumbnail_id', $thumbnail_id); }
			add_post_meta($listing_id, 'imic_plugin_vehicle_images', $thumbnail_id, false); $counter++; } } }
		}
		}
		$start++;
	}
	//echo count($save_val_ids);
	//print_r($array);
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}
			} //print_r(get_option('imic_csv_values')); ?>
            
            <!--<p>Please add specification for csv labels, please upload minimum csv files as per server load.</p>
            <p>Select unique field of csv file, so that it could create only new listings.</p>-->
            <form name="add_values_csv" method="post">
            <div>
            <label>Upload images</label>
            <p><label>Yes</label><input <?php echo (get_option('imic_csv_attachment')==1)?'checked':''; ?> type="radio" name="attachment-btn" value="1">
            <label>No</label><input <?php echo (get_option('imic_csv_attachment')==0)?'checked':''; ?> type="radio" name="attachment-btn" value="0"></p>
            </div>
            <label><strong>CSV Values</strong></label>
            <div id="field_wrap">
            <?php
			$csv_vals = get_option('imic_csv_values');
			if(!empty($csv_vals)) {
				foreach($csv_vals as $key=>$value) {
					if(!empty($value[0])) { ?>
					<div><label>CSV Labels</label>
            <input type="text" name="csv_label[]" value="<?php echo $value; ?>">
            <label>Select Specification for this label</label>
            <select name="csv_specification[]">
            <option value="0">Select</option>
            <option <?php echo ($key=="thumbnail")?'selected="selected"':''; ?> value="thumbnail">Thumbnail</option>
            <!--<option <?php echo ($key=="create")?'selected="selected"':''; ?> value="create">Create</option>-->
            <option <?php echo ($key=="content")?'selected="selected"':''; ?> value="content">Content</option>
            <option <?php echo ($key=="unique")?'selected="selected"':''; ?> value="unique">Unique Id</option>
            <?php foreach($spec_data as $keys=>$values) { ?>
            <option <?php echo ($key==$keys)?'selected="selected"':''; ?> value="<?php echo $keys; ?>"><?php echo $values; ?></option>
            <?php } ?>
            </select>
            <input class="button" type="button" value="<?php _e('Remove','framework'); ?>" onclick="remove_field(this)" /></div><?php
					}
				}
			}
			?>
            </div>
			<div id="master-row" style="display:none;">
            
            <div>
            <label>CSV Labels</label>
            <input type="text" name="csv_label[]" value="">
            <label>Select Specification for this label</label>
            <select name="csv_specification[]">
            <option value="0">Select</option>
            <option value="thumbnail">Thumbnail</option>
            <!--<option value="create">Create</option>-->
            <option value="content">Content</option>
            <option value="unique">Unique Id</option>
            <?php foreach($spec_data as $key=>$values) { ?>
            <option value="<?php echo $key; ?>"><?php echo $values; ?></option>
            <?php } ?>
            </select>
            <input class="button" type="button" value="<?php _e('Remove','framework'); ?>" onclick="remove_field(this)" />
            </div> 
			</div>
            <input type="button" onClick="add_field_row();" value="Add">
            <input type="submit" name="save_values" value="Save">
            </form>
            <form name="submit_csv" action="" method="post" enctype="multipart/form-data">
            <div>
            <input type="file" name="upload_csv" id="upload_csv">
            <input name="add_csv" type="submit" value="upload">
            </div>
            </form>
			<?php
}