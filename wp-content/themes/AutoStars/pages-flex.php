<?php 
wp_enqueue_script('imic_jquery_flexslider');
global $imic_options,$id;
$type = get_post_meta($id,'imic_pages_Choose_slider_display',true);
$pagination = get_post_meta($id,'imic_pages_slider_pagination',true);
$autoplay = get_post_meta($id,'imic_pages_slider_auto_slide',true);
$arrows = get_post_meta($id,'imic_pages_slider_direction_arrows',true);
$effects = get_post_meta($id,'imic_pages_slider_effects',true);
if($type==1 || $type==2 || $type==3) {
	$height = get_post_meta($id,'imic_pages_slider_height',true);
} else {
	$height = '';
}
$images = get_post_meta($id,'imic_pages_slider_image',false);
$position = (isset($imic_options['search_position']))?$imic_options['search_position']:'';
?><div class="hero-area" style="height:<?php echo esc_attr($height).'px' ?>; display:block;">
<?php if($position==2) {
	$listing_url = imic_get_template_url("template-listing.php");
$listing_id = imic_get_template_id('template-listing.php');
$search_fields = (isset($imic_options['search_form']))?$imic_options['search_form']:array(); ?>
<!-- Search Form -->
        <div class="floated">
            <div class="search-form">
          		<h2><?php echo esc_attr_e('Looking for a yacht?','framework'); ?></h2>
                <p><?php echo esc_attr_e('Our range of yachts is capable of finding every possible match you like to buy.','framework'); ?></p>
                <div class="search-form-inner">
                    <form method="get" action="<?php echo esc_url($listing_url); ?>" class="searchoneform">
                    <input type="hidden" value="<?php echo esc_attr($listing_id); ?>" name="page_id">
                    	<div class="input-group input-group-lg">
      						<input type="text" class="form-control" name="specification-search" placeholder="<?php echo esc_attr_e('Enter shipyard, model, year..','framework'); ?>">
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
									foreach($search_fields as $field):
										$specs = get_post_meta($field,'specifications_value',true);
										$int = get_post_meta($field,'imic_plugin_spec_char_type',true);
										if($int==0) {
										$spec_slug = imic_the_slug($field); }
										else {
										$spec_slug = "int_".imic_the_slug($field); }
										$get_child = (imic_get_child_values_status($specs)==1)?'get-child-field':'';
										echo '<div class="col-md-3 col-sm-3">
                                            <label>'.get_the_title($field).'</label>';
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
                                     	echo '</div>';
										if(imic_get_child_values_status($specs)==1) {
											//echo "saibaba";
											$child_label = get_post_meta($field,'imic_plugin_sub_field_label',true);
											echo '<div class="col-md-3 col-sm-3" id="field-'.(($field*111)+2648).'">
                                            <label>'.$child_label.'</label>';
                                       	echo '<select data-empty="true" name="'.esc_attr($child_label).'" class="form-control selectpicker">
                                                <option disabled value="" selected>'.__('Select ','framework').get_the_title($field).'</option>';
                                       	echo '</select>';
										echo '</div>';
										}
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
<?php } if(!empty($images)) { ?>
<div class="hero-slider heroflex flexslider clearfix" style="height:<?php echo esc_attr($height).'px' ?>;" data-autoplay="<?php echo esc_attr($autoplay); ?>" data-pagination="<?php echo esc_attr($pagination); ?>" data-arrows="<?php echo esc_attr($arrows); ?>" data-style="<?php echo esc_attr($effects); ?>" data-speed="7000" data-pause="yes">
      	<ul class="slides">
        <?php foreach($images as $image) {
			$image_src = wp_get_attachment_image_src( $image, 'full', '', array() ); ?>
        	<li class=" parallax" style="background-image:url(<?php echo esc_url($image_src[0]); ?>); height:<?php echo esc_attr($height).'px' ?>;">
            <div class="flex-caption" data-appear-animation="fadeInRight" data-appear-animation-delay="500">
            <?php $image_data = imic_wp_get_attachment($image); ?>
                	<strong><?php echo esc_attr($image_data['caption']); ?></strong>
                	<p><?php echo esc_attr($image_data['description']); ?></p>
               	</div>
            </li>
			<?php } ?>
            </ul>
    </div><?php } ?></div>
    <!-- End Page Header -->