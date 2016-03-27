<?php 
global $imic_options,$id;
$pagination = get_post_meta($id,'imic_pages_slider_pagination',true);
$autoplay = get_post_meta($id,'imic_pages_slider_auto_slide',true);
$arrows = get_post_meta($id,'imic_pages_slider_direction_arrows',true);
$height = get_post_meta($id,'imic_pages_slider_height',true);
$slider_height = ($height!='')?$height:'';
$images = get_post_meta($id,'imic_pages_slider_image',false);
$position = (isset($imic_options['search_position']))?$imic_options['search_position']:'';
if(!empty($images)) {
?>
<div class="hero-area">
<?php if($position==2) {
	$listing_url = imic_get_template_url("template-listing.php");
$listing_id = imic_get_template_id('template-listing.php');
$search_fields = (isset($imic_options['search_form']))?$imic_options['search_form']:array();
$numeric_specs_type = (isset($imic_options['integer_specs_type']))?$imic_options['integer_specs_type']:0; ?>
<!-- Search Form -->
        <div class="floated">
            <div class="search-form">
          		<h2><?php echo esc_attr_e('Looking for a used or new listing?','framework'); ?></h2>
                <p><?php echo esc_attr_e('Our range of vehicles is capable of finding every possible car you like to buy.','framework'); ?></p>
                <div class="search-form-inner">
                    <form method="get" action="<?php echo esc_url($listing_url); ?>" class="searchoneform">
                    <input type="hidden" value="<?php echo esc_attr($listing_id); ?>" name="page_id">
                    	<div class="input-group input-group-lg">
      						<input type="text" value="" class="form-control" name="specification-search" placeholder="<?php echo esc_attr_e('Enter zip, model, make..','framework'); ?>">
                        	<span class="input-group-btn">
        						<button class="btn btn-primary" type="submit"><?php echo esc_attr_e('Search','framework'); ?></button>
      						</span>
                        </div>
                        <?php if(!empty($search_fields)) { ?>
                        <a href="#" class="search-advanced-trigger"><?php echo esc_attr_e('Advanced Search','framework'); ?> <i class="fa fa-arrow-down"></i></a><?php } ?>
                        <div class="row advanced-search-row">
                            <?php $count = 1;
									if(!empty($search_fields)) {
									$new_search_fields = imic_filter_lang_specs($search_fields);
									foreach($new_search_fields as $field):
										$specs = get_post_meta($field,'specifications_value',true);
										$int = get_post_meta($field,'imic_plugin_spec_char_type',true);
										$value_label = get_post_meta($field, 'imic_plugin_value_label', true);
										if($int==0) 
										{
											$spec_slug = imic_the_slug($field); 
										}
										elseif($int==1)
										{
											if($numeric_specs_type==0)
											{
												$spec_slug = "int_".imic_the_slug($field);
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
										if($int==1)
										{ ?>
											<b><?php echo esc_attr(get_the_title($field)); echo ' '.$value_label; ?> <input class="search-range" type="hidden" name="<?php echo esc_attr($spec_slug); ?>" value=""><span class="left"><?php echo esc_attr($min_val); ?></span> - 
<span class="right"><?php echo esc_attr($max_val); ?></span></b> <input id="ex2" type="text" class="span2" value="" data-slider-min="<?php echo esc_attr($min_val); ?>" data-slider-max="<?php echo esc_attr($max_val); ?>" data-slider-step="<?php echo esc_attr($steps); ?>" data-slider-value="[<?php echo esc_attr($min_val); ?>,<?php echo esc_attr($max_val); ?>]" data-imic-start="" data-imic-end=""/>
										<?php }
										else
										{
                                            echo '<label>'.get_the_title($field).'</label>';
										if(!imic_array_empty($specs)) {
                                       	echo '<select data-empty="true" id="field-'.($field+2648).'" name="'.esc_attr($spec_slug).'" class="form-control selectpicker '.$get_child.'">
                                                <option disabled value="" selected>'.__('Any','framework').'</option>';
												foreach($specs as $spec) {
													echo '<option value="'.esc_attr($spec['imic_plugin_specification_values']).'">'.esc_attr($spec['imic_plugin_specification_values']).'</option>';
												}
                                       	echo '</select>';
										
										}
										else {
											echo '<input type="text" name="'.esc_attr($spec_slug).'" value="" class="form-control">';
										}
										}
                                        echo '</div>';
										if($count++>3) { break; }
									endforeach; }
									else {
										echo '<div class="col-md-12">';
										echo esc_attr_e('Please select search fields from Theme Options','framework');
										echo '</div>';
									}
							?>
                        </div>
                    </form>
                </div>
            </div>
       	</div>
<?php } ?>
        <!-- Start Hero Carousel -->
        <ul class="owl-carousel carousel-alt" data-columns="1" data-autoplay="" data-pagination="no" data-arrows="<?php echo esc_attr($arrows); ?>" data-single-item="no" data-items-desktop="1" data-items-desktop-small="1" data-items-mobile="1" data-items-tablet="1" <?php if(isset($imic_options['enable_rtl']) && $imic_options['enable_rtl']== 1){ ?>data-rtl="rtl"<?php } else { ?> data-rtl="ltr" <?php } ?>>
         <?php foreach($images as $image):
		$attachment_meta = imic_wp_get_attachment($image);
		?>
    	<li class="item"><img src=" <?php echo esc_url($attachment_meta['src']); ?> " alt="" title="<?php echo esc_attr($attachment_meta['caption']); ?>"></li>
        <?php endforeach; ?>
        </ul>
        <!-- End Hero Carousel -->
   	</div>
<?php } ?>