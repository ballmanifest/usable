<?php
App::uses('AppController', 'Controller');

class ShortUrlsController extends AppController {

	/**
	*	Method for URL shortening
	*
	*	@return
	*		Either a valid SHORT_URL or FALSE	
	*/
	public function short() {
		$this->autoRender = 0;
		if($this->Auth->loggedIn() && $this->request->is('post') && !empty($this->request->data['ShortUrl']['original_url'])) {
			$url = $this->request->data['ShortUrl']['original_url'];
			$short_url = $this->ShortUrl->doShort($url);
			if($short_url) {
				return FULL_BASE_URL . '/d/' . $short_url;
			}
		}
		return 0;
	}
	
	/**
	*	Method for parse the short url
	*	and redirect user to original location
	*/
	public function forward() {
		$this->autoRender = 0;
		$redirectTo = $this->ShortUrl->field('original_url', array('ShortUrl.url_code' => $this->params['id']));
		$this->redirect($redirectTo);
	}
}
