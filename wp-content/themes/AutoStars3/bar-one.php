<?php global $id, $imic_options;
$spec_browse = get_post_meta($id,'imic_browse_by_specification',true);
$browse_listing = imic_get_template_url('template-listing.php');
$auto_scroll = get_post_meta($id,'imic_browse_by_auto_scroll',true);
$scroll_speed = get_post_meta($id,'imic_browse_by_auto_scroll_speed',true);
$scroll_speed = ($scroll_speed=='')?5000:$scroll_speed;
$scroll = ($auto_scroll==1)?$scroll_speed:''; ?>
<!-- Utiity Bar -->
    <div class="utility-bar">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-4 col-sm-6">
                <?php 
						if(!empty($spec_browse)) {
						$specification_img = get_post_meta($spec_browse,'specifications_value',true);
						$browse_title = get_post_meta($id,'imic_browse_by_specification_title',true);
						$spec_int = get_post_meta($spec_browse,'imic_plugin_spec_char_type',true);
						if($spec_int==0) {
						$slug = imic_the_slug($spec_browse); }
						elseif($spec_int==1) {
          	$slug = "int_".imic_the_slug($spec_browse); }
         		else
       			{
           		$slug = "char_".imic_the_slug($spec_browse);
         		}
				?>
                	<div class="toggle-make">
                		<a href="#"><i class="fa fa-navicon"></i></a>
                    	<span><?php echo esc_attr($browse_title); ?></span>
                    </div><?php } ?>
                </div>
            	<div class="col-md-8 col-sm-6">
	<?php imic_share_buttons(); ?>
                </div>
          	</div>
      	</div>
        <?php if(!empty($specification_img)) { ?>
    	<div class="by-type-options">
    		<div class="container">
               	<div class="row">
                  	<ul class="owl-carousel carousel-alt" data-columns="6" data-autoplay="<?php echo esc_attr($scroll); ?>" data-pagination="no" data-arrows="yes" data-single-item="no" data-items-desktop="6" data-items-desktop-small="4" data-items-mobile="3" data-items-tablet="4" <?php if(isset($imic_options['enable_rtl']) && $imic_options['enable_rtl']== 1){ ?>data-rtl="rtl"<?php } else { ?> data-rtl="ltr" <?php } ?>>
                    <?php foreach($specification_img as $img) {
						$speci_value = $img['imic_plugin_specification_values'];
						$go_val = imic_encode_spaces($speci_value); ?>
                    	<li class="item"> <a href="<?php echo esc_url(add_query_arg($slug, $go_val,$browse_listing)); ?>"><?php if($img['imic_plugin_specification_values']!='') { ?><img src="<?php echo esc_url($img['imic_plugin_spec_image']); ?>" alt=""><?php } ?> <span><?php echo esc_attr($img['imic_plugin_specification_values']); ?></span></a></li>
                  	<?php } ?>
                  	</ul>
               	</div>
            </div>
		</div><?php } ?>
    </div>
    <?php if($imic_options['search_position']==1) { echo get_template_part('search','one'); } ?>