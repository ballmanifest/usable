<?php
App::uses('AppModel', 'Model');

class Contact extends AppModel {

	public $displayField = 'id';

	public $validate = array(
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
		'user_id2' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
		
	);

	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public $hasMany = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ContactsGroup' => array(
			'className' => 'ContactsGroup',
			'foreignKey' => 'contact_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Country' => array(
			'className' => 'Country',
			'foreignKey' => 'country_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'state_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Folder' => array(
			'className' => 'Folder',
			'foreignKey' => 'folder_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Share' => array(
			'className' => 'Share',
			'foreignKey' => 'contact_id',
			'conditions' => '',
			'dependent' => true,
			'fields' => '',
			'order' => ''
		)
	);
	
	public function get_contact_info($user_id, $contact_id){
		$contact = $this->find('all',
										array(
											'fields' => array(
												'Contact.*'
											),
											'recursive' => -1,
											'conditions' => array('Contact.id'=>$contact_id)
										)
									);
		return $contact;
	}
	
	public function get_all_contacts($user_id, $company_id, $sort=null,$conditions=array()){
		$contacts = $this->find('all',
										array(
											'fields' => array(
												'Contact.id',
												'Contact.first_name',
												'Contact.last_name',
												'Contact.email',
											),
											'recursive' => -1,
											'conditions' => array_merge(array(
												'OR' => array(
													'Contact.user_id' => $user_id,
													'AND' => array(
														'Contact.company_id' => $company_id,
														'Contact.contact_type' => 1
													)
												)
											),$conditions),
											'order' => $sort
										)
									);
		return $contacts;
	}
	
	public function get_private_contacts($user_id,$company_id,$sort=null,$conditions=array()){
		$contacts = $this->find('all',
										array(
											'fields' => array(
												'Contact.id',
												'Contact.first_name',
												'Contact.last_name',
												'Contact.email',
											),
											'recursive' => -1,
											'conditions' => array_merge(array(
												'Contact.user_id' => $user_id,
												'Contact.company_id' => $company_id,
												'Contact.contact_type' => 0
											),$conditions),
											'order' => $sort
										)
									);
		return $contacts;
	}
	
	public function get_shared_contacts($user_id,$company_id,$sort=null,$conditions=array()){
		$contacts = $this->find('all',
										array(
											'fields' => array(
												'Contact.id',
												'Contact.first_name',
												'Contact.last_name',
												'Contact.email',
											),
											'recursive' => -1,
											'conditions' => array_merge(array(
												'Contact.company_id' => $company_id,
												'Contact.contact_type' => 1
											),$conditions),
											'order' => $sort
										)
									);
		return $contacts;
	}
	
	public function get_account_users_contacts($user_id){
		$contacts = $this->find('all',
										array(
											'fields' => array(
												'Contact.id',
												'Contact.first_name',
												'Contact.last_name',
												'Contact.email',
											),
											'recursive' => -1,
											'conditions' => array(
												'NOT'=>array('Contact.user_id2'=>0)
											)
										)
									);
		return $contacts;
	}
	
	public function get_all_contacts_and_members($user_id, $company_id, $sort=null,$conditions=array()) {
		$all_members_and_contacts = array();
		$all_members_and_contacts[] = $this->get_all_contacts($user_id, $company_id, $sort, $conditions);
		$all_members_and_contacts[] = $this->User->get_account_users($company_id);
		return $all_members_and_contacts;
	}
	
}
