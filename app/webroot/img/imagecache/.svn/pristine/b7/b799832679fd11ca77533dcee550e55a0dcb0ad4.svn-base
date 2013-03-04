<?php
App::uses('AppModel', 'Model');

class ContactsGroup extends AppModel {

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
		)
	);

	public $belongsTo = array(
		'Contact' => array(
			'className' => 'Contact',
			'foreignKey' => 'contact_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function is_unique($group_id, $contact_id){
		$contact_group = $this->find('all',
										array(
											'fields' => array(
												'ContactsGroup.id'
											),
											'recursive' => -1,
											'conditions' => array(
												'ContactsGroup.group_id'=>$group_id,
												'ContactsGroup.contact_id'=>$contact_id
											)
										)
									);
		return count($contact_group)<1;
	}
	
	public function get_group_contacts($group_id, $sort=null, $conditions=array()){
		$contacts_group = $this->find('all',
										array(
											'fields' => array(
												'Contact.id',
												'Contact.first_name',
												'Contact.last_name',
												'Contact.email',
											),
											'recursive' => 1,
											'conditions' => array_merge(array(
												'ContactsGroup.group_id'=>$group_id
											),$conditions),
											'order'=>$sort
										)
									);
		return $contacts_group;
	}
	public function get_contact_groups($contact_id, $user_id){
		$contacts_group = $this->find('all',
										array(
											'fields' => array(
												'Group.*'
											),
											'recursive' => 1,
											'conditions' => array(
												'Group.user_id'=>$user_id,
												'ContactsGroup.contact_id'=>$contact_id
											)
										)
									);
		return $contacts_group;
	}
	
}