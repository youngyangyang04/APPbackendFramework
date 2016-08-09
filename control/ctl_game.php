<?php
namespace control;

use model\mod_user;

include_once 'model/mod_user.php';
//include_once 'lib/sort.php';//本来应该把这个函数独立出来，可是一调这个函数阿里云就不运行了
include_once 'config/game_config.php';


class ctl_game extends mod_user{
	
	function update_game_score($uID,$game_score){
		
		$result_update_failed = array("retCode"=>-1,"errmsg"=>"update failed");
		$old_game_score = $this->mod_get_game_score($uID);
//		echo $old_game_score;
		if($game_score > $old_game_score){
			$rs = $this->mod_update_game_score($uID, $game_score);
//			echo $rs;
			if($rs){
				$result_update_success = array("retCode"=>1,
						"max_game_score"=>$game_score,
						"errmsg"=>"update success");
				return json_encode($result_update_success);
			}
			else 
				return json_encode($result_update_failed);
		}
		else{
			$result_original = array("retCode"=>0,
					"max_game_score"=>$old_game_score,
					"errmsg"=>"do not need to update");
			return json_encode($result_original);
		}
	}
	
	function get_score($uID){
		return $this->mod_get_score($uID);
	}
	function get_ranking_list(){
		$list = $this->mod_get_score_and_other();
		
		$list = arr_sort($list, "score", "desc"); //up :asc  down: desc
		$list = array_slice($list,0,SHOW_SORT_ARRAY_NUMBER);
		return $list;
	}

	function get_ranking_by_uID($uID){
//		$uID = 3;
		$list = $this->mod_get_score_and_other();
		$list = arr_sort($list, "score", "desc");
//		for($i=0;$i)
		for($i=0;$list[$i];$i++){
//			echo $list[$i]['score']."*";
			if($list[$i]['uID']==$uID){
				return $i+1;
			}
		}
		return null;
	}
	function add_score($uID,$score){
		$this->mod_add_score($uID, $score);
	}
	
	
}