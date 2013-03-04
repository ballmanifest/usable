<?php
App::uses('AppModel', 'Model');

class CalendarAdd extends AppModel {

	public $displayField = 'user_add';

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
		'user_add' => array(
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
			'ord,er' => ''
		),
		'Calendar' => array(
			'className' => 'Calendar',
			'foreignKey' => 'calendar_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
	
	public function get_added_user($cur_user = null) {
		$user_idx = $this->find('list',
								array(
									'conditions' => array('CalendarAdd.user_id' => $cur_user)
								)
							);
		return am($cur_user, array_values( $user_idx ) );
	}
	
	public function isExists($data = array()) {
		$count = $this->find('count',
								array(
									'conditions' => array('CalendarAdd.user_id' => $data['CalendarAdd']['user_id'], 'CalendarAdd.user_add' => $data['CalendarAdd']['user_add'])
								)
							);
		return $count;
	}
}
