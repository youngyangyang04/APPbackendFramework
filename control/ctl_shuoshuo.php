<?php

namespace control;
use model\mod_shuoshuo;
include_once 'model/mod_shuoshuo.php';
class ctl_shuoshuo extends mod_shuoshuo{
	
	function get_shuoshuos($refreshTime,$refresh,$loadMoreTime,$uID){
		
		$shuoshuo = $this->mod_get_shuoshuos_by_time($refreshTime,$refresh,$loadMoreTime,$uID);
	//	$robotInfo = $this->mod_get_robotInfo_by_rID($rID);
		$shuoshuoNum=$shuoshuo[0][0];
	//	echo $shuoshuoNum;
		$index =1;
		$result = array();
//		foreach ($shuoshuo as $obj){
		for($i=1;$i<=$shuoshuoNum;$i++){
			$obj = $shuoshuo[$i];
//			$getLike = $this->get_like($obj['shuoshuoID']);
			$picsURL = $this->string_division($obj['picsURL']);
			$arr['image']=$picsURL;
			$pics_normal_URL = $this->string_division_normal($obj['picsURL']);
			$arr['normal_image']=$pics_normal_URL;
//			$arr['face']="http://aiiage.com/hanwuji_1/data/uploadedimages/1bcd99ae548df26c447941fdb0119d87.jpg";
			$arr['face']=$obj['portrait'];
//			$arr['name']='小5';
			$arr['name']=$obj['robotname'];
			//	$arr['content']=$obj['content'];
			$arr['likeNum']=$obj['zanNum'];
			$arr['time']=$obj['uptime'];
			
			$arr['shuoshuoID']=$obj['shuoshuoID'];
			$arr['likeID']=$this->mod_get_like_portrait($arr['shuoshuoID']);
			$arr['isClick']=$obj['zanyourself'];
			$arr['comment']=$this->mod_get_shuoshuo_comments($arr['shuoshuoID']);
			$result[$index++] =  $arr;
		}
		$_arr = json_encode($result);
		return $_arr;
	}
}
