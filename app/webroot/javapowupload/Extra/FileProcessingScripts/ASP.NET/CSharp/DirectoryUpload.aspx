<%@ Page language="c#"%>
<%@ Import Namespace="System.IO" %>
<script language="CS" runat="server">
/*
JavaPowUpload builtin log area supports only limited count of HTML tags. You can find list here
http://java.sun.com/j2se/1.4.2/docs/api/javax/swing/text/html/HTML.Tag.html
*/
		/*Creates folders.*/
		private void AddPath(string PathToCreate)
		{
			int iBreak;
			iBreak = PathToCreate.LastIndexOf("\\");
			if(iBreak != -1)
			{
				string Parent = PathToCreate.Substring(0, iBreak);
				if(!System.IO.Directory.Exists(Parent))
				{
					AddPath(Parent);
				}
			}

			if(!System.IO.Directory.Exists(PathToCreate))
			{
				System.IO.Directory.CreateDirectory(PathToCreate);
			}
		}


		private string GetWinSafeFileName(string strPath)
		{
			return GetWinSafeName(strPath, false);
		}

		private string GetWinSafePath(string strPath)
		{
			return GetWinSafeName(strPath, true);
		}

		/*
		 Returns the safe file name and extension or safe path of the specified path string.
		All characters that are illegal in file names or paths on Windows 
		and not safe relative path substrings like "?", "..\" are deleted.
		*/
		private string GetWinSafeName(string strPath, bool isPath)
		{
			string safeName = "";
			if(!isPath)
			{
				int slashind = strPath.LastIndexOf("\\");
				int backslashind = strPath.LastIndexOf("/");				
				if(slashind == -1 && backslashind==-1)
					safeName = strPath;
				else if(slashind>backslashind)
					safeName = strPath.Substring(slashind+1, strPath.Length-slashind-1);
				else
					safeName = strPath.Substring(backslashind +1, strPath.Length-backslashind-1);
			}
			else
				safeName = strPath.Replace("/","\\");
 
			int i, charpos;
			char[] mywrongchars = new char[]{'?','*','/',':'};
			char[] systemwrongchars = System.IO.Path.InvalidPathChars;
			char[] wrongchars = new char[systemwrongchars.Length + mywrongchars.Length];
			
			mywrongchars.CopyTo(wrongchars,0); 
			systemwrongchars.CopyTo (wrongchars,mywrongchars.Length);

			for(i=0; i<=wrongchars.Length-1; i++)
			{
				do
				{
					charpos = safeName.IndexOf(wrongchars[i]);
					if(charpos!=-1)
						safeName = safeName.Remove(charpos, 1);
				}while(charpos!=-1);					
			}
			if(!isPath)
			{
				if(safeName.Length > 255 )
					safeName = safeName.Substring(safeName.Length-255, 255);
			}
			//Replace dangerous ..\ at the begin or ..\ at the end or \..\ at the any place
			//of folder path.
			if(isPath)
			{
				while(safeName.IndexOf("\\..\\")!=-1)
					safeName = safeName.Replace("\\..\\", "\\pp\\");
				if(safeName.EndsWith("\\.."))
					safeName = safeName.Substring(0,safeName.Length-2) + "pp";
				if(safeName.StartsWith("..\\"))
					safeName = "pp" + safeName.Substring(2,safeName.Length-2);
			}
			return safeName;
		}

		private void SaveToFolder(HttpPostedFile myFile, string FolderToSave, string nameToSave, string clientRelativePath)
		{
			string serverRelativePath;
			string tmpStr;
			/*Replace "/" with the "\" symbols
			  Cut filename and "\" symbols at the begin and end of path.
			  So path should be in format "folder1\folder2\folder3"
			*/
			tmpStr = clientRelativePath.Replace("/","\\");
			if(tmpStr.IndexOf("\\")!=-1)
				tmpStr = tmpStr.Substring(0,tmpStr.LastIndexOf("\\"));
			if(tmpStr.StartsWith("\\"))
				tmpStr = tmpStr.Substring(1,tmpStr.Length-1);
			serverRelativePath = GetWinSafePath(tmpStr);
			if(nameToSave !="")
			{						
				AddPath(FolderToSave + serverRelativePath);
				myFile.SaveAs(FolderToSave + serverRelativePath + "\\" + nameToSave);
			}
		}


		private void Page_Load(object sender, System.EventArgs e)
		{
			string FolderToSave = Server.MapPath("") + "\\UploadedFiles\\";
			string clientRelativePath;
			string nameToSave;
			int Uploaded=0;
			for (int i = 0; i < Request.Files.Count; i++)
			{						
				HttpPostedFile myFile = Request.Files[i];
				
				clientRelativePath = Request.Form["SelectedPath_"+i];				
				if(clientRelativePath.IndexOf("\\")==-1 && clientRelativePath.IndexOf("/")==-1) //If SelectedPath havn't '\' symbol it is filename
					clientRelativePath = "";
				nameToSave = GetWinSafeFileName(myFile.FileName);
				
				if(nameToSave !="")
				{						

					//Create and Save whole folders structure							
					SaveToFolder(myFile, FolderToSave, nameToSave, clientRelativePath);
					Response.Write("File " + nameToSave + " succesfully saved.<br>");
					Uploaded++;
				}
			
			}
			if(Uploaded == 0)
				Response.Write("No files sent!");
		}


</script>