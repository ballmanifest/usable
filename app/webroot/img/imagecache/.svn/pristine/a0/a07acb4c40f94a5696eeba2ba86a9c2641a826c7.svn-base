<%@ Page language="c#"%>
<%@ Import Namespace="System.IO" %>
<%@ Import Namespace="System.Text" %>
<%@ Import Namespace="System.Web" %>

<script language="CS" runat="server">
/*
JavaPowUpload builtin log area supports only limited count of HTML tags. You can find list here
http://java.sun.com/j2se/1.4.2/docs/api/javax/swing/text/html/HTML.Tag.html
*/
	//Script that generate xml file for JavaPowUpload with specified folder structure.
	//2008. Element-IT software.
	
	//Wich directory structure should be generated		
	//initialized in Page_Load function
	String source_dir = "";		
	//If $direct_output set to true, then generated xml will be printed in response
	//and you can specify this script as source for Download.DataURL parameter
	//Like this:   <param name="Download.DataURL" value="generatexml.php">
	//else  generated xml will be saved to $output_file
	bool direct_output = true;
	//Path to save generated xml file
	String output_file = "";
	FileStream fs = null;
	StreamWriter w = null;

	private void Page_Load(object sender, System.EventArgs e)
	{
		//Set directory 
		source_dir = Server.MapPath("") + "\\UploadedFiles\\";
		if(direct_output)				
			Response.ContentType = "text/xml";
		else
		{
			// Delete the file if it exists.
			if (File.Exists(output_file)) 				
				File.Delete(output_file);				
			//Create the file.
			fs = File.Create(output_file);	
			w = new StreamWriter(fs, Encoding.UTF8);			
		}

		write_xml("<?xml version=\"1.0\" encoding=\"UTF-8\"?>");
		write_xml("<download>");
		add_dir(source_dir);
		write_xml("</download>");
		if(w != null)
			w.Close();
		if(fs != null)
			fs.Close();
	}

	private void add_dir(String parent)
	{
		if(Directory.Exists(parent))
		{
			DirectoryInfo dirInfo = new DirectoryInfo(parent);
			write_xml("<folder name=\""+HttpUtility.HtmlEncode (dirInfo.Name)+"\">"); 
			string [] subdirectoryEntries = Directory.GetDirectories(parent);
			foreach(string subdirectory in subdirectoryEntries)
				add_dir(subdirectory);

			string [] fileEntries = Directory.GetFiles(parent);
			String download_url= "";
			foreach(string fileName in fileEntries)
			{				
				write_xml("<file name=\""+HttpUtility.HtmlEncode(Path.GetFileName(fileName))+"\" length=\""+(new FileInfo(fileName)).Length+"\">"); 
				download_url = "FileProcessingScripts/ASP.NET/CSharp/UploadedFiles/"+
					getRelativePath(source_dir, parent)+
					Path.GetFileName(fileName).Replace(" ","%20");
					
				write_xml("<url>"+download_url+"</url>");
				write_xml("</file>");
			}
			write_xml("</folder>");
		}
	}

	private String getRelativePath(String root, String path)
	{	
		if(!path.Equals(root) && path.StartsWith(root))							
			return  (path.Substring(root.Length).Replace("\\","/")+"/").Replace(" ","%20");
		return "";
	}
			
	
	private void write_xml(String xml)
	{
		if(direct_output)
			Response.Write(xml);
		else
			AddText(w, xml);
	}

	private static void AddText(StreamWriter fs, string value) 
	{		
		fs.Write(value);//info, 0, info.Length);
	}

</script>