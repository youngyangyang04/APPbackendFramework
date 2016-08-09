<?php
namespace control;
use model\mod_uploadimages;
include_once 'config/global_config.php';
include_once 'model/mod_uploadimages.php';
include_once 'lib/create_small_images.php';
class ctl_uploadimages extends mod_uploadimages{
	function uploadimages($arr,$rID){
		$json = json_decode($arr);	
		$insert_name = array();
		foreach ($json as $k=>$value)
		{
			$filename = $value->name;
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$rename = md5(date('Y-m-dHis').rand(123456,999999)).'.'.$ext;
			$insert_name[] = $rename;
			$binary=base64_decode($value->data);
			header('Content-Type: bitmap; charset=utf-8');
			
			$normal_file = UPLOADED_IMAGESPATH.$rename;
			$file = fopen($normal_file, 'wb');
			fwrite($file, $binary);
			fclose($file);
			
			$thumb_file = UPLOADED_SMALL_IMAGESPATH.$rename;
			create_thumb($normal_file, $thumb_file, $ext );
		}
		if(!empty($insert_name))
		{
			$last_shuoshuoID=$this->mod_insert_shuoshuo_and_get_last_shuoshuoID($insert_name, $rID);			
			$this->mod_insert_pictures($insert_name, $last_shuoshuoID);
			
			/* $shuoshuoCount = $this->mod_get_shuoshuoCount_by_rID($rID);
			$shuoshuoCount++;
			$this->mod_update_shuoshuoCount($shuoshuoCount) */
			
		
		}
		
	}
}

?>