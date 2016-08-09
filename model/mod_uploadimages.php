<?php
namespace model;
class mod_uploadimages extends mod_base{
	function mod_insert_shuoshuo_and_get_last_shuoshuoID($insert_name,$rID){
		$conn = $this->db_conn();
		$picsURL = implode("#", $insert_name);
//		echo $picsURL;
		$result = mysql_query("INSERT INTO shuoshuo(rID,picsURL,thumbsURL) VALUES('$rID','$picsURL','$picsURL')",$conn);
		$sql = "select shuoshuoID from shuoshuo order by shuoshuoID desc limit 1";
		$result = mysql_query($sql,$conn);
		$get_last_shuoshuoID = mysql_fetch_array($result);
		return $get_last_shuoshuoID[0];
	}
	function mod_insert_pictures($insert_name,$last_shuoshuoID){
		$conn = $this->db_conn();
		foreach($insert_name as $url){
			//			$result = mysql_query("INSERT INTO pictures(uID,url,shuoshuoID) VALUES('$uID','$url','$last_shuoshuoID')",$conn);
			$result = mysql_query("INSERT INTO pictures(url,shuoshuoID) VALUES('$url','$last_shuoshuoID')",$conn);
		}
	}
	/* function mod_get_shuoshuoCount_by_rID($rID){
		$conn = $this->db_conn();
		$sql = "select shuoshuoCount from shuoshuo where rID ='".$rID."'";
		$result = mysql_query($sql);
		$get_shuoshuoCount = mysql_fetch_array($result);
		return $get_shuoshuoCount[0];
	}
	 */
}

?>