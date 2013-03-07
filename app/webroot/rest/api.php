<?php

// use this link for get user details http://localhost/rest/users/
// database name rest
//than import file for database
// ini_set('display_errors', 1);
require_once("config.php");

require_once("S3.php");

class API extends REST {

    public function __construct() {
        parent::__construct();            // Init parent contructor
        $this->dbConnect();     // Initiate Database connection
    }

    // ***********************************database connection*************************
    private function dbConnect() {
        $this->db = mysql_connect(self::DB_SERVER, self::DB_USER, self::DB_PASSWORD);
        if ($this->db)
            mysql_select_db(self::DB, $this->db);
    }

    // Public method for access api.
    // This method dynmically call the method based on the query string
    //
		 
		public function processApi() {
        $func = strtolower(trim(str_replace("/", "", $_REQUEST['rquest'])));
        //echo $func;exit;
        if ((int) method_exists($this, $func) > 0)
            $this->$func();
        else
            $this->json(array("messgae" => "You cann't access filocity "));
        // If the method not exist with in this class, response would be "you cannt access filocity"
	
    }

    // ************************ Authentication ***********************************	

    public function auth() {
        // authentication  function 
        //  using username & email or  APIkey 


        if (isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
            $email = $_REQUEST['username'];
            $password = $_REQUEST['password'];
        } else {
            $email = '';
            $password = '';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password == '') {
            $key = $_REQUEST['secret'];

            if ($key == '') {
                $this->json_error_without_array("Invalid credentials");
            } else {

                $sqlquery = mysql_query(" SELECT * FROM users WHERE  status<>'0' AND auth_key='$key' ", $this->db);


                $users_array = mysql_fetch_array($sqlquery);
                if (count($users_array) > 0) {
                    $users_array["user_id"] = $users_array["id"];
                    $users_array["personal_space"] = 1;
                    $users_array["account_id"] = 0;
                    $users_array["is_guest"] = 0;
                    $users_array["time_zone"] = $users_array["timezone"];
                    $users_array['aws_access_key'] = $this->aws_access_key;
                    $users_array['aws_secret_key'] = $this->aws_secret_key;
                    $users_array['aws_bucket'] = $this->aws_bucket;
                    $this->Result["status"] = "OKAY";
                    $this->Result["result"][] = $users_array;
                    if (is_array($this->Result)) {
                        echo json_encode($this->Result);
                    }
                } else {
                    $this->json_error_without_array("Invalid credentials");
                }
            }
        } else {
            //  auth if email and password is not empty 
            $sqlquery = mysql_query("SELECT * FROM users WHERE  status<> '0' AND email='$email' ", $this->db);
            $users_array = mysql_fetch_array($sqlquery);
            $salt = 'DYhG93b0qyJfIxfs2guVoUubWwDFdfdashfasdhfDF$9475DHfyesrwesdfdasfniR2G0FgaC9mi';

            $password = sha1($salt . $password);
            if (count($users_array)) {
                if ($users_array['password'] == $password) {
                    $users_array["user_id"] = $users_array["id"];
                    $users_array["personal_space"] = 1;
                    $users_array["account_id"] = 0;
                    $users_array["is_guest"] = 0;
                    $users_array["time_zone"] = $users_array["timezone"];
                    $users_array['aws_access_key'] = $this->aws_access_key;   // return aws_access_key to user once at the time of auth 
                    $users_array['aws_secret_key'] = $this->aws_secret_key;    // return aws_secret key to user once at the time of auth
                    $users_array['aws_bucket'] = $this->aws_bucket;            // return aws_bucket to user once at the time of auth
                    $users_array['key'] = $users_array['auth_key'];
                    $this->json($users_array);
                } else {
                    $this->json_error_without_array("Invalid credentials ");
                }
            } else {
                $this->json_error_without_array("Invalid credentials ");
            }
        }
    }

//******************************** allowed extensions***********************************

    public function allowedextensions() {
        $user_id = $this->init(); // check  APIkey is valid or not if valid than return usewr_id for that user
        $ourext = $this->allowedExn; // getting all allowed extension  from Private  $allowedExn

        $allowExtArray = explode(',', $ourext); // explode extensions from $allowedExn
        $this->json_without_array($allowExtArray); // return all allowed 
    }

//************************************** Add folder **********************************           

    public function addfolder() {

        $parent = $_REQUEST['folder'];
        $Space = $_REQUEST['space'];
        $ShareId = $_REQUEST['share'];
        $foldername = $_REQUEST['foldername'];


        if (!preg_match('/^\d+$/', $parent)) {
            $this->json_error("Invalid Parent Folder."); // folder's parent id is valid or Invalid 
            exit;
        }

        $folderName = trim(urldecode($foldername));

        if ($folderName == '') {
            $this->json_error("Please Specify Folder Name."); // if folder name is blank  then " please specify fodler name "
            exit;
        }

        if ($Space == "shared" && $parent == 0) {
            $this->json_error("Sorry can't create root level folders in shared space."); // if space is shared and parent id =0 then Sorry can't create root level folders in shared space
            exit;
        }

        $result = $this->createFolder($folderName, $parent, $ShareId, $Space); // call createfolder ()

        if (intval($result) && $result > 0) {
            $this->json_without_array($result);
        } else {
            $this->json_error($result);
        }
    }

    private function createFolder($folderName, $parent, $SharedId, $Space, $status=1) {

        $user_id = $this->init(); // check APIkey is valid or invalid 
        $permission_status = $this->touchpermission(1, $Space); // checking permissions for personal, company and shared .. 
        // currently hard-coded for defination see touchpermission() method.
        if ($permission_status['write'] == 0) {
            return "This folder location specified does not exist in your space or you don't have the rights to this folder.";
            exit; //  space is invalid then user's write permission is =0 user cannt add folder in this space .
        }

        if ($permission_status['write'] == 1) {
            $sqlquery = mysql_query("SELECT * FROM users WHERE id='$user_id'");
            $users_array = mysql_fetch_array($sqlquery);
            // if space is company and parent id =0 
            if ($Space == 'company' && $parent == 0)
                $my_parent_id = $users_array['company_space_id'];
            else if ($Space == 'personal' && $parent == 0)                      // if space is personal and parent id =0 
                $my_parent_id = $users_array['my_space_id'];
            else
                $my_parent_id = $parent;


            // folder creation is in sub folder of any space 
            $sqlquery = "SELECT * FROM folders WHERE parent_id='$my_parent_id' AND name='$folderName'  AND user_id='$user_id' AND status='1'";
            $sqlquery = mysql_query($sqlquery, $this->db);
            $folders_array = mysql_fetch_array($sqlquery);
            if (mysql_num_rows($sqlquery) > 0) {        // check if folder is already exits or not 
                return array("message" => "Folder already exists.", "object_id" => $folders_array["id"]);
            } else { // folder not exists then create new folder 
                $created = date("Y-m-d H:i:s");
                $sqlquery = "INSERT INTO folders(name,user_id,parent_id,created,modified,status) VALUES('$folderName','$user_id','$my_parent_id','$created','$created','1')";

                if (mysql_query($sqlquery, $this->db)) {
                    $sqlquery = "SELECT * FROM folders WHERE parent_id='$my_parent_id' AND name='$folderName' AND user_id='$user_id' AND status='1'";

                    $sqlquery = mysql_query($sqlquery, $this->db);
                    $folders_array = mysql_fetch_array($sqlquery);
                    return array("message" => "Folder Created", "object_id" => $folders_array["id"]);
                }else
                    return array("message" => "Folder creation operation failed");
            }
        }
    }

    //****************************** touch permission( hard-coded) ***************************************


