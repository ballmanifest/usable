<?php
App::uses('AppController', 'Controller');

class TasksStatusController extends AppController {

	public function index() {
		$this->TaskStatus->recursive = 0;
		$this->set('taskstatus', $this->paginate());
	}
	
	public function view($id = null) {
		$this->TaskStatus->id = $id;
		if (!$this->TaskStatus->exists()) {
			throw new NotFoundException(__('Invalid taskstatus'));
		}
		$this->set('taskstatus', $this->Log->read(null, $id));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->TaskStatus->create();
			if ($this->TaskStatus->save($this->request->data)) {
				$this->Session->setFlash(__('The taskstatus has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The taskstatus could not be saved. Please, try again.'));
			}
		}
		$companies = $this->TaskStatus->Company->find('list');
		$this->set(compact('companies'));
	}

	public function edit($id = null) {
		$this->TaskStatus->id = $id;
		if (!$this->TaskStatus->exists()) {
			throw new NotFoundException(__('Invalid taskstatus'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->TaskStatus->save($this->request->data)) {
				$this->Session->setFlash(__('The taskstatus has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The taskstatus could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->TaskStatus->read(null, $id);
		}
		$companies = $this->TaskStatus->find('list');
		$this->set(compact('companies'));
	}

	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->TaskType->id = $id;
		if (!$this->TaskType->exists()) {
			throw new NotFoundException(__('Invalid taskstatus'));
		}
		if ($this->TaskType->delete()) {
			$this->Session->setFlash(__('TaskType deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Log was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
