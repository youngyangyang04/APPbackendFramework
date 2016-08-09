<?php
namespace control;
use model\mod_user;
include_once 'model/mod_user.php';
include_once 'lib/upload_image.php';
class ctl_user extends mod_user{
	function change_password($phone,$password){
		return $this->mod_change_password($phone, $password);
	}
	function check_phone($phone){
		return $this->mod_check_phone_exist($phone);
	}
	function register_or_not($phone,$password){
		return $this->mod_register_or_not($phone,$password);
	}
	function code_or_not($phone,$code){
		return $this->mod_code_or_not($phone,$code);
	}
	function add_num_invite($inviteID){
		$this->mod_add_num_invite($inviteID);
	}
	function get_invite_num($uID){
		return $this->mod_get_invite_num($uID);
	}
	function register($phone,$password,$inviteID){
		
		$check = $this->mod_register_or_not($phone);
		if($check)
		{
			$msg = array("retCode"=>-1,"errmsg"=>"Phone number is occupied");
			return json_encode($msg);
		}
		else {
			$result = $this->mod_insert($phone, $password);
			if($result)
			{
				$this->mod_add_num_invite($inviteID);
				$msg = array("retCode"=>1,"errmsg"=>'register success!');
				return json_encode($msg);
			}
		}
	}
	function user1_update($phone,$uID, $act){
	
		$check = $this->mod_check_phone_exist($phone);
		if($check)
		{
			$msg = array("retCode"=>-1,"errmsg"=>"Phone number has been registered!");
			return $msg;
		}
		else
		{
			$this->mod_update_user($phone, $uID, $act);
// 			$temp = $this->mod_check_password_change_or_not($phone, $password);
// 			if($temp){
// 				$user['sid'] = null;
// 			}
		}
	}
	function user_update($value,$uID,$act){
		
// 		$check = $this->mod_check_phone_exist($phone);
// 		if($check)
// 		{
// 			$msg = array("retCode"=>-1,"errmsg"=>"Phone number has been registered!");
// 			echo json_encode($msg);
// 		}
// 		else
// 		{
			$this->mod_update_user($value, $uID, $act);
			//$temp = $this->mod_check_password_change_or_not($phone, $password);
			//if($temp){
			//	$user['sid'] = null;
		//	}
// 		}
	}

	function ctl_add_feekback($uID,$username,$phone,$arr){
		$result_s = array('retCode'=>1,'msg'=>'success');
		$result_f = array('retCode'=>-1,'msg'=>'failed');

		$feedback = json_decode($arr);

		$feedback_words = $feedback->feedback_words;
		$feedback_pic_form = $feedback->feedback_pic_form;
		$feedback_data = $feedback->feedback_data;
		
		$filename = $feedback_pic_form;
		upload_feedback_pic($filename, $feedback_data);
		$feedback_pic_url = $filename;
		$rs = $this->mod_add_feedback($uID, $username, $phone, $feedback_words, $feedback_pic_url);
		if($rs!=null){
			return $result_s;
		}
		else{
			return $result_f;
		}
	}
	
	
	
	function ctl_get_diffday($uID){
		$diffday = $this->mod_get_diffday($uID);
		return  $diffday;
	}
	function ctl_get_difftime($code){
	    $difftime = $this->mod_get_difftime($code);
	    return  $difftime;
	}
	function ctl_get_sign_future($uID){
		$diffday = $this->ctl_get_diffday($uID);
		$days = $this->mod_get_continuous_days($uID);
		if($diffday == 0 || $diffday == 1){
			if($days==1)
				$result=2;
			else 
				$result = 3;
		}
		else if($diffday>1){
			$result = 1;
		}
	
		return $result;
	}
	function ctl_add_score_sign($uID){
		$diffday = $this->ctl_get_diffday($uID);
		if($diffday == 0)
		{
			$result = array('retCode'=>-1,'msg'=>'sorry you cannot sign again!');
			return $result;
		}
		else if($diffday == 1)
		{	
			$days = $this->mod_get_continuous_days($uID);
			$this->mod_add_score_by_continuous($uID,$days);
			if($days==1)
				$result = array('retCode'=>1,'msg'=>"continuous "."2",'add_score'=>2);
			else 
				$result = array('retCode'=>1,'msg'=>"continuous "."3",'add_score'=>3);
			return $result;
		}
		else if ($diffday > 1) {
			$this->mod_add_score_day($uID);
			$result = array('retCode'=>1,'msg'=>'sign success!','add_score'=>1);
			return $result;
		}
	}
}

?>