<?php
/*** Widget code for Registration ***/
class imic_agent_registration extends WP_Widget {
	// constructor
	function imic_agent_registration() {
		 $widget_ops = array('description' => __( "Registration/Login Form.", 'imic-framework-admin') );
         parent::__construct(false, $name = __('Registration/Login','imic-framework-admin'), $widget_ops);
	}
	// widget form creation
	function form($instance) {
	    // Check values
                if( $instance) {
			 $title = esc_attr($instance['title']);
			 $type = esc_attr($instance['type']);
		} else {
			 $title = $type = '';
		}
	?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php echo esc_attr_e('Title', 'imic-framework-admin'); ?></label>
            <input class="spTitle_<?php echo esc_attr($title); ?>" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('type')); ?>"><?php echo esc_attr_e('Select', 'imic-framework-admin'); ?></label>
            <select class="spType_type" id="<?php echo esc_attr($this->get_field_id('type')); ?>" name="<?php echo esc_attr($this->get_field_name('type')); ?>">
            <option <?php echo ($type==1)?'selected':''; ?> value="1"><?php echo esc_attr_e('Registration','imic-framework-admin'); ?></option>
            <option <?php echo ($type==2)?'selected':''; ?> value="2"><?php echo esc_attr_e('Login','imic-framework-admin'); ?></option>
            </select> 
        </p> 
	<?php
	}
	// update widget
	function update($new_instance, $old_instance) {
		  $instance = $old_instance;
                // Fields
		  $instance['title'] = strip_tags($new_instance['title']);
		  $instance['type'] = strip_tags($new_instance['type']);
		  return $instance;
	}
	// display widget
	function widget($args, $instance) {
	   extract( $args );
       if ( !is_user_logged_in() ) {   
	   // these are the widget options
	   $post_title = apply_filters('widget_title', $instance['title']);
	   $post_title = ($post_title=='')?__('Create an account','imic-framework-admin'):$post_title;
	   $type = apply_filters('widget-type', empty($instance['type']) ?'': $instance['type'], $instance, $this->id_base);
	   echo $args['before_widget'];
	   if($type==1) {
	   wp_enqueue_script('imic_agent_register');
	   wp_localize_script('imic_agent_register','agent_register',array('ajaxurl'=>admin_url('admin-ajax.php')));
	   echo '<section class="signup-form sm-margint">';
	   echo '<div class="regular-signup">
       <h3>'.$post_title.'</h3>';
	   $user_role = get_terms('user-role',array('hide_empty'=>false));
	   echo '<form method="post" id="registerform" name="registerform" class="register-form">
       		<input type ="hidden" class ="redirect_register" name ="redirect_register" value =""/>';
			if(!empty($user_role)) {
			echo '<select name="user-role" id="user-role" class="form-control selectpicker">';
			foreach($user_role as $role) {
			echo '<option value="'.esc_attr($role->name).'">'.esc_attr($role->name).'</option>';
			}
			echo '</select>';
			}
            echo '<input type="text" name="username" id="username" class="form-control" placeholder="'. __('Username','framework').'">
           	<input type="email" name="email" id="email" class="form-control" placeholder="'.__('Email','framework').'">
           	<input type="password" name="pwd1" id="pwd1" class="form-control password-input" placeholder="'.__('Password','framework').'">
			<a href="javascript:void(0);" rel="0" class="password-show pass-actions"><i class="fa-eye-slash"></i></a>
			<a href="javascript:void(0);" class="password-generate pass-actions"><i class="fa fa-refresh"></i></a>
                                    <div class="progress"><div class="progress-bar password-output" style="width: 0%"></div></div>
                                    <div class="clearfix spacer-20"></div>
           	<input type="password" name="pwd2" id="pwd2" class="form-control password-input2 margin-5" placeholder="'.__('Repeat Password','framework').'">
			<div class="clearfix spacer-20"></div>
           	<input type="hidden" name="image_path" id="image_path" value="'.get_template_directory_uri().'">                             
          	<input type="hidden" name="task" id="task" value="register" />
        	<button type="submit" id="submit" class="btn btn-primary">'.__('Create Account','framework').'</button>
        	</form><div class="clearfix">
           	<div id="message"></div>
           	</div>
         	</section>'; }
		elseif($type==2) {
			echo '<section class="signup-form sm-margint">';
			   echo '<div class="regular-signup">
			   <h3>'.$post_title.'</h3>';
			echo '<form id="login" action="login" method="post">';
				$redirect_login= '';
                echo '<input type ="hidden" class ="redirect_login" name ="redirect_login" value ="'.esc_url($redirect_login).'"/>
                        <input id="loginname" name="loginname" type="text" class="form-control" placeholder="'.__('Username','framework').'">
                        <input id="password" name="password" type="password" class="form-control" placeholder="'.__('Password','framework').'">
                    <input type="checkbox" checked="checked" value="true" name="rememberme" id="rememberme" class="checkbox"> '.__('Remember Me!','framework').'<br/>
                    <input name="submit" type="submit" class="btn btn-primary submit_button" value="'.__('Login','framework').'">';
					wp_nonce_field( 'ajax-login-nonce', 'security' );
					echo '<p class="status"></p>
                </form></div></section>';
		} 
	   echo $args['after_widget'];
	   }
	}
}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("imic_agent_registration");'));
?>