<?php
App::uses('AppController', 'Controller');

class ContactsController extends AppController {

	public function index() {
		
	}

	public function view($what,$arg2=null,$arg3=null){
		$this->autoRender = false;
		$user_id=$this->Auth->user('id');
		$company_id=$this->Auth->user('company_id');
		$data=array('list'=>array(),'name'=>'','purpose'=>'');
		
		$tbl='Contact';
		if($what=='account-users' || ($what=='group' && $arg3=='users')){
			$tbl='User';
		}
		
		$sort=array();
		
		if($this->request->data['sort']=='first_name'){
			$sort=array(
				$tbl.'.first_name'=>'ASC',
				$tbl.'.last_name'=>'ASC',
				$tbl.'.email'=>'ASC'
			);
		}else{
			$sort=array(
				$tbl.'.last_name'=>'ASC',
				$tbl.'.first_name'=>'ASC',
				$tbl.'.email'=>'ASC'
			);
		}
		
		$keyword='';
		if(!empty($this->request->data['filter'])){
			$keyword=$this->request->data['filter'];
			$filter=array(
				'OR' => array(
					$tbl.'.last_name LIKE'=>$keyword.'%',
					$tbl.'.first_name LIKE'=>$keyword.'%',
					$tbl.'.email LIKE'=>$keyword.'%'
				)
			);
		}else{
			$filter=array();
		}
		if($what=='account-users'){
			$data['name']='Account Users';
			$data['purpose']='Account Users is a listing of all users sharing this Filocity account.';
			$data['list']=$this->Contact->User->get_account_users($company_id, $sort, $filter);
			//print_r($data['list']);
		}else if($what=='shared-contacts'){
			$data['name']='Shared Contacts';
			$data['purpose']='Shared Contacts is a listing of all people and businesses that are available to all the users of this account.';
			$data['list']=$this->Contact->get_shared_contacts($user_id, $company_id, $sort, $filter);
		}else if($what=='private-contacts'){
			$data['name']='My Private Contacts';
			$data['purpose']='My Private Contacts is a listing of people and businesses you have added to the system but who are visible only to you.';
			$data['list']=$this->Contact->get_private_contacts($user_id, $company_id, $sort, $filter);
		}else if($what=='group'){
			$group_id=(int)$arg2;
			$group_for=$arg3;
			
			$data=$this->Contact->Group->get_info($group_id);
				$group_folder=$this->Contact->Share->find('first',
					array(
						'fields' => array('Share.folder_id'),
						'conditions' => array(
							'Share.user_id' => $user_id,
							'Share.user2_id' => 0,
							'Share.contact_id' => 0,
							'Share.group_id' => $group_id,
							'NOT' => array('Share.folder_id' => 0)
						)
					)
				);
			$data['Group']['folder_id']=empty($group_folder)?0:$group_folder['Share']['folder_id'];

			if($group_for=='users'){
				$data=$data['Group'];
				$data['list']=$this->Contact->Group->UsersGroup->get_group_users($group_id, $sort, $filter);
			}else{
				$data=$data['Group'];
				$data['list']=$this->Contact->ContactsGroup->get_group_contacts($group_id, $sort, $filter);
			}
			//print_r($data);
		} elseif($what == 'all-members-contacts') {
			$data['name']='Members, Contacts';
			$data['purpose']='All Contacts ans memebers';
			$data['list']=$this->Contact->get_all_contacts_and_members($user_id,$company_id, $sort, $filter);
		} else {
			$data['name']='All Contacts';
			$data['purpose']='All Contacts is a listing of people and businesses that you have imported as well as contacts that other account users have added and made available to all account users.';
			$data['list']=$this->Contact->get_all_contacts($user_id,$company_id, $sort, $filter);
		}
		
		echo json_encode($data);
	}
	
