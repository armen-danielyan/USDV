<?php
require_once( dirname(__FILE__) . '/wp-load.php' );

if ($_POST['message_type'] == 'ORDER_CREATED') {
	$insMessage = array();
		foreach ($_POST as $k => $v) {
		$insMessage[$k] = $v;
	}
	
	# Validate the Hash
	$hashSecretWord = "ZWZhMDE5NDAtODkyMy00YzUzLWIwOGUtOWRmY2I3YjFjZjZk"; # Input your secret word
	$hashSid = 901299300; #Input your seller ID (2Checkout account number)
	$hashOrder = $insMessage['sale_id'];
	$hashInvoice = $insMessage['invoice_id'];
	$StringToHash = strtoupper(md5($hashOrder . $hashSid . $hashInvoice . $hashSecretWord));
	$member_id = $insMessage['vendor_order_id'];

	if ($StringToHash != $insMessage['md5_hash']) {
		update_user_meta($member_id, 'payment', 0);
		update_user_meta($member_id, 'payment_return', serialize($insMessage));
		exit();
	}else{

		update_user_meta($member_id, 'payment', 1);
		update_user_meta($member_id, 'payment_return', serialize($insMessage));

		$user = new WP_User( $member_id );
		$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

		$message .= 'Thank You.';
		$message .= 'Your payment has been success.';
		mail($user->user_email, 'Payment Success on - '.$blogname, $message);
		exit();
	}
}
