<?php

/*
JavaPowUpload builtin log area supports only limited count of HTML tags. You can find list here
http://java.sun.com/j2se/1.4.2/docs/api/javax/swing/text/html/HTML.Tag.html
*/

function AddPath($PathToCreate)
{
	$iBreak = 0;
	$iBreak = strrpos($PathToCreate, "/");
	if($iBreak !== FALSE)
	{
		$Parent = substr($PathToCreate, 0, $iBreak);
		if(!@chdir($Parent))
			AddPath($Parent);

	}

	if(!@chdir($PathToCreate))
		mkdir($PathToCreate);

}


function GetWinSafeFileName($strPath)
{
	return GetWinSafeName($strPath, false);
}

function GetWinSafePath($strPath)
{
	return GetWinSafeName($strPath, true);
}

///<summary>
/// Returns the safe file name and extension or safe path of the specified path string.
/// All characters that are illegal in file names or paths on Windows
/// and not safe relative path substrings like "?", "..\" are deleted.
///</summary>
function GetWinSafeName($strPath, $isPath)
{
	$safeName = "";
	if(!$isPath)
	{
		$slashind = strrpos($strPath, "\\");
		$backslashind = strrpos($strPath, "/");
		if($slashind == FALSE && $backslashind==FALSE)
			$safeName = $strPath;
		else if($slashind>$backslashind)
			$safeName = substr($strPath, $slashind+1, strlen($strPath)-$slashind-1);
		else
			$safeName = substr($strPath, $backslashind +1, strlen($strPath)-$backslashind-1);
	}
	else
		$safeName = str_replace("\\","/", $strPath);

	$i = 0;
	$charpos = 0;
	$wrongchars = array('?','*',':', '"', '<', '>', '|', '\0', '\x0001', '\x0002', '\x0003', '\x0004', '\x0005', '\x0006', '\a', '\b', '\t', '\n', '\v',
        '\f', '\r', '\x000e', '\x000f', '\x0010', '\x0011', '\x0012', '\x0013', '\x0014', '\x0015', '\x0016', '\x0017', '\x0018', '\x0019', '\x001a', '\x001b',
        '\x001c', '\x001d', '\x001e', '\x001f');

  	for($i=0; $i<=count($wrongchars)-1; $i++)
	{
		do
		{
			$charpos = strpos($safeName, $wrongchars[$i]);

			if($charpos!==FALSE)
			{
				$safeName = substr($safeName, 0, $charpos).substr($safeName, $charpos+1, strlen($safeName));
			}
		}while($charpos!==FALSE);
	}
	if(!$isPath)
	{
		if(strlen($safeName) > 255 )
			$safeName = substr($safeName, strlen($safeName)-255, 255);
	}
	//Replace dangerous ..\ at the begin or ..\ at the end or \..\ at the any place
	//of folder path.
	if($isPath)
	{
		while(strpos($safeName, "/../")!==FALSE)
			$safeName = str_replace("/../", "/pp/", $safeName);
		if(strrpos($safeName , "/..") === strlen($safeName)-3)
			$safeName = substr($safeName, 0, strlen($safeName)-2)."pp";
		if(strpos($safeName,"../") === 0)
			$safeName = "pp".substr($safeName, 2, strlen($safeName)-2);
	}
	return $safeName;
}

function SaveToFolder($myFile, $FolderToSave, $nameToSave, $clientRelativePath)
{
	$serverRelativePath = "";
	$tmpStr = "";
	/*Replace "\\" with the "/" symbols
	  Cut filename and "/" symbols at the begin and end of path.
	  So path should be in format "folder1/folder2/folder3"
	*/
	$tmpStr = str_replace("\\","/", $clientRelativePath);
	if(strpos($tmpStr,"/") !== FALSE)
		$tmpStr = substr($tmpStr, 0, strrpos($tmpStr,"/"));
	if(strpos($tmpStr,"/") === 0)
		$tmpStr = substr($tmpStr,1,strlen($tmpStr)-1);
	
	$serverRelativePath = GetWinSafePath($tmpStr);
	
	if($nameToSave !="")
	{
		AddPath($FolderToSave.$serverRelativePath);
		move_uploaded_file($myFile['tmp_name'], $FolderToSave.$serverRelativePath."/".$nameToSave);
	}
}


	$FolderToSave = dirname($_SERVER['SCRIPT_FILENAME'])."/UploadedFiles";
	if(strrpos($FolderToSave,"/") != strlen($FolderToSave)-1)
		$FolderToSave .=  "/";
	$clientRelativePath;
	$clientAbsolutePath;
	$nameToSave;
	$Uploaded=0;
	$i=0;
	foreach($_FILES as $myFile)
	{
		$clientRelativePath = $_POST["SelectedPath_".$i];
		$clientAbsolutePath = $myFile['name'];
		$nameToSave = GetWinSafeFileName($clientAbsolutePath); //GetWinSafeFileName(
		echo $clientRelativePath." - ".$nameToSave." - ".$clientAbsolutePath ."<br>";
		if(strpos($clientRelativePath, "/") !== 0 && strpos($clientRelativePath, "\\") !== 0)
			$clientRelativePath = "/".$clientRelativePath;
			
		if($nameToSave !="")
		{
			if(strpos($clientRelativePath,"/") !== FALSE || strpos($clientRelativePath,"\\") !==FALSE)
			{
				//Create and Save whole folders structure
				SaveToFolder($myFile, $FolderToSave, $nameToSave, $clientRelativePath);
				echo "File ".$nameToSave." succesfully saved.<br>";
			}
			$Uploaded++;
		}
		$i++;
	}
	if($Uploaded == 0)
		echo("No files sent!");

?>