<?php
 $source_dir = "UploadedFiles/";
if(isset($_GET['fileName']))
	downloadFile($source_dir.$_GET['fileName']);

function downloadFile($filePath)
{
	$stream=null;        
	$contentType = "application/octet-stream";
	try
	{		
		header("Content-Type: ".$contentType);
		header("Content-Encoding: UTF-8");          
		header("Pragma: public");
		header("Expires: 0"); // set expiration time
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		/*
		The Content-transfer-encoding header should be binary, since the file will be read
		directly from the disk and the raw bytes passed to the downloading computer.		
		*/	
		$filePi = pathinfo($filePath);             
		$fileName = $filePi["basename"];
		
		$contentTag = $contentType == "application/octet-stream" ? "attachment" : "inline";
		//file name HttpUtility.UrlEncode(fileName, Encoding.UTF8).Replace("+", "%20")
		$CDfilename = $fileName;//urlencode
		if (stripos($_SERVER["HTTP_USER_AGENT"], "MSIE") !== FALSE)
			$CDfilename = str_replace("+", "%20", urlencode($fileName));
		else
			$CDfilename = $fileName;//str_replace(";", "%3B", str_replace(" ", "%20", $fileName));                

		header('Content-Disposition: '.$contentTag.'; filename="'.$CDfilename.'"');
		if (!file_exists($filePath) || !is_readable($filePath))
		{
			header("Status: 404 Not Found");
			return;
		}		
		header("Content-Length: ". filesize($filePath));

		$stream =fopen($filePath, "r");                
		while (!feof($stream))
		{
			echo fgets($stream, 1024000);
			try {
				flush();
				@ob_flush();
			}
			catch(Exception $ex)
			{};
		}				
		if($stream != null)
			fclose($stream);
	}
	catch (Exception $ex) 
	{		
		if($stream != null)
			fclose($stream);
	}           
}

?>