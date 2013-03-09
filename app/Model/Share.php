<?php
App::uses('AppModel', 'Model');

class Share extends AppModel {

	public $displayField = 'id';

	public $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user2_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public $belongsTo = array(
		'Project' => array(
			'className' => 'Project',
			'foreignKey' => 'project_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Task' => array(
			'className' => 'Task',
			'foreignKey' => 'task_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Document' => array(
			'className' => 'Document',
			'foreignKey' => 'document_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Folder' => array(
			'className' => 'Folder',
			'foreignKey' => 'folder_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Document' => array(
			'className' => 'Document',
			'foreignKey' => 'document_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Company' => array(
			'className' => 'Company',
			'foreignKey' => 'company_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Guest' => array(
			'className' => 'Guest',
			'foreignKey' => 'guest_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'CalendarEvent' => array(
			'className' => 'CalendarEvent',
			'foreignKey' => 'calendar_event_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Contact' => array(
			'className' => 'Contact',
			'foreignKey' => 'contact_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	public function user_access($auth_id = null) {
		$userRights = array();
		$this->Behaviors->attach('Containable');
		$userRights = $this->find('all',
								array(
									'fields' => array('Share.id', 'Share.user_id', 'Share.user2_id'),
									'conditions' => array('Share.user2_id' => $auth_id), 
									'order' => array('Share.id' => 'asc'),
									'contain' => array(
										'Project' => array(
											'fields' => array('Project.id')
										),
										'Task' => array(
											'fields' => array('Task.id')
										),
										'Document' => array(
											'fields' => array('Document.id')
										)
										
									)
								)
							);
		return $userRights;
	}
	
	public function any_one_with_project_link($project_id = null) {
		$project_members = array();
		$project_members = $this->Project->ProjectsUser->find('all',
																array(
																	'fields'  => array('DISTINCT(ProjectsUser.user_id)'),
																	'ProjectsUser.project_id' => $project_id
																)
															);
		$user_idx = Set::extract('/ProjectsUser/user_id', $project_members);
		$this->User->Behaviors->attach('Containable');			
		$members_list = $this->User->find('all', 
											array(
												'fields' => array('User.id', 'User.first_name', 'User.last_name','User.department', 'User.company_id'),
												'conditions' => array('User.id' => $user_idx),
												'contain' => array(
													'Task' => array(
														'fields' => array('Task.id')
													),
													'Folder' => array(
														'fields' => array('Folder.id')
													),
													'Document' => array(
														'fields' => array('Document.id')
													)
												)
											)
										);
		return $members_list;
	}
	
	public function delete_cur_rows($project_id=null) {
		$status = false;
		if($project_id) {
			$status = $this->deleteAll(array('Share.project_id' => $project_id), false);
		}
		return $status;
	}
	
	public function is_shared($conditions = array()) {
		$result = $this->find('first',
							array(
								'conditions' => $conditions, 
								'recursive' => -1
							)
						);
		return $result;
	}
	
	/**
	*	All Shared Folders
	*	$params $conditions is like Cake conditions array
	*	$return Array / null
	*/
	public function get_all_shared_folder($conditions = array()) {
		$this->Behaviors->attach('Containable');
		return $this->find('all',
							array(
								'conditions' => $conditions,
								'contain' => array(
													'User' => array(
																'fields' => array('User.id', 'User.first_name', 'User.last_name')
															)
												)
							)
						);
	}
	
	/**
	*	All Shared Documents
	*	$params $conditions is like Cake conditions array
	*	$return Array / null
	*/
	public function get_all_shared_document($conditions = array()) {
		$this->Behaviors->attach('Containable');
		return $this->find('all',
							array(
								'recursive' => -1,
								'conditions' => $conditions
							)
						);
	}
	
	/**
	*	Create Random Password
	*	For Guest Users
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
	
	/**
	*	Set Registration to Guest
	*/
	private function _send_guest_registration_email($uuid, $user, $email_of_user_who_shared, $item_name, $quick_note="") {
	
		$htmt= '';
		
		App::import("Vendor", 'mandrill' . DS . 'Mandrill');
		//$apiKey = '6a167a94-5c1b-4f1e-9e13-4e5230696e0d';  // AY
		$apiKey = 'fac8b477-26d0-457d-a566-5b579dd1a7b0'; // BP		
		
		$subject = 'Filocity.com - New file shared with you';
	
		$activation_url = '<a href="https://'. env('HTTP_HOST') . '/users/activation/' . $uuid. '" target="_blank">https://'.env('HTTP_HOST'). '/users/activation/' . $uuid.'</a>';
		$permalink = '<a href="https://'. env('HTTP_HOST') . '/users/activation/' . $uuid. '" target="_blank">here</a>';
		
		$html = '<h2>Filocity.com - Confirm your email</h2>';
		$html = '<h2>'. $item_name .' has been shared by '. $email_of_user_who_shared .'.</h2>';
		$html .= '<p>To access the share, please click '. $permalink .'</p>';
		$html .= '<p>If you can not see the link, please copy/paste following URL in your browser\'s address and press enter.</p>';
		$html .= '<p>' . $activation_url . '</p>';
		$html .= '<p>To log in at any time from any browser you may user your email address and the following password: <span style="color:#a9a9a9">'. $user['User']['password'] .'</span></p>';
		$password_change_link = $password_permalink = '<a style="text-decoration:underline;color:#000" href="https://'. env('HTTP_HOST') . '/users/change_password" target="_blank">HERE</a>';
		$html .= '<p>To reset your password click here '. $password_change_link . '</p>';
		
		$Mandrill = new Mandrill($apiKey);
		$result = $Mandrill->prepareAndSendEmail($activation_url, $user, $html, $subject);
		return true;
	}
	/**
	*	Checking for an Email already in syste
	*	ie. In users table or not
	*/
	private function _is_guest_exists($guest_email) {
		$this->User->recursive = -1;
		$isExists = $this->User->findByEmail($guest_email);
		return $isExists;
	}
	
	/**
	*	Send email to User
	*	with information about the shared file
	*	eg. X shares file / folder with you
	*/
	private function _send_mail_about_share_info($uuid, $user, $email_of_user_who_shared, $item_name, $quick_note="") {
		$htmt= '';
		
		App::import("Vendor", 'mandrill' . DS . 'Mandrill');
		//$apiKey = '6a167a94-5c1b-4f1e-9e13-4e5230696e0d';  // AY
		$apiKey = 'fac8b477-26d0-457d-a566-5b579dd1a7b0'; // BP		
		
		$subject = 'Filocity.com - New file shared with you';
		
		$activation_url = '<a href="https://'. env('HTTP_HOST') . '/guests/entry/' . $uuid. '" target="_blank">https://'.env('HTTP_HOST'). '/guests/entry/' . $uuid.'</a>';
		$permalink = '<a href="https://'. env('HTTP_HOST') . '/guests/entry/' . $uuid. '" target="_blank">here</a>';
		
		$html = '<h2>'. $item_name .' has been shared by '. $email_of_user_who_shared .'.</h2>';
		if($quick_note) $html .= '<p>' . $quick_note . '</p>';
		$html .= '<p><strong>'. $item_name .'</strong> has been shared with you by '. $email_of_user_who_shared .'.</p>';
		//$html .= '<p>In order to access the share, please click '. $permalink .'</p>';
		//$html .= '<p>If you can not see the link, please copy/paste following URL in your browser\'s address and press enter.</p>';
		//$html .= '<p>' . $activation_url . '</p>';
		unset($user['User']['password']);
		$Mandrill = new Mandrill($apiKey);
		$result = $Mandrill->prepareAndSendEmail($activation_url, $user, $html, $subject);
		return true;
	}
	
	
	/**
	*	Save All Shares
	*/
	public function save_shares($data=array(), $calendar_event_id=null) {
		$users = array();
		$item_name = '';
		$quick_note = array_shift($data);
		$result = 0;
			
		foreach($data as $k => $d) {
			/**
			*	Keep record of event
			*	to which the file has been shared
			*/
			if($calendar_event_id) {
				$data[$k]['Share']['calendar_event_id'] = $calendar_event_id;
			}

			if( array_key_exists('guest_id', $d['Share']) ) {
				$guest_email = $d['Share']['guest_email'];
				$item_name = $d['Share']['item_name'];
				/*
				*	if yes, then no registration email, only share message to send
				*	if no, then send registration email with share message
				*/
				$isExists = $this->_is_guest_exists($guest_email);
				$user_id = $isExists['User']['id'];
				
				if(!empty($isExists['User'])) {
					$user = array(
								'User' => array(
									'email' => $guest_email,
									'uuid' => null
								)
					);
					$data[$k]['Share']['user2_id'] = $user_id;
					
					/** 
					*	send share notification mail
					*	to already exists guest
					*/ 
					$this->_send_mail_about_share_info($user['User']['uuid'], $user, CakeSession::read('Auth.User.email'), $item_name, $quick_note);
					
				} else {

					$uuid = String::uuid();						
					
					/**
					*	save guest to user table [as new process for guest account]
					*	and send activation email
					*/
					$_randPass = $this->_randomPassword();
					
					/**
					*	Create a guest company
					*/
					$company = array('Company' => array('name' => 'Guest Company'));
					$this->User->Company->create();
					$this->User->Company->save($company, false);
					
					$guest_as_user = array('User' => array('activation_key' => $uuid, 'email' => $guest_email, 'password' => $_randPass, 'role' => 2, 'company_id' => $this->User->Company->id, 'cabinet_visited' => 0)); // role : 2 for guest
					
					/**
					*	Create Guest User
					*/
					$this->User->create();
					if($this->User->save($guest_as_user, false)) {
						$new_guest_id = $this->User->id;
						
						/**
						*	Create "My Share" space for
						*	guest user
						*/
						$folder = array(
								'Folder' => array(
											'parent_id' => 0,
											'name' => 'Shared With Me',
											'user_id' => $new_guest_id,
											'status' => 1,
											'folder_type' => 'share'
										)
							);
						$this->Folder->create();
						$this->Folder->save($folder, false);
						
						/**
						*	Update Guest user `my_share_id`
						*	in `users` table
						*/
						$this->User->id    = $new_guest_id;
						$this->User->saveField('my_share_id', $this->Folder->id);
						
						/**
						*	Save guest record 
						*	for future use [if needed]
						*/
						
						$guest_data = array('Guest' => array('uuid' => $uuid, 'email' => $guest_email));
						$data[$k]['Share']['user2_id'] = $new_guest_id;
						
						$this->Guest->create();
						if( $this->Guest->save($guest_data) ) {
							$user = array(
											'User' => array(
												'email' => $guest_email,
												'uuid' => $uuid,
												'password' => $_randPass
											)
										);								
						}
						
						/**
						*	Add an Guest to User's Contact
						*/
						$contact = array();
						$contact['Contact'] = array(
							'email' => $guest_email,
							'company_id' => $this->User->Company->id,
							'company_name' => 'Guest Company',
							'user_id' => CakeSession::read('Auth.User.id'),
							'user_id2' => $new_guest_id,
							'folder_id' => $this->Folder->id,
							'contact_type' => 1
						);
						App::import('Model', 'Contact');
						$Contact = new Contact();
						$Contact->save($contact, false);
						
						/**
						*	send mail to guest 
						*	for activate account
						*/
						$this->_send_guest_registration_email($user['User']['uuid'], $user, CakeSession::read('Auth.User.email'), $item_name, $quick_note);
						
						/** 
						*	send share notification mail
						*	to new guest
						*/ 
						$this->_send_mail_about_share_info($user['User']['uuid'], $user, CakeSession::read('Auth.User.email'), $item_name, $quick_note);
					}
				}
			}
			$data[$k]['Share']['user_id'] = CakeSession::read('Auth.User.id');
		}
		
		$arr = $data;
		if( $this->saveMany($arr) ) {
			$result = 1;
		}
		return $result;
	}
	
	/**
	*	using afterSave Callback to 
	*	create notice on any share
	*/
	
	public function afterSave($created) {
		if($created) {
			$Notice = ClassRegistry::init('Notice');
			$User = ClassRegistry::init('User');
			$data = $this->data['Share'];
			$item_name = '';

			// Load Document name if document share
			if(isset($data['document_id']) && (int)$data['document_id'] != 0) {
				$Document = ClassRegistry::init('Document');
				$item_name = $Document->field('name', array('Document.id' => $data['document_id']));
			} 
			// Load Folder name if Folder share
			if(isset($data['folder_id']) && (int)$data['folder_id'] != 0 ) {
				$Folder = ClassRegistry::init('Folder');
				$item_name = $Folder->field('name', array('Folder.id' => $data['folder_id']));
			} 
			if(isset($data['user2_id']) && (int)$data['user2_id'] != 0) {
				$user2 = $User->findById($data['user2_id']);
				$display = '';
				if($user2['User']['first_name']) {
					$display = $user2['User']['first_name'] . ' ' . $user2['User']['last_name'];
				} else {
					$display = $user2['User']['email'];
				}
				
				/**
				*	Create notice for who
				*	added shares
				*/
				$time = date('g:ia');
				$notice_add_share['Notice']['user_id'] = CakeSession::read('Auth.User.id');
				$notice_add_share['Notice']['user2_id'] = $user2['User']['id'];
				$notice_add_share['Notice']['notice_type'] = 'share';
				$notice_add_share['Notice']['short_message'] = htmlspecialchars('<div class="notice_block"><div class="pill share">Share</div><div class="the_notice"><span class="time"> | '. $time .'</span><strong>'. $item_name .'</strong> With <strong>'. $display .'</strong></div></div>');
				$Notice->create();
				$share_notice = $Notice->save($notice_add_share, false);
				
				/**
				*	"New Subscriber" notice save
				*	for add user to share if notification = 1	
				*/
				if(isset($data['notification']) && $data['notification'] == 1) {
					$notice_subs['Notice']['user_id'] = CakeSession::read('Auth.User.id');
					$notice_subs['Notice']['user2_id'] = $user2['User']['id'];
					$new_subscriber = $this->User->findById($user2['User']['id']);
					$notice_subs['Notice']['notice_type'] = 'new_subscriber';
					$display = '';
					if($new_subscriber['User']['first_name']) {
						$display = $new_subscriber['User']['first_name'] . ' ' . $new_subscriber['User']['last_name'];
					} else {
						$display = $new_subscriber['User']['email'];
					}
					$notice_subs['Notice']['short_message'] = htmlspecialchars('<div class="notice_block"><div class="pill new_subscriber">New Subscriber</div><div class="the_notice"><span class="time"> | '. $time .'</span> Added <strong>'. $display .'</strong></div></div>');
					$Notice->create();
					$Notice->save($notice_subs, false);
				}
				
				/**
				*	Another Notice for the
				*	user to whom file / folder
				*	has been shared
				*/
				$notice_to['Notice']['user_id'] = $user2['User']['id'];
				$notice_to['Notice']['user2_id'] = CakeSession::read('Auth.User.id');
				$notice_to['Notice']['notice_type'] = 'shared_with_me';
				$shared_by = CakeSession::read('Auth.User.first_name') . ' ' . CakeSession::read('Auth.User.last_name');
				$notice_to['Notice']['short_message'] = htmlspecialchars('<div class="notice_block"><div class="pill shared_with_me">Shared</div><div class="the_notice"><span class="time"> | '. $time .'</span> <strong>'. $item_name .'</strong> With you by <strong>'. $shared_by .'</strong></div></div>');
				$Notice->create();
				$Notice->save($notice_to, false);
				
			}
		}
	}
	
	public function afterFind($results, $primary = false) {
		$shared_with_me = Set::extract('/Share[user2_id='. CakeSession::read('Auth.User.id') .']', $results);
		$role = (int)CakeSession::read('Auth.User.role');

		if(!empty($shared_with_me) && $role == 2 && !$shared_with_me[0]['Share']['is_view']) {
			$this->id = $shared_with_me[0]['Share']['id'];
			$this->saveField('is_view', 1);
			
			/**
			*	Generate Notice that shared
			*	has accessed by user
			*/
			$Notice = ClassRegistry::init('Notice');
			$time = date('g:ia');
			$notice['Notice']['user_id'] = $shared_with_me[0]['Share']['user_id'];
			$notice['Notice']['user2_id'] = $shared_with_me[0]['Share']['user2_id'];
			$user_who_accessed = $this->User->findById($shared_with_me[0]['Share']['user2_id']);
			$notice['Notice']['notice_type'] = 'share_accessed';
			$display = '';
			if($user_who_accessed['User']['first_name']) {
				$display = $user_who_accessed['User']['first_name'] . ' ' . $user_who_accessed['User']['last_name'];
			} else {
				$display = $user_who_accessed['User']['email'];
			}
			$notice['Notice']['short_message'] = htmlspecialchars('<div class="notice_block"><div class="pill share_accessed">Share Accessed</div><div class="the_notice"><span class="time"> | '. $time .'</span> By <strong>'. $display .'</strong></div></div>');
			$Notice->create();
			$Notice->save($notice, false);
		}
		return $results;
	}

}
