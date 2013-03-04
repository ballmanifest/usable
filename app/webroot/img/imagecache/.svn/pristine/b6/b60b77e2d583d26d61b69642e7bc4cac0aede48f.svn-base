<?php
App::uses('AppController', 'Controller');

class PackagesController extends AppController {

	public function index() {
		$this->Package->recursive = 0;
		$this->set('packages', $this->paginate());
	}

	public function view($id = null) {
		$this->Package->id = $id;
		if (!$this->Package->exists()) {
			throw new NotFoundException(__('Invalid package'));
		}
		$this->set('package', $this->Package->read(null, $id));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->Package->create();
			if ($this->Package->save($this->request->data)) {
				$this->Session->setFlash(__('The package has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The package could not be saved. Please, try again.'));
			}
		}
	}

	public function edit($id = null) {
		$this->Package->id = $id;
		if (!$this->Package->exists()) {
			throw new NotFoundException(__('Invalid package'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Package->save($this->request->data)) {
				$this->Session->setFlash(__('The package has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The package could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Package->read(null, $id);
		}
	}

	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Package->id = $id;
		if (!$this->Package->exists()) {
			throw new NotFoundException(__('Invalid package'));
		}
		if ($this->Package->delete()) {
			$this->Session->setFlash(__('Package deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Package was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
