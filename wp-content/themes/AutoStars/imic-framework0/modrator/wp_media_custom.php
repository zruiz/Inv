<?php defined('ABSPATH') or die;
class FRONT_MEDIA_ALLOW
{
	function __construct()
	{
		if(is_user_logged_in() && !is_admin())
		{
			
			add_action('wp_enqueue_scripts', array('FRONT_MEDIA_ALLOW','imic_enqueue_media_uploader'));
			/* add action and filter */
			add_action('wp_footer', array('FRONT_MEDIA_ALLOW','override_css'));
			//add_action('pre_get_posts', array('FRONT_MEDIA_ALLOW','wp_custom_filter_media_files'),100);
			add_action('wp_enqueue_scripts', array('FRONT_MEDIA_ALLOW','add_media_upload_scripts_for_front'));
			//add_filter('wp_count_attachments', array('FRONT_MEDIA_ALLOW','wp_custom_recount_attachments'));
		}
	}
	
	public static function imic_enqueue_media_uploader()
			{
		     wp_register_script(
		       'wp_custom_media_jquery', 
		       IMIC_THEME_PATH.'/imic-framework/modrator/js/wp.media.custom.jquery.js',array(),
		        wp_get_theme()->get( 'Version' ), true
		    );
			wp_enqueue_script('wp_custom_media_jquery');
			}
			
