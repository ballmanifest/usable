<?php
App::uses('AppHelper', 'View/Helper');

class ZohoHelper extends AppHelper {

	function openEditor($baseUrl='', $file='', $fileName='', $ext='', $docId='', $saveUrl='') {
	
		$apiKey = "d67f93c58707ddb6abd945974887ec38";
		$SecretKey = "99ac3934c77a5986de0e1e46a1983f84";
		$viewer_url = '';
		
		$ZohoTarget = "";
		$docUrl = $baseUrl . $file;
		
		switch ($ext) {
			case "docx":
			case "doc":
			case "rtf":
			case "html":
			case "htm":
			case "odt":
			case "txt":
			case "sxw":
				$ZohoTarget = "https://exportwriter.zoho.com/remotedoc.im";
				break;
			case "ppt":
			case "pps":
			case "odp":
			case "sxi":
				$ZohoTarget = "https://show.zoho.com/remotedoc.im";
				break;
			case "xls":
			case "xlsx":
			case "ods":
			case "sxc":
			case "csv":
			case "tsv":
				$ZohoTarget = "https://sheet.zoho.com/remotedoc.im";
				break;
		}

		$url = $ZohoTarget;
		
		/**
		*	If extension type not matched
		*/
		if(!$ZohoTarget) {
			return 'ext_fail';
		}
			
		/**
		*	Setup and send request to Zoho
		*/
		
		App::uses('HttpSocket', 'Network/Http');
		
		$fields = array (
			'filename' => $fileName,
			'url' => $docUrl,
			'apikey' => $apiKey,
			'output' => 'viewurl',
			'mode' => 'normaledit',
			'lang' => 'en',
			'id' => $docId,
			'format' => $ext,
			'saveurl' => $saveUrl,
			'agentname' => 'ZRemoteAgent'
		);
		
		$HttpSocket = new HttpSocket(array(
			'ssl_allow_self_signed' => 1,
			'ssl_verify_host' => 1,
			'ssl_verify_peer' => 1
		));
		
		$response = $HttpSocket->post($url, $fields);
		
		if($response->code == '200') {
			$arr = explode("\n", $response->body);
			foreach ($arr as $v) {
				$r = explode('=', $v);
				if ($r[0] == "RESULT")
					$result = $r[1];
				if ($r[0] == "WARNING")
					$warning = $r[1];
				if ($r[0] == "URL")
					$viewer_url = substr($v, 4);
			}
		}
		return $viewer_url;
    }
}	
?>
