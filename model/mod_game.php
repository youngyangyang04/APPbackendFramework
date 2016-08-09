<?php
namespace model;
use model\mod_base;
class mod_game extends mod_base{
	function mod_get_score($uID){
		$conn = $this->db_conn();
		$result = mysql_query("select score from user where uID = '".$uID."'",$conn);
		$rs = mysql_fetch_array($result);
		return $rs;
	}
	function mod_get_score_and_other(){
		$conn = $this->db_conn();
		$result = mysql_query("select score,uID,username,portrait from user",$conn);
		$rs = array(array());
		$i=0;
		while ($te = mysql_fetch_array($result)){
//			$uID = $te['uID'];
			$rs[$i++]=$te;
		}
//		echo $rs[0]['score'];
		return $rs;
	}
}
