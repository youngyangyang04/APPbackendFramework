<?php
namespace model;
include_once 'model/mod_base.php';
include_once 'config/global_config.php';
class mod_comment extends mod_base {
	
	function mod_comment_add($comment,$user,$shuoshuoID){
		$conn = $this->db_conn();
		$uID = $user['uID'];
//		echo $uID;
		$sql = "INSERT INTO comment(shuoshuoID,uID,content)VALUES('$shuoshuoID','$uID','$comment')";
		$result = mysql_query($sql,$conn);
		return $result;
	}
}

?>