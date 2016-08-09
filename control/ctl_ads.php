<?php
namespace control;

use model\mod_ads;
include_once 'model/mod_ads.php';
include_once 'config/global_config.php';
class ctl_ads extends mod_ads{
	function ctl_get_ads(){
		$temp = $this->mod_download_ads();
		$result = array();
		while($rs = mysql_fetch_array($temp)){
			$re['pic_url'] = DOWNLOADED_ADS_PIC.$rs['pic_name'];
			$re['pic_link'] = $rs['pic_link'];
			$result[] = $re;
		}
		return json_encode($result); 
	}
}