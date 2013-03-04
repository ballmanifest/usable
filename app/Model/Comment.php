<?php
App::uses('AppModel', 'Model');

class Comment extends AppModel {

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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Project' => array(
			'className' => 'Project',
			'foreignKey' => 'project_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Task' => array(
			'className' => 'Task',
			'foreignKey' => 'task_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
            'counterCache'=> true,
		),
            
        'Document' => array(
            'className' => 'Document',
            'foreignKey' => 'document_id'
        ),
        'Folder' => array(
            'className' => 'Folder',
            'foreignKey' => 'folder_id'
        ),
        'Notice' => array(
            'className' => 'Notice',
            'foreignKey' => 'notice_id'
        )
	);

	
	public function get_task_comments($task_id){
		$comments = array();
		$comments = $this->find('all', 
			array(
				'fields' => array('Comment.id', 'Comment.comment', 'Comment.task_id', 'Comment.created','User.id','User.first_name', 'User.last_name'),
				'conditions' => array('Comment.task_id' => $task_id),
				'order' => array('Comment.created' => 'ASC')
			)
		);
		return $comments;
	}

	
	public function get_comments($project_idx = array()) {
		$comments = array();
		$this->Behaviors->attach('Containable');
		$comments = $this->find('all', 
					array(
						'fields' => array('Comment.id', 'Comment.comment', 'Comment.task_id', 'Comment.created'),
						'conditions' => array('Comment.project_id' => $project_idx),
						'contain' => array(
							'User' => array(
								'fields' => array('User.id','User.first_name', 'User.last_name')
							)
						)
					)
				);
		return $comments;
	}
	
	public function task_comments_count($task_ids){
		$tasks_num_comments = array();
		$tasks_num_comments = $this->find('all',
										array(
											'fields' => array('Task.id','count(Comment.id) as comments'),
											'conditions' => array('Task.id' => $task_ids),
											'group'=>'Task.id'
										)
									);
		$counts=array();
		foreach($tasks_num_comments as $task_num_comments){
			$counts[$task_num_comments['Task']['id']]=$task_num_comments[0]['comments'];
		}
		return $counts;
	}
	
	public function get_notice_comments($noticeId=null) {
		return $this->findAllByNoticeId($noticeId);
	}
	
	public function count_document_comments($doc_idx) {
		$this->recursive = -1;
		return $this->find('count', array('conditions' => array('Comment.document_id' => $doc_idx)));
	}
}
