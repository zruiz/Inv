<?php 
if(!class_exists('UserAddEdit')){
	class UserAddEdit{
		private $is_public = true;
		private $user_id = '';
		private $type = 'create';//create or edit
		private $action = '';// form action (url) 		
		private $user_data = array();
		private $tos = false;
		private $captcha = false;
		private $register_metas = array();
		private $errors = false;
		private $register_fields = '';
		private $disabled_submit_form = '';
		private $register_template = 'ihc-register-1';
		private $bank_transfer_message = FALSE;
		private $display_type = 'display_admin';
		private $coupon = '';
		private $show_sm = FALSE;
		private $print_errors = array();
		private $required_fields = array();
		
		/////////
		public function __construct(){}

		////////
		public function setVariable($arr=array()){
			/*
			 * set the input variables
			 * @param array
			 * @return none
			 */
			if(count($arr)){
				foreach($arr as $k=>$v){
					$this->$k = $v;
				}
			}
			if ($this->is_public){
				if ($this->type=='create'){
					$this->display_type = 'display_public_reg';
				} else {
					$this->display_type = 'display_public_ap';
				}
			} else {
				$this->display_type = 'display_admin';
			}
		}
		
		private function set_register_fields(){
			$this->register_fields = ihc_get_user_reg_fields();//register fields	
			ksort($this->register_fields);		
			if ($this->type=='edit'){
				$key = ihc_array_value_exists($this->register_fields, 'user_login', 'name');
				if ($key){
					unset($this->register_fields[$key]);
				}
			}				
		}
		
		/////////
		public function form(){
			/*
			 * @param none
			 * @return string
			 */

			/*extra fields that must be transalted:*/				 		
			   __("Confirm Password", 'ihc');
			   __("Last Name", 'ihc');
			   __("First Name", 'ihc');			 
			 /**/
			   
			$this->userdata();//settings the user data
			$this->set_register_fields();

			
			$standard_level = get_option('ihc_register_new_user_level');
		
			
			$str = '';
			$i = 0;
			if ($this->register_template == 'ihc-register-6'){
				$count_reg = $this->count_register_fields();
			}
			
			foreach ($this->register_fields as $v){
				if ($v[$this->display_type]>0){
					$i++;
					
					// TEST CUSTOM FIELD - LEVELS RELATION
					if (isset($v['target_levels']) && $v['target_levels']!='' && $this->is_public){
						$current_level = (isset($_REQUEST['lid'])) ? $_REQUEST['lid'] : $standard_level;
						$field_target_levels = explode(',', $v['target_levels']);
						if (!in_array($current_level, $field_target_levels)){
							continue;
						}
					}
					
					if ($v['name']=='tos'){
						 //TOS
						 if ($this->tos){
							 $disp_tos = $this->print_tos($v);
							 if($disp_tos != ''){
						 		$str .= $this->print_tos($v);
						 		$this->required_fields[] = array('name' => 'tos', 'type' => 'checkbox');
							 }
						 }
						 if (!empty($this->print_errors['tos'])){
						 	$str .= '<div class="">' . $this->print_errors['tos'] . '</div>';
						 }
					} else if ($v['name']=='recaptcha'){						
						 //CAPTCHA
						 if ($this->captcha){
							 $disp_captcha = $this->print_captcha($v);
							 if($disp_captcha != ''){
						 		$str .= $this->print_captcha($v);
							}
						 }
						 if (!empty($this->print_errors['captcha'])){
						 	$str .= '<div class="">' . $this->print_errors['captcha'] . '</div>';
						 }						 
					} else if ($v['name']=='ihc_social_media'){
						//SOCIAL MEDIA
						if ($this->type=='create' && $this->is_public){							
							$str .= ihc_print_social_media_icons('register');
							$this->show_sm = TRUE;							
						} else {
							continue;
						}						 
					} else if ($this->is_public) {
						if ($this->register_template == 'ihc-register-6'){
							if($i == 1) $str .= '<div class="ihc-register-col">';
							if($i-1 == ceil($count_reg/2)) $str .= '</div><div class="ihc-register-col">';
						}
						//========== PUBLIC
						$str .= $this->print_fields($v);
					} else {
						 //========== ADMIN
						 
						 $disabled = '';
						 if ( $this->type=='edit' && $v['name']=='user_login'){
						 	$disabled = 'disabled';
						 }
						 //FORM FIELD
						 $parent_id = 'ihc_reg_' . $v['type'] . '_' . rand(1,10000);
						 $str .= '<div class="iump-form-line-register" id="' . $parent_id . '">';
						 $str .= '<label class="iump-labels-register">';
						 if ($v['req']){
						 	 $str .= '<span style="color: red;">*</span>';
						 }
						 if (isset($v['native_wp']) && $v['native_wp']){
						 	$str .= __($v['label'], 'ihc');
						 } else {
				 			$str .= $v['label'];
						 }						 
						 $str .= '</label>';

						 $val = '';
						 if (isset($this->user_data[$v['name']])){
						 	$val = $this->user_data[$v['name']];
						 }
						 
						 $multiple_values = FALSE;
					 	 if (isset($v['values']) && $v['values']){
					 	 	//is checkbox, select or radio input field, so we have to include multiple+_values into indeed_create_form_elelemt
					 		$multiple_values = ihc_from_simple_array_to_k_v($v['values']);
					 	 }	
					 	 
					 	 if (empty($v['sublabel'])){
					 	 	$v['sublabel'] = '';
					 	 }
					 	 
					 	 if (empty($v['class'])){
					 	 	$v['class'] = '';
					 	 }
						 
						 $str .= indeed_create_form_element(array(  'type'=>$v['type'], 'name'=>$v['name'], 'value' => $val,
						 										    'disabled' => $disabled, 'multiple_values' => $multiple_values, 
						 											'user_id'=>$this->user_id, 'sublabel' => $v['sublabel'], 'class'=>$v['class'] ));
						 $str .= '</div>';
					}
				}
			}
					
			if ($this->is_public){				
				/*******************************PUBLIC****************************/				
				//SPECIAL PAYMENTS (authorize, stripe)				
				if (isset($_REQUEST['lid']) || $standard_level){
					$_REQUEST['lid'] = isset($_REQUEST['lid']) ? $_REQUEST['lid'] : $standard_level;
					$level_data = ihc_get_level_by_id($_REQUEST['lid']);
					if ($level_data['payment_type']=='payment'){
						$payment_gateway = get_option('ihc_payment_selected');
						
						if($payment_gateway == 'authorize' && isset($level_data['access_type']) && $level_data['access_type']=='regular_period'){
							//AUTHORIZE RECCURING
							require_once IHC_PATH . 'classes/ihcAuthorizeNet.class.php';
							$auth_pay = new ihcAuthorizeNet();
							$str .= '<div class="ihc_payment_details">'.__('Payment Details', 'ihc').'</div>';
							$str .= indeed_create_form_element(array('type'=>'hidden', 'name'=>'ihcpay', 'value' => $payment_gateway ));	
							$str .=  $auth_pay->payment_fields();		
						} else if ($payment_gateway=='stripe') {
							$str .= indeed_create_form_element(array('type'=>'hidden', 'name'=>'ihcpay', 'value' => $payment_gateway ));
							if ( isset($_REQUEST['stripeEmail']) && isset($_REQUEST['stripeToken']) ){
								//already have a token
								$str .= indeed_create_form_element(array('type'=>'hidden', 'name'=>'stripeToken', 'value' => $_REQUEST['stripeToken'] ));
								$str .= indeed_create_form_element(array('type'=>'hidden', 'name'=>'stripeEmail', 'value' => $_REQUEST['stripeEmail'] ));
							} else {
								require_once IHC_PATH . 'classes/ihcStripe.class.php';
								$payment_obj = new ihcStripe();
								$str .= $payment_obj->payment_fields($_REQUEST['lid']);								
							}
						}
						
					}
				}
				
				//ACTIONS
				if ($this->type=='edit'){
					$str .= indeed_create_form_element(array('type'=>'hidden', 'name'=>'ihcaction', 'value' => 'update' ));
				} else {
					$str .= indeed_create_form_element(array('type'=>'hidden', 'name'=>'ihcaction', 'value' => 'register' ));
				}
				//LEVELS				
				if (isset($_GET['lid'])){	
					//if we have a level id from request assign to form, lid = Level ID	
					$str .= indeed_create_form_element(array('type'=>'hidden', 'name'=>'lid', 'value' => $_GET['lid'] ));
				} else {
					if ($this->type=='create' && $standard_level!==FALSE){
						$str .= indeed_create_form_element(array('type'=>'hidden', 'name'=>'lid', 'value' => $standard_level ));
						//assign the standard level only on create
						
					}
				}
			} else {
				/******************************** ADMIN ****************************/
				$str .= $this->print_wp_role();//select wp role
				$str .= $this->select_level();//select levels
				
				if ($this->user_id && $this->type=='edit'){//hide user id into the form for edit, only in admin
					$str .= indeed_create_form_element(array('type'=>'hidden', 'name'=>'user_id', 'value' => $this->user_id ));
					$str .= $this->print_level_expire_time_edit();///level expire time
				}		
				$str .= $this->print_overview_post_select();		
			}
			
			if ($this->register_template == 'ihc-register-6'){ $str .= '</div>'; }
			if ($this->register_template == 'ihc-register-7'){ $str .= '<div class="impu-temp7-row">'; }
			
			$str .= '<div class="iump-submit-form">';
			if ($this->type=='create'){
				$str .= indeed_create_form_element(array('type'=>'submit', 'name'=>'Submit', 'value' => __('Register', 'ihc'), 
						'class' => 'button button-primary button-large', 'id'=>'ihc_submit_bttn', 'disabled'=>$this->disabled_submit_form ));
			} else {
				$str .= indeed_create_form_element(array('type'=>'submit', 'name'=>'Update', 'value' => __('Save Changes', 'ihc'),
						 'class' => 'button button-primary button-large', 'id'=>'ihc_submit_bttn', 'disabled'=>$this->disabled_submit_form ));
			}			
			$str .= '</div>';			
			
			if ($this->register_template == 'ihc-register-7'){ $str .= '</div>'; }
			
			$str .= $this->social_register_request_data();
			
			//wrapp it all in a form
			if ($this->type=='edit'){
				$form_detail = ' name="edituser" id="edituser" class="ihc-form-create-edit" enctype="multipart/form-data" ';
			} else {
				$form_detail = ' name="createuser" id="createuser" class="ihc-form-create-edit" enctype="multipart/form-data" ';
			}
			$str = indeed_form_start( $this->action, 'post', $form_detail) . $str . indeed_form_end();
			
			//SOCIAL LOGGER
			if ($this->is_public && $this->type=='create' && $this->show_sm){
				$str .= $this->ihc_social_form();		
			}	

			//MESSAGE ABOUT LEVEL 
			$str .= $this->add_level_details_on_register_form($standard_level);
			
			//CUSTOM CSS
			$data = get_option('ihc_register_custom_css');
			if ($data){
				$str = '<style>' . $data . '</style>' . $str;
			}			
			
			//CHECK FIELDS VALUES VIA AJAX
			if ($this->is_public){
				$str .= '<script>';
				$str .= 'var req_fields_arr = [];';
				$str .= 'jQuery(document).ready(function(){';
				foreach ($this->required_fields as $req_field){
					if (in_array($req_field['type'], array('text', 'textarea', 'number', 'password'))){
						$str .= 'jQuery(".ihc-form-create-edit [name='.$req_field['name'].']").on("blur", function(){
							ihc_register_check_via_ajax("'.$req_field['name'].'");
						});';						
					}
					
					$str .= 'req_fields_arr.push("' . $req_field['name'] . '");
					';
				}
				$str .= 'jQuery(".ihc-form-create-edit").live("submit", function() {
							if (window.must_submit==1){
								return true;
							} else {
								ihc_register_check_via_ajax_rec(req_fields_arr);
								return false;							
							}
						});';
				$str .= '});';
				$str .= '</script>';
			}
			
			return $str;	
		}
		
		
		/////////
		public function userdata(){
			//setting $user_data for current user
			if ($this->user_id){
				//getting user meta for id
				$data = get_userdata($this->user_id);
				$user_fields = ihc_get_user_reg_fields();
				if ($data){
					foreach ($user_fields as $user_field){
						$name = $user_field['name'];
						if ($user_field['native_wp']==1){
							//native wp field, get value from get_userdata ( $data object )
							if (isset($data->$name) && $data->$name){
								$this->user_data[ $name ] = $data->$name;
							}
						} else {
							//custom field, get value from get_user_meta()
							$this->user_data[ $name ] = get_user_meta($this->user_id, $name, true);
						}
					}
				}
				//user wp role
				if (isset($data->roles[0])){
					$this->user_data['role'] = $data->roles[0];
				}
				///user levels
				$this->user_data['ihc_user_levels'] = get_user_meta($this->user_id, 'ihc_user_levels', true);
				
				//remove coupon data
				unset($this->user_data['ihc_coupon']);
			} else {
				//empty arr
				$user_fields = ihc_get_user_reg_fields();
					foreach ($user_fields as $user_field){
						$name = $user_field['name'];
						$this->user_data[$name] = '';	
						
						if ($this->is_public && isset($_REQUEST[$name])){
							$this->user_data[$name] = $_REQUEST[$name];
						}					
					}
				$this->user_data['ihc_user_levels'] = '';
				$this->user_data['role'] = '';
			}
		}

		private function print_wp_role(){
			$str = '';
			$str .= '<div class="iump-form-line-register">';
			$str .= '<label class="iump-labels-register">WP Role</label>';
			$str .= indeed_create_form_element(
													array(  'type' => 'select', 
															'name' => 'role', 
															'value' => $this->user_data['role'],
															'multiple_values' => ihc_get_wp_roles_list(),
															'class' => '' )
													);
			$str .= '</div>';
			return $str;
		}
		
		////////
		private function select_level(){
			$str = '';			
			$levels = get_option('ihc_levels');
			if ($levels && count($levels)){
				$level_select_options[-1] = '...';
				foreach ($levels as $k=>$v){
					$level_select_options[$k] = $v['name'];
				}
				$str .= '<div class="iump-form-line iump-special-line">';
				$str .= '<label class="iump-labels">'.__('Select Level:', 'ihc').' </label>';
					
				$args['type'] = 'select';
				//$args['value'] = $level_select_options;
				$args['multiple_values'] = $level_select_options;
				$args['value'] = -1;
				$args['name'] = 'ihc_user_levels';
				if (!$this->is_public){
					unset($args['name']);
					$args['other_args'] = 'onChange="ihc_writeTagValue(this, \'#indeed-user-level-free-select\', \'#ihc-select-level-view-values\', \'ihc-level-select-v-\');"';
				}
				$str .= indeed_create_form_element($args);
				if (!$this->is_public){
					$str .= indeed_create_form_element(array('type'=>'hidden', 'name'=>'ihc_user_levels', 'id' => 'indeed-user-level-free-select', 'value' => $this->user_data['ihc_user_levels'] ));
					$str .= '<div id="ihc-select-level-view-values">';
					if ($this->user_data['ihc_user_levels']!='' && $this->user_data['ihc_user_levels']!=-1){
						$user_levels = explode(',', $this->user_data['ihc_user_levels']);				
						foreach ($user_levels as $v){
							$v = (int)$v;
							$temp_data = ihc_get_level_by_id($v);
							if ($temp_data){
								$str .= '<div id="ihc-level-select-v-'.$v.'" class="ihc-tag-item">'.$temp_data['name']
											. '<div class="ihc-remove-tag" onclick="ihcremoveTag('.$v.', \'#ihc-level-select-v-\', \'#indeed-user-level-free-select\');" title="'.__('Removing tag', 'ihc').'">'
											. 'x</div>'
									  . '</div>';									
							}
						}
					}
					$str .= '</div>';
					$str .= '<div class="clear"></div>';
				}
				$str .= '</div>';
			}
			return $str;
		}
		
		private function print_fields($v=array()){		
			/*
			 * @param array
			 * @return string
			 */
			$str = '';
			$disabled = '';
			$placeholder = '';
			 if ( $this->type=='edit' && $v['name']=='user_login'){
			 	$disabled = 'disabled';
			 }
			 $parent_id = 'ihc_reg_' . $v['type'] . '_' . rand(1,10000);
			 
			 if (!empty($v['req'])){
			 	$this->required_fields[] = array('name' => $v['name'], 'type'=>$v['type']);
			 }
			 
			 switch ($this->register_template){
				 case 'ihc-register-3':
				  //////// FORM FIELD
					 $str .= '<div class="iump-form-line-register" id="' . $parent_id . '">';
					 if ($v['type'] == 'text' || $v['type'] == 'password'){
					 	if ($v['req']){
							 $placeholder .= '*';
						 }
						if (isset($v['native_wp']) && $v['native_wp']){
							$placeholder .= __($v['label'], 'ihc');
						 } else {
							$placeholder .= $v['label'];
						 }	
					 } else {
						 $str .= '<label class="iump-labels-register">';
						 if ($v['req']){
							 $str .= '<span style="color: red;">*</span>';
						 }
						 if (isset($v['native_wp']) && $v['native_wp']){
							$str .= __($v['label'], 'ihc');
						 } else {
						 	$str .= $v['label'];						
						 }						 
						 $str .= '</label>';
					 }
					 $val = '';
					 if (isset($this->user_data[$v['name']])){
					 	$val = $this->user_data[$v['name']];
					 }
					 $multiple_values = FALSE;
					 if (isset($v['values']) && $v['values']){
					 	//is checkbox, select or radio input field, so we have to include multiple+_values into indeed_create_form_elelemt
					 	$multiple_values = ihc_from_simple_array_to_k_v($v['values']);
					 }	
					 			
					 if (empty($v['sublabel'])){
					 	$v['sublabel'] = '';
					 }
					 if (empty($v['class'])){
					 	$v['class'] = '';
					 }
					 					 				 	 
					 $str .= indeed_create_form_element(array(	'type'=>$v['type'], 'name'=>$v['name'], 'value' => $val, 
					 											'disabled' => $disabled, 'placeholder' => $placeholder, 'multiple_values'=>$multiple_values,
					 											'user_id'=>$this->user_id, 'sublabel' => $v['sublabel'], 'class' => $v['class'] ));		
			 		 if (!empty($this->print_errors[$v['name']])){
					 	$str .= '<div class="">' . $this->print_errors[$v['name']] . '</div>';
					 }		 
					 $str .= '</div>';
				 break;
				 case 'ihc-register-4':
				  //////// FORM FIELD
				  $add_class = '';
					if ($v['type'] == 'select' || $v['type'] == 'multi_select' || $v['type'] == 'file' || $v['type'] == 'upload_image' || $v['type'] == 'date'){
						$add_class ='ihc-no-backs';
					}
					 $str .= '<div class="iump-form-line-register '.$add_class.'" id="' . $parent_id . '">';
					 if ($v['type'] == 'text' || $v['type'] == 'password'){
					 	if ($v['req']){
							 $placeholder .= '*';
						 }
						if (isset($v['native_wp']) && $v['native_wp']){
							$placeholder .= __($v['label'], 'ihc');
						 } else {
							$placeholder .= $v['label'];
						 }	
					 } else {
							 $str .= '<label class="iump-labels-register">';
							 if ($v['req']){
								 $str .= '<span style="color: red;">*</span>';
							 }
							 if (isset($v['native_wp']) && $v['native_wp']){
								$str .= __($v['label'], 'ihc');
							 } else {
								$str .= $v['label'];	
							 }						 
							 $str .= '</label>';
					 }
					 $val = '';
					 if (isset($this->user_data[$v['name']])){
					 	$val = $this->user_data[$v['name']];
					 }
			 		 $multiple_values = FALSE;
					 if (isset($v['values']) && $v['values']){
					 	//is checkbox, select or radio input field, so we have to include multiple+_values into indeed_create_form_elelemt
					 	$multiple_values = ihc_from_simple_array_to_k_v($v['values']);
					 }		
					 
					 if (empty($v['sublabel'])){
					 	$v['sublabel'] = '';
					 }	
					 if (empty($v['class'])){
					 	$v['class'] = '';
					 }				 
					 
					 $str .= indeed_create_form_element(array( 'type'=>$v['type'], 'name'=>$v['name'], 'value' => $val,
					 										   'disabled' => $disabled, 'placeholder' => $placeholder, 'multiple_values'=>$multiple_values,
					 											'user_id'=>$this->user_id, 'sublabel' => $v['sublabel'], 'class' => $v['class'] ));
			 		 if (!empty($this->print_errors[$v['name']])){
					 	$str .= '<div class="">' . $this->print_errors[$v['name']] . '</div>';
					 }
					 $str .= '</div>';
				 break;
				 
				  case 'ihc-register-6':
				  	 //////// FORM FIELD
					 $str .= '<div class="iump-form-line-register" id="' . $parent_id . '">';
					 $str .= '<label class="iump-labels-register">';
					 if ($v['req']){
						 $str .= '<span style="color: red;">*</span>';
					 }
					 if (isset($v['native_wp']) && $v['native_wp']){
						$str .= __($v['label'], 'ihc');
					 } else {
						$str .= $v['label'];
					 }						 
					 $str .= '</label>';
		
					 $val = '';
					 if (isset($this->user_data[$v['name']])){
					 	$val = $this->user_data[$v['name']];
					 }
			 		 $multiple_values = FALSE;
					 if (isset($v['values']) && $v['values']){
					 	//is checkbox, select or radio input field, so we have to include multiple+_values into indeed_create_form_elelemt
					 	$multiple_values = ihc_from_simple_array_to_k_v($v['values']);
					 }	
					 
					 if (empty($v['sublabel'])){
					 	$v['sublabel'] = '';
					 }	

					 if (empty($v['class'])){
					 	$v['class'] = '';
					 }
					 
					 $str .= indeed_create_form_element(array( 'type'=>$v['type'], 'name'=>$v['name'], 'value' => $val,
					 										   'disabled' => $disabled, 'multiple_values'=>$multiple_values,
					 											'user_id'=>$this->user_id, 'sublabel' => $v['sublabel'], 'class' => $v['class'] ));
					 if (!empty($this->print_errors[$v['name']])){
					 	$str .= '<div class="">' . $this->print_errors[$v['name']] . '</div>';
					 }
					 $str .= '</div>';
				 break;
				 
				 default:
					 //////// FORM FIELD
					 $str .= '<div class="iump-form-line-register" id="' . $parent_id . '">';
					 $str .= '<label class="iump-labels-register">';
					 if ($v['req']){
						 $str .= '<span style="color: red;">*</span>';
					 }
					 if (isset($v['native_wp']) && $v['native_wp']){
						$str .= __($v['label'], 'ihc');
					 } else {
					 	$str .= $v['label'];
					 }						 
					 $str .= '</label>';
		
					 $val = '';
					 if (isset($this->user_data[$v['name']])){
					 	$val = $this->user_data[$v['name']];
					 }
					 $multiple_values = FALSE;
					 if (isset($v['values']) && $v['values']){
					 	//is checkbox, select or radio input field, so we have to include multiple+_values into indeed_create_form_elelemt
					 	$multiple_values = ihc_from_simple_array_to_k_v($v['values']);
					 }
					 
					 if (empty($v['sublabel'])){
					 	$v['sublabel'] = '';
					 }	

					 if (empty($v['class'])){
					 	$v['class'] = '';
					 }
					 
					 $str .= indeed_create_form_element(array( 'type'=>$v['type'], 'name'=>$v['name'], 'value' => $val,
					 										   'disabled' => $disabled, 'multiple_values'=>$multiple_values,
					 										   'user_id'=>$this->user_id, 'sublabel' => $v['sublabel'], 'class' => $v['class'] ));
					 if (!empty($this->print_errors[$v['name']])){
					 	$str .= '<div class="ihc-register-notice">' . $this->print_errors[$v['name']] . '</div>';
					 }
					 $str .= '</div>';
				 break;
			 }
			return $str;	
		}
		///////
		private function print_tos($v=array()){
			/*
			 * @param array
			 * @return string
			 */
			$str = '';
			$tos_msg = get_option('ihc_register_terms_c');//getting tos message
			$tos_page_id = get_option('ihc_general_tos_page');
			$tos_link = get_permalink($tos_page_id);

			if ($tos_msg && $tos_page_id){
				$class = (empty($v['class'])) ? '' : $v['class'];
				$id = 'ihc_tos_field_parent_' . rand(1,1000);
				$str .= '<div class="ihc-tos-wrap" id="' . $id . '">';
				$str .= '<input type="checkbox" value="1" name="tos" class="' . $class . '" />';
				$str .= '<a href="'.$tos_link.'" target="_blank">' . $tos_msg . '</a>';
				$str .= '</div>';
			}									
			return $str;	
		}
		
		
		
		//////
		private function print_captcha($v=array()){
			/*
			 * @param array
			 * @return string
			 */			
			$str = '';
			$key = get_option('ihc_recaptcha_public');
			if ($key){
				$class = (empty($v['class'])) ? '' : $v['class'];
				$str .= '<div class="g-recaptcha-wrapper" class="' . $class . '">';
				$str .= '<div class="g-recaptcha" data-sitekey="' . $key . '"></div>';
				$str .= '<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=en"></script>';				
				$str .= '</div>';
			}	
			return $str;
		}
		
		private function add_level_details_on_register_form($standard_level=-1){
			/*
			 * 
			 */
			$str = '';
			$show = get_option("ihc_register_show_level_price");
			if ($show){
				$level = $standard_level;
				if (isset($_REQUEST['lid'])){
					$level = $_REQUEST['lid'];
				}
					
				if ((int)$level>-1){
					$currency = get_option("ihc_currency");
					$level_data = ihc_get_level_by_id($level);
					$str .= '<div class="iump-level-details-register">';
					$str .= '<span class="iump-level-details-register-name">'.$level_data['label'] . '</span><span class="iump-level-details-register-price">';
					if ($level_data['payment_type']=='payment'){
						$str .= $level_data['price'] . $currency;
					} else {
						$str .= __("Free", "ihc");
					}
					$str .= '</span><div class="iump-clear"></div></div>';
				}				
			}
			return $str;
		}
		
		private function print_level_expire_time_edit(){
			/*
			 * @param none, use variables from class
			 * @return string with input for each level expire
			 */
			
			$string = '';
			if (isset($this->user_data['ihc_user_levels']) && $this->user_data['ihc_user_levels']!=-1){
				
				$user_levels = explode(',', $this->user_data['ihc_user_levels']);
				$i = 1;
				foreach ($user_levels as $v){
					
					$v = (int)$v;
					$temp_data = ihc_get_level_by_id($v);
					if ($temp_data){
						$time = ihc_get_start_expire_date_for_user_level($this->user_id, $v);
						$placeholder['start_time'] = '';
						$placeholder['expire_time'] = '';
						if (!$time['start_time']){
							$placeholder['start_time'] = '----/--/----';
						}
						if (!$time['expire_time']){
							$placeholder['expire_time'] = '----/--/----';
						}
						
						if (!isset($temp_data['access_type'])){
							$temp_data['access_type'] = 'LifeTime';
						}
						$string .= '<tr class="'. ($i%2==0 ? 'alternate':'') .'">' 
											. '<td style="color: #21759b; font-weight:bold; width:120px;font-family: "Oswald", arial, sans-serif !important;font-size: 14px;font-weight: 300;">' . $temp_data['name'] . '</td>'
											. '<td style="color: #888; font-weight:bold; width:120px;font-family: "Oswald", arial, sans-serif !important;font-size: 14px;font-weight: 300;">' . $temp_data['access_type'] . '</td>'
											. '<td>' . indeed_create_form_element( array('type'=>'text', 
																				'name'=>'start_time_levels['.$v.']', 
																				'class'=>'start_input_text', 
																				'value' => $time['start_time'],
																				'placeholder' => $placeholder['start_time'] 
																				)
											  )															
											. '</td>'											
											. '<td>' . indeed_create_form_element( array('type'=>'text', 
																				'name'=>'expire_levels['.$v.']', 
																				'class'=>'expire_input_text', 
																				'value' => $time['expire_time'],
																				'placeholder' => $placeholder['expire_time'] 
																				)
											  )
											. '</td>'
										. '</tr>';
					}
				$i++; 
				}
			}
			if ($string){
				$string = '<table class="wp-list-table widefat fixed tags ihc-manage-user-expire"><thead><tr><th>' . __('Level Name', 'ihc') . '</th><th>' . __('Acess Type', 'ihc') . '</th><th>' . __('Start Time', 'ihc') . '</th><th>' . __('Expire Time', 'ihc') . '</th></tr></thead><tbody>' . $string . '</tbody></table>';
			}
			return $string;
		}
		
		private function print_overview_post_select(){
			/*
			 * dropdown with all post 
			 * @param none
			 * @return string
			 */
			$str = '';
			$default_pages_arr = ihc_return_meta_arr('general-defaults');
			$default_pages_arr = array_diff_key($default_pages_arr, array(  'ihc_general_redirect_default_page'=>'', 
																			'ihc_general_logout_redirect'=>'', 
																			'ihc_general_register_redirect'=>'', 
																			'ihc_general_login_redirect'=>'' ));//let's exclude the redirect pages
			$args = array(
					'posts_per_page'   => -1,
					'offset'           => 0,
					'orderby'          => 'date',
					'order'            => 'DESC',
					'post_type'        => array( 'post', 'page' ),
					'post_status'      => 'publish',
					'post__not_in'	   => $default_pages_arr,
			);
			
			$posts_array = get_posts( $args );
			$arr['-1'] = '...';
			foreach ($posts_array as $k=>$v){
				$arr[$v->ID] = $v->post_title;
			}
			$str .= '<div class="iump-form-line">';
			$str .= '<label class="iump-labels">' . __('Select Post For Account Page Overview:', 'ihc') . ' </label>';
			$args['type'] = 'select';
			$args['multiple_values'] = $arr;
			$value = get_user_meta($this->user_id, 'ihc_overview_post', true);
			$args['value'] = ($value!==FALSE) ? $value : '';
			$args['name'] = 'ihc_overview_post';
			$str .= indeed_create_form_element($args);
			$str .= '</div>';
			return $str;
		}
		
		private function update_level_expire(){
			/*
			 * used only in admin - edit user section
			 * @param none
			 * @return none
			 */
			if (!$this->is_public && $this->type=='edit'){
				if (isset($_REQUEST['expire_levels']) && is_array($_REQUEST['expire_levels'])){
					foreach ($_REQUEST['expire_levels'] as $l_id=>$expire){
						$start = (isset($_REQUEST['start_time_levels'][$l_id])) ? $_REQUEST['start_time_levels'][$l_id] : '';
						ihc_set_time_for_user_level($this->user_id, $l_id, $start, $expire);
					}
				}
			}
		}
		
		///////
		public function save_update_user(){
			//settings the user data, in case of new user, set the array only with keys
			$this->userdata();
			
			// set the meta register array, values selected in dashboard, register tab
			$this->register_metas = array_merge(ihc_return_meta_arr('register'), ihc_return_meta_arr('register-msg'), ihc_return_meta_arr('register-custom-fields'));
				
			//register fields, function available in utilities.php, 
			//return something $arr[] = array($this->display_type=>'', 'name'=>'', 'label'=>'', 'type'=>'', 'order'=>'', 'native_wp' => '', 'req' => '' );
			$this->set_register_fields();
					
			$this->register_with_social();
			
			$this->check_username();
			$this->check_password();
			$this->check_email();
			//$this->check_tos();
			$this->check_captcha();
			$this->set_roles();
			$this->set_coupon();
			
			$custom_meta_user = FALSE;
			if ($this->type=='create'){
				$custom_meta_user['indeed_user'] = 1;
			}
			if (!$this->is_public){
				$custom_meta_user['ihc_overview_post'] = $_REQUEST['ihc_overview_post'];
			}
			
			foreach ($this->register_fields as $value){
				$name = $value['name'];
				if (isset($_REQUEST[$name])){
					if (!empty($value['req']) && $_REQUEST[$name]==''){
						$this->errors[$name]= $this->register_metas['ihc_register_err_req_fields'];
					}
					if (!empty($value['native_wp'])){
						 //wp standard info
						 $this->fields[$name] = $_REQUEST[$name];
					} else {
						 //custom meta user
						 $custom_meta_user[$name] = $_REQUEST[$name];
					}
				}
			}
			//PAY CHECK
			$paid = 0;
			if (isset($_REQUEST['ihcpay'])){
				do {
					
					//======================== if price after discount is 0
					$level_data = ihc_get_level_by_id($_REQUEST['lid']);
					if (ihc_dont_pay_after_discount($_REQUEST['lid'], $this->coupon, $level_data)){
						//will continue in set_levels() method
						break;
					}
					//========================
					
					
					switch ($_REQUEST['ihcpay']){
						case 'authorize':
							/*************** AUTHORIZE *****************/
							$pay_errors = '';
							foreach ($_REQUEST as $key => $vals){
								$exp_key = explode('_', $key);
								if ($exp_key[0] == 'ihcpay'){
									if ($_REQUEST[$key]==''){
										$this->errors []= $this->register_metas['ihc_register_err_req_fields'];
										$pay_errors = 1;
									}
								}
							}
					
							if ($pay_errors == '' && !$this->errors){
								require_once IHC_PATH . 'classes/ihcAuthorizeNet.class.php';
								$auth_pay = new ihcAuthorizeNet();
								$charge = $auth_pay->charge($_REQUEST);
								if ($charge){
									$pay_result = $auth_pay->subscribe($_REQUEST);
									if($pay_result['code'] == 2){
										$paid = 1;
										$trans_id = $pay_result['trans_id'];
										$trans_info = $pay_result;
										$trans_info['ihc_payment_type'] = 'authorize';
									}else{
										$this->errors [] = $pay_result['message'];
									}
								}
							}
							break;
						case 'stripe':
							/*************** STRIPE *****************/
							if (isset($_REQUEST['stripeToken'])) {
								if (!$this->errors){
									require_once IHC_PATH . 'classes/ihcStripe.class.php';
									$payment_obj = new ihcStripe();
									$pay_result = $payment_obj->charge($_REQUEST);
									if ($pay_result['message'] == "success") {
										$paid = 1;
										$trans_id = $pay_result['trans_id'];
										$trans_info = $pay_result;
										$trans_info['ihc_payment_type'] = 'stripe';
									}
									unset($_REQUEST['stripeToken']);
								}
							}
							break;
					}					
				} while (FALSE);
			}
				 	
			if ($this->errors){
				 //print the error and exit
				 $this->return_errors();
				 return FALSE;
			}			
			
			//=========================== SAVE / UPDATE
			//wp native user
			if ($this->type=='create'){
				//add new user
				$this->user_id = wp_insert_user($this->fields);
			} else {
				//update user
				$this->fields['ID'] = $this->user_id;
				wp_update_user($this->fields);
			}
			
			$this->do_opt_in();
			$this->double_email_verification();
			
			//custom user meta
			if ($custom_meta_user){
				foreach ($custom_meta_user as $k=>$v){			
					update_user_meta($this->user_id, $k, $v);
				}
			}
			
			//auto login
			if ($this->is_public && $this->type=='create' && 
					!empty($this->register_metas['ihc_register_auto_login']) && !empty($this->register_metas['ihc_register_new_user_role']) 
					&& $this->register_metas['ihc_register_new_user_role']!='pending_user'){
				wp_set_auth_cookie($this->user_id);
			}
			
			$this->save_coupon();//save coupon if used
			
			$this->notify_admin();
			$this->set_levels();//USER LEVELS	
			$this->update_level_expire();//only for admin
			
			//PAY SAVE
			if($paid == 1){		
				//only authorize && stripe		
				if ($_REQUEST['ihcpay']=='authorize'){
					//only authorize with reccuring
					$level_data = ihc_get_level_by_id($_REQUEST['lid']);
					if (isset($level_data['access_type']) && $level_data['access_type']=='regular_period'){
						ihc_update_user_level_expire($level_data, $_REQUEST['lid'], $this->user_id);
					}					
				}				
				ihc_insert_update_transaction($this->user_id, $trans_id, $trans_info);
			}
			
			if ($this->is_public){				
				//email notification to user
				if ($this->type=='create'){
					if (!empty($this->register_metas['ihc_register_new_user_role']) && $this->register_metas['ihc_register_new_user_role']=='pending_user'){
						//PENDING NOTIFICATION
						ihc_send_user_notifications($this->user_id, 'review_request', @$_REQUEST['lid']);//[$l_id]
					} else {
						//REGISTER NOTIFICATION
						ihc_send_user_notifications($this->user_id, 'register', @$_REQUEST['lid']);//[$l_id]
					}					
				} else {
					ihc_send_user_notifications($this->user_id, 'user_update');//[$l_id]
				}
				$this->succes_message();//this will redirect
			}				
		}

		
		///handle password
		private function check_password(){
			if(($this->type=='edit' && !empty($_REQUEST['pass1'])) || $this->type=='create' ){
				///// only for create new user or in case that current user has selected a new password (edit)
				
				//check the strength
				if ($this->register_metas['ihc_register_pass_options']==2){
					//characters and digits
					if (!preg_match('/[a-z]/', $_REQUEST['pass1'])){
						$this->errors['pass1'] = $this->register_metas['ihc_register_pass_letter_digits_msg'];
					}						
					if (!preg_match('/[0-9]/', $_REQUEST['pass1'])){
						$this->errors['pass1'] = $this->register_metas['ihc_register_pass_letter_digits_msg'];
					}	
				} elseif ($this->register_metas['ihc_register_pass_options']==3){
					//characters, digits and one Uppercase letter
					if (!preg_match('/[a-z]/', $_REQUEST['pass1'])){
						$this->errors['pass1'] = $this->register_metas['ihc_register_pass_let_dig_up_let_msg'];
					}						
					if (!preg_match('/[0-9]/', $_REQUEST['pass1'])){
						$this->errors['pass1'] = $this->register_metas['ihc_register_pass_let_dig_up_let_msg'];
					}
					if (!preg_match('/[A-Z]/', $_REQUEST['pass1'])){
						$this->errors['pass1'] = $this->register_metas['ihc_register_pass_let_dig_up_let_msg'];
					}
				}
				
				//check the length of password
				if($this->register_metas['ihc_register_pass_min_length']!=0){
					if(strlen($_REQUEST['pass1'])<$this->register_metas['ihc_register_pass_min_length']){
						$this->errors['pass1'] = str_replace( '{X}', $this->register_metas['ihc_register_pass_min_length'], $this->register_metas['ihc_register_pass_min_char_msg'] );
					}
				}
				if(isset($_REQUEST['pass2'])){
					if($_REQUEST['pass1']!=$_REQUEST['pass2']){
						$this->errors['pass2'] = $this->register_metas['ihc_register_pass_not_match_msg'];
					}
				}
				//PASSWORD
				$this->fields['user_pass'] = $_REQUEST['pass1'];
			}
			$pass1 = ihc_array_value_exists($this->register_fields, 'pass1', 'name');
			unset($this->register_fields[$pass1]);
			$pass2 = ihc_array_value_exists($this->register_fields, 'pass2', 'name');
			unset($this->register_fields[$pass2]);
		}
		
		///check email
		private function check_email(){
			if (!is_email( $_REQUEST['user_email'])) {
				$this->errors['user_email'] = $this->register_metas['ihc_register_invalid_email_msg'];
			}
			if (isset($_REQUEST['confirm_email'])){
				if ($_REQUEST['confirm_email']!=$_REQUEST['user_email']){
					$this->errors['user_email'] = $this->register_metas['ihc_register_emails_not_match_msg'];
				}
			}	
			if (email_exists( $_REQUEST['user_email'])){
				if ($this->type=='create' || ($this->type=='edit' && email_exists( $_REQUEST['user_email'])!=$this->user_id  ) ){
					$this->errors['user_email'] = $this->register_metas['ihc_register_email_is_taken_msg'];
				}					
			}
		}
		
		//check username
		private function check_username(){
			//only for create
			if ($this->type=='create'){
				if (!validate_username( $_REQUEST['user_login'])) {
					$this->errors['user_login'] = $this->register_metas['ihc_register_error_username_msg'];
				}
				if (username_exists($_REQUEST['user_login'])) {
					$this->errors['user_login'] = $this->register_metas['ihc_register_username_taken_msg'];
				}				
			}

		}
		
		///////// TERMS AND CONDITIONS CHECKBOX CHECK
		private function check_tos(){
			//check if tos was printed
			$tos_page_id = get_option('ihc_general_tos_page');
			if (!$tos_page_id){
				$tos = ihc_array_value_exists($this->register_fields, 'tos', 'name');
				unset($this->register_fields[$tos]);
				return;
			}
			

			if ($this->tos && $this->type=='create'){
				$tos = ihc_array_value_exists($this->register_fields, 'tos', 'name');
				if ($tos && $this->register_fields[$tos][$this->display_type]){
					unset($this->register_fields[$tos]);
					if (!isset($_REQUEST['tos']) || $_REQUEST['tos']!=1){
						$this->errors['tos'] = get_option('ihc_register_err_tos');
					}
				}
			} else {
				$tos = ihc_array_value_exists($this->register_fields, 'tos', 'name');
				if ($tos) unset($this->register_fields[$tos]);
			}
		}
		
		//////////// CAPTCHA
		private function check_captcha(){
			if ($this->type=='create' && $this->captcha){
				//check if capcha key is set
				$captcha_key = get_option('ihc_recaptcha_public');
				if (!$captcha_key){
					$captcha = ihc_array_value_exists($this->register_fields, 'recaptcha', 'name');
					unset($this->register_fields[$captcha]);
					return;
				}
				
				$captcha = ihc_array_value_exists($this->register_fields, 'recaptcha', 'name');
				if ($captcha && $this->register_fields[$captcha][$this->display_type]){
					$captha_err = get_option('ihc_register_err_recaptcha');
					unset($this->register_fields[$captcha]);
					if (isset($_REQUEST['g-recaptcha-response'])){					
						$secret = get_option('ihc_recaptcha_private');
						if ($secret){
							include_once IHC_PATH . 'classes/ReCaptcha/ReCaptcha.php';
							$recaptcha = new ReCaptcha($secret);
							$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
							if (!$resp->isSuccess()){
								$this->errors['captcha'] = $captha_err;
							}
						} else {
							$this->errors['captcha'] = $captha_err;
						}
					} else {
						$this->errors['captcha'] = $captha_err;
					}
				}
			}
		}
		
		////WP ROLE
		private function set_roles(){
			//role
			if ($this->is_public && $this->type=='create'){
				// special role for this level?
				if (isset($_REQUEST['lid'])){
					$level_data = ihc_get_level_by_id($_REQUEST['lid']);
					if (isset($level_data['custom_role_level']) && $level_data['custom_role_level']!=-1 && $level_data['custom_role_level']){
						$this->fields['role'] = $level_data['custom_role_level'];
						return;
					}					
				}
				
				if (isset($this->register_metas['ihc_register_new_user_role'])){
					$this->fields['role'] = $this->register_metas['ihc_register_new_user_role'];
				} else {
					$this->fields['role'] = 'subscriber';
				}	
			} else if (!$this->is_public){
				if (isset($_REQUEST['role'])){
					$this->fields['role'] = $_REQUEST['role'];
				}
			}
		}
		
		public function update_level($url_return=''){
			/*
			 * used only in public section (ihc_acquire_new_level() in IHC_PATH/functions.php), for add new levels to user
			 * @param none 
			 * @return none
			 */
			if ($this->is_public){
				/****************** PUBLIC ******************/
				if (isset($_REQUEST['lid']) && $_REQUEST['lid']!=='none' && $_REQUEST['lid']>-1){ //'lid' can be none in a older version
					$user_levels = get_user_meta($this->user_id, 'ihc_user_levels', true);
					if ($user_levels){
						$user_levels_arr = explode(',', $user_levels);
						if (!in_array($_REQUEST['lid'], $user_levels_arr)){
							$user_levels_arr[] = $_REQUEST['lid'];
						}
						$user_levels = implode(',', $user_levels_arr);
					} else {
						$user_levels = $_REQUEST['lid'];
					}					
					$level_data = ihc_get_level_by_id($_REQUEST['lid']);
					
					if ($level_data['payment_type']=='payment'){
						ihc_send_user_notifications($this->user_id, 'user_update');//[$l_id]

						
						//======================== if price after discount is 0
						if (ihc_dont_pay_after_discount($_REQUEST['lid'], $this->coupon, $level_data, TRUE)){
							$this->handle_levels_assign($_REQUEST['lid']);
							update_user_meta($this->user_id, 'ihc_user_levels', $user_levels);
							ihc_update_user_level_expire($level_data, $_REQUEST['lid'], $this->user_id);
							if ($url_return){
								wp_redirect($url_return);
								exit();
							} else {
								return;
							}
						}
						//========================
						
						
						$payment_gateway = get_option('ihc_payment_selected');
						switch ($payment_gateway){
							case 'paypal':
								$this->handle_levels_assign($_REQUEST['lid']);
								update_user_meta($this->user_id, 'ihc_user_levels', $user_levels);
								//redirect to payment
								$href = IHC_URL.'public/paypal_payment.php?lid='.$_REQUEST['lid'].'&uid='.$this->user_id;
								if ($this->coupon){
									$href .= '&ihc_coupon=' . $this->coupon;
								}
								wp_redirect($href);
								exit();
								break;
							case 'authorize':								
								//redirect to payment
								if (isset($level_data['access_type']) && $level_data['access_type']=='regular_period'){
									$page = get_option('ihc_general_user_page');
									$url = get_permalink($page);
									$url = add_query_arg( 'ihc_ap_menu', 'profile', $url );
									$url = add_query_arg( 'lid', $_REQUEST['lid'], $url );
									wp_redirect($url);
								} else {
									$this->handle_levels_assign($_REQUEST['lid']);
									update_user_meta($this->user_id, 'ihc_user_levels', $user_levels);
									$href = IHC_URL . 'public/authorize_payment.php?lid='.$_REQUEST['lid'].'&uid='.$this->user_id;
									if ($this->coupon){
										$href .= '&ihc_coupon=' . $this->coupon;
									}
									wp_redirect($href);
									exit();
								}
								break;
							case 'twocheckout':	
								$this->handle_levels_assign($_REQUEST['lid']);
								update_user_meta($this->user_id, 'ihc_user_levels', $user_levels);
								ihc_twocheckout_submit($this->user_id, $_REQUEST['lid'], $this->coupon);//function available in utilities.php
								break;
							case 'bank_transfer':
								$this->handle_levels_assign($_REQUEST['lid']);
								update_user_meta($this->user_id, 'ihc_user_levels', $user_levels);
								if ($url_return){
									$url = add_query_arg( 'ihc_success_bt', true, $url_return );
									$url = add_query_arg( 'ihc_lid', $_REQUEST['lid'], $url );
									$url .= '#ihc_bt_success_msg';
									wp_redirect($url);
								}
								break;
							case 'stripe':
								$page = get_option('ihc_general_user_page');
								$url = get_permalink($page);
								$url = add_query_arg( 'ihc_ap_menu', 'profile', $url );
								$url = add_query_arg( 'lid', $_REQUEST['lid'], $url );
								wp_redirect($url);
								exit();
								break;
						}							
					} else {
						/****************** FREE LEVEL ******************/
						$this->handle_levels_assign($_REQUEST['lid']);
						update_user_meta($this->user_id, 'ihc_user_levels', $user_levels);
						if ($url_return){
							wp_redirect($url_return);
							exit();
						}
					}
				}
			}			
		}
		
		///LEVELs
		private function set_levels(){
			if ($this->is_public){
				/****************** PUBLIC ******************/
				if (isset($_REQUEST['lid']) && $_REQUEST['lid']!=='none' && $_REQUEST['lid']>-1){ //'lid' can be none in a older version
					$user_levels = get_user_meta($this->user_id, 'ihc_user_levels', true);
					if ($user_levels!==FALSE && $user_levels!=''){
						$user_levels_arr = explode(',', $user_levels);
						if (!in_array($_REQUEST['lid'], $user_levels_arr)){
							$user_levels_arr[] = $_REQUEST['lid'];
						}
						$user_levels = implode(',', $user_levels_arr);
					} else {
						$user_levels = $_REQUEST['lid'];
					}		

					$this->handle_levels_assign($_REQUEST['lid']);
					update_user_meta($this->user_id, 'ihc_user_levels', $user_levels);
					$level_data = ihc_get_level_by_id($_REQUEST['lid']);
					
					//======================== if price after discount is 0
					if (ihc_dont_pay_after_discount($_REQUEST['lid'], $this->coupon, $level_data, TRUE)){
						ihc_update_user_level_expire($level_data, $_REQUEST['lid'], $this->user_id);
						return;
					}
					//========================		
										
					if ($level_data['payment_type']=='payment'){
						$payment_gateway = get_option('ihc_payment_selected');
						switch($payment_gateway){
								case 'paypal':
											 //redirect to payment
											$href = IHC_URL.'public/paypal_payment.php?lid='.$_REQUEST['lid'].'&uid='.$this->user_id;
											if ($this->coupon){
												$href .= '&ihc_coupon=' . $this->coupon;
											}
											wp_redirect($href);
											exit();	
											break;
								case 'authorize':
											 //redirect to payment
											if (isset($level_data['access_type']) && $level_data['access_type']=='regular_period'){
												
											} else {
												$href = IHC_URL.'public/authorize_payment.php?lid='.$_REQUEST['lid'].'&uid='.$this->user_id;
												if ($this->coupon){
													$href .= '&ihc_coupon=' . $this->coupon;
												}
												wp_redirect($href);
											 	exit();
											}
											break;
								case 'twocheckout':
									ihc_twocheckout_submit($this->user_id, $_REQUEST['lid'], $this->coupon);//function available in utilities.php
									break;
								case 'bank_transfer':
									$this->bank_transfer_message = TRUE;
									break;
						}
											
					}
				}
			} else {
				/*************** ADMIN ********************/
				if (isset($_REQUEST['ihc_user_levels'])){					
					$the_level = $_REQUEST['ihc_user_levels'];
					if ($_REQUEST['ihc_user_levels']==-1 || $_REQUEST['ihc_user_levels']===''){
						$the_level = FALSE;
					}
					$this->handle_levels_assign($the_level);
					update_user_meta($this->user_id, 'ihc_user_levels', $the_level);
				}			
			}
		}
		
		private function handle_levels_assign($request_levels){			
			/*
			 * insert into db when user was start using this level, 
			 * if it's free level will assign the expire date, 
			 * if not paypal ipn will set the expire time
			 * @param string with all level ids separated by comma
			 * @return none
			 */			
			if ($request_levels!=-1 && $request_levels!==FALSE){				
				$current_levels = explode(',', $request_levels);

				if (count($current_levels)){
					
					$old_levels = get_user_meta($this->user_id, 'ihc_user_levels', true);
					foreach ($current_levels as $lid){
						if (isset($lid) && $lid!='' && strpos($old_levels, $lid)===FALSE){
							//we got a new level to assign
							$level_data = ihc_get_level_by_id($lid);//getting details about current level 
							$current_time = time();
							
							if (empty($level_data['access_type'])){
								$level_data['access_type'] = 'unlimited';
							}
							
							//set start time
							if ( $level_data['access_type']=='date_interval' && !empty($level_data['access_interval_start']) ){
								$start_time = $level_data['access_interval_start'];
							} else {
								$start_time = $current_time;
							}
							
							//set end time 
							if ($this->is_public &&	$level_data['payment_type']!='free'){
								//end time will be expired, updated when payment
								$end_time = '0000-00-00 00:00:00';
							} else {
								//it's admin or free so we set the correct expire time
								switch ($level_data['access_type']){
									case 'unlimited':
										$end_time = strtotime('+10 years', $current_time);//unlimited will be ten years
									break;
									case 'limited':
										if (!empty($level_data['access_limited_time_type']) && !empty($level_data['access_limited_time_value'])){
											$multiply = ihc_get_multiply_time_value($level_data['access_limited_time_type']);
											$end_time = $current_time + $multiply * $level_data['access_limited_time_value'];
										}
									break;
									case 'date_interval':
										if (!empty($level_data['access_interval_end'])){
											$end_time = $level_data['access_interval_end'];
										}
									break;
									case 'regular_period':
										if (!empty($level_data['access_regular_time_type']) && !empty($level_data['access_regular_time_value'])){
											$multiply = ihc_get_multiply_time_value($level_data['access_regular_time_type']);
											$end_time = $current_time + $multiply * $level_data['access_regular_time_value'];											
										}
									break;
								}
								$end_time = date('Y-m-d H:i:s', $end_time);
							}
							
							$update_time = date('Y-m-d H:i:s', $current_time);
							$start_time = date('Y-m-d H:i:s', $start_time);
							
							global $wpdb;
							$table = $wpdb->prefix . 'ihc_user_levels';
							$exists = $wpdb->get_row('SELECT * FROM ' . $table . ' WHERE user_id="' . $this->user_id . '" AND level_id="' . $lid . '";');
							if (!empty($exists)){
								$wpdb->query('DELETE FROM ' . $table .' WHERE user_id="' . $this->user_id . '" AND level_id="' . $lid . '";');//assure that pair user_id - level_id entry is not exists
							}					
							$wpdb->query('INSERT INTO ' . $table . '
												VALUES(null, "' . $this->user_id . '", "' . $lid . '", "' . $start_time . '", "' . $update_time . '", "' . $end_time . '", 0, 1);');				
						}
					}
				}
			}
		}//end of handle_levels_assign()
		
		
		///notify admin email
		private function notify_admin(){
			///send email to admin when someone is register
			///REGISTER SEND EMAIL
			if ($this->type=='create' && $this->is_public){
				if ($this->register_metas['ihc_register_admin_notify']){
					  $to = get_option('admin_email');
					  $subject = __('New Membership User registration on ', 'ihc') . get_option('blogname');
					  $msg = '';
					  $msg .= sprintf(__('New Membership User registration on: <strong> %s </strong>', 'ihc'), get_option('blogname')).'<br/><br/><br/>';
					  $msg .=  sprintf(__('<strong> Username:</strong> %s', 'ihc'), $_REQUEST['user_login']).'<br/>';
					  $msg .=  sprintf(__('<strong> Email:</strong> %s', 'ihc'), $_REQUEST['user_email']).'<br/><br/>';
					  if (isset($_REQUEST['lid'])){
						$msg .= sprintf(__('<strong> Level:</strong> %s', 'ihc'), $_REQUEST['lid']).'<br/>';  
					  }
					  $msg =  "<html><head></head><body>{$msg}</body></html>";
					  $headers = array('Content-Type: text/html; charset=UTF-8');
					  wp_mail( $to, $subject, $msg,$headers );
				}
			}			
		}
		
		///// RETURN ERROR
		private function return_errors(){
			/*
			 * set the global variable with the error string
			 */
			if (!empty($this->errors)){
				global $ihc_error_register;				
				$ihc_error_register = $this->errors;				
			}
		}
		
		private function count_register_fields(){
			$count = 0;
			foreach ($this->register_fields as $v){
				if ($v[$this->display_type] > 0){
					$count++;
				}
			}
			return $count;
		}
		
		private function succes_message(){
			if ($this->type=='create'){
				$q_arg = 'create_message';				
			} else {
				$q_arg = 'update_message';						
			}				
			
			$redirect = get_option('ihc_general_register_redirect');
			if ($redirect && $redirect!=-1 && $this->type=='create'){
				$url = get_permalink($redirect);
				if (!$url){				
					$url = ihc_get_redirect_link_by_label($redirect);
					if (strpos($url, IHC_PROTOCOL . $_SERVER['SERVER_NAME'] )!==0){
						//if it's a external custom redirect we don't want to add extra params in url, so let's redirect from here
						wp_redirect($url);
						exit();						
					}
				}
			} else {
				$url = IHC_PROTOCOL . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
			}
			
			if ($this->bank_transfer_message){
				$url = add_query_arg( array( 'ihc_register' => $q_arg, 'ihcbt' => 'true', 'ihc_lid' => $_REQUEST['lid'], 'ihc_uid' => $this->user_id ), $url );
			} else {
				$url = add_query_arg( array( 'ihc_register' => $q_arg ), $url );
			}
			
			wp_redirect($url);
			exit();
		}
		
		
		private function do_opt_in(){
			/*
			 * @param none
			 * @return none
			 */
			$double_email_verification = get_option('ihc_register_double_email_verification');
			if (get_option('ihc_register_opt-in') && $this->type=='create' && empty($double_email_verification)){
				//If Opt In it's enable, put the email address somewhere
				// Not available when double email verification it's enabled
				ihc_run_opt_in($_REQUEST['user_email']);
			}
		}//end of do_opt_in()
		
		
		private function double_email_verification(){
			/*
			 * @param none
			 * @return none
			 */
			$double_email_verification = get_option('ihc_register_double_email_verification');
			if ($this->is_public && $this->type=='create' && !empty($double_email_verification) ){
				$hash = ihc_random_str(10);
				//put the hash into user option
				update_user_meta($this->user_id, 'ihc_activation_code', $hash);
				//set ihc_verification_status @ -1
				update_user_meta($this->user_id, 'ihc_verification_status', -1);
				$activation_url_w_hash = IHC_URL . 'user_activation.php?uid=' . $this->user_id . '&ihc_code=' . $hash;
				//send a nice notification
				ihc_send_user_notifications($this->user_id, 'email_check', @$_REQUEST['lid'], array('{verify_email_address_link}'=>$activation_url_w_hash));
			}
		}
		
			
		////SOCIAL MEDIA
		private function social_register_request_data(){
			$str = '';
			if ($this->is_public){
				if (!empty($_GET['ihc_fb'])){
					$ihc_register_sm_value = 'fb';
					$ihc_sm_value = $_GET['ihc_fb'];
					$ihc_sm_name = 'ihc_fb';
				} else if (!empty($_GET['ihc_tw'])){
					$ihc_register_sm_value = 'tw';
					$ihc_sm_value = $_GET['ihc_tw'];
					$ihc_sm_name = 'ihc_tw';						
				} else if (!empty($_GET['ihc_in'])){
					$ihc_register_sm_value = 'in';
					$ihc_sm_value = $_GET['ihc_in'];
					$ihc_sm_name = 'ihc_in';									
				} else if (!empty($_GET['ihc_tbr'])){
					$ihc_register_sm_value = 'tbr';
					$ihc_sm_value = $_GET['ihc_tbr'];
					$ihc_sm_name = 'ihc_tbr';									
				} else if (!empty($_GET['ihc_ig'])){
					$ihc_register_sm_value = 'ig';
					$ihc_sm_value = $_GET['ihc_ig'];
					$ihc_sm_name = 'ihc_ig';									
				} else if (!empty($_GET['ihc_vk'])){
					$ihc_register_sm_value = 'vk';
					$ihc_sm_value = $_GET['ihc_vk'];
					$ihc_sm_name = 'ihc_vk';									
				} else if (!empty($_GET['ihc_goo'])){
					$ihc_register_sm_value = 'goo';
					$ihc_sm_value = $_GET['ihc_goo'];
					$ihc_sm_name = 'ihc_goo';									
				}
				if (!empty($ihc_register_sm_value) && !empty($ihc_sm_value) && !empty($ihc_sm_name)){
					$str .= indeed_create_form_element(array('name'=>'ihc_sm_register', 'value'=>$ihc_register_sm_value, 'type'=>'hidden'));
					$str .= indeed_create_form_element(array('name'=>$ihc_sm_name, 'value'=>$ihc_sm_value, 'type'=>'hidden'));
				}
			}
			return $str;
		}
		
		private function register_with_social(){
			/*
			 * test if user was register with social. If true generate a password if it's not set
			 * @param none
			 * @return none
			 */
			if ($this->is_public){
				if (isset($_REQUEST['ihc_sm_register'])){
					//generate password if it's not set
					if (empty($_REQUEST['pass1'])){
						$password = wp_generate_password();
						$_REQUEST['pass1'] = $password;
						$_REQUEST['pass2'] = $password;
					}
					
					//add social key to current register_fields array
					$name = 'ihc_' . $_REQUEST['ihc_sm_register'];
					$this->register_fields[] = array('name' => $name);

				}
			}
		}//end of register_with_social
		
		private function ihc_social_form(){
			/*
			 * @param none
			 * @return string
			 */
			 $url = IHC_PROTOCOL . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
			 $str = '<form method="post" action="' . IHC_URL . 'public/social_handler.php" id="ihc_social_login_form">';
			 $str .= '<input type=hidden name=ihc_current_url value=' . urlencode($url) . ' />';
			 $str .= '<input type=hidden name=sm_register value=1 />';
			 $str .= '</form>';
			 return $str;
		}

		////COUPONS
		
		public function set_coupon(){
			/*
			 * @param none
			 * @return none
			 */
			if (isset($_REQUEST['ihc_coupon'])){
				$this->coupon = $_REQUEST['ihc_coupon'];
				if (!empty($this->register_fields)){
					$ihc_coupon = ihc_array_value_exists($this->register_fields, 'ihc_coupon', 'name');
					if (isset($ihc_coupon) && $ihc_coupon!==FALSE){
						unset($this->register_fields[$ihc_coupon]);
					}					
				}
			}
		}
		
		public function save_coupon(){
			if ($this->coupon && $this->user_id){
				$user_coupons = get_user_meta($this->user_id, 'ihc_coupon', TRUE);
				$user_coupons[] = $this->coupon;
				update_user_meta($this->user_id, 'ihc_coupon', $user_coupons);
			}
		}
		
	}//end of class UserAddEdit
}
