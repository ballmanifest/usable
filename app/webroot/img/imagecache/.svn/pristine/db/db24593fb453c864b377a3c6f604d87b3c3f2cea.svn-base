<?php
App::uses('AppModel', 'Model');

class Guest extends AppModel {

	public $displayField = 'email';

	public $validate = array(
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public $hasMany = array(
		'Share' => array(
			'className' => 'Share',
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
		)
	);

	public function get_all_shared_folder_with_guest($folder_idx) {
		return $this->Share->Folder->listAllGuestFolder($folder_idx);
	}
	public function get_all_shared_document_with_guest($document_idx) {
		return $this->Share->Document->listAllGuestDocument($document_idx);
	}
}
