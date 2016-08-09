<?php
//connect to database
$conn = mysql_connect("127.0.0.1",'www','www');//root???,123456???
$mycon=mysql_select_db('hanwuji',$conn);
$uID = null;
//get pictures stringstream
$arr=$_REQUEST['image'];
//$uID =$_REQUEST['uID'];

$uID= 2;
//$uID ;
//echo  "SERVER ARR=".$arr;
//echo "aaa";

$json = json_decode($arr);

$insert_name = array();
	foreach ($json as $k=>$value)
	{
		$filename = $value->name;
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		$rename = md5(date('Y-m-dHis').rand(123456,999999)).'.'.$ext;
		$insert_name[] = $rename;
		$binary=base64_decode($value->data);
		header('Content-Type: bitmap; charset=utf-8');
		$file = fopen('uploadedimages/'.$rename, 'wb');
		fwrite($file, $binary);
		fclose($file);
	}

 	if(!empty($insert_name))
	{
		$picsURL = implode("#", $insert_name);
//		echo $uID;
 		$result = mysql_query("INSERT INTO shuoshuo(uID,picsURL) VALUES('$uID','$picsURL')",$conn);
		
		$sql = "select shuoshuoID from shuoshuo order by shuoshuoID desc limit 1";
		$result = mysql_query($sql);
//		echo $result;
		$get_last_shuoshuoID = mysql_fetch_array($result);
		$last_shuoshuoID=$get_last_shuoshuoID[0];
//		echo "fdg";
//		echo $get_last_shuoshuoID;
		foreach($insert_name as $url){
//			$result = mysql_query("INSERT INTO pictures(uID,url,shuoshuoID) VALUES('$uID','$url','$last_shuoshuoID')",$conn);
			$result = mysql_query("INSERT INTO pictures(url,shuoshuoID) VALUES('$url','$last_shuoshuoID')",$conn);
		}
 		
	}
	


