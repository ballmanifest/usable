<?php
App::uses('AppController', 'Controller');

class ImageController extends AppController {

	public function index() {

	}

	public function profile() {
		$this->autoRender = false;
		$args=func_get_args();
		$q=$_GET;
		$_GET=array();
		if($args[1]=='small.jpg'){
			$_GET['w']=46;
			$_GET['h']=51;
		}else if($args[1]=='medium.jpg'){
			$_GET['w']=128;
			$_GET['h']=128;
		} else if($args[1]=='thumb.jpg') {
			$_GET['w']=146;
			$_GET['h']=166;
		} 
		$user_id=$args[0];
		
		$_GET['src']= DS.'img'.DS.'filocity_img'.DS.'user_'.$user_id.DS.'profile.jpg';
		if(!file_exists(WWW_ROOT.$_GET['src'])){
			$_GET['src']=DS.'img'.DS.'prof_img.jpg';
		}
		
		define('LOCAL_FILE_BASE_DIRECTORY', WWW_ROOT);
		require(WWW_ROOT.'/../Lib/timthumb.php');
	}
	
	public function cabimage($size=null, $file_name="", $width=0, $height=0) {
		$this->autoRender = false;
		$_GET =array();
		if($size == 'thumb') {
			$_GET['h'] = 170;
		} elseif($size == 'large') {
			$_GET['w'] = $width;
			$_GET['h'] = $height;
		}
		$userId = $this->Auth->user('id');
		$_GET['src'] =  DS . 'uploads' . DS . 'user_' . $userId . DS . $file_name;
		define('LOCAL_FILE_BASE_DIRECTORY', WWW_ROOT);
		require(WWW_ROOT.'/../Lib/timthumb.php');
	}
	
	public function temp() {
		$this->autoRender = false;
		$args=func_get_args();
		$q=$_GET;
		$_GET=array();
		if($args[1]=='small.jpg'){
			$_GET['w']=46;
			$_GET['h']=51;
		}else if($args[1]=='medium.jpg'){
			$_GET['w']=128;
			$_GET['h']=128;
		}
		$filename=$args[0];
		
		$_GET['src']=$filename;
		if(!file_exists(sys_get_temp_dir().DS.'uploads_temp'.DS.$_GET['src'])){
			$_GET['src']=DS.'img'.DS.'prof_img.jpg';
		}
		define('FILE_CACHE_ENABLED', false);
		define('LOCAL_FILE_BASE_DIRECTORY', sys_get_temp_dir().DS.'uploads_temp');
		require(WWW_ROOT.'/../Lib/timthumb.php');
	}
}
