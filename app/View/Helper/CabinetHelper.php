<?php

App::uses('Helper', 'View');
class CabinetHelper extends Helper {

	public function createBreadCrumb($treeSessions, $search = ""){ 
		if(!!$treeSessions || !empty($treeSessions)) {
			foreach($treeSessions as $id => $item){
				$depth = strrpos($item, '_');
				if ($depth === false) { 
					$depth = 0; 
					$cleanItem = $item; 
				} else { 
					$depth = $depth + 1; 
					$cleanItem = substr($item, strrpos($item, '_')+1); 
				}
			   $out[][$depth] = $cleanItem;
			   if($search == $cleanItem) {
					break;
			   }
			} 
			return $this->toProper($out, $depth); 
		}
    }
	
	private function toProper($out, $depth) {
		$reverse = array_reverse($out);
		$crumb = array();
		$deep = --$depth;
		foreach($reverse as $item){
			$key = key($item);
			if($key == $deep) {
				$deep = --$depth;
				$crumb[] = $item[$key];
			}
		}
		return $this->make($crumb);
	}	
	
	private function make($crumb) {
		$reverse = array_reverse($crumb);
		return implode(" / ", $reverse);
	}
	

}
?>