<?php
App::uses('AppController', 'Controller');

class GroupsController extends AppController {

	public function index() {
		
	}
	
	public function create_group() {
		$result = array('status' => 'n', 'group_id' => '');
		$this->autoRender=false;
		$user_id=$this->Auth->user('id');
		$company_id=$this->Auth->user('company_id');
		$this->request->data['Group']['user_id']=$user_id;
		$this->request->data['Group']['company_id']=$company_id;
		if ($this->request->is('post')) {
			$this->Group->create();
			if ($this->Group->save($this->request->data)) {
				$result['group_id'] = $this->Group->id;
				$result['status'] = 'y';
			}
		}
		echo json_encode($result);
	}
	
	public function add_group(){
		$this->autoRender=false;
		$user_id=$this->Auth->user('id');
		$company_id=$this->Auth->user('company_id');
		$this->request->data['Group']['user_id']=$user_id;
		$this->request->data['Group']['company_id']=$company_id;
		if ($this->request->is('post')) {
			$this->Group->create();
			if ($this->Group->save($this->request->data)) {
				echo json_encode('Group Added');
			} else {
				echo json_encode(array('error'=>'The group could not be saved. Please try again.'));
			}
		}
	}
	
	public function edit_group($group_id){
		$this->autoRender=false;
		$user_id=$this->Auth->user('id');
		$company_id=$this->Auth->user('company_id');
		$this->request->data['Group']['user_id']=$user_id;
		$this->request->data['Group']['company_id']=$company_id;
		$this->Group->id=$group_id;
		/*
		if(!isset($this->request->data['Group']['is_for_account_users'])){
			$this->request->data['Group']['is_for_account_users']=0;
		}
		if(!isset($this->request->data['Group']['has_smart_filing_category'])){
			$this->request->data['Group']['has_smart_filing_category']=0;
		}*/
		unset($this->request->data['Group']['is_for_account_users']);
		$this->Group->save($this->request->data);
		if($this->Group->save($this->request->data)) {
			echo json_encode(__('The group has been saved'));
		}else{
			echo json_encode(array('error'=>'The group could not be saved. Please try again.'));
		}
	}
	
	public function delete_group($group_id){
		$this->autoRender=false;
		if($this->Group->delete($group_id, true)){
			echo json_encode(__('The group has been deleted'));
		}else{
			echo json_encode(array('error'=>'The group could not be deleted. Please try again.'));
		}
	}
	
	public function get_groups(){
		$this->autoRender=false;
		$user_id=$this->Auth->user('id');
		$groups=$this->Group->list_user_created_groups($user_id);
		echo json_encode($groups);
	}
	
	public function get_info($group_id){
		$this->autoRender=false;
		$group_info=$this->Group->get_info($group_id);
		echo json_encode($group_info['Group']);
	}
	
	
	public function create_group_folder(){
		$this->autoRender=false;
		$user_id=$this->Auth->user('id');
		$company_id=$this->Auth->user('company_id');
		$group_id=(int)$this->request->data['group_id'];
		$parent_id=(int)$this->request->data['folder_id'];
		unset($this->request->data['folder_id']);
		
		$group_info=$this->Group->get_info($group_id);
		$group_name=$group_info['Group']['name'];

		$this->request->data['Folder']['user_id']=$user_id;
		$this->request->data['Folder']['parent_id']=$parent_id;
		$this->request->data['Folder']['name']=$group_name;
		
		if ($this->Group->Folder->save($this->request->data)) {
			$folder_id = $this->Group->Folder->id;
			$share_data=array();
			$share_data['Share']['folder_id']=$folder_id;
			$share_data['Share']['user_id']=$user_id;
			$share_data['Share']['group_id']=$group_id;
			$share_data['Share']['access']='project_manager';
			if($this->Group->Share->save($share_data)){
				echo json_encode('Folder Created');
				Cache::clear();
			}else{
				echo json_encode(array('error'=>'The folder was created but an error has occured when applying permission.'));
			}
		} else {
			echo json_encode(array('error'=>'The folder could not be created. Please try again.'));
		}
	}
	
	public function get_folder_id($group_id){
		$this->autoRender=false;
		$current_user_id=$this->Auth->user('id');
		$row=$this->User->Share->find('first',
			array(
				'fields' => array('Share.folder_id'),
				'conditions' => array(
					'Share.user_id' => $current_user_id,
					'Share.user2_id' => 0,
					'Share.contact_id' => 0,
					'Share.group_id' => $group_id,
					'NOT' => array('Share.folder_id' => 0)
				)
			)
		);
		return empty($row)?0:$row['Share']['folder_id'];
	}
 
}
