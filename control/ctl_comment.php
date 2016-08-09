<?php
namespace control;
header('Content-Type: bitmap; charset=utf-8');
use model\mod_comment;
include_once 'model/mod_comment.php';
class ctl_comment extends mod_comment{
	

	function comment_add($comment,$user,$shuoshuoID){
 		$result_failed = array("retCode"=>-1,"errmsg"=>"commment failed");
		$result_success = array("retCode"=>1,"errmsg"=>"commment success");
		
		$comment = $this->mod_comment_add($comment, $user, $shuoshuoID);
		 if($comment !=FALSE){
			return  json_encode($result_success);
		}
		else{
			return  json_encode($result_failed);
		}
	 
		
	}
}

?>