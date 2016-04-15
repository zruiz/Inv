<?php
if(!function_exists('imic_get_specs_values_status'))
{
	function imic_get_specs_values_status($arr, $field='imic_plugin_specification_values')
	{
		foreach($arr as $tab)
		{
			$child_value = $tab[$field];
			if(!empty($child_value))
			{
				$result = 1;
				break;
			}
			else
			{
				$result = 0;
			}
		}
		return $result;
	}
}
if(!function_exists('imic_filter_lang_specs_plugin'))
{
	function imic_filter_lang_specs_plugin($specs)
	{
		$new_specs = array();
		if((!empty($specs))&&(class_exists('SitePress')))
		{
			foreach($specs as $spec)
			{
				if(class_exists('SitePress')&&ICL_LANGUAGE_CODE==imic_langcode_post_id( $spec ))
				{
					$new_specs[] = $spec;
				}
			}
		}
		else
		{
			$new_specs = $specs;
		}
		return $new_specs;
	}
}
if (!function_exists('imic_register_post_box')) {
    add_action('admin_init', 'imic_register_post_box');
    function imic_register_post_box() {
        // Check if plugin is activated or included in theme
        if (!class_exists('RW_Meta_Box'))
            return;
        $prefix = 'imic_plugin_';
//Specification Section
$meta_box = array(
    'id' => 'cars-specifications',
    'title' => __('Specification Details', 'framework'),
    'pages' => array('specification'),
    'show_names' => true,
    'fields' => array(
		array(
            'name' => __('Required Mandatory', 'framework'),
            'id' => $prefix . 'required_mandatory',
            'desc' => __("Enable if you need this specification to be filled mandatory by users while publishing their AD listing", 'framework'),
            'type' => 'select',
            'options' => array(
		'0' => __('Disable', 'framework'),
		'1' => __('Enable','framework'),
            ),
	'std' => 0,
        ),
		array(
            'name' => __('Character Type', 'framework'),
            'id' => $prefix . 'spec_char_type',
            'desc' => __("Values of the variables can be set as normal for text and Numeric. Numeric are helpful for specification like Price, Fuel Economy or Mileage", 'framework'),
            'type' => 'select',
            'options' => array(
		//'0' => __('Serialized', 'framework'),
		'1' => __('Numeric','framework'),
		'2' => __('Normal','framework'),
            ),
	'std' => 0,
        ),
				array(
            'name' => __('Minimum Value', 'framework'),
            'id' => $prefix . 'range_min_value',
            'desc' => __("Please insert range selector minimum value, you should enable range filter from listing settings under Theme Options.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
				array(
            'name' => __('Maximum Value', 'framework'),
            'id' => $prefix . 'range_max_value',
            'desc' => __("Please insert range selector maximum value, you should enable range filter from listing settings under Theme Options.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
				array(
            'name' => __('Filter Steps', 'framework'),
            'id' => $prefix . 'range_steps',
            'desc' => __("Please insert steps between minimum and maximum value of filter.Ex-100, then filter will increase or decrease value by minimum of 100", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Value Label', 'framework'),
            'id' => $prefix . 'value_label',
            'desc' => __("Variables label goes here like for Price you can put in $ sign or for Mileage you can use: Kms", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Lable Position', 'framework'),
            'id' => $prefix . 'lable_position',
            'desc' => __("Position of the variables label can be set to prefix or postfix so like for prices Currency sign show before price or after price", 'framework'),
            'type' => 'select',
            'options' => array(
		'0' => __('Prefix', 'framework'),
		'1' => __('Postfix','framework'),
            ),
	'std' => 0,
        ),
		array(
            'name' => __('Enable Sub-field', 'framework'),
            'id' => $prefix . 'sub_field_switch',
            'desc' => __("Enable the subfield for the add listing form if you put in the child values ablove for the variable like for make/model", 'framework'),
            'type' => 'select',
            'options' => array(
		'0' => __('Disable', 'framework'),
		'1' => __('Enable','framework'),
            ),
	'std' => 0,
        ),
		array(
            'name' => __('Sub Field Label', 'framework'),
            'id' => $prefix . 'sub_field_label',
            'desc' => __("Lable for the child values if added for the variable above.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Status after Payment', 'framework'),
            'id' => $prefix . 'status_after_payment',
            'desc' => __("Choose whether you want this specification to be editable once the user/dealer complete the ad listing payment or not.", 'framework'),
            'type' => 'select',
            'options' => array(
		'1' => __('Editable', 'framework'),
		'0' => __('Non Editable','framework'),
            ),
	'std' => 1,
        ),
		array(
            'name' => __('Show for vehicle edit', 'framework'),
            'id' => $prefix . 'show_for_vehicle',
            'desc' => __("Select whether to display this as custom field while editing listing from the wp-dashboard > Cars.", 'framework'),
            'type' => 'select',
            'options' => array(
		'1' => __('Yes', 'framework'),
		'0' => __('No','framework'),
            ),
	'std' => 1,
        ),
));
new RW_Meta_Box($meta_box);	
	}
}
if (!function_exists('imic_register_car_additional_specs')) {
    add_action('admin_init', 'imic_register_car_additional_specs');
    function imic_register_car_additional_specs() {
        // Check if plugin is activated or included in theme
        if (!class_exists('RW_Meta_Box'))
            return;
        $prefix = 'imic_plugin_';
$meta_box = array(
    'id' => 'cars-additional_specs',
    'title' => __('Additional Specifications', 'framework'),
    'pages' => array('cars'),
    'show_names' => true,
    'fields' => array(
		array(
            'name' => __('Ad Steps Completed', 'framework'),
            'id' => $prefix . 'ads_steps',
            'desc' => __("Select completed steps of this listing.", 'framework'),
            'type' => 'select',
            'options' => array(
			'0' => __('None', 'framework'),
			'1' => __('One', 'framework'),
			'2' => __('Two','framework'),
			'3' => __('Three', 'framework'),
			'4' => __('Four','framework'),
			'5' => __('All', 'framework'),
            ),
			'std' => 0,
        ),
		array(
            'name' => __('Payment Status', 'framework'),
            'id' => $prefix . 'ad_payment_status',
            'desc' => __("Select Ad payment status.", 'framework'),
            'type' => 'select',
            'options' => array(
			'0' => __('Pending', 'framework'),
			'1' => __('Completed', 'framework'),
			'4' => __('Under Review', 'framework'),
			'2' => __('Sold', 'framework'),
			'3' => __('Inactive', 'framework'),
            ),
			'std' => 0,
        ),
		array(
            'name' => __('Paid Price', 'framework'),
            'id' => $prefix . 'paid_price',
            'desc' => __("This field will automatically upated on paypal verification.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Plan', 'framework'),
            'id' => $prefix . 'car_plan',
            'desc' => __("Enter Plan ID.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Manual', 'framework'),
            'id' => $prefix . 'car_manual',
            'desc' => __("Upload Vehicle Manual.", 'framework'),
            'type' => 'file_input',
            'std' => '',
        ),
		array(
            'name' => __('Contact Phone', 'framework'),
            'id' => $prefix . 'contact_phone',
            'desc' => __("Enter Contact Phone.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Contact Email', 'framework'),
            'id' => $prefix . 'contact_email',
            'desc' => __("Enter Contact Email.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Video URL', 'framework'),
            'id' => $prefix . 'video_url',
            'desc' => __("Enter Video URL.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Listing End Date', 'framework'),
            'id' => $prefix . 'listing_end_dt',
            'desc' => __("Insert date of Listing end.", 'framework'),
            'type' => 'date',
			'js_options' => array(
				'dateFormat'      =>'yy-mm-dd',
				'changeMonth'     => true,
				'changeYear'      => true,
				'showButtonPanel' => false,
			),
        ),
		array(
            'name' => __('Property Sights', 'framework'),
            'id' => $prefix . 'vehicle_images',
            'desc' => __("Upload Property sights.", 'framework'),
            'type' => 'image_advanced',
            'max_file_uploads' => 30
        ),
		array(
            'name' => __('Listing View', 'framework'),
            'id' => $prefix . 'listing_view',
            'desc' => __("Select listing view.", 'framework'),
            'type' => 'select',
            'options' => array(
		'all' => __('Publicly', 'framework'),
		'dealer' => __('Dealer','framework'),
            ),
	'std' => 'all',
        ),
));
new RW_Meta_Box($meta_box);	
	}
}
if (!function_exists('imic_register_cars_specification_values')) {
    add_action('rwmb_meta_boxes', 'imic_register_cars_specification_values');
    function imic_register_cars_specification_values($meta_boxes) {
        // Check if plugin is activated or included in theme
        if (!class_exists('RW_Meta_Box'))
            return;
        $prefix = 'imic_plugin_';
		//Car Details Meta Box
		$meta_boxes[] = array(
		'title' => __( 'Car Details', 'rwmb' ),
		 'pages' => array('specification'),
		'fields' => array(
			array(
			'id' => 'specifications_value',
			'name' => __( 'Tabs', 'rwmb' ),
			'type' => 'group', // Group type
			'clone' => true, // Can be cloned?
			// List of child fields
			'fields' => array(
		array(
            'name' => __('Values', 'framework'),
            'id' => $prefix . 'specification_values',
                'desc' => __("Enter values for specifications.", 'framework'),
            'type' => 'text',
			'clone' => false,
            'std' => '',
			'columns' => 6, // Display child field in grid columns
        ),
		array(
            'name' => __('Child Values', 'framework'),
            'id' => $prefix . 'specification_values_child',
                'desc' => __("Enter comma seperated values to be child of above value.", 'framework'),
            'type' => 'text',
			'clone' => false,
            'std' => '',
			'columns' => 6, // Display child field in grid columns
        ),
		
		array(
            'name' => __('Image', 'framework'),
            'id' => $prefix . 'spec_image',
            'desc' => __("Insert Image.", 'framework'),
            'type' => 'file_input',
			'clone' => false,
            'std' => '',
			'columns' => 6, // Display child field in grid columns
        ),
		/*array(
			'name' => __( 'Color', 'framework' ),
			'id' => $prefix."spec_color",
			'desc' => __('Select Color','framework'),
			'type' => 'color',
			'columns' => 6, // Display child field in grid columns
			),*/
		))),
);
	return $meta_boxes;
	}
}
add_action( 'admin_init', 'add_event_fields_clone' );
add_action( 'save_post', 'imic_update_event_fields_data', 10, 2 );
/**
 * Add custom Meta Box to Posts post type
 */
function add_event_fields_clone() 
{
    add_meta_box('event_schedule',__('Specifications','framework'),'imic_event_feilds_output','cars','normal','core');
}
/**
 * Print the Meta Box content
 */
function imic_event_feilds_output() 
{
    global $post, $line_icons;
	global $ints;
	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'event_schedule_meta_box', 'event_schedule_meta_box_nonce' );
    $feat_data = get_post_meta( $post->ID, 'feat_data', true );
	$car_id = $post->ID;
?>
<div id="field_group">
    <div id="field_wrap">
    <?php 
		$specification = get_posts(array('post_type'=>'specification','posts_per_page'=>-1,'post_status'=>'publish','meta_query'=>array(array('key'=>'imic_plugin_show_for_vehicle','value'=>'1','compare'=>'='))));
		$ids = $ints = $chars = array();
		foreach($specification as $post_specs) {
		$int = get_post_meta($post_specs->ID,'imic_plugin_spec_char_type',true);
		if($int==0) {
			$ids[] = $post_specs->ID; }
			elseif($int==2)
			{
				$chars[] = $post_specs->ID;
			}
			elseif($int==1) {
				$ints[] = $post_specs->ID;
			}
		} 
		$ids = imic_filter_lang_specs_plugin($ids);
		$chars = imic_filter_lang_specs_plugin($chars);
		$ints = imic_filter_lang_specs_plugin($ints);
		$i=0;
        foreach( $ids as $id ) 
        {
			$spec_key = 'ss';
			$title = $position = $spec_value = $this_id = '';
			if(!empty($feat_data['sch_title'])) {
			if(in_array($id,$feat_data['sch_title'])) {
			$spec_key = array_search($id, $feat_data['sch_title']); } 
			elseif(in_array($id*111,$feat_data['sch_title'])) {
			$spec_key = array_search($id*111, $feat_data['sch_title']); } 
			else { $spec_key = 'ss'; }
			}
			$this_id = $id;
		if(isset($feat_data['start_time'][$spec_key])||($spec_key!='ss')) { $spec_value = $feat_data['start_time'][$spec_key]; }
		if(isset($feat_data['sch_title'][$spec_key])&&($spec_key!='ss')) { $this_id = $feat_data['sch_title'][$spec_key]; }
		$values = get_post_meta($this_id,'specifications_value',true);
        ?>
        <div class="field_row">
          <div class="rwmb-meta-box">
          
          <div class="rwmb-field rwmb-select-wrapper"><div class="rwmb-label">
              <label><?php echo get_the_title($this_id); ?></label></div>
              <?php if(imic_get_specs_values_status($values)==1) { ?>
              <div class="rwmb-input">
              <select type="text"
                     class="meta_feat_title rwmb-select"
                     name="featured[start_time][]"
              >
              <option value=""><?php _e('Select','framework'); ?></option>
              <?php foreach($values as $value) {
				  		$select = ($spec_value==$value['imic_plugin_specification_values'])?'selected="selected"':'';
				 		echo '<option '.$select.' value="'.$value['imic_plugin_specification_values'].'">'.$value['imic_plugin_specification_values'].'</option>';
			  } ?>
              </select>
              </div>
              <?php } else { ?>
              <div class="rwmb-input"><input type="text" class="meta_feat_title" name="featured[start_time][]" value="<?php echo esc_attr($spec_value); ?>"/></div>
              <?php } ?>
            </div>
            <div class="form_field" style="display:none;"><div class="rwmb-label">
              <label><?php _e('Title','framework'); ?></label></div><div class="rwmb-input">
              <input type="text"
                     class="meta_sch_title"
                     name="featured[sch_title][]"
                     value="<?php echo esc_attr($this_id); ?>"
              /></div>
            </div>
            <?php if(imic_get_child_values_status($values)==1) { ?>
          	<div class="rwmb-field rwmb-select-wrapper"><div class="rwmb-label">
              <label><?php echo get_post_meta($this_id,'imic_plugin_sub_field_label',true); ?></label></div>
              <div class="rwmb-input"><input type="text" class="meta_feat_title" name="featured[start_time][]" value="<?php echo (!empty($feat_data))?$feat_data['start_time'][array_search($this_id*111, $feat_data['sch_title'])]:''; ?>"/></div>
            </div>
            <div class="form_field" style="display:none;"><div class="rwmb-label">
              <label><?php _e('Title','framework'); ?></label></div><div class="rwmb-input">
              <input type="text"
                     class="meta_sch_title"
                     name="featured[sch_title][]"
                     value="<?php echo esc_attr($this_id*111); ?>"
              /></div>
            </div>
          <?php } ?>
          </div>
          <div class="clear" /></div> 
        </div>
        <?php
        //} // endif
    $i++; } // endforeach
		foreach( $chars as $char ) 
        {
		$values = get_post_meta($char,'specifications_value',true);
		$char_slug = imic_the_slug($char);
		$spec_value = get_post_meta($post->ID, 'char_'.$char_slug, true);
        ?>
        <div class="field_row">
          <div class="rwmb-meta-box">
          
          <div class="rwmb-field rwmb-select-wrapper"><div class="rwmb-label">
              <label><?php echo get_the_title($char); ?></label></div>
              <?php if(imic_get_specs_values_status($values)==1) { 
								$parent_class = (imic_get_child_values_status($values)==1)?'parent-spec':''; ?>
              <div class="rwmb-input">
              <select type="text"
              data-specid="<?php echo esc_attr($char); ?>" 
              data-listid="<?php echo esc_attr($post->ID); ?>"
                     class="meta_feat_title rwmb-select <?php echo esc_attr($parent_class); ?>"
                     name="char_<?php echo esc_attr($char_slug); ?>"
              >
              <option value=""><?php _e('Select','framework'); ?></option>
              <?php foreach($values as $value) {
				  		$select = ($spec_value==$value['imic_plugin_specification_values'])?'selected="selected"':'';
				 		echo '<option '.$select.' value="'.$value['imic_plugin_specification_values'].'">'.$value['imic_plugin_specification_values'].'</option>';
			  } ?>
              </select>
              </div>
              <?php } else { ?>
              <div class="rwmb-input"><input type="text" class="meta_feat_title" name="char_<?php echo esc_attr($char_slug); ?>" value="<?php echo esc_attr($spec_value); ?>"/></div>
              <?php } ?>
            </div>
            <?php if(imic_get_specs_values_status($values, 'imic_plugin_specification_values_child')==1) { ?>
          	<div class="rwmb-field rwmb-select-wrapper"><div class="rwmb-label">
              <label><?php echo get_post_meta($char,'imic_plugin_sub_field_label',true); ?></label></div>
              <div class="rwmb-input child-spec">
              <?php
							if($spec_value!='')
							{
								$current_value = get_post_meta($post->ID, 'child_'.$char_slug, true);
							echo '<select type="text" class="meta_feat_title rwmb-select" name="child_'.esc_attr($char_slug).'">';
              foreach($values as $value) {
								if($spec_value==$value['imic_plugin_specification_values'])
								{
									$child_vals = $value['imic_plugin_specification_values_child'];
									$child_vals = explode(',', $child_vals);
									break;
								}
							}
							foreach($child_vals as $val)
							{
								$selected = ($current_value==$val||$current_value==" ".$val)?'selected':'';
								echo '<option '.$selected.' value="'.$val.'">'.$val.'</option>';
							}
             echo '</select>';
							}
						 ?>
              </div>
            </div>
          <?php } ?>
          </div>
          <div class="clear" /></div> 
        </div>
        <?php
        //} // endif
    $i++; } // endforeach
		foreach($ints as $in) {
		$values = get_post_meta($in,'specifications_value',true);
		$integer = get_post_meta($in,'imic_plugin_spec_char_type',true);
		$post_id = get_post($in);
		$spec_slug = $post_id->post_name;  ?>
        <div class="field_row">
          <div class="rwmb-meta-box">
          
          <div class="rwmb-field rwmb-select-wrapper"><div class="rwmb-label">
              <label><?php echo get_the_title($in); ?></label></div>
              <div class="rwmb-input"><input type="text" class="meta_feat_title" name="int_<?php echo esc_attr($spec_slug); ?>" value="<?php echo get_post_meta($car_id,'int_'.$spec_slug,true); ?>"/></div>
            </div>
          </div>
          <div class="clear" /></div> 
        </div>
		<?php }	//$ids[]=get_the_ID();
		//} wp_reset_postdata();
    ?>
    </div></div>
  <?php
}
/**
 * Save post action, process fields
 */
function imic_update_event_fields_data( $post_id, $post_object ) 
{
    if ( ! isset( $_POST['event_schedule_meta_box_nonce'] ) ) {
		return;
	}
	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['event_schedule_meta_box_nonce'], 'event_schedule_meta_box' ) ) {
		return;
	}
    // Doing revision, exit earlier **can be removed**
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )  
        return;
    // Doing revision, exit earlier
    if ( 'revision' == $post_object->post_type )
        return;
    // Verify authenticity
	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'cars' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}
	/* OK, it's safe for us to save the data now. */
    
			
		$args_specification = array('post_type'=>'specification','posts_per_page'=>-1,'post_status'=>'publish','meta_query'=>array(array('key'=>'imic_plugin_spec_char_type','value'=>"0",'compare'=>"!=")));
	$specification_listing = new WP_Query( $args_specification );
	if ( $specification_listing->have_posts() ) :
	while ( $specification_listing->have_posts() ) :	
	$specification_listing->the_post();
		$specs_slug = imic_the_slug(get_the_ID());
		$field_type = get_post_meta(get_the_ID(), 'imic_plugin_spec_char_type', true);
		if(($field_type=="1")&&(isset($_POST['int_'.$specs_slug])))
		{
			update_post_meta($post_id,'int_'.$specs_slug,$_POST['int_'.$specs_slug]);
		}
		elseif(($field_type=="2")&&(isset($_POST['char_'.$specs_slug])))
		{
			update_post_meta($post_id,'char_'.$specs_slug,$_POST['char_'.$specs_slug]);
			if(isset($_POST['child_'.$specs_slug]))
			{
				update_post_meta($post_id,'child_'.$specs_slug,$_POST['child_'.$specs_slug]);
			}
		}
	endwhile; endif; wp_reset_postdata();
	if ( $_POST['featured'] ) 
    {
        // Build array for saving post meta
        $feat_data = array();
        for ($i = 0; $i < count( $_POST['featured']['sch_title'] ); $i++ ) 
        {
            if ( '' != $_POST['featured']['sch_title'][ $i ] ) 
            {
				$feat_data['start_time'][]  = $_POST['featured']['start_time'][ $i ];
                $feat_data['sch_title'][]  = $_POST['featured']['sch_title'][ $i ];
            }
        }
        if ( $feat_data ) 
            update_post_meta( $post_id, 'feat_data', $feat_data );
        else 
            delete_post_meta( $post_id, 'feat_data' );
    } 
    // Nothing received, all fields are empty, delete option
    else 
    {
        delete_post_meta( $post_id, 'feat_data' );
    }
}
function add_admin_scripts_event( $hook ) {
    global $post;
    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        if ( 'cars' === $post->post_type ) {     
			wp_enqueue_style(  'myscript', get_template_directory_uri().'/css/clone_fields.css' );
			wp_enqueue_script(  'imic_listing_admin', get_template_directory_uri().'/js/listing_admin.js' );
			wp_localize_script('imic_listing_admin','listadm',array('ajaxurl'=>admin_url('admin-ajax.php')));
        }
    }
}
add_action( 'admin_enqueue_scripts', 'add_admin_scripts_event', 10, 1 );
?>