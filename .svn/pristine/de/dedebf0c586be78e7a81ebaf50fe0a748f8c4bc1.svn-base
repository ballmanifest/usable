
<?php
error_reporting(E_ERROR);

//If set to true relative directory structure will be created in destination folder
// specified in $dirPath variable
//If set to false all files will be saved directly in $dirPath  without creating subfolders
$resore_directory_structure = true;

$filename = urldecode (isset($_GET["fileName"]) ? str_replace("../", "", $_GET["fileName"]) : "");
$isEmptyFolder = isset($_GET["isEmptyFolder"]);
$querySize = isset($_GET["action"]) ? strtolower($_GET["action"]) == "check" ? true : false : false;
$upload = isset($_GET["action"]) ? strtolower($_GET["action"]) == "upload" ? true : false : false;
$fileSize = isset($_GET["totalSize"]) ? (int)$_GET["totalSize"] : 0;
$uniqueID = isset($_GET["fid"]) ? $_GET["fid"] : "";
$isMultiPart = isset($_GET["isMultiPart"]) ? $_GET["isMultiPart"] == "true" : false;
$isZipped = isset($_GET["isZipped"]) ? ($_GET["isZipped"] == "false" ? false : true)  : false;

$dirPath = dirname(__FILE__) . "/UploadedFiles";


//JavaPowUpload send file name in UTF-8 encoding. And in most cases you need not any conversion.
//But php for Windows have bug related to file name encoding in move_uploaded_file function.
// http://bugs.php.net/bug.php?id=47096

// If you use file names in national encodings, change the $filePath assignment consider
// encoding conversion by functions 'iconv()' or 'mb_convert_encoding()' as shown below:
// $codepage = "windows-1251";
// $filename = mb_convert_encoding($filename, $codepage , 'UTF-8');
// $filename = iconv("utf-8", $codepage, $filename);


//$filePath = $dirPath . "/" . $uniqueID.$filename;
if($isEmptyFolder)
{	
	$filename .="/";
}

if($resore_directory_structure && dirname($filename) != ".")
{		
	$dirPath .= "/". ($isEmptyFolder ? GetWinSafePath($filename): GetWinSafePath(dirname($filename)."/"));			
	AddPath($dirPath);	
}

$filename = basename($filename);
$filePath = $dirPath . "/" . $uniqueID.$filename;

$openTag = "<javapowupload>";
$closeTag = "</javapowupload>";
echo $openTag;

if($isEmptyFolder)
	echo "<ok size='0'/>";
else
	if ($querySize)
	{
		if (file_exists($dirPath) && is_dir($dirPath))	
			if (file_exists($filePath))		
				echo "<ok size='".filesize($filePath)."'/>";
		else 
			echo "<ok size='0'/>";
	}
	else if($upload)
	{	
		if (!is_writable($dirPath))	
			write_error("Error: cannot write to the specified directory.");
		else
		{
			//if mulltipart mode and there is no file form field in request , then write error
			if($isMultiPart && count($_FILES) <= 0)
				write_error("No chunk for save.");	
			//if can't open file for append , then write error
			if (!$file = fopen($filePath, "a")) 			
				write_error("Can't open file for write.");	
			
			//logic to read and save chunk posted with multipart
			if($isMultiPart)
			{
				if($isZipped)
					unzipAndWriteChunk($filePath, $file, $filearr['tmp_name']);
	            else	
					if(($input = file_get_contents($filearr['tmp_name'])) === FALSE)
						write_error("Can't read from file.");
					else
						if(fwrite($file, $input) === FALSE) 
							write_error("Can't write to file.");			
			}
			//logic to read and save chunk posted as raw stream
			else
			{
				if($isZipped)
					unzipAndWriteChunk($filePath, $file, file_get_contents("php://input"));
				else
				$input = file_get_contents("php://input");
				if(fwrite($file, $input) === FALSE) 
					write_error("Can't write to file.");		
			}
			fclose($file);
			
			//Upload complete if size of saved temp file >= size of source file.
			if(filesize($filePath) >= $fileSize)
			{	
				if(file_exists($dirPath."/" .$filename))
				{
					//delete file if exist				
					unlink($dirPath."/" .$filename);
					//or rename old or new file
				}
				//move file
				rename($filePath, $dirPath."/" .$filename);
				/*here You can do some other job when upload complete
				With last chucnk MultiPowUpload send information about file,
				Like, size, date , index, etc
				*/
			}
			echo "<ok />";
		}
	}

echo $closeTag;

function unzipAndWriteChunk($filePath, $file, $input)
{
		try{
			$zip = new ZipArchive;				
			file_put_contents($filePath."tmp", $input);
			$res = $zip->open($filePath."tmp");
			if ($res !== TRUE)
				write_error("Failed to open archive");
			//get first zip entry					
			$zipEntry = $zip->getNameIndex(0);
			$fp = $zip->getStream($zipEntry);	
            if(!$fp)
                write_error('Unable to extract the file.');           
            while(!feof($fp))
                fwrite($file, fread($fp, 8192));	           
            fclose($fp);
            $zip->close();
		}
		catch(Exception $ex){write_error('Unable to extract chunk:'+$ex->getMessage()); }
            if(file_exists($filePath."tmp"))
            	unlink($filePath."tmp");
}

function write_error($errstr)
{
	GLOBAL $closeTag;
    echo "<error message=\"".$errstr."\"/>";		
	echo $closeTag;
	exit;
}

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
	{		
		mkdir($PathToCreate);
	}

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
	{
		/*Replace "\\" with the "/" symbols
		  Cut filename and "/" symbols at the begin and end of path.
		  So path should be in format "folder1/folder2/folder3"
		*/
		$safeName = str_replace("\\","/", $strPath);
		if(strpos($safeName,"/") !== FALSE)
			$safeName = substr($safeName, 0, strrpos($safeName,"/"));
		if(strpos($safeName,"/") === 0)
			$safeName = substr($safeName,1,strlen($safeName)-1);
			
	}

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



?>
