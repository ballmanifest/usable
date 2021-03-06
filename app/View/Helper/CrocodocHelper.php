<?php

	/*
	 * Crocodoc integration
	 */

	App::uses('AppHelper', 'View/Helper');
	
	require_once 'crocodoc/Crocodoc.php';

	$uuid1 = '057d6c6a-1589-4a8a-9e2e-61d873a0a2db';
	$uuid2 = '82be5a5d-1c85-4d58-9d17-79af97e52b73';
	
	class CrocodocHelper extends AppHelper {
	
		/*
		 *	Configurations
		 */
		
		public $url = null;
		public $uuidGet = null;
		public $uuidSet = null;
		public $apiToken = null;
		
		public function __construct() {}
		
		public function setToken($API_TOKEN) {
			//$this->apiToken = $API_TOKEN ? $API_TOKEN : ' wt70OZCukd6Az2jNF8fHScvQ'; // 'E7ub1x3TqgeZAVy6C5FdIKMN'
			$this->apiToken = $API_TOKEN;
			Crocodoc::setApiToken($API_TOKEN);
			return $this;
		}
		
		public function createSession() {
			$sessionKey = CrocodocSession::create($this->uuidSet);
			return $sessionKey;
		}
		
		public function setURL($url) {
			if( !$this->apiToken ) {
				$this->_sendMessage (
					array(
						'status' => 'fail',
						'error' => 'Set your API TOKEN first'
					)
				);
			} else {
				$this->url = $url;
			}
			return $this;
		}
		
		public function uploadFile() {
			try {
				$fileHandle = fopen($this->url, 'r');
				$uuid = CrocodocDocument::upload($fileHandle);
				$this->uuidGet = $uuid;
				$result = array( 
							'status' => 'ok', 
							'uuid' => $this->uuidGet
						);
			} catch (CrocodocException $e) {
				$result = array(
							'status' => 'fail',
							'error' => array (
								'error_code' => $e->errorCode,
								'error_msg' => $e->getMessage()
							)
						);
			}
			return $result;
			
			//$this->_sendMessage($result);
		}
		
		public function setUUID($uuids = null) {
			if( empty($uuids) && !$uuids) {
				$this->_sendMessage (
					array(
						'status' => 'fail',
						'error' => 'No UUID to delete.'
					)
				);
			} else {
				if(is_string($uuids) && strpos($uuids, ',') !== false) {
					$uuids = explode(',', $uuids);
				}
				$this->uuidSet = $uuids;
				return $this;
			}
		}
		
		public function getStatus() {
			try {
				if( !$this->_isUUID() )  {
					$result = array(
								'status' => 'fail',
								'error' => 'Set UUID to file'
							);
					$this->_sendMessage($result);
					return false;
				}
				$statuses = CrocodocDocument::status($this->uuidSet);
				if (!empty($statuses)) {
					/*
					foreach($statuses as $x => $status) {
						if( empty($status['error']) ) {
							$results[$x]['status'] = 'ok';
							$results[$x]['file'] = array(
								'status' => $status['status'],
								'viewable' => $statuses[0]['viewable']
							);
						} else {
							$results[$x] = array(
								'status' => 'fail',
								'error' =>  $statuses[0]['error']
							);
						}
					}
					*/
				} else {
					$results = array(
						'status' => 'fail',
						'error' =>  'nofile'
					);
				}
			} catch (CrocodocException $e) {
				$results = array (
					'status' => 'fail',
					'error' =>  array(
						'error_code' => $e->errorCode,
						'error_msg' => $e->getMessage()
					)
				);
			}
			$this->uuidSet = null;
			return $statuses;
			//$this->_sendMessage($results);
		}
		
		public function downloadAsOriginal() {
			// TODO
		}
		
		public function downloadAsPdf() {
			// TODO
		}
		
		private function _isUUID() {
			if( !empty($this->uuidSet) ) {
				return true;
			} else return false;
		}
		
		private function _setToken($apiToken) {
			if(!empty($apiToken)) {
				$this->apiToken = $apiToken;
				//Crocodoc::setApiToken($this->apiToken);
				return $this;
			} else {
				$this->_sendMessage (
					array(
						'status' => 'fail',
						'error' => 'No API TOKEN to set'
					)
				);
			}
		}
		
		private function _sendMessage($msg = array(), $isJSON = true) {
			if( $isJSON ) {
				echo json_encode($msg);
			} else print_r( $msg );
		}
	}

/*
$url = 'http://filocitydev.com/files/testfiles/pdf-test.pdf';
$Crocodoc = new FilocityFileManagement;
//$Crocodoc->setToken(API_TOKEN)->setURL($url)->uploadFile();
echo $Crocodoc->setUUID(array($uuid1, $uuid2))->getStatus();
*/
?>
