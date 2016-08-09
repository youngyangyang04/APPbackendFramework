<?php
function upload_protrait($filename,$data)
{
 		$ext = pathinfo($filename, PATHINFO_EXTENSION);
// 		$rename = md5(date('Y-m-dHis').rand(123456,999999)).'.'.$ext;
		$binary=base64_decode($data);
		header('Content-Type: bitmap; charset=utf-8');
//		$upload_portrait = UPLOADED_NORMAL_PORTRAITSPATH.$rename;
		$upload_portrait = UPLOADED_NORMAL_PORTRAITSPATH.$filename;
		$file = fopen($upload_portrait, 'wb');
		fwrite($file, $binary);
		fclose($file);
		$thumb_file = UPLOADED_SAMLL_PORTRAITSPATH.$filename;
		create_thumb($upload_portrait, $thumb_file, $ext );
}
function upload_certificate($filename,$data)
{
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
	$binary=base64_decode($data);
	header('Content-Type: bitmap; charset=utf-8');
	$upload_certificate = UPLOADED_NORMAL_WORKPATHSPATH.$filename;
	$file = fopen($upload_certificate, 'wb');
	fwrite($file, $binary);
	fclose($file);
	$thumb_file = UPLOADED_SAMLL_WORKPATHSPATH.$filename;
	create_thumb($upload_certificate, $thumb_file, $ext );
}

function upload_feedback_pic($filename,$data)
{
//	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	$binary=base64_decode($data);
//	echo $binary;
	header('Content-Type: bitmap; charset=utf-8');
	$upload_feedback_pic = UPLOADED_FEEDBACK_PIC.$filename;
	
//	echo $upload_feedback_pic ;
	$file = fopen($upload_feedback_pic, 'wb');
	fwrite($file, $binary);
	fclose($file);
//	$thumb_file = UPLOADED_SAMLL_WORKPATHSPATH.$filename;
//	create_thumb($upload_feedback_pic, $ext );
}