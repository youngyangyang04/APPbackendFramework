<?php
namespace control;

use model\mod_game_rule;
include_once 'model/mod_game_rule.php';
include_once 'config/global_config.php';
class ctl_game_rule extends mod_game_rule{
	function ctl_get_game_rule(){
		$temp = $this->mod_get_game_rule();
		$result = array();
		while($rs = mysql_fetch_array($temp)){
			$te['title'] = $rs['title'];
			$te['content'] = $rs['content'];
			$result[] = $te; 
		}
		return json_encode($result);
	}
	function ctl_get_game_gift(){
		$temp = $this->mod_get_game_gift();
		$result = array();
		while($rs = mysql_fetch_array($temp)){
			$te['pic_url'] = DOWNLOADED_GAME_GIFT.$rs['pic_name'];
			$te['pic_detail_url'] = DOWNLOADED_GAME_GIFT.$rs['pic_detail_name'];
			$te['score'] = $rs['score'];
			$te['state'] = $rs['state'];
			$te['title'] = $rs['title'];
			$te['content'] = $rs['content'];
			$te['heading'] = $rs['heading'];
			$result[] = $te;
		}
		return json_encode($result);
	}
}