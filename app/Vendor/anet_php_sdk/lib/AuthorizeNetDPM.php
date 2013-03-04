<?php
class AuthorizeNetDPM extends AuthorizeNetSIM_Form
{

    const LIVE_URL = 'https://secure.authorize.net/gateway/transact.dll';
    const SANDBOX_URL = 'https://test.authorize.net/gateway/transact.dll';
	
	private static function _send_to_AuthNet($post_url = '', $post_values = array()) {
		$request = curl_init($post_url); 
		curl_setopt($request, CURLOPT_HEADER, 0); 
		curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($request,CURLOPT_POST, 1);
		curl_setopt($request, CURLOPT_POSTFIELDS,  http_build_query( $post_values )); 
		curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); 
		$post_response = curl_exec($request); 
		curl_close ($request); 
		return $post_response;
	}

	public static function FilocityDPM($url, $api_login_id, $transaction_key, $amount= '0.00', $md5_setting = '', $test_mode = false, $custom_fields = array()) {
		$post_url = ($test_mode ? self::SANDBOX_URL : self::LIVE_URL);
		$fp_sequence = time();
		$post_values = AuthorizeNetDPM::get_credit_card_required_fields($amount, $fp_sequence, $url, $api_login_id, $transaction_key, $custom_fields);
		$post_response = AuthorizeNetDPM::_send_to_AuthNet($post_url ,$post_values);
		$response_array = explode($post_values["x_delim_char"],$post_response);
		return $response_array;
	}
	
	public static function get_credit_card_required_fields($amount, $fp_sequence, $relay_response_url, $api_login_id, $transaction_key, $custom_fields = array()) {
		$time = time();
        $fp = self::getFingerprint($api_login_id, $transaction_key, $amount, $fp_sequence, $time);
        $sim = array(
					'x_fp_sequence'   => $fp_sequence,
					'x_fp_hash'       => $fp,
					'x_fp_timestamp'  => $time,
					'x_relay_response'=> "FALSE",
					'x_login'         => $api_login_id,
					'x_fp_sequence'   => $fp_sequence,
					'x_fp_hash'       => $fp,
					'x_fp_timestamp'  => $time,
					'x_version' => '3.1',
					'x_delim_data' => 'TRUE',
					'x_delim_char' => '|'
				);
		$post_values = array_merge($sim, $custom_fields);
		return $post_values;
	}

}