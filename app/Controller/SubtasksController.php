<?php
App::uses('AppController', 'Controller');

class SubtasksController extends AppController {

	public function index() {
		$this->Subtask->recursive = 0;
		$this->set('subtasks', $this->paginate());
	}

	public function view($id = null) {
		$this->Subtask->id = $id;
		if (!$this->Subtask->exists()) {
			throw new NotFoundException(__('Invalid subtask'));
		}
		$this->set('subtask', $this->Subtask->read(null, $id));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->Subtask->create();
			if ($this->Subtask->save($this->request->data)) {
				$this->Session->setFlash(__('The subtask has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The subtask could not be saved. Please, try again.'));
			}
		}
		$tasks = $this->Subtask->Task->find('list');
		$this->set(compact('tasks'));
	}

	public function edit($id = null) {
		$this->Subtask->id = $id;
		if (!$this->Subtask->exists()) {
			throw new NotFoundException(__('Invalid subtask'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Subtask->save($this->request->data)) {
				$this->Session->setFlash(__('The subtask has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The subtask could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Subtask->read(null, $id);
		}
		$tasks = $this->Subtask->Task->find('list');
		$this->set(compact('tasks'));
	}

	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Subtask->id = $id;
		if (!$this->Subtask->exists()) {
			throw new NotFoundException(__('Invalid subtask'));
		}
		if ($this->Subtask->delete()) {
			$this->Session->setFlash(__('Subtask deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Subtask was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
