<?php
App::uses('AppController', 'Controller');

class CalendarsController extends AppController {

	public function index($user_id = null) {
		$current_company_id=$this->Auth->user('company_id');
		$current_user_id=$this->Auth->user('id');
		$agenda = '';
		if( !empty($this->request->named) && isset($this->request->named['agenda']) ) {
			$tagenda = strtolower($this->request->named['agenda']);
			if( in_array($tagenda, array('day', 'week', 'month')) ){
				$agenda = $tagenda != 'month' ? 'agenda' . ucfirst($tagenda) : $tagenda;
			}
		}		
		$user_id = $user_id ? $user_id : $current_user_id;
		$calendars = $this->Calendar->find('list');
		$users = $this->Calendar->CalendarEvent->User->members_list($current_company_id);
		$this->set(compact('calendars', 'user_id', 'users', 'agenda'));
	}

	public function view($id = null) {
		$this->Calendar->id = $id;
		if (!$this->Calendar->exists()) {
			throw new NotFoundException(__('Invalid calendar'));
		}
		$this->set('calendar', $this->Calendar->read(null, $id));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->Calendar->create();
			if ($this->Calendar->save($this->request->data)) {
				$this->Session->setFlash(__('The calendar has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The calendar could not be saved. Please, try again.'));
			}
		}
	}

	public function edit($id = null) {
		$this->Calendar->id = $id;
		if (!$this->Calendar->exists()) {
			throw new NotFoundException(__('Invalid calendar'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Calendar->save($this->request->data)) {
				$this->Session->setFlash(__('The calendar has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The calendar could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Calendar->read(null, $id);
		}
	}

	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Calendar->id = $id;
		if (!$this->Calendar->exists()) {
			throw new NotFoundException(__('Invalid calendar'));
		}
		if ($this->Calendar->delete()) {
			$this->Session->setFlash(__('Calendar deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Calendar was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
