<?php
App::uses('AppController', 'Controller');

class SharesController extends AppController {

	public $project_to_update = null;

	public function index() {
		$user_id = $this->Auth->user('id');
		$this->Share->Project->Behaviors->attach('Containable');
		$projects_detail = $this->Share->Project->find('all', 
													array(
													'fields' => array(
														'Project.name','Project.id', 'Project.visibility'
													),
													'conditions' => array(
														'Project.user_id' => $user_id
													),
													'contain' => array(
														'Share' => array(
															'fields' => array('Share.id', 'Share.user2_id', 'Share.access'),
															'conditions' => array (
																					'OR' => array ( 
																							'Share.access' => array('member', 'project_manager')
																						)
																				),
															'User' => array (
																'fields' => array('User.id', 'User.first_name', 'User.last_name')
															)
														)
													)
												)
											);	
		$visibilities = $this->Share->Project->get_project_visibilities();
		$this->set(compact(array('projects_detail', 'visibilities'))); 
	}
	public function search_project_member() {
		if ($this->RequestHandler->isAjax()) {
			$this->autoLayout = false;
			$this->autoRender = false;
			$this->Share->User->recursive = -1;
			$results = $this->Share->User->find('all', 
											array(
												'fields' => array('User.id', 'User.first_name', 'User.last_name'),
												'conditions' => array(
													'first_name LIKE "%'.$_GET['term'].'%"',
													'User.company_id' => $this->Auth->user('company_id')
												)
											)
										);
			$response = array();
			$i = 0;
			foreach($results as $result){
				$response[$i]['value'] = $result['User']['first_name']. ' ' . $result['User']['last_name'];
				$response[$i]['id'] = $result['User']['id'];
				$i++;
			}
			echo json_encode($response);
		}
	}
	public function add_new_manager(){
		$this->autoRender = false;
		if($this->request->is('ajax') && !empty($this->request->data)){
			$user2_id = $this->request->data['User']['id'];
			$project_id = $this->request->data['Project']['id'];
			$manager_data = array(
							'Share' => array(
										'user_id' => $user2_id,
										'user2_id' => $this->Auth->User('id'),
										'project_id' => $project_id,
										'access' => 'project_manager'
									)
							);
			$check_manager = $this->Share->find('all', 
										array(
											'recursive' => -1,
											'fields' => array('Share.id'),
											'conditions' => array(
												'Share.project_id' => $project_id,
												'Share.user2_id' => $this->Auth->user('id'),
												'Share.access' => 'project_manager'
												)
											)
										);
			if(count($check_manager) >= 0){
				$this->Share->id = Set::extract('/Share/id', $check_manager);
				$this->Share->delete($this->Share->id);	
				if($this->Share->save($manager_data)){
					$managerInfo = $this->Share->User->find('all', 
															array(
																'recursive' => -1,
																'fields' => array('User.first_name', 'User.last_name', 'User.id'),
																'conditions' =>array('User.id' => $user2_id)
																)
															);
					echo json_encode($managerInfo);
				}
			} else{
				echo json_encode('exist');
			}				
		}
	}
	
	private function _anyone_with_project_link() {
		$this->autoRender = false;
		
		$user_id = $this->Auth->user('id');
		$company_id = $this->Auth->user('company_id');
		$members_list = $this->Share->any_one_with_project_link($this->project_to_update);
		
		$task = array();
		
		for($i = 0; $i < count($members_list); $i++){
			$count = 0;
			if(count($members_list[$i]['Task']) != 0){
				for($j = 0; $j < count($members_list[$i]['Task']); $j++){
					$task[$i][] = $members_list[$i]['Task'][$j]['id'];
					$count++;
				}
			}
			if($count > 0){ 
				$active = $this->Share->Project->Task->get_active_tasks($task[$i]);
			}	
			unset($members_list[$i]['Task']);
			$members_list[$i]['Task']['count'] = $count;
			if($count == 0){
				$members_list[$i]['Task']['active'] = 0;
			} else{
				$members_list[$i]['Task']['active'] = count($active);
			}
		}
		return $members_list;
	}
	
		
	private function _only_company_members() {
		
	}
	
