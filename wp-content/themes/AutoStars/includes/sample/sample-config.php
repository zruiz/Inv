<?php
/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */
if (!class_exists('Redux_Framework_sample_config')) {
load_theme_textdomain('imic-framework-admin', IMIC_FILEPATH . '/language');
    class Redux_Framework_sample_config {
        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;
        public function __construct() {
            if (!class_exists('ReduxFramework')) {
                return;
            }
            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }
        }
        public function initSettings() {
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();
            // Set the default arguments
            $this->setArguments();
            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();
            // Create the sections and fields
            $this->setSections();
            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }
            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));
            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }
        /**
          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.
         * */
        function compiler_action($options, $css) {
            //echo '<h1>The compiler hook has run!</h1>';
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }
              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }
        /**
          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.
          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons
         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'imic-framework-admin'),
                'desc' => __('<p>Did you know that IMIC Framework sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$imic_options</strong></p>', 'imic-framework-admin'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );
            return $sections;
        }
        /**
          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;
            return $args;
        }
        /**
          Filter hook for filtering the default value of any given field. Very useful in development mode.
         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = __('Testing filter hook!','framework');
            return $defaults;
        }
        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);
                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }
        public function setSections() {
            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();
            if (is_dir($sample_patterns_path)) :
                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();
                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {
                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;
            ob_start();
            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';
            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'imic-framework-admin'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>
                <h4><?php echo $this->theme->display('Name'); ?></h4>
                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'imic-framework-admin'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'imic-framework-admin'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'imic-framework-admin') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'imic-framework-admin'), $this->theme->parent()->display('Name'));
            }
            ?>
                </div>
            </div>
            <?php
            $item_info = ob_get_contents();
            ob_end_clean();
            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }
			load_theme_textdomain('imic-framework-admin', IMIC_FILEPATH . '/language');
			$defaultLogo = get_template_directory_uri().'/images/logo.png';
			$defaultAdminLogo = get_template_directory_uri().'/images/logo@2x.png';
			$defaultBannerImages = get_template_directory_uri().'/images/page-header1.jpg';
			$defaultFavicon = '';
			$default_logo = get_template_directory_uri() . '/images/logo.png';
			$default_favicon = get_template_directory_uri() . '/images/favicon.ico';
            // ACTUAL DECLARATION OF SECTIONS
			$this->sections[] = array(
    'icon' => 'el-icon-cogs',
    'icon_class' => 'icon-large',
    'title' => __('General Settings', 'imic-framework-admin'),
    'fields' => array(
        array(
            'id' => 'enable_maintenance',
            'type' => 'switch',
            'title' => __('Enable Maintenance', 'imic-framework-admin'),
            'subtitle' => __('Enable the themes in maintenance mode.', 'imic-framework-admin'),
            "default" => 0,
            'on' => __('Enabled', 'imic-framework-admin'),
            'off' => __('Disabled', 'imic-framework-admin'),
        ),
        array(
            'id' => 'switch-responsive',
            'type' => 'switch',
            'title' => __('Enable Responsive', 'imic-framework-admin'),
            'subtitle' => __('Enable/Disable the responsive behaviour of the theme', 'imic-framework-admin'),
            "default" => 1,
        ),
        array(
            'id' => 'enable_rtl',
            'type' => 'switch',
            'title' => __('Enable RTL', 'imic-framework-admin'),
            'subtitle' => __('If you are using wordpress for RTL languages then you should enable this option.', 'imic-framework-admin'),
            "default" => 0,
        ),
        array(
            'id' => 'enable_backtotop',
            'type' => 'switch',
            'title' => __('Enable Back To Top', 'imic-framework-admin'),
            'subtitle' => __('Enable the back to top button that appears in the bottom right corner of the screen.', 'imic-framework-admin'),
            "default" => 0,
        ),
        array(
            'id' => 'custom_favicon',
            'type' => 'media',
            'compiler' => 'true',
            'title' => __('Custom favicon', 'imic-framework-admin'),
            'desc' => __('Upload a image that will represent your website favicon', 'imic-framework-admin'),
            'default' => array('url' => $default_favicon),
        ),
       array(
            'id' => 'tracking-code',
            'type' => 'ace_editor',
            'title' => __('Tracking Code', 'imic-framework-admin'),
            'subtitle' => __('Paste your Google Analytics (or other) tracking code here. This will be added into the header template of your theme. Please put code without opening and closing script tags.', 'imic-framework-admin'),
			'default' => '',
        ),
        array(
            'id' => 'custom_admin_login_logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Custom admin login logo', 'imic-framework-admin'),
            'compiler' => 'true',
            //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
            'desc' => __('Upload a 254 x 95px image here to replace the admin login logo.', 'imic-framework-admin'),
            'subtitle' => __('', 'imic-framework-admin'),
            'default' => array('url' => $defaultAdminLogo),
        ),
		
    )
);
$this->sections[] = array(
    'icon' => 'el-icon-chevron-up',
    'title' => __('Header Options', 'imic-framework-admin'),
    'desc' => __('<p class="description">These are the options for the header.</p>', 'imic-framework-admin'),
    'fields' => array(
	array(
            'id' => 'header_image',
            'type' => 'media',
            'url' => true,
            'title' => __('Header Image', 'imic-framework-admin'),
            'desc' => __('Default header image for post types.', 'imic-framework-admin'),
            'subtitle' => __('Set this image as default page header image for all Pages/Posts/Cars/Team/Gallery', 'imic-framework-admin'),
            'default' => array('url' => ''),
        ),
        array(
            'id' => 'logo_upload',
            'type' => 'media',
            'url' => true,
            'title' => __('Upload Logo', 'imic-framework-admin'),
            'desc' => __('Basic media uploader with disabled URL input field.', 'imic-framework-admin'),
            'subtitle' => __('Upload site logo to display in header.', 'imic-framework-admin'),
            'default' => array('url' => $default_logo),
        ),
        array(
            'id' => 'retina_logo_upload',
            'type' => 'media',
            'url' => true,
            'title' => __('Upload Logo for Retina Devices', 'imic-framework-admin'),
            'desc' => __('Retina Display is a marketing term developed by Apple to refer to devices and monitors that have a resolution and pixel density so high – roughly 300 or more pixels per inch', 'imic-framework-admin'),
            'subtitle' => __('Upload site logo to display in header.', 'imic-framework-admin'),
            'default' => array('url' => $defaultAdminLogo),
        ),
		array(
            'id' => 'retina_logo_width',
            'type' => 'text',
            'title' => __('Standard Logo Width for Retina Logo', 'imic-framework-admin'),
            'subtitle' => __('If retina logo is uploaded, enter the standard logo (1x) version width, do not enter the retina logo width.', 'imic-framework-admin'),
			'default' => '',
        ),
		array(
            'id' => 'retina_logo_height',
            'type' => 'text',
            'title' => __('Standard Logo Height for Retina Logo', 'imic-framework-admin'),
            'subtitle' => __('If retina logo is uploaded, enter the standard logo (1x) version height, do not enter the retina logo height.', 'imic-framework-admin'),
			'default' => '',
        ),
        array(
            'id' => 'enable-header-stick',
            'type' => 'switch',
            'title' => __('Enable Header Stick', 'imic-framework-admin'),
            'subtitle' => __('Enable/Disable Header Stick behaviour of the theme', 'imic-framework-admin'),
            "default" => 1,
        ),
		array(
			'id'=>'search_position',
			'type' => 'button_set',
			'compiler'=>true,
			'title' => __('Search Form Position', 'imic-framework-admin'), 
			'subtitle' => __('Choose the position of search form', 'imic-framework-admin'),
			'options' => array(
					'0' => __('Default','imic-framework-admin'),
					'1' => __('Below Slider/Banner','imic-framework-admin'),
					'2' => __('Over Slider/Banner','imic-framework-admin')
				),
			'default' => '0',
			),
		array(
            'id' => 'search_text',
			'required' => array('search_position','equals','0'),
            'type' => 'text',
            'title' => __('Search Title', 'imic-framework-admin'),
            'subtitle' => __('Enter title for search form', 'imic-framework-admin'),
            'default' => ''
        ),
        array(
			'id' => 'header_social_links',
			'type' => 'sortable',
			'label' => true,
			'compiler'=>true,
			'title' => __('Social Links', 'imic-framework-admin'),
			'desc' => __('Enter the social links and sort to active and display according to sequence in header.', 'imic-framework-admin'),
			'options' => array(
							'fa-facebook' => 'facebook',
							'fa-twitter' => 'twitter',
							'fa-pinterest' => 'pinterest',
							'fa-google-plus' => 'google',
							'fa-youtube' => 'youtube',
							'fa-instagram' => 'instagram',
							'fa-vimeo-square' => 'vimeo',
							'fa-rss' => 'rss',
							'fa-dribbble' => 'dribbble',
							'fa-dropbox' => 'dropbox',
							'fa-bitbucket' => 'bitbucket',
							'fa-flickr' => 'flickr',
							'fa-foursquare' => 'foursquare',
							'fa-github' => 'github',
							'fa-gittip' => 'gittip',
							'fa-linkedin' => 'linkedin',
							'fa-pagelines' => 'pagelines',
							'fa-skype' => 'skype',
							'fa-tumblr' => 'tumblr',
							'fa-vk' => 'vKontakte'
				),

		),
		array(
    		'id' => 'header_layout',
    		'type' => 'image_select',
    		'compiler'=>true,
			'title' => __('Header Layout','imic-framework-admin'), 
			'subtitle' => __('Select the Header layout', 'imic-framework-admin'),
    			'options' => array(
					'v1' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/headerLayout/header-style1.png'),
    				'v2' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/headerLayout/header-style2.png'),
    				'v3' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/headerLayout/header-style3.png'),
					'v4' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/headerLayout/header-style4.png'),
    				),
    		'default' => 'v1'
    		),
		),
);
$this->sections[] = array(
    'icon' => 'el-icon-chevron-down',
    'title' => __('Footer Options', 'imic-framework-admin'),
    'desc' => __('<p class="description">These are the options for the footer.</p>', 'imic-framework-admin'),
    'fields' => array(
        array(
            'id' => 'site-rss',
            'type' => 'text',
			'required' => array('theme_color_types','equals','0'),
            'title' => __('Rss', 'imic-framework-admin'),
            'subtitle' => __('Rss URL to link your  Rss icon.', 'imic-framework-admin'),
            'desc' => __('Enter your Rss URL for you theme footer.', 'imic-framework-admin'),
            'default' => site_url().'/feed/',
        ),
        array(
            'id' => 'footer_copyright_text',
            'type' => 'text',
            'title' => __('Footer Copyright Text', 'imic-framework-admin'),
            'subtitle' => __(' Enter Copyright Text', 'imic-framework-admin'),
            'default' => __('All Rights Reserved', 'imic-framework-admin')
        ),
		array(
						'id' => 'footer_social_links',
						'type' => 'sortable',
						'label' => true,
						'compiler'=>true,
						'title' => __('Social Links', 'imic-framework-admin'),
						'desc' => __('Insert Social URL in their respective fields and sort as your desired order.', 'imic-framework-admin'),
						'options' => array(
										'fa-facebook' => 'facebook',
										'fa-twitter' => 'twitter',
										'fa-pinterest' => 'pinterest',
										'fa-google-plus' => 'gplus',
										'fa-youtube' => 'youtube',
										'fa-instagram' => 'instagram',
										'fa-vimeo-square' => 'vimeo',
										'fa-rss' => 'rss',
										'fa-dribbble' => 'dribbble',
										'fa-dropbox' => 'dropbox',
										'fa-bitbucket' => 'bitbucket',
										'fa-flickr' => 'flickr',
										'fa-foursquare' => 'foursquare',
										'fa-github' => 'github',
										'fa-gittip' => 'gittip',
										'fa-linkedin' => 'linkedin',
										'fa-pagelines' => 'pagelines',
										'fa-skype' => 'skype',
										'fa-tumblr' => 'tumblr',
										'fa-vk' => 'vKontakte'
							),
					),
		array(
    		'id' => 'footer_layout',
    		'type' => 'image_select',
    		'compiler'=>true,
			'title' => __('Footer Layout', 'imic-framework-admin'), 
			'subtitle' => __('Select the footer layout', 'imic-framework'),
    			'options' => array(
					'12' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/footerColumns/footer-1.png'),
    				'6' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/footerColumns/footer-2.png'),
    				'4' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/footerColumns/footer-3.png'),
    				'3' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/footerColumns/footer-4.png'),
					'2' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/footerColumns/footer-5.png'),
    							),
    		'default' => '4'
    						),	
    ),
);
$this->sections[] = array(
    'icon' => 'el-icon-check-empty',
    'title' => __('Layout Options', 'imic-framework-admin'),
    'fields' => array(
        array(
			'id'=>'site_layout',
			'type' => 'image_select',
			'compiler'=>true,
			'title' => __('Page Layout', 'imic-framework-admin'), 
			'subtitle' => __('Select the page layout type', 'imic-framework-admin'),
			'options' => array(
					'wide' => array('alt' => 'Wide', 'img' => ReduxFramework::$_url.'assets/img/wide.png'),
					'boxed' => array('alt' => 'Boxed', 'img' => ReduxFramework::$_url.'assets/img/boxed.png')
				),
			'default' => 'wide',
			),
		array(
			'id'=>'repeatable-bg-image',
			'type' => 'image_select',
			'required' => array('site_layout','equals','boxed'),
			'title' => __('Repeatable Background Images', 'imic-framework-admin'), 
			'subtitle' => __('Select image to set in background.', 'imic-framework-admin'),
			'options' => array(
				'pt1.png' => array('alt' => 'pt1', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt1.png'),
				'pt2.png' => array('alt' => 'pt2', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt2.png'),
				'pt3.png' => array('alt' => 'pt3', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt3.png'),
				'pt4.png' => array('alt' => 'pt4', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt4.png'),
				'pt5.png' => array('alt' => 'pt5', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt5.png'),
				'pt6.png' => array('alt' => 'pt6', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt6.png'),
				'pt7.png' => array('alt' => 'pt7', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt7.png'),
				'pt8.png' => array('alt' => 'pt8', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt8.png'),
				'pt9.png' => array('alt' => 'pt9', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt9.png'),
				'pt10.png' => array('alt' => 'pt10', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt10.png'),
				'pt11.jpg' => array('alt' => 'pt11', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt11.png'),
				'pt12.jpg' => array('alt' => 'pt12', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt12.png'),
				'pt13.jpg' => array('alt' => 'pt13', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt13.png'),
				'pt14.jpg' => array('alt' => 'pt14', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt14.png'),
				'pt15.jpg' => array('alt' => 'pt15', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt15.png'),
				'pt16.png' => array('alt' => 'pt16', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt16.png'),
				'pt17.png' => array('alt' => 'pt17', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt17.png'),
				'pt18.png' => array('alt' => 'pt18', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt18.png'),
				'pt19.png' => array('alt' => 'pt19', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt19.png'),
				'pt20.png' => array('alt' => 'pt20', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt20.png'),
				'pt21.png' => array('alt' => 'pt21', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt21.png'),
				'pt22.png' => array('alt' => 'pt22', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt22.png'),
				'pt23.png' => array('alt' => 'pt23', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt23.png'),
				'pt24.png' => array('alt' => 'pt24', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt24.png'),
				'pt25.png' => array('alt' => 'pt25', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt25.png'),
				'pt26.png' => array('alt' => 'pt26', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt26.png'),
				'pt27.png' => array('alt' => 'pt27', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt27.png'),
				'pt28.png' => array('alt' => 'pt28', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt28.png'),
				'pt29.png' => array('alt' => 'pt29', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt29.png'),
				'pt30.png' => array('alt' => 'pt30', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt30.png')
				)
			),	
		array(
			'id'=>'upload-repeatable-bg-image',
			'compiler'=>true,
			'required' => array('site_layout','equals','boxed'),
			'type' => 'media', 
			'url'=> true,
			'title' => __('Upload Repeatable Background Image', 'imic-framework-admin')
			),
		array(
			'id'=>'full-screen-bg-image',
			'compiler'=>true,
			'required' => array('site_layout','equals','boxed'),
			'type' => 'media', 
			'url'=> true,
			'title' => __('Upload Full Screen Background Image', 'imic-framework-admin')
			),	
		
    ),
);
$this->sections[] = array(
    'icon' => 'el-icon-website',
    'title' => __('Theme Color Options', 'imic-framework-admin'),
    'fields' => array(
		 array(
			'id'=>'theme_color_type',
			'type' => 'button_set',
			'compiler'=>true,
			'title' => __('Website primary color', 'imic-framework-admin'), 
			'subtitle' => __('Select the website primary color', 'imic-framework-admin'),
			'options' => array(
					'0' => __('Pre-Defined Color Schemes','imic-framework-admin'),
					'1' => __('Custom Color','imic-framework-admin')
				),
			'default' => '0',
			),
        array(
            'id' => 'theme_color_scheme',
            'type' => 'select',
			'required' => array('theme_color_type','equals','0'),
            'title' => __('Theme Color Scheme', 'imic-framework-admin'),
            'subtitle' => __('Select your website primary color scheme.', 'imic-framework-admin'),
            'options' => array('color1.css' => 'color1.css', 'color2.css' => 'color2.css', 'color3.css' => 'color3.css', 'color4.css' => 'color4.css', 'color5.css' => 'color5.css', 'color6.css' => 'color6.css', 'color7.css' => 'color7.css', 'color8.css' => 'color8.css', 'color9.css' => 'color9.css', 'color10.css' => 'color10.css','color11.css' => 'color11.css','color12.css' => 'color12.css'),
            'default' => 'color1.css',
        ),	
		array(
			'id'=>'primary_theme_color',
			'type' => 'color',
			'required' => array('theme_color_type','equals','1'),
			'title' => __('Primary Theme Color', 'imic-framework-admin'), 
			'subtitle' => __('Pick a primary color for the website', 'imic-framework-admin'),
			'validate' => 'color',
			'transparent' => false,
			),
    ),
);
$this->sections[] = array(
    'icon' => 'el-icon-zoom-in',
    'title' => __('Lightbox Options', 'imic-framework-admin'),
    'fields' => array(
        array(
            'id' => 'switch_lightbox',
            'type' => 'button_set',
            'title' => __('Lightbox Plugin', 'imic-framework-admin'),
            'subtitle' => __('Choose the plugin for the Lightbox Popup for theme.', 'imic-framework-admin'	
			),
			'options' => array(
				'0' => __('PrettyPhoto','imic-framework-admin'),
				'1' => __('Magnific Popup','imic-framework-admin')
			),
            "default" => 0,
       	),
		array(
			'id'       => 'prettyphoto_theme',
			'type'     => 'select',
			'required' => array('switch_lightbox','equals','0'),
			'title'    => __('Theme Style', 'imic-framework-admin'), 
			'desc'     => __('Select style for the prettyPhoto Lightbox', 'imic-framework-admin'),
			'options'  => array(
				'pp_default' => __('Default','imic-framework-admin'),
				'light_rounded' => __('Light Rounded','imic-framework-admin'),
				'dark_rounded' => __('Dark Rounded','imic-framework-admin'),
				'light_square' => __('Light Square','imic-framework-admin'),
				'dark_square' => __('Dark Square','imic-framework-admin'),
				'facebook' => __('Facebook','imic-framework-admin'),
			),
			'default'  => 'pp_default',
		),
		array(
			'id' => 'prettyphoto_opacity',
			'required' => array('switch_lightbox','equals','0'),
			'type' => 'slider',
			'title' => __('Overlay Opacity', 'redux-framework-demo'),
			'desc' => __('Enter values between 0.1 to 1. Default is 0.5', 'redux-framework-demo'),
			"default" => .5,
			"min" => 0,
			"step" => .1,
			"max" => 1,
			'resolution' => 0.1,
			'display_value' => 'text'
		),
        array(
            'id' => 'prettyphoto_title',
			'required' => array('switch_lightbox','equals','0'),
            'type' => 'button_set',
            'title' => __('Show Image Title', 'imic-framework-admin'),
			'options' => array(
				'0' => __('Yes','imic-framework-admin'),
				'1' => __('No','imic-framework-admin')
			),
            "default" => 0,
       	),
	)
);
$this->sections[] = array(
    'icon' => 'el-icon-font',
    'title' => __('Global Font Options', 'imic-framework-admin'),
    'subtitle' => __('Global Font Family Sets (Can be override with dedicated styling options available below)', 'imic-framework-admin'),
	'desc' => __('These options are as per the design which consists of 3 fonts. For more advanced typography options see Sub Sections below this in Left Sidebar. Make sure you set these options only if you have knowledge about every property to avoid disturbing the whole layout. If something went wrong just reset this section to reset all fields in Typography Options or click the small cross signs in each select field/delete text from input fields to reset them.'),
    'fields' => array(
        array(
            'id' => 'body_font_typography',
            'type'        => 'typography',
			'title'       => __('Primary font', 'imic-framework-demo'),
			'google'      => true,
			'font-backup' => true,
			'subsets' 	  => true,
			'color' 		  => false,
			'text-align'	  => false,
            'font-weight' => false,
            'font-style' => false,
			'font-size'	  => false,
            'word-spacing'=>false,
			'line-height' => false,
			'letter-spacing' => false,
			'output'      => array('body, blockquote cite, .selectpicker.btn-default, .top-navigation > li > ul li, .result-item-title, .single-listing-actions .btn-default'),
			'units'       =>'px',
	    	'subtitle' => __('Please Enter Body Font.', 'imic-framework-admin'),
            'default' => array(
             	'font-family' => 'Roboto',
              ),
        ),
        array(
            'id' => 'heading_font_typography',
            'type'        => 'typography',
			'title'       => __('Secondary font', 'imic-framework-demo'),
			'google'      => true,
			'font-backup' => true,
			'subsets' 	  => true,
			'color' 		  => false,
			'text-align'	  => false,
            'font-weight' => false,
            'font-style' => false,
			'font-size'	  => false,
            'word-spacing'=>false,
			'line-height' => false,
			'letter-spacing' => false,
			'output'      => array('h4,.top-navigation > li, .review-status span, .result-item-view-buttons a, .single-vehicle-details .badge-premium-listing, .points-review .review-point strong'),
			'units'       =>'px',
            'subtitle' => __('Please Enter Heading Font', 'imic-framework-admin'),
            'default' => array(
            	'font-family' => 'Roboto Condensed',
				'font-backup' => '',
               ),
        ),
        array(
            'id' => 'metatext_date_font_typography',
            'type' => 'typography',
            'title' => __('Metatext/Quotes Cursive Font', 'imic-framework-admin'),
            'google'      => true,
			'font-backup' => true,
			'subsets' 	  => true,
			'color' 		  => false,
			'text-align'	  => false,
            'font-weight' => false,
            'font-style' => false,
			'font-size'	  => false,
            'word-spacing'=>false,
			'line-height' => false,
			'letter-spacing' => false,
			'output'      => array('blockquote, .cursive, .site-tagline, .dd-menu .megamenu-container .megamenu-sub-title .accent-color, .by-type-options .item a span, .social-signup .or-break, .body-type-widget li span, .fact'),
			'units'       =>'px',
            'subtitle' => __('Please Enter Metatext date Font', 'imic-framework-admin'),
            'default' => array(
           	 	'font-family' => 'Playfair Display',
				'font-backup' => '',
            ),
        ),
    ),
);
$this->sections[] = array(
    'icon' => 'el-icon-wrench-alt',
    'icon_class' => 'icon-large',
    'title' => __('Listing Settings', 'imic-framework-admin'),
    'fields' => array(
	    array(
			'id'=>'file_upload_type',
			'type' => 'button_set',
			'compiler'=>true,
			'title' => __('File Upload Type Method', 'imic-framework-admin'), 
			'subtitle' => __('Choose the upload file input method.', 'imic-framework-admin'),
			'options' => array(
					'0' => __('Default','imic-framework-admin'),
					'1' => __('Wordpress Media','imic-framework-admin'),
				),
			'default' => '0',
			),
		array(
			'id'=>'filetype_required',
			'type' => 'button_set',
			'compiler'=>true,
			'title' => __('File Upload', 'imic-framework-admin'), 
			'subtitle' => __('Make file upload mandatory.', 'imic-framework-admin'),
			'options' => array(
					'0' => __('No','imic-framework-admin'),
					'1' => __('Yes','imic-framework-admin'),
				),
			'default' => '0',
			),
			array(
			'id'=>'integer_specs_type',
			'type' => 'button_set',
			'compiler'=>true,
			'title' => __('Numeric Specification Type', 'imic-framework-admin'), 
			//'subtitle' => __('Make file upload mandatory.', 'imic-framework-admin'),
			'options' => array(
					'0' => __('Default','imic-framework-admin'),
					'1' => __('Slider','imic-framework-admin'),
				),
			'default' => '0',
			),
		array(
            'id' => 'category_rail',
            'type' => 'select',
            'title' => __('Categories', 'imic-framework-admin'),
            'subtitle' => __('Show categories for listing.', 'imic-framework-admin'),
            'options' => array('0' => 'No', '1' => 'Yes'),
            'default' => '0',
        ),
		array(
			'id'       => 'badge_specs',
			'multi'		=> true,
			'type'     => 'select',
			'title'    => __('Badges', 'imic-framework-admin'), 
			'desc'     => __('Select specification for badges on listing featured image, can show upto 4 only.', 'imic-framework-admin'),
			'data'  => 'post',
			'sortable'	=> true,
			'args' => array('post_type' => array('specification'),'posts_per_page'=>-1),
			'default'  => '',
		),
		array(
			'id'       => 'additional_specs',
			'multi'		=> false,
			//'sortable'	=> true,
			'type'     => 'select',
			'title'    => __('Additional Specification', 'imic-framework-admin'), 
			'desc'     => __('Select specification to show on homepage grid, numeric specifications could not work for this area.', 'imic-framework-admin'),
			'data'  => 'post',
			'args' => array('post_type' => array('specification'),'posts_per_page'=>-1),
			'default'  => '',
		),
		array(
			'id'       => 'highlighted_specs',
			'multi'		=> true,
			'sortable'	=> true,
			'type'     => 'select',
			'title'    => __('Title', 'imic-framework-admin'), 
			'desc'     => __('Select specifications which makes a listing title in together', 'imic-framework-admin'),
			'data'  => 'post',
			'args' => array('post_type' => array('specification'),'posts_per_page'=>-1),
			'default'  => '',
		),
		array(
			'id'       => 'unique_specs',
			'multi'		=> false,
			'sortable'	=> false,
			'type'     => 'select',
			'title'    => __('Price', 'imic-framework-admin'), 
			'desc'     => __('Select specification to show for price.', 'imic-framework-admin'),
			'data'  => 'post',
			'args' => array('post_type' => array('specification'),'posts_per_page'=>-1),
			'default'  => '',
		),
		array(
			'id'       => 'vehicle_specs',
			'multi'		=> true,
			'sortable'	=> true,
			'type'     => 'select',
			'title'    => __('Detail Specification', 'imic-framework-admin'), 
			'desc'     => __('Select detail specification for homepage, can show upto 4 only.', 'imic-framework-admin'),
			'data'  => 'post',
			'args' => array('post_type' => array('specification'),'posts_per_page'=>-1),
			'default'  => '',
		),
		array(
			'id'       => 'specification_list',
			'multi'		=> true,
			'sortable'	=> true,
			'type'     => 'select',
			'title'    => __('Specification for listing', 'imic-framework-admin'), 
			'desc'     => __('Select specification for listing page.', 'imic-framework-admin'),
			'data'  => 'post',
			'args' => array('post_type' => array('specification'),'posts_per_page'=>-1),
			'default'  => '',
		),
		array(
			'id'       => 'compare_specification_list',
			'multi'		=> true,
			'sortable'	=> true,
			'type'     => 'select',
			'title'    => __('Compare Specifications', 'imic-framework-admin'), 
			'desc'     => __('Select specification for vehicle comparision page.', 'imic-framework-admin'),
			'data'  => 'post',
			'args' => array('post_type' => array('specification'),'posts_per_page'=>-1),
			'default'  => '',
		),
		array(
            'id' => 'default_car_image',
            'type' => 'media',
            'compiler' => 'true',
            'title' => __('Vehicle Image', 'imic-framework-admin'),
            'desc' => __('Upload a default image for vehicle', 'imic-framework-admin'),
            'default' => array('url' => ''),
        ),
		array(
            'id' => 'default_dealer_image',
            'type' => 'media',
            'compiler' => 'true',
            'title' => __('Dealer Image', 'imic-framework-admin'),
            'desc' => __('Upload a default image for dealers', 'imic-framework-admin'),
            'default' => array('url' => ''),
        ),
		array(
            'id' => 'distance_calculate',
            'type' => 'select',
            'title' => __('Distance', 'imic-framework-admin'),
            'subtitle' => __('Show distance in.', 'imic-framework-admin'),
            'options' => array('km' => 'KMS', 'miles' => 'Miles'),
            'default' => 'km',
        ),	
		array(
			'id'       => 'opt_plans',
			'type'     => 'radio',
			'title'    => __('Enable Paid Listing', 'redux-framework-demo'), 
			'desc'     => __('Enable Paid Listing, if using plan for listing.', 'redux-framework-demo'),
			//Must provide key => value pairs for radio options
			'options'  => array(
				'1' => 'Enable', 
				'0' => 'disable', 
			),
			'default' => '1'
		),
		array(
			'id'       => 'opt_listing_status',
			'type'     => 'radio',
			'title'    => __('Listing Status', 'redux-framework-demo'), 
			'desc'     => __('Select status of listing after adding.', 'redux-framework-demo'),
			//Must provide key => value pairs for radio options
			'options'  => array(
				'draft' => 'Under Review', 
				'publish' => 'Active', 
			),
			'default' => 'draft'
		),
		/*array(
            'id' => 'category_filters',
            'type' => 'select',
            'title' => __('Category Filters', 'imic-framework-admin'),
            'subtitle' => __('Show filters of their respective categories.', 'imic-framework-admin'),
            'options' => array('0' => 'No', '1' => 'Yes'),
            'default' => '0',
        ),*/	
		array(
            'id' => 'badges_type',
            'type' => 'select',
            'title' => __('Badges Type', 'imic-framework-admin'),
            'subtitle' => __('Select badge type.', 'imic-framework-admin'),
            'options' => array('0' => 'Fix', '1' => 'Categorize'),
            'default' => '0',
        ),	
		array(
            'id' => 'short_specifications',
            'type' => 'select',
            'title' => __('Short Specifications', 'imic-framework-admin'),
            'subtitle' => __('Select short specifications.', 'imic-framework-admin'),
            'options' => array('0' => 'Fix', '1' => 'Categorize'),
            'default' => '0',
        ),	
		array(
            'id' => 'filters_type',
            'type' => 'select',
            'title' => __('Filters', 'imic-framework-admin'),
            'subtitle' => __('Select filters type.', 'imic-framework-admin'),
            'options' => array('0' => 'Fix', '1' => 'Categorize'),
            'default' => '0',
        ),	
		array(
            'id' => 'ad_listing_fields',
            'type' => 'select',
            'title' => __('Ad listing fields', 'imic-framework-admin'),
            'subtitle' => __('Select ad listing fields type.', 'imic-framework-admin'),
            'options' => array('0' => 'Fix', '1' => 'Categorize'),
            'default' => '0',
        ),	
		array(
            'id' => 'search_form_type',
            'type' => 'select',
            'title' => __('Search Form', 'imic-framework-admin'),
            'subtitle' => __('Select search form type.', 'imic-framework-admin'),
            'options' => array('0' => 'Filters', '1' => 'Categorize'),
            'default' => '0',
        ),	
		array(
            'id' => 'listing_details',
            'type' => 'select',
            'title' => __('Listing Details', 'imic-framework-admin'),
            'subtitle' => __('Select listing details type.', 'imic-framework-admin'),
            'options' => array('0' => 'Fix', '1' => 'Categorize'),
            'default' => '0',
        ),	
    )
);
$this->sections[] = array(
    'icon' => 'el-icon-ok-circle',
    'icon_class' => 'icon-large',
    'title' => __('Add Listing Fields', 'imic-framework-admin'),
    'fields' => array(
		array(
            'id' => 'ad_listing_order',
            'type' => 'select',
            'title' => __('Set Default Form', 'imic-framework-admin'),
            'subtitle' => __('Select default form on ad listing.', 'imic-framework-admin'),
            'options' => array('0' => 'Search', '1' => 'Custom Details'),
            'default' => '0',
        ),	
		array(
			'id'       => 'search_vehicle',
			'multi'		=> true,
			'sortable'	=> true,
			'type'     => 'select',
			'title'    => __('Search Vehicle', 'imic-framework-admin'), 
			'desc'     => __('Select specification search vehicle tab.', 'imic-framework-admin'),
			'data'  => 'post',
			'args' => array('post_type' => array('specification'),'posts_per_page'=>-1),
			'default'  => '',
		),
		array(
			'id'       => 'custom_vehicle_details',
			'multi'		=> true,
			'sortable'	=> true,
			'type'     => 'select',
			'title'    => __('Custom Details', 'imic-framework-admin'), 
			'desc'     => __('Select specification to show custom details.', 'imic-framework-admin'),
			'data'  => 'post',
			'args' => array('post_type' => array('specification'),'posts_per_page'=>-1),
			'default'  => '',
		),
		array(
			'id'       => 'vehicle_more_details',
			'multi'		=> true,
			'sortable'	=> true,
			'type'     => 'select',
			'title'    => __('More Details tab', 'imic-framework-admin'), 
			'desc'     => __('Select specification for more details tab.', 'imic-framework-admin'),
			'data'  => 'post',
			'args' => array('post_type' => array('specification'),'posts_per_page'=>-1),
			'default'  => '',
		),
		array(
			'id'       => 'price_guide_specifications',
			'multi'		=> true,
			'sortable'	=> true,
			'type'     => 'select',
			'title'    => __('Price Guide', 'imic-framework-admin'), 
			'desc'     => __('Select specification to find best price while listing.', 'imic-framework-admin'),
			'data'  => 'post',
			'args' => array('post_type' => array('specification'),'posts_per_page'=>-1),
			'default'  => '',
		),
		array(
			'id'       => 'find_guide_specifications',
			'multi'		=> false,
			'sortable'	=> false,
			'type'     => 'select',
			'title'    => __('Find value for above specifications.', 'imic-framework-admin'), 
			'desc'     => __('Select specification which need to find by above matched value.', 'imic-framework-admin'),
			'data'  => 'post',
			'args' => array('post_type' => array('specification'),'posts_per_page'=>-1),
			'default'  => '',
		),
    )
);
$this->sections[] = array(
    'icon' => 'el-icon-list-alt',
    'icon_class' => 'icon-large',
    'title' => __('Search Fields', 'imic-framework-admin'),
    'fields' => array(
		array(
			'id'       => 'search_form',
			'multi'		=> true,
			'sortable'	=> true,
			'type'     => 'select',
			'title'    => __('Search Form', 'imic-framework-admin'), 
			'desc'     => __('Select specification for search form.', 'imic-framework-admin'),
			'data'  => 'post',
			'args' => array('post_type' => array('specification'),'posts_per_page'=>-1),
			'default'  => array(),
		),
		array(
			'id'       => 'search_filter_listing',
			'multi'		=> true,
			'sortable'	=> true,
			'type'     => 'select',
			'title'    => __('Search Filter', 'imic-framework-admin'), 
			'desc'     => __('Select specification for search filter.', 'imic-framework-admin'),
			'data'  => 'post',
			'args' => array('post_type' => array('specification'),'posts_per_page'=>-1),
			'default'  => '',
		),
		array(
			'id'       => 'search_widget1',
			'multi'		=> true,
			'sortable'	=> true,
			'type'     => 'select',
			'title'    => __('Search Shortcode 1', 'imic-framework-admin'), 
			'desc'     => __('Select specifications for search shortcode type 1.', 'imic-framework-admin'),
			'data'  => 'post',
			'args' => array('post_type' => array('specification'),'posts_per_page'=>-1),
			'default'  => array(),
		),
		array(
			'id'       => 'search_widget2',
			'multi'		=> true,
			'sortable'	=> true,
			'type'     => 'select',
			'title'    => __('Search Widget 2', 'imic-framework-admin'), 
			'desc'     => __('Select specifications for search shortcode type 2.', 'imic-framework-admin'),
			'data'  => 'post',
			'args' => array('post_type' => array('specification'),'posts_per_page'=>-1),
			'default'  => '',
		),
    )
);
$this->sections[] = array(
    'icon' => 'el-icon-zoom-in',
    'icon_class' => 'icon-large',
    'title' => __('Listing Details', 'imic-framework-admin'),
    'fields' => array(
		array(
			'id'=>'enquiry_form1',
			'type' => 'button_set',
			'compiler'=>true,
			'title' => __('Enquiry Form 1', 'imic-framework-admin'), 
			'subtitle' => __('Choose the form type for listing details.', 'imic-framework-admin'),
			'options' => array(
					'0' => __('Default','imic-framework-admin'),
					'1' => __('Shortcode','imic-framework-admin'),
					'2' => __('None','imic-framework-admin')
				),
			'default' => '0',
			),
		array(
			'id'               => 'enquiry_form1_editor',
			'required' => array('enquiry_form1','equals','1'),
			'type'             => 'editor',
			'title'            => __('Editor Form1', 'redux-framework-demo'), 
			'subtitle'         => __('You can insert any form shortcode here.', 'redux-framework-demo'),
			'default'          => '',
    		'args'   => array(
        	'teeny'            => false,
			'tinymce'		=> true,
        	'textarea_rows'    => 6
			)
		),
		array(
			'id'=>'enquiry_form2',
			'type' => 'button_set',
			'compiler'=>true,
			'title' => __('Enquiry Form 2', 'imic-framework-admin'), 
			'subtitle' => __('Choose the form type for listing details.', 'imic-framework-admin'),
			'options' => array(
					'0' => __('Default','imic-framework-admin'),
					'1' => __('Shortcode','imic-framework-admin'),
					'2' => __('None','imic-framework-admin')
				),
			'default' => '0',
			),
		array(
			'id'               => 'enquiry_form2_editor',
			'required' => array('enquiry_form2','equals','1'),
			'type'             => 'editor',
			'title'            => __('Editor Form2', 'redux-framework-demo'), 
			'subtitle'         => __('You can insert any form shortcode here.', 'redux-framework-demo'),
			'default'          => '',
    		'args'   => array(
        	'teeny'            => false,
			'tinymce'		=> true,
        	'textarea_rows'    => 6
			)
		),
		array(
			'id'=>'enquiry_form3',
			'type' => 'button_set',
			'compiler'=>true,
			'title' => __('Enquiry Form 3', 'imic-framework-admin'), 
			'subtitle' => __('Choose the form type for listing details.', 'imic-framework-admin'),
			'options' => array(
					'0' => __('Default','imic-framework-admin'),
					'1' => __('Shortcode','imic-framework-admin'),
					'2' => __('None','imic-framework-admin')
				),
			'default' => '0',
			),
		array(
			'id'               => 'enquiry_form3_editor',
			'required' => array('enquiry_form3','equals','1'),
			'type'             => 'editor',
			'title'            => __('Editor Form3', 'redux-framework-demo'), 
			'subtitle'         => __('You can insert any form shortcode here.', 'redux-framework-demo'),
			'default'          => '',
    		'args'   => array(
        	'teeny'            => false,
			'tinymce'		=> true,
        	'textarea_rows'    => 6
			)
		),
		array(
			'id'       => 'side_specifications',
			'multi'		=> true,
			'sortable'	=> true,
			'type'     => 'select',
			'title'    => __('Featured Specifications', 'imic-framework-admin'), 
			'desc'     => __('Select specification for list.', 'imic-framework-admin'),
			'data'  => 'post',
			'args' => array('post_type' => array('specification'),'posts_per_page'=>-1),
			'default'  => '',
		),
		array(
			'id'       => 'normal_specifications',
			'multi'		=> true,
			'sortable'	=> true,
			'type'     => 'select',
			'title'    => __('Detailed Specifications', 'imic-framework-admin'), 
			'desc'     => __('Select specification.', 'imic-framework-admin'),
			'data'  => 'post',
			'args' => array('post_type' => array('specification'),'posts_per_page'=>-1),
			'default'  => '',
		),
		array(
			'id'       => 'related_specifications',
			'multi'		=> true,
			'sortable'	=> true,
			'type'     => 'select',
			'title'    => __('Related Vehicles', 'imic-framework-admin'), 
			'desc'     => __('Select specification to find related vehicles.', 'imic-framework-admin'),
			'data'  => 'post',
			'args' => array('post_type' => array('specification'),'posts_per_page'=>-1),
			'default'  => '',
		),
		array(
                        'id' => 'details_tab',
                        'type' => 'text_group',
                        'title' => __('Listing Details Tab', 'framework'),
                        'subtitle' => __('Add tabs for listing, use [content], [specifications], [location], [tab-area1], [tab-area2], [tab-area3], [tab-area4] & [features].', 'framework'),
                        'placeholder' => array(
                            'title' => __('Enter tab name', 'framework'),
                            'description' => __('Enter shortcode Ex-[content], [specifications], [features].', 'framework'),
                            //'url' => __("Enter plan price", 'framework'),
                        ),
                    ),
    )
);
$this->sections[] = array(
    'icon' => 'el-icon-credit-card',
    'icon_class' => 'icon-large',
    'title' => __('Paypal Settings', 'imic-framework-admin'),
    'fields' => array(
		array(
			'id'       => 'paypal_email',
			'type'     => 'text',
			'title'    => __('Paypal Email Address', 'imic-framework-admin'), 
			'desc'     => __('Enter Paypal Business Email Address.', 'imic-framework-admin'),
			'default'  => '',
		),
		array(
			'id'       => 'paypal_token',
			'type'     => 'text',
			'title'    => __('Paypal Token', 'imic-framework-admin'), 
			'desc'     => __('Enter Paypal Token ID.', 'imic-framework-admin'),
			'default'  => '',
		),
		array(
            'id' => 'paypal_site',
            'type' => 'select',
            'title' => __('Paypal Site', 'imic-framework-admin'),
            'subtitle' => __('Select paypal site.', 'imic-framework-admin'),
            'options' => array('0' => 'Sandbox', '1' => 'Live'),
            'default' => '1',
        ),	
		array(
            'id' => 'paypal_currency',
            'type' => 'select',
            'title' => __('Payment Currency', 'imic-framework-admin'),
            'subtitle' => __('Select payment currency.', 'imic-framework-admin'),
            'options' => array('USD' => 'USD', 'GBP' => 'GBP', 'EUR' => 'EUR', 'AUD' => 'AUD', 'CAD' => 'CAD', 'NZD' => 'NZD', 'HKD' => 'HKD'),
            'default' => 'USD',
        ),	
    )
);
$this->sections[] = array(
    'icon' => 'el-icon-envelope-alt',
    'icon_class' => 'icon-large',
    'title' => __('Email Messages', 'imic-framework-admin'),
    'fields' => array(
		array(
			  'id' => 'enquiry_form',
			  'type' => 'ace_editor',
			  'title' => __('Enquiry Form', 'framework'),
			  'subtitle' => __('Paste your HTML email code here.', 'framework'),
			  'mode' => 'html',
			  'theme' => 'chrome',
			  'desc' => __('', 'framework'),
			  'default' => "Thanks for email, we will contact you shortly."
		  ),
		array(
			  'id' => 'agent_register',
			  'type' => 'ace_editor',
			  'title' => __('Dealer Registration', 'framework'),
			  'subtitle' => __('Paste your HTML email code here.', 'framework'),
			  'mode' => 'html',
			  'theme' => 'chrome',
			  'desc' => __('', 'framework'),
			  'default' => "Thanks for registration, we will contact you shortly."
		  ),
		array(
			'id' => 'payment_success_mail',
			'type' => 'ace_editor',
			'title' => __('Payment Success', 'framework'),
			'subtitle' => __('Enter html code for email on successfull payment.', 'framework'),
			'mode' => 'html',
			'theme' => 'chrome',
			'desc' => __('', 'framework'),
			'default' => "Thanks for listing Ad, we will review your ad and try to publish instantly."
		),
    )
);
$this->sections[] = array(
    'icon' => 'el-icon-share',
    'title' => __('Share Options', 'imic-framework-admin'),
    'fields' => array(
        array(
            'id' => 'switch_sharing',
            'type' => 'switch',
            'title' => __('Social Sharing', 'imic-framework-admin'),
            'subtitle' => __('Enable/Disable theme default social sharing buttons for posts/pages/cars single pages', 'imic-framework-admin'	
			),
            "default" => 1,
       		),
		 array(
			'id'=>'sharing_style',
			'type' => 'button_set',
			'compiler'=>true,
			'title' => __('Share Buttons Style', 'imic-framework-admin'), 
			'subtitle' => __('Choose the style of share button icons', 'imic-framework-admin'),
			'options' => array(
					'0' => __('Rounded','imic-framework-admin'),
					'1' => __('Squared','imic-framework-admin')
				),
			'default' => '0',
			),
		 array(
			'id'=>'sharing_color',
			'type' => 'button_set',
			'compiler'=>true,
			'title' => __('Share Buttons Color', 'imic-framework-admin'), 
			'subtitle' => __('Choose the color scheme of the share button icons', 'imic-framework-admin'),
			'options' => array(
					'0' => __('Brand Colors','imic-framework-admin'),
					'1' => __('Theme Color','imic-framework-admin'),
					'2' => __('GrayScale','imic-framework-admin')
				),
			'default' => '2',
			),
		array(
			'id'       => 'share_icon',
			'type'     => 'checkbox',
			'required' => array('switch_sharing','equals','1'),
			'title'    => __('Social share options', 'redux-framework-demo'),
			'subtitle' => __('Click on the buttons to disable/enable share buttons', 'redux-framework-demo'),
			'options'  => array(
				'1' => 'Facebook',
				'2' => 'Twitter',
				'3' => 'Google',
				'4' => 'Tumblr',
				'5' => 'Pinterest',
				'6' => 'Reddit',
				'7' => 'Linkedin',
				'8' => 'Email',
				'9' => 'VKontakte'
			),
			'default' => array(
				'1' => '1',
				'2' => '1',
				'3' => '1',
				'4' => '1',
				'5' => '1',
				'6' => '1',
				'7' => '1',
				'8' => '1',
				'9' => '1'
			)
		),
		array(
			'id'       => 'share_post_types',
			'type'     => 'checkbox',
			'required' => array('switch_sharing','equals','1'),
			'title'    => __('Select share buttons for post types', 'imic-framework-admin'),
			'subtitle'     => __('Uncheck to disable for any type', 'imic-framework-admin'),
			'options'  => array(
				'1' => 'Posts',
				'2' => 'Pages',
				'3' => 'Listings',
			),
			'default' => array(
				'1' => '1',
				'2' => '1',
				'3' => '1',
			)
		),
		array(
            'id' => 'facebook_share_alt',
            'type' => 'text',
            'title' => __('Tooltip text for Facebook share icon', 'imic-framework-admin'),
            'subtitle' => __('Text for the Facebook share icon browser tooltip.', 'imic-framework-admin'),
            'default' => 'Share on Facebook'
        ),
		array(
            'id' => 'twitter_share_alt',
            'type' => 'text',
            'title' => __('Tooltip text for Twitter share icon', 'imic-framework-admin'),
            'subtitle' => __('Text for the Twitter share icon browser tooltip.', 'imic-framework-admin'),
            'default' => 'Tweet'
        ),
		array(
            'id' => 'google_share_alt',
            'type' => 'text',
            'title' => __('Tooltip text for Google Plus share icon', 'imic-framework-admin'),
            'subtitle' => __('Text for the Google Plus share icon browser tooltip.', 'imic-framework-admin'),
            'default' => 'Share on Google+'
        ),
		array(
            'id' => 'tumblr_share_alt',
            'type' => 'text',
            'title' => __('Tooltip text for Tumblr share icon', 'imic-framework-admin'),
            'subtitle' => __('Text for the Tumblr share icon browser tooltip.', 'imic-framework-admin'),
            'default' => 'Post to Tumblr'
        ),
		array(
            'id' => 'pinterest_share_alt',
            'type' => 'text',
            'title' => __('Tooltip text for Pinterest share icon', 'imic-framework-admin'),
            'subtitle' => __('Text for the Pinterest share icon browser tooltip.', 'imic-framework-admin'),
            'default' => 'Pin it'
        ),
		array(
            'id' => 'reddit_share_alt',
            'type' => 'text',
            'title' => __('Tooltip text for Reddit share icon', 'imic-framework-admin'),
            'subtitle' => __('Text for the Reddit share icon browser tooltip.', 'imic-framework-admin'),
            'default' => 'Submit to Reddit'
        ),
		array(
            'id' => 'linkedin_share_alt',
            'type' => 'text',
            'title' => __('Tooltip text for Linkedin share icon', 'imic-framework-admin'),
            'subtitle' => __('Text for the Linkedin share icon browser tooltip.', 'imic-framework-admin'),
            'default' => 'Share on Linkedin'
        ),
		array(
            'id' => 'email_share_alt',
            'type' => 'text',
            'title' => __('Tooltip text for Email share icon', 'imic-framework-admin'),
            'subtitle' => __('Text for the Email share icon browser tooltip.', 'imic-framework-admin'),
            'default' => 'Email'
        ),
		array(
            'id' => 'vk_share_alt',
            'type' => 'text',
            'title' => __('Tooltip text for vk share icon', 'imic-framework-admin'),
            'subtitle' => __('Text for the vk share icon browser tooltip.', 'imic-framework-admin'),
            'default' => 'Share on vk'
        ),
	)
);
$this->sections[] = array(
    'icon' => 'el-icon-edit',
    'title' => __('Custom CSS/JS', 'imic-framework-admin'),
    'fields' => array(
        array(
            'id' => 'custom_css',
            'type' => 'ace_editor',
            //'required' => array('layout','equals','1'),	
            'title' => __('CSS Code', 'imic-framework-admin'),
            'subtitle' => __('Paste your CSS code here.', 'imic-framework-admin'),
            'mode' => 'css',
            'theme' => 'monokai',
            'desc' => '',
            'default' => "#header{\nmargin: 0 auto;\n}"
        ),
        array(
            'id' => 'custom_js',
            'type' => 'ace_editor',
            //'required' => array('layout','equals','1'),	
            'title' => __('JS Code', 'imic-framework-admin'),
            'subtitle' => __('Paste your JS code here.', 'imic-framework-admin'),
            'mode' => 'javascript',
            'theme' => 'chrome',
            'desc' => '',
            'default' => "jQuery(document).ready(function(){\n\n});"
        )
    ),
);
$this->sections[] = array(
                'title' => __('Import / Export', 'imic-framework-admin'),
                'desc' => __('Import and Export your Theme Framework settings from file, text or URL.', 'imic-framework-admin'),
                'icon' => 'el-icon-refresh',
                'fields' => array(
                    array(
                        'id' => 'opt-import-export',
                        'type' => 'import_export',
                       'title' => __('Import Export','imic-framework-admin'),
                        'subtitle' => __('Save and restore your Theme options','imic-framework-admin'),
                        'full_width' => false,
                    ),
                ),
            ); 
                       if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
                $tabs['docs'] = array(
                    'icon'      => 'el-icon-book',
                    'title'     => __('Documentation', 'imic-framework-admin'),
                    'content'   => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
                );
            }
        }
        public function setHelpTabs() {
            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'imic-framework-admin'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'imic-framework-admin')
            );
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'imic-framework-admin'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'imic-framework-admin')
            );
            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'imic-framework-admin');
        }
        /**
          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments() {
            $theme = wp_get_theme(); // For use with some settings. Not necessary.
            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'imic_options',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => __('Theme Options', 'imic-framework-admin'),
                'page_title'        => __('IMIC Options', 'imic-framework-admin'),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => 'AIzaSyDzJyslYLbuwBAqc_UTRokHKAY1ZaXrotk', // Must be defined to add google fonts to the typography module
                
                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => true,                    // Enable basic customizer support
                
                // OPTIONAL -> Give you extra features
                'page_priority'     => '57',                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => false,                   // Shows the Import/Export panel when not used as a field.
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false, // REMOVE
                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );
            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/imithemes',
                'title' => 'Like us on Facebook',
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://twitter.com/imithemes',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el-icon-twitter'
            );
            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
                $this->args['intro_text'] = sprintf(__('<p>Did you know that we sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'imic-framework-admin'), $v);
            } else {
                //$this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'imic-framework-admin');
            }
            // Add content after the form.
            //$this->args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'imic-framework-admin');
        }
    }
    
    global $reduxConfig;
    $reduxConfig = new Redux_Framework_sample_config();
}
/**
  Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;
/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';
        /*
          do your validation
          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */
        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;