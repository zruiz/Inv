<?php
/*** Widget code for Cars ***/
class imic_cars extends WP_Widget {
	// constructor
	function imic_cars() {
		 $widget_ops = array('description' => __( "Show listings.", 'imic-framework-admin') );
         parent::__construct(false, $name = __('Cars','imic-framework-admin'), $widget_ops);
	}
	// widget form creation
	function form($instance) {
	    // Check values
                if( $instance) {
			 $title = esc_attr($instance['title']);
			 $category = esc_attr($instance['category']);
			 $number = esc_attr($instance['number']);
		} else {
			 $title = '';
           $category='';
		   $number = '';
		}
	?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php echo esc_attr_e('Title', 'imic-framework-admin'); ?></label>
            <input class="spTitle_<?php echo esc_attr($title); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
       
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('category')); ?>"><?php echo esc_attr_e('Select Category', 'imic-framework-admin'); ?></label>
            <select class="spType_event_cat" id="<?php echo esc_attr($this->get_field_id('category')); ?>" name="<?php echo esc_attr($this->get_field_name('category')); ?>">
            <option <?php echo ($category=="1")?"selected":''; ?> value="1"><?php echo esc_attr_e('Recent','imic-framework-admin'); ?></option>
            <option <?php echo ($category=="2")?"selected":''; ?> value="2"><?php echo esc_attr_e('Sold','imic-framework-admin'); ?></option>
            </select> 
        </p> 
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php echo esc_attr_e('Number', 'imic-framework-admin'); ?></label>
            <input class="spTitle_<?php echo esc_attr($number); ?>" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
        </p>
	<?php
	}
	// update widget
	function update($new_instance, $old_instance) {
		  $instance = $old_instance;
                // Fields
		  $instance['title'] = strip_tags($new_instance['title']);
		  $instance['category'] = strip_tags($new_instance['category']);
		  $instance['number'] = strip_tags($new_instance['number']);
		  return $instance;
	}
	// display widget
	function widget($args, $instance) {
	   extract( $args );
           
	   // these are the widget options
	   $post_title = apply_filters('widget_title', $instance['title']);
	   $post_title = ($post_title=='')?__('Latest Added','imic-framework-admin'):$post_title;
       $category = apply_filters('widget-category', empty($instance['category']) ?'': $instance['category'], $instance, $this->id_base);
	   $number = apply_filters('widget-number', $instance['number']);
	   echo $args['before_widget'];
	   global $imic_options;
	   if( !empty($instance['title']) ){
			echo $args['before_title'];
			echo apply_filters('widget_title',$post_title, $instance, $this->id_base);
			echo $args['after_title'];
		}
		if(isset($imic_options['enable_rtl']) && $imic_options['enable_rtl']== 1){ $DIR = 'data-rtl="rtl"';} else { $DIR = 'data-rtl="ltr"'; }
	   echo '
                            <div class="carousel-wrapper">
                                <div class="row">
                                    <ul class="owl-carousel single-carousel" id="vehicle-slider" data-columns="1" data-autoplay="" data-pagination="no" data-arrows="no" data-single-item="no" data-items-desktop="1" data-items-desktop-small="1" data-items-tablet="2" data-items-mobile="1" '.$DIR.'>';
										$badges_type = (isset($imic_options['badges_type']))?$imic_options['badges_type']:'0';
										$specification_type = (isset($imic_options['short_specifications']))?$imic_options['short_specifications']:'0';
										if($badges_type=="0")
										{
                                       		$badge_ids = $imic_options['badge_specs'];
										}
										else
										{
											$badge_ids = array();
										}
										$img_src = '';
										if($specification_type==0)
										{
											$detailed_specs = (isset($imic_options['specification_list']))?$imic_options['specification_list']:array();
										}
										else
										{
											$detailed_specs = array();
										}
										$additional_specs = (isset($imic_options['additional_specs']))?$imic_options['additional_specs']:'';
										//$detailed_specs = $imic_options['vehicle_specs'];
										$additional_specs_all = get_post_meta($additional_specs,'specifications_value',true);
										$highlighted_specs = (isset($imic_options['highlighted_specs']))?$imic_options['highlighted_specs']:'';
										$unique_specs = $imic_options['unique_specs'];	
										$listing_page_url = imic_get_template_url('template-listing.php');
										$args_cars = array('post_type'=>'cars','posts_per_page'=>$number,'post_status'=>'publish','meta_query'=>array(array('key'=>'imic_plugin_ad_payment_status','value'=>$category,'compare'=>'=')));
										$cars_listing = new WP_Query( $args_cars );
										if ( $cars_listing->have_posts() ) :
										while ( $cars_listing->have_posts() ) :	
										$cars_listing->the_post();
										if(is_plugin_active("imi-classifieds/imi-classified.php")) 
										{
											$badge_ids = imic_classified_badge_specs(get_the_ID(), $badge_ids);
											$detailed_specs = imic_classified_short_specs(get_the_ID(), $detailed_specs);
										}
										$post_author_id = get_post_field( 'post_author', get_the_ID() );
										$user_info_id = get_user_meta($post_author_id,'imic_user_info_id',true);
										$author_role = get_option('blogname');
										if(!empty($user_info_id)) {
										$term_list = wp_get_post_terms($user_info_id, 'user-role', array("fields" => "names"));
										if(!empty($term_list)) {
										$author_role = $term_list[0]; }
										else { $author_role = get_option('blogname'); }
										}
										$specifications = get_post_meta(get_the_ID(),'feat_data',true);
										$unique_value = imic_vehicle_price(get_the_ID(),$unique_specs,$specifications);
										$new_highlighted_specs = imic_filter_lang_specs_admin($highlighted_specs, get_the_ID());	
										$highlighted_specs = $new_highlighted_specs;
										$highlight_value = imic_vehicle_title(get_the_ID(),$highlighted_specs,$specifications);
										$highlight_value = ($highlight_value!='')?$highlight_value:get_the_title();
										$details_value = imic_vehicle_all_specs(get_the_ID(),$detailed_specs,$specifications);
										$data_ser_type = (get_option('imic_specifications_upd_st')!=1)?0:get_option('imic_specifications_upd_st');
										if(!empty($additional_specs)) {
										if($data_ser_type=="0")
											{
												$image_key = array_search($additional_specs, $specifications['sch_title']);
												$additional_specs_value = $specifications['start_time'][$image_key];
											}
											else
											{
												 $img_char = imic_the_slug($additional_specs);
												 $additional_specs_value = get_post_meta(get_the_ID(), 'char_'.$img_char, true);
											}
										$this_key = find_car_with_position($additional_specs_all,$additional_specs_value);
										$img_src = $additional_specs_all[$this_key]['imic_plugin_spec_image']; }
										
										?>
                                    <li class="item">
                                        <div class="vehicle-block format-standard">
                                        <?php if(has_post_thumbnail()) {
											if($category==1) { ?>
                                            <a href="<?php echo esc_url(get_permalink()); ?>" class="media-box"><?php the_post_thumbnail('600x400'); ?></a><?php } else { ?><a href="javascript:void(0);" class="media-box"><?php the_post_thumbnail('600x400'); ?></a><?php } } ?>
                                            <div class="vehicle-block-content">
                                            <?php if($category==1) { ?>
                                                <h5 class="vehicle-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_attr($highlight_value); ?></a></h5><?php } else { ?>
                                                <h5 class="vehicle-title"><?php echo esc_attr($highlight_value); ?></h5><?php } ?><span class="vehicle-meta"><?php if(!empty($details_value)) { foreach($details_value as $value) { echo esc_attr($value).', '; } } echo esc_attr_e(' by ','framework'); ?><abbr class="user-type" title="<?php echo esc_attr_e('Listed by','framework'); echo esc_attr($author_role); ?>"><?php echo esc_attr($author_role); ?></abbr></span>
                                                <?php if($img_src!='') { ?>
                                                <a href="<?php echo esc_url($listing_page_url); ?>" title="<?php echo esc_attr_e('View all ','framework'); echo esc_attr($additional_specs_all[$this_key]['imic_plugin_specification_values']); ?>" class="vehicle-body-type"><img src="<?php echo esc_url($additional_specs_all[$this_key]['imic_plugin_spec_image']); ?>" alt=""></a><?php } ?>
                                                <span class="vehicle-cost"><?php echo esc_attr($unique_value); ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <?php endwhile; endif; wp_reset_postdata();
                                    echo '</ul>
                                </div>
                            </div>';
	   echo $args['after_widget'];
	}
}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("imic_cars");'));
?>