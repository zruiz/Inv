<?php
$menu_locations = get_nav_menu_locations();
global $imic_options;
 ?>
    <footer class="site-footer">
    <?php if ( is_active_sidebar( 'footer-sidebar' ) ) : ?>
    <div class="site-footer-top">
    	<div class="container">
            	<div class="row">
                	<?php dynamic_sidebar('footer-sidebar'); ?>
            	</div>
         </div>
   	</div>
           	<?php endif; ?>
        <div class="site-footer-bottom">
        	<div class="container">
                <div class="row">
                	<div class="col-md-6 col-sm-6 copyrights-left">
                    	<p><?php echo $imic_options['footer_copyright_text']; ?></p>
                    </div>
                    <?php $socialSites = $imic_options['footer_social_links']; ?>
                    <div class="col-md-6 col-sm-6 copyrights-right">
                        <ul class="social-icons social-icons-colored pull-right">
                            <?php
								foreach ($socialSites as $key => $value) {
									if (filter_var($value, FILTER_VALIDATE_URL)) {
										$string = substr($key, 3);
										echo '<li class="'.$string.'"><a href="' . esc_url($value) . '" target="_blank"><i class="fa ' . $key . '"></i></a></li>'; } } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
<a id="back-to-top"><i class="fa fa-angle-double-up"></i></a>  
<div class="modal fade" id="PaymentModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="PaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel"><?php echo esc_attr_e('Invictus - Login or Register','framework'); ?></h4>
        </div>
        <div class="modal-body">
            <div class="tabs">
              <ul class="nav nav-tabs">
                <li class="active"> <a data-toggle="tab" href="#login-user-form"> <?php echo esc_attr_e('Login','framework'); ?> </a> </li>
                <li> <a data-toggle="tab" href="#register-user-form"> <?php echo esc_attr_e('Register','framework'); ?> </a> </li>
                <li> <a data-toggle="tab" href="#reset-user-form"> <?php echo esc_attr_e('Reset Password','framework'); ?> </a> </li>
              </ul>
              <div class="tab-content">
                <div id="login-user-form" class="tab-pane active">
                  <form id="login-popup" action="login" method="post">
                  <br/>
                    <?php 
                    $redirect_login= get_post_meta(get_the_ID(),'imic_login_redirect_options',true);
                    $redirect_login=!empty($redirect_login)?$redirect_login:  home_url();
                    ?>
                    <input type ="hidden" class ="redirect_login" name ="redirect_login" value ="dashboard/"/>
                    <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input class="form-control input1" id="loginname" type="text" name="loginname" placeholder="<?php _e('Username', 'framework'); ?>">
                    </div>
                    <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input class="form-control input1" id="password" type="password" name="password" placeholder="<?php _e('Password', 'framework'); ?>">
                    </div>
                    <div class="input-group">
                    <input type="checkbox" checked="checked" value="true" name="rememberme" id="rememberme" class="checkbox"> <?php echo esc_attr_e('Remember Me!','framework'); ?>
                    </div>
                    <input class="submit_button btn btn-primary button2" type="submit" value="<?php echo esc_attr_e('Login Now','framework'); ?>" name="submit">
                    <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?><br/><p class="status"></p>
                    </form>
                </div>
                <div id="register-user-form" class="tab-pane">
                  <form method="post" id="registerformpopup" name="registerformpopup" class="register-form-popup">
                  <br/>
                    <input type ="hidden" class ="redirect_register" name ="redirect_register" value ="registration-complete/"/>
                    <?php 
                    if(is_plugin_active("imithemes-listing/listing.php")) {
                    $user_role = get_terms('user-role',array('hide_empty'=>false));
                    if(!empty($user_role)) { ?>
                    <div class="input-group">
                    <span class="input-group-addon"><?php echo esc_attr_e('Role','framework'); ?></span>
                    <select name="user-role" id="user-role-popup" class="form-control selectpicker">
                    <?php foreach($user_role as $role) {
                    echo '<option value="'.esc_attr($role->name).'">'.esc_attr($role->name).'</option>';
                    } ?>
                    </select>
                    </div>
                    <?php } } ?>
                    <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" name="firstname" id="firstname-popup" class="form-control" placeholder="<?php echo esc_attr_e('First Name','framework'); ?>">
                    </div>
                    <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" name="lastname" id="lastname-popup" class="form-control" placeholder="<?php echo esc_attr_e('Last Name','framework'); ?>">
                    </div>
                    <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" name="company" id="company-popup" class="form-control" placeholder="<?php echo esc_attr_e('Company','framework'); ?>">
                    </div>
                    <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" name="username" id="username-popup" class="form-control" placeholder="<?php echo esc_attr_e('Username','framework'); ?>">
                    </div>
                    <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="email" name="email" id="email-popup" class="form-control" placeholder="<?php echo esc_attr_e('Email','framework'); ?>">
                    </div>
                    <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" name="pwd1" id="pwd1-popup" class="form-control password-input-popup" placeholder="<?php echo esc_attr_e('Password','framework'); ?>">
                    </div><div class="signup-form">
                    <a href="javascript:void(0);" rel="0" title="<?php echo esc_attr_e('Show/Hide Password','framework') ?>" class="password-show-popup pass-actions"><i class="fa-eye-slash"></i></a>
					<a href="javascript:void(0);" title="<?php echo esc_attr_e('Generate Password','framework') ?>" class="password-generate-popup pass-actions"><i class="fa fa-refresh"></i></a>
                	<div class="progress"><div class="progress-bar password-output-popup" style="width: 0%"></div></div></div>
                	<div class="clearfix spacer-20"></div>
                    <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-refresh"></i></span>
                    <input type="password" name="pwd2" id="pwd2-popup" class="form-control password-input2-popup margin-5" placeholder="<?php echo esc_attr_e('Repeat Password','framework') ?>">
                    </div>
                    <input type="hidden" name="image_path" id="image_path" value="<?php echo get_template_directory_uri(); ?>">                             
                    <input type="hidden" name="task" id="task-popup" value="register" />
                    <button type="submit" id="submit-popup" class="btn btn-primary"><?php echo esc_attr_e('Register Now','framework'); ?></button>
                    </form><div class="clearfix"></div><br/>
                    <div id="message-popup"></div>
                </div>
                <div id="reset-user-form" class="tab-pane">
                  <form id="reset-pass" method="post">
                  <br/>
                    <?php 
                    $redirect_login= get_post_meta(get_the_ID(),'imic_login_redirect_options',true);
                    $redirect_login=!empty($redirect_login)?$redirect_login:  home_url();
                    ?>
                    <input type ="hidden" class ="redirect_login" name ="redirect_login" value ="dashboard/"/>
                    <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input class="form-control input1" id="reset-email" type="text" name="reset-email" placeholder="<?php esc_attr_e('Email Address', 'framework'); ?>">
                    </div>
                    <div class="input-group" id="reset-key" style="display:none;">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input class="form-control input1" id="reset-verification" type="text" name="reset-verification" placeholder="<?php esc_attr_e('Please insert verification code', 'framework'); ?>">
                    </div>
                    <div id="show-pass-fields" style="display:none;">
                    <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input class="form-control input1" id="reset-pass1" type="password" name="reset-pass1" placeholder="<?php esc_attr_e('Enter Password', 'framework'); ?>">
                    </div>
                    <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input class="form-control input1" id="reset-pass2" type="password" name="reset-pass2" placeholder="<?php esc_attr_e('Enter Password Again', 'framework'); ?>">
                    </div>
                    </div>
                    <input id="reset-code" class="submit_button btn btn-primary button2" type="submit" value="<?php echo esc_attr_e('Reset Password','framework'); ?>" name="submit">
                    <input style="display:none;" id="reset-new-pass" class="submit_button btn btn-primary button2" type="submit" value="<?php echo esc_attr_e('Change Password','framework'); ?>" name="submit_pass">
                    
                    <br/><p class="status"></p>
                    </form>
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer">
        </div>
    </div>
    </div>
