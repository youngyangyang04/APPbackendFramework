<?php
header ( "Content-Type: text/html; charset=utf-8" );
//ini_set("display_errors", "On");
//error_reporting(E_ALL | E_STRICT);
include_once 'control/ctl_shuoshuo.php';
include_once 'control/ctl_comment.php';
include_once 'control/ctl_like.php';
include_once 'control/ctl_friends.php';
include_once 'lib/tencentIM.php';
include_once 'lib/upload_image.php';
include_once 'lib/create_QRcode.php';
include_once 'control/ctl_user.php';
include_once 'control/ctl_uploadimages.php';
include_once 'control/ctl_QRcode.php';
include_once 'control/ctl_news.php';
include_once 'control/ctl_game.php';
include_once 'control/ctl_ads.php';
include_once 'control/ctl_game_rule.php';
include_once 'control/ctl_robot.php';
include_once 'lib/sent_msg_by_phone.php';
use control\ctl_shuoshuo;
use control\ctl_comment;
use control\ctl_like;
use control\ctl_friends;
use control\ctl_user;
use control\ctl_uploadimages;
use control\ctl_QRcode;
use control\ctl_news;
use control\ctl_game;
use control\ctl_ads;
use control\ctl_game_rule;
use control\ctl_robot;
// use control;


$mod = $_REQUEST ['mod'];
$act = $_REQUEST ['act'];

if($mod == "ads" && $act == "download"){
	$ctl_ads = new ctl_ads();
	echo $ctl_ads->ctl_get_ads();
	
}


if ($mod != 'user' && $mod != 'pictures' &&$mod!='robot') {
	$sid = $_REQUEST ['session_id'];
	session_id ( $sid );
	session_start ();   
	$user = $_SESSION ['user'];
	$uID = $user ['uID'];
}

// echo $uID;
//dasf



if($mod == "user" && $act == "feedback" ){
	$sid = $_REQUEST ['session_id'];
	session_id ( $sid );
	session_start ();
	$user = $_SESSION ['user'];
	$uID = $user ['uID'];
	$feedback =$_REQUEST['feedback'];
/* 	$feedback ='{
		"feedback_pic_form":".jpg",
		"feedback_words" : "好吃",
		"feedback_data":"/9j/4AAQSkZJ
	}'; */
//	$feedback1 = json_encode($feedback);
/* 	$feedback_pic_form = $_REQUEST['feedback_pic_form'];
	$data =$_REQUEST['feedback_data'];
	$feedback_words = $_REQUEST['feedback_words']; */
	
		
	$username = $user['username'];
	$phone = $user['phone'];
	$ctl_user = new ctl_user();
	$result = $ctl_user->ctl_add_feekback($uID, $username, $phone, $feedback);
	echo json_encode($result);
}
if($mod == 'game' && $act == 'download_game_gift'){
	$ctl_game_rule = new ctl_game_rule();
	echo $ctl_game_rule->ctl_get_game_gift();
}
if($mod == 'game' && $act =='update_game_score'){
//	echo "saf";
	$game_score = $_REQUEST['game_score'];
	$ctl_game = new ctl_game();
	$it = $ctl_game->update_game_score($uID, $game_score);
	echo $it;
}
if($mod == 'game' && $act == 'download_rule'){
	$ctl_game_rule = new ctl_game_rule();
	echo $ctl_game_rule->ctl_get_game_rule();
	
}
if($mod == 'game' && $act =='download_ranking_list'){
	$ctl_game = new ctl_game();
	$list = $ctl_game->get_ranking_list();
	echo json_encode($list);
}

if($mod == 'game' && $act == 'upload_score'){
	$score = $_REQUEST['score'];
	$ctl_game = new ctl_game();
	$ctl_game->add_score($uID, $score);
}

