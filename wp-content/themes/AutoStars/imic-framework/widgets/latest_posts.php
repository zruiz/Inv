<?php
/*** Widget code for Latest Posts ***/
class imic_latest_posts extends WP_Widget {
	// constructor
	function imic_latest_posts() {
		 $widget_ops = array('description' => __( "Show Recent Posts.", 'imic-framework-admin') );
         parent::__construct(false, $name = __('Latest Posts','imic-framework-admin'), $widget_ops);
	}
	// widget form creation
	function form($instance) {
	    // Check values
                if( $instance) {
			 $title = esc_attr($instance['title']);
			 $number = esc_attr($instance['number']);
		} else {
			 $title = '';
           $number='';
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
	<?php
	}
	// update widget
	function update($new_instance, $old_instance) {
		  $instance = $old_instance;
                // Fields
		  $instance['title'] = strip_tags($new_instance['title']);
		  $instance['number'] = strip_tags($new_instance['number']);
		  return $instance;
	}
	// display widget
	function widget($args, $instance) {
	   extract( $args );
           
	   // these are the widget options
	   $post_title = apply_filters('widget_title', $instance['title']);
	   $post_title = ($post_title=='')?__('Recent Posts','imic-framework-admin'):$post_title;
	   $number = apply_filters('widget-number', $instance['number']);
	   echo $args['before_widget'];
	   global $imic_options;
	   if( !empty($instance['title']) ){
			echo $args['before_title'];
			echo apply_filters('widget_title',$post_title, $instance, $this->id_base);
			echo $args['after_title'];
		}
		$args_post = array('post_type'=>'post','posts_per_page'=>$number);
		$post_listing = new WP_Query( $args_post );
		if ( $post_listing->have_posts() ) :
		echo '<ul>';
		while ( $post_listing->have_posts() ) :	
		$post_listing->the_post();
	   	echo '<li>
                                	<a href="'.esc_url(get_permalink()).'">'.get_the_post_thumbnail(get_the_ID(),'210x210').'</a>
                                    <h5><a href="'.esc_url(get_permalink()).'">'.get_the_title().'</a></h5>
                                    <div class="post-actions"><div class="post-date">'.esc_attr(get_the_date(get_option('date_format'))).'</div></div>
                                </li>';
		endwhile; 
		echo '</ul>';
		endif; wp_reset_postdata();
	   echo $args['after_widget'];
	}
}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("imic_latest_posts");'));
?>