<?php
/*** Widget code for Enquiry Form ***/
class imic_enquiry_form extends WP_Widget {
	// constructor
	function imic_enquiry_form() {
		 $widget_ops = array('description' => __( "Enquiry form", 'imic-framework-admin') );
         parent::__construct(false, $name = __('Enquiry Form Widget','imic-framework-admin'), $widget_ops);
	}
	// widget form creation
	function form($instance) {
	    // Check values
                if( $instance) {
			 $title = esc_attr($instance['title']);
			 $subject = esc_attr($instance['subject']);
		} else {
			 $title = '';
			 $subject = '';
		}
	?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php echo esc_attr_e('Title', 'imic-framework-admin'); ?></label>
            <input class="spTitle_<?php echo esc_attr($title); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('subject')); ?>"><?php echo esc_attr_e('Subject', 'imic-framework-admin'); ?></label>
            <input class="spTitle_<?php echo esc_attr($subject); ?>" id="<?php echo esc_attr($this->get_field_id('subject')); ?>" name="<?php echo esc_attr($this->get_field_name('subject')); ?>" type="text" value="<?php echo esc_attr($subject); ?>" />
        </p>
	<?php
	}
	// update widget
	function update($new_instance, $old_instance) {
		  $instance = $old_instance;
                // Fields
		  $instance['title'] = strip_tags($new_instance['title']);
		  $instance['subject'] = strip_tags($new_instance['subject']);
		  return $instance;
	}
	// display widget
	function widget($args, $instance) {
	   extract( $args );
           
	   // these are the widget options
	   $post_title = apply_filters('widget_title', $instance['title']);
	   $post_title = ($post_title=='')?__('Latest Added','imic-framework-admin'):$post_title;
	   $email_subject = apply_filters('widget_title', $instance['title']);
	   $email_subject = ($email_subject=='')?__('Enquiry Form','imic-framework-admin'):$email_subject;
	   echo $args['before_widget'];
	   global $imic_options;
	   if( !empty($instance['title']) ){
			echo $args['before_title'];
			echo apply_filters('widget_title',$post_title, $instance, $this->id_base);
			echo $args['after_title'];
		}
	   echo '<div class="vehicle-enquiry-in">
                                    <form name="enquiry-form" class="enquiry-vehicle">
										<input type="hidden" name="email_content" value="enquiry_form">
										<input type="hidden" name="Subject" id="subject" value="'.esc_attr($email_subject).'">
										<input type="hidden" name="Vehicle_ID" value="'.esc_attr(get_the_ID()).'">
                                        <input type="text" name="Name" id="name" placeholder="'.__('Name','framework').'*" class="form-control" required>
                                        <input type="email" name="Email" id="Email" placeholder="'.__('Email address','framework').'*" class="form-control" required>
                                        <div class="row">
                                            <div class="col-md-7"><input type="text" name="Phone" id="phone" placeholder="'.__('Phone no.','framework').'*" class="form-control" required></div>
                                            <div class="col-md-5"><input type="text" name="Zip Code" id="zip" placeholder="'.__('Zip','framework').'*" class="form-control" required></div>
                                        </div>
                                        <textarea name="comments" name="Comments" id="comments" class="form-control" placeholder="'.__('Your comments','framework').'"></textarea>
                                        <!--<label class="checkbox-inline">
                                            <input type="checkbox" name="Newsletter" id="newsletter" value="1"> '.__('Subscribe To','framework').' <strong>'.get_bloginfo('name').' '.__('Newsletter','framework').'</strong>
                                        </label>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="remember" id="remember" value="1"> '.__('Remember my details','framework').'
                                        </label>-->
                                        <input type="submit" class="btn btn-primary" value="'.__('Submit','framework').'">
										<div class="message"></div>
                                    </form>
                                </div>';
	   echo $args['after_widget'];
	}
}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("imic_enquiry_form");'));
?>