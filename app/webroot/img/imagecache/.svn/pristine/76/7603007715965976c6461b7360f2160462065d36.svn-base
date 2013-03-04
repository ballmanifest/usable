<?php
//First of it should not to be a proper controller, these scripts should behave like API

        ini_set('display_errors', 1);
//It is added for only testing and can be reomved, but keep it for time being
        if($_FILES == null)
        {
                echo '<html><body><form method="post" enctype="multipart/form-data"><label for="file">Filename:</label><input type="file" name="file" id="file" /><br /><input type="submit" name="submit" value="Submit" /></form></body></html>';
                die;
        }

		//Replace time() with the id from DB, here id is the PDF document id should come from DB
		$id = time();
		$dir = 'uploads/' . $id . '/';
        $new_name = $dir . $id . '.pdf';
		
		if ( !file_exists($dir) ) {
			mkdir ($dir, 0764);
		}
		
		//Save user uploaded PDF file
        if($_FILES["file"]["error"] > 0)
        {
                print_r($_FILES);
                echo "Error: " . $_FILES["file"]["error"] . "<br />";
				die;
        }
        else
        {
                move_uploaded_file($_FILES["file"]["tmp_name"], $new_name);
        }

        //Get number of pages for PDF
		$pages = exec("/usr/bin/identify -format %n '" . $new_name . "'");
        //echo $pages;

        $density = 300;
        header("Content-type: text/xml");
        $ret_xml = '<?xml version="1.0"?><pdf id="' . $id . '">';
		
		//Make all required direcory structure
		$high_res = $dir . 'high/';
		$low_res = $dir . 'low/';
		if ( !file_exists($high_res) ) {
			mkdir ($high_res, 0764);
		}
		if ( !file_exists($low_res) ) {
			mkdir ($low_res, 0764);
		}
		//Now generate high low images for each PDF page
		//And also generate a xml to be used in future for flash
        for ($i=0; $i<$pages; $i++){
                //echo "The number is " . $i . "<br>";
                $img = new Imagick();
                $img->setResolution($density, $density);//high res image

                $img->readImage($new_name . "[" . $i . "]");
                $img->setImageFormat("png");
                //echo "PDF page loaded<br />";

				//Each Image height and width should be saved
                $prop = $img->identifyImage();
                $geometry = $prop['geometry'];
				$resolution = $prop['resolution'];
                
                $image_name = $high_res . "_" . $i . ".png";
                $img->writeImage($image_name);
                $ret_xml .= '<page id="' . $i . '" width="' . $geometry['width'] . '" height="' . $geometry['height'] . '"';
				if($resolution['x'] == null || $resolution['x'] == '' || $resolution['y'] == null || $resolution['y'] == '')
					$ret_xml .= ' resolutionX="300" resolutionY="300">';
				else
					$ret_xml .= ' resolutionX="' . $resolution['x'] . '" resolutionY="' . $resolution['y'] . '">';
				
				$ret_xml .= '<high><![CDATA[' . $image_name . ']]></high>';

                $thumb_name = $low_res . "_" . $i . ".png";
				$img->setResolution(72, 72);// low res image
				$img->readImage($new_name . "[" . $i . "]");
                $img->setImageFormat("png");
				
                $prop = $img->identifyImage();
                $geometry = $prop['geometry'];
                //$img->thumbnailImage(120, 0);
                $img->writeImage($thumb_name);
                $ret_xml .= '<low width="' . $geometry['width'] . '" height="' . $geometry['height'] . '"><![CDATA[' . $thumb_name . ']]></low></page>';
        }
        $ret_xml .= '</pdf>';
		
		//save the xml file and also send the response xml to be used in flash
		$xml_file = $dir . 'pdf.xml';
	$fp = fopen($xml_file, 'w');
	fwrite($fp, $ret_xml);
	fclose($fp);
        //file_put_contents($xml_file, $ret_xml);	
		
        echo $ret_xml;
		exit(0);
?>