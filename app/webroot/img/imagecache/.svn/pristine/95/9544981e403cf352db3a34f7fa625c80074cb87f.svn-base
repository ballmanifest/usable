<%@ Page Language="C#" AutoEventWireup="true" %>
<%@ Import Namespace="System.IO" %>
<script runat="server">

    private string savePath = "UploadedFiles";
	private string tempPath = "UploadedFiles";
	private string openTag = "<javapowupload>";
    private string closeTag = "</javapowupload>";

    protected void Page_Load(object sender, EventArgs e)
    {
			string fileName = Request.QueryString["fileName"];
			bool resore_directory_structure = true;
            if (!string.IsNullOrEmpty(fileName))
                fileName = HttpUtility.UrlDecode(fileName).Replace("..\\", "");
           
		    bool isEmptyFolder = !string.IsNullOrEmpty(Request.QueryString["isEmptyFolder"]);
            bool isMultiPart = string.IsNullOrEmpty(Request.QueryString["isMultiPart"]) ? false : bool.Parse(Request.QueryString["isMultiPart"]);
            bool querySize = string.IsNullOrEmpty(Request.QueryString["action"]) ? false : Request.QueryString["action"].ToLower().Equals("check")? true: false;
            bool upload = string.IsNullOrEmpty(Request.QueryString["action"]) ? false : Request.QueryString["action"].ToLower().Equals("upload")? true: false;
            long fileSize = string.IsNullOrEmpty(Request.QueryString["totalSize"]) ? 0 : long.Parse(Request.QueryString["totalSize"]); ;
          
            string uniqueID = Request.QueryString["fid"] != null ?
                HttpUtility.UrlDecode(Request.QueryString["fid"].ToString()) : string.Empty;
            string comment = Request.QueryString["Comment"] != null ?
                HttpUtility.UrlDecode(Request.QueryString["Comment"].ToString()) : string.Empty;
            string tag = Request.QueryString["Tag"] != null ?
                HttpUtility.UrlDecode(Request.QueryString["Tag"].ToString()) : string.Empty;

            
			
            if (string.IsNullOrEmpty(fileName) || string.IsNullOrEmpty(tempPath)) return;
			
			if(isEmptyFolder) 
				fileName +="/";
			
            string dirPath = GetPath(tempPath);
            string filePath;
			savePath = GetPath(savePath);
			//if we should restore directory structure, then get relative path 
			//and append it to savePath
			
			if(resore_directory_structure && Path.GetDirectoryName(fileName) != null )
			{
				savePath += "/"+GetWinSafePath(Path.GetDirectoryName(fileName));	
				AddPath(savePath);	
			}
			fileName = Path.GetFileName(fileName);
			
           

           Response.Write(openTag);

            filePath = Path.Combine(dirPath, uniqueID+fileName);
			
            FileInfo fi = new FileInfo(filePath);
			if(isEmptyFolder) 
				Response.Write("<ok />");
			else
				if (querySize)
				{
					if (!Directory.Exists(dirPath))                
						WriteError( "The path for file storage not found on the server.");                    
					else                
						if (!fi.Exists)Response.Write("<ok size='0'/>");
						else Response.Write("<ok size='" + fi.Length.ToString() + "'/>");               
				}
				else
				{
					FileStream fs = null;
					System.IO.MemoryStream ms = new System.IO.MemoryStream();
					try
					{                   
						
						if(isMultiPart && Request.Files.Count < 1 )
							WriteError( "No chunk for save!");    						

						if (ms != null)
						{
							if (!isMultiPart)
								SaveFile(Request.InputStream, ms);
							else
								SaveFile(Request.Files[0].InputStream, ms);
							
						}
						
						if (File.Exists(filePath))                    
							fs = File.Open(filePath, FileMode.Append);                        
						else                    
							fs = File.Create(filePath);
							
						if(fs != null)
						{
							ms.Seek(0, System.IO.SeekOrigin.Begin);
							SaveFile(ms, fs);							
							fs.Close();
						}

						if ((new FileInfo(filePath)).Length >= fileSize)
						{    
							//rename or move temp file						
							if(File.Exists(Path.Combine(savePath, fileName)))							
								//File.Delete(Path.Combine(savePath, fileName)); and then move temp file to destination folder
								//File.Move(filePath , Path.Combine(savePath, fileName));
								//or remove  temp file and keep first copy of file
								File.Delete(Path.Combine(savePath, fileName));
							
							File.Move(filePath , Path.Combine(savePath, fileName));
							
							 // Place here the code making postprocessing of the uploaded file (moving to other location, database, etc). 
							
						}					
						Response.Write("<ok />");
					}
					catch (Exception ex)
					{         
						if(fs != null)
							fs.Close();
						if(ms!=null)
							ms.Close();
						WriteError( "Error: " + ex.Message);                  
					}
				
					finally
					{
						if(fs != null)
							fs.Close();
						if(ms!=null)
							ms.Close();
					}
				}
           Response.Write(closeTag);
           Response.Flush();
    }

    private void WriteError(String error)
	{	        
		Response.Write("<error message=\""+error+"\"/>");			      
		Response.Flush();
	}
	
	private String GetPath(String path)
	{
			
                try
                {
                    path = Server.MapPath(path);
                }
                catch { }
            
			return path;
	}
	
    private void SaveFile(System.IO.Stream stream, System.IO.Stream fs)
    {
        byte[] buffer = new byte[40960];
        int bytesRead;
        while ((bytesRead = stream.Read(buffer, 0, buffer.Length)) != 0)
        {
            fs.Write(buffer, 0, bytesRead);
        }
    }
	
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
</script>

