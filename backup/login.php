<?php
	header("Content-Type: text/html; charset=utf-8") ;
	
	$conn = mysql_connect('localhost','root','root');
	$myconn = mysql_select_db('hanwuji',$conn);
	//echo "mysql connected!";
	session_start();
	if(!empty($_REQUEST['phone']))
	{
		$phone = trim($_REQUEST['phone']);
	}
	else 
	{
		$result = array("retCode"=>-1,"errmsg"=>"phone not set");
		echo json_encode($result);
	}
	if(!empty($_REQUEST['password']))
	{
		$password = trim($_REQUEST['password']);
	}
	else 
	{
		$result = array("retCode"=>-1,"errmsg"=>"password not set");
		echo json_encode($result);
	}
	
	
	$identifier = $phone;	
	
	/*
	 * 签名函数
	 */
/*	if(!empty($_REQUEST['identifier']))
	{
		$identifier = $_REQUEST['identifier'];
	}
	else 
	{
		$result = array("retCode"=>-1,"errmsg"=>"identifier not set");
		echo json_encode($result);
	}
*/	
	
	
	
	$account_type = 1386;
	$appid_at_3rd = 1400002202;
	$sdk_appid = 1400002202;
	$expiry_after = 2592000;
	$private_key_path = '/data/www/nginx/html/hanwuji/key/ec_key.pem';
	
	function signature($account_type, $identifier, $appid_at_3rd,
			$sdk_appid, $expiry_after, $private_key_path)
	{
		$command = '/data/www/nginx/html/hanwuji/tls/signature'
				. ' '. escapeshellarg($private_key_path)
				. ' ' . escapeshellarg($expiry_after)
				. ' ' . escapeshellarg($sdk_appid)
				. ' ' . escapeshellarg($account_type)
				. ' ' . escapeshellarg($appid_at_3rd)
				. ' ' .escapeshellarg($identifier);
		$ret = exec($command, $out, $status);
		if( $status == -1)
		{
			return null;
		}
		return $out;
	}
// 	if(!$_REQUEST)
// 		return false;
	
// 	$name = $_REQUEST['name'];
// 	$passwd = $_REQUEST['passwd'];
	//验证用户存在
	mysql_query('set names utf8');
	$result = mysql_query("select * from user where phone='$phone' and password = '$password' limit 1",$conn);
	$arr = array(); //存储json数据格式返回给客户端
	$user = mysql_fetch_array($result);
	if($user&&$identifier)
	{
		$user['sid'] = session_id();
		$_SESSION['user'] = $user;
		$arr = array(
				'flag' => 'login ok!',
				'retCode' => 1,
				
// 				'result'=>$user
				'result' => array(
						'uID' => $user['uID'],
						'username' => $user['username'],
						'password' => $user['password'],
						'sign' => $user['sign'],
						'face' => 'http://localhost/image'.$user['portrait'],
						'phone' => $user['phone'],
						'uptime' => $user['uptime'],
						'signature'=>signature($account_type, $identifier, $appid_at_3rd,
			$sdk_appid, $expiry_after, $private_key_path),
						'sid' => $user['sid']
		)		
	);
		echo json_encode($arr);
		
}
	else 
	{
		$arr = array(
				'flag' => 'login faild!',
				'retCode' => -1,
				'result' => array(
						'uID' => '',
						'username' => '',
						'password' => '',
						'sign' => '',
						'face' => '',
						'phone' => '',
						'uptime' => '',
						'sid' => ''
		)		
	);
	echo json_encode($arr);
}	
		
