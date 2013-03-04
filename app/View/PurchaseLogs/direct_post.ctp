<?php 
		echo $this->Html->css(array('directpayment', 'jquery-ui'));
		echo $this->Html->script(array('payment', 'jquery-ui-1.8.23.custom.min'));
		$url = "http://filocitydev.com/purchase_logs/direct_post"; 
		$api_login_id = '8J5pmZ324y'; 
		$transaction_key = '74FXUGJv264ybd4h'; 
		$md5_setting = '8J5pmZ324y'; // Your MD5 Setting 
		$amount = "5.99"; 
		AuthorizeNetDPM::directPostDemo($url, $api_login_id, $transaction_key, $amount, $md5_setting); 
?>

