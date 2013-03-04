<?php
App::uses('AppModel', 'Model');

class Country extends AppModel {

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
			'foreignKey' => 'country_id',
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
			'foreignKey' => 'country_id',
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
	
	public function get_name($country_id){
		$info = $this->find('first',
							array(
								'fields' => array('Country.name'),
								'recursive' => -1,
								'conditions' => array('Country.id' => $country_id)
							)
						);
		return $info;
	}
	
	public function get_id($country_name){
		$info = $this->find('first',
							array(
								'fields' => array('Country.id'),
								'recursive' => -1,
								'conditions' => array('Country.name' => $country_name)
							)
						);
		return $info['Country']['id'];
	}
	
	

}
