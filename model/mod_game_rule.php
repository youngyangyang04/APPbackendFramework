<?php
namespace model;
include_once 'model/mod_base.php';
class mod_game_rule extends mod_base{
	function mod_get_game_rule(){
		$conn = $this->db_conn();
		$result = mysql_query("select * from game_rule",$conn);
		return $result;
	}
	
	function mod_get_game_gift(){
		$conn = $this->db_conn();
		$result = mysql_query("select * from game_gift",$conn);
		return $result;
	}
}