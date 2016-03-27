<?php global $imic_options;
$menu_locations = get_nav_menu_locations();
$listing_url = imic_get_template_url("template-listing.php");
$listing_id = imic_get_template_id('template-listing.php'); ?>
<div class="body">
	<!-- Start Site Header -->
	<div class="site-header-wrapper">
    	<!-- Top Header -->
        <header class="top-header mmenu">
            <div class="container sp-cont">
                <ul class="pull-right social-icons social-icons-colored">
                    <?php $header_socialSites = $imic_options['header_social_links'];
								foreach ($header_socialSites as $key => $value) {
									if (filter_var($value, FILTER_VALIDATE_URL)) {
										$string = substr($key, 3);
										echo '<li class="'.$string.'"><a href="' . esc_url($value) . '" target="_blank"><i class="fa ' . $key . '"></i></a></li>'; } } ?>
                </ul>
                <?php if (!empty($menu_locations['primary-menu'])) {
						echo '<div class=" dd-menu toggle-menu">';
                    	wp_nav_menu(array('theme_location' => 'primary-menu', 'container' => '','items_wrap' => '<ul id="%1$s" class="sf-menu">%3$s</ul>', 'walker' => new imic_mega_menu_walker)); 
						echo '</div>'; } ?>
               	<a href="#" class="visible-sm visible-xs" id="menu-toggle"><i class="fa fa-bars"></i></a>
           	</div>
        </header>
        <!-- Site Main Header -->
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
                </div>
                
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
                    </div><?php } if(is_plugin_active("imithemes-listing/listing.php")) { ?>
                    <form class="search-form-minimal hidden-xs hidden-sm" method="get" action="<?php echo esc_url($listing_url); ?>">
                    <input type="hidden" value="<?php echo esc_attr($listing_id); ?>" name="page_id">
                        <div class="input-group input-group-sm">
                            <input type="text" name="specification-search" class="form-control" size="40" placeholder="<?php echo esc_attr_e('Enter model, make, zipcode etc. to search','framework'); ?>">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><?php echo esc_attr_e('Search!','framework'); ?></button>
                            </span>
                        </div>
                   	</form><?php } ?>
                </div>
            </div>
        </header>
        </div>
        <!-- End Site Header -->