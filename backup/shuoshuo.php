<?php
	define("DATABASEUSERNAME",'root');//www
	define("DATABASEPASSWORD",'root');//www
	define("DATABASENAME",'hanwuji');
//	define("UPLOADEDIMAGESPATH","http://server.aiiage.com/hanwuji/uploadedimages/");
	define("UPLOADEDIMAGESPATH","http://10.0.0.31/hanwuji/uploadedimages/");
	$refreshTime = $_REQUEST['refreshTime'];
	$loadMoreTime = $_REQUEST['loadMoreTime'];
	$refresh = $_REQUEST['refresh'];
	$sid = $_REQUEST['session_id'];
	session_id($sid);
	session_start();
	$user = $_SESSION['user'];
	$uID = $user['uID'];
	if($_SESSION['user']){
	//	$uID = $_GET['id'];
	//	echo $refreshTime;
		$shuoshuo = get_shuoshuos_by_time($refreshTime,$refresh,$loadMoreTime,$uID);
		$shuoshuoNum=$shuoshuo[0][0];
		
		for($i=1;$i<=$shuoshuoNum;$i++){
			$obj = $shuoshuo[$i];
			$getLike = get_like($obj['shuoshuoID']);
			$picsURL = string_division($obj['picsURL']);
			$arr['face']="http://server.aiiage.com/hanwuji/uploadedimages/1bcd99ae548df26c447941fdb0119d87.jpg";
			$arr['name']="小5";
		//	$arr['content']=$obj['content'];
			$arr['likeNum']=$obj['zanNum'];
			$arr['time']=$obj['uptime'];
			$arr['image']=$picsURL;
			$arr['shuoshuoID']=$obj['shuoshuoID'];
			$arr['likeID']=get_like_protrait($arr['shuoshuoID']);	
			$arr['isClick']=$obj['zanyourself'];
			$arr['comment']=get_shuoshuo_comments($arr['shuoshuoID']);
			$result[$i] =  $arr; 
		}
		$_arr = json_encode($result );	 
		echo $_arr;	
	}
	else{
		$result = array("retCode"=>-1,"errmsg"=>"login failed");
		echo json_encode($result);
	}
function get_likeID($shuoshuoID){
	$sql = "select likeID from friendslike where shuoshuoID = ".$shuoshuoID;
	$result = mysql_query($sql);
	$rs = null;
	while($row = mysql_fetch_array($result)){
		$rs[] = $row['likeID'];
	}
	return $rs;
}

function get_like_protrait($shuoshuoID){
	$pre_url = UPLOADEDIMAGESPATH;
	$rs = get_likeID($shuoshuoID);
	$portrait = null;
//	$likeID = null;
	if(is_array($rs)&&!empty($rs))
	{
		foreach($rs as $likeID)
		{
			$sql = "select portrait from user where uID = '".$likeID."'";
			$result = mysql_query($sql);
			$rs = mysql_fetch_array($result);
			$portrait[] = $pre_url.$rs["portrait"];
		}
	}

	return $portrait;
}

function get_shuoshuos_by_time($time,$refresh,$loadMoreTime,$uID){
	$conn01 = conn();
	$sql = "select friendID from friends where uID = ".$uID;
	$result_friendsID = mysql_query($sql);
	$rs = null;
	while($row = mysql_fetch_array($result_friendsID)){
		$rs[]=$row['friendID'];
	}
	$result = null;
	foreach($rs as $friendsID){
		if($time == "-1" || $time == ""){
	//		echo "tra44444f";
			$result[] = mysql_query("SELECT * FROM shuoshuo where uID='".$friendsID."'order by uptime desc limit 10",$conn01);
		}else if($refresh == "true") {
	//		echo "traf";
			$result[] = mysql_query("SELECT * FROM shuoshuo where uptime > '" . $time . "' and uID='".$friendsID."' order by uptime limit 10",$conn01);
		}else {
			$result[] = mysql_query("SELECT * FROM shuoshuo where uptime < '" . $loadMoreTime . "'and uID='".$friendsID."' order by uptime limit 10",$conn01);
		}
	}
	$i=1;
	foreach($result as $temp){
		while ($row = mysql_fetch_array($temp)){
			$rs[$i++] = $row;
		}
	}
	$rs['0']['0']=$i-1;
	return $rs;
}
function conn(){
	$conn01 = mysql_connect("localhost",DATABASEUSERNAME,DATABASEPASSWORD);//rootÃ¦ËœÂ¯Ã¥Â¸ï¿½Ã¥ï¿½Â·,123456Ã¦ËœÂ¯Ã¥Â¯â€ Ã§Â ï¿½
	$mycon=mysql_select_db(DATABASENAME,$conn01); //testdatabaseÃ¦ËœÂ¯mysqlÃ¦â€¢Â°Ã¦ï¿½Â®Ã¥Âºâ€œÃ¥ï¿½ï¿½
	return $conn01;
	
}
function string_division($String){
	$pre_url = UPLOADEDIMAGESPATH;
	$arr = explode("#",$String);
	$count = count($arr);
	
	for($i=0;$i<$count;$i++){
		$result[$i] = $pre_url.$arr[$i];
	}
	return  $result;
}