	public function get_contact_info($contact_id){
		$this->autoRender=false;
		$user_id=$this->Auth->user('id');
		$company_id=$this->Auth->user('company_id');
		$info=$this->Contact->get_contact_info($user_id, $contact_id);
		$info[0]['Contact']['country']=$this->Contact->Country->get_name($info[0]['Contact']['country_id']);
		$info[0]['Contact']['country']=$info[0]['Contact']['country']['Country']['name'];
		$info[0]['Contact']['state']=$this->Contact->State->get_name($info[0]['Contact']['state_id']);
		$info[0]['Contact']['state']=$info[0]['Contact']['state']['State']['name'];
		$info[0]['Share']['folder_id']=$this->get_folder_id($contact_id);
		echo json_encode($info);
	}
	
	public function add_contact(){
		$this->autoRender=false;
		$user_id=$this->Auth->user('id');
		$company_id=$this->Auth->user('company_id');
		if ($this->request->is('post')) {
			$this->request->data['Contact']['user_id']=$user_id;
			$this->request->data['Contact']['company_id']=$company_id;
			$this->request->data['Contact']['state_id']=(int)$this->request->data['Contact']['state_id'];
			$this->request->data['Contact']['country_id']=(int)$this->request->data['Contact']['country_id'];
			$this->request->data['Contact']['user_id2']=(int)$this->request->data['Contact']['user_id2'];
			$this->Contact->create();
			if ($this->Contact->save($this->request->data)) {
				echo json_encode('Contact Added');
			} else {
				echo json_encode(array('error'=>'The contact could not be saved. Please try again.'));
			}
		}
	}
	
	public function edit_contact($contact_id){
		$this->autoRender=false;
		$user_id=$this->Auth->user('id');
		$company_id=$this->Auth->user('company_id');
		if ($this->request->is('post')) {
			unset($this->request->data['Contact']['user_id']);
			unset($this->request->data['Contact']['company_id']);
			unset($this->request->data['Contact']['contact_id']);
			unset($this->request->data['Contact']['created']);
			//print_r($this->request->data);
			if ($this->Contact->updateAll(
				array(
						'Contact.first_name' => '"'.@$this->request->data['Contact']['first_name'].'"',
						'Contact.last_name' => '"'.@$this->request->data['Contact']['last_name'].'"',
						'Contact.email' => '"'.@$this->request->data['Contact']['email'].'"',
						'Contact.company_name' => '"'.@$this->request->data['Contact']['company_name'].'"',
						'Contact.job_title' => '"'.@$this->request->data['Contact']['job_title'].'"',
						'Contact.job_position' => '"'.@$this->request->data['Contact']['job_position'].'"',
						'Contact.street_1' => '"'.@$this->request->data['Contact']['street_1'].'"',
						'Contact.street_2' => '"'.@$this->request->data['Contact']['street_2'].'"',
						'Contact.city' => '"'.@$this->request->data['Contact']['city'].'"',
						'Contact.state_id' => '"'.(int)@$this->request->data['Contact']['state_id'].'"',
						'Contact.zip' => '"'.@$this->request->data['Contact']['zip'].'"',
						'Contact.country_id' => '"'.(int)@$this->request->data['Contact']['country_id'].'"',
						'Contact.photo' => '"'.@$this->request->data['Contact']['photo'].'"',
						'Contact.work_phone' => '"'.@$this->request->data['Contact']['work_phone'].'"',
						'Contact.mobile_phone' => '"'.@$this->request->data['Contact']['mobile_phone'].'"',
						'Contact.home_phone' => '"'.@$this->request->data['Contact']['home_phone'].'"',
						'Contact.toll_free_phone' => '"'.@$this->request->data['Contact']['toll_free_phone'].'"',
						'Contact.work_fax' => '"'.@$this->request->data['Contact']['work_fax'].'"',
						'Contact.website' => '"'.@$this->request->data['Contact']['website'].'"',
						'Contact.user_id2' => '"'.(int)@$this->request->data['Contact']['user_id2'].'"',
						'Contact.contact_type' => '"'.@$this->request->data['Contact']['contact_type'].'"'
				),
				array(
					'Contact.id' => $contact_id,
					'Contact.user_id' => $user_id,
					'Contact.company_id' => $company_id,
				)
			)) {
				echo json_encode('Contact Updated');
			} else {
				echo json_encode(array('error'=>'The contact could not be updated. Please try again.'));
			}
		}
	}

	
	public function share_multi(){
		$this->autoRender=false;
		$user_id=$this->Auth->user('id');
		$company_id=$this->Auth->user('company_id');
		//print_r($this->request->data);
		
		if($this->Contact->updateAll(
			array(
				'Contact.contact_type' => 1
			),
			array(
				'Contact.user_id' => $user_id,
				'Contact.company_id' => $company_id,
				'Contact.id' => $this->request->data['contact_ids'],
			)
		)){
			echo json_encode('Contacts Shared');
		}else{
			echo json_encode(array('error'=>'The contacts could not be shared. Please try again.'));
		}
		
	}
	
