<?php
App::uses('AppModel', 'Model');

class Project extends AppModel {
	
	public $displayField = 'name';

	public $actsAs = array('Containable');
	
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
		'manager_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'start' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'end' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'budget' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public $hasOne = array(
		'Folder' => array(
			'className' => 'Folder',
			'foreignKey' => 'project_id',
		)
	);

	public $belongsTo = array(
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
		),
		'Notice' => array(
			'className' => 'Notice',
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
		'Share' => array(
			'className' => 'Share',
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
		'ProjectsUser' => array(
			'className' => 'ProjectsUser',
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
	);

	public $hasAndBelongsToMany = array(
		'User' => array(
			'className' => 'User',
			'joinTable' => 'projects_users',
			'foreignKey' => 'project_id',
			'associationForeignKey' => 'user_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

	public function get_project_notices($project_id = null){
		$projectNotices = array();
		if( !empty($project_id) ) {
			$projectNotices = $this->Notice->find('all', 
											array(
												'fields' => array('Notice.id', 'Notice.message', 'Notice.notice_type', 'Notice.item_type', 'Notice.itemid', 'Notice.description', 'DATE(Notice.created) AS date','Notice.user_id','Notice.created'),
												'conditions' => array('Notice.project_id' => $project_id),
												'recursive' => -2,
												'order' => array('Notice.created' => 'DESC')
											)
										);
		}
		return $projectNotices;
	}

	public function is_projects_exists($conditions) {
		$exists = $this->find('count', array('conditions' => $conditions, 'recursive' => -1));
		return $exists;
	}
	
	public function active_projects($auth_id = null) {
		$activeProjects = array();
		$this->Behaviors->attach('Containable');
		$conditions['Project.user_id'] = $auth_id;
		
		$isExists = $this->is_projects_exists($conditions);
		if(!$isExists) {
			$is_project_shared = $this->Share->find('all',
													array(
														'fields' => array('Share.project_id'),
														'conditions' => array('Share.user2_id' => $auth_id, 'Share.project_id !=' => 0)
													)
												);
			if(count($is_project_shared) > 0) {
				$project_idx = Set::extract('/Share/project_id', $is_project_shared);
				$conditions = array();
				$conditions['Project.id'] = $project_idx;
			} else return $activeProjects; 
		}

		$activeProjects = $this->find('all',
								array(
									'conditions' => $conditions, 
									'order' => array('Project.created' => 'desc'),
									'contain' => array(
										'User' => array(
											'fields' => array('User.id'),
											'ProjectsUser' => array (
												'fields' => array('ProjectsUser.id', 'ProjectsUser.modified')
											)
										),
										'Task' => array(
											'fields' => array('Task.id', 'Task.description', 'Task.title', 'Task.status')
										)
									),
									'limit' => 5,
									'order' => array('Project.name')
								)
							);
		return $activeProjects;
	}
	
	public function get_projects_list_by_user($auth_id=null, $clue='', $escape=array()) {

		$activeProjectsListByUserId = array();
		$conditions = array('Project.user_id' => $auth_id, 'Project.visibility !=' => 4);
		if($clue) {
			$conditions['Project.name LIKE'] =  '%' . $clue . '%';
		}
		if(!empty($escape)) {
			$conditions['NOT'] = array('Project.id' => array_unique($escape));
		}
		
		$activeProjectsListByUserId = $this->find('all',
												array(
													'fields' => array('Project.id', 'Project.name'),
													'conditions' => $conditions,
													'recursive' => -1,
												)
											);
		return $activeProjectsListByUserId;
	}
	
	public function project_details($project_id = null) {
		$activeProjects = array();
		$this->Behaviors->attach('Containable');
		$activeProjects = $this->find('all',
								array(
									'fields' => array('Project.id', 'Project.name', 'Project.date_due'),
									'conditions' => array('Project.id' => $project_id),
									'order' => array('Project.date_due' => 'asc'),
									'contain' => array(
										'User' => array(
											'fields' => array('User.id,User.first_name,User.last_name,User.position'),
											'ProjectsUser' => array(
												'fields' => array('ProjectsUser.id', 'ProjectsUser.modified')
											)
										),
										'Task' => array(
											'fields' => array('Task.id', 'Task.description', 'Task.title', 'Task.status', 'Task.ownerid', 'Task.task_type', 'Task.status')
										)
									)
								)
							);
		return $activeProjects;
	}
	
	public function get_project_visibilities() {
		$visibilities = array(
							array( 
								'value' => 'anyone_with_project_link', 
								'text' => 'Anyone With Project Link' 
							),
							array( 
								'value' => 'only_company_members', 
								'text' => 'Only Company Members'
							),
							array( 
								'value' => 'only_some_groups', 
								'text' => 'Only Some Groups'
							),
							array( 
								'value' => 'only_some_members', 
								'text' => 'Only Some Members'
							),
							array( 
								'value' => 'all_groups_members_except',  
								'text' => 'All Groups / Members Except'
							)
						);
		return $visibilities;
	}

	public function get_a_project_detail($project_id=null, $auth_id=null) {
		$project = array();
		$conditions = array();
		$order = array();
		$this->Behaviors->attach('Containable');
		if( $project_id ) {
			$conditions = array('Project.id' => $project_id);
		} else {
			$conditions = array('Project.user_id' => $auth_id);
			$order = array('Project.created' => 'desc');
		}
		$project = $this->find('first',
										array(
											'conditions' => $conditions,
											'order' => $order,
											'contain' => array(
												'User', 'Task', 'Share', 'Comment', 'Folder'
											)
										)
									);
		return $project;
	}
	
	public function get_project_members($project_id=null) {
		$project_members = array();
		$members_detail = array();
		if($project_id) {
			$members = $this->ProjectsUser->find('all',
														array(
															'recursive' => 2,
															'conditions' => array('ProjectsUser.project_id' => $project_id)
														)
													);
			$project_manager = $this->field('manager_id', array('Project.id' => $project_id));
			$members_idx = Set::extract('/ProjectsUser/user_id', $members);

			$members_detail= $this->User->find('all',
												array(
													'recursive' => -1,
													'fields' => array('User.id', 'User.name', 'User.first_name', 'User.last_name', 'User.role'),
													'conditions' => array('User.id' => am($members_idx, $project_manager)),
													'order' => array('User.last_name','User.first_name')
												)
											);
		}
		return $members_detail;
	}
	
	public function get_project_tasks($project_id=null) {
		$project_tasks = array();
		if($project_id) {
			$project_tasks = $this->Task->get_tasks_by_project($project_id);
		}
		return $project_tasks;
	}
	
	public function get_project_files($project_id=null, $auth_id=null, $limit=false, $shared=false) {
		$project_files = array();
		$this->Share->Behaviors->attach('Containable');
		$folder_id = $this->Folder->field('id', array('Folder.project_id' => $project_id));
		if($shared) {
			$project_files = $this->Share->find('all',
											array(
												'conditions'  => array('Share.project_id' => $project_id, 'Share.document_id !=' => 0),
												'contain' => array('Document')
											)
										);
		} else {
			$project_files = $this->Folder->Document->get_document_by_folder($folder_id, $auth_id, $limit);
		}
		
		return $project_files;
	}
}
