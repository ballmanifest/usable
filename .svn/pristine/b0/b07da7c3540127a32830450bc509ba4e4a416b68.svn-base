<?php
App::uses('AppController', 'Controller');

class FoldersController extends AppController {

	public function index() {
		
	}
	
	public function list_folder_contents(){
		$this->autoRender=false;
		$user_id=$this->Auth->user('id');
		$parent_id=$this->request->data['parent_id'];
		$folders=$this->Folder->listFolderContents($parent_id, $user_id);
		$list=array();
		foreach($folders as $i=>$folder){
			$arr = array(); // Array for each Node's Data
			$arr['attr']['id'] = 'node_'.$i;
			$arr['attr']['name'] = $folder;
			$arr['data']  = $folder;
			$arr['state'] = 'closed';
			$list[] = $arr;
		}
		echo json_encode($list);
	}
	
	public function comments($id = 0) {
        if($id) {
            $this->loadModel("Comment");
			$auth_id = $this->Auth->user('id');
			$guest_id = !empty($this->request->named['guest']) ? $this->request->named['guest'] : '';
			$title = 'Folder';
			$comment_for = 'folder_id';
			$target_id = $id;
			$FolderComments =  $this->Comment->find("all", array("conditions"=>array("Comment.folder_id"=>$id)));
            $this->set(compact("FolderComments", "auth_id", "title", "comment_for", "target_id", "guest_id"));
            $this->render("ajax_comments", false);
        }
    }
	
	public function addComment() {
        $authId = $this->Auth->user("id");
        if($this->request->is('ajax') && !empty($this->request->data)) {
            $this->loadModel("Comment");
			$this->request->data['Comment']['user_id'] = $this->Auth->user('id');
            $this->Comment->save($this->request->data);
            $newId = $this->Comment->getLastInsertId();
			/**
			*	Create a Notice when New
			*	Comment Added to Folder
			*/
			$this->loadModel('Notice');
			$notice = array();
			$auth_name = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
			$time = date('g:ia');
			$notice['Notice']['user_id'] = $this->Auth->user('id');
			$notice['Notice']['comment_id'] = $newId;
			$notice['Notice']['notice_type'] = 'new_comment';
			$getFolderName = $this->Folder->field('name', array('Folder.id' => $this->request->data['Comment']['folder_id']));
			$notice['Notice']['short_message'] = htmlspecialchars('<div class="notice_block"><div class="pill new_comment">New Comment</div><div class="the_notice"><span class="time"> | '. $time .'</span>To <strong>'. $getFolderName .'</strong> By <strong>'. $auth_name .'</strong></div></div>');
			$this->Notice->create();
			$this->Notice->save($notice, false);
			/**
			*	Create Notice block end
			*/
            $this->set("isNewAdded",true);
            $this->set("FolderComments", $this->Comment->find("all", array("conditions"=>array("Comment.id"=>$newId))));
            $this->render("ajax_comments", false);
        }
    }
}
