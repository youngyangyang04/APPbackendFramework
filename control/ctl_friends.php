<?php
namespace control;
use model\mod_friends;
include_once 'model/mod_friends.php';
class ctl_friends extends mod_friends{
	function friends_add($user,$friendID){
		$result_failed = array("retCode"=>-1,"errmsg"=>"friend_add failed");
		$result_success = array("retCode"=>1,"errmsg"=>"friend_add success");
		
		$friend_or_not = $this->mod_friends_or_not($user, $friendID);
		if(!$friend_or_not){
			$friend = $this->mod_friends_add($user, $friendID);
			if($friend !=FALSE){
				echo json_encode($result_success);
			}
			else{
				echo json_encode($result_failed);
			}
		}
		else{
			$result = array("retCode"=>-1,"errmsg"=>"friends already");
			echo json_encode($result);
		}
	}
}

?>