<?php
namespace model;
use model\mod_base;
include_once 'config/game_config.php';
include_once 'config/global_config.php';
class mod_user extends mod_base{
/* 	function mod_login_or_not($phone,$password){
		$conn = $this->db_conn();
		$result = mysql_query("select * from user where phone='$phone' and password = '$password' limit 1",$conn);
		$user = mysql_fetch_array($result);
		return $user;
	} */
	function mod_change_password($phone,$password){
		$conn = $this->db_conn();
		$result = mysql_query("update user set password = '".$password."' where phone='".$phone."'",$conn);
		return $result;
	}
	function mod_get_game_score($uID){
		$conn = $this->db_conn();
		$result = mysql_query("select game_score from user where uID = '".$uID."'",$conn);
		$rs = mysql_fetch_array($result);
		return $rs['game_score'];
	}
	function mod_update_game_score($uID,$game_score){
		$conn = $this->db_conn();
		$result = mysql_query("update user set game_score = '".$game_score."' where uID='".$uID."'",$conn);
		return $result;
	}
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
			$te['portrait'] = DOWNLOADED_SAMLL_PORTRAITSPATH.$te['portrait'];
			$rs[$i++]=$te;
		}
		//		echo $rs[0]['score'];
		return $rs;
	}
	
	function mod_add_score($uID,$score){
		$conn = $this->db_conn();
		$result = mysql_query("update user set score = score+'".$score."' where uID='".$uID."'",$conn);
	}
	
	
	
	function mod_add_feedback($uID,$username,$phone,$feedback,$feedback_pic_url){
		$conn = $this->db_conn();
	//	$result = mysql_query("insert uID,username,phone,feedback,feedback_pic from feedback where uID ='".$uID."'",$conn);
		$result =mysql_query("INSERT INTO feedback(uID,username,phone,feedback,feedback_pic) VALUES('$uID','$username','$phone','$feedback','$feedback_pic_url')",$conn);
		return $result;
		
	}
	function mod_get_invite_num($uID){
		$this->db_conn();
		$result = mysql_query("select num_invite from user where uID = '".$uID."'");
		$re = mysql_fetch_array($result);
		return $re;
	}
	function mod_add_num_invite($inviteID){
		$conn = $this->db_conn();
		$result = mysql_query("update user set num_invite = num_invite+1 where uID='".$inviteID."'",$conn);
		$result = mysql_query("update user set score = score+'".INVITE_USER_ADD_SCORE."' where uID='".$inviteID."'",$conn);
	}
	function mod_register_or_not($phone,$password){
		$conn = $this->db_conn();
		$result= mysql_query("select * from user where phone='$phone' and password ='$password'",$conn);
		$check = mysql_fetch_array($result);
		return $check;
	}
	function mod_code_or_not($phone,$code){
		$conn = $this->db_conn();
		$result = mysql_query("select * from check_msg where phone='$phone' and phone_code='$code'",$conn);
		$check = mysql_fetch_array($result);
		return $check;
	}
	function mod_insert($phone,$password){
		$conn = $this->db_conn();
		$result = mysql_query("INSERT INTO user(password,phone,username,gender) VALUES('$password','$phone','hanwuji','male')",$conn);
		return $result;
	}
	function mod_check_phone_exist($phone){
		$conn = $this->db_conn();
		$sql = mysql_query("select * from user where phone='$phone'",$conn);
		$check = mysql_fetch_array($sql);
		return $check;
	}
	function mod_update_user($value,$uID,$act){
		$conn = $this->db_conn();
		$field = $act;
		if($field!="area")
			$sql = "update user set ".$field." ='".$value."' where uID='".$uID."'";
		else 
			$sql = "update user set country ='".$value->country."',province= '".$value->province."',city='".$value->city."' where uID='".$uID."'";
		mysql_query($sql,$conn);
	}
	function mod_check_password_change_or_not($phone,$password){
		$conn = $this->db_conn();
		$sql = mysql_query("select password from user where phone='$phone'",$conn);
		$rs = mysql_fetch_array($sql);
		$db_password = $rs['password'];
		if($db_password == $password){
			return 0;
		}
		else return 1;
		
		
	}
	
	
	function mod_get_diffday($uID)
	{
		$conn = $this->db_conn();
		$new_signin_time = date('y-m-d h:i:s');
		$sql = "select DATEDIFF('$new_signin_time',sign_in_time) as diffdate from user where uID = '$uID'";
		$result = mysql_query($sql,$conn);
		$diffdate = mysql_fetch_array($result);
//		echo "safd";
		return $diffdate[0];
	}
	function mod_get_difftime($code)
	{
	    $conn = $this->db_conn();
	    $curr_time = date('Y-m-d h:i:s');
	    $sql = "SELECT  UNIX_TIMESTAMP("."'".$curr_time."'".")" ."- UNIX_TIMESTAMP(curr_time) from check_msg where phone_code = '$code'" ;
	    
	    $result = mysql_query($sql,$conn);
	    $difftime = mysql_fetch_array($result);
	    return $difftime[0];
	    
	}
	
	function mod_add_score_by_continuous($uID,$days)
	{
		$conn = $this->db_conn();
		$new_signin_time = date('y-m-d h:i:s');
		if($days == 1)
			$sql = "update user set score=score+2,continuous_days=continuous_days+1,sign_in_time = '$new_signin_time' where uID = '$uID'";
		else 
			$sql = "update user set score=score+3,continuous_days=continuous_days+1,sign_in_time = '$new_signin_time' where uID = '$uID'";
		$result = mysql_query($sql,$conn);
	}
	function mod_add_score_day($uID)
	{
		$conn = $this->db_conn();
		$new_signin_time = date('y-m-d h:i:s');
		$sql = "update user set score=score+1, continuous_days=1,sign_in_time='$new_signin_time' where uID='$uID'";
		$result = mysql_query($sql,$conn);
	}
	function mod_get_continuous_days($uID)
	{
		$conn = $this->db_conn();
		$day = "select continuous_days from user where uID = '$uID'";
		$result = mysql_query($day,$conn);
		$con_day = mysql_fetch_array($result);
		return $con_day[0];
	}
}

?>