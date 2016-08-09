<?php
namespace model;
use model\mod_base;
class mod_robot extends mod_base{
	function mod_login($rID){
		$conn = $this->db_conn();
		$sql = "select * from robot where rID = '".$rID."'";
		$result = mysql_query($sql,$conn);
		$rs = mysql_fetch_array($result);
//		echo $rs['robotname'];
		return $rs;	
	}
}