	//Recount attachments for the specific user 
	public static function wp_custom_recount_attachments($views){
		$_total_posts = array();
				$_num_posts = array();
				global $wpdb, $current_user, $post_mime_types, $avail_post_mime_types;
				$views = array();
				$count = $wpdb->get_results( "
					SELECT post_mime_type, COUNT( * ) AS num_posts 
					FROM $wpdb->posts 
					WHERE post_type = 'attachment' 
					AND post_author = $current_user->ID 
					AND post_status != 'trash' 
					GROUP BY post_mime_type
				", ARRAY_A );
				foreach( $count as $row )
					$_num_posts[$row['post_mime_type']] = $row['num_posts'];
				$_total_posts = array_sum($_num_posts);
				$detached = isset( $_REQUEST['detached'] ) || isset( $_REQUEST['find_detached'] );
				if ( !isset( $total_orphans ) )
					$total_orphans = $wpdb->get_var("
						SELECT COUNT( * ) 
						FROM $wpdb->posts 
						WHERE post_type = 'attachment' 
						AND post_author = $current_user->ID 
						AND post_status != 'trash' 
						AND post_parent < 1
					");
				$matches = wp_match_mime_types(array_keys($post_mime_types), array_keys($_num_posts));
				foreach ( $matches as $type => $reals )
					foreach ( $reals as $real )
						$num_posts[$type] = ( isset( $num_posts[$type] ) ) ? $num_posts[$type] + $_num_posts[$real] : $_num_posts[$real];
				$class = ( empty($_GET['post_mime_type']) && !$detached && !isset($_GET['status']) ) ? ' class="current"' : '';
				$views['all'] = "<a href='upload.php'$class>" . sprintf( __('All <span class="count">(%s)</span>', 'uploaded files' ), number_format_i18n( $_total_posts )) . '</a>';
				foreach ( $post_mime_types as $mime_type => $label ) {
					$class = '';
					if ( !wp_match_mime_types($mime_type, $avail_post_mime_types) )
						continue;
					if ( !empty($_GET['post_mime_type']) && wp_match_mime_types($mime_type, $_GET['post_mime_type']) )
						$class = ' class="current"';
					if ( !empty( $num_posts[$mime_type] ) )
						$views[$mime_type] = "<a href='upload.php?post_mime_type=$mime_type'$class>" . sprintf( translate_nooped_plural( $label[2], $num_posts[$mime_type] ), $num_posts[$mime_type] ) . '</a>';
				}
				$views['detached'] = '<a href="upload.php?detached=1"' . ( $detached ? ' class="current"' : '' ) . '>' . sprintf( __( 'Unattached <span class="count">(%s)</span>', 'detached files' ), $total_orphans ) . '</a>';
				return $views;
	}
	/* Filter attachments for the specific user */
	public static function wp_custom_filter_media_files($wp_query){
		global $current_user;
		if( is_admin() && !current_user_can('edit_others_posts') ) {
			$wp_query->set( 'author', $current_user->ID );
			add_filter('views_upload', array('FRONT_MEDIA_ALLOW','wp_custom_recount_attachments'));
			//add_filter('views_upload', 'fix_media_counts');
		}
	}
 /* wp media jquey enque for fornt end*/
	public static function add_media_upload_scripts_for_front() {
		if ( is_admin() ) {
			 return;
		   }
		 if(!did_action( 'wp_enqueue_media' ) )
		 {
		   wp_enqueue_media();
		 }
	}
	
	/* wp media file button */
	/* @param type = array($name,$class,$value,$thumbnail_container_id)
	   $name = name of button,
	   $class = class of button,
	   $value = value for displaying upload button,
	   $thumbnail_container = name of container id where display thumbnail preview(should be unique)
	   @ouptut - display upload button
	*/
	public static function wp_media_upload_button($data = array()) {
		$default = array(
				  'name'                 =>'front_media_uploader',
				  'class'                =>'listing-images-uploads',
				  'value'                =>__('Upload','framework'),
				  'thumbnail_container'  =>'photoList',
		);
	   $data = $default+$data;
	   $data_button  = '';
	   if(is_user_logged_in())
	   {
		  if(Browser::isHTML5() && self::check_file_input_method() == 0)
		  {
			  $data_button .='<input class="listing-images-uploads" type="file" name="images[]" id="photoimg" multiple accept="image/*" />';
		  }
		  else
		  {
			  $data_button .= '<div class="'.$data['class'].'">';
              $data_button .= '<input id="cbafu_button" data-container="'.$data['thumbnail_container'].'" ';
	          $data_button .=' class="'.$data['class'].'"';
		      $data_button .= ' name="'.$data['name'].'" type="button" value="'.$data['value'].'" /></div>';
		  }
		}
		else 
		{
			$data_button .='<input type="file" name="images[]" disabled="disabled" multiple accept="image/*" />';
		}
		
		echo $data_button;
	}
	
	public static function check_file_input_method(){
		$imic              = get_option('imic_options');
		$file_upload_type  = isset($imic['file_upload_type'])?$imic['file_upload_type']:0;
		return $file_upload_type;
	}
	
	
	public static function wp_custom_css()
	{ 
	     echo '<link href="'.IMIC_THEME_PATH.'/imic-framework/modrator/css/wp_custom_media.css'.'" type="text/css" />';
	}
	public static function override_css() { ?>

		<style type="text/css">
        .media-modal .screen-reader-text{
	           display:none;
			}
		.media-modal .button-primary{
				float:right;
			}
		</style>
   <?php
	}
}
// check and test html5 support browsers
 class Browser { 
            public static function detect() { 
                $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']); 
                if ((substr($_SERVER['HTTP_USER_AGENT'],0,6)=="Opera/") || (strpos($userAgent,'opera')) != false ){ 
                    $name = 'opera';
                } 
                elseif ((strpos($userAgent,'chrome')) != false) { 
                    $name = 'chrome'; 
                } 
                elseif ((strpos($userAgent,'safari')) != false && (strpos($userAgent,'chrome')) == false && (strpos($userAgent,'chrome')) == false){ 
                    $name = 'safari'; 
                } 
                elseif (preg_match('/msie/', $userAgent)) { 
                    $name = 'msie'; 
                } 
                elseif ((strpos($userAgent,'firefox')) != false) { 
                    $name = 'firefox'; 
                } 
                else { 
                    $name = 'unrecognized'; 
                } 
                if (preg_match('/.+(?:me|ox|it|ra|ie)[\/: ]([\d.]+)/', $userAgent, $matches) && (strpos($userAgent,'safari')) == true ) { 
                    $version = $matches[1]; 
                }
                elseif (preg_match('/.+(?:me|ox|it|on|ra|ie)[\/: ]([\d.]+)/', $userAgent, $matches) && (strpos($userAgent,'safari')) == false ) { 
                    $version = $matches[1]; 
                }
				
                else { 
                    $version = 'unknown'; 
                } 

                return array( 
                    'name'      => $name, 
                    'version'   => $version,
                ); 
            }
			public static function isHTML5()
			{
				 $browser = self::detect(); 
				 if($browser['name'] == 'firefox' && version_compare($browser['version'],'17.0') >= 0)
				 {
					 return true;
				 }
				 if($browser['name'] == 'safari' && version_compare($browser['version'],'7.0') >= 0)
				 {
					 return true;
				 }
				 if($browser['name'] == 'chrome' && version_compare($browser['version'],'28.0') >= 0)
				 {
					 return true;
				 }
				 if($browser['name'] == 'msie' && version_compare($browser['version'],'11.0') >= 0)
				 {
					 return true;
				 }
				 if($browser['name'] == 'opera' && version_compare($browser['version'],'12.10') >= 0)
				 {
					 return true;
				 }
				 
				 return false;
			}
        } 
		
       

/* acitvate functionality */
new FRONT_MEDIA_ALLOW;

// Show only posts and media related to logged in author
add_action('pre_get_posts', 'query_set_only_author' );
function query_set_only_author( $wp_query ) {
	if(isset($_REQUEST['action']) && $_REQUEST['action']==='query-attachments')
	{
   		global $current_user;
		   if( is_admin() && !current_user_can('edit_others_posts') ) {
				$wp_query->set( 'author', $current_user->ID );
				add_filter('views_upload', 'fix_media_counts');
			}
	}
}

// Fix media counts
function fix_media_counts($views) {
    $_total_posts = array();
    $_num_posts = array();
    global $wpdb, $current_user, $post_mime_types, $avail_post_mime_types;
    $views = array();
    $count = $wpdb->get_results( "
        SELECT post_mime_type, COUNT( * ) AS num_posts 
        FROM $wpdb->posts 
        WHERE post_type = 'attachment' 
        AND post_author = $current_user->ID 
        AND post_status != 'trash' 
        GROUP BY post_mime_type
    ", ARRAY_A );
    foreach( $count as $row )
        $_num_posts[$row['post_mime_type']] = $row['num_posts'];
    $_total_posts = array_sum($_num_posts);
    $detached = isset( $_REQUEST['detached'] ) || isset( $_REQUEST['find_detached'] );
    if ( !isset( $total_orphans ) )
        $total_orphans = $wpdb->get_var("
            SELECT COUNT( * ) 
            FROM $wpdb->posts 
            WHERE post_type = 'attachment' 
            AND post_author = $current_user->ID 
            AND post_status != 'trash' 
            AND post_parent < 1
        ");
    $matches = wp_match_mime_types(array_keys($post_mime_types), array_keys($_num_posts));
    foreach ( $matches as $type => $reals )
        foreach ( $reals as $real )
            $num_posts[$type] = ( isset( $num_posts[$type] ) ) ? $num_posts[$type] + $_num_posts[$real] : $_num_posts[$real];
    $class = ( empty($_GET['post_mime_type']) && !$detached && !isset($_GET['status']) ) ? ' class="current"' : '';
    $views['all'] = "<a href='upload.php'$class>" . sprintf( __('All <span class="count">(%s)</span>', 'uploaded files' ), number_format_i18n( $_total_posts )) . '</a>';
    foreach ( $post_mime_types as $mime_type => $label ) {
        $class = '';
        if ( !wp_match_mime_types($mime_type, $avail_post_mime_types) )
            continue;
        if ( !empty($_GET['post_mime_type']) && wp_match_mime_types($mime_type, $_GET['post_mime_type']) )
            $class = ' class="current"';
        if ( !empty( $num_posts[$mime_type] ) )
            $views[$mime_type] = "<a href='upload.php?post_mime_type=$mime_type'$class>" . sprintf( translate_nooped_plural( $label[2], $num_posts[$mime_type] ), $num_posts[$mime_type] ) . '</a>';
    }
    $views['detached'] = '<a href="upload.php?detached=1"' . ( $detached ? ' class="current"' : '' ) . '>' . sprintf( __( 'Unattached <span class="count">(%s)</span>', 'detached files' ), $total_orphans ) . '</a>';
    return $views;
}