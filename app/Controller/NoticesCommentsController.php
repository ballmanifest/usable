<?php
App::uses('AppController', 'Controller');

class NoticesCommentsController extends AppController {

	public function index() {
		$this->NoticesComment->recursive = 0;
		$this->set('noticescomments', $this->paginate());
	}

	public function view($id = null) {
		$this->NoticesComment->id = $id;
		if (!$this->NoticesComment->exists()) {
			throw new NotFoundException(__('Invalid comment'));
		}
		$this->set('noticescomment', $this->NoticesComment->read(null, $id));
	}
	
	
	
	public function add() {
		if ($this->request->is('post')) {
			$this->NoticesComment->create();
			$this->request->data['NoticesComment']['user_id']=$this->Auth->user('id');
			if ($this->NoticesComment->save($this->request->data)) {
				$this->Session->setFlash(__('The comment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The comment could not be saved. Please, try again.'));
			}
		}
		$users = $this->NoticesComment->User->find('list');
		$projects = $this->NoticesComment->Project->find('list');
		$tasks = $this->NoticesComment->Task->find('list');
		$this->set(compact('users', 'notices', 'tasks'));
	}

	public function edit($id = null) {
		$this->NoticesComment->id = $id;
		if (!$this->NoticesComment->exists()) {
			throw new NotFoundException(__('Invalid comment'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->NoticesComment->save($this->request->data)) {
				$this->Session->setFlash(__('The comment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The comment could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->NoticesComment->read(null, $id);
		}
		$users = $this->NoticesComment->User->find('list');
		$projects = $this->NoticesComment->Project->find('list');
		$tasks = $this->NoticesComment->Task->find('list');
		$this->set(compact('users', 'projects', 'tasks'));
	}

	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->NoticesComment->id = $id;
		if (!$this->NoticesComment->exists()) {
			throw new NotFoundException(__('Invalid comment'));
		}
		if ($this->NoticesComment->delete()) {
			$this->Session->setFlash(__('Comment deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Comment was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function show_comments(){
		$this->autoRender = false;
		if($this->request->is('post')) {
			print_r(json_encode($this->NoticesComment->get_notice_comments(7)));
		}else{
			print_r($this->NoticesComment->get_notice_comments(7));
		}
	}
	
}
