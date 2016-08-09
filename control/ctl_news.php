<?php
namespace control;
use model\mod_news;
include_once 'model/mod_news.php';
class ctl_news extends mod_news{
	function get_news(){
		$result = $this->mod_get_news();
		$te=array(array());
		$i=0;
		while($rs = mysql_fetch_array($result)){
			$r['news_url'] = $rs['news_url'];
			$r['title'] = $rs['title'];
			$r['pic_url']=$rs['pic_url'];
			$r['uptime']=$rs['uptime'];
			$te[$i++]=$r;
		}
		return $te;
	}
}