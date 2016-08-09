<?php

$conn = mysql_connect("127.0.0.1",'root','root');//root???,123456???
$mycon=mysql_select_db('hanwuji',$conn);

//$uID = $_REQUEST['uID'];
$sid = $_REQUEST['session_id'];
session_id($sid);
session_start();
$user = $_SESSION['user'];
$uID = $user['uID'];
if($_SESSION['user']){
	$shuoshuoID = $_REQUEST['shuoshuoID'];
//	echo $shuoshuoID;
	$sql = "SELECT shuoshuoID,likeID FROM friendslike where shuoshuoID = '$shuoshuoID' and likeID = '$uID'";
	$result = mysql_query($sql,$conn);
	$rs = mysql_fetch_array($result);
	if(!$rs)
	{
		$sql = "INSERT INTO friendslike(shuoshuoID,likeID)VALUES('$shuoshuoID','$uID')";
		$result = mysql_query($sql,$conn);
		$sql = "UPDATE shuoshuo SET zanNum=zanNum+1 where shuoshuoID = '$shuoshuoID'";
		$result = mysql_query($sql,$conn);
	}
	else{
		$result = array("retCode"=>-1,"errmsg"=>"like already");
		echo json_encode($result);
	}
}
else{
	$result = array("retCode"=>-1,"errmsg"=>"login failed");
	echo json_encode($result);
}