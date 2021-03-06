<?php global $imic_options;
$menu_locations = get_nav_menu_locations(); ?>
<div class="body">
	<!-- Start Site Header -->
	<div class="site-header-wrapper">
        <header class="site-header">
            <div class="container sp-cont">
                <div class="site-logo">
                    <h1><?php
                                    global $imic_options;
                                    if (!empty($imic_options['logo_upload']['url'])) {
                                        echo '<a href="' . esc_url( home_url() ) . '" title="' . get_bloginfo('name') . '" class="default-logo"><img src="' . $imic_options['logo_upload']['url'] . '" alt="Logo"></a>';
                                    } else {
                                        echo '<a href="' . esc_url( home_url() ) . '" title="' . get_bloginfo('name') . '" class="default-logo theme-blogname">'. get_bloginfo('name') .'</a>';
                                    }
                                    ?>
                                    <?php
                                    global $imic_options;
                                    if (!empty($imic_options['retina_logo_upload']['url'])) {
                                        echo '<a href="' . esc_url( home_url() ) . '" title="' . get_bloginfo('name') . '" class="retina-logo"><img src="' . $imic_options['retina_logo_upload']['url'] . '" alt="Logo" width="' . $imic_options['retina_logo_width'] .'" height="' . $imic_options['retina_logo_height'] .'"></a>';
                                    } elseif (!empty($imic_options['logo_upload']['url'])) {
                                        echo '<a href="' . esc_url( home_url() ) . '" title="' . get_bloginfo('name') . '" class="retina-logo"><img src="' . $imic_options['logo_upload']['url'] . '" alt="Logo"></a>';
                                    } else {
                                        echo '<a href="' . esc_url( home_url() ) . '" title="' . get_bloginfo('name') . '" class="retina-logo theme-blogname">'. get_bloginfo('name') .'</a>';
                                    }
                                    ?></h1>
                    <span class="site-tagline"><?php echo html_entity_decode(get_option('blogdescription')); ?></span>
                </div>
<?php if (!empty($menu_locations['primary-menu'])) {
						echo '<div class="topnav main-navigation dd-menu toggle-menu">';
                    	wp_nav_menu(array('theme_location' => 'primary-menu', 'container' => '','items_wrap' => '<ul id="%1$s" class="sf-menu">%3$s</ul>', 'walker' => new imic_mega_menu_walker)); 
						echo '</div>'; } ?>
                <div class="header-right">
                <?php if(!is_user_logged_in()) { 
		wp_enqueue_script('imic_agent_register');
	   wp_localize_script('imic_agent_register','agent_register',array('ajaxurl'=>admin_url('admin-ajax.php'))); ?>
                    <div class="user-login-panel">
                    <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#PaymentModal"><?php echo esc_attr_e('Login/Signup','framework'); ?></a>
                    </div><?php } else {
						$default_image = (isset($imic_options['default_dealer_image']))?$imic_options['default_dealer_image']:array('url'=>'');
						global $current_user;
						$user_id = get_current_user_id( );
						$user_info_id = get_user_meta($user_id,'imic_user_info_id',true);
						$userFirstName = $current_user->user_firstname;
						$userLastName = $current_user->user_lastname;
						$userName = get_the_author_meta( 'display_name', $user_id );
						if(!empty($userFirstName) || !empty($userLastName)) {
							$userName = $userFirstName .' '. $userLastName; 
						}
						$dashboard = imic_get_template_url('template-dashboard.php'); ?>
            <?php if(!empty($dashboard)) { ?>
                    <div class="user-login-panel logged-in-user">
                        <a href="#" class="user-login-btn" id="userdropdown" data-toggle="dropdown">
                        <?php if(has_post_thumbnail($user_info_id)) { echo get_the_post_thumbnail($user_info_id,'100x100'); } else { ?>
                            <img src="<?php echo esc_url($default_image['url']); ?>" alt=""><?php } ?>
                            <span class="user-informa">
                                <span class="meta-data"><?php echo esc_attr_e('Welcome','framework'); ?></span>
                                <span class="user-name"><?php echo esc_attr($userName); ?></span>
                            </span>
                            <span class="user-dd-dropper"><i class="fa fa-angle-down"></i></span>
                        </a>
                        
                        <ul class="dropdown-menu" role="menu" aria-labelledby="userdropdown">
                            <li><a href="<?php echo esc_url($dashboard); ?>"><?php echo esc_attr_e('Dashboard','framework'); ?></a></li>
                            <li><a href="<?php echo esc_url(add_query_arg('search',1,$dashboard)); ?>"><?php echo esc_attr_e('Saved Searches','framework'); ?></a></li>
                            <li><a href="<?php echo esc_url(add_query_arg('saved',1,$dashboard)); ?>"><?php echo esc_attr_e('Saved Listings','framework'); ?></a></li>
                            <li><a href="<?php echo esc_url(add_query_arg('manage',1,$dashboard)); ?>"><?php echo esc_attr_e('Manage Ads','framework'); ?></a></li>
                            <li><a href="<?php echo esc_url(add_query_arg('profile',1,$dashboard)); ?>"><?php echo esc_attr_e('My Profile','framework'); ?></a></li>
                            <li><a href="<?php echo wp_logout_url(home_url()); ?>"><?php echo esc_attr_e('Log Out','framework'); ?></a></li>
                        </ul><?php } ?>
                    </div><?php } ?>
                    <a href="#" class="visible-sm visible-xs" id="menu-toggle"><i class="fa fa-bars"></i></a>
                </div>
            </div>
        </header>
        </div>
        <!-- End Site Header -->