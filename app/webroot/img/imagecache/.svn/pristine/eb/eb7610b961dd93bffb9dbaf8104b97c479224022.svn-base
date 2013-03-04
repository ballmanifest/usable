<?php
App::uses('AppModel', 'Model');

class ContactsGroupsUser extends AppModel {

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
		'ContactsGroup' => array(
			'className' => 'ContactsGroup',
			'foreignKey' => 'contact_group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