    public function touchpermission($ObjectType, $Space) {

        if ($Space == 'personal') {  // for personal space 
            $rightarray['access'] = 1;
            $rightarray['read'] = 1;
            $rightarray['write'] = 1;
            $rightarray['share'] = 1;
            $rightarray['print'] = 1;
            $rightarray['download'] = 1;
            return $rightarray;
        }
        if ($Space == 'shared') { // for shared space
            $rightarray['access'] = 1;
            $rightarray['read'] = 1;
            $rightarray['write'] = 1;
            $rightarray['share'] = 1;
            $rightarray['print'] = 1;
            $rightarray['download'] = 1;
            return $rightarray;
        } if ($Space == 'company') { // for company space 
            $rightarray['access'] = 1;
            $rightarray['read'] = 1;
            $rightarray['write'] = 1;
            $rightarray['share'] = 1;
            $rightarray['print'] = 1;
            $rightarray['download'] = 1;
            return $rightarray;
        } else {     //  user cann't access  
            $rightarray['access'] = 0;
            $rightarray['read'] = 0;
            $rightarray['write'] = 0;
            $rightarray['share'] = 0;
            $rightarray['print'] = 0;
            $rightarray['download'] = 0;
            return $rightarray;
        }
    }

//******************************** file save ******************************************
    public function save() {

        $Space = $_REQUEST['space']; // get the attribute values space ,  folder id , file size , uploadKeyName
        // $ShareId=$_REQUEST['share'];
        $folderId = $_REQUEST['folder'];
        $file_size = $_REQUEST['filesize'];
        $file_name = $_REQUEST['filename'];

        if (!preg_match('/^\d+$/', $folderId)) {
            $this->json_error("Invalid Paarent Folder."); // check folder id is valid or invalid 
            exit;
        }
        if ($file_size < 0) {   // check file size  " cannt upload file size is zero "
            return " Uploaded file  size Cann't be zero.";
        }
        if ($Space == "shared" && $folderId == 0) { // if  space is  shared and folder is root then cannt create folder 
            $this->json_error("Sorry Can't create root level folders in shared space.");
            exit;
        }

        $response = $this->upload($file_name, $file_size, $folderId, $Space); // call upload() method 
        if ($response) {

            $this->json_without_array(array("message" => $file_name . ' uploaded successfully.', "documentId" => $folderId, "UpdatedFileName" => $response));
        } else {
            $this->json_error($response);
        }
    }

    public function upload($file_name, $file_size, $folderId, $Space, $status=0) {
        $user_id = $this->init(); // check the APIkey is valid or invalid 
        $allowExtArray = explode(',', $this->allowedExn);
        $Filefilter = explode('.', $file_name);
        $name = $Filefilter[0];
        $extension = $Filefilter[1];

        $sqlquery = "SELECT * FROM users WHERE id='$user_id'";
        $sqlquery = mysql_query($sqlquery);
        $users_array = mysql_fetch_array($sqlquery);
        $username = $users_array['first_name'] . " " . $users_array['last_name'];
        $my_company_space = $users_array['company_space_id'];
        $my_personal_space = $users_array['my_space_id'];

        if ($Space == "company" && $folderId == 0) { // check if company space  and folderid =0 then 
            $folderId = $my_company_space;
        }
        if ($Space == "personal" && $folderId == 0) {// check if company space  and folderid =0 then
            $folderId = $my_personal_space;
        }
        $version = 1; //assuming
        // check if extension is valid      


        if (($allowExtArray[0] == "All") || ($extension != '' && array_search($extension, $allowExtArray) > -1)) {


            $sqlquery = "SELECT * FROM documents WHERE name='$name' AND ext='$extension' AND folder_id='$folderId' AND user_id='$user_id' AND status='1' AND in_progress='0'";

            $sqlquery = mysql_query($sqlquery, $this->db);
            $documents_array = mysql_fetch_array($sqlquery);

            if ($documents_array != false) {
                //check file is already uploaded or not 
                $document_id = $documents_array['id'];
                $document_name = $documents_array['name'];
                $document_file = $documents_array['file'];
                $document_ext = $documents_array['ext'];
                $document_ver = $documents_array['version'];
                $document_type = $documents_array['type'];
                $document_size = $documents_array['size'];
                $document_uid = $documents_array['user_id'];
                $document_fid = $documents_array['folder_id'];
                $document_status = $documents_array['status'];
                $document__created = $documents_array['created'];
                $document_cby = $documents_array['createdby'];
                $document_mby = $documents_array['modifiedby'];
                $document_mdified = $documents_array['modified'];


                //version history maintain then  update  bersion  of  the file 

                $version = ++$document_ver; // assuming for new file
                $modified = date("Y-m-d H:i:s");
                $created = date("Y-m-d H:i:s");
                //$hashkey = file_get_contents('http://www.filocity.com/auth/');
                // $sqlquery="insert into documents(name,version,size,modifiedby,modified,in_progress,status,user_id,ext,type,folder_id,created,createdby) values('$name','$version','$file_size','$username','$modified','1','1','$user_id','$extension','$extension','$folderId','$created','$username')";
                // if (!(mysql_query($sqlquery,  $this->db)))
                // {
                // // if update operation is failed than insert operation is failed and returnm NULL 
                // echo "insert operation failed ";
                // return NULL;
                // }
                // select file from documents 
                // $sqlquery="SELECT MAX(id) FROM documents WHERE name='$name' AND ext='$extension' AND folder_id='$folderId' AND user_id='$user_id' AND status=1 AND in_progress=1";
                // $sqlquery= mysql_query($sqlquery);
                // $documents_array=mysql_fetch_array($sqlquery);
                // $document_id=$documents_array[0];
                //  $uniqFileName = $document_id . '-' . $folderId . '.' .$extension . '-[[' .$version . "]]" .$hashkey;
                // $uniqFileName = $folderId . '-' . $document_id . '.' .$extension;
                $uniqFileName = $document_fid . '-' . $document_id . '.' . $document_ext;

                // $sqlquery="UPDATE documents SET file='$uniqFileName' WHERE name='$name' AND folder_id='$folderId' AND ext='$extension' AND user_id='$user_id' AND status=1 AND in_progress=1 ";
                // if(!mysql_query($sqlquery,  $this->db))
                // {
                // echo "insert operation failed2";
                // return NULL;
                // }else
                // {
                // return $uniqFileName;
                // }
                return $uniqFileName;
            }
            //  file name saved as this format [document_id]-[folder_id].[ext][[v]] + [[hash]];
            else { // if document is not found in documents table 
                $version = 1; // assuming for new file
                $status = 0;
                $created = date("Y-m-d H:i:s");
                $modified = date("Y-m-d H:i:s");
                $hashkey = file_get_contents('http://www.filocity.com/auth/');

                // insert in documents  table   for new documents 
                $sqlquery = "INSERT INTO documents(name,ext,version,type,size,user_id,folder_id,created,createdby,modifiedby,modified,status,in_progress) VALUES('$name','$extension','$version','$extension','$file_size','$user_id','$folderId','$created','$username','$username','$created',1,1)";
                if (!(mysql_query($sqlquery, $this->db))) {
                    echo "insert operation failed ";
                    return "insert operation failed ";
                    // return NULL;
                }
                $document_id = mysql_insert_id();
                // $uniqFileName = $document_id . '-' . $folderId . '.' .$extension . '-[[' .$version . "]]" .$hashkey;
                $uniqFileName = $folderId . '-' . $document_id . '.' . $extension;

                $sqlquery = "UPDATE documents SET file='$uniqFileName' WHERE name='$name' AND ext='$extension' AND folder_id='$folderId' AND user_id='$user_id'  AND id='$document_id' AND status=1 AND in_progress=1";
                $sqlquery = mysql_query($sqlquery, $this->db);
                return $uniqFileName;
            }
        } else {
            return "$extension file type is not allowed for $file_name";
            // file extension not allowed for 
        }
    }

