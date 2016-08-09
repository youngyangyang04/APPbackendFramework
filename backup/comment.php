<?php
	
	header('Content-Type: bitmap; charset=utf-8');
	$conn = mysql_connect("127.0.0.1",'root','root');//root???,123456???
	$mycon=mysql_select_db('hanwuji',$conn);
	mysql_query('set names utf8');
	$comment = $_REQUEST['comment'];
//	$uID = $_REQUEST['uID'];
	$sid = $_REQUEST['session_id'];
	session_id($sid);
	session_start();
	$user = $_SESSION['user'];
	if($user){
		$uID = $user['uID'];
		$shuoshuoID = $_REQUEST['shuoshuoID'];
		echo $comment; 
		$sql = "INSERT INTO comment(shuoshuoID,uID,content)VALUES('$shuoshuoID','$uID','$comment')";
		$result = mysql_query($sql,$conn);
	}
	else{
		$result = array("retCode"=>-1,"errmsg"=>"login failed");
		echo json_encode($result);
	}