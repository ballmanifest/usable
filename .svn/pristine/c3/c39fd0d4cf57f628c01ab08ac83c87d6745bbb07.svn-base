<?php

//First of it should not to be a proper controller, these scripts should behave like API

ini_set('display_errors', 1);
//It is added for only testing and can be reomved, but keep it for time being
if($_FILES == null || $_POST == null)
{
    echo '<html><body><form method="post" enctype="multipart/form-data"><label for="file">Filename:</label><input type="file" name="file" id="file" /><br /><input type="submit" name="submit" value="Submit" /></form></body></html>';
                die;
}
//ID for the PDF document will be sent from flash
$id = $_REQUEST['id'];
//File path storing files and main folder for PDF related files
$dir = '../webroot/uploads/' . $id . '/';
$new_name = $id . '_new.pdf';
if(file_exists($dir.$new_name))
	unlink($dir.$new_name);

// create new directory with 777 permissions if it does not exist yet
// owner will be the user/group the PHP script is run under
if ( !file_exists($dir) ) {
  mkdir ($dir, 0764);
}
//A XML will be sent from flash It need to be saved for future to be used
$changes_xml = '';
if($_FILES != null){
	if($_FILES["file"]["error"] > 0)
    {
        print_r($_FILES);
        echo "Error: " . $_FILES["file"]["error"] . "<br />";
		die;
    }
    else
    {
        move_uploaded_file($_FILES["file"]["tmp_name"], $dir . "changes.xml");
    }
	$xml_string = file_get_contents($dir . "changes.xml");
}
else{
	$xml_string = $_POST['xml'];
	//save changes xml file first then parse
	$changes_xml_file = $dir . 'changes.xml';
	$fp = fopen($changes_xml_file, 'w');
	fwrite($fp, $xml_string);
	fclose($fp);
}
//parse send XML;
$changes_xml = simplexml_load_string($xml_string);

//load and parse pdf.xml
$xml_string = file_get_contents($dir . "pdf.xml");
$pdf_xml = simplexml_load_string($xml_string);


$p = PDF_new();

/*  open new PDF file; insert a file name to create the PDF on disk */
if (PDF_begin_document($p, $dir.$new_name, "") == 0) {
    die("Error: " . PDF_get_errmsg($p));
}

//Set file authoring information
PDF_set_info($p, "Creator", "FiloCity.com");
PDF_set_info($p, "Author", "FiloCity");
PDF_set_info($p, "Title", "PDF created by http://www.filocity.com");

$i = 0;
$changes_xml_children = $changes_xml->children();
//This is main logic it will use pdf.xml and flash sent XML to generate the final PDF
foreach($pdf_xml->children() as $page){
	//Set page dimension
	PDF_begin_page_ext($p, (double)$page->low->attributes()->width, (double)$page->low->attributes()->height, "");
	
	//Add high resolution image as page first layer
	$high_res = pdf_load_image($p, "png", $page->high, "");
	pdf_fit_image($p, $high_res, 0, 0, "scale " . 1/4.166);
	pdf_close_image($p, $high_res);
	//echo "<br/>page no. = " . $i;
	
	$page_changes = $changes_xml_children->page[$i];
	//Now add user made changes to a page second layer
	if($changes_xml_children->page[$i] != null)
	foreach($changes_xml_children->page[$i]->children() as $change){
		//If user made any changes during editing the Page add those changes to page
		if($change->getName() == "image"){
			$img = pdf_load_image($p, "png", $change->src, "");
			pdf_fit_image($p, $img, (double)$change->attributes()->left, (double)$page->low->attributes()->height - (double)$change->attributes()->top - (double)$change->attributes()->height, "scale " . $change->attributes()->scalex);
			echo "top ->" . ((double)$page->low->attributes()->height - (double)$change->attributes()->top - (double)$change->attributes()->height);
			pdf_close_image($p, $img);
		}
		else if($change->getName() == "label"){
			$font = PDF_load_font($p, $change->attributes()->font_family, "winansi", "");
			PDF_setfont($p, $font, (double)$change->attributes()->font_size);
			PDF_set_text_pos($p, (double)$change->attributes()->left, (double)$page->low->attributes()->height - (double)$change->attributes()->top - (double)$change->attributes()->height);
			PDF_show($p, $change->attributes()->text);
		}
	}
	//Finish page editing
	PDF_end_page_ext($p, "");
	$i++;
}
//Finish PDF editing
PDF_end_document($p, "");

exit(0);

?>
