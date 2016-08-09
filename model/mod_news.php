<?php
namespace  model;
use model\mod_base;
class mod_news extends mod_base{
	function mod_get_news(){
		$conn = $this->db_conn();
		$result = mysql_query("select * from news",$conn);
		return $result;
	}
}