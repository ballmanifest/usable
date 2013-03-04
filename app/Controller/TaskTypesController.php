<?php
App::uses('AppController', 'Controller');

class TaskTypesController extends AppController {

	public function index() {
		$this->TaskType->recursive = 0;
		$this->set('tasktype', $this->paginate());
	}
	
	public function view($id = null) {
		$this->TaskType->id = $id;
		if (!$this->Log->exists()) {
			throw new NotFoundException(__('Invalid tasktype'));
		}
		$this->set('tasktype', $this->Log->read(null, $id));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->TaskType->create();
			if ($this->TaskType->save($this->request->data)) {
				$this->Session->setFlash(__('The tasktype has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tasktype could not be saved. Please, try again.'));
			}
		}
		$companies = $this->TaskType->Company->find('list');
		$this->set(compact('companies'));
	}

	public function edit($id = null) {
		$this->TaskType->id = $id;
		if (!$this->TaskType->exists()) {
			throw new NotFoundException(__('Invalid tasktype'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->TaskType->save($this->request->data)) {
				$this->Session->setFlash(__('The tasktype has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tasktype could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->TaskType->read(null, $id);
		}
		$companies = $this->TaskType->find('list');
		$this->set(compact('companies'));
	}

	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->TaskType->id = $id;
		if (!$this->TaskType->exists()) {
			throw new NotFoundException(__('Invalid tasktype'));
		}
		if ($this->TaskType->delete()) {
			$this->Session->setFlash(__('TaskType deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Log was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
