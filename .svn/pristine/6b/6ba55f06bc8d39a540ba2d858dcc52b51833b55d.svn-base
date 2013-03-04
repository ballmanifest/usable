<?php
App::uses('AppController', 'Controller');

class PurchaseLogsController extends AppController {

	public function index() {
		$this->PurchaseLog->recursive = 0;
		$this->set('purchaseLogs', $this->paginate());
	}
	public function direct_post(){
		App::import('Vendor', 'phpthumb', array('file' => 'anet_php_sdk' . DS . 'AuthorizeNet.php'));
	}
	public function view($id = null) {
		$this->PurchaseLog->id = $id;
		if (!$this->PurchaseLog->exists()) {
			throw new NotFoundException(__('Invalid purchase log'));
		}
		$this->set('purchaseLog', $this->PurchaseLog->read(null, $id));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->PurchaseLog->create();
			if ($this->PurchaseLog->save($this->request->data)) {
				$this->Session->setFlash(__('The purchase log has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The purchase log could not be saved. Please, try again.'));
			}
		}
		$users = $this->PurchaseLog->User->find('list');
		$this->set(compact('users'));
	}

	public function edit($id = null) {
		$this->PurchaseLog->id = $id;
		if (!$this->PurchaseLog->exists()) {
			throw new NotFoundException(__('Invalid purchase log'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->PurchaseLog->save($this->request->data)) {
				$this->Session->setFlash(__('The purchase log has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The purchase log could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->PurchaseLog->read(null, $id);
		}
		$users = $this->PurchaseLog->User->find('list');
		$this->set(compact('users'));
	}

	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->PurchaseLog->id = $id;
		if (!$this->PurchaseLog->exists()) {
			throw new NotFoundException(__('Invalid purchase log'));
		}
		if ($this->PurchaseLog->delete()) {
			$this->Session->setFlash(__('Purchase log deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Purchase log was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

}