</div>
<!-- End Boxed Body -->
<!-- LIGHTBOX INIT -->
<?php			
	if(isset($imic_options['switch_lightbox']) && $imic_options['switch_lightbox']== 0){?>
		<script>
			jQuery(document).ready(function() {
               jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({
				  opacity: <?php if(isset($imic_options['prettyphoto_opacity']) && $imic_options['prettyphoto_opacity']!= ""){ echo $imic_options['prettyphoto_opacity']; } ?>,
				  social_tools: "",
				  deeplinking: false,
				  allow_resize:false,
				  show_title: <?php if(isset($imic_options['prettyphoto_title']) && $imic_options['prettyphoto_title']== 0){ echo 'true'; } else echo 'false'; ?>,
				  theme: '<?php if(isset($imic_options['prettyphoto_theme']) && $imic_options['prettyphoto_theme']!= ""){ echo $imic_options['prettyphoto_theme']; } ?>',
				});
				jQuery('.sort-source a').click(function(){
					var sortval = jQuery(this).parent().attr('data-option-value');
					$(".sort-destination li a").removeAttr('data-rel');
    				$(".sort-destination li a").attr('data-rel', "prettyPhoto["+sortval+"]");
				});
            });
		</script>
	<?php }elseif(isset($imic_options['switch_lightbox']) && $imic_options['switch_lightbox']== 1){ ?>
    	<script>
			jQuery(document).ready(function() {
				jQuery('.format-gallery').magnificPopup({
  					delegate: 'a.magnific-gallery-image', // child items selector, by clicking on it popup will open
  					type: 'image',
					gallery:{enabled:true}
  				// other options
				});
				jQuery('.magnific-image').magnificPopup({ 
  					type: 'image'
					// other options
				});
				jQuery('.magnific-video').magnificPopup({ 
  					type: 'iframe'
					// other options
				});
				jQuery('.title-subtitle-holder-inner').magnificPopup({
  					delegate: 'a.magnific-video', // child items selector, by clicking on it popup will open
  					type: 'iframe',
					gallery:{enabled:true}
  				// other options
				});
			});
		</script>
	<?php }
