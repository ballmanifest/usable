<?php
App::uses('AppModel', 'Model');

class CalendarEvent extends AppModel {

	public $displayField = 'title';

	public $validate = array(
		'calendar_id' => array(
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
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'date_start' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'date_end' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'timezone' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_all_day' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_repeat' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'availability' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'privacy' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	public $belongsTo = array(
		'Calendar' => array(
			'className' => 'Calendar',
			'foreignKey' => 'calendar_id',
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
	
	public function get_calendar_events($auth_id = null, $users_ids = array()) {
		$calendarEvents = array();
		$options = array();
		$users_ids = $users_ids ? $users_ids : $auth_id;
		if(!empty($users_ids)){
			$options['conditions'] = array('CalendarEvent.user_id' => $users_ids);
		}
		$options['recursive'] = -1;
		$calendarEvents = $this->find('all',$options);
		return $calendarEvents;
	}
	
	public function get_last_event($event_id = null) {
		$last_event = array();
		if( !empty($event_id) ) {
			$this->recursive = -1;
			$last_event = $this->findById($event_id);
		}
		return $last_event;
	}
	
	public function minicalendar_events($date_start = null, $date_end = null, $user_idx = array()) {
		$minicalendarEvents = array();
		$this->Behaviors->attach('Containable');
		$options = array();
		$options['conditions']['CalendarEvent.user_id'] = $user_idx;

		if( $date_start && $date_end ) {
			$options['conditions']['DATE(CalendarEvent.date_start) BETWEEN ? AND ?'] = array( $date_start, $date_end );
		} else {
			$options['conditions'][] = 'DATE(CalendarEvent.date_start) BETWEEN date_format(NOW(), \'%Y-%m-01\') AND last_day(NOW())';
		}
		$options['order'] = array('DATE(CalendarEvent.date_start)' => 'ASC', 'User.id' => 'ASC');
		$options['contain'] = array(
								'User' => array(
									'fields' => array('User.first_name', 'User.last_name')
								)
							);
		$minicalendarEvents['by_user'] = $this->find('all',
											array (
												'fields' => array('COUNT(CalendarEvent.id) AS event_count'),
												'conditions' => $options['conditions'],
												'order' => $options['order'],
												'group' => array('CalendarEvent.user_id'),
												'contain' => $options['contain']
											)
										);
										
		$user_with_events = Set::extract('/User/id', $minicalendarEvents['by_user']);
		$not_found_events = array_diff($user_idx, $user_with_events);
		
		if(!empty($not_found_events)) {
			foreach($not_found_events as $user_id) {
				$this->User->recursive = -1;
				$not_found_user = $this->User->findById($user_id);
				$empty_entry = array(
								array('event_count' => 0),
								'User' => array('id' => $user_id, 'first_name' => $not_found_user['User']['first_name'], 'last_name' => $not_found_user['User']['last_name'])
						);
				$minicalendarEvents['by_user'][] = $empty_entry;
			}
		}

		$minicalendarEvents['by_date'] = $this->find('all',
										array (
											'fields' => array('CalendarEvent.title', 'DATE(CalendarEvent.date_start) AS start_date', 'DATE(CalendarEvent.date_end) AS end_date'),
											'conditions' => $options['conditions'],
											'order' => $options['order'],
											'contain' => $options['contain']
										)
									);
		return $minicalendarEvents;
	}
	
	public function get_events_list($user_id = null, $event_type = null) {
		$eventsList = array();
		$user_idx = $user_id;
		$limit = 10;
		if( $event_type == 'all') {
			$user_idx = $this->get_added_user($user_id);
			$limit = 15;
		}
		$eventsList = $this->find('all',
									array(
										'fields' => array('CalendarEvent.user_id', 'CalendarEvent.id','CalendarEvent.title', 'CalendarEvent.date_start', 'DATE(CalendarEvent.date_start) AS start_date', 'CalendarEvent.description'),
										'conditions' => array('CalendarEvent.user_id' => $user_idx, 'DATE(CalendarEvent.date_start) >= CURDATE()'),
										'limit' => $limit,
										'order' => array('start_date' => 'ASC')
									)
								);
		return $eventsList;
	}
	
	public function get_users_has_calendar($escape_user = null, $escape_only_auth=true, $company_id=null) {
		$users = array();
		$already_added = $escape_only_auth ? $escape_user : $this->get_added_user($escape_user);
		/*
		
		>>> Not to filter over users
		>>> Has calendar or not
		>>> If urer has no calendar then will show
		>>> 0 event for that user
		
		$idx = $this->find('all',
								array(
									'fields' => array('DISTINCT(CalendarEvent.user_id)'),
									'conditions' => array('NOT' => array('CalendarEvent.user_id' => $already_added))
								)
							);
							
		$user_idx = Set::extract('/CalendarEvent/user_id', $idx );
		
		$conditions = array('User.id' => $user_idx);
		*/
		if(!$company_id) {
			$company_id = AuthComponent::user('company_id');
		}

		$conditions['User.company_id'] = $company_id;
		$conditions['NOT'] = array('User.id' => $already_added);
		$users = $this->User->find('all',
									array(
										'fields' => array('User.id','User.name'),
										'conditions' => $conditions,
										'recursive' => -1
									)
								);
		return $users;
	}
	
	public function get_added_user($cur_user = null) {
		$user_idx = $this->User->CalendarAdd->get_added_user($cur_user);
		return $user_idx;
	}
	
	public function get_events_by_user($auth_id=null, $clue='', $escape=array()) {
		$events = array();
		$conditions = array(
							'CalendarEvent.user_id' => $auth_id,
							'CalendarEvent.date_end >=' => date('Y-m-d h:i:s'),
						);
		if($clue) {
			$conditions['CalendarEvent.title LIKE'] = '%' . $clue . '%';
		}
		if(!empty($escape)) {
			$conditions['NOT'] = array('CalendarEvent.id' => array_unique($escape));
		}
		$events = $this->find('all',
								array(
									'conditions' => $conditions,
									'recursive' => -1,
								)
							);
		return $events;
	}
}
