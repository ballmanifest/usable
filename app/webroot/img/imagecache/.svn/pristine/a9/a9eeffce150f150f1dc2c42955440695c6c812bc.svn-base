#!/usr/bin/perl -w



	use CGI;
	use File::Basename;
	use Encode;


	$query = new CGI;
	my $target_encoding = "ISO-8859-1";
	my $i = 0;
	my $j = 0;

	print $query->header ( );	

	print "Upload result:<br>"; 

	$upload_dir = dirname($ENV{'PATH_TRANSLATED'})."/UploadedFiles/";
	@names = $query->param;
	foreach $param (@names) {
		my $filename = $query->param($param);
		$filename =~ s/.*[\/\\](.*)/$1/;
		$filename = encode($target_encoding, decode_utf8($filename));
		my $upload_filehandle = $query->upload($param);

		if(defined($upload_filehandle))
		{

			open UPLOADFILE, ">$upload_dir\\$filename";
			binmode UPLOADFILE;
			while ( <$upload_filehandle> )
			{
			 print UPLOADFILE;
			}
			close UPLOADFILE;
			
			if(($param cmp ("FileBody_".$i)) == 0)
			{
				print "file \"$filename\" uploaded sucessfully<br>" ;
				print "FilePath: ".$query->param("FilePath_".$i)."<br>";
				print "RealFilePath: ".$query->param("RealFilePath_".$i)."<br>";
				print "FileSize: ".$query->param("FileSize_".$i)."<br>";
				print "FileLastModified: ".$query->param("FileLastModified_".$i)."<br>";
				print "FileIndex: ".$query->param("FileIndex_".$i)."<br>";
				print "FileMD5: ".$query->param("FileMD5_".$i)."<br><br>";
				$i+=1;
			}
			if(($param cmp ("ThumbnailBody_".$j)) == 0)
			{
				print "Thumbnail \"$filename\" uploaded sucessfully<br>" ;
				print "ThumbnailPath: ".$query->param("ThumbnailPath_".$j)."<br>";
				print "ThumbnailRealFilePath: ".$query->param("ThumbnailRealFilePath_".$j)."<br>";
				print "ThumbnailFileSize: ".$query->param("ThumbnailFileSize_".$j)."<br>";				
				print "ThumbnailFileIndex: ".$query->param("ThumbnailFileIndex_".$j)."<br>";
				print "ThumbnailFileMD5: ".$query->param("ThumbnailFileMD5_".$j)."<br>";				
				print "Url to thumbnail: ".dirname($ENV{'PATH_INFO'})."/UploadedFiles/".$filename."<br><br>";
				$j+=1;
			}

			print "<br>";

		}
	}
	