function get_like($shuoshuoID){
	return 0;
}
function get_shuoshuo_comments($shuoshuoID){
	$conn1 = conn();
	$sql = "SELECT * FROM comment where shuoshuoID = '".$shuoshuoID."'";
	$result = mysql_query($sql,$conn1);
	$comment = null;
	while($rs = mysql_fetch_array($result)){
		$temp['portrait'] = find_portrait_by_uID($rs['uID']);
		$temp['content'] = $rs['content'];
		$temp['timestamp'] = $rs['timestamp'];
		$comment[] = $temp;
	}
	return $comment;
}
function find_portrait_by_uID($uID){
	$pre_url = UPLOADEDIMAGESPATH;
	$conn1 = conn();
	$sql = "SELECT portrait FROM user where uID = '".$uID."'";
	$result = mysql_query($sql,$conn1);
	
	$rs = mysql_fetch_array($result);
	
	$portrait = $pre_url.$rs['portrait'];
	
	return $portrait;
}
	/* $result = array("obj"=>array (
			array (
					"face"=>"face.png",
					"name" => "James",
					"content" => "There is a server",
					"likeNum" => "20",
					"time" => date('y-m-d h:i:s',time()),
					"image" => array (
							
									$shuoshuo['picsURL'],
									"http://120.24.226.68/uploadedimages/2.bmp",
									"http://120.24.226.68/uploadedimages/2.bmp",
									"http://120.24.226.68/uploadedimages/2.bmp"
							),
					"likeID" => "http://120.24.226.68/uploadedimages/2.bmp",
					"isClick"=>"false" 
			),
			array (
					"name" => "James",
					"content" => "There is a server",
					"likeNum" => "20",
					"time" => date('y-m-d h:i:s',time()),
							"image" => array (
									"http://120.24.226.68/uploadedimages/2.bmp",
									"http://120.24.226.68/uploadedimages/2.bmp",
									"http://120.24.226.68/uploadedimages/2.bmp" 
							) ,
					"likeID" => "afi",
					"isClick"=> "ture" 
			)
	)
	); */ 
	
	/*
	 "4": {
        "face": "http://120.24.226.68/hanwuji/uploadedimages/1bcd99ae548df26c447941fdb0119d87.jpg",
        "name": "小5",
        "likeNum": "0",
        "time": "2015-11-19 15:02:00",
        "image": [
            "http://10.0.0.31/hanwuji/uploadedimages/63f6cda99efbf0a9307da315a5062168.jpg",
            "http://10.0.0.31/hanwuji/uploadedimages/c448ae187b047c353fdefddac81c502c.jpg"
        ],
        "shuoshuoID": "101",
        "likeID": [
            "http://10.0.0.31/hanwuji/uploadedimages/2.bmp",
            "http://10.0.0.31/hanwuji/uploadedimages/3.bmp"
        ],
        "isClick": null,
        "comment": [
            {
                "portrait": "http://10.0.0.31/hanwuji/uploadedimages/2.bmp",
                "content": "好吃",
                "timestamp": "2015-11-19 15:02:29"
            },
            {
                "portrait": "http://10.0.0.31/hanwuji/uploadedimages/2.bmp",
                "content": "好吃",
                "timestamp": "2015-11-19 15:02:25"
            },
            {
                "portrait": "http://10.0.0.31/hanwuji/uploadedimages/2.bmp",
                "content": null,
                "timestamp": "2015-11-19 15:02:23"
            }
        ]
    },
	*/
?>
