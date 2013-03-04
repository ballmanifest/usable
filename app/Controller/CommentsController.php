<?php
App::uses('AppController', 'Controller');

class CommentsController extends AppController {

	public function index() {
		$this->Comment->recursive = 0;
		$this->set('comments', $this->paginate());
	}

	public function view($id = null) {
		$this->Comment->id = $id;
		if (!$this->Comment->exists()) {
			throw new NotFoundException(__('Invalid comment'));
		}
		$this->set('comment', $this->Comment->read(null, $id));
	}
	
	public function view_by_task_id($id = null) {
		if( $this->request->is('ajax')) {
			$this->autoRender = false;
			echo json_encode($this->Comment->get_task_comments($id));
		}else{
			print_r($this->Comment->get_task_comments($id));
			$this->autoRender = false;
		}
	}
	
	
	public function add() {
		if ($this->request->is('post')) {
			$this->Comment->create();
			$this->request->data['Comment']['user_id']=$this->Auth->user('id');
			if ($this->Comment->save($this->request->data)) {
				//$this->Session->setFlash(__('The comment has been saved'));
				//$this->redirect(array('action' => 'index'));
			} else {
				//$this->Session->setFlash(__('The comment could not be saved. Please, try again.'));
			}
		}
		$users = $this->Comment->User->find('list');
		$projects = $this->Comment->Project->find('list');
		$tasks = $this->Comment->Task->find('list');
		$this->set(compact('users', 'projects', 'tasks'));
	}

	public function edit($id = null) {
		$this->Comment->id = $id;
		if (!$this->Comment->exists()) {
			throw new NotFoundException(__('Invalid comment'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Comment->save($this->request->data)) {
				$this->Session->setFlash(__('The comment has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The comment could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Comment->read(null, $id);
		}
		$users = $this->Comment->User->find('list');
		$projects = $this->Comment->Project->find('list');
		$tasks = $this->Comment->Task->find('list');
		$this->set(compact('users', 'projects', 'tasks'));
	}

	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Comment->id = $id;
		if (!$this->Comment->exists()) {
			throw new NotFoundException(__('Invalid comment'));
		}
		if ($this->Comment->delete()) {
			$this->Session->setFlash(__('Comment deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Comment was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	/**
	*	Show Notice's Comment Modal
	*/

	public function notice_comment($noticeId=null) {
		$noticeComments = array();
		 if($this->request->is('ajax') && !empty($noticeId)) {
			$auth_id = $this->Auth->user('id');
			$comments = $this->Comment->get_notice_comments($noticeId);
			$notice = $this->Comment->Notice->findById($noticeId);
			$title = 'Notice';
			$comment_for = 'notice_id';
			$target_id = $noticeId;
            $this->set(compact('comments', 'title', 'comment_for', 'target_id', 'auth_id', 'notice'));
            $this->render('comments', false);
        }
	}
	
	/**
	*	Add New Comment
	*/
	
	public function addComment() {
        $auth_id = $this->Auth->user("id");
        if($this->request->is('ajax') && !empty($this->request->data)) {
            $this->Comment->create();
            $this->Comment->save($this->request->data);
            $newId = $this->Comment->getLastInsertId();
            $this->set("isNewAdded",true);
            $this->set("comments", $this->Comment->find("all", array("conditions"=>array("Comment.id"=>$newId))));
            $this->render("comments", false);
        }
    }
}