	public function delete_multi(){
		$this->autoRender=false;
		$user_id=$this->Auth->user('id');
		$company_id=$this->Auth->user('company_id');
		//print_r($this->request->data);
		
		if($this->Contact->deleteAll(
			array(
				'Contact.user_id' => $user_id,
				'Contact.company_id' => $company_id,
				'Contact.id' => $this->request->data['contact_ids'],
			),
			true //also delete dependent records
		)){
			echo json_encode('Contacts Deleted');
		}else{
			echo json_encode(array('error'=>'The contacts could not be deleted. Please try again.'));
		}
	}
	
	public function import_contacts($from){
		$this->autoRender=false;
		$user_id=$this->Auth->user('id');
		$company_id=$this->Auth->user('company_id');
		if($from=='outlook_csv'){
			$tmp_file=$this->request->data['Contact']['outlook_csv']['tmp_name'];
			if(!is_uploaded_file($tmp_file)){
				json_encode(array('error'=>'The contacts could not be imported. Please try again.'));
				return;
			}
			$csv=explode("\n",file_get_contents($tmp_file));
			$csvHeaders=explode(',',$csv[0]);
			$csvHeadersIndex=array();
			for($i=0,$csvHeadersCount=count($csvHeaders);$i<$csvHeadersCount;$i++){
				$csvHeadersIndex[trim($csvHeaders[$i])]=$i;
			}
			
			$data=array();
			
			for($i=1,$csvLinesCount=count($csv);$i<$csvLinesCount;$i++){

				if(empty($csv[$i])){
					continue;
				}

				$csvInfo=explode(',',trim($csv[$i]));
				
				$info=array(
					'first_name' => @$csvInfo[@$csvHeadersIndex['First Name']],
					'last_name' => @$csvInfo[@$csvHeadersIndex['Last Name']],
					'email' => @$csvInfo[@$csvHeadersIndex['E-mail Address']],
					'company_name' => @$csvInfo[@$csvHeadersIndex['Company']],
					'job_title' => @$csvInfo[@$csvHeadersIndex['Job Title']],
					'street_1' => @$csvInfo[@$csvHeadersIndex['Business Street']],
					'state_id' => (int)$this->Contact->State->get_id(@$csvInfo[@$csvHeadersIndex['Business State']]),
					'country_id' => (int)$this->Contact->Country->get_id(@$csvInfo[@$csvHeadersIndex['Business Country/Region']]),
					'city' => @$csvInfo[@$csvHeadersIndex['Business City']],
					'zip' => @$csvInfo[@$csvHeadersIndex['Business Postal Code']],
					'work_phone' => @$csvInfo[@$csvHeadersIndex['Business Phone']],
					'mobile_phone' => @$csvInfo[@$csvHeadersIndex['Mobile Phone']],
					'home_phone' => @$csvInfo[@$csvHeadersIndex['Home Phone']],
					'work_fax' => @$csvInfo[@$csvHeadersIndex['Business Fax']],
					'user_id' => $user_id,
					'company_id' => $company_id
				);
				if(!empty($csvHeadersIndex['Personal Web Page'])){
					$info['website'] = @$csvInfo[@$csvHeadersIndex['Personal Web Page']];
				}
				$data[]=$info;
			}
			//print_r($data);die;
			
			if($this->Contact->saveMany($data, array('validate'=>false))){
				echo json_encode('Contacts imported');
			}else{
				echo json_encode('Contacts not imported');
			}
			
		}
	
	}
	
	
	public function create_contact_folder(){
		$this->autoRender=false;
		$user_id=$this->Auth->user('id');
		$company_id=$this->Auth->user('company_id');
		$contact_id=(int)$this->request->data['contact_id'];
		$parent_id=(int)$this->request->data['folder_id'];
		unset($this->request->data['folder_id']);
		
		$contact_info=$this->Contact->get_contact_info($user_id, $contact_id);
		$contact_email=$contact_info[0]['Contact']['email'];
		$this->request->data['Folder']['user_id']=$user_id;
		$this->request->data['Folder']['parent_id']=$parent_id;
		$this->request->data['Folder']['name']=$contact_email;
		
		if ($this->Contact->Folder->save($this->request->data)) {
			$folder_id = $this->Contact->Folder->id;
			$share_data=array();
			$share_data['Share']['folder_id']=$folder_id;
			$share_data['Share']['user_id']=$user_id;
			$share_data['Share']['contact_id']=$contact_id;
			$share_data['Share']['access']='member';
			if($this->Contact->Share->save($share_data)){
				echo json_encode('Folder Created');
				Cache::clear();
			}else{
				echo json_encode(array('error'=>'The folder was created but an error has occured when applying permission.'));
			}
		} else {
			echo json_encode(array('error'=>'The folder could not be created. Please try again.'));
		}
	}
	
	
	public function get_contact_groups($contact_id){
		$this->autoRender=false;
		$user_id=$this->Auth->user('id');
		$company_id=$this->Auth->user('company_id');
		$groups=$this->Contact->ContactsGroup->get_contact_groups($contact_id,$user_id);
		echo json_encode($groups);
	}
	
	
	public function get_contact_shares($contact_id){
		
	}
	
