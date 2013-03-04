<%@ Application Language="C#" %>
<script runat="server">

/* 
C# Global.asax file for ASP.NET sample. 
This script remove httpOnly attribut from all cookies to allow MultiPowUpload read them in browse using JavaScript.
*/

	void Application_EndRequest(object sender, EventArgs e) 
	{
		//remove httpOnly attribute from all cookies to allow MultiPowUpload read them in browse using JavaScript.
		if(Response.Cookies.Count > 0)
		   foreach(string s in Response.Cookies.AllKeys)        
				   Response.Cookies[s].HttpOnly = false;
	}
	
</script>
