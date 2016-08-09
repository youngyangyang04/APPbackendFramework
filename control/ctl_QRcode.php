<?php
namespace control;
use model\mod_QRcode;
include_once 'model/mod_QRcode.php';
include_once 'config/global_config.php';
class ctl_QRcode extends mod_QRcode{
	
	public function create_QRcode_by_phone($phone, $QRcode) {
		$pre = ".png";
		$statu = $this->mod_create_QRcode_by_phone($phone, $QRcode);
		if($statu !=0)
		{
			$result = array(
					'retCode'=>1,
					'msg'=>'success',
					'QRcode_path'=>DOWNLOADED_QRCODE.$phone.$pre
			);
			return $result;
		}
		else{
			$result = array(
					'retCode'=>-1,
					'msg'=>'faild'
			);
			return $result;
		}
	}

	
}

?>