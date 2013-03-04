
<div class="main">
    	<div id="top">
        <h1>Version List for <?php echo $documents[0]['Document']['name'];	?></h1>
        <div id="top_lst">
        	 <div id="lst_l">File Name</div>
             <div id="lst_l_lft">Version </div>
             <div id="lst_date">Date </div>
             <div id="lst_l_lft">Size </div>
        </div>
		<?php foreach ($documents as $document): ?>
        <div id="botton">
        	<div id="lst_bottom_l"><?php echo h($document['Document']['name']); ?>&nbsp; </div>
            <div id="lst_bottom_l_lft"><?php echo h($document['Document']['version']); ?>&nbsp;</div>
            <div id="lst_bottomt_date"><?php echo h($document['Document']['created']); ?>&nbsp;</div>
            <div id="lst_bottom_l_lft"><?php echo h($document['Document']['size']); ?>&nbsp;</div>            
            <div id="lst_bottom_download"><a href="/cabinets/download/<?php echo $document['Document']['id'] ;?>" style ='color: #0665a5' target="_blank"><?php echo __("Download");?></a> |  <?php 
							if(in_array(strtolower($document['Document']['ext']), array('jpg', 'jpeg', 'png', 'gif'))) {?>
								
							  <a href="/img/?img=/imagecache/<?php echo $document['Document']['file'] ;?>" target="_blank" class='icon-eye-open' style ='color: #0665a5'><?php echo __("View");?></a>
								
						<?php	} else {
								
					       echo $this->Html->link('View',array('controller' => 'documents', 'action' => 'view', 'id' => $document['Document']['id']), array('target' => '_blank', 'class' => 'icon-eye-open', 'style' => 'color: #0665a5', 'data-relatedthumb' => $document['Document']['ext'] . '_' . $document['Document']['id'] ));
							}?></div>
        </div>
		<?php endforeach; ?>
        </div>
    </div>