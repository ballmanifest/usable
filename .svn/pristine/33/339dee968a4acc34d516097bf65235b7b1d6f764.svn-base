<%@ Page language="VB"%>
<%

		Response.Write("Upload result:<br>") 

		dim FolderToSave as String = Server.MapPath("") & "\UploadedFiles\"
		dim i as integer

		if Request.Files.Count > 0 then
			for i = 0 to Request.Files.Count-1
				if not Request.Files("FileBody_"&i) is nothing then
					dim myFile as HttpPostedFile =Request.Files("FileBody_"&i)
					if not myfile is nothing andalso myFile.FileName <>""  then
						myFile.SaveAs(FolderToSave & System.IO.Path.GetFileName(myFile.FileName))						
						Response.Write("File " &Request.Form("FilePath_" & i) & " succesfully saved.<br>")
						Response.Write("FilePath: "&Request.Form("FilePath_" & i)&"<br>")
						Response.Write("RealFilePath: "&Request.Form("RealFilePath_" & i)&"<br>")
						Response.Write("FileSize: "&Request.Form("FileSize_" & i)&"<br>")
						Response.Write("FileLastModified: "&Request.Form("FileLastModified_" & i)&"<br>")
						Response.Write("FileIndex: "&Request.Form("FileIndex_" & i)&"<br>")
						Response.Write("FileMD5: "&Request.Form("FileMD5_" & i)&"<br><br>")
					end if
				end if
			next
			for i = 0 to Request.Files.Count-1
				if not Request.Files("ThumbnailBody_"&i) is nothing then
					dim myFile as HttpPostedFile =Request.Files("ThumbnailBody_"&i)
					if not myfile is nothing andalso myFile.FileName <>""  then
						myFile.SaveAs(FolderToSave & System.IO.Path.GetFileName(myFile.FileName))						
						Response.Write("Thumbnail " &Request.Form("FilePath_" & i) & " succesfully saved.<br>")
						Response.Write("ThumbnailPath: "&Request.Form("ThumbnailPath_" & i)&"<br>")
						Response.Write("ThumbnailRealFilePath: "&Request.Form("ThumbnailRealFilePath_" & i)&"<br>")
						Response.Write("ThumbnailFileSize: "&Request.Form("ThumbnailFileSize_" & i)&"<br>")						
						Response.Write("ThumbnailFileIndex: "&Request.Form("ThumbnailFileIndex_" & i)&"<br>")
						Response.Write("ThumbnailFileMD5: "&Request.Form("ThumbnailFileMD5_" & i)&"<br>")
						Response.Write("Url to thumbnail: "&System.IO.Path.GetDirectoryName(Request.ServerVariables("PATH_INFO")).Replace("\\","/") & "/UploadedFiles/"&System.IO.Path.GetFileName(myFile.FileName)&"<br><br>")				
					end if
				end if
			next

		else
	     		Response.Write("No files sent!")
		end if

%>