    public function upstatus() {

        // update document  status  after  document succesfully then update status otherwise status=0 
        $user_id = $this->init();
        $parent_id = $_REQUEST['folder'];
        $Space = $_REQUEST['space'];
        $name = $_REQUEST['filename'];
        $filename_ext = explode('.', $name);
        $sqlquery = "SELECT * FROM users WHERE id='$user_id'";
        $sqlquery = mysql_query($sqlquery);
        $users_array = mysql_fetch_array($sqlquery);
        $my_company_space = $users_array['company_space_id'];
        $my_personal_space = $users_array['my_space_id'];
        if ($Space == "company" && $parent_id == 0) {
            $parent_id = $my_company_space;
        }
        if ($Space == "personal" && $parent_id == 0) {
            $parent_id = $my_personal_space;
        }

        $sqlquery = "SELECT MAX(id) FROM documents WHERE user_id='$user_id' AND folder_id='$parent_id' AND name='$filename_ext[0]' AND ext='$filename_ext[1]'";
        $sqlquery = mysql_query($sqlquery);
        $users_id = mysql_fetch_array($sqlquery);




        $sqlquery = "UPDATE documents SET in_progress='0' WHERE user_id='$user_id' AND folder_id='$parent_id' AND name='$filename_ext[0]' AND ext='$filename_ext[1]' AND id='$users_id[0]'";
        $sqlquery = mysql_query($sqlquery);
        $this->json_without_array(array("message" => "File successfully updated."));
    }

    //****************************** Delete Objects***************************************
    public function deleteobject() {

        $Space = $_REQUEST['space']; // get attributes value 
        $ShareId = $_REQUEST['share'];
        $user_id = $this->init();

        $id = (int) $_REQUEST['object_id'];

        if ($id == 0) { // check if object id =0 
            $this->json_error("Object id is invalid/missed.");
            exit;
        }

        $type = (int) $_REQUEST['object_type']; // check if object type valid or invalid
        if ($type == 0) {
            $this->json_error("Object type is invalid/missed.");
            exit;
        }
        $rightpermission = $this->touchpermission(1, $Space); // check the access permissions
        if ($rightpermission['access'] == 0) {
            $this->json_error("You are not eligible to perform this operation.");
            exit;
        }

        if ($rightpermission['write'] == 1) {

            if ($type == 1) { // if type=1 then for folder 
                $this->deleteFolder($id, $user_id);
            } else {  // type=2 then file
                $this->deleteFile($id, $user_id);
            }
            $object_type = array('0' => 'asset', '1' => 'folder', '2' => 'file');
            $this->json_without_array(array('object_id' => $id, 'message' => ucfirst($object_type[$type]) . ' has been deleted successfully.'));

            exit;
        }
    }

    private function deleteFolder($folderId, $user_id) {



        $sqlquery = "SELECT id FROM folders WHERE parent_id='$folderId' AND user_id='$user_id' AND status='1'";
        $sqlquery_for_loop = mysql_query($sqlquery);

        $sqlquery = "UPDATE folders set status='0' Where id='$folderId' AND user_id='$user_id' AND status='1' ";
        $sqlquery = mysql_query($sqlquery);
        $sqlquery = "UPDATE documents set status='0' Where folder_id='$folderId' AND user_id='$user_id' AND status='1' AND in_progress='0'";
        $sqlquery = mysql_query($sqlquery);

        while ($folders_array_use = mysql_fetch_array($sqlquery_for_loop, MYSQL_NUM)) {
            $sqlquery = "UPDATE folders set status='0' Where id='$folders_array_use[0]'";
            $sqlquery = mysql_query($r);
            $sqlquery = "UPDATE documents set status='0' Where folder_id='$folders_array_use[0]'";
            $sqlquery = mysql_query($sqlquery);
            $this->deleteFolder($folders_array_use[0], $user_id);
        }
    }

    private function deleteFile($fileId, $user_id) {
        $sqlquery = "SELECT folder_id, name from documents where id='$fileId'";
        $sqlquery = mysql_query($sqlquery);
        $sqlquery = mysql_fetch_array($sqlquery);
        $parent_id = $sqlquery['folder_id'];
        $name = $sqlquery['name'];

        // change status if file is delted .. status=0 , now folder is not visible to users 
        $sqlquery = "UPDATE documents SET status='0' WHERE folder_id='$parent_id' AND name='$name' AND user_id='$user_id' AND status='1' AND in_progress='0'";
        // $q="DELETE FROM documents WHERE id='$fileId' AND user_id='$user_id'";
        $sqlquery = mysql_query($sqlquery);
    }

    //**************************************** move folder and files********************************* 
    public function move() {

        $Space = $_REQUEST['space']; // get the value of attributes 
        $ShareId = $_REQUEST['share'];
        $chk2 = $_REQUEST['source'];
        $folderId = $_REQUEST['destination'];
        $user_id = $this->init();

        $rights = $this->touchpermission(1, $Space); // check the permisson for access

        if ($rights['write'] == 0) {


            return "This folder location specified does not exist in your space or you don't have the rights to this folder.";
            exit;
        }

        if ($rights['write'] == 1) {
            if ($chk2 == '') // check if source is 0 then exit;
                exit;

            $chk = explode(",", $chk2);
            $result = $this->moveItems($user_id, $chk[0], $folderId);

            if ($result == 'success') {
                $this->json_without_array(array("message" => "Object moves successfully."));
            } else {

                $this->json_error_without_array($result);
            }
        }
    }

    public function moveItems($user_id, $itemList, $folderId) {
        $res = '';
        //foreach ($itemList as $item) {
        list($type, $id) = explode("-", $itemList);

        if ($type == 1) { // move operation for object type =1 for folder
            if ($folderId > 0) {
                //check if item already exists
                if ($folderId == $id) {
                    return "Invalid Operation.";
                }
                $sqlquery = "SELECT * FROM folders where id='$id'";
                $sqlquery = mysql_query($sqlquery);
                $folders_array = mysql_fetch_array($sqlquery);
                $fname = $folders_array['name'];
                $sqlquery = "Select * from folders where parent_id='$folderId' AND name='$fname' AND user_id='$user_id' AND status='1'";
                $sqlquery = mysql_query($sqlquery, $this->db);

                if (mysql_num_rows($sqlquery) > 0) {

                    return "Cannot move. Folder already exists.";
                }

                $sqlquery = "UPDATE folders SET parent_id='$folderId' WHERE id='$id' AND name='$fname'  AND user_id='$user_id' AND status='1'";
                $sqlquery = mysql_query($sqlquery, $this->db);
                $res = 'success';
            }
        } else { // move operation for object type =2 for files
            if ($folderId > 0) {
                $sqlquery = "SELECT * FROM documents where id='$id'";
                $sqlquery = mysql_query($sqlquery);
                $sqlquery = mysql_fetch_array($sqlquery);
                $fname = $sqlquery['name'];
                $fext = $sqlquery['ext'];
                $sqlquery = "Select * from documents where folder_id='$folderId' AND name='$fname' AND ext='$fext' AND user_id='$user_id' AND status='1' AND in_progress='0'";
                $sqlquery = mysql_query($sqlquery, $this->db);
                if (mysql_num_rows($sqlquery) > 0)
                    return "Cannot move. File already exists.";
                $sqlquery = "UPDATE documents SET folder_id='$folderId' WHERE  name='$fname' AND ext='$fext' AND user_id='$user_id'  AND status='1' AND in_progress='0'";
                $sqlquery = mysql_query($sqlquery, $this->db);
                $res = 'success';
            }
        }

        //}
        if ($res == 'success') {
            //echo 'success';
            return 'success';
        } else {
            //echo 'Unable to move';
            return 'Unable to move';
        }
    }

