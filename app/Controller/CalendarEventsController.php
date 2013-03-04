<?php
App::uses('AppController', 'Controller');

class CalendarEventsController extends AppController {

	public function index() {
		$this->CalendarEvent->recursive = 0;
		$this->set('calendarEvents', $this->paginate());
	}

	public function view($id = null) {
		$this->CalendarEvent->id = $id;
		if (!$this->CalendarEvent->exists()) {
			throw new NotFoundException(__('Invalid calendar event'));
		}
		$this->set('calendarEvent', $this->CalendarEvent->read(null, $id));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->CalendarEvent->create();
			if ($this->CalendarEvent->save($this->request->data)) {
				$this->Session->setFlash(__('The calendar event has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The calendar event could not be saved. Please, try again.'));
			}
		}
		$calendars = $this->CalendarEvent->Calendar->find('list');
		$this->set(compact('calendars'));
	}

	public function edit($id = null) {
		$this->CalendarEvent->id = $id;
		if (!$this->CalendarEvent->exists()) {
			throw new NotFoundException(__('Invalid calendar event'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CalendarEvent->save($this->request->data)) {
				$this->Session->setFlash(__('The calendar event has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The calendar event could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->CalendarEvent->read(null, $id);
		}
		$calendars = $this->CalendarEvent->Calendar->find('list');
		$this->set(compact('calendars'));
	}

	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->CalendarEvent->id = $id;
		if (!$this->CalendarEvent->exists()) {
			throw new NotFoundException(__('Invalid calendar event'));
		}
		if ($this->CalendarEvent->delete()) {
			$this->Session->setFlash(__('Calendar event deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Calendar event was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	public function add_calendar_event () {
		$this->autoRender = false;
		$result = array('status' => 'n');
		if( $this->request->is('post') && $this->request->is('ajax') || true ) {
			if (empty( $this->request->data['CalendarEvent']['date_start'])) {
				$this->request->data['CalendarEvent']['date_start'] = date( 'Y-m-d H:i:s', time() );;
			}
			if( empty( $this->request->data['CalendarEvent']['date_end'] ) ) {
				$this->request->data['CalendarEvent']['date_end'] = $this->request->data['CalendarEvent']['date_start'];
			}
			// @todo put contraint checks for lat/long
			if( $this->CalendarEvent->save($this->request->data, false) ) {
				/**
				*	Get Members to Share
				*	and save them
				*/
				$shares = Set::extract('/Share', $this->request->data);
				if(!empty($shares)) {
					$this->loadModel('Share');
					$this->Share->save_shares($shares, $this->CalendarEvent->id);
				}
				/**
				*	Create a Notice when New
				*	New Event Created
				*/
				$this->loadModel('Notice');
				$notice = array();
				$auth_name = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
				$time = date('g:ia');
				$notice['Notice']['user_id'] = $this->Auth->user('id');
				$notice['Notice']['calendar_event_id'] = $this->CalendarEvent->id;
				$notice['Notice']['notice_type'] = 'event_added';
				$notice['Notice']['short_message'] = htmlspecialchars('<div class="notice_block"><div class="pill event_added">Event Added</div><div class="the_notice"><span class="time"> | '. $time .'</span><strong>'. $this->request->data["CalendarEvent"]["title"] .'</strong> By <strong>'. $auth_name .'</strong></div></div>');
				$this->Notice->create();
				$this->Notice->save($notice, false);
				/**
				*	Create Notice block end
				*/
				$result['status'] = 'y';
				$last_event = $this->CalendarEvent->get_last_event($this->CalendarEvent->id);
				$result['event'] = $this->_events_formatting(array($last_event));
				echo json_encode( $result );
				return;
			}
		}
		echo json_encode( $result );
	}

	public function edit_calendar_event () {
		$this->autoRender = false;
		$result = array('status' => 'n');
		if( $this->request->is('post') && $this->request->is('ajax') ) {
			if( !empty($this->request->data['CalendarEvent']['event_id']) ) {
				$this->request->data['CalendarEvent']['id'] = $this->request->data['CalendarEvent']['event_id'];
				if( $this->CalendarEvent->save($this->request->data) ) {
					$result['status'] = 'y';
					$last_event = $this->CalendarEvent->get_last_event($this->request->data['CalendarEvent']['event_id']);
					$result['event'] = $this->_events_formatting(array($last_event));
				}
			}
		}
		
		echo json_encode( $result );
	}

	public function delete_calendar_event($id = null) {
		$this->autoRender = false;
		$result = array('status' => 'n');
		if( $this->request->is('ajax') && !empty($id) ) {
			$this->CalendarEvent->id = $id;
			if( $this->CalendarEvent->delete() ) {
				$result['status'] = 'y';
			}
		}
		echo json_encode( $result );
	}

	public function get_calendar_events($uids = '') {
		$this->autoRender = false;
		$calendarEvents = array();
		$auth_id = $this->Auth->user('id');
		$events = $this->CalendarEvent->get_calendar_events($auth_id, explode(',', $uids));
		$calendarEvents = $this->_events_formatting($events);
		//print_r($calendarEvents);
		echo json_encode( $calendarEvents );
	}

	public function minicalendar_events() {
		$result = array('status' => 'n');
		$cur_user = $this->Auth->user('id');
		if($this->request->is('ajax') && $this->request->is('post')) {
			$date_start = $this->request->data['CalendarEvent']['date_start'];
			$date_end = $this->request->data['CalendarEvent']['date_end'];
		}
		$user_idx = $this->CalendarEvent->get_added_user($cur_user);
		$events = $this->CalendarEvent->minicalendar_events($date_start, $date_end, $user_idx);
		$user_idx_with_event = Set::extract('/User/id', $events['by_user']);
		$empty_entry = array();
		if(!in_array($cur_user, $user_idx_with_event) || empty($events['by_user'])) {
			$empty_entry = array(
								array('event_count' => 0),
								'User' => array('id' => $cur_user, 'first_name' => $this->Auth->user('first_name'), 'last_name' => $this->Auth->user('last_name'))
						);
			$events['by_user'][] = $empty_entry;
		}
		$minicalendarEvents['byUser'] = $this->_add_color_to_users($events['by_user']);
		$minicalendarEvents['byDate'] = $this->_minicalendar_events_formatting($events['by_date'], $minicalendarEvents['byUser']);
		if( !empty($minicalendarEvents) ) {
			$result['status'] = 'y';
			$result['events'] = $minicalendarEvents;
			$result['auth_id'] = $cur_user;
		}
		$this->set(compact('result'));
	}

	public function get_events_list() {
		$eventsList = array();
		$result = array('status' => 'n');
		$user_id = $this->Auth->user('id');
		$event_type = 'me';
		if( $this->request->is('ajax') && $this->request->is('post') ) {
			if( !empty($this->request->data['CalendarEvent']['type']) ) {
				$event_type = $this->request->data['CalendarEvent']['type'];
			}
			$events = $this->CalendarEvent->get_events_list($user_id, $event_type);
			$eventsList = $this->_format_events_list($events);
			$result['status'] = 'y';
			$result['events'] = $eventsList;
		}
		$this->set(compact('result'));
	}

	public function get_users_has_calendar() {
		$escape_user = $this->Auth->user('id');
		$users = $this->CalendarEvent->get_users_has_calendar($escape_user);
		$this->set(compact('users'));
	}

	private function _events_formatting($events = array()) {
		$calendarEvents = array();
		foreach($events as $x => $event) {
			$calendarEvents[$x] = array(
									'id' => $event['CalendarEvent']['id'],
									'calendar_id' => $event['CalendarEvent']['calendar_id'],
									'title' => $event['CalendarEvent']['title'],
									'start' => $event['CalendarEvent']['date_start'],
									'end' => $event['CalendarEvent']['date_end'],
									'date_start' => $event['CalendarEvent']['date_start'],
									'date_end' => $event['CalendarEvent']['date_end'],
									'color' => '#' . (empty($event['CalendarEvent']['color'])  ? '5181EF' : $event['CalendarEvent']['color']),
									'description'=> $event['CalendarEvent']['description'],
									'allDay' => $event['CalendarEvent']['is_all_day'],
									'is_all_day' => $event['CalendarEvent']['is_all_day'],
									'is_repeat' => $event['CalendarEvent']['is_repeat'],
									'location' => $event['CalendarEvent']['location'],
									'lat' => $event['CalendarEvent']['lat'],
									'lng' => $event['CalendarEvent']['lng'],
									'availability' => $event['CalendarEvent']['availability'],
									'privacy' => $event['CalendarEvent']['privacy']
								);
		}
		return $calendarEvents;
	}

	private function _minicalendar_events_formatting($minicalEvents = array(), $users = array()) {
		$data = array();
		$sdate = null;
		$uid = null;
		$index = -1;
		$eCount = 1;
		$gCount = 1;
		$events_count_by_user = array();

		foreach($minicalEvents as $i => $event) {
			$tmp = $event[0]['start_date'];
			$edate = $event[0]['end_date'];
			$name = $event['User']['first_name'] . ' ' . substr($event['User']['last_name'], 0, 1) . '.';
			if( !$sdate || $sdate != $tmp) {
				$sdate = $tmp;
				$uid = $event['User']['id'];
				$index = 0;
			} else {
				if( $uid != $event['User']['id'] ) {
					$uid = $event['User']['id'];
					$eCount = 1;
					$index++;
				} else {
					$eCount++;
				}
			}
			$color = Set::extract('/User[id='. $uid .']/color', $users);
			$data[$sdate][$index] = array(
									'id'=> $uid,
									'name' => $name,
									'count' => $eCount,
									'color' => $color[0],
									'start_date' => $sdate,
									'end_date' => $edate
								);
		}
		return $data;
	}

	private function _format_events_list($events = array()) {
		$eventsList = array();
		$eventsList = Set::combine($events, '{n}.CalendarEvent.id', '{n}.CalendarEvent', '{n}.0.start_date');
		return $eventsList;
	}

	private function _add_color_to_users($events_by_user = array()) {
		$colors = array('A8A6FF', '5181EF', 'FCD74E', 'A3BBFE', '74E8BE', '3BD6DC', '4BB842',  'FFB871', 'FF8678', 'DE1D1D', 'DBAAFF', 'E1E1E1');
		foreach($events_by_user as $index => $event) {
			$events_by_user[$index]['User']['color'] = $colors[$index];
		}
		return $events_by_user;
	}
}
