<?php
if(!function_exists('imi_get_child_category')) {
function imi_get_child_category(){
	//echo "sai";
	global $imic_options;
	$parent_cat = $_POST['parents'];
	$ids = $_POST['ids'];
	$page = (isset($_POST['pagess']))?$_POST['pagess']:'';
	$data_pages = ($page!='')?$page:'';
	$num_id = explode("-",$ids);
	$category_id = get_term_by('slug', $parent_cat, 'listing-category');
	$listing_cats = get_terms('listing-category',array('parent' => $category_id->term_id));
	if(!empty($listing_cats)) 
	{
		echo '<div class="col-md-3 col-sm-3 act-cat" id="'.$num_id[0].'-'.((intval($num_id[1]))+1).'">';
		echo '<label>'.__('Select Category').'</label>';
		echo '<select data-page="'.$data_pages.'" data-empty="true" name="list-cat" class="form-control selectpicker get-child-cat">';
		echo '<option value="" selected disabled>'.__('Select','framework').'</option>';
		foreach($listing_cats as $cat)
		{
			$term_children = get_terms('listing-category',array('parent' => $cat->term_id));
			$disabled = (empty($term_children))?'blank':'';
			echo '<option data-val="'.$disabled.'" value="'.$cat->slug.'">'.$cat->name.'</option>';
		}
		echo '</select>';
		echo '</div>';
	}
	echo '<div class="col-md-3 col-sm-3 loading-fields" id="loading-field" style="display:none;"><label>'.__('Select Category','framework').'</label><input class="form-control" type="text" value="'.__('Loading...','framework').'"></div>';
	die();
}
add_action('wp_ajax_nopriv_imi_get_child_category', 'imi_get_child_category');
add_action('wp_ajax_imi_get_child_category', 'imi_get_child_category');
}
if(!function_exists('imic_set_ad_fields'))
{
	function imic_set_ad_fields()
	{
		//echo "saibaba";
		global $imic_options;
		$custom_details = array();
		$category_slug = $_POST['slug'];
		$update_id = $_POST['update'];
		$required_value = '';
		$specifications = get_post_meta($update_id,'feat_data',true);
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
if((empty($custom_details))&&($imic_options['ad_listing_fields']!=1))
{
	$custom_details = $imic_options['custom_vehicle_details'];
}
$total_fields = count($custom_details); 
$half = $total_fields/2; 
$half = (imic_is_decimal($half))?$half+1:$half; 
$half = floor($half); 
if((!empty($custom_details))&&($imic_options['ad_listing_fields']==1)) 
{ 
	echo "<div class=\"row\">";
	$st = 1;
	foreach($custom_details as $field) {
	$label = get_post_meta($field,'imic_plugin_value_label',true);
	$editable = get_post_meta($field,'imic_plugin_status_after_payment',true);
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
											echo '<label>'.__('Select ', 'framework').get_the_title($field).'</label>';
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
														echo '<label>'.__('Select ', 'framework').get_post_meta($field,'imic_plugin_sub_field_label',true).'</label>';
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
																$required_value = get_post_meta($update_id, 'child_'.$child_field_slug, true);
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
                                               	if(($st==$half)||(count($custom_details)==$st)) 
												{ 
													echo '</div>'; 
												} 
												$st++;   
											} 
	//echo "</div>"; 
	if(is_user_logged_in()) 
{ ?>
	<button id="ss" class="btn btn-info pull-right save-searched-value"><?php echo esc_attr_e('Save','framework'); ?> &amp; <?php echo esc_attr_e('continue','framework'); ?></button><?php } else { echo '<a class="btn btn-primary pull-right" data-toggle="modal" data-target="#PaymentModal">'.__('Login/Register','framework').'</a>'; }
} 
else
{
	echo "blank";
}
	die();
    }
	add_action('wp_ajax_nopriv_imic_set_ad_fields', 'imic_set_ad_fields');
	add_action('wp_ajax_imic_set_ad_fields', 'imic_set_ad_fields');
}
if(!function_exists('imic_set_tags_fields'))
{
	function imic_set_tags_fields()
	{
		$output = '';
		$data = '';
		$parents = array();
		$category_slug = $_POST['slug'];
		$update_id = $_POST['update'];
		$term_id = get_term_by('slug', $category_slug, 'listing-category');
		$parents = get_ancestors( $term_id->term_id, 'listing-category' );
		array_push($parents, $term_id->term_id);
		$list_tags = get_terms('yachts-tag',array('hide_empty'=>false));
		$term_list = wp_get_post_terms($update_id, 'yachts-tag', array("fields" => "ids"));
		foreach($list_tags as $tag)
		{ 
			$cat_slugs = get_option('taxonomy_'.$tag->term_id.'_metas');
			$cat_slugs = $cat_slugs['cats'];
			if(!empty($cat_slugs))
			{
				$cat_slugs = explode(',', $cat_slugs);
			}
			else
			{
				$cat_slugs = array();
			}
			foreach($parents as $parent)
			{ 
				$list_term = get_term_by('id', $parent, 'listing-category');
				if(in_array($list_term->slug, $cat_slugs))
				{
					$selected = (in_array($tag->term_id,$term_list))?'checked':'';
					echo '<li class="checkbox"><label><input '.$selected.' value="1" id="'.$tag->slug.'" type="checkbox" class="vehicle-tags"> '.$tag->name.'</input></label></li>';
					$data = 1;
					break;
				}
														
			}
		}
		if($data!=1)
		{
			echo 'blank';
		}
		die();
	}
	add_action('wp_ajax_nopriv_imic_set_tags_fields', 'imic_set_tags_fields');
	add_action('wp_ajax_imic_set_tags_fields', 'imic_set_tags_fields');
}
if(!function_exists('imic_classified_badge_specs'))
{
	function imic_classified_badge_specs($id, $badges)
	{
		$badge_ids = $badges;
		global $imic_options;
		$classifieds_data = get_option('imic_classifieds');
		$list_cat_id = wp_get_post_terms( $id, 'listing-category', array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all') );
		if(!empty($list_cat_id))
		{
			foreach($list_cat_id as $cat)
			{
				if(!empty($classifieds_data))
				{
					if(array_key_exists($cat->term_id, $classifieds_data))
					{
						$classi_data_badge = $classifieds_data[$cat->term_id]['badge'];
						if($classi_data_badge!=''&&$imic_options['badges_type']==1)
						{
							$badge_ids = explode(',', $classi_data_badge);
							break;
						}
					}
				}
			}
		}
		return $badge_ids;
	}
}
if(!function_exists('imic_classified_short_specs'))
{
	function imic_classified_short_specs($id, $details)
	{
		$detailed_specs = $details;
		global $imic_options;
		$classifieds_data = get_option('imic_classifieds');
		$list_cat_id = wp_get_post_terms( $id, 'listing-category', array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all') );
		if(!empty($list_cat_id))
		{
			foreach($list_cat_id as $cat)
			{
				if(!empty($classifieds_data))
				{
					if(array_key_exists($cat->term_id, $classifieds_data))
					{
						$classi_data_lists = $classifieds_data[$cat->term_id]['lists'];
						if($classi_data_lists!=''&&$imic_options['short_specifications']==1)
						{
							$detailed_specs = explode(',',$classi_data_lists);
							break;
						}
					}
				}
			}
		}
		return $detailed_specs;
	}
}

if(!function_exists('imic_get_cats_list'))
{
	function imic_get_cats_list($id, $type="list")
	{
		global $imic_options;
		$listing_page_url = imic_get_template_url('template-listing.php');
		$list = '';
		$separator = " &gt; ";
		$start = 1;
		$args = array('orderby' => 'name', 'fields' => 'all','hierarchical'  => true,	'child_of' => 0);
		$terms = wp_get_object_terms( $id, 'listing-category');
		if($type=="list")
		{
			$list .= '<div class="category-rail">';
			foreach($terms as $term)
			{
				$list .= '<a href="'.esc_url(add_query_arg('list-cat',$term->slug,$listing_page_url)).'">'.$term->name.'</a>';
				if($start<count($terms))
				{
					$list .= $separator;
				}
				$start++;
			}
			$list .= '</div>';
		}
		if($type=="dropdown")
		{
			if(count($terms)>1)
			{
				$list .= '<div class="btn-group pull-right category-rail">
				<button type="button" class="btn btn-default listing-sort-btn">'.__('Categories','framework').'</button>
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
				<span class="caret"></span>
				<span class="sr-only">'.__('Toggle Dropdown','framework').'</span>
				</button>
				<ul class="dropdown-menu sorter">';
				foreach($terms as $term)
				{
					$list .= '<li><a href="'.esc_url(add_query_arg('list-cat',$term->slug,$listing_page_url)).'">'.$term->name.'</a></li>';
				}
				$list .= '</ul>
				</div>';
			}
			else
			{
				$list .= '<div class="category-rail">';
				foreach($terms as $term)
				{
					$list .= '<a href="'.esc_url(add_query_arg('list-cat',$term->slug,$listing_page_url)).'">'.$term->name.'</a>';
				}
				$list .= '</div>';
			}
		}
		$list .= '';
		return $list;
	}
}
if(!function_exists('imic_viewed_listing'))
{
	function imic_viewed_listing($id)
	{
		$most_viewed = get_option('imic_most_viewed');
		$most_viewed = (!empty($most_viewed))?$most_viewed:array();
		$most = get_post_meta($id, 'imic_most_visited', true);
		$most = ($most=='')?0:$most;
		if(!in_array($id, $most_viewed))
		{
			array_unshift($most_viewed, $id);
			update_option('imic_most_viewed', $most_viewed);
		}
		update_post_meta($id, 'imic_most_visited', $most+1);
	}
}
?>