<?php
App::uses('Controller', 'Controller');

class AppController extends Controller {
	public $components = array(
		'Session',
		'Cookie',
		'RequestHandler',
		'Auth' => array(
			'loginAction' => array('controller' => 'users', 'action'=> 'login'),
			'loginRedirect' => array('controller' => 'users', 'action' => 'dashboard'),
			'logoutRedirect' => array('controller' => 'users', 'action' => 'logout'),
			'authError' => 'Did you really think you are allowed to see that?',
			'authenticate' => array(
				'Form' => array(
					'fields' => array('username' => 'email')
				)
			)
		)
	);
	
	public function beforeFilter() {		
		$this->Auth->allow( array('login', 'registration', 'thank', 'activation', 'is_user_exists', 'entry','documents', 'folders', 'view','comments', 'addComment','forgot_password','password_reset', 'change_password', 'validation'));
	}
}
