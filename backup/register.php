<?php
header("Content-Type: text/html; charset=utf-8") ;
$conn = mysql_connect('localhost','root','root');
$myconn = mysql_select_db('hanwuji',$conn);
if(!empty($_REQUEST['phone'])&&!empty($_REQUEST['password']))
{
	$phone = trim($_REQUEST['phone']);
	$password = trim($_REQUEST['password']);


mysql_query('set names utf8');
$check = mysql_query("select * from user where phone='$phone'",$conn);
$check1 = mysql_fetch_array($check);
if($check1)
{
	$msg = array("retCode"=>-1,"errmsg"=>"Phone number is occupied");
	echo json_encode($msg);
}
else {
	$result = mysql_query("INSERT INTO user(password,phone) VALUES('$password','$phone')",$conn);
	if($result)
	{
		$msg = array("retCode"=>1,"errmsg"=>'register success!');
		echo json_encode($msg);
	}
	}
}
else 
{
	$msg = array("retCode"=>-1,"errmsg"=>"phone or password not set");
	echo json_encode($msg);
}