<?php

namespace model;
include_once 'model/mod_base.php';
include_once 'config/global_config.php';
class mod_shuoshuo extends mod_base{
	
	function mod_get_robotInfo_by_rID($rID){
		$conn = $this->db_conn();
		$sql = "select * from robot where rID = '".$rID."'";
		$result = mysql_query($sql);
		$rs = mysql_fetch_array($result);
		return $rs;
	}
	
	function mod_get_like_portrait($shuoshuoID){
		$conn = $this->db_conn();
		$pre_url = DOWNLOADED_NORMAL_PORTRAITSPATH;
		$rs = $this->get_likeID($shuoshuoID);
		$portrait = null;
		//	$likeID = null;
		if(is_array($rs)&&!empty($rs))
		{
			foreach($rs as $likeID)
			{
				$sql = "select portrait from user where uID = '".$likeID."'";
				$result = mysql_query($sql,$conn);
				$rs = mysql_fetch_array($result);
				$portrait[] = $pre_url.$rs["portrait"];
			}
		}
		return $portrait;
	}
	function mod_find_rID_by_uID($uID){
		$conn = $this->db_conn();
		$sql = "select friendID from friends where uID = ".$uID;
		$result_friendsID = mysql_query($sql,$conn);
		$rs = array();
		while($row = mysql_fetch_array($result_friendsID)){
			$rs[]=$row['friendID'];
		}
		return $rs;
	}

	function mod_get_shuoshuos_by_time($refreshTime,$refresh,$loadMoreTime,$uID){
		$pre_url = DOWNLOADED_NORMAL_PORTRAITSPATH;
		$conn = $this->db_conn();
		$rs = $this->mod_find_rID_by_uID($uID);
		$result = array();
//		echo $refresh;
		foreach($rs as $friendsID){
	//		echo $friendsID;
			if($refreshTime == "-1" && $refresh == "true"){
				$result[] = mysql_query("SELECT shuoshuo.*,robot.* FROM shuoshuo,robot where robot.rID = shuoshuo.rID and shuoshuo.rID='".$friendsID."'order by uptime desc limit 10",$conn);
				
	//			echo "adf";
			}else if($refresh == "true") {
	//			echo "traf";
	//			$result[] = mysql_query("SELECT shuoshuo.* FROM shuoshuo where uptime > '" . $time . "' and shuoshuo.rID='".$friendsID."' order by uptime limit 10",$conn);
				$result[] = mysql_query("SELECT shuoshuo.*,robot.* FROM shuoshuo,robot where uptime > '" . $refreshTime . "' and robot.rID = shuoshuo.rID and shuoshuo.rID='".$friendsID."' order by uptime desc limit 10",$conn);
			}else {
	//			echo "asdf";
				$result[] = mysql_query("SELECT shuoshuo.*,robot.* FROM shuoshuo,robot where uptime < '" . $loadMoreTime . "'and shuoshuo.rID='".$friendsID."' and robot.rID = shuoshuo.rID order by uptime desc limit 10",$conn);
			}
		}
		$i=1;
		$rs = array(array());
		foreach($result as $temp){
			while ($row = mysql_fetch_array($temp)){
				if($row){
					$row['portrait']= $pre_url.$row['portrait'];
					$rs[$i++] = $row;
				}
			}
		}
//		echo $i;
		
		$temp = $i-1;
		$rs[0][0] = $temp;
		return $rs;
	}
/* 	function conn(){
		$conn01 = mysql_connect("localhost",DATABASEUSERNAME,DATABASEPASSWORD);//rootÃ¦ËœÂ¯Ã¥Â¸ï¿½Ã¥ï¿½Â·,123456Ã¦ËœÂ¯Ã¥Â¯â€ Ã§Â ï¿½
		$mycon=mysql_select_db(DATABASENAME,$conn01); //testdatabaseÃ¦ËœÂ¯mysqlÃ¦â€¢Â°Ã¦ï¿½Â®Ã¥Âºâ€œÃ¥ï¿½ï¿½
		return $conn01;
	
	} */
	
	
	function mod_get_shuoshuo_comments($shuoshuoID){
		$conn = $this->db_conn();
		$sql = "SELECT * FROM comment where shuoshuoID = '".$shuoshuoID."'";
		$result = mysql_query($sql,$conn);
		$comment = null;
		while($rs = mysql_fetch_array($result)){
			$temp['portrait'] = $this->find_portrait_by_uID($rs['uID']);
			$temp['content'] = $rs['content'];
			$temp['timestamp'] = $rs['timestamp'];
			$comment[] = $temp;
		}
		return $comment;
	}
	
	function string_division($String){
//		$pre_url = DOWNLOADED_NORMAL_IMAGESPATH;
		$pre_url = DOWNLOADED_SMALL_IMAGESPATH;
		$arr = explode("#",$String);
		$count = count($arr);
	
		for($i=0;$i<$count;$i++){
			$result[$i] = $pre_url.$arr[$i];
		}
		return  $result;
	}
	function string_division_normal($String){
		$pre_url = DOWNLOADED_NORMAL_IMAGESPATH;
		$arr = explode("#",$String);
		$count = count($arr);
		
		for($i=0;$i<$count;$i++){
			$result[$i] = $pre_url.$arr[$i];
		}
		return  $result;
	}
	function get_likeID($shuoshuoID){
		$conn = $this->db_conn();
		$sql = "select likeID from friendslike where shuoshuoID = ".$shuoshuoID;
		$result = mysql_query($sql,$conn);
		$rs = null;
		while($row = mysql_fetch_array($result)){
			$rs[] = $row['likeID'];
		}
		return $rs;
	}
	
	function find_portrait_by_uID($uID){
		$pre_url = DOWNLOADED_NORMAL_PORTRAITSPATH;
		$conn = $this->db_conn();
		$sql = "SELECT portrait FROM user where uID = '".$uID."'";
		$result = mysql_query($sql,$conn);
	
		$rs = mysql_fetch_array($result);
	
		$portrait = $pre_url.$rs['portrait'];
	
		return $portrait;
	}
}

?>