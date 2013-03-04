<?php 
	echo $this->Html->css('document_view');
	$doc = $document['Document']; 
?>
<div id="DocEditor" class="container_to_editor">
	<div class="doc_editor_header"></div>
<?php

	$baseUrl = $this->Html->url('/uploads/user_' . CakeSession::read('Auth.User.id') . '/', true);
	$file = $doc['file'];;
	$ext = strtolower($doc['ext']);
	$fileName = $doc['name'] . '.' . $ext;
	$docId = time();
	$saveUrl = $this->Html->url(array('controller' => 'documents', 'action' => 'savedoc'));
	
	/**
	*	Call Zoho API
	*/
	$this->loadHelper('Zoho');
	$viewer_url = $this->Zoho->openEditor($baseUrl, $file, $fileName, $ext, $docId, $saveUrl);
	
	/**
	*	If Zoho is OK
	*/
	if($viewer_url && $viewer_url != 'ext_fail'):
?>
		<iframe src="<?php echo $viewer_url;?>" seamless border="1" height="860" width="950" scrolling="no" align="middle" frameborder="0" marginwidth="1" marginheight="1" style="border: 1px solid #ccc;border-radius:5px;">
<?php
	/**
	*	If not appropriate extension for Zoho
	*/
	elseif($viewer_url == 'ext_fail'):
		echo '<h2>Sorry, failed to open this extension</h2>';
	/**
	*	If no return from Zoho
	*/
	else:
		echo '<h2>Sorry, failed to open this document</h2>';
	endif;
?>
</div>