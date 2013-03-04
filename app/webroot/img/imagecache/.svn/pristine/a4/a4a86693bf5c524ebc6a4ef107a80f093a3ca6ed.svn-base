<?php
App::uses('AppController', 'Controller');

class NoticesController extends AppController {

	private $notice_config = array();
	
	public function index() {
		$this->Notice->recursive = 0;
		$this->set('notices', $this->paginate());
	}

	public function view($id = null) {
		$this->Notice->id = $id;
		if (!$this->Notice->exists()) {
			throw new NotFoundException(__('Invalid notice'));
		}
		$this->set('notice', $this->Notice->read(null, $id));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->Notice->create();
			if ($this->Notice->save($this->request->data)) {
				$this->Session->setFlash(__('The notice has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The notice could not be saved. Please, try again.'));
			}
		}
		$users = $this->Notice->User->find('list');
		$projects = $this->Notice->Project->find('list');
		$tasks = $this->Notice->Task->find('list');
		$documents = $this->Notice->Document->find('list');
		$folders = $this->Notice->Folder->find('list');
		$this->set(compact('users', 'projects', 'tasks', 'documents', 'folders'));
	}

	public function edit($id = null) {
		$this->Notice->id = $id;
		if (!$this->Notice->exists()) {
			throw new NotFoundException(__('Invalid notice'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Notice->save($this->request->data)) {
				$this->Session->setFlash(__('The notice has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The notice could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Notice->read(null, $id);
		}
		$users = $this->Notice->User->find('list');
		$projects = $this->Notice->Project->find('list');
		$tasks = $this->Notice->Task->find('list');
		$documents = $this->Notice->Document->find('list');
		$folders = $this->Notice->Folder->find('list');
		$this->set(compact('users', 'projects', 'tasks', 'documents', 'folders'));
	}

	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Notice->id = $id;
		if (!$this->Notice->exists()) {
			throw new NotFoundException(__('Invalid notice'));
		}
		if ($this->Notice->delete()) {
			$this->Session->setFlash(__('Notice deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Notice was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	/*
	*	generate HTML block for share
	*/
	private function _get_share_html_block($config = array()) {
	
		/*				<user_id>_share_<document_id>_with_<user2_id>
		*				<user_id>_share_<document_id>_with_<project_id>
		*				<user_id>_share_<document_id>_with_<task_id>
		*				<user_id>_share_<document_id>_with_<group_id>
		*				<user_id>_share_<task_id>_with_<user2_id>
		*				<user_id>_share_<task_id>_with_<project_id>
		*				<user_id>_share_<task_id>_with_<calendar_event_id>
		*/
		
		$_BASE = '../../';
		$config = $this->notice_config;
		$keys = array_keys($config['values']);
		$pattern = implode('_', $keys);
		$ids = $config['ids'];
		$vals = $config['values'];
		if(!empty($vals['document'])) {
			$doctype = $this->_get_file_type($vals['document']);
		}

		$html = '<div class="notice_block share_notice" data-notice="share">';
		$short_message = '<td class="notice_des" data-noticetype="share"><p>';
		
		switch($pattern) {
			case 'user_document_user2':
				$html .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has shared '. $doctype['type'] .' with <a href="'. $_BASE . 'users/view/'. $ids['user2_id'] .'">'. $vals['user2'] .'</a> at ' . date('h:i a') . '</p>';
				$url = ($doctype['type'] == 'image') ? $_BASE . 'img/imagecache/'. $vals['document'] : $_BASE. 'documents/view/'. $ids['document_id'] .'?name='. $doctype['name'].'&ext='. $doctype['ext'];
				$short_message .= '<a href="'. $_BASE .'users/view/'. $ids['user_id'] .'">'. $vals['user'] .'</a> has shared <a href="'. $url .'">'. $vals['document'].'</a> with <a href="'. $_BASE .'users/view/'. $ids['user2_id'] .'">'. $vals['user2'] .'</a>';
			break;
			
			case 'user_document_project':
				$html .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has shared '. $doctype['type'] .' with <a href="'. $_BASE .'projects/view/'. $ids['project_id'] .'">'. $vals['project'] .'</a> at '. date('h:i a') . '</p>';	
				$url = ($doctype['type'] == 'image') ? 'img/imagecache/'. $vals['document'] : 'documents/view/'. $ids['document_id'] .'?name='. $doctype['name'].'&ext='. $doctype['ext'];
				$short_message .= '<a href="'. $_BASE .'users/view/'. $ids['user_id'] .'">'. $vals['user'] .'</a> has shared <a href="'. $url .'">'. $vals['document'].'</a> with project <a href="'. $_BASE .'projects/view/'. $ids['project_id'] .'">'.  $vals['project']  .'</a>';				
			break;
			
			case 'user_document_task':
				$html .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has shared '. $doctype['type'] .' with <a href="'. $_BASE .'tasks/view/'. $ids['task_id'] .'">'. $vals['task'] .' </a> task at ' . date('h:i a') . '</p>';
				$url = ($doctype['type'] == 'image') ? 'img/imagecache/'. $vals['document'] : 'documents/view/'. $ids['document_id'] .'?name='. $doctype['name'].'&ext='. $doctype['ext'];
				$short_message .= '<a href="'. $_BASE .'users/view/'. $ids['user_id'] .'">'. $vals['user'] .'</a> has shared <a href="'. $url .'">'. $vals['document'].'</a> with <a href="'. $_BASE .'tasks/view/'. $ids['task_id'] .'">'.  $vals['task']  .'</a> task';				
			break;
			
			case 'user_document_group':
				$html .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has shared '. $doctype['type'] .' with <a href="'. $_BASE .'groups/view/'. $ids['group_id'] .'">'. $vals['group'] .'</a> at ' . date('h:i a') . '</p>';
				$url = ($doctype['type'] == 'image') ? 'img/imagecache/'. $vals['document'] : 'documents/view/'. $ids['document_id'] .'?name='. $doctype['name'].'&ext='. $doctype['ext'];
				$short_message .= '<a href="'. $_BASE .'users/view/'. $ids['user_id'] .'">'. $vals['user'] .'</a> has shared <a href="'. $url .'">'. $vals['document'].'</a> with <a href="'. $_BASE .'tasks/view/'. $ids['task_id'] .'">'.  $vals['task']  .'</a> task';				
			break;
			
			case 'user_task_user2':
				$html .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has shared '. $vals['task'] .' task with <a href="'. $_BASE .'users/view/'. $ids['user2_id'] .'">'. $vals['user2'] .'</a> at ' . date('h:i a') . '</p>';
				$short_message .= '<a href="'. $_BASE .'users/view/'. $ids['user_id'] .'">'. $vals['user'] .'</a> has shared <a href="'. $_BASE .'tasks/view/'. $ids['task_id'] .'">'. $vals['task'].'</a> task with <a href="'. $_BASE .'users/view/'. $ids['user2_id'] .'">'.  $vals['user2']  .'</a>';
			break;
			
			case 'user_task_project':
				$html .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has shared '. $vals['task'] .' task with <a href="'. $_BASE .'projects/view/'. $ids['project_id'] .'">'. $vals['project'] .'</a> at '. date('h:i a') . '</p>';
				$short_message .= '<a href="'. $_BASE .'users/view/'. $ids['user_id'] .'">'. $vals['user'] .'</a> has shared <a href="'. $_BASE .'tasks/view/'. $ids['task_id'] .'">'. $vals['task'].'</a> task with <a href="'. $_BASE .'projects/view/'. $ids['project_id'] .'">'.  $vals['project']  .'</a>';
			break;
			
			case 'user_task_calendarEvent':
				$html .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has shared '. $vals['task'] .' to '. $vals['user2'] .' calendar event at ' . date('h:i a') . '</p>';
				$short_message .= '<a href="'. $_BASE .'users/view/'. $ids['user_id'] .'">'. $vals['user'] .'</a> has shared <a href="'. $_BASE .'tasks/view/'. $ids['task_id'] .'">'. $vals['task'].'</a> to calendar event. </a>';
			break;
		}
		
		if(!empty($doctype) ) {
			if($doctype['type'] == 'image') {
				$html .= '<p style="margin-top: 10px;vertical-align: middle"><img src="img/imagecache/'. $vals['document'] .'" height="173"></p>';
			} else {
				$html .= '<p style="margin-top: 10px;vertical-align: middle><a href="'. $_BASE .'documents/view/'. $ids['document_id'] .'?name='. $doctype['name'].'&ext='. $doctype['ext'] .'">'. $vals['document'].'</a></p>';
			}
		}
		$html .= '</div>';
		$short_message .= '</p></td>';
		return array('message' => htmlspecialchars($html), 'short_message' => htmlspecialchars($short_message), 'notice_type' => 'share');
	}
	
	/*
	*	generate HTML block for comment
	*/
	
	private function _get_comment_html_block($config = array()) {
	
		/*				<user_id>_comment_to_<document_id>
		*				<user_id>_comment_to_<folder_id>
		*				<user_id>_comment_to_<task_id>
		*				<user_id>_comment_to_<project_id>
		*/
		
		$_BASE = '../';
		$config = $this->notice_config;
		$keys = array_keys($config['values']);
		$pattern = implode('_', $keys);
		$ids = $config['ids'];
		$vals = $config['values'];
		if(!empty($vals['document'])) {
			$doctype = $this->_get_file_type($vals['document']);
		}
		
		$html = '<div class="notice_block notice_comment" data-notice="comment">';
		$short_message = '<td class="notice_des" data-noticetype="comment"><p>';
		
		switch($pattern) {
			case 'user_document':
				$html .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has commented on '. $doctype['type'] .' at ' . date('h:i a') . '</p>';
				$url = ($doctype['type'] == 'image') ? $_BASE .'img/imagecache/'. $vals['document'] : $_BASE .'documents/view/'. $ids['document_id'] .'?name='. $doctype['name'].'&ext='. $doctype['ext'];
				$short_message .= '<a href="users/view/'. $ids['user_id'] .'">'. $vals['user'] .'</a> has commented on <a href="'. $url .'">'. $vals['document'].'</a>';
			break;
			
			case 'user_folder':
				$html .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has commented to <a href="'. $_BASE .'cabinets/view/'. $ids['folder_id'] .'">'. $vals['folder'] .'</a> at '. date('h:i a') . '</p>';
				$short_message .= '<a href="'. $_BASE .'users/view/'. $ids['user_id'] .'">'. $vals['user'] .'</a> has commented on <a href="'. $_BASE .'cabinets/view/'. $ids['folder_id'] .'">'. $vals['folder'].'</a>';
			break;
			
			case 'user_task':
				$html .= '<p><a href="'.$_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has commented on <a href="'. $_BASE .'tasks/view/'. $ids['task_id'] .'">'. $vals['task'] .'</a> task at ' . date('h:i a') . '</p>';
				$short_message .= '<a href="'. $_BASE .'users/view/'. $ids['user_id'] .'">'. $vals['user'] .'</a> has commented on <a href="'. $_BASE .'tasks/view/'. $ids['task_id'] .'">'. $vals['task'].'</a>';
			break;
			
			case 'user_project':
				$html .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has commented on project <a href="'. $_BASE .'projects/view/'. $ids['project_id'] .'">'. $vals['project'] .'</a> at ' . date('h:i a') . '</p>';
				$short_message .= '<a href="'. $_BASE .'users/view/'. $ids['user_id'] .'">'. $vals['user'] .'</a> has commented on project <a href="'. $_BASE .'projects/view/'. $ids['project_id'] .'">'. $vals['project'].'</a>';
			break;
		}
		
		if(!empty($doctype) ) {
			if($doctype['type'] == 'image') {
				$html .= '<p style="margin-top: 10px;vertical-align: middle"><img src="img/imagecache/'. $vals['document'] .'" height="173"></p>';
			} else {
				$html .= '<p style="margin-top: 10px;vertical-align: middle><a href="'. $_BASE .'documents/view/'. $ids['document_id'] .'?name='. $doctype['name'].'&ext='. $doctype['ext'] .'">'. $vals['document'].'</a></p>';
			}
		}
		$html .= '</div>';
		$short_message .= '</p></td>';
		return array('message' => htmlspecialchars($html), 'short_message' => htmlspecialchars($short_message), 'notice_type' => 'comment');
	}
	
	/*
	*	generate HTML block for add
	*/
	
	private function _get_add_html_block($config = array()) {
	
		/*				<user_id>_add_<user2_id>
		*				<user_id>_add_<task_id>
		*				<user_id>_add_<project_id>
		*				<user_id>_add_<document_id>
		*/
		
		$_BASE = '../';
		$config = $this->notice_config;
		$keys = array_keys($config['values']);
		$pattern = implode('_', $keys);
		$ids = $config['ids'];
		$vals = $config['values'];
		if(!empty($vals['document'])) {
			$doctype = $this->_get_file_type($vals['document']);
		}
		
		$html = '<div class="notice_block notice_add" data-notice="add">';
		$short_message = '<td class="notice_des" data-noticetype="add"><p>';
		
		switch($pattern) {
			case 'user_document':
				$html .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has added '. $doctype['type'] .' at ' . date('h:i a') . '</p>';
				$url = ($doctype['type'] == 'image') ? $_BASE .'img/imagecache/'. $vals['document'] : $_BASE .'documents/view/'. $ids['document_id'] .'?name='. $doctype['name'].'&ext='. $doctype['ext'];
				$short_message .= '<a href="'. $_BASE .'users/view/'. $ids['user_id'] .'">'. $vals['user'] .'</a> has added <a href="'. $url .'">'. $vals['document'].'</a>';
			break;
			
			case 'user_user2':
				$html .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has added <a href="'. $_BASE .'users/view/'. $ids['user2_id'] .'">'. $vals['user2'] .'</a> at '. date('h:i a') . '</p>';
				$short_message .= '<a href="'. $_BASE .'users/view/'. $ids['user_id'] .'">'. $vals['user'] .'</a> has added <a href="'. $_BASE .'users/view/'. $ids['user2_id'] .'">'. $vals['user2'].'</a>';				
			break;
			
			case 'user_task':
				$html .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has added <a href="'. $_BASE .'tasks/view/'. $ids['task_id'] .'">'. $vals['task'] .' </a> task at ' . date('h:i a') . '</p>';
				$short_message .= '<a href="'. $_BASE .'users/view/'. $ids['user_id'] .'">'. $vals['user'] .'</a> has added <a href="'. $_BASE . 'tasks/view/'. $ids['task_id'] .'">'. $vals['task'].'</a> task.';				
			break;
			
			case 'user_project':
				$html .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has added project <a href="'. $_BASE .'projects/view/'. $ids['project_id'] .'">'. $vals['project'] .'</a> at ' . date('h:i a') . '</p>';
				$short_message .= '<a href="'. $_BASE . 'users/view/'. $ids['user_id'] .'">'. $vals['user'] .'</a> has added <a href="'. $_BASE . 'projects/view/'. $ids['project_id'] .'">'. $vals['project'].'</a> project.';				
			break;
		}
		
		if(!empty($doctype) ) {
			if($doctype['type'] == 'image') {
				$html .= '<p style="margin-top: 10px;vertical-align: middle"><img src="img/imagecache/'. $vals['document'] .'" height="173"></p>';
			} else {
				$html .= '<p style="margin-top: 10px;vertical-align: middle><a href="documents/view/'. $ids['document_id'] .'?name='. $doctype['name'].'&ext='. $doctype['ext'] .'">'. $vals['document'].'</a></p>';
			}
		}
		$html .= '</div>';
		$short_message .= '</p></td>';
		return array('message' => htmlspecialchars($html), 'short_message' => htmlspecialchars($short_message), 'notice_type' => 'add');
	}
	
	/*
	*	generate HTML block for join
	*/
	
	private function _get_join_html_block($config = array()) {
	
		/*				<user_id>_join_to_<grop_id>
		*				<user_id>_join_to_<project_id>
		*				<user_id>_join_to_<task_id>
		*/
		
		$_BASE = '../';
		$config = $this->notice_config;
		$keys = array_keys($config['values']);
		$pattern = implode('_', $keys);
		$ids = $config['ids'];
		$vals = $config['values'];
		if(!empty($vals['document'])) {
			$doctype = $this->_get_file_type($vals['document']);
		}
		
		$html = '<div class="notice_block notice_join" data-notice="join">';
		$short_message = '<td class="notice_des" data-noticetype="join"><p>';
		
		switch($pattern) {
			case 'user_group':
				$html .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has joinded to group '. $val['group'] .' at ' . date('h:i a') . '</p>';
				$short_message .= '<a href="'. $_BASE .'users/view/'. $ids['user_id'] .'">'. $vals['user'] .'</a> has  joinded to group <a href="'. $_BASE .'groups/view/'. $ids['group_id'] .'">'. $vals['group'].'</a>.';				
			break;
			
			case 'user_project':
				$html .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has joined to project <a href="'. $_BASE .'projects/view/'. $ids['project_id'] .'">'. $vals['project'] .'</a> at '. date('h:i a') . '</p>';	
				$short_message .= '<a href="'. $_BASE . 'users/view/'. $ids['user_id'] .'">'. $vals['user'] .'</a> has  joinded to project <a href="'. $_BASE . 'projects/view/'. $ids['project_id'] .'">'. $vals['project'].'</a>.';
			break;
			
			case 'user_task':
				$html .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has joined to <a href="'. $_BASE .'tasks/view/'. $ids['task_id'] .'">'. $vals['task'] .'</a> task at ' . date('h:i a') . '</p>';
				$short_message .= '<a href="'. $_BASE .'users/view/'. $ids['user_id'] .'">'. $vals['user'] .'</a> has  joinded to <a href="'. $_BASE .'tasks/view/'. $ids['task_id'] .'">'. $vals['task'].'</a>.';
			break;
			
		}
		
		$html .= '</div>';
		$short_message .= '</p></td>';
		return array('message' => htmlspecialchars($html), 'short_message' => htmlspecialchars($short_message), 'notice_type' => 'join');
	}
	
	/*
	*	generate HTML block for edit
	*/
	
	private function _get_edit_html_block($config = array()) {
	
		/*				<user_id>_edit_<user2_id>
		*				<user_id>_edit_<task_id>
		*				<user_id>_edit_<project_id>
		*				<user_id>_edit_<document_id>
		*/
		
		$_BASE = '../';
		$config = $this->notice_config;
		$keys = array_keys($config['values']);
		$pattern = implode('_', $keys);
		$ids = $config['ids'];
		$vals = $config['values'];
		if(!empty($vals['document'])) {
			$doctype = $this->_get_file_type($vals['document']);
		}
		
		$html = '<div class="notice_block notice_edit" data-notice="edit">';
		$short_message = '<td class="notice_des" data-noticetype="edit"><p>';
		
		switch($pattern) {
			case 'user_document':
				$html .= '<p><a href="'. $_BASE . 'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has edited '. $doctype['type'] .' at ' . date('h:i a') . '</p>';
				$url = ($doctype['type'] == 'image') ? $_BASE .'img/imagecache/'. $vals['document'] : $_BASE .'documents/view/'. $ids['document_id'] .'?name='. $doctype['name'].'&ext='. $doctype['ext'];
				$short_message .= '<a href="'. $_BASE .'users/view/'. $ids['user_id'] .'">'. $vals['user'] .'</a> has edited <a href="'. $url .'">'. $vals['document'].'</a>';
			break;
			
			case 'user_user2':
				$html .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has edited <a href="'. $_BASE .'users/view/'. $ids['user2_id'] .'">'. $vals['user2'] .'</a> at '. date('h:i a') . '</p>';
				$short_message .= '<a href="'. $_BASE .'users/view/'. $ids['user_id'] .'">'. $vals['user'] .'</a> has edited <a href="'. $_BASE .'users/view/'. $ids['user2_id'] .'">'. $vals['user2'].'</a>';								
			break;
			
			case 'user_task':
				$html .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has edited <a href="'. $_BASE .'tasks/view/'. $ids['task_id'] .'">'. $vals['task'] .'</a> task at ' . date('h:i a') . '</p>';
				$short_message .= '<a href="'. $_BASE .'users/view/'. $ids['user_id'] .'">'. $vals['user'] .'</a> has edited <a href="'. $_BASE .'tasks/view/'. $ids['task_id'] .'">'. $vals['task'].'</a>';
			break;
			
			case 'user_project':
				$html .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has edited project <a href="'. $_BASE .'projects/view/'. $ids['project_id'] .'">'. $vals['project'] .'</a> at ' . date('h:i a') . '</p>';
				$short_message .= '<a href="'. $_BASE .'users/view/'. $ids['user_id'] .'">'. $vals['user'] .'</a> has edited project <a href="'. $_BASE .'projects/view/'. $ids['project_id'] .'">'. $vals['project'].'</a>';
			break;
		}
		
		if(!empty($doctype) ) {
			if($doctype['type'] == 'image') {
				$html .= '<p style="margin-top: 10px;vertical-align: middle"><img src="img/imagecache/'. $vals['document'] .'" height="173"></p>';
			} else {
				$html .= '<p style="margin-top: 10px;vertical-align: middle><a href="documents/view/'. $ids['document_id'] .'?name='. $doctype['name'].'&ext='. $doctype['ext'] .'">'. $vals['document'].'</a></p>';
			}
		}
		$html .= '</div>';
		$short_message .= '</p></td>';
		return array('message' => htmlspecialchars($html), 'short_message' => htmlspecialchars($short_message), 'notice_type' => 'edit');
	}
	
	/*
	*	generate HTML block for delete
	*/
	
	private function _get_delete_html_block($config = array()) {
	
		/*				<user_id>_delete_<user2_id>
		*				<user_id>_delete_<task_id>
		*				<user_id>_delete_<project_id>
		*				<user_id>_delete_<document_id>
		*/
		
		$_BASE = '../';
		$config = $this->notice_config;
		$keys = array_keys($config['values']);
		$pattern = implode('_', $keys);
		$ids = $config['ids'];
		$vals = $config['values'];
		if(!empty($vals['document'])) {
			$doctype = $this->_get_file_type($vals['document']);
		}
		
		$html = '<div class="notice_block notice_delete" data-notice="delete">';
		$short_message = '<td class="notice_des" data-noticetype="delete"><p>';
		
		switch($pattern) {
			case 'user_document':
				$html .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has deleted file '. $vals['document'] .' at ' . date('h:i a') . '</p>';
				$short_message .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has deleted file '. $vals['document'] . '</p>';
			break;
			
			case 'user_user2':
				$html .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has deleted user '. $vals['user2'] .' at '. date('h:i a') . '</p>';				
				$short_message .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has deleted user '. $vals['user2'] . '</p>';				
			break;
			
			case 'user_task':
				$html .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has deleted '. $vals['task'] .'</a> task at ' . date('h:i a') . '</p>';
				$short_message .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has deleted '. $vals['task'] . ' task</p>';
			break;
			
			case 'user_project':
				$html .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has deleted project '. $vals['project'] .' at ' . date('h:i a') . '</p>';
				$short_message .= '<p><a href="'. $_BASE .'users/view/'. $ids['user_id'].'">'. $vals['user'] .'</a> has deleted project '. $vals['project'] . '</p>';
			break;
		}

		$html .= '</div>';
		$short_message .= '</p></td>';
		return array('message' => htmlspecialchars($html), 'short_message' => htmlspecialchars($short_message), 'notice_type' => 'delete');
	}
	
	/*
	*
	*			This is the CORE function 
	*			to generate NOTICE message
	*			for a valid notice HANDLER
	*
	*/
	
	public function add_notice ($config = array()) {
	
		/**
		*	Default values of notice type (notice HANDLER)
		*	and their possbile combinations
		*
		*	[many more will be added later]
		*	==============================================
		*
		*	1.	comment:
		*			possbile combinations:
		*			--------------------------
		*				<user_id>_comment_to_<document_id>
		*				<user_id>_comment_to_<folder_id>
		*				<user_id>_comment_to_<task_id>
		*				<user_id>_comment_to_<project_id>
		*
		*		
		*	2.	add:
		*			possbile combinations:
		*			--------------------------
		*				<user_id>_add_<user2_id>
		*				<user_id>_add_<task_id>
		*				<user_id>_add_<project_id>
		*				<user_id>_add_<document_id>
		*			
		*
		*	3.	share:
		*			possbile combinations:
		*			--------------------------
		*				<user_id>_share_<document_id>_with_<user2_id>
		*				<user_id>_share_<document_id>_with_<project_id>
		*				<user_id>_share_<document_id>_with_<task_id>
		*				<user_id>_share_<document_id>_with_<group_id>
		*				<user_id>_share_<task_id>_with_<user2_id>
		*				<user_id>_share_<task_id>_with_<project_id>
		*				<user_id>_share_<task_id>_with_<calendar_event_id>
		*
		*
		*	4.	join:
		*			possbile combinations:
		*			--------------------------
		*				<user_id>_join_to_<grop_id>
		*				<user_id>_join_to_<project_id>
		*				<user_id>_join_to_<task_id>
		*
		*
		*	5.	edit:
		*			possbile combinations:
		*			--------------------------
		*				<user_id>_edit_<user2_id>
		*				<user_id>_edit_<task_id>
		*				<user_id>_edit_<project_id>
		*				<user_id>_edit_<document_id>
		*
		*
		*	6.	delete:
		*			possbile combinations:
		*			--------------------------
		*				<user_id>_delete_<user2_id>
		*				<user_id>_delete_<task_id>
		*				<user_id>_delete_<project_id>
		*				<user_id>_delete_<document_id>
		*
		*	NOTE:
		*	========
		*		Notice types must be spelled correctly and
		*		for each combination id field noted within <....._id>
		*		are necessary......... :)
		*		Otherwise it will throw exception......... :(
		*
		*	How to use this method:
		*	===========================
		*
		*	$config = array (
		*				'notice_type' => <correctly_spelled_notice_type>,
		*
		*				'ids' => array(
		*							// required ids for possbile combination
		*						),
		*
		*				'values' => array(
		*							// corresponding value of aboves id fields
		*						)
		*			);
		*
		*	Example:
		*	------------
		*		Suppose, "Brayn Potts"<user_id= 1> comment to a document named 
		*		"Test_doc.docx"<document_id=2> then $config will look like:
		*
		*	$config = array (
		*				'notice_type' => 'share',
		*
		*				'ids' => array(
		*							'user_id' => 1
		*							'document_id' => 3,
		*							'user2_id' => 2
		*						),
		*
		*				'values' => array(
		*							'user' => 'Bryan Potts',
		*							'document' => 'Test_doc.docx',	// File name must be with extension
		*							'user2' => 'Abdullah Yousuf'
		*						)
		*			);
		*	
		*	NOTE:
		*	=========
		*		`key` for `values` array will be the field name
		*		without `_id`. eg:
		*		--------------------|-----------------------
		*			ids				|		values
		*		--------------------|----------------------
		*			user_id			|		user
		*			document_id		|		document
		*			user2_id		|		user2
		*		calendar_event_id	|		calendarEvent // exception
		*
		*	and so on.
		*/		
		
		$this->autoRender = false;		
		$config = array (
						'notice_type' => 'share',
						'ids' => array (
							'user_id' => 1,
							'document_id' => 81,
							'user2_id' => 3,
							//'project_id' => 1,
							//'task_id' => 1
						),						
						'values' => array(
							'user' => 'Abdullah Yousuf',
							'document' => '3-81.jpg',
							'user2' => 'Bryan Potts',
							//'project' => 'Project 1',
							//'task' => 'Task 1'
						)
					);
		$this->notice_config = $config;
		$notice_type = $config['notice_type'];
		
		if( !$notice_type ) {
			throw new NotFoundException(__('Invalid notice type'));
			return false;
		} else {
			$method = '_' . $notice_type;
			call_user_func(array($this, $method));
		}
	}
	
	/*
	*	Generate comment block
	*/
	private function _comment($config = array()) {
		$to_save = $this->_get_comment_html_block();
		$this->notice_save($to_save);
	}
	
	/*
	*	Generate add block
	*/
	private function _add($config = array()) {
		$to_save = $this->_get_add_html_block();
		$this->notice_save($to_save);
	}
	
	/*
	*	Generate share block
	*/
	private function _share($config = array()) {
		$to_save = $this->_get_share_html_block();
		$this->notice_save($to_save);
	}
	
	/*
	*	Generate join block
	*/
	private function _join($config = array()) {
		$to_save = $this->_get_join_html_block();
		$this->notice_save($to_save);
	}
	
	/*
	*	Generate edit block
	*/
	private function _edit($config = array()) {
		$to_save = $this->_get_edit_html_block();
		$this->notice_save($to_save);
	}
	
	/*
	*	Generate delete block
	*/
	private function _delete($config = array()) {
		$to_save = $this->_get_delete_html_block();
		$this->notice_save($to_save);
	}
	
	/*
	*	get file type
	*/
	private function _get_file_type ($file_name = null) {
		$file = array('type' => 'file', 'ext' => 'pdf');
		if( !empty($file_name) ) {
			$arr = explode('.', $file_name);
			$name = $arr[0];
			$ext = $arr[count($arr)-1];
			$imageExt = array('png', 'jpg', 'jpeg', 'gif');
			if( in_array($ext, $imageExt) ) {
				$file['type'] = 'image';
				$file['name'] = $name;
			}
		}
		$file['ext'] = $ext;
		return $file;
	}
	
	/*
	*	Save Notice
	*/
	
	public function notice_save($to_save = array()) {
		$data = array();
		$data['Notice'] = am( $this->notice_config['ids'], $to_save );
		$this->Notice->create();
		$this->Notice->save($data, false);
	}
	
}