	private function _only_some_groups() {

	}
	
	private function _only_some_members() {
	
	}
	
	private function _all_groups_members_except() {
	
	}
	
	private function _delete_cur_rows() {
		$project_id = $this->project_to_update;
		return $this->Share->delete_cur_rows($project_id);
	}
	
	public function update_modal() {
		$result = array('status' => 'n');
		$this->autoRender = false;
		if( $this->request->is('ajax') && $this->request->is('post') && !empty($this->request->data['Share']['vistype']) && !empty($this->request->data['Share']['project_id']) ) {
			$method = '_' . $this->request->data['Share']['vistype'];
			$this->project_to_update = $this->request->data['Share']['project_id'];
			$data = call_user_func(array($this, $method));
			if( $this->_delete_cur_rows() ) {
				$data = call_user_func(array($this, $method));
				$result['status'] = 'y';
				$result['data'] = $data;
			}
			$this->project_to_update = null;
		}
		echo json_encode($result);
	}
	
	public function add_new_permission(){
		$this->autoRender = false;
		if(!empty($this->request->data)){
			$user2_id = $this->request->data['User']['id'];
			$project_id = $this->request->data['Project']['id'];
			$share_data = array(
							'Share' => array(
										'user_id' => $user2_id,
										'user2_id' => $this->Auth->User('id'),
										'project_id' => $project_id,
										'access' => 'member'
									)
							);	
			$check_member = $this->Share->find('all', 
										array(
											'conditions' => array(
												'Share.project_id' => $project_id,
												'Share.user_id' => $user2_id
												)
											)
										);
								
			if(count($check_member) == 0){
				if($this->Share->save($share_data)){
					$memberInfo = $this->Share->User->find('all', 
															array(
																'recursive' => -1,
																'fields' => array('User.first_name', 'User.last_name', 'User.id'),
																'conditions' =>array('User.id' => $user2_id)
																)
															);
					echo json_encode($memberInfo);
				}
			} else{
				echo json_encode('exist');
			}
		}
	}
	public function delete_permission(){
		$this->autoRender = false;
		if($this->request->is('ajax') && !empty($this->request->data)){
			$user_id = $this->request->data['User']['id'];
			$share_id = $this->request->data['Share']['id'];
			$this->Share->id = $share_id;	
			if($this->Share->delete()){
					echo json_encode(array('Status' => 'ok'));
			}	
		}
	}
	public function view($id = null) {
		$this->Share->id = $id;
		if (!$this->Share->exists()) {
			throw new NotFoundException(__('Invalid task'));
		}
		$this->set('task', $this->Share->read(null, $id));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->Share->create();
			if ($this->Share->save($this->request->data)) {
				$this->Session->setFlash(__('The task has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The task could not be saved. Please, try again.'));
			}
		}
		$users = $this->Share->User->find('list');
		$this->set(compact('users'));
	}

	public function edit($id = null) {
		$this->Share->id = $id;
		if (!$this->Share->exists()) {
			throw new NotFoundException(__('Invalid task'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Share->save($this->request->data)) {
				$this->Session->setFlash(__('The task has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The task could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Task->read(null, $id);
		}
		$users = $this->Share->User->find('list');
		$this->set(compact('users'));
	}

	public function delete($id = null) {
		$result = array('status' => 'n');
		if($this->request->is('ajax') && !empty($id)) {
			$this->autoRender = false;
			$this->Share->id = $id;
			if( $this->Share->delete() ) {
				$result['status'] = 'y';
			}
			echo json_encode($result);
		} else {
			if (!$this->request->is('post')) {
				throw new MethodNotAllowedException();
			}
			$this->Share->id = $id;
			if (!$this->Share->exists()) {
				throw new NotFoundException(__('Invalid task'));
			}
			if ($this->Share->delete()) {
				$this->Session->setFlash(__('Task deleted'));
				$this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Task was not deleted'));
			$this->redirect(array('action' => 'index'));
		}
	}
	
	public function update_share() {
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Share->save($this->request->data)) {
				$this->Session->setFlash(__('The task has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The task could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Share->read(null, $id);
		}
		 $this->autoRender = false;
	}
	
	public function get_share_info(){
		$id = $this->Auth->user('id');
		$user_access = $this->Share->user_access($id);
	}
	
	/** 
	*	Add Share from File Cab
	*	by Folder / document share modal
	*/
	
	public function add_share() {
		$this->autoRender = false;
		$result = array('status' => 'n');

		if( $this->request->is('ajax') && $this->request->is('post') && !empty($this->request->data)) {
			$arr = array();
			$data = $this->request->data;
			if($this->Share->save_shares($data)) {
				$result['status'] = 'y';
			}
		}
		echo json_encode($result);
	}
	
	private function _is_guest_exists($guest_email) {
		$this->Share->User->recursive = -1;
		$isExists = $this->Share->User->findByEmail($guest_email);
		return $isExists;
	}
	
	public function get_all_shares_listing($shareType = null, $itemId = null, $item_name=null) {
		$this->autoRender = false;
		$result = '';
		
		if($shareType && $itemId) {
			$conditions[$shareType . '_id'] = $itemId;
			$conditions['Share.user_id'] = $this->Auth->user('id');
			
			$shares = $this->Share->find('all',
										array(	
												'recursive' => -1,
												'conditions' => $conditions
											)
										);
			$html = '';

			foreach($shares as $index => $share) {
				$sh = $share['Share'];
				
				// Get Users
				/*
				if(!empty($sh['user2_id'])) {
					$da = $this->Share->User->find('first', array('recursive' => -1, 'conditions' => array('User.id' => $sh['user2_id']), 'fields' => array('id', 'first_name', 'last_name', 'email')));
					$target_name =  $da['User']['first_name'] . ' ' .  $da['User']['last_name'];
					$da_id = $da['User']['id'];
					$html .= $this->_parepare_share_row_for_modal('user2_id', $sh, $da_id, $shareType, $item_name, $itemId, $target_name);
				}*/
				
				// Get Emails
				if(!empty($sh['user2_id'])) {
					$da = $this->Share->User->find('first', array('recursive' => -1, 'conditions' => array('User.id' => $sh['user2_id']), 'fields' => array('id', 'first_name', 'last_name', 'email')));
					$target_name =  $da['User']['email'];
					$da_id = $da['User']['id'];
					$html .= $this->_parepare_share_row_for_modal('user2_id', $sh, $da_id, $shareType, $item_name, $itemId, $target_name);
				}
				
				// Get Tasks
				if(!empty($sh['task_id'])) {
					$da = $this->Share->Task->find('first', array('recursive' => -1, 'conditions' => array('Task.id' => $sh['task_id']), 'fields' => array('id', 'title')));
					$target_name =  $da['Task']['title'];
					$da_id = $da['Task']['id'];
					$html .= $this->_parepare_share_row_for_modal('task_id', $sh, $da_id, $shareType, $item_name, $itemId, $target_name);
				}
				
				// Get Projects
				if(!empty($sh['project_id'])) {
					$da = $this->Share->Project->find('first', array('recursive' => -1, 'conditions' => array('Project.id' => $sh['project_id']), 'fields' => array('id', 'name')));
					$target_name =  $da['Project']['name'];
					$da_id = $da['Project']['id'];
					$html .= $this->_parepare_share_row_for_modal('project_id', $sh, $da_id, $shareType, $item_name, $itemId, $target_name);
				}
				
				// Get Groups
				if(!empty($sh['group_id'])) {
					$da = $this->Share->Group->find('first', array('recursive' => -1, 'conditions' => array('Group.id' => $sh['group_id']), 'fields' => array('id', 'name')));
					$target_name =  $da['Group']['name'];
					$da_id = $da['Group']['id'];
					$html .= $this->_parepare_share_row_for_modal('group_id', $sh, $da_id, $shareType, $item_name, $itemId, $target_name);
				}
				
				// Get Calendar Event
				if(!empty($sh['calendar_event_id'])) {
					$da = $this->Share->CalendarEvent->find('first', array('recursive' => -1, 'conditions' => array('CalendarEvent.id' => $sh['calendar_event_id']), 'fields' => array('id', 'title')));
					$target_name =  $da['CalendarEvent']['title'];
					$da_id = $da['CalendarEvent']['id'];
					$html .= $this->_parepare_share_row_for_modal('calendar_event_id', $sh, $da_id, $shareType, $item_name, $itemId, $target_name);
				}
				
				// Get Contacts
				if(!empty($sh['contact_id'])) {
					$da = $this->Share->Contact->find('first', array('recursive' => -1, 'conditions' => array('Contact.id' => $sh['contact_id']), 'fields' => array('id', 'email')));
					$target_name =  $da['Contact']['email'];
					$da_id = $da['Contact']['id'];
					$html .= $this->_parepare_share_row_for_modal('contact_id', $sh, $da_id, $shareType, $item_name, $itemId, $target_name);
				}
			}
			$result = $html;
		}
		echo $result;
	}
	
	private function _parepare_share_row_for_modal($type, $sh, $da_id, $shareType, $item_name, $itemId, $target_name) {
		$snippet = '';
		$snippet .= '<tr data-type="'. $shareType .'" data-id="'. $itemId .'" data-shareid="'. $sh['id'] .'">';
		$snippet .=		'<td class="user_name">';
		$snippet .=			$target_name;
		$snippet .=			'<input type="hidden" readonly class="share_id" name="data[Share][id]" value="'. $sh['id'] .'">';
		$snippet .= 	'</td>';
		$snippet .= 	'<td>'. ucfirst($sh['item_shared']).'</td>';
		$snippet .= 	'<td>'. ($sh['is_printable'] ? 'Y' : 'N') .'</td>';
		$snippet .= 	'<td>'. ($sh['is_writable'] ? 'Y' : 'N') .'</td>';
		$snippet .= 	'<td>'. ($sh['is_downloadable'] ? 'Y' : 'N') .'</td>';
		$snippet .= 	'<td>'. ($sh['status'] ? 'Active' : 'Pending') .'</td>';
		$snippet .= 	'<td><a class="delete_icon" id="s_'. $sh['id'] .'"></a><a class="email_icon"></a></td>';
		$snippet .= '</tr>';
		return $snippet;
	}
	
	public function share_modal() {
		$auth_id = $this->Auth->user('id');
		$company_id = $this->Auth->user('company_id');
		$params = $this->request->named;
		$item_shared = '';
		
		if(!empty($params['type']) && !empty($params['id'])) {
			$type = $params['type'];
			$id = $params['id'];
			$item_key = $type . '_id';
			$item_key_val = $id;
			$itemDetail = array();
			$Model =  $item_shared = ucfirst($type);
			if($type == 'document') {
				$itemDetail = $this->Share->Document->findById($id);
			} else if($type == 'folder') {
				$itemDetail = $this->Share->Folder->findById($id);
			}
		}
		$existing_share_items = $this->Share->find('all',
										array(	
												'recursive' => -1,
												'conditions' => array('Share.' . $item_key => $id, 'Share.user_id' => $auth_id)
											)
										);
										
		if(is_bool($existing_share_items)) {
			$existing_share_items = array();
		}
		$is_share_exists = count($existing_share_items);
		$resultHtml = $this->Share->User->get_everything($auth_id, $company_id, null, $existing_share_items);
		$this->set(compact('resultHtml', 'auth_id', 'item_key', 'item_key_val', 'itemDetail', 'Model', 'item_shared', 'is_share_exists'));
		$this->render('share_modal');
	}
	
	public function refresh_share_autofill_list($item_key='', $item_id='') {
		$this->autoRender = false;
		$auth_id = $this->Auth->user('id');
		$company_id = $this->Auth->user('company_id');
		$existing_share_items = $this->Share->find('all',
										array(	
												'recursive' => -1,
												'conditions' => array('Share.' . $item_key => $item_id, 'Share.user_id' => $auth_id)
											)
										);
		if(is_bool($existing_share_items)) {
			$existing_share_items = array();
		}
		$resultHtml = $this->Share->User->get_everything($auth_id, $company_id, null, $existing_share_items);
		echo $resultHtml;
	}

}
