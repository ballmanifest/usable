<%@ Application Language="VB" %>
<script runat="server">

'This script remove httpOnly attribut from all cookies to allow JavaPowUpload read them in browser using JavaScript.
	
	Sub Application_EndRequest(ByVal sender As Object, ByVal e As EventArgs)
		' remove httpOnly attribut from all cookies to allow MultiPowUpload read them in browse using JavaScript.
		if(Response.Cookies.Count > 0) then
		   For Each s As String In Response.Cookies.AllKeys
				   Response.Cookies(s).HttpOnly = false
			Next s
		End if
	End Sub
       
</script>