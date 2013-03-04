<?php
App::uses('AppController', 'Controller');

class UsersGroupsController extends AppController {

	public function index() {
		
	}

	public function add_multi(){
		$this->autoRender=false;
		$user_id=$this->Auth->user('id');
		$company_id=$this->Auth->user('company_id');
		$group_id=$this->request->data['group_id'];
		$data=array();
		for($i=0,$iCount=count($this->request->data['user_ids']);$i<$iCount;$i++){
			$user_id=$this->request->data['user_ids'][$i];
			if(!$this->UsersGroup->is_unique($group_id, $user_id)){
				continue;
			}
			$data[]=array(
				'group_id' => $group_id,
				'user_id' => $user_id
			);
		}
		
		//print_r($data);
		
		if($this->UsersGroup->saveAll($data)){
			echo json_encode(count($data).' Users Added to Group');
		}else{
			echo json_encode(array('error'=>'The users could not be added to the group. Please try again.'));
		}
	}
	
	public function delete_multi(){
		$this->autoRender=false;
		$user_id=$this->Auth->user('id');
		$company_id=$this->Auth->user('company_id');
		$group_id=$this->request->data['group_id'];
		$data=array();
		for($i=0,$iCount=count($this->request->data['user_ids']);$i<$iCount;$i++){
			$user_id=$this->request->data['user_ids'][$i];
			if($this->UsersGroup->is_unique($group_id, $user_id)){
				continue;
			}
			$data[]=$user_id;
		}
		
		if($this->UsersGroup->deleteAll(array(
			'UsersGroup.group_id' => $group_id,
			'UsersGroup.user_id' => $data
		))){
			echo json_encode(count($data).' Users Removed from Group');
		}else{
			echo json_encode(array('error'=>'The users could not be removed from the group. Please try again.'));
		}
	}
	
	public function get_group_users($group_id){
		json_encode($this->User->UsersGroup->get_group_users($group_id));
	}
}
