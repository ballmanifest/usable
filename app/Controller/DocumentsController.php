<?php
App::uses('AppController', 'Controller');

class DocumentsController extends AppController {

	public function index() {
		$this->Document->recursive = 0;
		$this->set('documents', $this->paginate());
	}

	public function view () {
		$viewer_info = array();
		if(!empty($this->request->params['named'])) {
		
			$params = $this->request->params['named'];
			$doc_id = $params['id'];
			
			$viewer_info = array();
			$doc_info = array();
			$owner = true;
			
			$auth_id = $this->Auth->user('id');
			$role = intval($this->Auth->user('role'));
			
			$doc_detail = $this->Document->findByIdAndUserId($doc_id, $auth_id);
			$share_info = array();
			
			if(!$doc_detail) {
				$owner = false;
				$doc_detail = $this->Document->findById($doc_id);
			}
			
			if(!$owner) {
				$share_info = Set::extract('/Share[user2_id='. $auth_id .']', $doc_detail);
			} 
			
			if(!$owner && empty($share_info)) {
				$this->Session->setFlash(__('Not permitted to see this document.'));
				return false;
			}

			$ext = $doc_detail['Document']['ext'];
			if( !empty($ext) && in_array($ext , array('doc', 'docx' ,'pdf', 'ppt', 'pptx', 'xls', 'xlsx')) ) {
				$viewer_info = array(
									'viewer' => 'crocodoc',
									'doc_detail'=> $doc_detail
								);
			} else {
				$viewer_info = array(
									'viewer' => 'adeptol',
									'doc_detail' => $doc_detail
								);
			}
			$this->set(compact('viewer_info', 'share_info'));
		} 
	}
	
		
	public function edit($doc_id = null) {
		$auth_id = $this->Auth->user('id');
		$owner = true;

		$document = $this->Document->findByIdAndUserId($doc_id, $auth_id);
		$share_info = array();
		
		if(!$document) {
			$owner = false;
			$document = $this->Document->findById($doc_id);
		}
		
		if(!$owner) {
			$share_info = Set::extract('/Share[user2_id='. $auth_id .']', $document);
		} 
		
		if(!$owner && empty($share_info)) {
			$this->Session->setFlash(__('Not permitted to edit this document.'));
			return false;
		}
		$this->set(compact('document', 'share_info'));
	}
	
	public function savedoc($id=null, $userId=null) {
		$this->autoRender = 0;

		if($id && $userId && isset($_FILES) && $this->request->is('post') && !empty($this->request->data)) {
			$document = $this->Document->findByIdAndUserId($id, $userId);
			$share_info = array();
			$owner = true;
			$folder_id_to_access = $userId;
			
			if(!$document) {
				$owner = false;
				$document = $this->Document->findById($id);
			}
			
			if(!$owner) {
				$share_info = Set::extract('/Share[user2_id='. $userId .']', $document);
				$folder_id_to_access = $document['Document']['user_id'];
			} 
			
			if(!$owner && empty($share_info)) {
				echo 'Sorry, you\'re not permitted to edit this document';
				exit;
			}
			
			$doc_name = $document['Document']['name'] . '.' . $document['Document']['ext'];
			if(trim($this->request->data['filename']) !== trim($doc_name)) {
				echo 'Sorry, failed to save.';
				exit;
			}
			
			$targetDir = ROOT . DS . APP_DIR . DS . WEBROOT_DIR . DS . 'uploads';
			$targetFile = $targetDir . DS  . 'user_' . $folder_id_to_access . DS . $document['Document']['file'];
			move_uploaded_file($_FILES['content']['tmp_name'], $targetFile);
		}
	}
	
	public function download($file = null) {
		$this->viewClass = 'Media';
		
		$doc_id = $file;
		if (empty($doc_id)){
			$this->Session->setFlash(__('Invalid file'));
			$this->redirect($this->referer());
		}

		$auth_id = $this->Auth->user('id');
		$role = $this->Auth->user('role');
		
		$doc = $this->Document->findById($file);
		if ( empty($doc) ) {
			$this->Session->setFlash(__('Invalid file'));
			$this->redirect($this->referer());
		}
		 
		if($role == 0) {
			$share_info = Set::extract('/Share[user2_id='. $auth_id .']', $doc_detail);
		} elseif($role == 2) {
			$share_info = Set::extract('/Share[guest_id='. $auth_id .']', $doc_detail);
		}
		
		if(($role == 0 || $role == 2) && (empty($share_info) || !$share_info[0]['Share']['is_downloadable'])) {
			$this->Session->setFlash(__('Not permitted to download this document.'));
			$this->redirect($this->referer());
		}
		
		
		$path = "uploads" . DS . 'user_' . $auth_id . DS ;
		 
		if(!file_exists($path)) {
			$this->Session->setFlash(__('This file does not exists.'));
			$this->redirect($this->referer());
		}
		
		$nicename = $doc['Document']['name'] . '.' . $doc['Document']['ext'];
		$type = $doc['Document']['type'];
		$size = $doc['Document']['size'];  
		$modified = $doc['Document']['modified'];
				
		$params = array(
			'id'        => $doc['Document']['file'],
			'name'      => $nicename,
			'extension' => $doc['Document']['ext'],
			'download' => true, 
			'path'      => $path
		);
		$this->set($params);
		
	}
	