    //********************************************listing ************************************ 



    public function lists() {


        $Space = $_REQUEST['space']; // get the values of attributes
        $ShareId = $_REQUEST['share'];
        $showFiles = $_REQUEST['everything'];

        $folderId = $this->getFolderId(); // get the folder id after validate 

        $list = $this->getList($folderId, $showFiles, $Space, $ShareId); // call getList()
        $this->json_without_array(array("folders" => $list));
    }

    public function getList($folderId, $includeFiles=1, $Space, $ShareId) {


        $user_id = $this->init(); // auth using api key
        $rights = $this->touchpermission(1, $Space); // check the permission 
        if ($rights['write'] == 0) {// if access permission is 0 then exit
            return "This folder location specified does not exist in your space or you don't have the rights to this folder.";
            exit;
        }

        if ($rights['write'] == 1) { // if access permission is 1 
            $sqlquery = "SELECT * FROM users WHERE id='$user_id'";
            $sqlquery = mysql_query($sqlquery);
            $users_array = mysql_fetch_array($sqlquery);  // get the  company_space_id & my_space_id from user table for company & personal space
            $company_space_id = $users_array['company_space_id']; // parent foldser id in company space && folder_id=0
            $my_space_id = $users_array['my_space_id']; // parent foldser id in personal space && folder_id=0
            if ($Space == 'company') {
                if ($folderId == 0) {
                    $sqlquery = " SELECT * FROM (SELECT id as object_id, '1' as object_type_id, name as object_title, 'folder' as file_type, '1' as can_read, '1' as can_write, '1' as can_share, '1' as can_print, '1' as can_download , '0' as subscribed, created as create_on, parent_id as folder_id, NULL as object_version, '0' as file_count,'0' as folder_count ,NULL as visual_ref, modified as update_on, '0' as file_size, '0' as task_count, '0' as unread_comments, '0' as share_count, '0' as active_count, '0' as pending_count, '0' as comment_count,'0' as share_id, NULL as shared_by,'0' as  shared_by_id,'2011-12-09 22:00:34' as  share_date_utc, createdby as created_by, modifiedby as last_modified_by, '' as file_hash  FROM folders WHERE parent_id='$company_space_id' AND status='1'    UNION  SELECT (id) as object_id, '2' as object_type_id,name as object_title, type as file_type, '1' as can_read, '1' as can_write, '1' as can_share, '1' as can_print, '1' as can_download , '0' as subscribed, created as create_on, folder_id as folder_id,version as object_version, '0' as file_count,'0' as folder_count, NULL as visual_ref, modified as update_on, size as file_size, '0' as task_count, '0' as unread_comments, '0' as share_count, '0' as active_count, '0' as pending_count, '0' as comment_count ,'0' as share_id, NULL as shared_by,'0' as  shared_by_id,'0000-00-00 00:00:00' as  share_date_utc, createdby as created_by,createdby as last_modified_by, '' as file_hash FROM documents WHERE folder_id='$company_space_id' AND status='1'  AND in_progress='0'   ) as table2 ";
                } else {
                    $sqlquery = " SELECT * FROM (SELECT id as object_id, '1' as object_type_id, name as object_title, 'folder' as file_type, '1' as can_read, '1' as can_write, '1' as can_share, '1' as can_print, '1' as can_download , '0' as subscribed, created as create_on, parent_id as folder_id, NULL as object_version, '0' as file_count,'0' as folder_count ,NULL as visual_ref, modified as update_on, '0' as file_size, '0' as task_count, '0' as unread_comments, '0' as share_count, '0' as active_count, '0' as pending_count, '0' as comment_count,'0' as share_id, NULL as shared_by,'0' as  shared_by_id,'2011-12-09 22:00:34' as  share_date_utc, createdby as created_by, modifiedby as last_modified_by, '' as file_hash  FROM folders WHERE parent_id='$folderId' AND status='1'    UNION  SELECT (id) as object_id, '2' as object_type_id,name as object_title, type as file_type, '1' as can_read, '1' as can_write, '1' as can_share, '1' as can_print, '1' as can_download , '0' as subscribed, created as create_on, folder_id as folder_id,version as object_version, '0' as file_count,'0' as folder_count, NULL as visual_ref, modified as update_on, size as file_size, '0' as task_count, '0' as unread_comments, '0' as share_count, '0' as active_count, '0' as pending_count, '0' as comment_count ,'0' as share_id, NULL as shared_by,'0' as  shared_by_id,'0000-00-00 00:00:00' as  share_date_utc, createdby as created_by,createdby as last_modified_by, '' as file_hash FROM documents WHERE folder_id='$folderId' AND status='1'  AND in_progress='0'   ) as table2 ";
                }
                $sqlquery = mysql_query($sqlquery, $this->db);
                $result = array();

                while ($line = mysql_fetch_array($sqlquery, MYSQL_ASSOC)) {
                    $result[] = $line;
                }
                return $result;
                break;
            } else

            if ($Space == 'personal') {

                if ($folderId == 0) {
                    $sqlquery = " SELECT * FROM (SELECT id as object_id, '1' as object_type_id, name as object_title, 'folder' as file_type, '1' as can_read, '1' as can_write, '1' as can_share, '1' as can_print, '1' as can_download , '0' as subscribed, created as create_on, parent_id as folder_id, NULL as object_version, '0' as file_count,'0' as folder_count ,NULL as visual_ref, modified as update_on, '0' as file_size, '0' as task_count, '0' as unread_comments, '0' as share_count, '0' as active_count, '0' as pending_count, '0' as comment_count,'0' as share_id, NULL as shared_by,'0' as  shared_by_id,'2011-12-09 22:00:34' as  share_date_utc, createdby as created_by, modifiedby as last_modified_by, '' as file_hash  FROM folders WHERE parent_id='$my_space_id' AND status='1' AND user_id='$user_id'   UNION  SELECT (id) as object_id, '2' as object_type_id,name as object_title, type as file_type, '1' as can_read, '1' as can_write, '1' as can_share, '1' as can_print, '1' as can_download , '0' as subscribed, created as create_on, folder_id as folder_id,version as object_version, '0' as file_count,'0' as folder_count, NULL as visual_ref, modified as update_on, size as file_size, '0' as task_count, '0' as unread_comments, '0' as share_count, '0' as active_count, '0' as pending_count, '0' as comment_count ,'0' as share_id, NULL as shared_by,'0' as  shared_by_id,'0000-00-00 00:00:00' as  share_date_utc, createdby as created_by,createdby as last_modified_by, '' as file_hash FROM documents WHERE folder_id='$my_space_id' AND status='1' AND user_id='$user_id' AND in_progress='0'   ) as table2 ";
                } else {
                    $sqlquery = " SELECT * FROM (SELECT id as object_id, '1' as object_type_id, name as object_title, 'folder' as file_type, '1' as can_read, '1' as can_write, '1' as can_share, '1' as can_print, '1' as can_download , '0' as subscribed, created as create_on, parent_id as folder_id, NULL as object_version, '0' as file_count,'0' as folder_count ,NULL as visual_ref, modified as update_on, '0' as file_size, '0' as task_count, '0' as unread_comments, '0' as share_count, '0' as active_count, '0' as pending_count, '0' as comment_count,'0' as share_id, NULL as shared_by,'0' as  shared_by_id,'2011-12-09 22:00:34' as  share_date_utc, createdby as created_by, modifiedby as last_modified_by, '' as file_hash  FROM folders WHERE parent_id='$folderId' AND status='1' AND user_id='$user_id'   UNION  SELECT (id) as object_id, '2' as object_type_id,name as object_title, type as file_type, '1' as can_read, '1' as can_write, '1' as can_share, '1' as can_print, '1' as can_download , '0' as subscribed, created as create_on, folder_id as folder_id,version as object_version, '0' as file_count,'0' as folder_count, NULL as visual_ref, modified as update_on, size as file_size, '0' as task_count, '0' as unread_comments, '0' as share_count, '0' as active_count, '0' as pending_count, '0' as comment_count ,'0' as share_id, NULL as shared_by,'0' as  shared_by_id,'2012-11-22 21:16:10' as  share_date_utc, createdby as created_by,createdby as last_modified_by, '' as file_hash FROM documents WHERE folder_id='$folderId' AND status='1' AND user_id='$user_id' AND in_progress='0'   ) as table2 ";
                }
                $sqlquery = mysql_query($sqlquery, $this->db);
                $result = array();

                while ($line = mysql_fetch_array($sqlquery, MYSQL_ASSOC)) {
                    $result[] = $line;
                }
                return $result;
                break;
            }
            if ($Space == 'shared') {

                $sqlquery = "SELECT fol.id as object_id, '1' as object_type_id, name as object_title, 'folder' as file_type, '1' as can_read, '1' as can_write, '1' as can_share, '1' as can_print, '1' as can_download , '0' as subscribed, fol.created as create_on, fol.id as folder_id, NULL as object_version, '0' as file_count,'0' as folder_count ,NULL as visual_ref, fol.modified as update_on, '0' as file_size, '0' as task_count, '0' as unread_comments, '1' as share_count, '0'  as active_count, '0' as pending_count, '0' as comment_count, shar.id as share_id, NULL as shared_by, shar.user_id as shared_by_id,'2012-11-22 21:16:10' as share_date_utc, fol.createdby as created_by,fol.modifiedby as last_modified_by, '' as file_hash FROM folders fol INNER JOIN shares shar ON fol.id =shar.folder_id WHERE shar.user2_id='$user_id' AND fol.status='1' UNION SELECT doc.id as object_id, '2' as object_type_id, name as object_title, ext as file_type, '1' as can_read, '1' as can_write, '1' as can_share, '1' as can_print, '1' as can_download , '0' as subscribed, doc.created as create_on, doc.folder_id as folder_id, version as object_version, '0' as file_count,'0' as folder_count ,NULL as visual_ref, doc.modified as update_on, size as file_size, '0' as task_count, '0' as unread_comments, '0' as share_count, '0' as active_count, '0' as pending_count, '0' as comment_count,shar.id as share_id, NULL as shared_by, shar.user_id as shared_by_id,'2012-11-22 21:16:10' as share_date_utc, doc.createdby as created_by,doc.modifiedby as last_modified_by, '' as file_hash FROM documents doc INNER JOIN shares shar ON  doc.id =shar.document_id WHERE   doc.status='1' and shar.user2_id='$user_id'";

                $sqlquery = mysql_query($sqlquery);
                $result = array();

                while ($line = mysql_fetch_array($sqlquery, MYSQL_ASSOC)) {
                    $result[] = $line;
                }
                return $result;
                break;
            } else {



                $sqlquery = " SELECT * FROM (SELECT id as object_id, '1' as object_type_id, name as object_title, 'folder' as file_type, '1' as can_read, '1' as can_write, '1' as can_share, '1' as can_print, '1' as can_download , '0' as subscribed, created as create_on, parent_id as folder_id, NULL as object_version, '0' as file_count,'0' as folder_count ,NULL as visual_ref, modified as update_on, '0' as file_size, '0' as task_count, '0' as unread_comments, '0' as share_count, '0' as active_count, '0' as pending_count, '0' as comment_count,'0' as share_id, NULL as shared_by,'0' as  shared_by_id,'2011-12-09 22:00:34' as  share_date_utc, createdby as created_by, modifiedby as last_modified_by, '' as file_hash  FROM folders WHERE parent_id='$folderId' AND status='1' AND user_id='$user_id'   UNION  SELECT (id) as object_id, '2' as object_type_id,name as object_title, type as file_type, '1' as can_read, '1' as can_write, '1' as can_share, '1' as can_print, '1' as can_download , '0' as subscribed, created as create_on, folder_id as folder_id,version as object_version, '0' as file_count,'0' as folder_count, NULL as visual_ref, modified as update_on, size as file_size, '0' as task_count, '0' as unread_comments, '0' as share_count, '0' as active_count, '0' as pending_count, '0' as comment_count ,'0' as share_id, NULL as shared_by,'0' as  shared_by_id,'2012-11-22 21:16:10' as  share_date_utc, createdby as created_by,createdby as last_modified_by, '' as file_hash FROM documents WHERE folder_id='$folderId' AND status='1' AND user_id='$user_id' AND in_progress='0'   ) as table2 ";

                $sqlquery = mysql_query($sqlquery, $this->db);
                $result = array();


                while ($line = mysql_fetch_array($sqlquery, MYSQL_ASSOC)) {
                    $result[] = $line;
                }
                return $result;
                break;
            }
        }
    }

//*************************************************download file or folder********************************
    public function get() {
        $user_id = $this->init();
        $Space = $_REQUEST['space'];
        $ShareId = $_REQUEST['share'];
        $filename_extension = $_REQUEST['filename'];
        $extrated_filename = explode('.', $filename_extension);
        $Folder = $_REQUEST['folder'];


        $sqlquery = "SELECT  id , version , file FROM documents WHERE name='$extrated_filename[0]' AND ext='$extrated_filename[1]' AND folder_id='$Folder' AND user_id='$user_id' AND status='1' AND in_progress='0' and id in (select max(id) FROM documents WHERE name='$extrated_filename[0]' AND ext='$extrated_filename[1]' AND folder_id='$Folder' AND user_id='$user_id' AND status='1' AND in_progress='0' )";
        $sqlquery = mysql_query($sqlquery);
        $documents_array = mysql_fetch_array($sqlquery);
        $file = $documents_array['file'];
        return $this->json_without_array(array("filename" => $file));
    }

//******************************************rename Objects ***********************************
    public function renameobject() {  // rename file objects
        $id = (int) $_REQUEST['object_id'];

        if ($id == 0) {                       // check  object id is valid or invalid 
            $this->json_error("Object id is invalid/missed.");
            exit;
        }

        $type = (int) $_REQUEST['object_type']; // check object type is valid or invalid 
        if ($type == 0) {
            $this->json_error("Object type is invalid/missed.");
            exit;
        }

        $newName = $_REQUEST['newname']; //check newName valid or invalid 
        if (trim($newName) == '') {
            $this->json_error("Object new name is invalid/missed.");
            exit;
        }

        $rename_status = $this->rename($type, $id, $newName); // call rename ()
        if ($rename_status == "success") { // renamed successfully then return success 
            $object_type = array('0' => 'asset', '1' => 'folder', '2' => 'file');
            $this->json_without_array(array('object_id' => $id, 'message' => ucfirst($object_type[$type]) . ' has been renamed successfully.'));
        } else {
            $this->json_error_without_array($rename_status);
        }
        exit;
    }

