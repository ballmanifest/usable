<?php
App::uses('AppModel', 'Model');
/**
 * ShortUrl Model
 *
 */
class ShortUrl extends AppModel {

	public $displayField = 'url_code';

	public $validate = array(
		'original_url' => array(
			'rule' => 'url'
		)
	);

	/**
	*	Generate the url_code in this callback
	*	and set to $this->data
	*/
	public function beforeSave($options=array()) {
		$urlCode = $this->buildShortUrl();
		$this->data[$this->alias]['url_code'] = $urlCode;
		return 1;
	}
	
	/**
	*	Checking procedure, if given url is already in record
	*/
	private function alreadyShortened($original_url=null) {
		return $this->field('url_code', array($this->alias . '.' . 'original_url' => $original_url));
	}
	
	/**
	*	Main Interface for url shortening
	*/
	public function doShort($original_url=null) {
		
		/**
		*	First checking for existance of short code for that url
		*	if exists, then return that short code
		*/
		$url_code = $this->alreadyShortened($original_url);
		if( $url_code ) {
			return $url_code;
		}
		
		/**
		*	If short code not exists
		*/
		$this->data[$this->alias]['original_url'] = $original_url;
		$this->set($this->data);
		
		if($this->validates()) {
			if($this->save($this->data)) {
				$this->id = $this->getLastInsertId();
				return $this->field('url_code');
			}
		}
		return 0;
	}
	
	/**
	*	Process for build the urlcode
	*/
	private function buildShortUrl() {
		$codeset = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_.-~";
		$base = strlen($codeset);
		$n = mt_rand(100, 9999999);
		$converted = null;
		while ($n > 0) {
		  $converted = substr($codeset, ($n % $base), 1) . $converted;
		  $n = floor($n / $base);
		}
		return $converted;
	}
}
