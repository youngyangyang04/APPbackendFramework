<?php

	 $conn = mysql_connect("localhost",'root','root');//root???,123456???
	// $conn = mysql_connect("192.168.1.43",'zhf','123456');//root???,123456???
	 $mycon=mysql_select_db('hanwuji',$conn);
    // Get image string posted from Android App
    $base=$_REQUEST['image'];
    // Get file name posted from Android App
    $filename = $_REQUEST['filename'];
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	$rename = date('Y-m-dHis').'.'.$ext;
	
    // Decode Image
    $binary=base64_decode($base);
    header('Content-Type: bitmap; charset=utf-8');
    // Images will be saved under 'www/imgupload/uplodedimages' folder
    $file = fopen('uploadedimages/'.$rename, 'wb');
    // Create File
    fwrite($file, $binary);
    fclose($file);
	$result = mysql_query("INSERT INTO shuoshuo(picsURL) VALUES('$rename')",$conn);
    echo 'Image upload complete, Please check your php file directory';
?>