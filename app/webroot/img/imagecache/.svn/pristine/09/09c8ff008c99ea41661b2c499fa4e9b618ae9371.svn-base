<?php
App::uses('AppModel', 'Model');

class Task extends AppModel {

	public $displayField = 'title';

	public $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'ownerid' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
	);

	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Company' => array(
			'className' => 'Company',
			'foreignKey' => 'id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasMany = array(
		'Comment' => array(
			'className' => 'Comment',
			'foreignKey' => 'task_id',
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
		'Subtask' => array(
			'className' => 'Subtask',
			'foreignKey' => 'task_id',
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
		'Share' => array(
			'className' => 'Share',
			'foreignKey' => 'task_id',
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
	
	public function task_types() {
		return array (
					'TasksType' => array(
						array(
							'id' => 1,
							'title' => 'Feature'
						),
						array(
							'id' => 2,
							'title' => 'Bug'
						),
						array(
							'id' => 3,
							'title' => 'Chore'
						),
						array(
							'id' => 4,
							'title' => 'Release'
						)
					)
				);
	}
	
	public function task_statuses() {
		return array(
					'TasksStatus' => array(
						array(
							'id' => 1,
							'title' => 'Not Started Yet'
						),
						array(
							'id' => 2,
							'title' => 'Started'
						),
						array(
							'id' => 3,
							'title' => 'Finished'
						),
						array (
							'id' => 4,
							'title' => 'Delivered'
						),
						array(
							'id' => 5,
							'title' => 'Accepted'
						)
					) 
				);
	}
	
	public function get_active_tasks($task_id=null) {
		$active_tasks = array();
		$active_tasks = $this->find('all', 
									array(
									'recursive' => -1,
									'fields' => array('Task.status','Task.id'),
									'conditions' => array(
											'Task.id' => $task_id,
											'OR' => array(
												'Task.status' => array(2, 4) 
											)
										)
									)
								);
		return $active_tasks;
	}
	
	public function get_tasks_by_project($project_id=null) {
		$tasks_by_project = array();
		$tasks_by_project = $this->find('all',
					array(
						'recursive' => -1,
						'conditions' => array('Task.project_id' => $project_id),
						'order' => array ('Task.created' => 'desc'),
						'limit' => 5
					)
				);
		$owner_idx = Set::extract('/Task/ownerid', $tasks_by_project);
		$owners = $this->User->find('all',
									array(
										'recursive' => -1,
										'conditions' => array('User.id' => $owner_idx),
										'fields' => array('User.id', 'User.name')
									)
								);
		$owner_map = Set::combine($owners, '{n}.User.id', '{n}.User.name');
		foreach($tasks_by_project as $key => $task) {
			if(array_key_exists($task['Task']['ownerid'], $owner_map)) {
				$part = explode(' ', $owner_map[$task['Task']['ownerid']]);
				$tasks_by_project[$key]['Task']['owner'] = strtoupper(substr($part[0],0,1)) . strtoupper(substr($part[1],0,1));
			}
		}
		return $tasks_by_project;
	}
	
	public function get_tasks_detail($project_idx = array(), $clue='', $escape=array()) {
		$conditions = array(
							'Task.project_id' => $project_idx, 
							/*'NOT' => array('Task.status' => array(2, 5)) */	// test only comment
						);
		if($clue) {
			$conditions['Task.title'] = '%' . $clue . '%';
		}
		if(!empty($escape)) {
			$conditions['NOT'] = array('Task.id' => array_unique($escape));
		}
		$tasks = $this->find('all',
							array(
								'conditions' => $conditions,
								'recursive' => -1,
							)
						);
		return $tasks;
	}
}