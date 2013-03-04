<?php
App::uses('AppModel', 'Model');

class Package extends AppModel {
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
		'storage' => array(
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

	public $hasMany = array(
		'Company' => array(
			'className' => 'Company',
			'foreignKey' => 'package_id',
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
	
	/**
	*	Retrieve Package Info
	*	params:
	*	$package_id [optional] : if supplied, only that package info will retrieve, else all packages will retrieve
	*/
	public function getPackages($package_id = null) {
		$packages = array();
		$settings = array (
			'order'=> array('Package.storage' => 'ASC'),
			'recursive' => -1
		);
		if( $package_id ) {
			$settings['conditions'] =  array('Package.id' => $package_id);
			$packages = $this->find('first', $settings);
		} else {
			$packages = $this->find('all', $settings);
		}
		return $packages;
	}

}
