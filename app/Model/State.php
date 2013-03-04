<?php
App::uses('AppModel', 'Model');

class State extends AppModel {

	public $displayField = 'name';

	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public $hasMany = array(
		'Contact' => array(
			'className' => 'Contact',
			'foreignKey' => 'state_id',
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
			'foreignKey' => 'state_id',
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
	
	public function get_name($state_id){
		$info = $this->find('first',
										array(
											'fields' => array('State.name'),
											'recursive' => -1,
											'conditions' => array('State.id'=>$state_id)
										)
									);
		return $info;
	}
	
	public function get_id($state_name){
		$info = $this->find('first',
							array(
								'fields' => array('State.id'),
								'recursive' => -1,
								'conditions' => array('State.name' => $state_name)
							)
						);
		return $info['State']['id'];
	}

}
