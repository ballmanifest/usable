<?php
App::uses('AppController', 'Controller');

class ContactsGroupsController extends AppController {

	public function index() {
		
	}

	public function save_contacts_groups() {
		$this->autoRender=false;
		$user_id=$this->Auth->user('id');
		$company_id=$this->Auth->user('company_id');
		$result['status'] = 'n';

		if($this->request->is('post') && !empty($this->request->data)) {
			if($this->ContactsGroup->saveMany($this->request->data, array('validate' => false))) {
				$result['status'] = 'y';
			}
		}
		echo json_encode($result);
	}
	
	public function add_multi(){
		$this->autoRender=false;
		$user_id=$this->Auth->user('id');
		$company_id=$this->Auth->user('company_id');
		$group_id=$this->request->data['group_id'];
		$data=array();
		for($i=0,$iCount=count($this->request->data['contact_ids']);$i<$iCount;$i++){
			$contact_id=$this->request->data['contact_ids'][$i];
			if(!$this->ContactsGroup->is_unique($group_id, $contact_id)){
				continue;
			}
			$data[]=array(
				'group_id' => $group_id,
				'contact_id' => $contact_id
			);
		}
		
		//print_r($data);
		
		if($this->ContactsGroup->saveAll($data)){
			echo json_encode(count($data).' Contacts Added to Group');
		}else{
			echo json_encode(array('error'=>'The contacts could not be added to the group. Please try again.'));
		}
	}
	
	public function delete_multi(){
		$this->autoRender=false;
		$user_id=$this->Auth->user('id');
		$company_id=$this->Auth->user('company_id');
		$group_id=$this->request->data['group_id'];
		$data=array();
		for($i=0,$iCount=count($this->request->data['contact_ids']);$i<$iCount;$i++){
			$contact_id=$this->request->data['contact_ids'][$i];
			if($this->ContactsGroup->is_unique($group_id, $contact_id)){
				continue;
			}
			$data[]=$contact_id;
		}
		
		if($this->ContactsGroup->deleteAll(array(
			'ContactsGroup.group_id' => $group_id,
			'ContactsGroup.contact_id' => $data
		))){
			echo json_encode(count($data).' Contacts Removed from Group');
		}else{
			echo json_encode(array('error'=>'The contacts could not be removed from the group. Please try again.'));
		}
	}
	
	public function get_group_contacts($group_id){
		json_encode($this->Contact->ContactsGroup->get_group_contacts($group_id));
	}
}
