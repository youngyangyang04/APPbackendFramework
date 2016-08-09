<?php
namespace model;
use model\mod_base;
class mod_friends extends mod_base{
	function mod_friends_or_not($user,$friendID){
		$conn = $this->db_conn();
		$uID = $user['uID'];
		$sql = "SELECT uID,friendID FROM friends where uID='$uID' and friendID='$friendID'";
		$result = mysql_query($sql,$conn);
		$rs = mysql_fetch_array($result);
		return $rs;
	}
	
	function mod_friends_add($user,$friendID){
		$conn = $this->db_conn();
		$uID = $user['uID'];
		$sql = "INSERT INTO friends(uID,friendID) VALUES('$uID','$friendID')";
		$result = mysql_query($sql,$conn);
		$sql = "INSERT INTO friends(uID,friendID) VALUES('$friendID','$uID')";
		$result = mysql_query($sql,$conn);
		return $result;
	}
}

?>