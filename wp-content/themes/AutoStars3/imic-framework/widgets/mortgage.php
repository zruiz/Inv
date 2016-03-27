<?php
/*** Widget code for Mortgage Calculator ***/
class imic_mortgage extends WP_Widget {
	// constructor
	function imic_mortgage() {
		 $widget_ops = array('description' => __( "Mortgage Calculator.", 'imic-framework-admin') );
         parent::__construct(false, $name = __('Calculate Loan','imic-framework-admin'), $widget_ops);
	}
	// widget form creation
	function form($instance) {
	    // Check values
                if( $instance) {
			 $title = esc_attr($instance['title']);
			 $currency = esc_attr($instance['currency']);
		} else {
			 $title = $currency = '';
		}
	?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php echo esc_attr_e('Title', 'imic-framework-admin'); ?></label>
            <input class="spTitle_<?php echo esc_attr($title); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('currency')); ?>"><?php echo esc_attr_e('Currency Symbol', 'imic-framework-admin'); ?></label>
            <input class="spTitle_<?php echo esc_attr($currency); ?>" id="<?php echo esc_attr($this->get_field_id('currency')); ?>" name="<?php echo esc_attr($this->get_field_name('currency')); ?>" type="text" value="<?php echo esc_attr($currency); ?>" />
        </p>
	<?php
	}
	// update widget
	function update($new_instance, $old_instance) {
		  $instance = $old_instance;
                // Fields
		  $instance['title'] = strip_tags($new_instance['title']);
		  $instance['currency'] = strip_tags($new_instance['currency']);
		  return $instance;
	}
	// display widget
	function widget($args, $instance) {
	   extract( $args );
           
	   // these are the widget options
	   $post_title = apply_filters('widget_title', $instance['title']);
	   $post_title = ($post_title=='')?__('Latest Added','imic-framework-admin'):$post_title;
	   $currency_symbol = (isset($instance['currency']))?$instance['currency']:'';
	   $currency_symbol = ($currency_symbol=='')?'$':$currency_symbol;
	   echo $args['before_widget'];
	   global $imic_options;
	   if( !empty($instance['title']) ){
			echo $args['before_title'];
			echo apply_filters('widget_title',$post_title, $instance, $this->id_base);
			echo $args['after_title'];
		}
		wp_localize_script('imic_jquery_init','mortgage',array('currency'=>$currency_symbol));
	   echo '<form>
                                    <div class="loan-calculations">
                                        <input type="text" class="form-control" id="loan-amount" placeholder="'.__('Loan amount','framework').'">
                                        <div class="form-group">
                                            <label>'.__('Loan term in months','framework').'</label>
                                            <div class="btn-group" data-toggle="buttons">
                                                <label class="btn btn-info calculate-loan" id="24">
                                                  	<input type="radio" name="Loan Tenure" autocomplete="off"> 24
                                                </label>
                                                <label class="btn btn-info calculate-loan" id="36">
                                                  	<input type="radio" name="Loan Tenure" autocomplete="off"> 36
                                                </label>
                                                <label class="btn btn-info calculate-loan" id="48">
                                                  	<input type="radio" name="Loan Tenure" autocomplete="off"> 48
                                                </label>
                                                <label class="btn btn-info calculate-loan" id="60">
                                                  	<input type="radio" name="Loan Tenure" autocomplete="off"> 60
                                                </label>
                                           	</div>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="down-payment" class="form-control" placeholder="'.__('Down payment','framework').'">
                                            <input type="text" id="interest-rate" class="form-control" placeholder="'.__('Rate of Interest eg.10','framework').'%">
                                        </div>
									<div id="message"></div>
                                    </div>
                                    <div class="calculations-result" id="result-loan-amount">';
										esc_attr_e('Results','framework');
                                    echo '</div>
                                </form>';
	   echo $args['after_widget'];
	}
}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("imic_mortgage");'));
?>