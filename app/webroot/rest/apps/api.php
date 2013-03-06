<?php

	require_once("../config.php");
	
	class API extends REST {
	
//		     public $data = "";
//		public $_REQUEST = NULL;
//		const DB_SERVER = "localhost"; // database server
//		const DB_USER = "root";        // database username
//                const DB_PASSWORD = "jcode";  // database password
//		const DB = "filocity2";        // database name 
//                    
	
		public function __construct(){
			parent::__construct();				// Init parent contructor
			$this->dbConnect();					// Initiate Database connection
		}
		
		/*
		 *  Database connection 
		*/
		private function dbConnect(){
			$this->db = mysql_connect(self::DB_SERVER,self::DB_USER,self::DB_PASSWORD);
			if($this->db)
				mysql_select_db(self::DB,$this->db);
		}
		
		/*
		 * Public method for access api.
		 * This method dynmically call the method based on the query string
		 *
		 */
		public function processApi(){
			$func = strtolower(trim(str_replace("/","",$_REQUEST['rquest'])));
			//echo $func;exit;
			if((int)method_exists($this,$func) > 0)
				$this->$func();
			else
				echo 'error';				// If the method not exist with in this class, response would be "Page not found".
		}
		
                
                
                
                
                 private $_Debug = 0;
                 private $Apps = array(
                                        "dropbox" => "1.0.2.0",
                                        "officeplugin" => "1.0.0.0",
                                        "outlookplugin" => "0",
                                        "cloudconnect" => "2.0.0.0"
                                    );
               public $ReleaseLinks = array(
                    "dropbox" => "http://www.filocity.com/app-downloads/Filocity-Dropbox-1.0.2.0.zip",
                    "officeplugin" => "http://www.filocity.com/app-downloads/Filocity.OfficeCloudSetup-1.0.0.0.zip",
                    "outlookplugin" => "http://www.filocity.com",
                    "cloudconnect" => "http://www.filocity.com/app-downloads/Filocity.CloudConnect.Setup-2.0.0.0.zip"
                );
                public  $ReleaseNotes = array(
                    "dropbox" => "Splash Screen, Better load timings, Performance enhancements & Guest role implementation.",
                    "officeplugin" => "First release",
                    "outlookplugin" => "http://www.filocity.com",
                    "cloudconnect" => "New release"
                );       

                
                
        public function needupgrade() {
      

        $app = $_REQUEST["id"];
        $version = $_REQUEST["v"];
        

        if (trim($app) == "") {
           $this->response( $this->json_error("Inappropriate app id 1."),200);
            return;
        }

        if ($version == "0") {
           $this->response( $this->json_error("Inappropriate app id 2."),200);
            return;
        }

        if (isset($this->Apps['$app'])) {
            $this->response( $this->json_error("Inappropriate app id 3."),200);
            return;
        }

        $requestVersionValue = $this->versionValue($version);
        $currentVersionValue = $this->versionValue($this->Apps[$app]);

        if ($requestVersionValue < $currentVersionValue) {
            $value=array("Upgrade" => "YES", "ReleaseLink" => $this->ReleaseLinks[$app], "ReleaseNotes" => $this->ReleaseNotes[$app]);
            $this->json($value);
        } else {
            $value=array("Upgrade" => "NO");
              $this->json_error($value);
           
        }
    }
    
    
     private function versionValue($version) {
        $versionPartsNormal = explode('.', $version);
        $versionParts = array_reverse($versionPartsNormal);

        $versionValue = 0;
        foreach ($versionParts as $key => $val) {
            $versionValue += pow(10000, $key) * $val;
        }
        return $versionValue;
    }
                
    
                 private function json($data){
                 $this->Result["status"] = "OKAY"; 
                $this->Result["result"] =  $data;
                if(is_array($this->Result)){
				echo json_encode($this->Result);
			}
			}
                
                
                
	    private function json_error($data){
                 $this->Result["status"] = "OKAY"; 
                $this->Result["result"] =  $data;
                if(is_array($this->Result)){
				echo json_encode($this->Result);
			}
			}
		
                
        }  
	
	// Initiiate Library
	
	$api = new API;
	
	
	$api->processApi();
                
?>