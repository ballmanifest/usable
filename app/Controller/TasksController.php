<?php
App::uses('AppController', 'Controller');

class TasksController extends AppController {

	public function index() {
		$this->Task->recursive = 0;
		$this->set('tasks', $this->paginate());
	}

	public function view($id = null) {
		$this->Task->id = $id;
		if (!$this->Task->exists()) {
			throw new NotFoundException(__('Invalid task'));
		}
		$this->set('task', $this->Task->read(null, $id));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->Task->create();
			if ($this->Task->save($this->request->data)) {
				$this->Session->setFlash(__('The task has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The task could not be saved. Please, try again.'));
			}
		}
		$users = $this->Task->User->find('list');
		$this->set(compact('users'));
	}

	public function edit($id = null) {
		$this->Task->id = $id;
		if (!$this->Task->exists()) {
			throw new NotFoundException(__('Invalid task'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Task->save($this->request->data)) {
				$this->Session->setFlash(__('The task has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The task could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Task->read(null, $id);
		}
		$users = $this->Task->User->find('list');
		$this->set(compact('users'));
	}

	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Task->id = $id;
		if (!$this->Task->exists()) {
			throw new NotFoundException(__('Invalid task'));
		}
		if ($this->Task->delete()) {
			$this->Session->setFlash(__('Task deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Task was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function update_task() {
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Task->save($this->request->data)) {
				$this->Session->setFlash(__('The task has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The task could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Task->read(null, $id);
		}
		 $this->autoRender = false;
	}
	
	
	public function get_resources_tasks(){
        $this->loadModel("Comment");
		$args = func_get_args();
		$view=@$args[0];
		$viewed_id=(int)@$args[1];
                $order_by=@$args[2];
                
		if($viewed_id==0){
                        $order_by=$view;
			$view='';
		}
		if($order_by=="")
                 { 
                 $order_by="created";  
                  }
		$current_company_id=$this->Auth->user('company_id');
		$current_user_id=$this->Auth->user('id');
		$this->autoRender=false;
			
		if($view=='member'){
			$tasks=$this->Task->find('all',
				array(
					 'recursive' => -1,
					'conditions'=>array(
						'Task.ownerid'=>$viewed_id
					),
					'order'=>array(
						'Task.'.$order_by.' DESC'
					)
				)
			);
		}else if($view=='project'){
			$tasks=$this->Task->find('all',
				array(
					 'recursive' => -1,
					'conditions'=>array(
						'Task.project_id'=>$viewed_id
					),
					'order'=>array(
						'Task.'.$order_by.' DESC'
					)
				)
			);
		}else{
			$tasks=$this->Task->find('all',
				array(
					'recursive' => -1,
					'conditions'=>array(
						'Task.company_id'=>$current_company_id
					),
                                     
					'order'=>array(
						'Task.'.$order_by.' DESC'
					)
				)
			);                  
           
		} 
		
		$tasks_ids=array();
		for($i=0,$iCount=count($tasks);$i<$iCount;$i++){
			$tasks_ids[]=$tasks[$i]['Task']['id'];
		}
		$subtasks=$this->Task->Subtask->find('all',
			array(
				'recursive' => -1,
				'conditions'=>array(
					'Subtask.task_id'=>$tasks_ids
				),
				'order'=>array(
					'Subtask.order'
				)
			)
		);
		
		$users=$this->Task->User->find('all',
			array(
				'fields'=>array('User.id','User.first_name','User.last_name'),
				'recursive' => -1,
				'conditions'=>array(
					'User.company_id'=>$current_company_id
				),
				'order'=>array(
					'User.first_name'
				)
			)
		);

		$documents=$this->Task->Share->find('all',
			array(
			'fields'=>array('Share.id','Share.task_id','Document.*'),
			'conditions'=>array(
			'Share.task_id'=>$tasks_ids
			),
		  )
		);
		echo json_encode(array('tasks'=>$tasks,'subtasks'=>$subtasks,'users'=>$users,'documents'=>$documents));
	}
	
	public function save_task(){
		$this->autoRender=false;
		$current_company_id=$this->Auth->user('company_id');
		$current_user_id=$this->Auth->user('id');
		$files=array();
		if(isset($this->request->data['Files']))
		{
		$files=$this->request->data['Files'];
		unset($this->request->data['Files']);
		}
		$task_id=(int)@$this->request->data['Task']['id'];
		if($task_id==0){
			unset($this->request->data['Task']['id']);
			$this->Task->create();
			$this->request->data['Task']['user_id']=$current_user_id;
			$this->request->data['Task']['company_id']=$current_company_id;
		}
                // check if  project id there or not
               if(isset($this->request->data['Task']['project_id']) && empty($this->request->data['Task']['project_id']))
               {
                   $this->request->data['Task']['project_id']=0;
               }
		if ($this->Task->save($this->request->data)) {
			$task_id=$this->request->data['Task']['id']=$this->Task->id;
			/**
			* Attach Document with task
			*/
			
			if(count($files)>0)
			{  
 			   $this->loadModel("Folder");	
               $project_id=0;
               if(isset($this->request->data['Task']['project_id'])){			   
			   $project_id=$this->request->data['Task']['project_id'];
			   }
			   if($project_id==""){$project_id=0;}
			   $folderDetail=$this->Folder->find('first', array('conditions'=>array('Folder.project_id' => $project_id)));
				
				$fileNames=$files['org_filename'];
				$tmp_names=$files['tmp_filename'];
				$fileTypes=$files['type'];
			    $folrderid=1;
            	if(!empty($folderDetail)){$folrderid=$folderDetail['Folder']['id'];}		
				
			    for($i=0;$i<count($fileNames);$i++)
				{
				  $docId= $this->upload_files($fileNames[$i],$folrderid,$current_user_id,$fileTypes[$i],$tmp_names[$i]);
				  $data=array();
				   $data['project_id']=$project_id;
				   $data['document_id']=$docId;
				   $data['task_id']=$task_id;
				   $data['folder_id']=$folrderid;
				   $data['user_id']=$current_user_id;
				   $data['user2_id']=$this->request->data['Task']['ownerid'];
				   $this->loadModel("Share");
				  	   $this->Share->create();
				   $this->Share->save($data);
				}
			}
			
			
			/**
			*	Create a Notice when
			*	New Task Added 
			*/
			$this->loadModel('Notice');
			$notice = array();
			$auth_name = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
			$time = date('g:ia');
			$notice['Notice']['user_id'] = $this->Auth->user('id');
			$notice['Notice']['task_id'] = $task_id;
			$notice['Notice']['notice_type'] = 'task_created';
			$notice['Notice']['short_message'] = htmlspecialchars('<div class="notice_block"><div class="pill task_created">Task Created</div><div class="the_notice"><span class="time"> | '. $time .'</span><strong>'. $this->request->data['Task']['title'] .'</strong> By <strong>'. $auth_name .'</strong></div></div>');
			$this->Notice->create();
			$this->Notice->save($notice, false);
			/**
			*	Create Notice block end
			*/
			
			if((int)$this->request->data['Task']['status'] == 3) {
				/**
				*	Create a notice when task has finished
				*	ie. Task status = 3
				*/
				$this->loadModel('Notice');
				$notice = array();
				$this->loadModel('User');
				$task_completer = $this->User->findById($this->request->data['Task']['requesterid']);
				$display = '';
				if($task_completer['User']['first_name']) {
					$display = $task_completer['User']['first_name'] . ' ' . $task_completer['User']['last_name'];
				} else {
					$display = $task_completer['User']['email'];
				}
				$time = date('g:ia');
				$task_complete_notice['Notice']['user_id'] = $this->Auth->user('id');
				$task_complete_notice['Notice']['task_id'] = $task_id;
				$task_complete_notice['Notice']['notice_type'] = 'task_completed';
				$task_complete_notice['Notice']['short_message'] = htmlspecialchars('<div class="notice_block"><div class="pill task_completed">Task Completed</div><div class="the_notice"><span class="time"> | '. $time .'</span><strong>'. $this->request->data['Task']['title'] .'</strong> By <strong>'. $display .'</strong></div></div>');
				$this->Notice->create();
				$this->Notice->save($task_complete_notice, false);
			}
			$subtasks=$this->Task->Subtask->find('all',
				array(
					'recursive' => -1,
					'conditions'=>array(
						'Subtask.task_id'=>$task_id
					),
					'order'=>array(
						'Subtask.order'
					)
				)
			);
			
			$documents=$this->Task->Share->find('all',
			array(
			'fields'=>array('Share.id','Share.task_id','Document.*'),
			'conditions'=>array(
			'Share.task_id'=>$task_id
			),
			)
			);
			echo json_encode(array(
				'success'=>1,
				'message'=>'Task Saved',
				'data'=>array('task'=>$this->request->data['Task'],'subtasks'=>$subtasks,'documents'=>$documents)
			));
			
		} else {
			echo json_encode(array(
				'success'=>0,
				'message'=>'The task could not be saved. Please try again.'
			));
		}
		
	}
	
	public function get_task($task_id){
		$this->autoRender=false;
		$current_company_id=$this->Auth->user('company_id');
		$current_user_id=$this->Auth->user('id');
		$tasks=$this->Task->find('first',
			array(
				'recursive' => -1,
				'conditions'=>array(
					'Task.id'=>$task_id,
					'Task.company_id'=>$current_company_id
				),
				'order'=>array(
					'Task.order DESC'
				)
			)
		);
		
		$subtasks=$this->Task->Subtask->find('all',
			array(
				'recursive' => -1,
				'conditions'=>array(
					'Subtask.task_id'=>$task_id
				),
				'order'=>array(
					'Subtask.order'
				)
			)
		);
		
		$users=$this->Task->User->find('all',
			array(
				'fields'=>array('User.id','User.first_name','User.last_name'),
				'recursive' => -1,
				'conditions'=>array(
					'User.company_id'=>$current_company_id
				),
				'order'=>array(
					'User.first_name'
				)
			)
		);
		
		echo json_encode(array('task'=>$tasks['Task'],'subtasks'=>$subtasks,'activities'=>array(),'users'=>$users));
	}
	
	public function save_tasks_order(){
		$this->autoRender=false;
		$current_company_id=$this->Auth->user('company_id');
		$current_user_id=$this->Auth->user('id');
		
		$order=$this->request->data['order'];
		$order=array_reverse($order);
		
		for($i=0,$iCount=count($order);$i<$iCount;$i++){
			$this->Task->id=$order[$i];
			$this->Task->saveField('order', $i);
		}
		
	}
	
	public function save_subtasks(){
		$this->autoRender=false;
		$current_company_id=$this->Auth->user('company_id');
		$current_user_id=$this->Auth->user('id');
		
		$task_id=$this->request->data['Task']['id'];
		
		$subtasks=&$this->request->data['subtasks'];
		if(!is_array($subtasks)){
			$subtasks=array();
		}
		
		foreach($subtasks as $key=>$subtask){
			$subtasks[$key]['Subtask']['task_id']=$task_id;
			$subtasks[$key]['Subtask']['is_checked']=isset($subtasks[$key]['Subtask']['is_checked'])?1:0;
			if($subtasks[$key]['Subtask']['id']==0){
				unset($subtasks[$key]['Subtask']['id']);
			}
		}
		
		$subtasksDelete=@$this->request->data['delete_subtask'];
		if(is_array($subtasksDelete)){
			$this->Task->Subtask->deleteAll(array(
				'Subtask.task_id'=>$task_id,
				'Subtask.id'=>$subtasksDelete
			));
		}
		
		if($this->Task->Subtask->saveMany($subtasks)){
			
		}
	}
	
	public function add_subtask(){
		$this->autoRender=false;
		$current_company_id=$this->Auth->user('company_id');
		$current_user_id=$this->Auth->user('id');
		
		$this->Task->Subtask->create();
		if ($this->Task->Subtask->save($this->request->data)) {
			echo json_encode(array('success'=>1,'id'=>$this->Task->Subtask->id));
		}
	}
	public function add_documents(){
	
	
	$fileNames=$_FILES['images']['name'];
	$tmp_names=$_FILES['images']['tmp_name'];
	$fileTypes=$_FILES['images']['type'];
	//$fileSize=$_FILES['images']['size'];
	$html="";
	   for($i=0;$i<count($fileNames);$i++)
	   {   
	       $ext=explode('.',$fileNames[$i]);
		   $ext=$ext[count($ext)-1];
		   $tname=$i.md5(time()).'.'.$ext;
		   $imgsrc="/uploads/".$tname;
		   if(!in_array(strtolower($ext), array('jpg', 'jpeg', 'png', 'gif'))) {
		   $imgsrc="/img/".$ext.".png";
		   }
		   $html.="<div class='main_dv_t'>";
		   $html.="<div class='home_icon'><img width='30px' src='".$imgsrc."' /></div><div class='normal_txt'>".$fileNames[$i]."</div>";
  	       if (move_uploaded_file($tmp_names[$i], ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.'uploads'.DS.$tname)) 
		   { 
		     
		      $html.="<input type='hidden' name='data[Files][org_filename][]' value='".$fileNames[$i]."'>";
			  $html.="<input type='hidden' name='data[Files][tmp_filename][]' value='".$tname."'>";
			  $html.="<input type='hidden' name='data[Files][type][]' value='".$fileTypes[$i]."'>";			 
			  $html.="<div class='message_txt'>Sucess</div>";
		   }
		   else
		   {
		    $html.="<div class='error_txt'>Error!</div>";		  
		   }
		    $html.="<div><a href='javascript:void(0);' onclick='jQuery(this).parent().parent().remove();'><img src='/img/icon-cross.png' /></a></div></div>";			 
	   }
	   echo $html;
	   exit;
		
	}
	
	public function upload_files($name,$folderid,$user_id,$doctype,$tmpname)
	{
	            $data=array();
				$this->loadModel("Document");				
				//..$folderid=$_POST["folder_id"];
				$ext=explode('.',$name);
				
				$ext=(count($ext)>1?$ext[count($ext)-1]:'');
				$name=str_replace('.'.$ext,'',$name);
				$oldfile=$this->Document->find('first', array('conditions'=>array('Document.folder_id' => $folderid,'Document.name' =>$name,'Document.is_latest'=>'Y')));									
				$newversion=1;
				if(!empty($oldfile))
				{
				$data["version_document_id"]=$oldfile['Document']['version_document_id'];
				$newversion=intval($oldfile['Document']['version'])+1;
				//update previous latest 
				$this->Document->updateAll(array('is_latest'=>"'N'"),array('version_document_id'=>$oldfile['Document']['version_document_id']));
				
				/**
				*	Create a Notice when any
				*	version update happen
				*/
				$this->loadModel('Notice');
				$notice = array();
				$auth_name = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
				$time = date('g:ia');
				$notice['Notice']['user_id'] = $this->Auth->user('id');
				$notice['Notice']['document_id'] = $oldfile['Document']['id'];
				$notice['Notice']['notice_type'] = 'new_file_version';
				$notice['Notice']['short_message'] = htmlspecialchars('<div class="notice_block"><div class="pill new_file_version">New Version</div><div class="the_notice"><span class="time"> | '. $time .'</span><strong>'. $oldfile['Document']['name'] .'</strong> From <strong>'. $auth_name .'</strong></div></div>');
				$this->Notice->create();
				$this->Notice->save($notice, false);
				/**
				*	Create Notice block end
				*/
				
				}

				$data["name"]=$name;
				$data["folder_id"]=$folderid;
				$data["user_id"]=$user_id;
				$data["version"]=$newversion;
				$data["ext"]=$ext;
				$data["size"]=intval(filesize(ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.'uploads'.DS.$tmpname )/1024);	
			    
				$data["type"]=$doctype;
				$this->Document->create();
				$this->Document->save($data);
				/**
				*	Create a Notice when New
				*	new File added
				*/
				if(empty($oldfile))
				{
				$this->loadModel('Notice');
				$notice = array();
				$auth_name = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
				$time = date('g:ia');
				$notice['Notice']['user_id'] = $this->Auth->user('id');
				$notice['Notice']['document_id'] = $this->Document->id;
				$notice['Notice']['notice_type'] = 'new_file_added';
				$getDocName = $name;
				$notice['Notice']['short_message'] = htmlspecialchars('<div class="notice_block"><div class="pill new_file_added">New File</div><div class="the_notice"><span class="time"> | '. $time .'</span>To <strong>'. $getDocName .'</strong> By <strong>'. $auth_name .'</strong></div></div>');
				$this->Notice->create();
				$this->Notice->save($notice, false);
				}
				/**
				*	Create Notice block end
				*/
				$newid = $this->Document->getLastInsertId();
				$this->Document->id = $newid;
			
				$renamedFile=$folderid."-".$newid.".".$ext;
				$data["file"]=$renamedFile;
				if($newversion==1){
					$data["version_document_id"]=$newid;
				}
				$this->Document->save($data);
				
				$this->set('documents',  $this->Document->read());
							
				copy(ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.'uploads'.DS.$tmpname , ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.'img'.DS . "imagecache" .DS .  $renamedFile); 
				/////Upload to Crocodoc
				if(in_array(strtolower($ext), array('doc', 'docx', 'pdf'))) {
				$local_url = ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.'img'.DS . "imagecache" .DS .  $renamedFile;
				$this->_uploadToCrocodoc($local_url, $newid);
				}				
				unlink(ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.'uploads'.DS.$tmpname);	
               return $newid;				
		 }
		
	
}
