<?php
App::uses('AppController', 'Controller');

class SubscriptionsController extends AppController {
	
	public function subscribe() {
		$this->autoRender = false;
		$result = array('status' => 'n');
		$this->Subscription->recursive = -1;
		$is_deleted = 0;

		if($this->request->is('post') && !empty($this->request->data) && !empty($this->request->data['Subscription']['user_id'])) {
			if(!empty($this->request->data['Subscription']['document_id'])) {
				$doc_subs_exists = $this->Subscription->findByUserIdAndDocumentId($this->request->data['Subscription']['user_id'], $this->request->data['Subscription']['document_id']);
				if($doc_subs_exists) {
					$this->Subscription->id = $doc_subs_exists['Subscription']['id'];
					$this->Subscription->delete();
					$is_deleted = 1;
				} 
			} else if(!empty($this->request->data['Subscription']['folder_id'])) {
				$folder_subs_exists = $this->Subscription->findByUserIdAndFolderId($this->request->data['Subscription']['user_id'], $this->request->data['Subscription']['folder_id']);
				if($folder_subs_exists) {
					$this->Subscription->id = $folder_subs_exists['Subscription']['id'];
					$this->Subscription->delete();
					$is_deleted = 1;
				} 
			}
			if(!$is_deleted) {
				if($this->_add_subscription($this->request->data)) {
					$result['status'] = 'y';
					$result['type'] = 'A';
				}
			} else {
				$result['status'] = 'y';
				$result['type'] = 'D';
			}
		}
		echo json_encode($result);
	}

	private function _add_subscription($data) {
		$this->Subscription->create();
		if($this->Subscription->save($this->request->data, false)) {
			return 1;
		} else return 0;
	}
}