    public function rename($objectTypeId, $objectId, $newName) {
        $user_id = $this->init();

        if ($objectTypeId == 1) /* 1 = folder */ {



            $sqlquery = "SELECT * FROM folders WHERE id='$objectId' AND user_id='$user_id'";
            $sqlquery = mysql_query($sqlquery);
            $folders_array = mysql_fetch_array($sqlquery);
            $parent_id_old = $folders_array['parent_id'];


            $sqlquery = "SELECT * FROM folders WHERE name='$newName' AND user_id='$user_id'";
            $sqlquery = mysql_query($sqlquery, $this->db);
            $folders_array = mysql_fetch_array($sqlquery);
            $parent_id_new = $folders_array['parent_id'];

            if ($parent_id_old == $parent_id_new)
            // check if it is already in data base 
                return "Cannot rename Folder. This name already exists under this folder.";
            else {
                // if not then reanamed successfully .
                $sqlquery = "UPDATE folders SET name='$newName' WHERE id='$objectId' AND user_id='$user_id' ";
                //$sqlquery=mysql_query($sqlquery);
//                        $sqlquery="SELECT * FROM folders WHERE id='$objectId'";
//            $sqlquery=mysql_query($sqlquery);
//            $folders_array=mysql_fetch_array($sqlquery);
//            $fnewName=$folders_array['name'];

                if (mysql_query($sqlquery)) {
                    return "success";
                } else {
                    return "Unknow error";
                }
            }
        } else /* else 2 = file */ {

            $sqlquery = "SELECT * FROM documents WHERE id='$objectId' AND  user_id='$user_id' AND status='1' AND in_progress='0'";
            $sqlquery = mysql_query($sqlquery);
            $documents_array = mysql_fetch_array($sqlquery);
            $folder_id_old = $documents_array['folder_id'];
            $old_name = $documents_array['name'];
            $extension = $documents_array['ext'];
            $parent_old = $documents_array['folder_id'];



            $sqlquery = "SELECT * FROM documents WHERE name='$newName' AND folder_id='$parent_old' AND status='1' AND  user_id='$user_id'  AND in_progress='0'";
            $sqlquery = mysql_query($sqlquery, $this->db);
            $documents_array = mysql_fetch_array($sqlquery);
            $folder_id_new = $documents_array['folder_id'];

            if ($folder_id_old == $folder_id_new)
            // check if it is already in data base 
                return "Cannot rename file. This name already exists under this folder.";
            else {
                // if not then reanamed successfully .
                $sqlquery = "UPDATE documents SET name='$newName' WHERE name='$old_name' AND  user_id='$user_id' AND ext='$extension'AND status='1' AND in_progress='0' ";
                // $sqlquery=mysql_query($sqlquery);
//               $sqlquery="SELECT * FROM documents WHERE id='$objectId'";
//            $sqlquery=mysql_query($sqlquery);
//            $documents_array=mysql_fetch_array($sqlquery);
//            $fnewName=$documents_array['name'];

                if (mysql_query($sqlquery)) {
                    return "success";
                } else {
                    return "Unknow error";
                }
            }
        }
    }

//************************************** encode array into json ******************************************

