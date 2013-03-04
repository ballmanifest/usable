<?php
App::uses('AppController', 'Controller');

class CalendarSharesController extends AppController {

	public function index() {
		$this->CalendarShare->recursive = 0;
		$this->set('calendarShares', $this->paginate());
	}

	public function view($id = null) {
		$this->CalendarShare->id = $id;
		if (!$this->CalendarShare->exists()) {
			throw new NotFoundException(__('Invalid calendar share'));
		}
		$this->set('calendarShare', $this->CalendarShare->read(null, $id));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->CalendarShare->create();
			if ($this->CalendarShare->save($this->request->data)) {
				$this->Session->setFlash(__('The calendar share has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The calendar share could not be saved. Please, try again.'));
			}
		}
		$calendars = $this->CalendarShare->Calendar->find('list');
		$this->set(compact('calendars'));
	}

	public function edit($id = null) {
		$this->CalendarShare->id = $id;
		if (!$this->CalendarShare->exists()) {
			throw new NotFoundException(__('Invalid calendar share'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CalendarShare->save($this->request->data)) {
				$this->Session->setFlash(__('The calendar share has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The calendar share could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->CalendarShare->read(null, $id);
		}
		$calendars = $this->CalendarShare->Calendar->find('list');
		$this->set(compact('calendars'));
	}

	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->CalendarShare->id = $id;
		if (!$this->CalendarShare->exists()) {
			throw new NotFoundException(__('Invalid calendar share'));
		}
		if ($this->CalendarShare->delete()) {
			$this->Session->setFlash(__('Calendar share deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Calendar share was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
