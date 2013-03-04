<?php
App::uses('AppController', 'Controller');
App::uses('CakeTime', 'Utility');
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class UsersController extends AppController {
 
	/**
	*	$previous_package: 
	*		used for keep record of 
	*		package used by user before upgrading
	*/
    public $previous_package = array();
	
	/**
	*	Generate Random password
	*/
	private function _randomPassword() {
		$alphabet = 'JKLMNOabcdef#ghijk%lm&nop*qrstu23wxy(zA_BCD!EFGHI)PQRST^UWXYZ012345$6789';
		$pass = array(); 
		$alphaLength = strlen($alphabet) - 1; 
		for ($i = 0; $i < 16; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass);
	}
	
	public function beforeFilter() {
		parent::beforeFilter();

		if($this->Auth->loggedIn() && 'login' === $this->action )  {
			$this->redirect(array('controller' => 'users', 'action' => 'dashboard'  ));
		}
		
		if($this->Auth->loggedIn() && 'registration' === $this->action ) {
			$this->redirect(array('controller' => 'cabinets'));
		} 

		$this->Auth->deny('view');
	}	
	
	public function index() {
		$this->redirect(array('controller' => 'cabinets'));
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}
	
	public function view($id = null) {
		$this->redirect(array('controller' => 'cabinets'));
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	public function add() { 
		$this->redirect(array('controller' => 'cabinets'));
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$companies = $this->User->Company->find('list');
		$projects = $this->User->Project->find('list');
		$this->set(compact('companies', 'projects'));
	}

	public function edit($id = null) {
		$this->redirect(array('controller' => 'cabinets'));
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
		$companies = $this->User->Company->find('list');
		$projects = $this->User->Project->find('list');
		$this->set(compact('companies', 'projects'));
	}

	public function delete($id = null) {
		$this->redirect(array('controller' => 'cabinets'));
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	
	public function login() {	
		if ($this->request->is('post')) {
			$user = $this->User->find('first',array('conditions' => array('User.email' => $this->request->data['User']['email'], 'User.password' => AuthComponent::password($this->request->data['User']['password']))));
			if(!$user || empty($user)) {
				$this->Session->setFlash('Sorry! You\'re not a valid member.');
				$this->redirect($this->Auth->logout());
				return false;
			}
			$only_user = array_shift($user);
			$all_user_data = $user;
			$result = am($only_user, $all_user_data);
			$set_cookie = 0;
			if(isset($this->request->data['User']['checkbox']) and $this->request->data['User']['checkbox']=='1'){
				$set_cookie = 1;
			}
			if ($this->Auth->login($result, $set_cookie)) { 
				if($this->Auth->loggedIn() && !$this->Auth->user('status')) {
					$this->Session->setFlash('You\'re account is not active. Please Activate your account via activation mail.');
					$this->redirect($this->Auth->logout());
					return false;
				}
				
				/**
				*	If logged user is guest
				*	then redirect him to guest page
				*/
				/*
				if(2 === intval($this->Auth->user('role'))) {
					return $this->redirect(array('controller' => 'guests', 'action' => 'entry'));
				} 
				*/
				$log = array(
							'Log' => array(
										'user_id' => $this->Auth->user('id')
									)
						);
				$this->User->Log->create();
				$this->User->Log->save($log);
			   
				// check trial exists
				$trial_date = $this->Auth->user('trial_end');
				if($trial_date != '0000-00-00') {
					$date1 = new DateTime($trial_date);
					$date2 = new DateTime(date('Y-m-d'));
					$interval = $date1->diff($date2);
					if($interval->d > 14) {
						// TODO
					}
				}
				return $this->redirect(array('controller' => 'cabinets'));
			} else {
				$this->Session->setFlash(__('Username or password is incorrect'), 'default', array(), 'auth');
			}
		}
	}
	
	public function change_password() {
		$user_id = '';
		$email = '';
		if($this->Auth->loggedIn()) {
			$user_id = $this->Auth->user('id');
			$email = $this->Auth->user('email');
		} else {
			$this->Session->setFlash(__('Please Login to change password'));
		}
		if($this->request->is('post') && !empty($this->request->data) && $this->Auth->loggedIn()) {
			if($this->request->data['User']['password'] == $this->request->data['User']['confirm_password']) {
				$this->request->data['User']['id'] = $this->Auth->user('id');
				unset($this->request->data['User']['confirm_password']);
				if($this->User->save($this->request->data, false)) {
					$this->Session->setFlash(__('Password Updated.'));
					$this->redirect($this->Auth->logout());
				} else {
					$this->Session->setFlash(__('Sorry, Password change failed. Try again.'));
				}
			} else {
				$this->Session->setFlash(__('Password and Confirm Password don\'t match.'));
			}
		} else {
			$this->Session->setFlash(__('Please Login to change password'));
		}
		$this->set(compact('user_id', 'email'));
	}
	
	public function logout() {
		
	    $this->Cookie->destroy();
		$this->redirect($this->Auth->logout());
	}
	
	public function terms() {
		
	}
	
	public function thank() {
		
	}
	
	public function registration($choosed_package=null) {
		$package_name = null;
		$isValidPackage = true;
		
		/**
		*	Varification on package
		*/
		if(empty($choosed_package) && empty($this->request->named['package'])) {
			$this->Session->setFlash(__('Package info not found.'));
			$isValidPackage = false;
		}

		if(empty($choosed_package) && !empty($this->request->named['package'])) {
			$package_name = 'package_' . $this->request->named['package'];
		} else if(empty($this->request->named['package']) && !empty($choosed_package) && ($choosed_package == '14-day-free-trial-cc' || $choosed_package ==  '14-day-free-trial')) {
			$package_name = $choosed_package;
		} else {
			$this->Session->setFlash(__('Invalid Package.'));
			$isValidPackage = false;
		}
		
		
		$this->loadModel('Package');
		$my_package = $this->Package->findByName($package_name);
		$package_id = $my_package['Package']['id'];
		if(!$package_id) {
			$this->Session->setFlash(__('Invalid Package.'));
			$isValidPackage = false;
		}
		
		/**
		*	If Package varification passed
		*	then forward for Registration
		*/
		if ($this->request->is('post') && !empty($this->request->data) && $isValidPackage) {
		
			/**
			*	Assign Default Subscription Id
			*	A valid Subscription Id will appear
			*	only when Billing Confirm
			*/
			$subscription_id = null;
			
			/**
			*	Set User Status
			*	Default is 0, means User not activate his acccount via activation mail
			*/
			$status = 0;

			/**
			*	Validating User Information
			*	If everything goes well then bill User
			*/
			
			$this->User->set($this->request->data);
			if($this->User->validates() && $package_name != '14-day-free-trial') {
				
				/**
				*	Make User Paid if he choose any package acccept " 14-day-free-trial"
				*
				*	But In case of, " 14-day-free-trial-cc " Billing will not instant. 
				*	System will keep records and will bill after 14 days
				*
				*	Payment Service use:	Authorize.net
				*
				*	API:					ARB Billing API
				*/
				
				App::import("Vendor", 'anet_php_sdk' . DS . 'FilocityDPM');

				/**
				*	Get Selected Package Price
				*/
				$this->User->Company->Package->recursive = -1;
				$package = $this->User->Company->Package->findById($package_id);
				$amount = number_format($package['Package']['price'],2);
		
				/**
				*	Get Conuntry and State name
				*/
				$this->User->State->recursive = -1;
				$country = $this->User->Country->findById($this->request->data['User']['country_id']);
				$state = $this->User->State->findById($this->request->data['User']['state_id']);					   

				/**
				*	Setting up Authorize.net API credentials
				*/
				$api_login_id = '6m8QM2ws4'; 
				$transaction_key = '639DJNw8n3e836j9'; 

				/**
				*	Set up fields for payment
				*/
				
				/**
				*	Format Expiration date as ARB want
				*/
				$expected_date_format = $this->request->data['User']['card_expiration_date']['month'] . '/' . $this->request->data['User']['card_expiration_date']['year'];
				
				/**
				*	Set Expiration date to save
				*/
				$this->request->data['User']['card_expiration_date'] = '';
				$this->request->data['User']['card_expiration_date'] = $expected_date_format;
				
				$payment_fields = array(
						'auth_login_key' => $api_login_id,
						'transaction_key' => $transaction_key, 
						'package_name' => $package_name,
						'package_amount' => $amount ,
						'cc_number' => $this->request->data['User']['card_number'],
						'security_code' => $this->request->data['User']['security_code'],
						'expire_date' => $expected_date_format,
						'order_invoice' => '',
						'customer_email' => $this->request->data['User']['email'],
						'customer_id'  =>  '' , 
						'bill_firstname' => $this->request->data['User']['first_name'],
						'bill_lastname' => $this->request->data['User']['last_name'],
						'bill_company' => $this->request->data['User']['company_name'],
						'bill_address' => $this->request->data['User']['mail_address_1'],
						'bill_city' => $this->request->data['User']['city'],
						'bill_state' => $state["State"]["name"],
						'bill_country' => $country["Country"]["name"],
						'bill_zipcode' => $this->request->data['User']['zip'],    
						'trial_amount' => 0 ,
						'trial_occurance' => 14,
				);		
				
				/**
				*	Calling ARB for finalize Billing
				*/
				$auth_response_arr = $this->User->doCallARB($payment_fields);
				
				/**
				*	Taking Action depending on
				*	Authorize.net Returned Message
				*
				*	If success, then update the $subscription_id, else throw error message to user
				*/
				if($auth_response_arr->getSubscriptionId()) {
					$subscription_id = $auth_response_arr->getSubscriptionId(); 
					/**
					*	Set subscription_id for save
					*/					
					$this->request->data['User']['subscription_id'] = $subscription_id;					
				} else {
					$this->Session->setFlash(__('Sorry, Payment Failed. Credit Card Authorization failed.'));
					$this->redirect($this->referer());
				} 
			}
			
			/**
			*	Creating Company for User
			*	and update company_id to save
			*/
			$company = array();
			$company['Company'] = array('name' => $this->request->data['User']['company_name'], 'package_id' => $this->request->data['User']['package_id']);
			$company_id = null;
			$this->User->Company->create();
			if( $this->User->Company->save($company) ) {
				$company_id = $this->request->data['User']['company_id'] = $this->User->Company->id;
			}
			
			/**
			*	Processing User info for save
			*/
			$user = array();
		
			$uuid = String::uuid();
			$this->request->data['User']['activation_key'] = $uuid;
			$this->request->data['User']['status'] = $status;
			$this->request->data['User']['auth_key'] = rand(1000, 100000);
			
			if($package_name == '14-day-free-trial-cc' || $package_name ==  '14-day-free-trial') {
				$this->request->data['User']['trial_end'] = date('Y-m-d', strtotime('+14 days'));
			}
			$user['User'] = $this->request->data['User'];
			
			/**
			*	Remove some validation
			*	if user choose "14*day-free-trial"
			*/
			if($package_name == '14-day-free-trial') {
				$validator = $this->User->validator();
				// Unset subscription_id for free trial with no credit card required
				unset($this->User->data['User']['subscription_id'], $this->User->data['User']['card_expiration_date']);
				unset($validator['subscription_id'], $validator['mail_address_1'], $validator['zip'], $validator['city'], $validator['country_id'], $validator['state_id'], $validator['card_name'], $validator['card_number'], $validator['card_expiration_date'], $validator['security_code']);
			}
			
			/**
			*	Save User
			*/
			
			$this->User->create(); 
			if ($this->User->save($user, false)) {
				$auth_id = $this->User->id;                                     
				$company_space_and_my_space_idx = $this->User->create_company_and_my_space($auth_id, $company_id, false);

				/**
				*	Update company_space_id & my_space_id fields in `users` table
				*	after create company space and My Space succfullly
				*/ 
				$update_user = array(
								'id' => $auth_id,
								'company_space_id' => $company_space_and_my_space_idx['company_space_id'],
								'my_space_id' => $company_space_and_my_space_idx['my_space_id'],
								'my_share_id' => $company_space_and_my_space_idx['my_share_id'],
						);
				$this->User->save($update_user, false);
				
				// Update my_space_id 
				$update_company = array(
									'id' => $company_id,
									'company_space_id' => $company_space_and_my_space_idx['company_space_id']
								);
				$this->User->Company->save($update_company, false);

				/**
				*	Make a record in Payment Log Table
				*	Two arguments: $subscription_id and $amount respectively
				*
				*	Keep records only when not a free trail without credit card
				*/
				if($package_name !== '14-day-free-trial') {
					$this->_payment_log($subscription_id, $amount, $auth_id);
				}
				
				/**
				*	If Everything successful, then send send activation mail to user
				*	and show a success message....HAPPY REGISTRATION :-)
				*/
				$this->_send_activation_mail($uuid, $user);
			} else {
				$this->Session->setFlash(__('Sorry, User cant save'));
			}
		} 
                
		$companies = $this->User->Company->find('list');
		$countries = $this->User->Country->find('list');                
		$states = $this->User->State->find('list');	                 
		$this->set(compact('companies', 'countries', 'states', 'card_names', 'my_package', 'package_id', 'isValidPackage', 'package_name'));
	}

	public function resend_auth_mail() {	
		$this->autoRender = false;
		$result = array('status' => 'n');
		if($this->request->is('ajax') && $this->request->is('post') && !empty($this->request->data['User']['id'])) {
			$this->User->id = $this->request->data['User']['id'];
			$user = $this->User->read(); 
			$_randomPassword = $this->_randomPassword();
			$this->User->saveField('password', $_randomPassword);
			$user['User']['password'] = $_randomPassword;
			$uuid = $user['User']['activation_key'];
			$this->_send_activation_mail($uuid, $user, $is_thank = false);
			$result['status'] = 'y';
		}
		echo json_encode($result);
	}
	
	//Following 2 should be in model - Shahruk
	private function _send_activation_mail($uuid, $user, $is_thank = true) {
	
		App::import("Vendor", 'mandrill' . DS . 'Mandrill');
		
		$apiKey = '6a167a94-5c1b-4f1e-9e13-4e5230696e0d';  // AY
		//$apiKey = 'fac8b477-26d0-457d-a566-5b579dd1a7b0'; // BP
		
		$activation_url = '<a href="https://'. env('HTTP_HOST') . '/' . $this->request->controller . '/' .'activation'. '/' . $uuid. '" target="_blank">https://'.env('HTTP_HOST'). '/' . $this->request->controller . '/' .'activation'. '/' . $uuid.'</a>';
		
		$Mandrill = new Mandrill($apiKey);
		$result = $Mandrill->prepareAndSendEmail($activation_url, $user);
		if((@$result['status'] !== 'error' || !@$result['name']) && $is_thank) {
			$this->redirect(array('action' => 'thank'));
		}
		return true;
	}
	
	private function __emailChanged($user, $oldemail, $newemail){
		App::import("Vendor", 'mandrill' . DS . 'Mandrill');
		$apiKey = '6a167a94-5c1b-4f1e-9e13-4e5230696e0d';
		$Mandrill = new Mandrill($apiKey);
		$html = '<h2>Filocity.com - Email Changed!</h2>';
		$html .= '<p>Your email address has now been changed to <b>'.$newemail.'</b>. Please contact the Support team if you believe that this is a mistake.</p>';
		unset($user['User']['password']);
		
		$user['User']['email'] = $oldemail;
		$result = $Mandrill->prepareAndSendEmail(NULL, $user, $html, "Filocity.com - Email Changed!");
		
		$user['User']['email'] = $newemail;
		$result = $Mandrill->prepareAndSendEmail(NULL, $user, $html, "Filocity.com - Email Changed!");
	}
	
	public function activation($uuid) {
		if(!empty($uuid)) {
			$user = $this->User->find('first',
										array(
											'recursive' => -1,
											'conditions' => array('User.activation_key' => $uuid)
										)
									);
			$user_id = $user['User']['id'];
			$user_role = intval($user['User']['role']);

			if(empty($user)) {
				$this->Session->setFlash(__('Invalid Login. Please insert email and password correctly.'));
				$this->redirect($this->Auth->logout());
				return false;
			}
			if(!$user['User']['status']) {
				$this->User->id = $user_id;
				$this->User->saveField('status', 1);
				$this->User->saveField('activation_key', '');
			} 
			$active_user = $this->User->find('first',array('conditions' => array('User.id' => $user_id)));
			$only_user = array_shift($active_user);
			$all_user_data = $active_user;
			$result = am($only_user, $all_user_data);
			if( $this->Auth->login($result) ) {
				/**
				* Check if a guest loggin
				*/
				/*
				if(2 === $user_role) {
					return $this->redirect(array('controller' => 'guests', 'action' => 'entry'));
				}*/
				$log = array(
					'Log' => array(
								'user_id' => $this->User->id
							)
				);
				$this->User->Log->create();
				$this->User->Log->save($log);
				$this->redirect(array('controller' => 'cabinets'));
			} else {
				$this->Session->setFlash(__('Account activation Failed.'));
			}
		} else {
			$this->Session->setFlash(__('Account activation Failed.'));
		}
	}
	
		public function forgot_password() {
		if($this->request->is('post'))
		{
			$user=$this->User->find('first',array('conditions' => array('User.email' => $this->request->data['User']['email'])));
			if($user) {
            $subject = "Password Reset for filocity.com"; 
            $code=md5($user["User"]["first_name"].time());
            $this->User->id=$user['User']['id'];
            $this->User->saveField('password_reset_key', $code);
            
            //begin of HTML message 
            $html = ' <div style="width:100%;height:38%;margin-left:2%;"><div style="float:left;width:30%;"><b>no-reply@filocity.com</b><br>
                <div style="font-size:15px;color:#666">To: '.$user["User"]["email"].'</div>  
                Password Reset for  <a href="https://secure.filocity.com/">filocity.com</a><br><br> </div>
                <div style="float:right;width:100px;color:#666">'.date('F').' '.date('d').',</div><hr style="float:left;width:100%;"></div>
                <div style="float:left;width:100%;height:60%;margin-left:2%;"> 
               <h1 style="font-size:30px;font-weight:bold;background:#d2d1d5;">Forgot Password</h1>
               <b>Dear '.$user["User"]["first_name"].' '.$user["User"]["last_name"].',</b> <br> <br>
               <b>You have requested a new password.</b><br><br>
               <b>Username: '.$user["User"]["email"].'</b><br><br>
               <b>Please follow this link to reset your password:</b><br><br>
               <a href="https://'. env('HTTP_HOST') . '/users/password_reset/'.$code.'" target="_blank">https://'. env('HTTP_HOST') . '/users/password_reset/'.$code.'</a>  <br> 
             <br>
             <b>If you did not send this request you can safely ignore this email.</b><br><br>
             <b>Once you reset your password you can login at the following link.</b><br><br>
            <a href="https://secure.filocity.com/">https://secure.filocity.com/</a><br><br>
            <b>Best Regards,</b><br>
            <b>filocity.com</b><br><hr>
            </div>
             '; 
                $this->_send_reset_mail( $user, $html, $subject); 

				$this->Session->setFlash(__('Please check your registered Email'));
				$this->redirect(array('action' => 'login'));
			} else {
				
				$this->Session->setFlash(__('Invalid Email Id'));
				$this->redirect(array('action' => 'login'));
			}
			
		}
		
	}
	
	
	
	
	
	
	public function password_reset($code){
		
	$user=$this->User->find('first',array('conditions' => array('User.password_reset_key' =>$code)));
	   if($user)
	  {	
		    $new_password=$this->_randomPassword();
		    
		    $this->User->id=$user['User']['id'];
            $this->User->saveField('password', $new_password);
            $subject = "Filocity Account New Password"; 
            //begin of HTML message 
            $html = '
            <div style="width:100%;height:38%;margin-left:2%;"><div style="float:left;width:30%;"><b>no-reply@filocity.com</b><br>
                <div style="font-size:15px;color:#666">To: '.$user["User"]["email"].'</div>  
                Password Reset for  <a href="https://secure.filocity.com/">filocity.com</a><br><br> </div>
                <div style="float:right;width:100px;color:#666">'.date('F').' '.date('d').',</div><hr style="float:left;width:100%;"></div>
                <div style="float:left;width:100%;height:60%;margin-left:2%;"> 
               <h1 style="font-size:30px;font-weight:bold;background:#d2d1d5;">Password Reset</h1>
             <h1 style="font-size:20px;font-weight:bold;">Filocity Account New Password</h1>
                <b>Dear '.$user["User"]["first_name"].' '.$user["User"]["last_name"].',</b> <br> <br>
               <b> Your new password is: '.$new_password.'</b><br>
             <br><b>Now you can login at the following link.</b><br><br>
            <a href="https://secure.filocity.com/">https://secure.filocity.com/</a><br><br>
            <b>Best Regards,</b><br>
            <b>filocity.com</b><br><hr> </div>'; 
                $this->_send_reset_mail( $user, $html, $subject);
				$this->Session->setFlash(__('Please check your registered Email for new password'));
				$this->redirect(array('action' => 'login'));
			} else {
				
				$this->Session->setFlash(__('Invalid Request'));
				$this->redirect(array('action' => 'login'));
			}
	}
	
	public function resources(){
		$args = func_get_args();
		$view=@$args[0];
		$viewed_id=(int)@$args[1];
        $order_by= @$args[2];
		if($viewed_id==0){
            $order_by=$view;
			$view='';
		}
        if($order_by=="")
        {
        $order_by="created";  
        }
		
		$current_company_id=$this->Auth->user('company_id');
		$current_user_id=$this->Auth->user('id');
		
		
		$project_members=array();
		$project_detail=array();
		$member_info=array();
		$max_members=false;
		if($view=='project'){
			$project_members=$this->get_project_members($viewed_id);			
			$project_detail=$this->User->Project->find('first', array('recursive' => -1,'conditions' => array('Project.id' => $viewed_id)));
			$this->User->Company->recursive = 0;
			$company = $this->User->Company->read(NULL, $current_company_id);
			$userCount = $this->User->find("count", array('conditions' => array("User.company_id" => $current_company_id)));	
	
			if($userCount >= $company['Package']['max_member']){
				$max_members=true;
			}
		}else if($view=='member'){
			$member_info=$this->get_member($viewed_id);
		}else{
			$project_members=$this->get_members();
		}
		
		$projects=$this->get_projects();
        $members=$this->get_members();
		

		$this->set(compact('projects','members','project_members','member_info','view','viewed_id','order_by','project_detail','max_members'));
	}
	
	private function get_members(){
		$current_company_id=$this->Auth->user('company_id');
		$current_user_id=$this->Auth->user('id');
		
		
		$company_users_arr=$this->User->find('all',
			array(
				'fields'=>array('User.id','User.first_name','User.last_name','User.position'),
				'recursive' =>-1,
				'conditions'=>array(
					'User.company_id'=>$current_company_id
				)
			)
		);
		return $company_users_arr;
	}
	
	private function get_member($user_id){
		$member_info=$this->User->find('all',
			array(
				'fields'=>array('User.id','User.first_name','User.last_name','User.position'),
				'recursive' =>-1,
				'conditions'=>array(
					'User.id'=>$user_id
				)
			)
		);
		return $member_info;
	}
	
	private function get_project_members($project_id){
		$project_users=$this->User->ProjectsUser->find('all',
			array(
				'fields'=>array('ProjectsUser.user_id'),
				'recursive' => -1,
				'conditions'=>array(
					'ProjectsUser.project_id'=>$project_id
				)
			)
		);
		$users_ids=array();
		for($i=0,$iCount=count($project_users);$i<$iCount;$i++){
			$users_ids[]=$project_users[$i]['ProjectsUser']['user_id'];
		}
		$users=$this->User->find('all',
			array(
			'joins' => array(
                array(
                    'table' => 'projects_users',
                    'prefix' => '',
                    'alias' => 'ProjectsUser',
                    'type' => 'INNER',
                    'conditions' => array(
                        'ProjectsUser.project_id'=>$project_id,
                    )
                ),
            ),  'recursive' => 1,
				'fields'=>array('User.id','User.first_name','User.last_name','User.position','ProjectsUser.*'),
				'conditions'=>array(
					'User.id'=>$users_ids
				),
				'group'=>'User.id'
				
			)
		);
		return $users;
	}
	
	private function get_projects(){
		$current_company_id=$this->Auth->user('company_id');
		$current_user_id=$this->Auth->user('id');
		if($this->Auth->user('role')==1){
			$company_users_arr=$this->get_members();
			
			$company_users=array();
			for($i=0;$i<count($company_users_arr);$i++){
				$company_users[]=$company_users_arr[$i]['User']['id'];
			}
			
			$projects=$this->User->Project->find('all',
				array(
					'recursive' => -1,
					'conditions'=>array(
						'Project.user_id'=>$company_users
					)
				)
			);
		}else{
			$projects_find=$this->User->ProjectsUser->find('all',
				array(
					'fields'=>array('ProjectsUser.project_id'),
					'recursive' => -1,
					'conditions'=>array(
						'ProjectsUser.user_id'=>$current_user_id
					)
				)
			);
			$projects_ids=array();
			for($i=0,$iCount=count($projects_find);$i<$iCount;$i++){
				$projects_ids[]=$projects_find[$i]['ProjectsUser']['project_id'];
			}
			$projects=$this->User->Project->find('all',
				array(
					'recursive' => -1,
					'conditions'=>array(
						'Project.id'=>$projects_ids
					)
				)
			);
		}
		
		return $projects;
	}
	
	public function dashboard() {
		$id = $this->Auth->user('id');
		$admin = false;
		if($this->Auth->user('role') == 1)
			$admin = true;
		$user = $this->User->curuser_detail($id);
		$company_id = $user['Company']['id'];
		$package = $this->User->active_members($company_id);
		$last_loggers = $this->User->last_loggers($company_id);
		$recent_activities = $this->User->recent_activities($id);
		$recent_documents = $this->User->recent_documents($id);
		$activities_by_date = array();
		foreach( $recent_activities as $key => $activity ) {
			$activities_by_date[$activity[0]['date']][$key]['Notice'] = $activity['Notice'];
		}
		$user_projects = $this->User->user_projects($id);
		$project_idx = Set::extract('/Project/id', $user_projects);
		$active_projects = $this->User->active_projects($id);
		$my_active_projects = $this->_format_data_for_active_projects($active_projects);
		$get_users_has_calendar = $this->get_users_has_calendar();
		$all_available_packages = $this->User->getAllPackages();
		$get_company_members = $this->User->get_company_members($company_id);
		
		$my_top_tasks=$this->dashboard_my_top_tasks();
		/**
		* 	Get all email address
		*	of members and contacts
		*/
		$allEmails = $this->User->get_all_emails();
		$this->set(compact(
			'user', 'admin', 'package', 'last_loggers', 'activities_by_date',
			'recent_documents', 'user_projects', 'tasks_types',
			'my_active_projects','task_list', 'get_users_has_calendar',
			'all_available_packages', 'get_company_members',
			'my_top_tasks', 'allEmails'
		));
	}
	
	private function dashboard_my_top_tasks(){
		$current_company_id=$this->Auth->user('company_id');
		$current_user_id=$this->Auth->user('id');
		
		$tasks=$this->User->Task->find('all',
			array(
				'fields'=>array('Task.id', 'Task.title', 'Task.project_id'),
				'recursive' => -1,
				'conditions'=>array(
					'Task.user_id'=>$current_user_id
				),
				'limit' => 5,
				'order' => array('Task.created DESC')
			)
		);
		
		$tasks_ids=array();
		for($i=0,$iCount=count($tasks);$i<$iCount;$i++){
			$tasks_ids[]=$tasks[$i]['Task']['id'];
		}
		
		$comments=$this->User->Comment->find('all',
										array(
											'fields' => array('Comment.task_id','COUNT(Comment.task_id) as comments'),
											'conditions' => array('Comment.task_id' => $tasks_ids),
											'group'=>'Comment.task_id',
											'recursive' => -1
										)
									);

		$comments_count=array();
		for($i=0,$iCount=count($comments);$i<$iCount;$i++){
			$comments_count[$comments[$i]['Comment']['task_id']]=$comments[$i][0]['comments'];
		}
		
		
		return array('tasks'=>$tasks, 'num_comments'=>$comments_count);
	}
	
	
	public function get_users_has_calendar() {
		$escape_user = $this->Auth->user('id');
		$company_id = $this->Auth->user('Company.id');
		$get_users_has_calendar = $this->User->CalendarEvent->get_users_has_calendar($escape_user, false, $company_id);
		return $get_users_has_calendar;
	}
	
	private function _format_data_for_active_projects($active_projects = array()) {	
		$my_active_projects = array();
		if( $active_projects) {
			foreach($active_projects as $index => $project) {
				$active_projects_slider_data = $this->_active_projects_slider_data($project, $index);
				unset($project['User']['id']);
				$members = count($project['User']) | 0;
				$tasks = count($project['Task']) | 0;
				$my_active_projects[$index] = array(
					'id' => $project['Project']['id'],
					'name' => $project['Project']['name'],
					'date_due' => date('m/d/Y', strtotime($project['Project']['date_due'])),
					'end' => date('m/d/Y', strtotime($project['Project']['end'])),
					'start' => date('m/d/Y', strtotime($project['Project']['start'])),
					'budget' => $project['Project']['budget'],
					'manager_id' => $project['Project']['manager_id'],
					'members' => $members,
					'tasks' => $tasks,
					'slider' => $active_projects_slider_data
				);
			}
		}
		return $my_active_projects;
	}
	
	private function _active_projects_slider_data($project = array()) {
		$project_task = array();
		$completed = 0;
		$incomplete = 0;
		$total = 0 ;
		if( count($project['Task']) > 0 ) {
			$tasks = Set::extract('/Task', $project);
			$total = count($tasks);
			foreach($tasks as $task) {
				if ($task['Task']['status'] == 5) {
					$completed++;          
				}
			}
			$incomplete = $total - $completed;
		}
		$project_task = array (
						'total' => $total,
						'completed' => $completed,
						'incompleted' => $incomplete
					);
		return $project_task;
	}
	
	//edit member detail info
	public function edit_member_detail_info(){
		$this->autoRender = false;
		if($this->request->is('post') && !empty($this->request->data)){
			$guid = $this->request->data['User']['id'];
			$data = $this->User->find('all', array(
													'recursive'=>-1,
													'fields'=>array(
															'User.first_name', 'User.last_name',
															'User.department', 'User.position',
															'User.title', 'User.city',
															'User.state_id', 'User.zip', 
															'User.country_id',
															'User.email',
															'User.id',
															),
													'conditions'=>array('User.id'=>$guid)
													)
												);
			echo json_encode($data);
		}
	}
	
	public function upload_photo(){
		$this->autoRender = false;
		$user_id=$this->Auth->user('id');
		if(empty($user_id)){
			echo json_encode(array('error'=>'Please login'));
			return;
		}
		if(!is_uploaded_file($_FILES['file']['tmp_name'])){
			echo json_encode(array('error'=>'Error uploading file'));
			return;
		}

		$path_parts = pathinfo(strtolower($_FILES['file']['name']));
		if(!in_array($path_parts['extension'],array('jpg','jpeg','png','gif'))){
			die(json_encode(array('error'=>'Unsupported image extension')));
		}
		$temp_file_name=rand(1000000000,9999999999).'-'.time().'.'.$path_parts['extension'];
		if(!file_exists(sys_get_temp_dir().DS.'uploads_temp')){
			mkdir(sys_get_temp_dir().DS.'uploads_temp');
		}
		move_uploaded_file($_FILES['file']['tmp_name'], sys_get_temp_dir().DS.'uploads_temp'.DS.$temp_file_name);
		
		echo json_encode(array('filename'=>$temp_file_name, 'path' => sys_get_temp_dir().DS.'uploads_temp'.DS.$temp_file_name));
	}
	
	public function upload_user_profile_and_company_logo() {
		$this->autoRender = false;
		$user_id=$this->Auth->user('id');
		if(!is_uploaded_file($_FILES['file']['tmp_name'])){
			echo json_encode(array('error'=>'Error uploading file'));
			return;
		}
		$path_parts = pathinfo(strtolower($_FILES['file']['name']));
		if(!in_array($path_parts['extension'],array('jpg','jpeg','png','gif'))){
			die(json_encode(array('error'=>'Unsupported image extension')));
		}
		$target_dir = ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.'img'.DS . "filocity_img" .DS .  'user_' . $user_id;
		if(!file_exists($target_dir)) {
			@mkdir($target_dir);
		}
		@unlink($target_dir . DS . 'profile.jpg');
		move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . DS . $_FILES['file']['name']);
		rename($target_dir . DS . $_FILES['file']['name'], $target_dir . DS . 'profile.jpg');
		echo json_encode(array('filename'=>$_FILES['file']['name'], 'path' => $target_dir . DS . 'profile.jpg'));
	}
	
	public function managemembers(){
	
		//Load model, set recursive to only pull Model + package info, and then read the data
		$this->loadModel("Company");
		$this->Company->recursive = 0;
		$company = $this->Company->read(NULL, $this->Auth->user('company_id'));
		
		//Double check to see if they have admin privileges
		if($this->Auth->user('role') == 1){
			$this->User->recursive = 1;
			
			$admins = $this->User->find("all", array("conditions" => array("User.company_id" => $this->Auth->user('company_id'), "User.role" => 1)));
			$users = $this->User->find("all", array("conditions" => array("User.company_id" => $this->Auth->user('company_id'), "User.role" => 0)));
			
			foreach($users as &$a){
				$a['User']['active_tasks'] = $this->User->getActiveTasks($a);
			}
			foreach($admins as &$a){
				$a['User']['active_tasks'] = $this->User->getActiveTasks($a);
			}
			
			$this->set(compact("users", "admins"));
			$this->set("currentadmin", true);
			
		}else{
			throw new NotFoundException(__('That page could not be found.'));
		}
	}
	
	public function addmember(){
		$this->loadModel("Country");
		$this->loadModel("State");
		$this->loadModel("Company");
		$this->Company->recursive = 0;
		$this->layout = "frame";
		$company_id=$this->Auth->user('company_id');
		
		$countries = $this->Country->find("list");
		$states = $this->State->find("list");
		$this->set(compact("countries", "states"));
			
		if ($this->request->is('post')) {
			$this->request->data['User']['company_id']=$company_id;
			$this->request->data['User']['role']=0;
			unset($this->request->data['User']['id']); 
			$this->User->create();
			$uuid = String::uuid();
			$this->request->data['User']['activation_key'] = $uuid;
			$this->request->data['User']['status'] = 0;
			$_randomPassword = $this->_randomPassword();
			$this->request->data['User']['password'] = $_randomPassword;
			$this->request->data['User']['auth_key'] = rand(1010, 101010);
			if ($this->User->save($this->request->data)) {
				/**
				*	Create a Notice when Admin
				*	add A New Memeber
				*/
				$this->loadModel('Notice');
				$notice = array();
				$auth_name = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
				$time = date('g:ia');
				$notice['Notice']['user_id'] = $this->Auth->user('id');
				$notice['Notice']['user2_id'] = $this->User->id;
				$notice['Notice']['notice_type'] = 'new_user_added';
				$display = '';
				if(!empty($this->request->data['User']['first_name'])) {
					$display = $this->request->data['User']['first_name'] . ' ' . $this->request->data['User']['last_name'];
				} else {
					$display = $this->request->data['User']['email'];
				}
				$notice['Notice']['short_message'] = htmlspecialchars('<div class="notice_block"><div class="pill new_user_added">New User</div><div class="the_notice"><span class="time"> | '. $time .'</span>'. $display .' By <strong>'. $auth_name .'</strong></div></div>');
				$this->Notice->create();
				$this->Notice->save($notice, false);
				/**
				*	Create Notice block end
				*/
				if($this->request->data['User']['picture_file']['size'] > 0){
					if(!$profilepic = $this->User->uploadProfilePicture($this->data['User']['picture_file'], $this->User->id)){
						$this->Session->setFlash(__("Please upload a proper image."));
					}else{
						$this->User->saveField("profile_picture", $profilepic);
					}
				}
				$user_id=$this->User->id;
				
				/**
				*	Creating "My Space" and 
				*	"My Share" for Members'
				*	and updating entry of that
				*	member with own my_space_id
				*	and my_share_id in User table
				*/
				
				$this->loadModel("Folder");
				$company_space_and_my_space_idx = $this->User->create_company_and_my_space($user_id, $company_id, true);
				$company_space_id = $this->User->field('company_space_id', array('User.company_id' => $company_id, 'User.role' => 1));
				$update_user = array(
									'id' => $user_id,
									'company_space_id' => $company_space_id,
									'my_space_id' => $company_space_and_my_space_idx['my_space_id'],
									'my_share_id' => $company_space_and_my_space_idx['my_share_id'],
								);
				$this->User->save($update_user, false);
				
				$this->request->data['User']['password'] = $_randomPassword;

				$this->_send_activation_mail($uuid, $this->request->data, false);
				
				$this->Session->setFlash(__("User successfully added!"));
				$this->redirect(array('controller' => 'users', 'action' => 'editmember', $this->User->id));
			} else {
				$this->Session->setFlash(__("Check the form below for errors."), "flash_error");
				debug($this->User->validationErrors);
			}
		}else{
			$company = $this->Company->read(NULL, $company_id);
			$userCount = $this->User->find("count", array("User.company_id" => $company['Company']['id']));
			if($userCount >= $company['Package']['max_member']){
				$this->Session->setFlash(__("Unfortunately you have exceeded your current package. Please upgrade your package to continue adding members."), "flash_error");
				$this->render(false);
			}
		}
	}
	
	public function editmember($userId){
		$this->layout = "frame";
		$this->User->recursive = 0;
		$user = $this->User->read(NULL, $userId);
		if(($user['User']['company_id'] !== $this->Auth->user('company_id')) || $this->Auth->user('role') != 1){
			throw new NotFoundException(__('That page could not be found.'));
		}else{
			$this->loadModel("Country");
			$this->loadModel("State");
			$countries = $this->Country->find("list");
			$states = $this->State->find("list");
			$this->set(compact("countries", "states"));
				
			if($this->request->is('put') || $this->request->is('post')){
				$this->User->set($this->request->data);
				if($this->User->validates()){
					if($this->request->data['User']['picture_file']['size'] > 0){
						if(!$profilepic = $this->User->uploadProfilePicture($this->data['User']['picture_file'], $this->request->data['User']['id'])){
							$this->Session->setFlash(__("Please upload a proper image."));
							return false;
						}else{
							$this->request->data['User']['profile_picture'] = $profilepic;
						}
					}
					if($this->User->save($this->request->data)){
						$userTemp = $this->User->read(NULL, $userId);
						if($this->request->data['User']['email'] !== $user['User']['email'])
							$this->__emailChanged($userTemp, $user['User']['email'], $this->request->data['User']['email']);
						$this->request->data = $userTemp;
						$this->Session->setFlash(__('The user has been saved'));
					}
				}else{
					$this->Session->setFlash(__('Check the form below for errors.'), "flash_error");
				}
			}else{
				$this->request->data = $user;
			}
		}
	}
	
	public function get_user_info($user_id){
		$this->autoRender=false;
		$company_id=$this->Auth->user('company_id');
		$info=$this->User->get_user_info($user_id, $company_id);
		$info[0]['User']['country']=$this->User->Country->get_name($info[0]['User']['country_id']);
		$info[0]['User']['country']=$info[0]['User']['country']['Country']['name'];
		$info[0]['User']['state']=$this->User->State->get_name($info[0]['User']['state_id']);
		$info[0]['User']['state']=$info[0]['User']['state']['State']['name'];
		$info[0]['User']['company_name']=$this->User->Company->get_name($info[0]['User']['company_id']);
		$info[0]['User']['company_name']=$info[0]['User']['company_name']['Company']['name'];
		$info[0]['Share']['folder_id']=$this->get_folder_id($user_id);
		//print_r($info);
		echo json_encode($info);
	}
	
	public function get_user_groups($of_user_id){
		$this->autoRender=false;
		$user_id=$this->Auth->user('id');
		$company_id=$this->Auth->user('company_id');
		$groups=$this->User->UsersGroup->get_user_groups($of_user_id, $user_id);
		echo json_encode($groups);
	}
	
	public function create_user_folder(){
		$this->autoRender=false;
		$user_id=$this->Auth->user('id');
		$company_id=$this->Auth->user('company_id');
		$for_user_id=(int)$this->request->data['user_id'];
		$parent_id=(int)$this->request->data['folder_id'];
		unset($this->request->data['folder_id']);
		
		$user_info=$this->User->get_user_info($for_user_id,$company_id);
		$user_email=$user_info[0]['User']['email'];
		$this->request->data['Folder']['user_id']=$user_id;
		$this->request->data['Folder']['parent_id']=$parent_id;
		$this->request->data['Folder']['name']=$user_email;
		
		if ($this->User->Folder->save($this->request->data)) {
			$folder_id = $this->User->Folder->id;
			$share_data=array();
			$share_data['Share']['folder_id']=$folder_id;
			$share_data['Share']['user_id']=$user_id;
			$share_data['Share']['user2_id']=$for_user_id;
			$share_data['Share']['access']='member';
			if($this->User->Share->save($share_data)){
				echo json_encode('Folder Created');
				Cache::clear();
			}else{
				echo json_encode(array('error'=>'The folder was created but an error has occured when applying permission.'));
			}
		} else {
			echo json_encode(array('error'=>'The folder could not be created. Please try again.'));
		}
	}
	
	public function get_folder_id($user_id){
		$this->autoRender=false;
		$current_user_id=$this->Auth->user('id');
		$row=$this->User->Share->find('first',
			array(
				'fields' => array('Share.folder_id'),
				'conditions' => array(
					'Share.user_id' => $current_user_id,
					'Share.user2_id' => $user_id,
					'Share.group_id' => 0,
					'NOT' => array('Share.folder_id' => 0)
				)
			)
		);
		return empty($row)?0:$row['Share']['folder_id'];
	}
	
	public function get_everything() {
		$this->autoRender = false;
		$result = array('status' => 'n');
		if( $this->request->is('post') && $this->request->is('ajax') ) {
			$auth_id = $this->Auth->user('id');
			$company_id = $this->Auth->user('company_id');
			//$clue = $this->request->data['User']['clue'];
			$resultHtml = $this->User->get_everything($auth_id, $company_id/*, $clue*/);
			$result['status'] = 'y';
			$result['html'] = $resultHtml;
		}		
		echo json_encode($result);
	}
	
	public function is_user_exists() {
		$this->autoRender = false;
		$result['status'] = 'y';
		if($this->request->is('post') && !empty($this->request->data['User']['email'])) {
			$user = $this->User->findByEmail($this->request->data['User']['email']);
			if(!$user) {
				$result['status'] = 'n';
			}
		}
		echo json_encode($result);
	}
	
	/**
	*	Determine that if user has visited the 
	*	File Cabinet page first time
	*/
	public function file_cab_visited($user_id=null) {
		$this->autoRender = false;
		$result['status'] = 'n';
		if(!empty($user_id)) {
			$this->User->id = $user_id;
			$this->User->saveField('cabinet_visited', 1);
			$result['status'] = 'y';
			$this->Session->write('Auth.User.cabinet_visited', 1);
		}
		echo json_encode($result);
	}
	
	/**
	*	Show waring for Guest page
	*	When guest click on Apps / Dashboard
	* 	link in Guest page
	*/
	public function warning() {
		// TODO
	}
	
	/**
	*	Get Active Package Detail
	*/
	private function _active_package() {
		$company_id = $this->Auth->user('company_id');
		/**
		*	Active Package Info of User
		*/
		$this->User->Company->Package->recursive = -1;
		$package_id = $this->User->Company->field('package_id', array('Company.id' => $company_id));
		$package_info = $this->User->Company->Package->getPackages($package_id);
		return $package_info;
	}
	
	/**
	*	Procedure for Update package
	*/
	public function upgrade_package() {
		$this->autoRender = false;
		$result = array();
		
		if($this->request->is('post') && $this->request->is('ajax') && !empty($this->request->data['Company']['package_id'])) {		
			/**
			*	Keep a copy of prev package
			*	before upgrade the package
			*/
			$this->previous_package = $this->_active_package();
			
			/**
			*	Prevent User If user from
			*	choosing a low package
			*/
			$current_package_id = (int)$this->previous_package['Package']['id'];
			$requested_package_id = (int)$this->request->data['Company']['package_id'];
			if($requested_package_id <= $current_package_id) {
				$result['status'] = 'n';
				$result['message'] = 'Sorry, You could not choose a low package or same package currently using.';
				echo json_encode($result);
				exit();
			}
			
			/**
			*	Package Upgrade Block
			*/
			$this->User->Company->id = $this->Auth->user('company_id');
			if( $this->User->Company->saveField('package_id', $this->request->data['Company']['package_id'])) {
				$this->Session->write('Auth.Company.package_id', $this->request->data['Company']['package_id']);
				/**
				*	Get Payment For new Package
				*/
				$result = $this->_make_payment(true);
			}
		}
		echo json_encode($result);
	}
	
	/**
	*	Get the difference 
	*	between Today and Next [Upcoming] payment
	*	date of user
	*/
	private function _get_days_delta($next_payment_date=null) {
		$delta = -1;
		if($next_payment_date) {
			$today = date('Y-m-d');
			$date1 = new DateTime($today);
			$date2 = new DateTime($next_payment_date);
			$interval_obj = $date1->diff($date2);
			$delta = $interval_obj->days;
			return $delta;
		}
	}
	
	/**
	*	Calculate the amount
	*	to pay by user via pricing modal
	*
	*	@return Array 
	*/
	private function _calculate_payment_amount($is_package_upgrade=false) {
		/**
		*	status = 0: Invalid calculation, 
		*	status = 1: successfull calculation
		*	status = 2: Already paid today
		*/ 
		
		$return['status'] = 0;	
		$return['amount'] = 0;
		$return['user_credit'] = 0;
		
		$auth_id = $this->Auth->user('id');
		
		/**
		*	Retrieve Last Payment Log
		*/
		$last_payment_log = $this->User->PaymentLog->getLastPaymentLogByUserId($auth_id);	// Getting Last payment record
		$last_payment_date = $last_payment_log['PaymentLog']['last_payment_date'];
		$next_payment_date = $last_payment_log['PaymentLog']['next_payment_date'];
		$user_credit = 0;
		
		/**
		*	Prevent User to pay multiple time in same day
		*	but if you request for a package upgrade then allow
		*/

		if( $this->_get_days_delta($last_payment_date) == 0 && !$is_package_upgrade) {
			$return['status'] = 2;
			return $return;
			exit();
		}
		
		/**
		*	Checking that user has any credit or not 
		*/
		if($last_payment_log['PaymentLog']['user_credit'] > 0) {
			$user_credit = $last_payment_log['PaymentLog']['user_credit'];
		}
		
		/**
		*	Retrieve Package Detail
		*	Currently Active for User
		*/
		$current_package_info = $this->_active_package();
	
		$delta = $this->_get_days_delta($next_payment_date);	// Getting the days difference
		
		/**
		*	$delta : represents the days interval from upcoming closest billing cycle
		*
		*	$delta = -1 : invalid difference, so no transaction
		*	$delta = 0  : today is the last date of billing cycle
		*	$delta > 0  : interval between today and next payment date of billing cycle
		*/
		if($delta >= 0) {
			$current_package_price = (float) $current_package_info['Package']['price'];
			$charge_per_day = 0;
			
			/**
			*	Calculation for per day charge will
			*	different in case of Package Upgrade Scenario
			*	In case of upgrade, per day charge will calculate based on previous package rate
			*/
			
			if(!empty($this->previous_package)) {
				$old_package_price = (float)$this->previous_package['Package']['price'];
				$charge_per_day = number_format(($old_package_price * 12) / 360, 2); 	// everyday charge for Old package rate
			} else {
				$charge_per_day = number_format(($current_package_price * 12) / 360, 2); 	// everyday charge for current package rate
			}
			
			$amount_credited_to_user = number_format($charge_per_day * $delta, 2); 		//Amount that Credit for user based on $delta
			
			/**
			*	This is the scenario if user have more credit 
			*	than the package he choosed, and only will happen
			*	in case of package downgrade
			*
			*	So, in this case we will keep record of amount that
			*	credit to user and will reduce from next payment amount
			*/
			$amount_to_pay = 0;
			if($current_package_price < $amount_credited_to_user) {
				$return['user_credit'] = abs( number_format($amount_credited_to_user - $current_package_price, 2) );	// credited amount to user
			} else {
				$amount_to_pay = abs( number_format($current_package_price - $amount_credited_to_user + $user_credit, 2) );	// reduce credited amount 
			}
			
			$this->previous_package = array();
			$user_credit = 0;
			
			$return['status'] = 1;
			$return['amount'] = $amount_to_pay;
			$return['next_payment_amount'] = $current_package_price;
		}
		return $return;
	}
	
	/**
	*	Pricing Modal to display
	*	in Dashboard page
	*/
	public function pricing_info() {
		$auth_id = $this->Auth->user('id');
		$payment = $this->User->PaymentLog->getLastPaymentLogByUserId($auth_id);
		$this->User->recursive = -1;
		$user = $this->User->findById($auth_id);
		$this->set(compact('payment', 'user'));
		$this->render('pricing_modal');
	}
	
	/**
	*	Do Payment on user request
	*	will call when user click on OK 
	*	button of payment confirm modal
	*/
	public function do_payment() {
		$this->autoRender = false;
		$result = array();
		
		if($this->request->is('post') && $this->request->is('ajax') && $this->request->data['User']['payment'] == 'do' && $this->Auth->loggedIn()) {
			$result = $this->_make_payment();
		}
		return json_encode($result);
	}
	
	/**
	*	Fires when user make payment
	*	via Payment Modal on Dashboard page
	*	which generated from `pricing_modal()` method
	*/
	private function _make_payment($is_package_upgrade=false) {
		$result['status'] = 'n';
		$result['message'] = 'Sorry, Payment Failed.';
		
		$auth_id = $this->Auth->user('id');
		$subscription_id = 123;	// this will update after Authorize payment
		
		/**
		*	Retrieve Logged User info
		*	for Authorize Billing
		*/ 
		$this->User->recursive = -1;
		$user_info = $this->User->findById($auth_id);
		
		/**
		*	Calculation payment amount
		*	for user payment
		*/
		$payment = $this->_calculate_payment_amount($is_package_upgrade);

		if($payment['status'] && $payment['amount'] > 0) {
			/**
			*	Auth.net Payment Block
			*/ 
			
			
			
			/**
			*	Make a record in Payment Log Table
			*	Two arguments: $subscription_id and $amount respectively
			*/
			$this->_payment_log($subscription_id, $payment['next_payment_amount'], $auth_id, $payment['user_credit']);
			$result['status'] = 'y';
			if($is_package_upgrade) {
				$result['message'] = 'Thanks. Package Upgrade done.';
			} else {
				$result['message'] = 'Payment successful';
			}
		} elseif($payment['status'] && $payment['user_credit'] > 0) {
			$result['status'] = 'y';
			$result['message'] = '';
		} else if($payment['status'] == 2) {
			$result['message'] = 'Sorry, You already Paid today.';
		}
		return $result;
	}
	
	/**
	*	Update Payment Info method
	*	done from Dashboard page using
	*	payment modal from `pricing_modal()` method
	*/
	public function update_payment_info() {
		
	}
	
	/**
	*	Make a Log to PaymentLog 
	*	on each payment done
	*	
	*	params:	
	*	@subscription_id => Subscription ID that returned from Authorize.net
	*	@amount => Amount that paid
	*/
	public function _payment_log($subscription_id=null, $amount=null, $auth_id=null, $user_credit=0.00) {
		if($subscription_id && $auth_id) {
			$payment_log = array();
			$payment_log['PaymentLog'] = array(
								'user_id' => $auth_id,
								'subscriptionId' => $subscription_id,
								'last_payment_date' => date('Y-m-d'),
								'last_payment_amount' => $amount,
								'next_payment_date' => date('Y-m-d', strtotime('+1 months')),
								'next_payment_amount' => $amount,
								'user_credit' => $user_credit
							);
			$this->User->PaymentLog->create();
			$this->User->PaymentLog->save($payment_log, false);
			return 1;
		} else {
			return 0;
		}
	}
	
	/**
	*	Ajax varification to 
	*	pop-up registratoin form
	*/
	
	public function validation($step=null) {
		$this->autoRender = false;
		if($this->request->is('post') && !empty($this->request->data) && $step && $this->request->is('ajax')) {
			if((int)$step == 1) {
				$validator = $this->User->validator();
				unset($validator['is_agreed'], $validator['role'], $validator['mail_address_1'], $validator['zip'], $validator['city'], $validator['country_id'], $validator['state_id'], $validator['card_name'], $validator['card_number'], $validator['card_expiration_date'], $validator['security_code']);
			}
			$this->User->set($this->request->data);
			echo json_encode( array('isvalid' => $this->User->validates(), 'errors' => $this->User->validationErrors) );
		}
	}
}