if($mod == 'news' && $act == 'download'){
	$ctl_news = new ctl_news();
	$news = $ctl_news->get_news();
	echo json_encode($news);
}
if ($mod == 'shuoshuo' && $act == "download") {
	$refreshTime = $_REQUEST ['refreshTime'];
	$loadMoreTime = $_REQUEST ['loadMoreTime'];
	$refresh = $_REQUEST ['refresh'];
	
	if ($user) {
		$ctl_shuoshuo = new ctl_shuoshuo ();
		$shuoshuo = $ctl_shuoshuo->get_shuoshuos ( $refreshTime, $refresh, $loadMoreTime, $uID );
		echo $shuoshuo;
	} else {
		$result = array (
				"retCode" => - 1,
				"errmsg" => "login failed" 
		);
		echo json_encode ( $result );
	}
}
if($mod =='game' && $act == 'get_score_and_ranking'){
	$ctl_game = new ctl_game();
	$rs = $ctl_game->get_score($uID);
	$score = $ctl_game->get_ranking_by_uID($uID);
	$rs['score'];
	$ctl_user = new ctl_user();
	$add_furture_score = $ctl_user->ctl_get_sign_future($uID);
	
	$result = array(
			"score" => $rs['score'],
			"ranking"=> $score,
			"add_score"=>$add_furture_score
	);
	echo json_encode($result);
	
}

if ($mod == 'comment' && $act == 'add') {
	$comment = $_REQUEST ['comment'];
	$shuoshuoID = $_REQUEST ['shuoshuoID'];
	if ($user) {
		$ctl_comment = new ctl_comment ();
		$result = $ctl_comment->comment_add ( $comment, $user, $shuoshuoID );
		echo $result;
	} else {
		$result = array (
				"retCode" => - 1,
				"errmsg" => "login failed" 
		);
		echo json_encode ( $result );
	}
}

if ($mod == 'like' && $act == 'add') {
	$shuoshuoID = $_REQUEST ['shuoshuoID'];
	if ($user) {
		// echo $shuoshuoID;
		$ctl_like = new ctl_like ();
		$result = $ctl_like->like_add ( $user, $shuoshuoID );
		echo $result;
	} else {
		$result = array (
				"retCode" => - 1,
				"errmsg" => "login failed" 
		);
		echo json_encode ( $result );
	}
}
if($mod == 'num_invite' && $act == 'download'){
	$ctl_user = new ctl_user();
	$rs = $ctl_user->get_invite_num($uID);
//	$rs['num_invite'];
	$msg = array(
			"num_invite"=>$rs['num_invite'],
			"errmsg" => "succuss"
	);
	echo json_encode($msg);
}

if ($mod == 'friends' && $act == 'add') {
	$friendID = $_REQUEST ['friendID'];
	if ($user) {
		// echo $shuoshuoID;
		$ctl_friends = new ctl_friends ();
		$result = $ctl_friends->friends_add ( $user, $friendID );
		echo $result;
	} else {
		$result = array (
				"retCode" => - 1,
				"errmsg" => "login failed" 
		);
		echo json_encode ( $result );
	}
}

if($mod == 'user' && $act == 'check'){
	if (! empty ( $_REQUEST ['phone'] )) {
		$phone = trim ( $_REQUEST ['phone'] );

		$msg = array();
		$user = new ctl_user ();
		$result = $user->check_phone($phone);	
		if($result){
			$msg = array("retCode"=>-1,"errmsg"=>"Phone number is occupied");
		}
		else{
			$msg = array("retCode"=>1,"errmsg"=>'Phone number is ok');
		}
		echo json_encode ( $msg );
	} else {
		$msg = array (
				"retCode" => - 1,
				"errmsg" => "phone not set"
		);
		echo json_encode ( $msg );
	}
}
if($mod == 'user'&& $act == 'sentmsg'){
	$target = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";
	$phone = $_REQUEST['phone'];
	$mobile = $phone;
	$mobile_code = random(6,1);
	$curr_time = date('y-m-d h:i:s');
	$post_data = "account=cf_hanwj&password=hanwuji2015&mobile=".$mobile."&content=".rawurlencode("验证码：".$mobile_code."，1分钟内有效。验证码请勿告诉陌生人！小5陪你官方热线：0755-86325272");
	//密码可以使用明文密码或使用32位MD5加密
	$gets =  xml_to_array(Post($post_data, $target));
//	echo $gets['SubmitResult']['code'];
	if($gets['SubmitResult']['code']==2){
		$result = array('retCode'=>1,'msg'=>'success!');
		echo json_encode($result);
		$check = insert_into_checkmsg($phone,$mobile_code,$curr_time);
	}
	else
	{
		$result = array('retCode'=>-1,'msg'=>'faild!');
		echo json_encode($result);
	}
}
if($mod == 'user' && $act == 'code'){
	if (! empty ( $_REQUEST ['phone']) && !empty($_REQUEST['code'])) {
		$phone = trim ( $_REQUEST['phone']);
        $code = trim($_REQUEST['code']);
        $msg = array();
        $user = new ctl_user();
        $diff_time = $user->ctl_get_difftime($code);
        
        if ($diff_time <= 60 && $diff_time > 0) {
          $result = $user->code_or_not($phone, $code);
		  if($result){
			 $msg = array("retCode"=>1,"errmsg"=>"Phone_code is ok!");
		  }
		  else{
			$msg = array("retCode"=>-1,"errmsg"=>'Phone_code is error!');
		  }
		echo json_encode ( $msg );
	}
	else 
	{
	    $msg = array (
	        "retCode" => - 1,
	        "errmsg" => "time out!"
	    );
	    echo json_encode ( $msg );
	}
} else {
		$msg = array (
				"retCode" => - 1,
				"errmsg" => "no data!"
		);
		echo json_encode ( $msg );
	}
}
if ($mod == 'user' && $act == 'register') {
	if (! empty ( $_REQUEST ['phone'] ) && ! empty ( $_REQUEST ['password'] )) {
		$user = new ctl_user ();
		$inviteID = null;
		$inviteID = $_REQUEST['inviteID'];
	/* 	if($inviteID != null){
			$user->add_num_invite($inviteID);
		} */
		$phone = trim ( $_REQUEST ['phone'] );
		$password = trim ( $_REQUEST ['password'] );
		
		$result = $user->register ( $phone, $password,$inviteID);
		echo $result;
	} else {
		$msg = array (
				"retCode" => - 1,
				"errmsg" => "phone or password not set" 
		);
		echo json_encode ( $msg );
	}
}

