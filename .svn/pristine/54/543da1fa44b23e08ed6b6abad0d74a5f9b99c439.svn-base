<?php
/*
 * TreeViewsHelper
 *
 * TreeViewsHelper is a cakePHP plugin for creating the Tree Behavior results into threaded array
 * Below are theTree Behavior results:
 *
 * Category
 * - Sub Category
 * - - Children
 * - - - Grand Children
 *
 * Built with the CakePHP framework.
 * Copyright (c) 2012 Filocity.com
 * Author: Christopher Natan
 *
 */

App::uses('AppHelper', 'View/Helper');

class TreeViewsHelper extends AppHelper { 
    public $helpers = array('Html'); 
    public $leaves = array(); 
    
	public function createTree($tree,$link){ 
		$this->link = $link; 
        $out = ''; 
        $count = 0; 
        $counter = 0;
		$buffer = null;
        $lastId = 0;
		
        foreach($tree as $id => $item){
            $depth = strrpos($item, '_');
            if ($depth === false) { 
                $depth = 0; 
                $clean_item = $item; 
            } else { 
                $depth = $depth + 1; 
                $clean_item = substr($item, strrpos($item, '_')+1); 
            }
            if($buffer != null){
                $parent = false;
				if($counter == 0) {
					$parent = true;
					$counter = 1;
				}
				$out .= $this->makeLi($buffer,$depth, $lastId,$parent);
            }
            $buffer['item'] = $clean_item; 
            $buffer['depth'] = $depth;
            $lastId = $id;
        } 
        $out .= $this->makeLi($buffer,0,$id);
        return $out; 
    }

    protected function makeLi($buffer,$depth,$id,$parent = ""){
        $attr = ' id="phtml_'.$id.'" data-name="'.$buffer['item'].'" ';
		if($buffer['depth']==$depth){ 
            $out = '<li'.$attr.'>'.$this->makeLabel($buffer['item'],$id, $parent)."</li>\n"; 
        }elseif($buffer['depth']<$depth){ 
            $out = '<li'.$attr.'>'.$this->makeLabel($buffer['item'], $id, $parent)."\n<ul>\n"; 
        }elseif($buffer['depth']>$depth){ 
            $out = "<li".$attr.">".$this->makeLabel($buffer['item'],$id, $parent)."</li>\n"; 
            $diff = $buffer['depth']-$depth; 
            for($i=0; $i<$diff;$i++){ 
                $out .= "</ul> \n </li>\n"; 
            }         
        } 
        return $out; 
    } 

    protected function makeLabel($item, $id = null, $parent){ 
		$class = "";
		if($parent) {
			$class = "parent";
		}
        $return = $this->Html->link($item, "javascript:void(0)", array("id"=>"mechild_" . $id, "data-fullname" => $item, "paramid"=>$id, "class"=>$class)); 
        return $return; 
    } 
     
    protected function mountLink($id){ 
        if(is_array($this->link)){ 
            $link = $this->link; 
            $link[] = $id; 
        }else{ 
            $link = rtrim($this->link,'/').'/'.$id; 
        } 
        return $link; 
    } 
     
     
} 
?>