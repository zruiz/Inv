<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
//echo "sainath";
$email_content = esc_attr($_POST['email_content']);
$email_subject = esc_attr($_POST['Subject']);
$email = $_POST['Email'];
$name = esc_attr($_POST['Name']);
$car = $_POST['Vehicle_ID'];
$post_type = get_post_type($car);
if($post_type=="yachts") { 
	$address = get_post_meta($car,'imic_plugin_contact_email',true); 
	//if($address=='') { $address = get_option('admin_email'); } 
} else { $address = get_option('admin_email'); }
echo $car;
$subject = $email_subject;
global $imic_options;
$body = $name. __(' has submitted an enquiry. Please find the details below.','framework');
if(!empty($imic_options[$email_content])){	
	$u_body = $imic_options[$email_content];
}else{
	$u_body=__("You information has been received, we will contact you shortly.",'framework');
}	
$e_content = '';
foreach($_POST as $key=>$value) {
	if($key!="email_content"&&$key!="Subject") {
		if($key=="Vehicle_ID")
		{
			$e_content .= "<p>".esc_attr__("Listing: ", "framework").get_permalink($value)."</p>";
		}
		else
		{
			$e_content .= "<p>$key: $value</p>";
		}
	}
}
//$e_reply = __("You can contact","framework"). $name .__("via email","framework").", $email";
$msgs = preg_replace('/Dear/', 'Dear '.$name, $u_body);
$msgs = wordwrap( ltrim($msgs), 70 );
$msg = wordwrap( ltrim($body . $e_content), 70 );
$admin_email = get_option('admin_email');

$headers = "From: $email" . PHP_EOL;
$headers .= "Reply-To: $email" . PHP_EOL;
$headers .= "MIME-Version: 1.0" . PHP_EOL;
$headers.="Content-Type: text/html; charset=\"iso-8859-1\"\n";
$header = "From: $admin_email" . PHP_EOL;
$header .= "Reply-To: $admin_email" . PHP_EOL;
$header .= "MIME-Version: 1.0" . PHP_EOL;
$header .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
if ($address != '') {
	mail($address, $subject, $msg, $headers);
	mail($admin_email, $subject, $msg, $headers);
} else mail($admin_email, $subject, $msg, $headers);
wp_mail($email, 'New Client Enquiry', $msgs);		
?>