<?php
	/**
	*
	*	Mandrill Integration for 
	*	Filocity Email Varification
	*	
	*/
	
	class Mandrill {
	
		public $apiKey = '';
		public $root = 'https://mandrillapp.com/api/1.0';
		public $params = array();
		
		public function __construct($apiKey) {
			if(!empty($apiKey)) {
				$this->apiKey = $apiKey;
			}
		}
		
		private function _requestHandler($params) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mandrill-PHP/1.0');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3000);
			curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
			
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);	// stop SSL varification
			
			$send_url = $this->root . '/messages/send.json';
			curl_setopt($ch, CURLOPT_URL, $send_url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
			
			$response_body = curl_exec($ch);
			$result = json_decode($response_body, true);			
			curl_close($ch);
			
			return $result;
		}
		
		public function prepareAndSendEmail($activation_url, $user, $html='', $subject='') {
		
			$subject = $subject ? $subject : 'Account Activation for Filocity';
			
			if(empty($html)) {
				$html = '<h2>Filocity.com - Confirm your email</h2>';
				$html .= '<p><strong>Thank you</strong> for registering for Filocity!  To get started, please confirm your email with the link below.</p>';
				$html .= '<p>'. $activation_url .'</p>';
			}
			if(!empty($user['User']['password'])) {
				$html .= '<p>Your login password is: <span style="color:#a9a9a9">'. $user['User']['password'] .'</span></p>';
			}
			$to = array(
				array(
					'email' => $user['User']['email'], 
					'name' => @$user['User']['first_name'] . ' ' . @$user['User']['last_name']
				),
			);
			
			$template_name = 'registration';
			$template_content = array (
									'name' => 'registration',
									'content' => $html
								);
			
			$email_config = array(
								'key' => $this->apiKey,
								//'template_name' => $template_name,
								//'template_content' => $template_content,
								'message' => array(
												'html' => $html,
												//'text' => $text,
												'subject' => $subject,
												'from_email' => 'no-reply@filocity.com',
												'from_name' => 'Filocity',
												'to' => $to
											)
								);
			$result = $this->_sendEmail($email_config);
			return $result;
		}
		
		
		public function prepareAndSendPasswordEmail( $user, $html='', $subject='') {
		
			
			
			$to = array(
				array(
					'email' => $user['User']['email'], 
					'name' => @$user['User']['first_name'] . ' ' . @$user['User']['last_name']
				),
			);
			
			$template_name = 'forgot password';
			$template_content = array (
									'name' => 'forgot password',
									'content' => $html
								);
			
			$email_config = array(
								'key' => $this->apiKey,
								//'template_name' => $template_name,
								//'template_content' => $template_content,
								'message' => array(
												'html' => $html,
												//'text' => $text,
												'subject' => $subject,
												'from_email' => 'no-reply@filocity.com',
												'from_name' => 'Filocity',
												'to' => $to
											)
								);
			$result = $this->_sendEmail($email_config);
			return $result;
		}
		
		
		
		private function _sendEmail ($config) {
			$params = json_encode($config);
			$result = $this->_requestHandler($params);
			return $result;
		}
	}
	
?>