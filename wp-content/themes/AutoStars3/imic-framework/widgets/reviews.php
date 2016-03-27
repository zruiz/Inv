<?php
/*** Widget code for Reviews ***/
class imic_reviews extends WP_Widget {
	// constructor
	function imic_reviews() {
		 $widget_ops = array('description' => __( "Show Reviews.", 'imic-framework-admin') );
         parent::__construct(false, $name = __('Reviews','imic-framework-admin'), $widget_ops);
	}
	// widget form creation
	function form($instance) {
	    // Check values
                if( $instance) {
			 $title = esc_attr($instance['title']);
			 $number = esc_attr($instance['number']);
			 $date = esc_attr($instance['date']);
		} else {
			 $title = '';
           $number='';
		   $date = '';
		}
	?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php echo esc_attr_e('Title', 'imic-framework-admin'); ?></label>
            <input class="spTitle_<?php echo esc_attr($title); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php echo esc_attr_e('Number', 'imic-framework-admin'); ?></label>
            <input class="spTitle_<?php echo esc_attr($number); ?>" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('date')); ?>"><?php echo esc_attr_e('Show Date', 'imic-framework-admin'); ?></label>
            <select class="spType_event_cat" id="<?php echo esc_attr($this->get_field_id('date')); ?>" name="<?php echo esc_attr($this->get_field_name('date')); ?>">
            <option <?php echo ($date=="yes")?"selected":''; ?> value="yes"><?php echo esc_attr_e('Yes','imic-framework-admin'); ?></option>
            <option <?php echo ($date=="no")?"selected":''; ?> value="no"><?php echo esc_attr_e('No','imic-framework-admin'); ?></option>
            </select> 
        </p> 
	<?php
	}
	// update widget
	function update($new_instance, $old_instance) {
		  $instance = $old_instance;
                // Fields
		  $instance['title'] = strip_tags($new_instance['title']);
		  $instance['number'] = strip_tags($new_instance['number']);
		  $instance['date'] = strip_tags($new_instance['date']);
		  return $instance;
	}
	// display widget
	function widget($args, $instance) {
	   extract( $args );
           
	   // these are the widget options
	   $post_title = apply_filters('widget_title', $instance['title']);
	   $post_title = ($post_title=='')?__('Latest Added','imic-framework-admin'):$post_title;
	   $number = apply_filters('widget-number', $instance['number']);
	   $date = apply_filters('widget-date', $instance['date']);
	   echo $args['before_widget'];
	   global $imic_options;
	   if( !empty($instance['title']) ){
			echo $args['before_title'];
			echo apply_filters('widget_title',$post_title, $instance, $this->id_base);
			echo $args['after_title'];
		}
		$args_post = array('post_type'=>'post','posts_per_page'=>$number,"post__not_in"	 =>	get_option("sticky_posts"),'meta_query'=>array(array('key'=>'imic_select_post_section','value'=>'0','comapre'=>'=')));
		$post_listing = new WP_Query( $args_post );
		if ( $post_listing->have_posts() ) :
		while ( $post_listing->have_posts() ) :	
		$post_listing->the_post();
		$rating = get_post_meta(get_the_ID(), 'imic_post_review', false);
		$review = get_post_meta(get_the_ID(),'imic_select_post_section',true);
		if($review==0) {
		$total_rating = '';
		$total_count = count($rating[0]);
		foreach ($rating[0] as $rate) {
			$total_rating += $rate[0];
		} $rates = ($total_rating/$total_count);
	   	echo '<div class="post-block post-review-block">
                                <div class="review-status">
                                    <strong>'. number_format((float)$rates, 1, '.', '').'</strong>
                                    <span>'.__('Out of 5','framework').'</span>
                                </div>
                                <h3 class="post-title"><a href="'.esc_url(get_permalink()).'">'.get_the_title().'</a></h3>';
								if($date=="yes") {
								echo '<div class="post-content">
                                        <div class="post-actions">
                                        	<div class="post-date">'.esc_attr(get_the_date(get_option('date_format'))).'</div>
                                        </div>
                                    </div>'; }
                            echo '</div>'; }
		endwhile; endif; wp_reset_postdata();
	   echo $args['after_widget'];
	}
}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("imic_reviews");'));
?>