<?php

namespace model;
include_once 'config/db_config.php';
class mod_base {
	function db_conn(){
		$conn = mysql_connect(DBHOST,DBUSER,DBPWD);
		$myconn = mysql_select_db(DBNAME,$conn);
//		$conn = mysqli_connect(DBHOST, DBUSER, DBPWD, DBNAME);
		mysql_query('set names utf8');
		return $conn;
	}
}

?>