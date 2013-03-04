<?php
App::uses('AppController', 'Controller');

class GuestsController extends AppController {

	public function beforeFilter() {
		$this->Auth->allow('download');
	}

	public function entry() {
	
		$guest = array();
		$folders = array();
		$documents = array();
		
		$shared_with_guest = $this->Guest->Share->find('all', array('recursive' => -1,'conditions' => array('Share.guest_id' => $this->Auth->user('id'))));

		$isvalid = true;
		$folder_idx = Set::extract('/Share/folder_id', $shared_with_guest);
		$document_idx = Set::extract('/Share/document_id', $shared_with_guest);
		if(!empty($folder_idx)) {
			$folders = $this->Guest->get_all_shared_folder_with_guest($folder_idx);
		}
		if(!empty($document_idx)) {
			$documents = $this->Guest->get_all_shared_document_with_guest($document_idx);
		}
		$this->layout = 'guest';
		$this->set(compact('guest', 'folders', 'documents', 'shared_with_guest'));
	}
	
	public function view () {
		$viewer_info = array();
		if(!empty($this->request->params['named'])) {
			$params = $this->request->params['named'];
			$doc_id = $params['id'];
			$viewer_info = array();
			$doc_info = array();
			$auth_id = $this->Auth->user('id');
			$doc_detail = $this->Guest->Share->Document->get_doc_info($doc_id, $auth_id);
			$share_info = $this->Guest->Share->find('all', array('recursive' => -1,'conditions' => array('Share.guest_id' => $auth_id, 'Share.document_id' => $doc_id)));
			if(!$share_info || empty($share_info)){
				$this->Session->setFlash(__('This document has not been shared with you.'));
				return $this->redirect($this->referer());
			}
			$ext = $doc_detail['Document']['ext'];
			/*
			if(!$doc_detail) {
				$this->Session->setFlash(__('Invalid document'));
				return false;
			}*/
			if( !empty($ext) && in_array($ext , array('doc', 'docx' ,'pdf')) ) {
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
	
	public function download($doc_id=null) {
		if (empty($doc_id)){
			$this->Session->setFlash(__('Invalid file'));
			return false;
		}
		$is_downloadable = (int)Set::extract('/Share[document_id='. $doc_id .']', $this->Auth->user());

		$shared_doc_idx = Set::extract('/Share/document_id', $this->Auth->user());
		if(!in_array($doc_id, $shared_doc_idx)) {
			$this->Session->setFlash(__('This document has not been shared with you.'));
			return false;
		}
		
		$this->Guest->Share->Document->recursive = -1;
		$getFile = $this->Guest->Share->Document->findById($doc_id);
		
		$file = $getFile['Document']['file'];
		
		$fsTarget = APP . WEBROOT_DIR . DS . 'img' . DS . 'imagecache' . DS . $file;
		
		if(!file_exists($fsTarget)) {
			$this->Session->setFlash(__('This file does not exists.'));
			return false;
		}
		
		$pathinfo = pathinfo($fsTarget);
		$this->viewClass = 'Media';

		$params = array(
			  'id' => $file,
			  'name' => $pathinfo['filename'], 
			  'download' => true,
			  'extension' => $pathinfo['extension'],  
			  'path' => dirname($fsTarget) . DS 
	   );
	   $this->set($params);
	}
	
}
