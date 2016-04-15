<?php
/**
 * Extension-Boilerplate
 * @link https://github.com/ReduxFramework/extension-boilerplate
 *
 * Radium Importer - Modified For ReduxFramework
 * @link https://github.com/FrankM1/radium-one-click-demo-install
 *
 * @package     WBC_Importer - Extension for Importing demo content
 * @author      Webcreations907
 * @version     1.0.1
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Don't duplicate me!
if ( !class_exists( 'ReduxFramework_extension_wbc_importer' ) ) {


	/************************************************************************
	* Extended Example:
	* Way to set menu, import revolution slider, and set home page.
	*************************************************************************/
	if ( !function_exists( 'wbc_extended_example' ) ) {
		function wbc_extended_example( $demo_active_import , $demo_directory_path ) {
			reset( $demo_active_import );
			$current_key = key( $demo_active_import );
			/************************************************************************
			* Import slider(s) for the current demo being imported
			*************************************************************************/
			if ( class_exists( 'RevSlider' ) ) {
				//If it's demo1
				$wbc_sliders_array = array(
					'demo1' => 'home5.zip', //Set slider zip name
					'demo2' => 'home5.zip', //Set slider zip name
					'demo3' => 'home5.zip', //Set slider zip name
				);
				if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_sliders_array ) ) {
					$wbc_slider_import = $wbc_sliders_array[$demo_active_import[$current_key]['directory']];
					if ( file_exists( $demo_directory_path.$wbc_slider_import ) ) {
						$slider = new RevSlider();
						$slider->importSliderFromPost( true, true, $demo_directory_path.$wbc_slider_import );
					}
				}
			}
			/************************************************************************
			* Setting Menus
			*************************************************************************/
			// If it's demo1 - demo6
			$wbc_menu_array = array( 'demo1','demo2','demo3' );
			if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && in_array( $demo_active_import[$current_key]['directory'], $wbc_menu_array ) ) {
				$top_menu = get_term_by( 'name', 'Top Menu', 'nav_menu' );
				$primary_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
				if ( isset( $top_menu->term_id ) ) {
					set_theme_mod( 'nav_menu_locations', array(
						'top-menu' => $top_menu->term_id,
						'primary-menu' => $primary_menu->term_id
					)
				);
			}
		}
		/************************************************************************
		* Set HomePage
		*************************************************************************/
		// array of demos/homepages to check/select from
		$wbc_home_pages = array(
			'demo1' => 'Home',
			'demo2' => 'Classified Page',
			'demo3' => 'Home',
		);
		$wbc_blog_pages = array(
			'demo1' => 'Blog',
			'demo2' => 'Blog',
			'demo3' => 'Blog',
		);
		if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_home_pages ) ) {
			$page = get_page_by_title( $wbc_home_pages[$demo_active_import[$current_key]['directory']] );
			if ( isset( $page->ID ) ) {
				update_option('imic_data_imported_status', 1);
				if($demo_active_import[$current_key]['directory']=="demo2")
				{
				//Update Classified Data
				$sb = 'a:13:{i:17;a:6:{s:5:"badge";s:0:"";s:5:"lists";s:0:"";s:6:"filter";s:11:"40,41,37,34";s:2:"ad";s:49:"2926,46,45,44,43,42,41,40,39,38,37,36,35,34,33,31";s:8:"featured";s:0:"";s:8:"detailed";s:0:"";}i:30;a:6:{s:5:"badge";s:0:"";s:5:"lists";s:0:"";s:6:"filter";s:22:"9,11,10,13,24,25,28,17";s:2:"ad";s:74:"4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30";s:8:"featured";s:0:"";s:8:"detailed";s:0:"";}i:19;a:6:{s:5:"badge";s:5:"34,31";s:5:"lists";s:14:"45,44,41,38,37";s:6:"filter";s:14:"40,41,37,34,31";s:2:"ad";s:49:"2926,46,45,44,43,42,41,40,39,38,37,36,35,34,33,31";s:8:"featured";s:41:"45,44,43,42,41,40,39,38,37,36,35,34,33,31";s:8:"detailed";s:41:"45,44,43,42,41,40,39,38,37,36,35,34,33,31";}i:22;a:6:{s:5:"badge";s:8:"42,41,40";s:5:"lists";s:14:"38,37,35,34,36";s:6:"filter";s:14:"45,40,34,35,37";s:2:"ad";s:49:"2926,46,45,44,43,42,41,40,39,38,37,36,35,34,33,31";s:8:"featured";s:41:"45,44,43,42,41,40,39,38,37,36,35,34,33,31";s:8:"detailed";s:41:"45,44,43,42,41,40,39,38,37,36,35,34,33,31";}i:89;a:6:{s:5:"badge";s:9:"3002,2996";s:5:"lists";s:19:"3004,3003,3002,2996";s:6:"filter";s:19:"3006,3005,3004,3003";s:2:"ad";s:62:"2926,46,3006,3005,3004,3003,3002,2996,2997,2998,2999,3000,3001";s:8:"featured";s:54:"3006,3005,3004,3003,3002,2996,2997,2998,2999,3000,3001";s:8:"detailed";s:54:"3006,3005,3004,3003,3002,2996,2997,2998,2999,3000,3001";}i:62;a:6:{s:5:"badge";s:5:"28,17";s:5:"lists";s:11:"28,30,22,21";s:6:"filter";s:8:"29,28,17";s:2:"ad";s:49:"2926,46,30,29,28,27,26,25,24,23,22,21,20,19,18,17";s:8:"featured";s:41:"30,28,29,27,26,25,24,23,22,21,20,19,18,17";s:8:"detailed";s:41:"62,28,29,27,26,25,24,23,22,21,20,19,18,17";}i:75;a:6:{s:5:"badge";s:0:"";s:5:"lists";s:0:"";s:6:"filter";s:14:"3006,3004,3003";s:2:"ad";s:62:"2926,46,3006,3005,3004,3003,3002,3001,3000,2999,2998,2997,2996";s:8:"featured";s:0:"";s:8:"detailed";s:0:"";}i:115;a:6:{s:5:"badge";s:9:"3002,3001";s:5:"lists";s:14:"3003,3002,3001";s:6:"filter";s:14:"3006,3005,3003";s:2:"ad";s:57:"2926,46,3006,3005,3003,3002,2996,2997,2998,2999,3000,3001";s:8:"featured";s:49:"3006,3005,3003,3002,2996,2997,2998,2999,3000,3001";s:8:"detailed";s:49:"3006,3005,3003,3002,2996,2997,2998,2999,3000,3001";}i:65;a:6:{s:5:"badge";s:0:"";s:5:"lists";s:0:"";s:6:"filter";s:8:"62,63,59";s:2:"ad";s:22:"2926,46,63,62,61,60,59";s:8:"featured";s:0:"";s:8:"detailed";s:0:"";}i:98;a:6:{s:5:"badge";s:5:"63,60";s:5:"lists";s:5:"63,62";s:6:"filter";s:5:"62,63";s:2:"ad";s:19:"2926,46,62,63,61,60";s:8:"featured";s:11:"63,62,61,60";s:8:"detailed";s:11:"63,62,61,60";}i:100;a:6:{s:5:"badge";s:5:"59,60";s:5:"lists";s:5:"62,59";s:6:"filter";s:5:"62,59";s:2:"ad";s:19:"2926,46,62,61,60,59";s:8:"featured";s:11:"62,61,60,59";s:8:"detailed";s:11:"62,61,60,59";}i:90;a:6:{s:5:"badge";s:5:"4,5,7";s:5:"lists";s:8:"7,9,15,4";s:6:"filter";s:7:"5,4,7,9";s:2:"ad";s:40:"2926,46,4,5,6,7,8,9,10,11,12,13,14,15,16";s:8:"featured";s:32:"4,5,6,7,8,9,10,11,12,13,14,15,16";s:8:"detailed";s:32:"4,5,6,7,8,9,10,11,12,13,14,15,16";}i:67;a:6:{s:5:"badge";s:5:"47,53";s:5:"lists";s:11:"58,54,53,48";s:6:"filter";s:17:"58,54,53,49,48,55";s:2:"ad";s:37:"2926,46,51,50,58,54,49,53,56,48,55,57";s:8:"featured";s:32:"51,50,58,54,49,53,56,57,48,47,55";s:8:"detailed";s:32:"47,51,50,58,54,49,53,56,57,48,55";}}';
				$sn = unserialize($sb);
				update_option('imic_classifieds', '');
				update_option('imic_classifieds', $sn);
				
				//Update User ID for User Info
				$userdata_services = array(
					'user_login'  =>  'services inc',
					'user_url'    =>  '',
					'role'		=>	'dealer',
					'user_pass'   =>  'demo'  // When creating an user, `user_pass` is expected.
				);
				$user_id_services = wp_insert_user( $userdata_services ) ;
				if( !is_wp_error($user_id_services) ) {
				 update_user_meta($user_id_services,'imic_user_info_id',3102);
				 add_post_meta(3102,'imic_user_reg_id',$user_id_services);
				}
				$userdata_home = array(
					'user_login'  =>  'home design',
					'user_url'    =>  '',
					'role'		=>	'dealer',
					'user_pass'   =>  'demo'  // When creating an user, `user_pass` is expected.
				);
				$user_id_home = wp_insert_user( $userdata_home ) ;
				if( !is_wp_error($user_id_home) ) {
				 update_user_meta($user_id_home,'imic_user_info_id',3100);
				 add_post_meta(3100,'imic_user_reg_id',$user_id_home);
				}
				$userdata_mobile = array(
					'user_login'  =>  'mobile Sellers',
					'user_url'    =>  '',
					'role'		=>	'dealer',
					'user_pass'   =>  'demo'  // When creating an user, `user_pass` is expected.
				);
				$user_id_mobile = wp_insert_user( $user_id_home ) ;
				if( !is_wp_error($user_id_mobile) ) {
				 update_user_meta($user_id_mobile,'imic_user_info_id', 3099);
				 add_post_meta(3099,'imic_user_reg_id',$user_id_mobile);
				}
				$userdata_ac = array(
					'user_login'  =>  'ac Sellers',
					'user_url'    =>  '',
					'role'		=>	'dealer',
					'user_pass'   =>  'demo'  // When creating an user, `user_pass` is expected.
				);
				$user_id_ac = wp_insert_user( $userdata_ac ) ;
				if( !is_wp_error($user_id_ac) ) {
				 update_user_meta($user_id_ac,'imic_user_info_id', 3098);
				 add_post_meta(3098,'imic_user_reg_id',$user_id_ac);
				}
				$userdata_car = array(
					'user_login'  =>  'car Sellers',
					'user_url'    =>  '',
					'role'		=>	'dealer',
					'user_pass'   =>  'demo'  // When creating an user, `user_pass` is expected.
				);
				$user_id_car = wp_insert_user( $userdata_car ) ;
				if( !is_wp_error($user_id_car) ) {
				 update_user_meta($user_id_car,'imic_user_info_id', 3094);
				 add_post_meta(3094,'imic_user_reg_id',$user_id_car);
				}
				$userdata_pet = array(
					'user_login'  =>  'pet Sellers',
					'user_url'    =>  '',
					'role'		=>	'dealer',
					'user_pass'   =>  'demo'  // When creating an user, `user_pass` is expected.
				);
				$user_id_pet = wp_insert_user( $userdata_pet ) ;
				if( !is_wp_error($user_id_pet) ) {
				 update_user_meta($user_id_pet,'imic_user_info_id', 3090);
				 add_post_meta(3090,'imic_user_reg_id',$user_id_pet);
				}
				}
				//Update User ID for User Info
				update_option( 'page_on_front', $page->ID );
				update_option( 'show_on_front', 'page' );
				update_user_meta(1,'imic_user_info_id',359);
				$userdata_fte = array(
					'user_login'  =>  'fte',
					'user_url'    =>  '',
					'role'		=>	'dealer',
					'user_pass'   =>  'demo'  // When creating an user, `user_pass` is expected.
				);
				$user_id_fte = wp_insert_user( $userdata_fte ) ;
				if( !is_wp_error($user_id_fte) ) {
				 update_user_meta($user_id_fte,'imic_user_info_id',203);
				 add_post_meta(203,'imic_user_reg_id',$user_id_fte);
				}
				$userdata_speedx = array(
					'user_login'  =>  'Speedx',
					'user_url'    =>  '',
					'role'		=>	'dealer',
					'user_pass'   =>  'demo'  // When creating an user, `user_pass` is expected.
				);
				$user_id_speedx = wp_insert_user( $userdata_speedx ) ;
				if( !is_wp_error($user_id_speedx) ) {
				 update_user_meta($user_id_speedx,'imic_user_info_id',279);
				 add_post_meta(279,'imic_user_reg_id',$user_id_speedx);
				}
				$userdata_carseller = array(
					'user_login'  =>  'Car Sellers',
					'user_url'    =>  '',
					'role'		=>	'dealer',
					'user_pass'   =>  'demo'  // When creating an user, `user_pass` is expected.
				);
				$user_id_carseller = wp_insert_user( $userdata_carseller ) ;
				if( !is_wp_error($user_id_carseller) ) {
				 update_user_meta($user_id_carseller,'imic_user_info_id',278);
				 add_post_meta(278,'imic_user_reg_id',$user_id_carseller);
				}
			}
		}
		if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_blog_pages ) ) {
			$bpage = get_page_by_title( $wbc_blog_pages[$demo_active_import[$current_key]['directory']] );
			if ( isset( $bpage->ID ) ) {
				update_option( 'page_for_posts', $bpage->ID );
			}
		}
	}
	// Uncomment the below
	add_action( 'wbc_importer_after_content_import', 'wbc_extended_example', 10, 2 );
	}


    class ReduxFramework_extension_wbc_importer {

        public static $instance;

        static $version = "1.0.1";

        protected $parent;

        private $filesystem = array();

        public $extension_url;

        public $extension_dir;

        public $demo_data_dir;

        public $wbc_import_files = array();

        public $active_import_id;

        public $active_import;


        /**
         * Class Constructor
         *
         * @since       1.0
         * @access      public
         * @return      void
         */
        public function __construct( $parent ) {

            $this->parent = $parent;

            if ( !is_admin() ) return;

            //Hides importer section if anything but true returned. Way to abort :)
            if ( true !== apply_filters( 'wbc_importer_abort', true ) ) {
                return;
            }

            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
                $this->demo_data_dir = apply_filters( "wbc_importer_dir_path", $this->extension_dir . 'demo-data/' );
            }

            //Delete saved options of imported demos, for dev/testing purpose
            // delete_option('wbc_imported_demos');

            $this->getImports();

            $this->field_name = 'wbc_importer';

            self::$instance = $this;

            add_filter( 'redux/' . $this->parent->args['opt_name'] . '/field/class/' . $this->field_name, array( &$this,
                    'overload_field_path'
                ) );

            add_action( 'wp_ajax_redux_wbc_importer', array(
                    $this,
                    'ajax_importer'
                ) );

            add_filter( 'redux/'.$this->parent->args['opt_name'].'/field/wbc_importer_files', array(
                    $this,
                    'addImportFiles'
                ) );

            //Adds Importer section to panel
            $this->add_importer_section();


        }


        public function getImports() {

            if ( !empty( $this->wbc_import_files ) ) {
                return $this->wbc_import_files;
            }

            $this->filesystem = $this->parent->filesystem->execute( 'object' );

            $imports = $this->filesystem->dirlist( $this->demo_data_dir, false, true );

            $imported = get_option( 'wbc_imported_demos' );

            if ( !empty( $imports ) ) {
                $x = 1;
                foreach ( $imports as $import ) {

                    if ( !isset( $import['files'] ) || empty( $import['files'] ) ) {
                        continue;
                    }

                    if ( $import['type'] == "d" && !empty( $import['name'] ) ) {
                        $this->wbc_import_files['wbc-import-'.$x] = isset( $this->wbc_import_files['wbc-import-'.$x] ) ? $this->wbc_import_files['wbc-import-'.$x] : array();
                        $this->wbc_import_files['wbc-import-'.$x]['directory'] = $import['name'];

                        if ( !empty( $imported ) && is_array( $imported ) ) {
                            if ( array_key_exists( 'wbc-import-'.$x, $imported ) ) {
                                $this->wbc_import_files['wbc-import-'.$x]['imported'] = 'imported';
                            }
                        }

                        foreach ( $import['files'] as $file ) {
                            switch ( $file['name'] ) {
                            case 'content.xml':
                                $this->wbc_import_files['wbc-import-'.$x]['content_file'] = $file['name'];
                                break;

                            case 'theme-options.txt':
                            case 'theme-options.json':
                                $this->wbc_import_files['wbc-import-'.$x]['theme_options'] = $file['name'];
                                break;

                            case 'widgets.json':
                            case 'widgets.txt':
                                $this->wbc_import_files['wbc-import-'.$x]['widgets'] = $file['name'];
                                break;

                            case 'screen-image.png':
                            case 'screen-image.jpg':
                            case 'screen-image.gif':
                                $this->wbc_import_files['wbc-import-'.$x]['image'] = $file['name'];
                                break;
                            }

                        }

                        if ( !isset( $this->wbc_import_files['wbc-import-'.$x]['content_file'] ) ) {
                            unset( $this->wbc_import_files['wbc-import-'.$x] );
                            if ( $x > 1 ) $x--;
                        }

                    }

                    $x++;
                }

            }

        }

        public function addImportFiles( $wbc_import_files ) {

            if ( !is_array( $wbc_import_files ) || empty( $wbc_import_files ) ) {
                $wbc_import_files = array();
            }

            $wbc_import_files = wp_parse_args( $wbc_import_files, $this->wbc_import_files );

            return $wbc_import_files;
        }

        public function ajax_importer() {
            if ( !isset( $_REQUEST['nonce'] ) || !wp_verify_nonce( $_REQUEST['nonce'], "redux_{$this->parent->args['opt_name']}_wbc_importer" ) ) {
                die( 0 );
            }
            if ( isset( $_REQUEST['type'] ) && $_REQUEST['type'] == "import-demo-content" && array_key_exists( $_REQUEST['demo_import_id'], $this->wbc_import_files ) ) {

                $reimporting = false;

                if( isset( $_REQUEST['wbc_import'] ) && $_REQUEST['wbc_import'] == 're-importing'){
                    $reimporting = true;
                }

                $this->active_import_id = $_REQUEST['demo_import_id'];

                $import_parts         = $this->wbc_import_files[$this->active_import_id];

                $this->active_import = array( $this->active_import_id => $import_parts );

                $content_file        = $import_parts['directory'];
                $demo_data_loc       = $this->demo_data_dir.$content_file;

                if ( file_exists( $demo_data_loc.'/'.$import_parts['content_file'] ) && is_file( $demo_data_loc.'/'.$import_parts['content_file'] ) ) {

                    if ( !isset( $import_parts['imported'] ) || true === $reimporting ) {
                        include $this->extension_dir.'inc/init-installer.php';
                        $installer = new Radium_Theme_Demo_Data_Importer( $this, $this->parent );
                    }else {
                        echo esc_html__( "Demo Already Imported", 'framework' );
                    }
                }

                die();
            }

            die();
        }

        public static function get_instance() {
            return self::$instance;
        }

        // Forces the use of the embeded field path vs what the core typically would use
        public function overload_field_path( $field ) {
            return dirname( __FILE__ ) . '/' . $this->field_name . '/field_' . $this->field_name . '.php';
        }

        function add_importer_section() {
            // Checks to see if section was set in config of redux.
            for ( $n = 0; $n < count( $this->parent->sections ); $n++ ) {
                if ( isset( $this->parent->sections[$n]['id'] ) && $this->parent->sections[$n]['id'] == 'wbc_importer_section' ) {
                    return;
                }
            }

            $wbc_importer_label = trim( esc_html( apply_filters( 'wbc_importer_label', __( 'Demo Importer', 'framework' ) ) ) );

            $wbc_importer_label = ( !empty( $wbc_importer_label ) ) ? $wbc_importer_label : __( 'Demo Importer', 'framework' );

            $this->parent->sections[] = array(
                'id'     => 'wbc_importer_section',
                'title'  => $wbc_importer_label,
                'desc'   => '<p class="description">'. apply_filters( 'wbc_importer_description', esc_html__( 'Works best to import on a new install of WordPress. Once you click the Import demo button, please wait until the loading animation stop with a message Imported in place.', 'framework' ) ).'</p>',
                'icon'   => 'el-icon-website',
                'fields' => array(
                    array(
                        'id'   => 'wbc_demo_importer',
                        'type' => 'wbc_importer'
                    )
                )
            );
        }

    } // class
} // if
