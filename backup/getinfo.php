<?php 
//$conn    数据库配置
$phone = $_REQUEST['sess_phone'];

$sid = $_REQUEST['session_id'];
session_id($sid);
session_start();
$sess_phone = $_SESSION['phone'];
if($phone == $sess_phone)
{
	mysql_query('set names utf8');
	$result = mysql_query("select * from user where phone='$phone'",$conn);
	$arr = array();
	$user = mysql_fetch_array($result);
	if($user)
	{
		$arr = array(
				'username' => $user['username']
		);
		echo json_encode($arr);
	}
}



?>