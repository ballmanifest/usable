<?php



if ( isset ( $GLOBALS["HTTP_RAW_POST_DATA"] )) {
	
	header('Content-type: application/pdf');
	header('Content-disposition: attachment; filename='.$_REQUEST['name']);

		$fp = fopen( 'pdf/'.$_REQUEST['name'], 'wb' );
       fwrite( $fp, $GLOBALS['HTTP_RAW_POST_DATA' ] );
       fclose( $fp);
		
	}else{
		//echo "error1 ".$_REQUEST['name'];
		throw(new Exception('Problem Saving PDF', 1));
		//echo "the error message you want";
	die;
}


?>