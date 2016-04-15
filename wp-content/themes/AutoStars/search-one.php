<?php global $imic_options;
$listing_url = imic_get_template_url("template-listing.php");
$listing_id = imic_get_template_id('template-listing.php');
$container = ($imic_options['search_position']==1)?"container":"";
$search_type = (isset($imic_options['search_form_type']))?$imic_options['search_form_type']:0;
$numeric_specs_type = (isset($imic_options['integer_specs_type']))?$imic_options['integer_specs_type']:0; ?>
<div class="search-form">
                    <div class="search-form-inner">
                        <form class="<?php echo esc_attr($container); ?> searchoneform" method="get" action="<?php echo esc_url($listing_url); ?>">
                        <input type="hidden" value="<?php echo esc_attr($listing_id); ?>" name="page_id">
                            <h3><?php echo esc_attr_e('Find a Car with our Quick Search','framework'); ?></h3>
                            <div class="row parent-category-row">
                        	<?php  if($search_type==0) 
																{		
																	$search_fields = (isset($imic_options['search_form']))?$imic_options['search_form']:array();
																	$count = 1;
																	if(!empty($search_fields)) 
																	{
																		$new_search_fields = imic_filter_lang_specs($search_fields);
																		foreach($new_search_fields as $field):
																		$value_label = get_post_meta($field, 'imic_plugin_value_label', true);
																					$specs = get_post_meta($field,'specifications_value',true);
																				$int = get_post_meta($field,'imic_plugin_spec_char_type',true);
																				if($int==0) 
																				{
																					$spec_slug = imic_the_slug($field); 
																				}
																				elseif($int==1)
																				{
																					if($numeric_specs_type==0)
																					{
																						$spec_slug = "int_".imic_the_slug($field);
																						$min_val = get_post_meta($field, 'imic_plugin_range_min_value', true);
																						$max_val = get_post_meta($field, 'imic_plugin_range_max_value', true);
																						$steps = get_post_meta($field, 'imic_plugin_range_steps', true);
																						$min_val = ($min_val!='')?$min_val:0;
																						$max_val = ($max_val!='')?$max_val:100000;
																						$steps = ($steps!='')?$steps:1000;
																					}
																					else
																					{
																						$spec_slug = "range_".imic_the_slug($field);
																						$min_val = get_post_meta($field, 'imic_plugin_range_min_value', true);
																						$max_val = get_post_meta($field, 'imic_plugin_range_max_value', true);
																						$steps = get_post_meta($field, 'imic_plugin_range_steps', true);
																						$min_val = ($min_val!='')?$min_val:0;
																						$max_val = ($max_val!='')?$max_val:100000;
																						$steps = ($steps!='')?$steps:1000;
																					}
																				}
																				elseif($int==2)
																				{
																					$spec_slug = "char_".imic_the_slug($field); 
																				}
																				$get_child = (imic_get_child_values_status($specs)==1)?'get-child-field':'';
																				echo '<div class="col-md-3 col-sm-3">';
																				if($int==1&&$numeric_specs_type==0)
																				{ ?>
																					<b><?php echo esc_attr(get_the_title($field)); echo ' '.$value_label; ?> 
																						<input class="search-range" type="hidden" name="<?php echo esc_attr($spec_slug); ?>" value="">
																						<!-- <span class="left"><?php echo esc_attr($min_val); ?></span> -  -->
																						<!-- <span class="right"><?php echo esc_attr($max_val); ?></span></b>  -->
																						<div class="hidden-slider" style="display:none;"><input id="ex2" type="text" class="span2" value="" data-slider-min="<?php echo esc_attr($min_val); ?>" data-slider-max="<?php echo esc_attr($max_val); ?>" data-slider-step="<?php echo esc_attr($steps); ?>" data-slider-value="[<?php echo esc_attr($min_val); ?>,<?php echo esc_attr($max_val); ?>]" data-imic-start="" data-imic-end=""/></div>
																						<input class="form-control" id="1" type="text" class="span2" value="" placeholder="Min"/> <input class="form-control" id="2" type="text" class="span2" value="" placeholder="Max"/>
																				<?php }
																				else
																				{
                                        	echo '<label>'.get_the_title($field).'</label>';
																				if(!imic_array_empty($specs)) 
																				{
                                       		echo '<select data-empty="true" id="field-'.($field+2648).'" name="'.esc_attr($spec_slug).'" class="form-control selectpicker '.$get_child.'">
                                        		<option disabled value="" selected>'.__('Any','framework').'</option>';
																					foreach($specs as $spec) 
																					{
																						echo '<option value="'.esc_attr($spec['imic_plugin_specification_values']).'">'.esc_attr($spec['imic_plugin_specification_values']).'</option>';
																					}
                                       		echo '</select>';
																				}
																				else 
																				{
																					echo '<input type="text" name="'.esc_attr($spec_slug).'" value="" class="form-control">';
																				}
																				}
                                     		echo '</div>';
																				if(imic_get_child_values_status($specs)==1) 
																				{
																					//echo "saibaba";
																					$child_label = get_post_meta($field,'imic_plugin_sub_field_label',true);
																					echo '<div class="col-md-3 col-sm-3" id="field-'.(($field*111)+2648).'">
                                          <label>'.$child_label.'</label>';
                                       		echo '<select data-empty="true" name="'.esc_attr($child_label).'" class="form-control selectpicker">
                                          <option disabled value="" selected>'.__('Select ','framework').get_the_title($field).'</option>';
                                       		echo '</select>';
																					echo '</div>';
																				}
																		endforeach; 
																	}
																	else 
																	{
																		echo '<div class="col-md-12">';
																		echo esc_attr_e('Please select search fields from Theme Options','framework');
																		echo '</div>';
																	}
																}
																else
																{
																	echo '<div class="col-md-3 col-sm-3">';
																	echo '<label>'.__('Enter Keyword', 'framework').'</label>';
																	echo '<input type="text" class="form-control" name="specification-search" placeholder="'.__('Keyword','framework').'">';
																	echo '</div>';
																	$listing_cats = get_terms('listing-category',array('parent' => 0,'number' => 10,'hide_empty' => false));
																	echo '<div class="col-md-3 col-sm-3" id="cat-1">';
																	echo '<label>'.__('Select Category').'</label>';
																	echo '<select data-page="" data-empty="true" name="list-cat" class="form-control selectpicker get-child-cat">';
																	echo '<option value="" selected disabled>'.__('Select','framework').'</option>';
																	foreach($listing_cats as $cat)
																	{
																		echo '<option value="'.$cat->slug.'">'.$cat->name.'</option>';
																	}
																	echo '</select>';
																	echo '</div>';
																	echo '<div id="child-field-loading" class="col-md-3 col-sm-3" style="display:none;">'.__('Loading Child Field...','framework').'</div>';
																}
							?>
                            </div>
                                    <div class="row">
                                    <div class="col-md-6">
                                    </div>
                                        <div class="col-md-6">
                                            <input type="submit" class="btn btn-block btn-info btn-lg" value="<?php echo esc_attr_e('Find my vehicle now','framework'); ?>">
                                        </div>
                                    </div>
                        </form>
                    </div>
                </div>