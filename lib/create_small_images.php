<?php
function create_thumb ($src_file,$thumb_file,$ext) {

	$t_width  = 100;
	$t_height = 62;
	if (!file_exists($src_file)) return false;
	$src_info = getImageSize($src_file);
	//$t_width = $src_info[0]/5;
	//$t_height = $src_info[1]/5;

	$subtype = $ext;
	//如果来源图像小于或等于缩略图则拷贝源图像作为缩略图,免去操作
	if ($src_info[0] <= $t_width && $src_info[1] <= $t_height) {
		if (!copy($src_file,$thumb_file)) {
			return false;
		}
		return true;
	}
	//按比例计算缩略图大小
	if (($src_info[0]-$t_width) > ($src_info[1]-$t_height)) {
		$t_height = ($t_width / $src_info[0]) * $src_info[1];
	} else {
		$t_width = ($t_height / $src_info[1]) * $src_info[0];
	}

	switch ($subtype) {
		case 'jpeg':
		case 'jpg' :
			$src_img = ImageCreateFromJPEG($src_file); break;
		case 'png' :
			$src_img = ImageCreateFromPNG($src_file); break;
		case 'gif' :
			$src_img = ImageCreateFromGIF($src_file); break;
	}
	//创建一个真彩色的缩略图像
	$thumb_img = @ImageCreateTrueColor($t_width,$t_height);
	//ImageCopyResampled函数拷贝的图像平滑度较好，优先考虑
	if (function_exists('imagecopyresampled')) {
		@ImageCopyResampled($thumb_img,$src_img,0,0,0,0,$t_width,$t_height,$src_info[0],$src_info[1]);
	} else {
		@ImageCopyResized($thumb_img,$src_img,0,0,0,0,$t_width,$t_height,$src_info[0],$src_info[1]);
	}
	//生成缩略图
	switch ($subtype) {
		case 'jpeg':
		case 'jpg' :
			ImageJPEG($thumb_img,$thumb_file); break;
		case 'gif' :
			ImageGIF($thumb_img,$thumb_file); break;
		case 'png' :
			ImagePNG($thumb_img,$thumb_file); break;
	}
	//销毁临时图像
	@ImageDestroy($src_img);
	@ImageDestroy($thumb_img);
	return true;
}