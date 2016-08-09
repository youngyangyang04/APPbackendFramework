<?php
namespace model;
use model\mod_base;

class mod_like extends mod_base{
	function mod_like_or_not($user,$shuoshuoID){
		$uID = $user['uID'];
		$conn = $this->db_conn();
		$sql = "SELECT shuoshuoID,likeID FROM friendslike where shuoshuoID = '$shuoshuoID' and likeID = '$uID'";
		$result = mysql_query($sql,$conn);
		$rs = mysql_fetch_array($result);
		return $rs;
		
	}
	function mod_insert_like($user,$shuoshuoID){
		$conn = $this->db_conn();
		$uID = $user['uID'];
		$sql = "INSERT INTO friendslike(shuoshuoID,likeID)VALUES('$shuoshuoID','$uID')";
		$result = mysql_query($sql,$conn);
		$sql = "UPDATE shuoshuo SET zanNum=zanNum+1 where shuoshuoID = '$shuoshuoID'";
		$result = mysql_query($sql,$conn);
		return $result;
	}
}

?>