<html>
<body>
<%@ Page language="c#"%>
<%

	if(Request.RequestType.ToString() == "HEAD")
		return;
		Response.Write("Upload result:<br>");

		string FolderToSave = Server.MapPath("") + "\\UploadedFiles\\";

		if(Request.Files.Count > 0)
		{
			for (int i = 0 ; i < Request.Files.Count; i++)
			{
				if(Request.Files["FileBody_"+i] != null)
				{
					HttpPostedFile myFile = Request.Files["FileBody_"+i];
					if(myFile != null && myFile.FileName !="")
					{
						myFile.SaveAs(FolderToSave + System.IO.Path.GetFileName(myFile.FileName));
						Response.Write("File " + myFile.FileName + " succesfully saved.<br>");
						Response.Write("FilePath: "+Request.Form["FilePath_" + i]+"<br>");
						Response.Write("RealFilePath: "+Request.Form["RealFilePath_" + i]+"<br>");
						Response.Write("FileSize: "+Request.Form["FileSize_" + i]+"<br>");
						Response.Write("FileLastModified: "+Request.Form["FileLastModified_" + i]+"<br>");
						Response.Write("FileIndex: "+Request.Form["FileIndex_" + i]+"<br>");
						Response.Write("FileMD5: "+Request.Form["FileMD5_" + i]+"<br><br>");
					}
				}

			}
			for (int i = 0 ; i < Request.Files.Count; i++)
			{				
				if(Request.Files["ThumbnailBody_"+i] != null)
				{
					HttpPostedFile myFile = Request.Files["ThumbnailBody_"+i];
					if(myFile != null && myFile.FileName !="")
					{
						myFile.SaveAs(FolderToSave + System.IO.Path.GetFileName(myFile.FileName));						
						Response.Write("Thumbnail " + myFile.FileName + " succesfully saved.<br>");
						Response.Write("ThumbnailPath: "+Request.Form["ThumbnailPath_" + i]+"<br>");
						Response.Write("ThumbnailRealFilePath: "+Request.Form["ThumbnailRealFilePath_" + i]+"<br>");
						Response.Write("ThumbnailFileSize: "+Request.Form["ThumbnailFileSize_" + i]+"<br>");						
						Response.Write("ThumbnailFileIndex: "+Request.Form["ThumbnailFileIndex_" + i]+"<br>");
						Response.Write("ThumbnailFileMD5: "+Request.Form["ThumbnailFileMD5_" + i]+"<br>");
						Response.Write("Url to thumbnail: "+System.IO.Path.GetDirectoryName(Request.ServerVariables["PATH_INFO"]).Replace("\\","/") + "/UploadedFiles/"+myFile.FileName+"<br><br>");				
						
					}
				}

			}
		}
		else
	     		Response.Write("No files sent.!");
%>
</body>
</html>