    /*
     * 	Encode array into JSON
     */
    private function json(array $data) {

        $this->Result["status"] = "OKAY";
        $this->Result["result"][] = $data;
        if (is_array($this->Result)) {
            echo json_encode($this->Result);
        }
    }

    private function json_without_array(array $data) { // encode the array into json
        $this->Result["status"] = "OKAY";
        $this->Result["result"] = $data;
        if (is_array($this->Result)) {
            echo json_encode($this->Result);
        }
    }

    private function json_error_without_array($data) { // error json
        $this->Result["status"] = "FAIL";
        $this->Result["result"] = array("message" => $data);
        if (is_array($this->Result)) {
            echo json_encode($this->Result);
        }
    }

    private function json_error($data) { // error json
        $this->Result["status"] = "FAIL";
        $this->Result["result"][] = array("message" => $data);
        if (is_array($this->Result)) {
            echo json_encode($this->Result);
        }
    }

//          private function _returnTextResponse($response) {
//                    $this->json(array("message" => $response));
//                }
//                        
    //*****************************************folder id check *************************************                       

    private function getFolderId() { // get the foilder id is id is valid 
        
        $folder = $_REQUEST['folder'];

        if (!preg_match('/^\d+$/', $folder)) {
            $this->json_error("Folder information not found.");
            exit;
        }

        return $folder;
    }

    public function init() { // check API key is valid or invalid and return  user_id 
        $id = 0;
        $current_date = date('Y-m-d');
        $key = $_REQUEST['secret'];
        if ($key == null) {
            $this->json_error("Secret not found.");
            exit;
        }

        $q = "SELECT * FROM users WHERE auth_key='$key'";
        $result1 = mysql_query($q, $this->db);
        while ($result = mysql_fetch_array($result1)) {
            $id = $result['id'];
            $expire_on = $result['trial_end'];
        }

        if ($id == 0) {
            $this->json_error("Secret not found.");
            exit;
        }
        else
            return $id;




        if ($current_date < $expire_on) {
            return $this->json_error("Associated account Expire ");
            exit;
        }
    }

