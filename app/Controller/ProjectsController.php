<?php
App::uses('AppController', 'Controller');

class ProjectsController extends AppController {


	public function index() {
		$this->redirect(array('action' => 'view'));
		return false;
		$auth_id = $this->Auth->user('id');
		$company_id = $this->Auth->user('Company.id');
		$get_notices = $this->Project->get_project_notices($auth_id);
		$get_users_has_calendar = $this->get_users_has_calendar();
		$get_company_members = $this->Project->User->get_company_members($company_id);
		$this->set(compact('get_users_has_calendar','get_notices', 'auth_id', 'get_company_members'));
	}

	public function view($project_id = null) {
		$auth_id = $this->Auth->user('id');
		$company_id = $this->Auth->user('Company.id');
		$the_project = $this->Project->get_a_project_detail($project_id, $auth_id);
		if(!$project_id) {
			$project_id = $the_project['Project']['id'];
		}
		$get_users_has_calendar = $this->get_users_has_calendar();
		$get_company_members = $this->Project->User->get_members_to_add_project($auth_id, $company_id, $project_id);
		$active_projects = $this->Project->active_projects($auth_id);
		$project_id = $the_project['Project']['id'];
		$get_notices = $this->Project->get_project_notices($project_id);
		$get_project_members = $this->Project->get_project_members($project_id);
		$get_project_tasks = $this->Project->get_project_tasks($project_id);
		$get_project_files = $this->Project->get_project_files($project_id, $auth_id);
		$this->set(compact('project_id','get_users_has_calendar','get_notices', 'auth_id', 'get_company_members', 'the_project', 'active_projects', 'get_project_members', 'get_project_tasks', 'get_project_files', 'company_id'));
	}

	public function add($project_id = null) {
	    
		$new_project="";
		$this->layout = "modal";
		$auth_id = $this->Auth->user('id');
		$company_id = $this->Auth->user('Company.id');
		$the_project = $this->Project->get_a_project_detail($project_id, $auth_id);
		if(!$project_id) {
			$project_id = $the_project['Project']['id'];
		}
		$get_company_members = $this->Project->User->get_members_to_add_project($auth_id, $company_id, $project_id);
		if($this->request->is('post') && !empty($this->request->data)) {
			$this->request->data['Project']['start'] = date_format(new DateTime($this->request->data['Project']['date_start']), 'Y-m-d');
			$this->request->data['Project']['end'] = date_format(new DateTime($this->request->data['Project']['date_end']), 'Y-m-d');
			$this->request->data['Project']['user_id']=$auth_id;
			$this->Project->create();
			if( $this->Project->save($this->request->data)) {
			
				/**
				*	Create a Notice when
				*	New Project Created 
				*/
				$this->loadModel('Notice');
				$notice = array();
				$auth_name = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
				$time = date('g:ia');
				$notice['Notice']['user_id'] = $this->Auth->user('id');
				$notice['Notice']['project_id'] = $this->Project->id;
				$notice['Notice']['notice_type'] = 'project_created';
				$notice['Notice']['short_message'] = htmlspecialchars('<div class="notice_block"><div class="pill project_created">Project Created</div><div class="the_notice"><span class="time"> | '. $time .'</span><strong>'. $this->request->data['Project']['name'] .'</strong> By <strong>'. $auth_name .'</strong></div></div>');
				$this->Notice->create();
				$this->Notice->save($notice, false);
				/**
				*	Create Notice block end
				*/
				
				// Create a Folder for Project
				$project_folder = array(
					'Folder' => array(
						'user_id' => $this->Auth->user('id'),
						'project_id' => $this->Project->id,
						'name' => $this->request->data['Project']['name'],
						'status' => 1,
						'parent_id' => 0
					)
				);
				$this->Project->Folder->create();
				$this->Project->Folder->save($project_folder);
				// return result
				$result['status'] = 'y';
				$result['project_id'] = $this->Project->id;
				$result['Folder']['id'] = $this->Project->Folder->id;
				$new_project=$this->Project->id;
				
			}
		}
		$this->set(compact('get_company_members','new_project'));
	}

	public function edit($id = null) {
		$this->Project->id = $id;
		if (!$this->Project->exists()) {
			throw new NotFoundException(__('Invalid project'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Project->save($this->request->data)) {
				$this->Session->setFlash(__('The project has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The project could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Project->read(null, $id);
		}
		$users = $this->Project->User->find('list');
		$users = $this->Project->User->find('list');
		$this->set(compact('users', 'users'));
	}

	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Project->id = $id;
		if (!$this->Project->exists()) {
			throw new NotFoundException(__('Invalid project'));
		}
		if ($this->Project->delete()) {
			$this->Session->setFlash(__('Project deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Project was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function get_users_has_calendar() {
		$escape_user = $this->Auth->user('id');
		$company_id = $this->Auth->user('company_id');
		$get_users_has_calendar = $this->Project->User->CalendarEvent->get_users_has_calendar($escape_user, false, $company_id);
		return $get_users_has_calendar;
	}
	
	public function get_budget_data() {
		$data = array(40, 87, 20, 36);
		$this->set('data');
	}
	
	public function get_project_notice() {
		$notices = $this->Project->get_notices();
	}

}
