<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class CabinetsController extends AppController {

    public $helpers = array('Cache');
    public $components = array();
    /*
      public $cacheAction = array(
      'index'  => 48000
      );
     */
    public $cacheAction = false;

    public function beforeFilter() {
        Cache::clear();
        $this->Auth->allow(array('multipleUpload'));
    }

    /**
     * Checks IE version
     * @return $integer IE version
     */
    private function ieVersion() {
        ereg('MSIE ([0-9].[0-9])', $_SERVER['HTTP_USER_AGENT'], $reg);
        if (!isset($reg[1])) {
            return -1;
        } else {
            return floatval($reg[1]);
        }
    }

    /**
     * Displays tree folders and documents with full ajax functionality
     * @link http://filocity.com/cabinets
     */
    public function index() {
        $defaultId = 1;
        $auth_id = $this->Auth->user('id');
        $role = intval($this->Auth->user('role'));
        $company_id = $this->Auth->user('Company.id');
        if (isset($this->params->query["rewrite"])) {
            $this->cacheAction = false;
        }
        $this->cacheAction = false;
        $this->loadModel("Folder");
        $folders = false; // Cache::read('folders_' . $this->Auth->user("id"));
        if (!$folders) {
            $this->Folder->recursive = -1;
            $folders['spaces'] = $this->Folder->listAll($auth_id, $role, $company_id);
            $folders['projects'] = $this->Folder->get_project_folders($auth_id);
            Cache::write('folders_' . $this->Auth->user("id"), $folders['spaces']);
        }
		/**
		* 	Get all email address
		*	of members and contacts
		*/
		$this->loadModel('User');
		$allEmails = $this->User->get_all_emails();
        $this->set('folders', $folders);
		$this->set('allEmails', $allEmails);
        $this->uploadToS3Initialize();
        /* store current parent folder id - for caching purposes */
        $this->Session->write("Folder.Parent.id", $defaultId);
    }

    /**
     * Ajax request that displays sub and children's tree folder
     * @link (ajax) http://filocity.com/cabinets/folders
     */
    public function folders() {
        if ($this->request->is('ajax') || $this->ieVersion() == 8) {
            $auth_id = $this->Auth->user('id');
            $role = intval($this->Auth->user('role'));
            $this->loadModel("Folder");
            $treeFolders = array(); //Cache::read('trees_' . $this->params->query["folderId"]);
            if (!$treeFolders) {
                $treeFolders = $this->Folder->findThreaded($this->params->query["folderId"], 0, $auth_id);
                Cache::write('trees_' . $this->params->query["folderId"], $treeFolders);
            }
            /**
             * 	Get Shared Folder
             * 	with guest
             */
            if ($role === 2) {
                $this->loadModel('Share');
                $conditions = array('Share.user2_id' => $auth_id);
                $shared_folders = $this->Share->get_all_shared_folder($conditions);
                $folder_idx = Set::extract('/Share/folder_id', $shared_folders);
                $folders = $this->Folder->find('all', array('conditions' => array('Folder.id' => $folder_idx), 'recursive' => -1));
                foreach ($folders as $folder) {
                    $treeFolders[$folder['Folder']['id']] = '_' . $folder['Folder']['name'];
                }
            }

            $this->set('treeFolders', $treeFolders);
            $this->Session->write("Folder.Parent.records", $treeFolders);
            $this->render("ajax_folders", false);
        }
    }

    /**
     * Moves a folder in a tree as sub folder or as parent
     * @link (ajax) http://filocity.com/cabinets/orders
     */
    public function orders() {
        if ($this->request->is('ajax') || $this->ieVersion() == 8) {
            $this->loadModel("Folder");
            $parentId = $this->params->query["parentId"];
            if ($this->params->query["action"] == "jstree-leaf") {
                $this->Folder->recursive = -1;
                $this->Folder->id = $this->params->query["parentId"];
                $results = $this->Folder->read();
                $parentId = $results["Folder"]["parent_id"];
            }

            $this->Folder->id = $this->params->query["sourceId"];
            $this->Folder->saveField("parent_id", $parentId);
            $this->autoLayout = false;
            Cache::delete("trees_" . $this->Session->read("Folder.Parent.id"));
        }
        exit;
    }

    /**
     * Deletes folder document
     * @link (ajax) http://filocity.com/cabinets/deleteDocument
     */
    public function deleteDocument() {
        if ($this->request->is('ajax') || $this->ieVersion() == 8) {
            $auth_id = $this->Auth->user('id');
            $role = intval($this->Auth->user('role'));
            $this->loadModel("Document");
            $folderId = $this->request->data['folderId'];
            $folder_type = $this->Document->Folder->field('folder_type', array('Folder.id' => $folderId));
            if (($role == 1 || $role == 0) && $folder_type != 'share') {
                $this->Document->delete($this->data["id"]);
                $this->Document->Share->delete(array('Share.document_id' => $this->data["id"]));
            } else {
                $this->Document->Share->delete(array('Share.document_id' => $this->data["id"], 'Share.user2_id' => $auth_id));
            }
            Cache::clear();
            /* @TODO - Unlink images etc.. */
        }
        exit;
    }

    /**
     * Deletes folder
     * @link (ajax) http://filocity.com/cabinets/delete
     */
    public function delete() {
        if ($this->request->is('ajax') || $this->ieVersion() == 8) {
            $this->loadModel("Folder");
            if ($this->data["folder_id"] != "") {
                $id = str_replace("phtml_", "", $this->data["folder_id"]);
                $this->Folder->delete($id);
                $return["status"] = 1;
                echo json_encode($return);
                Cache::delete("trees_" . $this->Session->read("Folder.Parent.id"));
            }
        }
    }

    /**
     * Renames folder
     * @link (ajax) http://filocity.com/cabinets/rename
     */
    public function rename() {
        if ($this->request->is('ajax') || $this->ieVersion() == 8) {
            $this->loadModel("Folder");
            if ($this->data["title"] != "") {
                $this->request->data["name"] = $this->data["title"];
                $this->Folder->id = str_replace("phtml_", "", $this->data["folder_id"]);
                $this->Folder->save($this->request->data);
                $return["status"] = 1;
                echo json_encode($return);
                Cache::delete("results_" . $this->Session->read("Folder.id"));
                Cache::delete("trees_" . $this->Session->read("Folder.Parent.id"));
            }
        }
        exit;
    }

    /**
     * Creates folder
     * @link (ajax) http://filocity.com/cabinets/create
     */
    public function create() {
        if ($this->request->is('ajax') || $this->ieVersion() == 8) {
            $this->loadModel("Folder");
            if ($this->data["title"] != "") {
                $this->request->data["name"] = $this->data["title"];
                $this->request->data["parent_id"] = str_replace("phtml_", "", $this->data["folder_id"]);
                $this->request->data["user_id"] = $this->Auth->user('id');
                $this->request->data["status"] = 1;
                $this->Folder->save($this->request->data);
                /**
                 * 	Create a Notice when New
                 * 	Folder Added
                 */
                $this->loadModel('Notice');
                $notice = array();
                $auth_name = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
                $time = date('g:ia');
                $notice['Notice']['user_id'] = $this->Auth->user('id');
                $notice['Notice']['folder_id'] = $this->Folder->id;
                $notice['Notice']['notice_type'] = 'new_folder_created';
                $notice['Notice']['short_message'] = htmlspecialchars('<div class="notice_block"><div class="pill new_folder_created">New Folder</div><div class="the_notice"><span class="time"> | ' . $time . '</span><strong>' . $this->request->data["name"] . '</strong> By <strong>' . $auth_name . '</strong></div></div>');
                $this->Notice->create();
                $this->Notice->save($notice, false);
                /**
                 * 	Create Notice block end
                 */
                $return["status"] = 1;
                $return["id"] = $this->Folder->getLastInsertId();

                echo json_encode($return);
                Cache::delete("trees_" . $this->Session->read("Folder.Parent.id"));
            }
        }
        exit;
    }

    /**
     * Loads folder documents
     * @link (ajax) http://filocity.com/cabinets/documents
     */
    public function documents() {

        if ($this->request->is('ajax') || $this->ieVersion() == 8) {
            $this->loadModel("Document");

            $auth_id = $this->Auth->user('id');
            $role = intval($this->Auth->user('role'));
            $folderId = $this->params->query["sourceId"];
			/**
			*	Save current viewing folder_id by user in Session
			*/
			$this->Session->write('currentFolderId', $folderId);
			
            $is_guest = $role == 2 ? true : false;

            $folder = $this->Document->Folder->find('first', array('conditions' => array('Folder.id' => $folderId)));
            $folder_name = $folder['Folder']['name'];
            $folder_type = $folder['Folder']['folder_type'];
            $folderIds = $this->Document->Folder->getChildrenId($folderId, true, $auth_id);

            $limit = $this->params->query["limit"];

            $arg = array();
            if ($limit) {
                $arg['limit'] = $limit;
            }
            $results = array();
            $this->Document->recursive = -1;
            $this->Document->Behaviors->attach('Containable');


            $shared_by = array(); // list of users who shared document
            $this->loadModel('Share');
            $is_shared = false;

            if (/* ($role === 2 &&  $folder_type == 'share' && $folder['Folder']['user_id'] == $auth_id) || */($folder_type == 'share')) {

                // If guest then get all documents from share table for "Share With Me" Folder
                $documents = $this->Share->get_all_shared_document(array('Share.user2_id' => $auth_id));
                $shared_by_idx = Set::extract('/Share/user_id', $documents);

                // get User name who shared file
                $this->Share->User->displayField = 'name';
                $shared_by = $this->Share->User->find('list', array('conditions' => array('User.id' => $shared_by_idx)));

                // get document ids
                $document_idx = Set::extract('/Share/document_id', $documents);
                $arg['conditions'] = array('Document.id' => $document_idx, 'Document.is_latest' => 'Y');
            } elseif ($folder_type != 'share') {
				$this->Document->Folder->recursive = -1;
                $is_owner = $this->Document->Folder->findByIdAndUserId($folderId, $auth_id);
				
                if (!empty($is_owner)) {
                    $arg["conditions"] = array("Document.folder_id" => $folderIds, 'Document.is_latest' => 'Y');
                } else {
                    $is_shared = $this->Share->is_shared(array('Share.user2_id' => $auth_id, 'Share.folder_id' => $folderId), -1);
                    $is_writable = (int) $is_shared['Share']['is_writable'];
                    $arg['conditions'] = array('OR' => array('Document.folder_id' => $folderIds, 'Document.folder_id' => $is_shared['Share']['folder_id']), 'Document.is_latest' => 'Y');
                }
            } else {
                $arg["conditions"] = array("Document.folder_id" => $folderIds, 'Document.is_latest' => 'Y');
            }
			$arg["conditions"]["Document.status"] = 1;
            $arg["order"] = array("Document.folder_id" => "ASC");
            $arg['contain'] = array(
                'User' => array(
                    'fields' => array('User.id', 'User.first_name', 'User.last_name')
                ),
                'Share',
                'Comment' => array(
                    'fields' => array('id')
                ),
                'Subscription' => array(
                    'fields' => array('Subscription.id')
                ),
                'CalendarEvent' => array(
                    'fields' => array('CalendarEvent.id')
                ),
                'Folder' => array(
                    'Subscription' => array(
                        'fields' => array('Subscription.id'),
                        'conditions' => array('Subscription.user_id' => $auth_id)
                    ),
                    'Share',
                    'Comment' => array(
                        'fields' => array('id')
                    ),
                    'CalendarEvent' => array(
                        'fields' => array('CalendarEvent.id')
                    )
                )
            );
			
            $results = $this->Document->find("all", $arg);

            /* store current folder id - for caching purposes */
            $this->Session->write("Folder.id", $this->params->query["sourceId"]);
            $this->set('documents', $results);
            $this->set('is_guest', $is_guest);
            $this->set('folder_name', $folder_name);
            $this->set('role', $role);
            $this->set('folder_type', $folder_type);
            $this->set('currentFolder', $folder);
            $this->set('shared_by', $shared_by);
            $this->set('is_shared', $is_shared);
            $this->uploadToS3Initialize();
            $this->set('treeFolders', $this->Session->read("Folder.Parent.records"));
            $this->render("ajax_documents", false);
        }
    }

    /**
     * Updates save folder document
     * @link (ajax) http://filocity.com/cabinets/documents
     */
    public function updateInfo() {
        if ($this->request->is('ajax') || $this->ieVersion() == 8) {
            $this->loadModel("Document");
            $this->Document->save($this->data);
            Cache::clear();
        }
        exit;
    }

	/**
	*  ///////////////////////////////////////////////////////////  S3 upload methods START ///////////////////////////////////////////////////////////////////
	*/
	
	/**
    * Before the uploading process begin, S3 Config should be initialized
    *
    * @param none
    * @return void
    */
    protected function uploadToS3Initialize() {
        config('s3');
        app::import("vendor", "S3/S3");

        if (class_exists('S3_CONFIG')) {
            $config = new S3_CONFIG();
        }
        S3::setAuth($config->default["accessKey"], $config->default["secretKey"]);
        $bucket = $config->default["bucket"];
        $path = '';
        $lifetime = 3600;
        $maxFileSize = (1024 * 1024 * 50);
        $metaHeaders = array('uid' => 123);
        $requestHeaders = array(
			'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename=${filename}'
        );

        $params = S3::getHttpUploadPostParams($bucket, $path, S3::ACL_PUBLIC_READ, $lifetime, $maxFileSize, 201, $metaHeaders, $requestHeaders, false);
        $this->set("params", $params);
    }
	
	/**
    * And before file was upload to S3, it saves first into database
    *
    * @param none
    * @return integer $newId New ID of a document
    */
    private function uploadToS3SaveFile() {
        $this->loadModel("Document");
        if ($this->Auth->user("id")) {
            $this->request->data["folder_id"] = $this->params->query["folderId"];
            $this->request->data["user_id"] = $this->Auth->user("id");
        }
        $this->Document->Behaviors->attach('Image');
        $this->Document->create();
        $this->Document->save($this->data);

        $newId = $this->Document->getLastInsertId();
        $this->Document->id = $newId;
        $this->set('documents', $this->Document->read());
        Cache::clear();
        return $newId;
    }
	
    /**
    * Before file was upload to S3, it renames on this function
    *
    * @param config $config S3 Config instance
    * @param integer $folderId The ID of the folder
    * @param integer $fileId The new ID of the document
    * @return string $tmpPath . $renamedFile Path and file name of the document
    */
    private function uploadToS3RenameFile($config, $folderId, $fileId) {
        $tmpName = $this->params->data["file"]["tmp_name"];
        $tmpArray = array_reverse(explode(DS, $tmpName));
        $tmpPath = str_replace($tmpArray[0], "", $tmpName);

        $fileInfo = $this->params->data["file"]["name"];
        $file = explode('.', $fileInfo);
        $ext = array_pop($file);
        $fileFormat = $config->default["fileFormat"];
        $version = $config->default["version"];
        $hash = AuthComponent::password($fileInfo);

        $renamedFile = str_replace("{folder-id}", $folderId, $fileFormat);
        $renamedFile = str_replace("{file-id}", $fileId, $renamedFile);
        $renamedFile = str_replace("{ext}", $ext, $renamedFile);
        //$renamedFile = str_replace("{[version]}",$version, $renamedFile);
        //$renamedFile = str_replace("{hash}",$hash, $renamedFile);

        rename($this->params->data["file"]["tmp_name"], $tmpPath . $renamedFile);
        copy($tmpPath . $renamedFile, ROOT . DS . APP_DIR . DS . WEBROOT_DIR . DS . 'uploads' . DS . "user_" . $this->Auth->user('id') . DS . $renamedFile);

        // Upload to Crocodoc
        if (in_array(strtolower($ext), array('doc', 'docx', 'pdf'))) {
            $local_url = ROOT . DS . APP_DIR . DS . WEBROOT_DIR . DS . 'uploads' . DS . "user_" . $this->Auth->user('id') . DS . $renamedFile;
            $this->_uploadToCrocodoc($local_url, $fileId);
        }
        return $tmpPath . $renamedFile;
    }
	
    /**
    * Uploads documents to S3
    * @link (ajax) http://filocity.com/cabinets/uploadToS3
    */
    public function uploadToS3() {

        if ($this->request->is('ajax') || $this->ieVersion() == 8 || isset($this->request->params["form"]["Filedata"]) || isset($this->request->params["form"]["FileBody_0"])) {

            if (isset($this->request->params["form"]["Filedata"])) {
                $this->params->data["file"] = $this->request->params["form"]["Filedata"];
                $this->params->query["folderId"] = $this->data["folder_id"];
                $this->Session->id($this->data["session_id"]);
                $flashJavaUpload = true;
            }

            if (isset($this->request->params["form"]["FileBody_0"])) {
                $this->params->data["file"] = $this->request->params["form"]["FileBody_0"];
                $this->params->query["folderId"] = $this->data["folder_id"];
                $this->Session->id($this->data["session_id"]);
                $flashJavaUpload = true;
            }

            ini_set('max_execution_time', 1234568910);

            config('s3');
            if (class_exists('S3_CONFIG')) {
                $config = new S3_CONFIG();
            }
            $fileId = $this->uploadToS3SaveFile();

            $newFile = $this->uploadToS3RenameFile($config, $this->params->query["folderId"], $fileId);
            $this->params->data["file"]["tmp_name"] = $newFile;
            $url = str_replace("{bucket}", $config->default["bucket"], $config->default["url"]);

            $postData = $_POST;
            $postData["file"] = "@" . $this->params->data["file"]["tmp_name"];

            if (!isset($flashJavaUpload)) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_VERBOSE, 1);
                $response = curl_exec($ch);
                $this->set('treeFolders', $this->Session->read("Folder.Parent.records"));
                $this->render("ajax_uploads", false);
            }
        } else {
            $msg = array("error" => "Browser doesn't support this method");
            echo json_encode($msg);
            exit;
        }
    }
	
	/**
	*  ///////////////////////////////////////////////////////////  S3 upload methods END ///////////////////////////////////////////////////////////////////
	*/
	

    /**
     *  Upload a copy of Local File to 
     * 	Crocodoc, for Crocodoc view
     * 	doc, docx and pdf Extensions only
     *
     * 	@params local path to file
     * 	@return Crocodoc UUID
     */
    private function _uploadToCrocodoc($local_url, $document_id) {
        $this->autoRender = false;
        App::import('Helper', 'Crocodoc');

        $Crocodoc = new CrocodocHelper();
        $response = $Crocodoc->setToken('suJGtmrvpCjEVNWfIAy0LXdh')->setURL($local_url)->uploadFile();
        if (isset($response['status']) && strtolower($response['status']) == 'ok') {
            $this->loadModel('Document');
            $this->Document->updateAll(array('Document.crocodoc_uuid' => '\'' . $response['uuid'] . '\''), array('Document.id' => $document_id));
        }
    }

    /**
     * Multiple upload
     *
     * @param none
     * @return void
     */
    public function multipleUpload() {
        if (isset($this->request->params["form"]["FileBody_0"])) {
            if (count($this->request->params["form"]) > 0) {
                $folders = $this->data["folders"];
                $length = strlen(str_replace(",", "", $folders));
                $explode = explode(",", $folders);

                $i = 0;
                $this->loadModel("Folder");
                $data["user_id"] = $this->data["user_id"];
                $data["parent_id"] = $this->data["folder_id"];

                foreach ($this->request->params["form"] as $name) {
                    if ($length >= 5) {
                        $folderId = $this->multipleUploadCreateFolders($data, $explode[$i]);
                        $this->request->data["folder_id"] = $folderId;
                        ++$i;
                    }
                    $this->log("1", "debug");
                    $this->request->params["form"]["FileBody_0"] = $name;
                    $this->uploadToS3();
                }
            }
        } else {
            $this->uploadToS3();
        }
        exit;
    }

    private $records = array();

    protected function multipleUploadCreateFolders($data, $path) {
        $filter = array();
        $exp = explode("\\", $path);
        $filter = array_filter($exp);

        foreach ($filter as $folder) {
            $data["name"] = Sanitize::paranoid($folder);
            $key = array_search($folder, $this->records);
            if ($key >= 1) {
                //$this->request->data["folder_id"] = $key;
                $lastId = $key;
            } else {
                $this->Folder->create();
                $this->Folder->save($data);
                /**
                 * 	Create a Notice when Admin
                 * 	creates a new Folder
                 */
                $this->loadModel('Notice');
                $notice = array();
                $auth_name = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
                $time = date('g:ia');
                $notice['Notice']['user_id'] = $this->Auth->user('id');
                $notice['Notice']['folder_id'] = $this->Folder->id;
                $notice['Notice']['notice_type'] = 'new_folder_created';
                $notice['Notice']['short_message'] = htmlspecialchars('<div class="notice_block"><div class="pill new_folder_created">New Folder</div><div class="the_notice"><span class="time"> | ' . $time . '</span><strong>' . $data['name'] . '</strong> By <strong>' . $auth_name . '</strong></div></div>');
                $this->Notice->create();
                $this->Notice->save($notice, false);
                /**
                 * 	Create Notice block end
                 */
                $data["parent_id"] = $this->Folder->getLastInsertId();
                $this->records[$data["parent_id"]] = $folder;
                //$this->request->data["folder_id"] = $data["parent_id"];
                $lastId = $data["parent_id"];
            }
        }
        return $lastId;
    }

    /**
     * Displays folder comments
     *
     * @param $id Integer Folder id
     * @return void
     */
    public function comments($id = 0) {
        if ($id) {
            $this->loadModel("Comment");
            $auth_id = $this->Auth->user('id');
            $title = 'Folder';
            $comment_for = 'folder_id';
            $target_id = $id;
            $documentsComment = $this->Comment->find("all", array("conditions" => array("Comment.folder_id" => $id)));
            $this->set(compact("documentsComment", "auth_id", "title", "comment_for", "target_id"));
            $this->render("ajax_comments", false);
        }
    }

    /**
     * Adds comment
     *
     * @param none
     * @return void
     */
    public function addComment() {
        $authId = $this->Auth->user("id");
        if ($this->request->is('ajax')) {
            $this->loadModel("Comment");

            $this->request->data["user_id"] = $authId;
            $this->request->data["folder_id"] = $this->data["document_id"];
            $this->request->data["comment"] = $this->data["comment"];

            unset($this->request->data["document_id"]);
            $this->Comment->save($this->request->data);
            $newId = $this->Comment->getLastInsertId();

            $this->set("isNewAdded", true);
            $this->set("documentsComment", $this->Comment->find("all", array("conditions" => array("Comment.id" => $newId))));
            $this->render("ajax_comments", false);
        }
    }

    /**
     * 	Get Folder permission
     */
    public function get_folder_permissoin() {
        $this->autoRender = false;
        $result['status'] = 'n';
        $result['upload_button'] = '<a class="share tool_link fancyboxUpload btn btn-success" href="#multipleUpload"><i class="icon-upload-alt"></i> Upload</a>';
        $result['is_writable'] = $result['is_printable'] = $result['is_downloadable'] = $result['is_readonly'] = 0;

        if ($this->request->is('post') && !empty($this->request->data)) {
            $auth_id = $this->Auth->user('id');
            $role = $this->Auth->user('role');
            $folder_id = $this->request->data['folderId'];
            $result['role'] = $role;
            $this->loadModel('Folder');
            $is_owner = $this->Folder->findByIdAndUserId($folder_id, $auth_id);

            if ($is_owner) {
                $result['is_writable'] = $result['is_printable'] = $result['is_downloadable'] = $result['is_readonly'] = 1;
            } else {
                $this->loadModel('Share');
                $is_shared = $this->Share->is_shared(array('Share.user2_id' => $auth_id, 'Share.folder_id' => $folder_id));
                $result['is_writable'] = (int) $is_shared['Share']['is_writable'];
                $result['is_printable'] = (int) $is_shared['Share']['is_printable'];
                $result['is_downloadable'] = (int) $is_shared['Share']['is_downloadable'];
                $result['is_readonly'] = (int) $is_shared['Share']['is_readonly'];
                if (!$result['is_writable']) {
                    $result['upload_button'] = '';
                }
            }
            $result['status'] = 'y';
        }
        echo json_encode($result);
    }

    /**
     * 	Get version details
     */
    public function versions($documentid) {
        //if($this->request->is('ajax') || $this->ieVersion()==8) {
        $this->loadModel("Document");
        $mydocData = $this->Document->find('all', array('conditions' => array('Document.version_document_id' => $documentid), 'order' => 'Document.version DESC'));
        $this->set('documents', $mydocData);
        $this->render("versions", false);
        //}
    }

    /**
     * 	save file by uploader as temp
     */
    public function uploader() {
        // HTTP headers for no cache etc
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        // Settings

        $targetDir = ROOT . DS . APP_DIR . DS . 'tmp';

        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds
        // 5 minutes execution time
        @set_time_limit(5 * 60);

        // Uncomment this one to fake upload time
        // usleep(5000);
        // Get parameters
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
        $fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';

        // Clean the fileName for security reasons
        $fileName = preg_replace('/[^\w\._]+/', '_', $fileName);

        // Make sure the fileName is unique but only if chunking is disabled
        if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
            $ext = strrpos($fileName, '.');
            $fileName_a = substr($fileName, 0, $ext);
            $fileName_b = substr($fileName, $ext);

            $count = 1;
            while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
                $count++;

            $fileName = $fileName_a . '_' . $count . $fileName_b;
        }

        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

        // Create target dir
        if (!file_exists($targetDir))
            @mkdir($targetDir);

        // Remove old temp files	
        if ($cleanupTargetDir && is_dir($targetDir) && ($dir = opendir($targetDir))) {
            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge) && ($tmpfilePath != "{$filePath}.part")) {
                    @unlink($tmpfilePath);
                }
            }

            closedir($dir);
        } else
            die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');


        // Look for the content type header
        if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
            $contentType = $_SERVER["HTTP_CONTENT_TYPE"];

        if (isset($_SERVER["CONTENT_TYPE"]))
            $contentType = $_SERVER["CONTENT_TYPE"];

        // Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
        if (strpos($contentType, "multipart") !== false) {
            if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
                // Open temp file
                $out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
                if ($out) {
                    // Read binary input stream and append it to temp file
                    $in = fopen($_FILES['file']['tmp_name'], "rb");

                    if ($in) {
                        while ($buff = fread($in, 4096))
                            fwrite($out, $buff);
                    } else
                        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
                    fclose($in);
                    fclose($out);
                    @unlink($_FILES['file']['tmp_name']);
                } else
                    die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
            } else
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
        } else {
            // Open temp file
            $out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
            if ($out) {
                // Read binary input stream and append it to temp file
                $in = fopen("php://input", "rb");

                if ($in) {
                    while ($buff = fread($in, 4096))
                        fwrite($out, $buff);
                } else
                    die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');

                fclose($in);
                fclose($out);
            } else
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        // Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off 
            rename("{$filePath}.part", $filePath);
        }
        // Return JSON-RPC response
        die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
    }

    /**
     * 	Save files's info in db and Crocodoc
     */
    public function saveUploadedImage() {

        if (isset($this->request->data) && $this->request->data['uploader_count'] > 0) {
            $count = $this->request->data['uploader_count'];
            for ($i = 0; $i < $count; $i++) {
                $data = array();
                Cache::clear();
                $status = 'uploader_' . $i . '_status';
                $name = 'uploader_' . $i . '_name';
                $name = $this->request->data[$name];
                $tmpname = 'uploader_' . $i . '_tmpname';
                $tmpname = $this->request->data[$tmpname];
                $fileStatus = $this->request->data[$status];
                if ($fileStatus == 'done') {

                    $this->loadModel("Document");

                    $folderid = $this->request->data["folder_id"];
                    $ext = explode('.', $name);

                    $ext = (count($ext) > 1 ? $ext[count($ext) - 1] : '');
                    $name = str_replace('.' . $ext, '', $name);
                    $oldfile = $this->Document->find('first', array('conditions' => array('Document.folder_id' => $folderid, 'Document.name' => $name, 'Document.is_latest' => 'Y')));

                    $newversion = 1;
                    if (!empty($oldfile)) {
                        $data["version_document_id"] = $oldfile['Document']['version_document_id'];
                        $newversion = intval($oldfile['Document']['version']) + 1;
                        //update previous latest 
                        $this->Document->updateAll(array('is_latest' => "'N'"), array('version_document_id' => $oldfile['Document']['version_document_id']));

                        /**
                         * 	Create a Notice when any
                         * 	version update happen
                         */
                        $this->loadModel('Notice');
                        $notice = array();
                        $auth_name = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
                        $time = date('g:ia');
                        $notice['Notice']['user_id'] = $this->Auth->user('id');
                        $notice['Notice']['document_id'] = $oldfile['Document']['id'];
                        $notice['Notice']['notice_type'] = 'new_file_version';
                        $notice['Notice']['short_message'] = htmlspecialchars('<div class="notice_block"><div class="pill new_file_version">New Version</div><div class="the_notice"><span class="time"> | ' . $time . '</span><strong>' . $oldfile['Document']['name'] . '</strong> From <strong>' . $auth_name . '</strong></div></div>');
                        $this->Notice->create();
                        $this->Notice->save($notice, false);
                        /**
                         * 	Create Notice block end
                         */
                    }
                    //$newversion=($newversion+1);
                    $data["name"] = $name;
                    $data["folder_id"] = $folderid;
                    $data["user_id"] = $this->request->data["user_id"];
                    $data["version"] = $newversion;

                    $data["ext"] = $ext;
                    $data["size"] = intval(@filesize(ROOT . DS . APP_DIR . DS . 'tmp' . DS . $tmpname) / 1024);
                    $data["type"] = $this->request->data["Content-Type"];
                    $this->Document->create();
                    $this->Document->save($data);
                    /**
                     * 	Create a Notice when New
                     * 	new File added
                     */
                    $this->loadModel('Notice');
                    $notice = array();
                    $auth_name = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
                    $time = date('g:ia');
                    $notice['Notice']['user_id'] = $this->Auth->user('id');
                    $notice['Notice']['document_id'] = $this->Document->id;
                    $notice['Notice']['notice_type'] = 'new_file_added';
                    $getDocName = $name;
                    $notice['Notice']['short_message'] = htmlspecialchars('<div class="notice_block"><div class="pill new_file_added">New File</div><div class="the_notice"><span class="time"> | ' . $time . '</span>To <strong>' . $getDocName . '</strong> By <strong>' . $auth_name . '</strong></div></div>');
                    $this->Notice->create();
                    $this->Notice->save($notice, false);
                    /**
                     * 	Create Notice block end
                     */
                    $newid = $this->Document->getLastInsertId();
                    $this->Document->id = $newid;
                    	
                    $renamedFile = $folderid . "-" . $newid . "." . $ext;
                    $data["file"] = $renamedFile;
                    if ($newversion == 1) {
                        $data["version_document_id"] = $newid;
                    }
                    $this->Document->save($data);

                    $this->set('documents', $this->Document->read());
					
					/**
					*	Save the uploaded files
					*/
					$targetDir = ROOT . DS . APP_DIR . DS . WEBROOT_DIR . DS . 'uploads';
					$auth_id = $this->Auth->user('id');
					
					$folderForUser = $targetDir . DS . 'user_' . $auth_id;
					if (!file_exists($folderForUser)) @mkdir($folderForUser);
					
                    //copy(ROOT . DS . APP_DIR . DS . 'tmp' . DS . $tmpname, ROOT . DS . APP_DIR . DS . WEBROOT_DIR . DS . 'img' . DS . "imagecache" . DS . $renamedFile);
					@copy(ROOT . DS . APP_DIR . DS . 'tmp' . DS . $tmpname, $folderForUser . DS . $renamedFile);
					
                    if (in_array(strtolower($ext), array('doc', 'docx', 'pdf'))) {
                        //$local_url = $folderForUser . DS . $renamedFile;
                        //$this->_uploadToCrocodoc($local_url, $newid);
                    }
                    @unlink(ROOT . DS . APP_DIR . DS . 'tmp' . DS . $tmpname);
                }
            }
        }
        Cache::clear();
        //$this->redirect('/cabinets?project=' . $folderid);
		$this->redirect('/cabinets');
    }
}

?>
