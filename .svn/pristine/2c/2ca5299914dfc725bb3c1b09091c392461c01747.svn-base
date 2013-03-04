<?php
// In PHP versions earlier than 4.1.0, $HTTP_POST_FILES should be used instead
// of $_FILES.

//JavaPowUpload send file name in UTF-8 encoding. And in most cases you need not any conversion.
//But php for Windows have bug related to file name encoding in move_uploaded_file function.
// http://bugs.php.net/bug.php?id=47096

// If you use file names in national encodings, change the $uploadfile assignment consider
// encoding conversion by functions 'iconv()' or 'mb_convert_encoding()' as shown below:
//$target_encoding = "ISO-8859-1";
// $uploadfile = $uploaddir . mb_convert_encoding(basename($arrfile['name']), $target_encoding , 'UTF-8');
// $uploadfile = $uploaddir . iconv("UTF-8", $target_encoding,basename($arrfile['name']));


echo 'Upload result:<br>'; 

$uploaddir = dirname($_SERVER['SCRIPT_FILENAME'])."/UploadedFiles/";

$filedNames['FilePath']="FilePath_#COUNTER#";
$filedNames['RealFilePath']="RealFilePath_#COUNTER#";
$filedNames['FileSize']="FileSize_#COUNTER#";
$filedNames['FileLastModified']="FileLastModified_#COUNTER#";
$filedNames['FileMD5']="FileMD5_#COUNTER#";

$i=0;
if(count($_FILES) > 0)
{
	//save files
	foreach($_FILES as $name=>$arrfile)
	{
		$uploadfile = $uploaddir . basename($arrfile['name']);
		if($name == "FileBody_".$i)
			if (move_uploaded_file($arrfile['tmp_name'], $uploadfile))
			{			   		   
			       	   echo "File ".$arrfile['name']." is valid, and was successfully uploaded $name.<br>";
				   echo "File saved to: ".$uploadfile."<br>";
				   echo "FilePath: ".$_POST[str_replace("#COUNTER#", $i,$filedNames['FilePath'])]."<br>";
				   echo "RealFilePath: ".$_POST[str_replace("#COUNTER#", $i,$filedNames['RealFilePath'])]."<br>";
				   echo "FileSize: ".$_POST[str_replace("#COUNTER#", $i,$filedNames['FileSize'])]."<br>";
				   echo "FileLastModified: ".$_POST[str_replace("#COUNTER#", $i,$filedNames['FileLastModified'])]."<br>";
				   echo "FileMD5: ".$_POST[str_replace("#COUNTER#", $i,$filedNames['FileMD5'])]."<br><br>";			   
     				  $i++;
			}
		
	}
	$i=0;
	//save thumbnails.
	foreach($_FILES as $name=>$arrfile)
	{
		$uploadfile = $uploaddir .basename($arrfile['name']);
		if($name == "ThumbnailBody_".$i)
			if (move_uploaded_file($arrfile['tmp_name'], $uploadfile))
			{			   		   
			       echo "File ".$arrfile['name']." is valid, and was successfully uploaded $name.<br>";
				   echo "File saved to: ".$uploadfile."<br>";				  
				   echo "ThumbnailPath: ".$_POST["ThumbnailPath_".$i]."<br>";
				   echo "ThumbnailRealFilePath: ".$_POST["ThumbnailRealFilePath_".$i]."<br>";
				   echo "ThumbnailFileSize: ".$_POST["ThumbnailFileSize_".$i]."<br>";			
				   echo "ThumbnailFileMD5: ".$_POST["ThumbnailFileMD5_".$i]."<br>";
				   echo "Url to thumbnail: ".dirname($_SERVER['PHP_SELF'])."/UploadedFiles/".iconv("UTF-8", $target_encoding,basename($arrfile['name']))."<br><br>";
		   
     				  $i++;
			}
		
	}
}
else
	echo 'No files sent!'; 


?>