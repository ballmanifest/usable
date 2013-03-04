<?php
App::uses('AppModel', 'Model');

class Document extends AppModel {
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
		'user_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'folder_id' => array(
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
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
		)
	);
	
	public $hasMany = array (
		'Share' => array(
			'className' => 'Share',
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
		'Subscription' => array(
			'className' => 'Subscription',
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
		'Comment' => array(
			'className' => 'Comment',
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
		'CalendarEvent' => array(
			'className' => 'CalendarEvent',
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
		)
	);
	
	public function get_total_useage_of_user($user_id = null) {
		$total_usage = null;
		if( $user_id ) {
			$total_usage = $this->find('all',
						array(
							'fields' => array('SUM(Document.size) / (1024 * 1024 * 1024) AS total_usage'), // calculate size in GB
							'conditions' => array('Document.user_id' => $user_id)
						)
					);
		}
		return $total_usage;
	}
	
	public function get_doc_info($doc_id, $auth_id) {	
		$result = false;
		$conditions['Document.id'] = $doc_id;
		if($auth_id) $conditions['Document.user_id'] = $auth_id;
		
		$result = $this->find('first',
							array(
								'conditions' => $conditions
							)
						);
		if(!$result) {
			$role = intval(CakeSession::read('Auth.User.role'));
			$conditions = array();
			if($role == 2) {
				$conditions = array('Share.guest_id' => $auth_id, 'Share.document_id' => $doc_id);
			} elseif($role == 0) {
				$conditions = array('Share.user2_id' => $auth_id, 'Share.document_id' => $doc_id);
			}
			$shared_info = $this->Share->is_shared($conditions);

			if($shared_info) {
				$result = $this->find('first',
							array(
								'conditions' => array(
												'Document.id' => $doc_id
											)
							)
						);
			}
		}
		return $result;
	}
	
	public function get_document_by_folder($folder_id=null, $auth_id=null, $limit=false) {
		$conditions = array();
		$documents = array();
		if($folder_id) {
			$folder_idx = $this->Folder->getChildrenId($folder_id, true, $auth_id);
			if(!empty($folder_idx)) {
				$params['conditions'] = array('Document.folder_id' => $folder_idx);
				$params['order'] = array('Document.created' => 'ASC');
				$params['recursive'] = -1;
				if($limit) {
					$params['limit'] = $limit;
				}
				$documents = $this->find('all', $params);
			}
		}
		return $documents;
	}
	
	public function listAllGuestDocument($document_idx) {
		$this->recursive = -1;
		$this->Behaviors->attach('Containable');
		$args['order'] = array('Document.id' => 'ASC');
		$args['conditions'] = array('Document.id' => $document_idx);
		$args['contain'] = array(
								'User' => array('fields' => array('User.id', 'User.first_name', 'User.last_name'))
							);
		return $this->find('all', $args);
	}
}