    // code for pdf file uploader ** 09/02/2012 **
   /* public function upload_pdf() {
            //$secret = $_REQUEST['secret'];
           // $company = $_REQUEST['company'];
            //$space   = $_REQUEST['space'];
            //$auth = $this->authenticate();
           // if($auth)
           // {
            $accessKey = $this->aws_access_key;
            $secretKey = $this->aws_secret_key;
            $bucket = $this->aws_bucket;
            $file_name = $_FILES["file"]["name"];
            $Filefilter = explode('.', $file_name);
            $name = $Filefilter[0];
            $extension = $Filefilter[1];
            $file_size = $_FILES["file"]["size"];
            $folderId = $_POST['FolderId'];
            $user_id = $_POST['UserId'];
            $crocodoc_uuid = "1";
            $version = 1; // assuming for new file
            $status = 0;
            $created = date("Y-m-d H:i:s");
            $sqlquery = "SELECT * FROM users WHERE id='$user_id'";
            $sqlquery = mysql_query($sqlquery);
            $users_array = mysql_fetch_array($sqlquery);
            $username = $users_array['first_name'] . " " . $users_array['last_name'];
            $my_company_space = $users_array['company_space_id'];
            $my_personal_space = $users_array['my_space_id'];
            $sqlquery = "INSERT INTO documents(name,ext,version,type,size,user_id,folder_id,crocodoc_uuid,created,createdby,modifiedby,modified,status,in_progress) VALUES('$name','$extension','$version','$extension','$file_size','$user_id','$folderId', '$crocodoc_uuid','$created','$username','$username','$created',1,1)";
            if ((mysql_query($sqlquery, $this->db))) {
                $document_id = mysql_insert_id();
               
            
            $tmp_name = $_FILES["file"]["tmp_name"];
           // $dir = 'uploads/';
           //$new_name = $dir .$folderId."-". $document_id . '.pdf';
             $new_name = $folderId."-". $document_id;
           // $file_name = $folderId."-".$document_id . '.pdf';
             move_uploaded_file($tmp_name, 'swf/'.$new_name.".".$extension);
             $url = "/var/www/html/app/webroot/rest/swf/".$new_name.".".$extension;
             $totalPages = intval(shell_exec("identify -format %n '$url'"));
             $swf_path = "/var/www/html/app/webroot/rest/swf/".$new_name."%.swf";
            shell_exec("pdf2swf -v -t -T 9 '$url' -o '$swf_path'");
            $s3 = new S3($accessKey, $secretKey);
            if ($s3->putObjectFile($url, $bucket, $new_name.".".$extension, S3::ACL_PUBLIC_READ_WRITE)) {
                   $sqlquery = "UPDATE documents SET file='$new_name.$extension', in_progress='0' WHERE id='$document_id'";
               if (!(mysql_query($sqlquery, $this->db))) {
            echo "<br/>update operation failed ";
           }
           else{
               for($i = 1; $i <= $totalPages; $i++){
                        $swf_path1 = "/var/www/html/app/webroot/rest/swf/".$new_name.$i.".swf";
                        $s3->putObjectFile($swf_path1, $bucket, "swf/".$new_name.$i.".swf", S3::ACL_PUBLIC_READ_WRITE);
                         unlink($swf_path1);
           }
                 echo $totalPages.",".$new_name;
                  
                 unlink($url);   
                
            }
            } 
            }
           
         else{
                echo "operation failed";
           }
                                
    }*/
 public function save_pdf() {
           
                    $secret = $_REQUEST['secret'];
                    $Space = $_REQUEST['space'];
                    //$name = $_REQUEST['name'];
                    $convert = $_REQUEST['convert'];
                    $url = NULL;
                    if($_REQUEST['folderid'])
                    {
                    $folderId = $_REQUEST['folderid'];
                    }
                    else
                    {
                        $folderId = 0;
                    }
                    $sqlquery = "SELECT * FROM users WHERE auth_key='$secret'";
                    $sqlquery = mysql_query($sqlquery);
                    $users_array = mysql_fetch_array($sqlquery);
                    if($users_array > 0){
                            if (!preg_match('/^\d+$/', $folderId)) {
                                    echo "Invalid Paarent Folder."; // check folder id is valid or invalid 
                                    exit;
                            }
                            if ($Space == "shared" && $folderId == 0) { // if  space is  shared and folder is root then cannt create folder 
                                    echo "Sorry Can't create root level folders in shared space.";
                                    exit;
                            }
                            $accessKey = $this->aws_access_key;
                            $secretKey = $this->aws_secret_key;
                            $bucket = $this->aws_bucket;
                            $user_id = $users_array['id'];
                                $crocodoc_uuid = "1";
                                $version = 1; // assuming for new file
                                $status = 0;
                                $created = date("Y-m-d H:i:s");
                                $username = $users_array['first_name'] . " " . $users_array['last_name'];
                                $my_company_space = $users_array['company_space_id'];
                                $my_personal_space = $users_array['my_space_id'];
                                if ($Space == "company" && $folderId == 0) { // check if company space  and folderid =0 then 
                                        $folderId = $my_company_space;
                                }
                                if ($Space == "personal" && $folderId == 0) {// check if company space  and folderid =0 then
                                       $folderId = $my_personal_space;
                                }
                            if($_REQUEST['filename'])
                            {
                                    $file_name = $_REQUEST['filename'];
                            }
                            if(isset($GLOBALS["HTTP_RAW_POST_DATA"]))
                            {
                                   if(isset($GLOBALS["HTTP_RAW_POST_DATA"])){
                                            $pdf = $GLOBALS["HTTP_RAW_POST_DATA"];
                                            $old_name = $_REQUEST["filename"];
                                            $url = "/home/www/htdocs/app/webroot/rest/swf/". $old_name;
                                            file_put_contents($url, $pdf);
                                            $Filefilter = explode('.', $old_name);
                                            $name = $Filefilter[0];
                                            $extension = $Filefilter[1];
                                            $file_size = filesize($url);
                                            $sqlquery = "SELECT * FROM documents WHERE folder_id='$folderId' AND name = '$name'";
                                            $sqlquery = mysql_query($sqlquery);
                                            $result_set = mysql_fetch_array($sqlquery);
                                            if($result_set > 0){
						$old_fileid = $result_set['id'];
						 $version = $result_set['version'];
						 $version = $version + 1;
						$sqlquery = "UPDATE documents SET status='0' WHERE id='$old_fileid'";
                                               
												
						if (!(mysql_query($sqlquery, $this->db))) {
								echo "update operation failed";
						}
                                            }
                                    } 
                                    else{
                                           echo "Sorry Can't create root level folders in shared space.";
                                           exit;
                                    }
                            }
                            else if($_FILES["Filedata"]["name"])
                            {
                                $file_name = $_FILES["Filedata"]["name"];
                                $Filefilter = explode('.', $file_name);
                                $name = $Filefilter[0];
                                $extension = $Filefilter[1];
                                $file_size = $_FILES["Filedata"]["size"];
                                  $sqlquery = "SELECT * FROM documents WHERE folder_id='$folderId' AND name = '$name'";
                                            $sqlquery = mysql_query($sqlquery);
                                            $result_set = mysql_fetch_array($sqlquery);
                                            if($result_set > 0){
						$old_fileid = $result_set['id'];
						 $version = $result_set['version'];
						 $version = $version + 1;
						$sqlquery = "UPDATE documents SET status='0' WHERE id='$old_fileid'";
                                
						if (!(mysql_query($sqlquery, $this->db))) {
								echo "update operation failed";
						}
                                            }
                            }
                            
                            else{
                                 echo "No File Data available";
                                 exit;
                            }
                                //$folderId = $_POST['FolderId'];
                                                        $sqlquery = "INSERT INTO documents(name,ext,version,type,size,user_id,folder_id,crocodoc_uuid,created,createdby,modifiedby,modified,status,in_progress) VALUES('$name','$extension','$version','$extension','$file_size','$user_id','$folderId', '$crocodoc_uuid','$created','$username','$username','$created',1,1)";
							if ((mysql_query($sqlquery, $this->db))) {
														$document_id = mysql_insert_id();
                                                                                                                $new_name = $folderId."-". $document_id;
					                if($url == NULL)
                                                        {
                                                        $tmp_name = $_FILES["Filedata"]["tmp_name"];
                                                        move_uploaded_file($tmp_name, 'swf/'.$new_name.".".$extension);
                                                        $url = "/home/www/htdocs/app/webroot/rest/swf/".$new_name.".".$extension;
                                                        }
                                                        $totalPages = intval(shell_exec("identify -format %n '$url'"));
                                                        $swf_path = "/home/www/htdocs/app/webroot/rest/swf/".$new_name."%.swf";
                                                        shell_exec("pdf2swf -v -t -T 9 '$url' -o '$swf_path'");
                                                        $s3 = new S3($accessKey, $secretKey);
                                                        if ($s3->putObjectFile($url, $bucket, $new_name.".".$extension, S3::ACL_PUBLIC_READ_WRITE)) {
                                                                     $sqlquery = "UPDATE documents SET file='$new_name.$extension', in_progress='0' WHERE id='$document_id'";
                                                                     if (!(mysql_query($sqlquery, $this->db))) {
                                                                           echo "update operation failed";
                                                                     }
                                                                     else{
                                                                           for($i = 1; $i <= $totalPages; $i++){
                                                                                   $swf_path1 = "/home/www/htdocs/app/webroot/rest/swf/".$new_name.$i.".swf";
                                                                                   $s3->putObjectFile($swf_path1, $bucket, "swf/".$new_name.$i.".swf", S3::ACL_PUBLIC_READ_WRITE);
                                                                                   unlink($swf_path1);
                                                                           }
                                                                           echo $totalPages.",".$new_name;
                                                                           unlink($url);   
                                                                     }   
                                                        }
                                                        else {
                                                                echo "Something went wrong while uploading your file";
                                                        }
                                                }
                                                else
                                                {
                                                     echo "Error while inserting into db";
                                                }
                                      }
                     else{
                       echo "authentication failed";
                   }
       
 } 
public function get_swf(){
   $secret = $_REQUEST['secret'];
$sqlquery = "SELECT * FROM users WHERE auth_key='$secret'";
 $sqlquery = mysql_query($sqlquery);
 $users_array = mysql_fetch_array($sqlquery);
  if($users_array > 0){
  $filename = $_REQUEST['fname'].".pdf";
  $name = $_REQUEST['fname'];
  $pageno = $_REQUEST['pno'];
  $Filefilter = explode('.', $filename);
  
  $swf = "swf/".$name.$pageno.".swf";
  $accessKey = $this->aws_access_key;
$secretKey = $this->aws_secret_key;
$bucket = $this->aws_bucket;

 $s3 = new S3($accessKey, $secretKey);
 if ($s3->getObjectInfo($bucket, $filename)){
            if ($s3->getObjectInfo($bucket, $swf)){
                    $timestamp = strtotime("+3 days");
                    $strtosign = "GET\n\n\n$timestamp\n/$bucket/$swf";
                    $signature = urlencode(base64_encode(hash_hmac("sha1", utf8_encode($strtosign), $secretKey, true)));
                    $swf_url = "http://".$bucket.".s3.amazonaws.com/$swf?AWSAccessKeyId=$accessKey&Expires=$timestamp&Signature=$signature";
                    header("Content-Type: application/x-shockwave-flash"); 
                    @readfile($swf_url); 
                     
            }
            else
            {        $timestamp = strtotime("+3 days");
                    $strtosign = "GET\n\n\n$timestamp\n/$bucket/$filename";
                    $signature = urlencode(base64_encode(hash_hmac("sha1", utf8_encode($strtosign), $secretKey, true)));
                    $file = "http://".$bucket.".s3.amazonaws.com/$filename?AWSAccessKeyId=$accessKey&Expires=$timestamp&Signature=$signature";
                    $newfile = '/home/www/htdocs/app/webroot/rest/swf/'.$filename;

                    if ( copy($file, $newfile) ) {
                          $swf_path = "/home/www/htdocs/app/webroot/rest/swf/".$name."%.swf";
                          shell_exec("pdf2swf -v -t -T 9 '$newfile' -o '$swf_path'");
                             $totalPages = intval(shell_exec("identify -format %n '$newfile'"));
                             if($totalPages >= $pageno)
                             {
                             for($i = 1; $i <= $totalPages; $i++)
                             {
                                 $swf_path1 = "/home/www/htdocs/app/webroot/rest/swf/".$name.$i.".swf";
                                $s3->putObjectFile($swf_path1, $bucket, "swf/".$name.$i.".swf", S3::ACL_PUBLIC_READ_WRITE);
                             }
                       $timestamp = strtotime("+3 days");
                       $strtosign = "GET\n\n\n$timestamp\n/$bucket/$swf";

                    $signature = urlencode(base64_encode(hash_hmac("sha1", utf8_encode($strtosign), $secretKey, true)));
                    $swf_url = "http://".$bucket.".s3.amazonaws.com/$swf?AWSAccessKeyId=$accessKey&Expires=$timestamp&Signature=$signature";
                   header("Content-Type: application/x-shockwave-flash"); 
                  @readfile($swf_url); 
                 unlink($newfile);   
                 unlink($swf_path);
                             }
                             else{
                                 echo "file not exists";
                             }
                 
                    }else{
                        echo "Copy failed";
                    }
                     
                 

             }
 }
 else
 {
     echo "no such file exists";
 }
                      }
  else{
     
      echo "authentication failed";
 }
 }
public function swf_info(){
   $secret = $_REQUEST['secret'];
$Space = $_REQUEST['space'];
$convert = $_REQUEST['convert'];
$fileId = $_REQUEST['fileid'];
$sqlquery = "SELECT * FROM users WHERE auth_key='$secret'";
 $sqlquery = mysql_query($sqlquery);
                    $users_array = mysql_fetch_array($sqlquery);
                    if($users_array > 0){
 $sqlquery = "SELECT * FROM documents WHERE id = '$fileId'";
$sqlquery = mysql_query($sqlquery);
$result_set = mysql_fetch_array($sqlquery);
if($result_set > 0){
    $filename = $result_set['file'];
    $Filefilter = explode('.', $filename);
  $name = $Filefilter[0];
 $extension = $Filefilter[1];
$swf = "swf/".$name."1.swf";
  $accessKey = $this->aws_access_key;
$secretKey = $this->aws_secret_key;
$bucket = $this->aws_bucket;
//$item = $_POST['filename'];
 $s3 = new S3($accessKey, $secretKey);
 if ($s3->getObjectInfo($bucket, $filename)){
                 if ($s3->getObjectInfo($bucket, $swf)){
                   // $timestamp = strtotime("+3 days");
                    //$strtosign = "GET\n\n\n$timestamp\n/$bucket/$swf";

                   // $signature = urlencode(base64_encode(hash_hmac("sha1", utf8_encode($strtosign), $secretKey, true)));
                    //$swf_url = "http://".$bucket.".s3.amazonaws.com/$swf?AWSAccessKeyId=$accessKey&Expires=$timestamp&Signature=$signature";
                     $timestamp = strtotime("+3 days");
                    $strtosign = "GET\n\n\n$timestamp\n/$bucket/$filename";
                    $signature = urlencode(base64_encode(hash_hmac("sha1", utf8_encode($strtosign), $secretKey, true)));
                    $file = "http://".$bucket.".s3.amazonaws.com/$filename?AWSAccessKeyId=$accessKey&Expires=$timestamp&Signature=$signature";
                    $newfile = '/var/www/html/app/webroot/rest/swf/'.$filename;

                    if ( copy($file, $newfile) ) {
                           $totalPages = intval(shell_exec("identify -format %n '$newfile'"));
                           unlink($newfile); 
                    }
                    else{
                        $totalPages =  0;
                    }
                
		 echo $totalPages.",".$name;
                     
            }
            else
            {        $timestamp = strtotime("+3 days");
                    $strtosign = "GET\n\n\n$timestamp\n/$bucket/$filename";
                    $signature = urlencode(base64_encode(hash_hmac("sha1", utf8_encode($strtosign), $secretKey, true)));
                    $file = "http://".$bucket.".s3.amazonaws.com/$filename?AWSAccessKeyId=$accessKey&Expires=$timestamp&Signature=$signature";
                    $newfile = '/var/www/html/app/webroot/rest/swf/'.$filename;

                    if ( copy($file, $newfile) ) {
                          $swf_path = "/var/www/html/app/webroot/rest/swf/".$name."%.swf";
                          shell_exec("pdf2swf -v -t -T 9 '$newfile' -o '$swf_path' ");
                          $totalPages = intval(shell_exec("identify -format %n '$newfile'"));
                          
                             for($i = 1; $i <= $totalPages; $i++)
                             {
                                 $swf_path1 = "/var/www/html/app/webroot/rest/swf/".$name.$i.".swf";
                                 $s3->putObjectFile($swf_path1, $bucket, "swf/".$name.$i.".swf", S3::ACL_PUBLIC_READ_WRITE);
                                 unlink($swf_path1);
                  //$timestamp = strtotime("+3 days");
                    //$strtosign = "GET\n\n\n$timestamp\n/$bucket/$swf";

                    //$signature = urlencode(base64_encode(hash_hmac("sha1", utf8_encode($strtosign), $secretKey, true)));
                    //$swf_url = "http://".$bucket.".s3.amazonaws.com/$swf?AWSAccessKeyId=$accessKey&Expires=$timestamp&Signature=$signature";
                    
                     
                    //header("Content-Type: application/x-shockwave-flash"); 
                    //echo get_file_contents($swf_url); 
                             }
		    echo $totalPages.",".$name;
                 unlink($newfile);   
                 
           
                 
                    }else{
                        echo "Copy failed";
                    }
                     
                 

             }
 }
 else
 {
     echo "no such file exists in s3";
 }
 }
 else{
     
      echo "no such file exists in db";
 }
                    }
  else{
     
      echo "authentication failed";
 }
}
 
    public function list_s3() {
        $s3 = new S3($this->aws_access_key, $this->aws_secret_key);
        $contents = $s3->getBucket($this->aws_bucket);
      foreach ($contents as $file){
	
		$fname = $file['name'];
		$furl = "http://$this->aws_bucket.s3.amazonaws.com/".$fname;
		
		//output a link to the file
		echo "<a href=\"$furl\">$fname</a><br />";
	}
    }

}

// Initiiate Library

$api = new API;


$api->processApi();
?>
