<?php
namespace model;
include_once 'model/mod_base.php';
class mod_ads extends mod_base{
	function mod_download_ads(){
		$conn = $this->db_conn();
		$result = mysql_query("select pic_name,pic_link from ads",$conn);
//		print_r($result);
//		echo $result;
//		$rs = mysql_fetch_array($result);
		return $result;
	}
}