<?php
App::uses('AppModel', 'Model');

class UsersGroup extends AppModel {

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
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public $hasMany = array(
		
	);
	
	public function is_unique($group_id, $user_id){
		$user_group = $this->find('all',
										array(
											'fields' => array(
												'UsersGroup.id'
											),
											'recursive' => -1,
											'conditions' => array(
												'UsersGroup.group_id'=>$group_id,
												'UsersGroup.user_id'=>$user_id
											)
										)
									);
		return count($user_group)<1;
	}
	
	public function get_group_users($group_id, $sort=null, $conditions=array()){
		$users_group = $this->find('all',
										array(
											'fields' => array(
												'User.id',
												'User.first_name',
												'User.last_name',
												'User.email',
											),
											'recursive' => 1,
											'conditions' => array_merge(array(
												'UsersGroup.group_id'=>$group_id
											),$conditions),
											'order'=>$sort
										)
									);
		return $users_group;
	}
	public function get_user_groups($of_user_id, $user_id){
		$user_groups = $this->find('all',
										array(
											'fields' => array(
												'*'
											),
											'recursive' => 1,
											'conditions' => array(
												'Group.user_id' => $user_id,
												'UsersGroup.user_id'=>$of_user_id
											)
										)
									);
		return $user_groups;
	}
	
}