<cfoutput>Upload result:<br></cfoutput>
<cfset i = 0>
<cfset filename = "FileBody_" & #i#>
<cfset thumbname = "ThumbnailBody_" & #i#>
<cfset dest = GetDirectoryFromPath(ExpandPath("UploadedFiles/"))>

<cfloop condition = "isDefined('Form.#filename#')">	
	    <cffile action="upload" filefield="#filename#" 
		destination="#dest#" nameconflict="overwrite">
            <cfif cffile.fileWasSaved>
            	<cfoutput>File #cffile.clientFile# was saved successfully<br></cfoutput>
            <cfelse>
            	<cfoutput>An error occurred uploading #cffile.clientFile#.<br></cfoutput>
            </cfif>
   	    <cfset i = i+1>
	    <cfset filename = "FileBody_" & #i#>
</cfloop>

<cfset i = 0>
<cfloop condition = "isDefined('Form.#thumbname#')">	
	    <cffile action="upload" filefield="#thumbname#" 
		destination="#dest#" nameconflict="overwrite">
            <cfif cffile.fileWasSaved>
            	<cfoutput>Thumbnail #cffile.clientFile# was saved successfully<br></cfoutput>
            <cfelse>
            	<cfoutput>An error occurred uploading #cffile.clientFile#.<br></cfoutput>
            </cfif>
   	    <cfset i = i+1>
	    <cfset thumbname = "ThumbnailBody_" & #i#>
</cfloop>
