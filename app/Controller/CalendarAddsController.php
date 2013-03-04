<?php
App::uses('AppController', 'Controller');

class CalendarAddsController extends AppController {

	public function index() {
		$this->CalendarAdd->recursive = 0;
		$this->set('calendarAdds', $this->paginate());
	}

	public function view($id = null) {
		$this->CalendarAdd->id = $id;
		if (!$this->CalendarAdd->exists()) {
			throw new NotFoundException(__('Invalid calendar add'));
		}
		$this->set('calendarAdd', $this->CalendarAdd->read(null, $id));
	}

	public function add() {
		$this->autoRender = false;
		$result = array('status' => 'n');
		if ($this->request->is('post') && $this->request->is('ajax')) {
			//$this->CalendarAdd->deleteAll(array('CalendarAdd.user_id' => $this->request->data['CalendarAdd']['user_id'], 'CalendarAdd.user_add' =>  $this->request->data['CalendarAdd']['user_add']));
			$this->CalendarAdd->create();
			if ($this->CalendarAdd->save($this->request->data, false)) {
				$cur_user = $this->request->data['CalendarAdd']['user_id'] ? $this->request->data['CalendarAdd']['user_id'] : $this->Auth->user('id');
				$added_users_idx = $this->CalendarAdd->get_added_user($cur_user);
				$result['user_idx'] = $added_users_idx;
				$result['status'] = 'y';
			}		
		}
		echo json_encode($result);
	}

	public function edit($id = null) {
		$this->CalendarAdd->id = $id;
		if (!$this->CalendarAdd->exists()) {
			throw new NotFoundException(__('Invalid calendar add'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CalendarAdd->save($this->request->data)) {
				$this->Session->setFlash(__('The calendar add has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The calendar add could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->CalendarAdd->read(null, $id);
		}
		$users = $this->CalendarAdd->User->find('list');
		$this->set(compact('users'));
	}

	public function delete($id = null) {
		$result = array('status' => 'n');
		if( $this->request->is('post') && $this->request->is('ajax')) {
			$this->autoRender = false;
			if( $this->CalendarAdd->deleteAll(array('CalendarAdd.user_id' => $this->request->data['CalendarAdd']['user_id'], 'CalendarAdd.user_add' => $this->request->data['CalendarAdd']['user_add']), false) ) {
				$result['status'] = 'y';
			} 
			echo json_encode($result);
		} else {
			if (!$this->request->is('post')) {
				throw new MethodNotAllowedException();
			}
			$this->CalendarAdd->id = $id;
			if (!$this->CalendarAdd->exists()) {
				throw new NotFoundException(__('Invalid calendar add'));
			}
			if ($this->CalendarAdd->delete()) {
				$this->Session->setFlash(__('Calendar add deleted'));
				$this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Calendar add was not deleted'));
			$this->redirect(array('action' => 'index'));
		}
	}
	
	private function _isExists($data = array()) {
		$count = $this->CalendarAdd->isExists($data);
		return !!$count;
	}
}