if ($mod == 'pictures' && $act == 'uploadshuoshuo') {
	$arr = $_REQUEST ['image'];
		// echo "SERVER ARR=".$arr." REQUEST=".$_REQUEST;
		// echo json_decode($arr);
		
//	 $arr = '[ { "name":"logo.jpg", "data":"/9j/4AAQSkZJRgABAQ" } ]';
	 
		// $rID = $_REQUEST ['rID'];
	$rID = 2;
	$ctl_uploadimages = new ctl_uploadimages ();
	$ctl_uploadimages->uploadimages ( $arr, $rID );
}
if ($mod == 'updateuser') {
	$ctl_user = new ctl_user ();
	if ($user) {
		$uID = $user ['uID'];
		$phone = $user['phone'];
		switch ($act) {
			case 'phone' :
				$phone1  = $_REQUEST ['phone'];
				if($phone == $phone1)
				{
	//				$ctl_user->user_update ( $phone, $uID, $act );
					$result = array(
							'retCode'=>1,
							'msg'=>'update success!'
					);
					echo json_encode($result);
				}
				else 
				{
					$msg = $ctl_user->user1_update($phone1, $uID, $act);
					if($msg){
						$result = $msg;
						echo json_encode($result);
					}
					else{
						$result = array(
								'retCode'=>1,
								'msg'=>'update success!'
						);
						echo json_encode($result);
						$user['phone'] = $phone1;
					}
				}
				$_SESSION ['user'] = $user;
				break;
			case 'username' :
				$username = $user ['username'] = $_REQUEST ['username'];
				$ctl_user->user_update ( $username, $uID, $act );
				$_SESSION ['user'] = $user;
				break;
			case 'password' :
				$phone = $user['phone'];
				$old_password = $_REQUEST['old_password'];
				$password = $_REQUEST ['password'];
//				echo $phone;
				$ctl_user = new ctl_user ();
				$check = $ctl_user->register_or_not( $phone, $old_password );
				
				if($check){
					$user ['password'] = $password;
					$ctl_user->user_update ( $password, $uID, $act );
					$_SESSION ['user'] = $user;
					$result = array(
							'retCode'=>1,
							'msg'=>'change password successfully'
					);
					echo json_encode($result);
				}
				else{
					$result = array(
							'retCode'=>-1,
							'msg'=>'password is wrong'
					);
					echo json_encode($result);
				}
				break;
			case 'sign' :
				$sign = $user ['sign'] = $_REQUEST ['sign'];
				$ctl_user->user_update ( $sign, $uID, $act );
				$_SESSION ['user'] = $user;
				break;
			case 'portrait' :
			    /*$arr = '[{
			    "name": "logo.jpeg",
			    "data":"/9j/4AAQSkZ"
			    
			    }]';
			    */
				$arr = $_REQUEST ['portrait'];
			/* 	$arr ='{
				"name" : "1.jpg",
				"data":"/9j/4AAQSkZJRgABAQEASABIAAD/7R3AUGhvdG9zaG9wIDMuMAA4Qk
				}'; */
				$portrait = json_decode($arr);
	//			echo $portrait;
				$filename = $portrait->name;
				$data = $portrait->data;
				$user ['portrait'] = $filename;
				upload_protrait ( $filename, $data );
				$ctl_user->user_update ($filename, $uID, $act );
				$_SESSION ['user'] = $user;
				break;
			case 'email' :
				$email = $user ['email'] = $_REQUEST ['email'];
				$ctl_user->user_update ( $email, $uID, $act );
				$_SESSION ['user'] = $user;
				break;
			case 'salary' :
				$salary = $user ['salary'] = $_REQUEST ['salary'];
				$ctl_user->user_update ( $salary, $uID, $act );
				$_SESSION ['user'] = $user;
				break;
			case 'bbirthday' :
				$bbirthday = $user ['bbirthday'] = $_REQUEST ['bbirthday'];
				$ctl_user->user_update ( $bbirthday, $uID, $act );
				$_SESSION ['user'] = $user;
				break;
			case 'gender' :
				$gender = $user ['gender'] = $_REQUEST ['gender'];
				$ctl_user->user_update ( $gender, $uID, $act );
				$_SESSION ['user'] = $user;
				break;
			case 'area' :
				$arr = $_REQUEST['area'];
/* 				$arr = '{
						"country":"中国",
						"province":"广东",
						"city":"深圳"
		
		}'; */
				
				$area = json_decode($arr);
				$country = $area->country;
				$province = $area->province;
				$city = $area->city;
				
				$user ['country'] = $country;
				$user ['province'] = $province;
				$user ['city'] = $city;
				$ctl_user->user_update ( $area,$uID, $act );
				$_SESSION ['user'] = $user;
				break;
			case 'work_certificate' :
				$arr = $_REQUEST ['work_certificate'];
				$work_certificate = json_decode($arr);
				$filename = $work_certificate->name;
				$data = $work_certificate->data;
				$user ['work_certificate'] = $filename;
				upload_certificate($filename,$data);
   				$ctl_user->user_update($filename,$uID, $act);
   				$_SESSION ['user'] = $user;
   				break;
   			}
   			
   		}
   		else
   		{
   			$result = array(
   					'retCode'=>-1,
   					'msg'=>'faild'
   			);
   			echo json_encode($result);
   		}
   		
 	}
