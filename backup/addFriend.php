<?php
	$conn = mysql_connect("127.0.0.1",'root','root');//root???,123456???
	$mycon=mysql_select_db('hanwuji',$conn);
//	$uID = $_REQUEST['uID'];
	$friendID = $_REQUEST['friendID'];
	$sid = $_REQUEST['session_id'];
	session_id($sid);
	session_start();
	$user = $_SESSION['user'];
	$uID = $user['uID'];
	if($user){
	//	echo $uID;
		$sql = "SELECT uID,friendID FROM friends where uID='$uID' and friendID='$friendID'";
		$result = mysql_query($sql,$conn);
		$rs = mysql_fetch_array($result);
		if(!$rs){
		
			$sql = "INSERT INTO friends(uID,friendID) VALUES('$uID','$friendID')";
			$result = mysql_query($sql,$conn);
			$sql = "INSERT INTO friends(uID,friendID) VALUES('$friendID','$uID')";
			$result = mysql_query($sql,$conn);
		}
		else{
			$result = array("retCode"=>-1,"errmsg"=>"friends already");
			echo json_encode($result);
		}
	}
	else{
		$result = array("retCode"=>-1,"errmsg"=>"login failed");
		echo json_encode($result);
	}