	/**
	*	Publicly accessable download url
	*	only accessable via permalink
	*/
	public function pdownload($auth_id=null, $doc_id=null) {
		if (empty($doc_id) || empty($auth_id)){
			die(__('Invalid file'));
		}
		$doc = $this->Document->findById($doc_id);		
		$nicename = $doc['Document']['name'] . '.' . $doc['Document']['ext'];
		$type = $doc['Document']['type'];
		$size = $doc['Document']['size'];  
		$modified = $doc['Document']['modified'];
		
		$path = "uploads" . DS . 'user_' . $auth_id . DS ;
		
		$this->viewClass = 'Media';
		$params = array(
			'id'        => $doc['Document']['file'],
			'name'      => $nicename,
			'extension' => $doc['Document']['ext'],
			'download' => true, 
			'path'      => $path
		);
		$this->set($params);
	}
	
	public function add() {
		if ($this->request->is('post')) {
			$this->Document->create();
			if ($this->Document->save($this->request->data)) {
				$this->Session->setFlash(__('The document has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The document could not be saved. Please, try again.'));
			}
		}
		$users = $this->Document->User->find('list');
		$folders = $this->Document->Folder->find('list');
		$this->set(compact('users', 'folders'));
	}

	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Document->id = $id;
		if (!$this->Document->exists()) {
			throw new NotFoundException(__('Invalid document'));
		}
		if ($this->Document->delete()) {
			$this->Session->setFlash(__('Document deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Document was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

    public function comments($id = 0) {
        if($id) {
            $this->loadModel("Comment");
			$user = $this->Auth->user();
			!empty($user['uuid']) ? $guest_id = $this->Auth->user('uuid') : $auth_id = $this->Auth->user('id');
			$title = 'Document';
			$comment_for = 'document_id';
			$target_id = $id;
			$documentsComment =  $this->Comment->find("all", array("conditions"=>array("Comment.document_id"=>$id)));
            $this->set(compact("documentsComment", "auth_id", "title", "comment_for", "target_id", "guest_id"));
            $this->render("ajax_comments", false);
        }
    }

    public function addComment() {
        $authId = $this->Auth->user("id");
        if($this->request->is('ajax') && !empty($this->request->data)) {
            $this->loadModel("Comment");
            $this->Comment->create();
            $this->Comment->save($this->request->data);
            $newId = $this->Comment->getLastInsertId();
			/**
			*	Create a Notice when New
			*	Comment Added to document
			*/
			$this->loadModel('Notice');
			$notice = array();
			$auth_name = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
			$time = date('g:ia');
			$notice['Notice']['user_id'] = $this->Auth->user('id');
			$notice['Notice']['comment_id'] = $newId;
			$notice['Notice']['notice_type'] = 'new_comment';
			$getDocName = $this->Document->field('name',array('Document.id' => $this->request->data['Comment']['document_id']));
			$notice['Notice']['short_message'] = htmlspecialchars('<div class="notice_block"><div class="pill new_comment">New Comment</div><div class="the_notice"><span class="time"> | '. $time .'</span>To '. $getDocName .' By <strong>'. $auth_name .'</strong></div></div>');
			$this->Notice->create();
			$this->Notice->save($notice, false);
			/**
			*	Create Notice block end
			*/
           	$guest_id = !empty($this->request->data['Comment']['guest_id']) ? $this->request->data['Comment']['guest_id'] : '';
            $this->set("isNewAdded",true);
			$this->set('guest_id',  $guest_id);
            $this->set("documentsComment", $this->Comment->find("all", array("conditions"=>array("Comment.id"=>$newId))));
            $this->render("ajax_comments", false);
        }
    }
      public function pdfeditor() {
		$viewer_info = array();
		if(!empty($this->request->params['named'])) {
			$params = $this->request->params['named'];
			$doc_id = $params['id'];
			if ($doc_id == NULL)
			{
			$viewer_info = array();
			$share_info = array();
			$auth_id = $this->Auth->user('id');
			$role = intval($this->Auth->user('role'));
			$auth_key =  $this->Auth->user('auth_key');
			
		    $viewer_info = array(
								'auth_key'=> $auth_key
								);
			$this->set(compact('viewer_info', 'share_info'));
			}
			else
			{
			$viewer_info = array();
			$doc_info = array();
			$auth_id = $this->Auth->user('id');
			$role = intval($this->Auth->user('role'));
			
			$doc_detail = $this->Document->get_doc_info($doc_id, $auth_id);
			$share_info = array();
			
			if(!$doc_detail) {
				$this->Session->setFlash(__('Sorry, Invalid Document.'.$doc_id));
				return false;
			}
			if($role == 0) {
				$share_info = Set::extract('/Share[user2_id='. $auth_id .']', $doc_detail);
			} elseif($role == 2) {
				$share_info = Set::extract('/Share[guest_id='. $auth_id .']', $doc_detail);
			}
			
			if(($role == 0 || $role == 2) && empty($share_info)) {
				$this->Session->setFlash(__('Not permitted to see this document.'));
				return false;
			}

		
			
				$viewer_info = array(
								'doc_detail'=> $doc_detail
								);
			
			$this->set(compact('viewer_info', 'share_info'));
			
                }
			}
	}
	
	/**
	*	Move Docuemnt from a folder to another folder
	*
	*	@params
	*		$document_id, $new_folder_id
	*	@return
	*		JSON object with status
	*/
	
	public function move_document() {
		$this->autoRender = 0;
		$result['status'] = 'n';
		if($this->request->is('post') && !empty($this->request->data['document_id']) && !empty($this->request->data['folder_id'])) {
			$this->Document->id = $this->request->data['document_id'];
			$this->Document->saveField('folder_id', $this->request->data['folder_id']);
			$result['status'] = 'y';
		}
		echo json_encode($result);
	}
}
