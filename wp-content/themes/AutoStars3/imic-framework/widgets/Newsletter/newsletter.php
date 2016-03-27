<?php
/*** Widget code for Newsletter ***/
class newsletter extends WP_Widget {
	// constructor
	function newsletter() {
		 $widget_ops = array('description' => __( "Newsletter Listing.", 'framework') );
         parent::__construct(false, $name = __('Newsletter','framework'), $widget_ops);
	}
	// widget form creation
	function form($instance) {
        // Check values
		if( $instance) {
			 $title = esc_attr($instance['title']);
			 } else {
			 $title = '';
			 
		}
	?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php echo esc_attr_e('Title', 'framework'); ?></label>
            <input class="spTitle" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>    
              <?php
	}
	// update widget
	function update($new_instance, $old_instance) {
		  $instance = $old_instance;
		  // Fields
		  $instance['title'] = strip_tags($new_instance['title']);
		  return $instance;
	}
	// display widget
	function widget($args, $instance) {
         extract($args);
             if(isset($_POST['newsletter_submit'])){
                $newsletter_email = $_POST['newsletter_email'];
				$newsletter_name = (isset($_POST['newsletter_name']))?$_POST['newsletter_name']:'Name';
				$newsletter_data = $newsletter_name.'|'.$newsletter_email;
              $NewsletterEmail=get_option('NewsletterEmail');
                $newsletter_email_temp=array();
                $date[]=date('F j, Y');
                array_push($newsletter_email_temp,$newsletter_data);
                $newsletter_email_temp=array_combine($newsletter_email_temp,$date);
                if(!empty($NewsletterEmail)){
                 $optionsValue =array_merge($NewsletterEmail,$newsletter_email_temp);
              }else{
                 $optionsValue= $newsletter_email_temp;  
                }
              update_option('NewsletterEmail',$optionsValue);
               }
	   // these are the widget options
	   $post_title = apply_filters('widget_title', $instance['title']);
	   $description = (isset($instance['description']))?$instance['description']:'';
	   echo $args['before_widget'];
		if( !empty($instance['title']) ){
			echo $args['before_title'];
			echo apply_filters('widget_title',$post_title, $instance, $this->id_base);
			echo $args['after_title'];
			}
                if(!empty($description)){
                 echo '<p>'.$description.'</p>';   
                }
		echo'<form method ="post" action ="#">
		<input type="text" name="newsletter_name" id="name-nl" placeholder="'.__('Name','framework').'" class="form-control">
                    <input type="email" name="newsletter_email" id="email-nl" placeholder="'.__('Email','framework').'" class="form-control">
                  <input type="submit" name="newsletter_submit" class="btn btn-primary btn-block btn-lg" value="'.__('Sign up now','framework').'">
               </form>';
          echo $args['after_widget'];
	}
       }
if (!function_exists('imic_newslatter_enqueue_scripts')) {
     function imic_newslatter_enqueue_scripts(){
            wp_register_script('imic_newslatter',IMIC_THEME_PATH . '/imic-framework/widgets/Newsletter/newsletter.js', array(), '', true);
            wp_enqueue_script('imic_newslatter');
      }
       add_action('wp_enqueue_scripts', 'imic_newslatter_enqueue_scripts');
     }
     
 if(!function_exists('imicRegisterNewsLetterMenuPage')){
     function imicRegisterNewsLetterMenuPage(){
		 add_theme_page( __('NewsLetter','framework'), __('NewsLetter','framework'),'manage_options', 'newsLetter', 'imicNewsLetter',6 );
     }
 add_action( 'admin_menu', 'imicRegisterNewsLetterMenuPage');
 }
     if(!function_exists('imicNewsLetter')){
     function imicNewsLetter(){
         require_once dirname(__FILE__) . '/newsletterEmail.php';
     }}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("newsletter");'));
?>