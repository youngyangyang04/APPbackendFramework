<?php
namespace control;
use model\mod_like;
include_once 'model/mod_like.php';
class ctl_like extends mod_like{
	function like_add($user,$shuoshuoID){
		$result_failed = array("retCode"=>-1,"errmsg"=>"like failed");
		$result_success = array("retCode"=>1,"errmsg"=>"like success");
		
		$like_or_not = $this->mod_like_or_not($user, $shuoshuoID);
		if(!$like_or_not)
		{
			$like = $this->mod_insert_like($user, $shuoshuoID);
			if($like!= FALSE){
				echo json_encode($result_success);
			}
			else{
				echo json_encode($result_failed);
			}
		}
		else{
			$result = array("retCode"=>-1,"errmsg"=>"like already");
			echo json_encode($result);
		}
	}
}

?>