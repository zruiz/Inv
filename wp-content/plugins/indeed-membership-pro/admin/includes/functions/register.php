<?php 
function ihc_update_reg_fields($post_data){
	/*
	 * this function will update the order of register fields
	 * @param $_POST
	 * @return none
	 */
	$data = get_option('ihc_user_fields');
	$new_data = array();
	foreach ($data as $k=>$v){
		$num = $post_data['ihc-order-' . $k];
		$new_data[$num] = $v;
		if (isset($post_data['ihc-field-display-admin' . $k])){
			$new_data[$num]['display_admin'] = $post_data['ihc-field-display-admin' . $k];
		}
		if (isset($post_data['ihc-field-display-public-reg' . $k])){
			$new_data[$num]['display_public_reg'] = $post_data['ihc-field-display-public-reg' . $k];
		}	
		if (isset($post_data['ihc-field-display-public-ap' . $k])){
			$new_data[$num]['display_public_ap'] = $post_data['ihc-field-display-public-ap' . $k];
		}			
		if (isset($post_data['ihc-require-' . $k])){
			$new_data[$num]['req'] = $post_data['ihc-require-' . $k];
		}
	}
	update_option('ihc_user_fields', $new_data);
}

function ihc_update_register_fields($post_data){
	/*
	 * this function will update the labels and the name
	 * @param $_POST
	 * @return none
	 */	
	$meta = get_option('ihc_user_fields');
	if (isset($meta[$post_data['id']])){
		if (isset($post_data['name'])) $meta[$post_data['id']]['name'] = $post_data['name'];
		if (isset($post_data['label'])) $meta[$post_data['id']]['label'] = $post_data['label'];
		if (isset($post_data['type'])) $meta[$post_data['id']]['type'] = $post_data['type'];
		if (isset($post_data['values'])) $meta[$post_data['id']]['values'] = $post_data['values'];
		if (isset($post_data['sublabel'])) $meta[$post_data['id']]['sublabel'] = $post_data['sublabel'];
		if (!empty($post_data['display_admin'])) $meta[$post_data['id']]['display_admin'] = $post_data['display_admin'];
		if (!empty($post_data['display_public_ap'])) $meta[$post_data['id']]['display_public_ap'] = $post_data['display_public_ap'];
		if (!empty($post_data['display_public_reg'])) $meta[$post_data['id']]['display_public_reg'] = $post_data['display_public_reg'];
		if (isset($post_data['target_levels'])) $meta[$post_data['id']]['target_levels'] = $post_data['target_levels'];
		if (isset($post_data['class'])) $meta[$post_data['id']]['class'] = $post_data['class'];
		update_option('ihc_user_fields', $meta);			
	}
}


function ihc_save_user_field($post_data){
	/*
	 * save user field
	 * array( 
	 *  'display_admin'=>'', 
	 *	'display_public_reg'=>'', 
	 * 	'display_public_ap'=>'', 
	 * 	'always'=>'', 
	 * 	'name'=>'', 
	 * 	'label'=>'', 
	 * 	'type'=>'', 
	 * 	'native_wp' => '', 
	 * 	'req' => '', 	
	 * 	'values'=>'' 
	 *  'sublevel'=>'');
	 * @param $_POST
	 * @return none
	 */
	if (isset($post_data['name']) && $post_data['name']
			&& isset($post_data['label']) && isset($post_data['type']) ){
		$new = array(
				//'display' => 0,
				'display_admin' => 0,
				'display_public_reg' => 0,
				'display_public_ap' => 0,
				'name' => $post_data['name'],
				'label' => $post_data['label'],
				'type' => $post_data['type'],
				'native_wp' => 0,
				'req' => 0,
				'sublabel' => $post_data['sublabel'],
				'target_levels' => @$post_data['target_levels'],
				'class' => @$post_data['class'],
		);
		if (isset($post_data['values'])){
			$new['values'] = $post_data['values'];
		}

		$data = get_option('ihc_user_fields');
		if ($data!==FALSE){
			$data[]= $new;			
		} else {
			$data = ihc_native_user_field();
			$data[] = $new;
		}
		update_option('ihc_user_fields', $data);
	}
}

function ihc_delete_user_field($id){
	/*
	 * delete user field
	 * @param field id to delete
	 * @return none
	 */	
	$data = get_option('ihc_user_fields');
	if (isset($data[$id]) ){
		unset($data[$id]);
	}
	update_option('ihc_user_fields', $data);
}