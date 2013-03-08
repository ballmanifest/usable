<?php
	/* File : Rest.inc.php
	 * Author : Arun Kumar Sekar
	*/
	class REST {
		
		const DB_SERVER = "localhost"; // database server
		const DB_USER = "root";        // database username
                const DB_PASSWORD = "";  // database password
		const DB = "filocity2";        // database name 
                protected $aws_access_key="AKIAJWIKQMYOIRHYI6KA";    // AWS s3 Access key  
                protected $aws_secret_key="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";  // AWS s3 Secret key
                protected $aws_bucket= 'filocity-files-002';// filocity s3 bucket
                protected $allowedExn="All";
  protected $swfpath="/home/www/htdocs/app/webroot/rest/swf/";
				  //protected $allowedExn="camrec,accdb,avi,mpg,mpeg,mp3,wav,jpg,gif,png,rtf,bmp,doc,docx,dot,dotx,ppt,pptx,potx,pot,txt,pdf,xls,xlsx,xltx,xlt,csv,xps,ods,odt,odp,sxw,html,htm,sxc,tsv,pps,sxi,pub,mp4,m4v,f4v,mov,webm,flv,ogv,aac,m4a,f4a,ogg,oga,aif,avi,bdb,cnt,des,iif,ldb,lmr,lmx,nd,qba,qbb,qbi,qbm,qbw,qbx,qby,qpd,rtp,tdb,tlg,set,v30,1pa,log,usa,qbt,ptb,zip,rar,avi,jpeg,tiff,eps";
                protected $ShareId = 0;
                protected $Space = "company";
                protected $Result = array("status" => "", "result" => "");
                protected $document_id;
                protected $username;
                protected $upKey;
                protected $db = NULL;
	        public $_content_type = "application/json";
		protected $_code = 200;
		public function __construct(){
			
		}
		
		public function get_referer(){
			return $_SERVER['HTTP_REFERER'];
		}
	
		
		public function get_request_method(){
			return $_SERVER['REQUEST_METHOD'];
		}
		
		
		
		private function cleanInputs($data){
			$clean_input = array();
			if(is_array($data)){
				foreach($data as $k => $v){
					$clean_input[$k] = $this->cleanInputs($v);
				}
			}else{
				if(get_magic_quotes_gpc()){
					$data = trim(stripslashes($data));
				}
				$data = strip_tags($data);
				$clean_input = trim($data);
			}
			return $clean_input;
		}		
		
		private function set_headers(){
			header("HTTP/1.1 ".$this->_code." ".$this->get_status_message());
			header("Content-Type:".$this->_content_type);
		}
	}	
?>
