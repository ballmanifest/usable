<?php
App::uses('AppController', 'Controller');

class AccountsController extends AppController {
	
	var $uses = array('User', 'State');
	
	public function index() {
		$id = $this->Auth->user('id');
		$this->User->id = $id;
		$current_user_id=$id;
		
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if(!empty($this->request->data['User']['password']) && !empty($this->request->data['User']['confirm_password']) && ($this->request->data['User']['password'] === $this->request->data['User']['confirm_password']) ) {
				unset($this->request->data['User']['confirm_password']);
			} else if(empty($this->request->data['User']['password']) || (empty($this->request->data['User']['password']) && empty($this->request->data['User']['confirm_password']))){
				unset($this->request->data['User']['password'], $this->request->data['User']['confirm_password']);
			} else if( $this->request->data['User']['password'] !== $this->request->data['User']['confirm_password'] ) {
				$this->Session->setFlash(__('Password and Password repeat not match.'));
			}
			$profile_thumb_temp = @$this->request->data['User']['profile_thumb_temp'];
			unset($this->request->data['User']['profile_thumb_temp']); 
			if ($this->User->save($this->request->data, false)) {
				$user_id=$this->User->id;
				if(!empty($profile_thumb_temp)){
					$user_dir = WWW_ROOT . 'img' . DS . 'filocity_img' . DS . 'user_' .$this->User->id;
					$src = sys_get_temp_dir().DS.'uploads_temp'.DS.$profile_thumb_temp;
					$dest = $user_dir . DS . 'profile.jpg';
					if(!file_exists($user_dir)){
						mkdir($user_dir, 0700);
					}
					rename($src, $dest);
				}
				$this->Session->setFlash(__('You Account info has been updated'));
				$this->redirect(array('controller' => 'accounts', 'action' => 'index'));
			} else {
				$this->Session->setFlash(__('Your Account info could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
			$state = $this->State->find('list');
			unset($this->request->data['User']['password']);
			$this->set(compact('state'));
		}
		$this->set(compact('current_user_id'));
	}
	
	public function upload_photo(){
		$this->autoRender = false;
		$user_id=$this->Auth->user('id');
		if(empty($user_id)){
			echo json_encode(array('error'=>'Please login'));
			return;
		}
		if(!is_uploaded_file($_FILES['file']['tmp_name'])){
			echo json_encode(array('error'=>'Error uploading file'));
			return;
		}
		
		$timestamp=time();
		$ext=pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
		$temp_file_name=$timestamp.'.'.$ext;
		$user_temp_dir=WWW_ROOT.'/img/filocity_img/user_'.$user_id.'/tmp';
		@mkdir($user_temp_dir, 0700);
		move_uploaded_file($_FILES['file']['tmp_name'], $user_temp_dir.'/'.$temp_file_name);
		echo json_encode(array('user_id'=>$user_id,'filename'=>$temp_file_name));
	}
}
