<?php global $imic_options,$id;
$rev_slider = get_post_meta($id,'imic_pages_select_revolution_from_list',true);
$rev_slider = preg_replace('/\\\\/', '', $rev_slider);
$position = (isset($imic_options['search_position']))?$imic_options['search_position']:''; ?>
<?php if($position==2) {
	$listing_url = imic_get_template_url("template-listing.php");
$listing_id = imic_get_template_id('template-listing.php');
$search_fields = (isset($imic_options['search_form']))?$imic_options['search_form']:array(); ?>
<!-- Search Form -->
        <div class="floated">
            <div class="search-form">
          		<h2><?php echo esc_attr_e('Looking for a used or new listing?','framework'); ?></h2>
                <p><?php echo esc_attr_e('Our range of yachts is capable of finding every possible match you like to buy.','framework'); ?></p>
                <div class="search-form-inner">
                    <form method="get" action="<?php echo esc_url($listing_url); ?>">
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
									foreach($search_fields as $field):
										$specs = get_post_meta($field,'specifications_value',true);
										$int = get_post_meta($field,'imic_plugin_spec_char_type',true);
										if($int==0) {
										$spec_slug = imic_the_slug($field); }
										else {
										$spec_slug = "int_".imic_the_slug($field); }
										echo '<div class="col-md-3">
                                            <label>'.get_the_title($field).'</label>';
                                            if(!imic_array_empty($specs)) {
                                       	echo '<select data-empty="true" name="'.esc_attr($spec_slug).'" class="form-control selectpicker">
                                                <option disabled value="" selected>'.__('Any','framework').'</option>';
												foreach($specs as $spec) {
													echo '<option value="'.esc_attr($spec['imic_plugin_specification_values']).'">'.esc_attr($spec['imic_plugin_specification_values']).'</option>';
												}
                                       	echo '</select>'; }
										else {
											echo '<input type="text" name="'.esc_attr($spec_slug).'" value="" class="form-control">';
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
<div class="page-header parallax clearfix" style="height:auto">

      <div class="slider-rev-cont">
            <div class="tp-limited">
            <?php echo do_shortcode($rev_slider); ?>
            </div>
		</div>
	
</div>