	public function get_folder_id($contact_id){
		$this->autoRender=false;
		$current_user_id=$this->Auth->user('id');
		$row=$this->Contact->Share->find('first',
			array(
				'fields' => array('Share.folder_id'),
				'conditions' => array(
					'Share.user_id' => $current_user_id,
					'Share.contact_id' => $contact_id,
					'Share.group_id' => 0,
					'NOT' => array('Share.folder_id' => 0)
				)
			)
		);
		return empty($row)?0:$row['Share']['folder_id'];
	}
	
	public function contact_modal() {
		$this->render('contact_modal');
	}
	
	public function import() {
		$this->autoRender = false;
		$result['status'] = 'n';
		if($this->request->is('ajax') && $this->request->is('post') && !empty($this->request->data['Contact'])) {
			// thi line is important.  this will work just like import in core php 
			App::import('Vendor', 'openinviter', array('file' => 'openinviter'.DS.'openinviter.php')); 
				 
			$inviter = new OpenInviter(); 

			$oi_services = $inviter->getPlugins(); 
			
			$inviter->startPlugin($this->request->data['Contact']['contact_type']);  
			// supply a file name with ought .php in the parameter. you will fine the files in the "vendors/openinviter/plugins/" In the Plugins you will find all the files which communicate with the respected services to fatch data. you will pass google, yahoo etc.

			// it will return error if any 
			$internal = $inviter->getInternalError(); 	
			
			// this is use for login in to services just like gmail.com account 1st. parameter take login id and 2nd. parameter takes password
			$inviter->login($this->request->data['Contact']['email'], $this->request->data['Contact']['password']); 
			
			
			// this will return the array which contain all the email address from the account you want to fetch. 
			$contacts = $inviter->getMyContacts(); 
			$data = array();
			$counter = 0;
			foreach($contacts as $email => $contact) {
				$data[$counter]['Contact'] = array('email' => $email, 'user_id' => $this->Auth->user('id'));
				$counter++;
			}
			if($this->Contact->saveMany($data)) {
				$result['status'] = 'y';
				echo json_encode($result);
			}
		}
	}
}
