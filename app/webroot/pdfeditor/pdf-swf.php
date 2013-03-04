<?php
/* $url = "swf/94.pdf";
$swf_path = "swf/94.swf";
$numPages =0;
 echo '<a href="'.$url.'">download</a><br/>';
 if(shell_exec("pdfinfo '$url' | awk '/Pages/ {print $2}'"))
 {         $totalPages = shell_exec("pdfinfo '$url' | awk '/Pages/ {print $2}'");
         echo $totalPages;
 }
 else{
     echo "fail pdfinfo";
 }
         $numPages = intval($totalPages);
         if(shell_exec("pdf2swf -v -t -T 9 '$url' -o '$swf_path'"))
         {
                echo "success";
                         }
          else{
              echo "fail";
          } */
phpinfo();
		  ?>