if($mod == 'game' && $act == 'sign'){
	$uID = $user['uID'];
	$ctl_sign = new ctl_user();
	$result = $ctl_sign->ctl_add_score_sign($uID);
	echo json_encode($result);
}
if($mod == 'QRcode' && $act == 'create')
{
	if($user)
	{
		$phone = $user['phone'];
		$QRcode = create_QRcode($user);
		$ctl_QRcode = new ctl_QRcode();
		$result = $ctl_QRcode->create_QRcode_by_phone($phone, $QRcode);
		echo json_encode($result);	
	}
	else
	{
		$msg = array (
				"retCode" => - 1,
				"errmsg" => "please login first!"
		);
		echo json_encode ( $msg );
	}
}
if ($mod == 'user' && $act == 'login') {
	session_start ();
	$phone = null;
	$password = null;
	if (! empty ( $_REQUEST ['phone'] )) {
		$phone = trim ( $_REQUEST ['phone'] );
	} else {
		$result = array (
				"retCode" => - 1,
				"errmsg" => "phone not set" 
		);
		echo json_encode ( $result );
	}
	if (! empty ( $_REQUEST ['password'] )) {
		$password = trim ( $_REQUEST ['password'] );
	} else {
		$result = array (
				"retCode" => - 1,
				"errmsg" => "password not set" 
		);
		echo json_encode ( $result );
	}
	// echo "daf";
	// tencentIM information
	$identifier = $phone;
	$account_type = 1386;
	$appid_at_3rd = 1400002202;
	$sdk_appid = 1400002202;
	$expiry_after = 2592000;
 	$private_key_path = '/data/www/nginx/html/hanwuji_1/key/ec_key.pem';
	
	// check login
	$ctl_user = new ctl_user ();
	$user = $ctl_user->register_or_not( $phone, $password );
	if ($user && $identifier) {
		$user ['sid'] = session_id ();
		$_SESSION ['user'] = $user;
		$arr = array (
				'flag' => 'login ok!',
				'retCode' => 1,
				'result' => array (
						'uID' => $user ['uID'],
						'username' => $user ['username'],
//						'password' => $user ['password'],
                        'email' => $user['email'],
				        'salary' => $user['salary'],
				        'bbirthday' => $user['bbirthday'],
				        'gender' => $user['gender'],
//				        'area' => $user['area'],
						'country' => $user['country'],
						'province' => $user['province'],
						'city' => $user['city'],
				        'work_certificate' => URL_IMAGE_PATH.'/small_works_certificate/'.$user['work_certificate'],
						'sign' => $user ['sign'],
						'portrait' => URL_IMAGE_PATH.'/small_portraits/' . $user ['portrait'],
						'phone' => $user ['phone'],
						'uptime' => $user ['uptime'],
						'signature' => signature ( $account_type, $identifier, $appid_at_3rd, $sdk_appid, $expiry_after, $private_key_path ),
						'sid' => $user ['sid'] 
				) 
		);
		echo json_encode ( $arr );
	} else {
		$arr = array (
				'flag' => 'login faild!',
				'retCode' => - 1,
				'result' => array (
						'uID' => '',
						'username' => '',
						'sign' => '',
						'face' => '',
						'phone' => '',
						'uptime' => '',
						'sid' => '' 
				) 
		);
		echo json_encode ( $arr );
	}
}