?>
<?php wp_footer(); ?>
</body>
<div id="searchmodal" class="modal fade" aria-hidden="true" aria-labelledby="mymodalLabel" role="dialog" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button class="close" aria-hidden="true" data-dismiss="modal" type="button"><?php echo esc_attr_e('×','framework'); ?></button>
<h4 id="mymodalLabel" class="modal-title"><?php echo esc_attr_e('Save Search','framework'); ?></h4>
</div>
<div class="modal-body">
<form method="post" id="contactform" name="contactform" class="contact-form clearfix" action="mail/contact.php">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <input type="text" id="search-title" name="First Name"  class="form-control input-lg" placeholder="First name*">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <textarea cols="6" rows="2" id="search-desc" name="comments" class="form-control input-lg" placeholder="Description"></textarea>
                </div>
                
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <div id="messages"></div>
                </div>
                
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
<input id="" name="submit" type="button" class="btn btn-default inverted save-search" value="Save Search">
<button class="btn btn-default inverted" data-dismiss="modal" type="button">Close</button>
</div>
</div>
</div>
</div>
<!--Delete Confirmation Box-->
<div id="confirm-delete" class="modal fade" aria-hidden="true" aria-labelledby="mymodalLabel" role="dialog" tabindex="-1">
                            <div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button class="close" aria-hidden="true" data-dismiss="modal" type="button"><?php echo esc_attr_e('×','framework'); ?></button>
<h4 id="mymodalLabel" class="modal-title"><?php echo esc_attr_e('Delete Selected Items','framework'); ?></h4>
</div>
<div class="modal-body">
<?php echo esc_attr_e('Please click delete to remove this listing from your list or click close to cancel.','framework'); ?>
</div>
<div class="modal-footer">
<input id="delete" name="submit" data-dismiss="modal" type="button" class="btn btn-default inverted" value="Delete">
<button class="btn btn-default inverted" data-dismiss="modal" type="button">Close</button>
</div>
</div>
</div>
</div>
</html>