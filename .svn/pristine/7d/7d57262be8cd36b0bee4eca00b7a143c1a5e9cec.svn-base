<?php
App::uses('AppController', 'Controller');

class ProjectsUsersController extends AppController {

	public function index() {
		$this->ProjectsUser->recursive = 0;
		$this->set('projectsUsers', $this->paginate());
	}

	public function view($id = null) {
		$this->ProjectsUser->id = $id;
		if (!$this->ProjectsUser->exists()) {
			throw new NotFoundException(__('Invalid projects user'));
		}
		$this->set('projectsUser', $this->ProjectsUser->read(null, $id));
	}

	public function add() {
		$this->autoRender = false;
		$result = array('status' => 'n');

		if($this->request->is('ajax') && $this->request->is('post') && !empty($this->request->data)) {
			$data = array(
				array(
					'ProjectsUser' => $this->request->data['ProjectsUser']
				),
				array(
					array('Share' => array('project_id' => $this->request->data['Share']['project_id'], 'user_id' => $this->request->data['Share']['user_id'], 'user2_id' => $this->request->data['Share']['user2_id'], 'is_admin' => $this->request->data['Share']['is_admin'])),
					array('Share' => array('folder_id' => $this->request->data['Share']['folder_id'], 'user_id' => $this->request->data['Share']['user_id'], 'user2_id' => $this->request->data['Share']['user2_id'])),
				)
			);;
			$this->ProjectsUser->create();
			/**
			*	Create a Notice for
			*	User who added to project
			*/
			$this->loadModel('Notice');
			$notice = array();
			$auth_name = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
			$user_accessed_this_project = $this->ProjectsUser->User->findById($this->request->data['ProjectsUser']['user_id']);
			$display = '';
			if($user_accessed_this_project['User']['first_name']) {
				$display = $user_accessed_this_project['User']['first_name'] . ' ' . $user_accessed_this_project['User']['last_name'];
			} else {
				$display = $user_accessed_this_project['User']['email'];
			}
			$time = date('g:ia');
			$notice['Notice']['user_id'] = $this->Auth->user('id');
			$notice['Notice']['projects_user_id'] = $this->ProjectsUser->id;
			$notice['Notice']['notice_type'] = 'project_accessed';
			$notice['Notice']['short_message'] = htmlspecialchars('<div class="notice_block"><div class="pill project_accessed">Project Accessed</div><div class="the_notice"><span class="time"> | '. $time .'</span> By <strong>'. $display .'</strong></div></div>');
			$this->Notice->create();
			$this->Notice->save($notice, false);
			/**
			*	Create Notice block end
			*/
				
			$this->ProjectsUser->Project->Share->create();
			if( $this->ProjectsUser->save($data[0], false) && $this->ProjectsUser->Project->Share->saveMany($data[1], array('validate' => false))) {
				$result['status'] = 'y';
			}
		}
		echo json_encode($result);
	}

	public function edit($id = null) {
		$this->ProjectsUser->id = $id;
		if (!$this->ProjectsUser->exists()) {
			throw new NotFoundException(__('Invalid projects user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ProjectsUser->save($this->request->data)) {
				$this->Session->setFlash(__('The projects user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The projects user could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->ProjectsUser->read(null, $id);
		}
		$projects = $this->ProjectsUser->Project->find('list');
		$users = $this->ProjectsUser->User->find('list');
		$this->set(compact('projects', 'users'));
	}

	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->ProjectsUser->id = $id;
		if (!$this->ProjectsUser->exists()) {
			throw new NotFoundException(__('Invalid projects user'));
		}
		if ($this->ProjectsUser->delete()) {
			$this->Session->setFlash(__('Projects user deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Projects user was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function members(){
		$params1 = $this->params['pass'];
		
		$project_tasks = $this->ProjectsUser->project_tasks($params1[0]);
		$task_ids = Set::extract('/Task/id', $project_tasks);
		$project_subtasks = $this->ProjectsUser->task_subtasks($task_ids);
		$comments = $this->ProjectsUser->get_comments($params1[0]);
		
		$project_details = $this->ProjectsUser->project_details($params1[0]);
		$project_members = $this->ProjectsUser->project_members($params1[0]);
		$project_members_idx = Set::extract('/ProjectsUser/user_id', $project_members);
		$project_members_details = $this->ProjectsUser->project_members_details($project_members_idx);
		
		$tasks_types = $this->ProjectsUser->task_types();
		$tasks_statuses = $this->ProjectsUser->task_statuses();
		
		$this->set(compact('params1',
							'project_details',
							'project_members',
							'project_members_details',
							'project_tasks',
							'project_subtasks',
							'comments',
							'tasks_types',
							'tasks_statuses'
							));
	}
	
	public function members_tasks(){
		$params1 = $this->params['pass'];
		
		$project_tasks = $this->ProjectsUser->project_member_tasks($params1[0],$this->Auth->user('id'));
		$task_ids = Set::extract('/Task/id', $project_tasks);
		$project_subtasks = $this->ProjectsUser->task_subtasks($task_ids);
		$comments = $this->ProjectsUser->get_comments($params1[0]);
		
		$project_details = $this->ProjectsUser->project_details($params1[0]);
		$current_user = $this->Auth->user('id');
		$project_members = $this->ProjectsUser->project_members($params1[0]);
		$project_members_idx = Set::extract('/ProjectsUser/user_id', $project_members);
		$project_members_details = $this->ProjectsUser->project_members_details($project_members_idx);
		
		$tasks_types = $this->ProjectsUser->task_types();
		$tasks_statuses = $this->ProjectsUser->task_statuses();
		
		$this->set(compact('params1',
							'project_details',
							'project_members',
							'project_members_details',
							'project_tasks',
							'project_subtasks',
							'comments',
							'tasks_types',
							'tasks_statuses',
							'current_user'
							));
	}
	
	public function add_project_member($project_id=null) {
		if($this->request->is('ajax')) {
			$auth_id = $this->Auth->user('id');
			$company_id = $this->Auth->user('Company.id');
			$the_project = $this->ProjectsUser->Project->get_a_project_detail($project_id, $auth_id);
			if(!$project_id) {
				$project_id = $the_project['Project']['id'];
			}
			$project_name = $the_project['Project']['name'];
			$project_member = $this->ProjectsUser->Project->User->get_members_to_add_project($auth_id, $company_id, $project_id);
			$this->set(compact('project_member', 'auth_id', 'project_id', 'company_id', 'project_name', 'the_project'));
			$this->render('add_project_member', false);
		}
	}
}
