<?php
/*
JavaPowUpload builtin log area supports only limited count of HTML tags. You can find list here
http://java.sun.com/j2se/1.4.2/docs/api/javax/swing/text/html/HTML.Tag.html
*/

ini_set("error_reporting", E_ALL);
//PHP script that generate xml file for JavaPowUpload with specified folder structure.
//2008. Element-IT software.
$source_dir =dirname($_SERVER['SCRIPT_FILENAME'])."/UploadedFiles/";
$url_prefix= dirname($_SERVER['PHP_SELF'])."/UploadedFiles/";
//file names encoding on server side. All file and folder names should encoded into utf-8
$source_encoding = "cp1252";
//If $direct_output set to true, then generated xml will be printed in response
//and you can specify this script as source for Download.DataURL parameter
//Like this:   <param name="Download.DataURL" value="generatexml.php">
//else  generated xml will be saved to $output_file
$direct_output = true;
$output_file = "";
$fs; // file stream
if($direct_output)
	header('Content-Type: text/xml');
else
	//Create the file.
	$fs = fopen($output_file,'w+');		
	
	
write_xml("<?xml version=\"1.0\" encoding=\"UTF-8\"?>");
write_xml("<download>");

add_dir($source_dir, "");

write_xml("</download>");

if($direct_output)
	flush();
else
	if($fs != null)
		fclose($fs);

	
function add_dir($parent, $folder_name)
{
	GLOBAL $source_dir, $source_encoding, $url_prefix;
	$have_files = false;	
	if($handle = opendir($parent))
	{		
			
	   if($parent != $source_dir)			
			write_xml("<folder name=\"".iconv($source_encoding,"UTF-8",$folder_name)."\">"); 
		
	    while (false !== ($file = readdir($handle)))			
	        if ($file != "." && $file != "..")	    	
	        	if(is_dir($parent.$file))							
	            	add_dir($parent.$file."/", $file);	        
				
		
	    rewinddir($handle);
		while (false !== ($file = readdir($handle)))
	    {
	        if ($file != "." && $file != "..")
	    	{
	        	if(is_file($parent.$file))
	        	{	
					$have_files = true;
					//REPLACE  $download_url with needed value!
					$relative_parent = str_replace("\\", "/", substr($parent, strlen($source_dir), strlen($parent)-strlen($source_dir)));
					$download_url = iconv($source_encoding,"UTF-8",$url_prefix.$relative_parent.rawurlencode($file));
					write_xml("<file name=\"".iconv($source_encoding,"UTF-8",$file)."\" length=\"".filesize($parent.$file)."\">"); 
										
					write_xml("<url>".$download_url."</url>");
					write_xml("</file>");
	         	}
	        }
	    }
	    if($parent != $source_dir)
		   write_xml("</folder>");
	    closedir($handle);
	}	
}
	
	
function write_xml($xml)
{
	GLOBAL $fs, $direct_output;
	if($direct_output)
		echo $xml;
	else
		if($fs != null)
			fwrite($fs, $xml);
}

?>
