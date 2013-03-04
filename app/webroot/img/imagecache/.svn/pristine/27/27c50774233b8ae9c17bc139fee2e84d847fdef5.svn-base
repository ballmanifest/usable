<?php
App::uses('AppModel', 'Model');

class NoticesComment extends AppModel {

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
		'Notice' => array(
			'className' => 'Notice',
			'foreignKey' => 'notice_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	
	public function get_notice_comments($notice_id){
		$comments = array();
		
		$comments = $this->find('all', 
			array(
				'fields' => array('NoticesComment.id', 'NoticesComment.comment', 'NoticesComment.notice_id',
								 'NoticesComment.created','User.id','User.first_name', 'User.last_name'),
				'conditions' => array('NoticesComment.notice_id' => $notice_id),
				'order' => array('NoticesComment.created' => 'ASC')
			)
		);
		return $comments;
	}

	
	public function get_comments($notice_idx = array()) {
		$comments = array();
		$this->Behaviors->attach('Containable');
		$comments = $this->find('all', 
					array(
						'fields' => array('Notices_Comments.id', 'Notices_Comments.comment', 'Notices_Comments.task_id', 'Notices_Comments.created'),
						'conditions' => array('Notices_Comments.notice_id' => $notice_idx),
						'contain' => array(
							'User' => array(
								'fields' => array('User.id','User.first_name', 'User.last_name')
							)
						)
					)
				);
		return $comments;
	}
	
	public function notice_comments_count($notice_ids){
		$tasks_num_comments = array();
		$tasks_num_comments = $this->find('all',
										array(
											'fields' => array('count(Comment.id) as comments'),
											'conditions' => array('Notice.id' => $notice_ids),
											'group'=>'Notice.id'
										)
									);
		$counts=array();
		foreach($tasks_num_comments as $task_num_comments){
			$counts[$task_num_comments['Notice']['id']]=$task_num_comments[0]['comments'];
		}
		return $counts;
	}
}
