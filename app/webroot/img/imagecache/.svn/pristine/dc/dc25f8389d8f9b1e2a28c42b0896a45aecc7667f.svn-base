<?php

class Rest_IndexController extends Zend_Controller_Action {

    private $_Identity = null;
    private $_ShareId = 0;
    private $_Space = "company";
    private $_Result = array("status" => "", "result" => "");
    private $_Debug = 0;

    public function init() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $this->_Space = $this->_request->getParam("space", "company");
        $this->_ShareId = $this->_request->getParam("share", 0);

        if (!preg_match('/^\d+$/', $this->_ShareId)) {
            $this->_returnError("Share information not found.");
            exit;
        }
        if ($this->_Space != "company" && $this->_Space != "shared" && $this->_Space != "personal") {
            $this->_returnError("Invalid space information.");
            exit;
        }

        if ($this->_request->getActionName() != 'auth') {
            $key = $this->_request->getParam("secret", null);
            $this->_Debug = $this->_request->getParam("debug", 0);

            if ($key == null) {
                $this->_returnError("Secret not found.");
                exit;
            }

            $var = new Application_Model_UserManagement();
            $r = $var->getUserIdByKey($key);

            if ($r == 0) {
                $this->_returnError("Secret not found.");
                exit;
            }

            $this->_Identity = new Application_Model_GMFilocityUser($r);

            if ($this->_Identity->accountDisabled == 1) {
                $this->_returnError("Secret associated with disabled account.");
                exit;
            }

            if ($this->_Identity->accountExpired == 1) {
                $this->_returnError("Secret associatd with expired account.");
                exit;
            }

            // If user is guest, just make sure that we have got shareId - against which he is requesting the document
            if ($this->_Identity->isGuest == 1 && $this->_ShareId == 0) {
                $this->_returnError("Share information not found.");
                exit;
            }

            if ($this->_Identity->isGuest == 1 && $this->_Space != "shared") {
                $this->_returnError("Space access violation for guest.");
                exit;
            }

            if ($this->_Identity->hasPersonalSpace == 0 && $this->_Space == "personal") {
                $this->_returnError("Space access violation for user.");
                exit;
            }
        }
    }

    // File related actions
    public function authAction() {

        $username = $this->_getParam('username', '');
        $password = $this->_getParam('password', '');
        if (!filter_var($username, FILTER_VALIDATE_EMAIL) || $password == '') {
            $this->_returnError("Invalid credentials");
        } else {
            $db = Zend_Db_Table::getDefaultAdapter();
            $select = new Zend_Db_Select($db);
            $select->from('user', array('login', 'password', 'time_zone'))->join('user_info', 'user_info.user_id=`user`.id')->join('account', 'user_info.account_id = account.id', array('primary_user_id'))->where('`user`.login= ?', $username);
            $result = $select->query()->fetchAll();

            $password = md5($password);
            if (count($result)) {
                if ($result[0]['password'] == $password) {

                    if ($result[0]["primary_user_id"] == $result[0]["user_id"])
                        $result[0]["personal_space"] = 1;

                    $this->_returnArrayResponse($result);
                } else {
                    $this->_returnError("Invalid credentials");
                }
            } else {
                $this->_returnError("Invalid credentials");
            }
        }
    }

    public function saveAction() {
        $folderId = $this->_getFolderId();

        if ($this->_Space == "shared" && $folderId == 0) {
            $this->_returnError("Sorry Can't create root level folders in shared space.");
            exit;
        }
        if (count($_FILES) == 0) {
            $this->_returnError("No files found in request.");
            exit;
        }

        if ($this->_Space == 'personal') {
            $isPersonal = 1;
        } else {
            $isPersonal = 0;
        }

        $fileManagement = new Application_Model_GrayMathFileManagement($this->_Identity, $this->_ShareId, $this->_Space);
        $docId = 0;
        foreach ($_FILES as $file) {
            $response = $fileManagement->upload($file, $folderId, $isPersonal, $docId);
            if ($response == 'success') {
                $this->_returnArrayResponse(array("message" => $file['name'] . ' uploaded successfuly.', "documentId" => $docId));
            } else {
                $this->_returnError($response);
            }
        }
    }

    public function updateAction() {
        $responseType = $this->_request->getParam("response", "json");

        if (sizeof($_FILES) == 0) {
            $this->_returnError("No documents found in request.");
            exit;
        }

        if (!$this->_processSaveRequest($this->_getDocumentId())) {
            if ($responseType == "txt") {
                print "Service was unable to write in cloud. Possible reason could be: permissions not available for context-user.";
            } else {
                $this->_returnError("Service was unable to write in cloud. Possible reason could be: permissions not available for context-user.");
            }
            exit;
        }
        if ($responseType == "txt") {
            print "Document has been saved in Filocity cloud.";
        } else {
            $this->_returnTextResponse("success");
        }
        exit;
    }

    public function getAction() {
        $version = $this->_request->getParam("version", 0);

        if ($this->_Space == "shared" && $this->_ShareId == "0") {
            $this->_returnError("Invalid share id. Please specify share id in your request.");
            exit;
        }

        $fileManagement = new Application_Model_GrayMathFileManagement($this->_Identity, $this->_ShareId, $this->_Space);
        if (!$fileManagement->downloadFileForREST($this->_getDocumentId(), $version))
            header("HTTP/1.0 404 Not Found");

        exit;
    }

    public function pullforadeptolAction() {
        // Need to add checks to make sure that request is coming from Adeptol.

        $version = $this->_request->getParam("version", 0);

        $fileManagement = new Application_Model_GrayMathFileManagement($this->_Identity, $this->_ShareId, $this->_Space);
        if (!$fileManagement->downloadFileForREST($this->_getDocumentId(), $version, 1))
            header("HTTP/1.0 404 Not Found");

        exit;
    }

    public function moveAction() {

        $chk2 = $this->_request->getParam('source', '');
        $folderId = $this->_request->getParam('destination', '0');

        $fileMamagement = new Application_Model_GrayMathFileManagement($this->_Identity, $this->_ShareId, $this->_Space);
        if ($chk2 == '')
            exit;

        $chk = explode(",", $chk2);
        $result = $fileMamagement->moveItems($chk, $folderId, true);
        if ($result == 'success') {
            $this->_returnTextResponse("Files moves successfully");
        } else {
            $this->_returnError($result);
        }
    }

    public function deleteAction() {

    }

    public function subscribeAction() {

    }

    public function addcommentAction() {

    }

    public function listcommentsAction() {

    }

    public function addshareAction() {

    }

    public function listsharesAction() {

    }

    public function resendshareAction() {

    }

    public function removeshareAction() {

    }

    public function listpermissionsAction() {

    }

    public function addpermissionAction() {

    }

    public function removepermissionAction() {

    }

    public function renameobjectAction() {

        $id = (int) $this->_request->getParam('object_id', 0);

        if ($id == 0) {
            $this->_returnError("Object id is invalid/missed.");
            exit;
        }

        $type = (int) $this->_request->getParam('object_type', 0);
        if ($type == 0) {
            $this->_returnError("Object type is invalid/missed.");
            exit;
        }

        $newName = $this->_request->getParam('newname', 0);
        if (trim($newName) == '') {
            $this->_returnError("Object new name is invalid/missed.");
            exit;
        }

        $fileManagement = new Application_Model_GrayMathFileManagement($this->_Identity, $this->_ShareId, $this->_Space);
        $rename_status = $fileManagement->rename($type, $id, $newName);
        if ($rename_status == "success") {
            $object_type = array('0' => 'asset', '1' => 'folder', '2' => 'file');
            $this->_returnArrayResponse(array('object_id' => $id, 'message' => ucfirst($object_type[$type]) . ' has been renamed successfully.'));
        } else {
            $this->_returnError($rename_status);
        }
        exit;
    }

    public function deleteobjectAction() {

        $id = (int) $this->_request->getParam('object_id', 0);

        if ($id == 0) {
            $this->_returnError("Object id is invalid/missed.");
            exit;
        }

        $type = (int) $this->_request->getParam('object_type', 0);
        if ($type == 0) {
            $this->_returnError("Object type is invalid/missed.");
            exit;
        }

        $fileManagement = new Application_Model_GrayMathFileManagement($this->_Identity, $this->_ShareId, $this->_Space);
        $security = $fileManagement->touch($type, $id);
        if ($security['access'] == 0) {
            $this->_returnError("You are not eligible to perform this operation.");
            exit;
        }

        if ($security['write'] == 1) {
            if ($type == 1) {
                $fileManagement->deleteFolder($id);
            } else {
                $fileManagement->deleteFile($id);
            }
            $object_type = array('0' => 'asset', '1' => 'folder', '2' => 'file');
            $this->_returnArrayResponse(array('object_id' => $id, 'message' => ucfirst($object_type[$type]) . ' has been deleted successfully.'));
        } else {
            $this->_returnError("You don't have right to delete this file.");
        }
        exit;
    }

    public function addfolderAction() {
        // Expect:
        //  FolderId = the folder under which you are supposed to create the folder
        //  FolderName
        //  Operation
        //  1 - Check write permissions
        //  2 - Check if folder already exists - if it does: return "Folder already exists." in message along with folder id
        //  3 - If folder does not exist - create one - return "Folder created." in message along with newly created folder id

        $parent = $this->_request->getParam('folder', 0);

        if (!preg_match('/^\d+$/', $parent)) {
            $this->_returnError("Invalid folder id.");
            exit;
        }

        $folderName = trim(urldecode($this->_request->getParam('foldername', '')));

        if ($folderName == '') {
            $this->_returnError("Please specify folder name.");
            exit;
        }

        if ($this->_Space == "shared" && $parent == 0) {
            $this->_returnError("Sorry can't create root level folders in shared space.");
            exit;
        }

        if ($this->_Space == 'personal') {
            $is_personal = 1;
        } else {
            $is_personal = 0;
        }

        $fileManagement = new Application_Model_GrayMathFileManagement($this->_Identity, $this->_ShareId, $this->_Space);
        $result = $fileManagement->createFolder($folderName, $parent, $is_personal, 1);

        if (intval($result) && $result > 0) {
            $this->_returnArrayResponse($result);
        } else {
            $this->_returnError($result);
        }
    }

    public function allowedextensionsAction() {
        $config = Zend_Registry::get("config");
        $allowExtArray = explode(',', $config->fileupload->format->All);

        $this->_returnArrayResponse($allowExtArray);
    }

    // List my file system action

    public function listAction() {
        $folderId = $this->_getFolderId();
        $showFiles = $this->_request->getParam("everything", 0);
        $search = $this->_request->getParam("search", "");

        $fileManagement = new Application_Model_GrayMathFileManagement($this->_Identity, $this->_ShareId, $this->_Space);

        if (trim($search) == "") {
            $list = $fileManagement->getList($folderId, $showFiles);
            if ($folderId != 0) {
                for ($i = 0; $i < sizeof($list); $i++) {
                    if ($list[$i]["object_id"] == $folderId && $list[$i]["object_type_id"] == 1) {
                        unset($list[$i]);
                        break;
                    }
                }
            }
        } else {
            $list = $fileManagement->getHackedList($search);
        }

        $this->_returnArrayResponse(array("folders" => $list));
    }

    // User information section

    public function infoAction() {

    }

    // Private data

    private function _returnError($error) {
        $this->_Result["status"] = "FAIL"; // . " & action=" . $this->_request->getActionName();
        $this->_Result["result"] = array("message" => $error);

        if ($this->_Debug == 1)
            print Zend_Json::prettyPrint(Zend_Json::encode($this->_Result));
        else
            print Zend_Json::encode($this->_Result);
    }

    private function _returnArrayResponse(array $response) {
        $this->_Result["status"] = "OKAY";
        $this->_Result["result"] = $response;

        if ($this->_Debug == 1)
            print Zend_Json::prettyPrint(Zend_Json::encode($this->_Result));
        else
            print Zend_Json::encode($this->_Result);

        exit;
    }

    private function _returnTextResponse($response) {
        $this->_returnArrayResponse(array("message" => $response));
    }

    private function _processSaveRequest($documentId) {
        $fileManagement = new Application_Model_GrayMathFileManagement($this->_Identity, $this->_ShareId, $this->_Space);

        foreach ($_FILES as $fk) {
            if ($this->_Space == "personal")
                return ($fileManagement->uploadOverwrite($fk, $documentId, 1, $id) == 'success');
            else
                return ($fileManagement->uploadOverwrite($fk, $documentId, 0, $id) == 'success');
        }
    }

    private function _getDocumentId() {
        $document = $this->_request->getParam("document", "");

        if (!preg_match('/^\d+$/', $document)) {
            $this->_returnError("Document information not found.");
            exit;
        }

        return $document;
    }

    private function _getFolderId() {
        $folder = $this->_request->getParam("folder", "");

        if (!preg_match('/^\d+$/', $folder)) {
            $this->_returnError("Folder information not found.");
            exit;
        }

        return $folder;
    }

    private function varDumpToString($var) {
        ob_flush();
        ob_get_clean();
        ob_start();
        var_dump($var);
        $result = ob_get_clean();
        return $result;
    }

}

?>