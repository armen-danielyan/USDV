<?php
require_once( dirname(__FILE__) . '/wp-load.php' );
//$message = 'It is test mail from developer';
//mail('islam.shaiful7@gmail.com', 'Test mail', $message);
/** changing default wordpres email settings */

$lang = isset($_GET['lang']) ? $_GET['lang'] : '';
$ip_address = $_SERVER['REMOTE_ADDR'];
$aa = file_get_contents('http://ip-api.com/json/'.$ip_address);
$a = json_decode($aa);

echo '<pre/>';
print_r($_SERVER['HTTP_USER_AGENT']);
echo '<pre/>';
print_r($a);

exit;
 
add_filter('wp_mail_from', 'new_mail_from');
add_filter('wp_mail_from_name', 'new_mail_from_name');
 
function new_mail_from($old) {
 return 'info@usdvexperts.com';
}
function new_mail_from_name($old) {
 return 'Usdvexperts';
}

 $Title = "Mail check";
 $Message = "Hi ,\n \n It is test mail from developer.";
 $headers = "From: info@usdvexperts.com\r\n";
 $headers .= "Reply-To: usdvexperts<info@usdvexperts.com>\r\n";
 $headers .= "Return-Path: info@usdvexperts.com\r\n";
 wp_mail( 'farhad.rpi@gmail.com' , $Title , $Message );