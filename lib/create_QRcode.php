<?php
include_once 'data/phpqrcode/phpqrcode.php';
function create_QRcode($QRuser)
{

	$phone = $QRuser['phone'];
	$friendID = $QRuser['uID'];
	$portrait = $QRuser['portrait'];
	$errorLevel = 'M';
	$pre = CREATE_QRCODE_PATH;
	$size = '5';
	$filename = 'QR.png';
	$new = $pre.$phone.'.png';
	//定义生成内容
	// 	$content1 = 'http://219.223.242.15:6666/hanwuji/friendAdd.php?friendID='.$friendID.'&sid='.$sid;
	// 	$content = trim($content1);
	$json_content = json_encode(array('uID'=>$friendID,'phone'=>$phone));
	$content = $json_content;
	QRcode::png($content,$filename,$errorLevel,$size,3);
	$face_logo = UPLOADED_NORMAL_PORTRAITSPATH.$portrait;
	$logo = $face_logo;
	//if ($logo !== FALSE) {
	$filename = imagecreatefromstring(file_get_contents($filename));
	$logo = imagecreatefromstring(file_get_contents($logo));
	$QR_width = imagesx($filename);
	$QR_height = imagesy($filename);
	$logo_width = imagesx($logo);
	$logo_height = imagesy($logo);
	$logo_qr_width = $QR_width / 4;
	$scale = $logo_width/$logo_qr_width;
	$logo_qr_height = $logo_height/$scale;
	$from_width = ($QR_width - $logo_qr_width) / 2;
	imagecopyresampled($filename, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
	$logo_qr_height, $logo_width, $logo_height);
	//	}
	imagepng($filename, $new); //there is picture
	return $phone.'.png';
}