if($mod == 'user' && $act =='change_password'){
	$phone = $_REQUEST['phone'];
	$password = $_REQUEST['password'];
	$ctl_user = new ctl_user();
	$rs = $ctl_user->change_password($phone, $password);
	if($rs){
		$msg = array("retCode"=>1,"errmsg"=>"success!");
	}
	else {
		$msg = array("retCode"=>-1,"errmsg"=>"fail!");
	}
	echo json_encode($msg);
	
}
if($mod == 'user' && $act == 'forget'){
	if (! empty ( $_REQUEST ['phone']) && !empty($_REQUEST['code'])) {
		$phone = trim ( $_REQUEST['phone']);
		$code = trim($_REQUEST['code']);
		$msg = array();
		$user = new ctl_user();
		$diff_time = $user->ctl_get_difftime($code);
		if ($diff_time <= 60 && $diff_time > 0) {
			$result = $user->code_or_not($phone, $code);
			if($result){
			 $msg = array("retCode"=>1,"errmsg"=>"Phone_code is ok!");
			}
			else{
				$msg = array("retCode"=>-1,"errmsg"=>'Phone_code is error!');
			}
			echo json_encode ( $msg );
		}
		else
		{
			$msg = array (
					"retCode" => - 1,
					"errmsg" => "time out!"
			);
			echo json_encode ( $msg );
		}
	} else {
		$msg = array (
				"retCode" => - 1,
				"errmsg" => "no data!"
		);
		echo json_encode ($msg);
	}
}


if($mod == 'robot' && $act = 'login'){
	session_start ();
	$rID = $_REQUEST['rID'];
	$identifier = $rID;
	$account_type = 1386;
	$appid_at_3rd = 1400002202;
	$sdk_appid = 1400002202;
	$expiry_after = 2592000;
	$private_key_path = '/data/www/nginx/html/hanwuji_1/key/ec_key.pem';
	
	// check login
	$ctl_robot = new ctl_robot();
	$robot = $ctl_robot->register_or_not($rID);
	if ($robot && $identifier) {
		$robot ['sid'] = session_id ();
		$_SESSION ['robot'] = $robot;
		$arr = array (
				'flag' => 'login ok!',
				'retCode' => 1,
				'result' => array (
						'rID' => $robot ['rID'],
						'robotname' => $robot ['robotname'],
						//						'password' => $user ['password'],
						'profile' => $robot['portrait'],
						'QRcode' => $robot['QRcode'],
						'signature' => signature ( $account_type, $identifier, $appid_at_3rd, $sdk_appid, $expiry_after, $private_key_path ),
						'sid' => $robot ['sid']
				)
		);
		echo json_encode ( $arr );
	} else {
		$arr = array (
				'flag' => 'login faild!',
				'retCode' => - 1,
				'result' => array (
						'rID' => '',
						'robotname' => '',
						'sid' => ''
				)
		);
		echo json_encode ( $arr );
	}
}