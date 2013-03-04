<?php
App::uses('AppModel', 'Model');

class ProjectsUser extends AppModel {

	public $displayField = 'title';

	public $validate = array(
		'project_id' => array(
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
		'is_admin' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'budget' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'title' => array(
			'rule' => array('noEmpty'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
		),
	);

	public $belongsTo = array(
		'Project' => array(
			'className' => 'Project',
			'foreignKey' => 'project_id',
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
		'Comment' => array(
			'className' => 'Comment',
			'foreignKey' => 'project_id',
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
		'Task' => array(
			'className' => 'Task',
			'foreignKey' => 'project_id',
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
	
	public function project_details($project_id = null) {
		$projectDetails = array();
		if( !empty($project_id) ) {
			$projectDetails = $this->Project->project_details($project_id);
		} 
		return $projectDetails;
	}
	
	public function project_members($project_idx = null) {
		$projectMembers = array();
		$projectMembers = $this->find('all',
										array(
											'conditions' => array('ProjectsUser.project_id' => $project_idx)
										)
									);
		return $projectMembers;
	}
	
	public function project_members_user($project_idx = null, $user_id = null) {
		$projectMembers = array();
		$projectMembers = $this->find('all',
										array(
											'conditions' => array('ProjectsUser.project_id' => $project_idx, 'ProjectsUser.user_id' => $user_id)
										)
									);
		return $projectMembers;
	}

	
	public function project_members_details($user_idx = array()) {
		$membersDetail = array();
		$membersDetail = $this->User->find('all',
										array(
											'fields' => array('User.id', 'User.first_name', 'User.last_name, User.position'),
											'conditions' => array('User.id' => $user_idx),
											'recusive' => -1
										)
									);
		return $membersDetail;
	}
	
	public function project_tasks($project_id = null) {
		$tasks = array();
		if( !empty($project_id) ) {
			$tasks = $this->Task->find('all', 
										array(
										  'conditions' => array('Task.project_id' => $project_id),
										  'recursive' => -1,
										  'order' => array('Task.created' => 'DESC')
										)
									);
		}
		return $tasks;
	}
	
	public function project_member_tasks($project_id = null,$user_id = null) {
		$tasks = array();
		if( !empty($project_id) ) {
			$tasks = $this->Task->find('all', 
										array(
										  'conditions' => array('Task.project_id' => $project_id,'Task.ownerid' => $user_id),
										  'recursive' => -1,
										  'order' => array('Task.created' => 'DESC')
										)
									);
		}
		return $tasks;
	}
	
	
	public function task_subtasks($task_ids = array()) {
		$subtasks = array();
		if( !empty($task_ids) ) {
			$subtasks = $this->Task->Subtask->find('all',
													array(
														'conditions' => array('Subtask.task_id' => $task_ids),
														'recursive' => -1,
														'order' => array('Subtask.created' => 'DESC'),
													)
												);
		}
		return $subtasks;
	}
	
	public function get_comments($project_idx = array()) {
		$comments = array();
		if( $project_idx ) {
			$comments = $this->Project->Comment->get_comments($project_idx);
		}
		return $comments;
	}
	
	public function task_types() {
		return $this->Task->task_types();
	}
	
	public function task_statuses() {
		return $this->Task->task_statuses();
	}
	
}
