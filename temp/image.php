<?php


 $conn = mysql_connect("localhost",'root','root');//root???,123456???
// $conn = mysql_connect("192.168.1.43",'zhf','123456');//root???,123456???
 $mycon=mysql_select_db('hanwuji',$conn);
 
																			 /*
																			 $arr = '[{
																						"name":"1.jpg",
																						"data":"1base64"
																						},
																					{
																						"name":"2.jpg",
																						"data":"2base64"
																						}
																					]';
																			 
																			 */
																			 
																			// $json = array(array('data'=>'1.jpg'),
																			// 			  array('data'=>'2.jpg')
																					
																			// );

$arr=$_REQUEST['image'];

$json = file_get_contents('php://input');
//var_dump(json_decode($arr));
$json = json_decode($arr);
$name = array();
$insert_name = array();
 foreach ($json as $k=>$value)
{
	$name[] = $value->name;
																				//echo $value->name;
																				
																			// // 	if(empty($value->data))
																			// // 		echo $value->data;
																			// // 	else 
																			// // 		echo "not null";
																			// 	$filename = $value->data;
																			// 								$image[] = $value->data;
																			// 								echo $value->data;
																				
	$filename = $value->name;
	
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	$rename = date('Y-m-dHis').'.'.$ext;
																			//$insert_name[] = date('Y-m-dHis').'.'.$ext;
	
	
	$insert_name[] = $rename;
	
	
																			//echo $filename;
																			// Decode Image
	$binary=base64_decode($value->data);
	header('Content-Type: bitmap; charset=utf-8');
																			// Images will be saved under 'www/imgupload/uplodedimages' folder
	$file = fopen('uploadedimages/'.$rename, 'wb');
																			// Create File
	fwrite($file, $binary);
	fclose($file);
	
	
	
	
																			//  	$file = fopen('image/'.$filename, 'wb');
																			//  	$binary=base64_decode($base);
																			//  	//Create File
																			// 	fwrite($file, "hello");
																			//  	fclose($file);
																				
																			// 	//$insert = implode('#',
																				
																				
																			// 	$result = mysql_query("insert into images(imgs) values('$filename')",$conn);
																				
}
																			// $insert_name =array();
 foreach ($name as $k => $n)
 //{
	
 	$ext = pathinfo($n, PATHINFO_EXTENSION);
																			// 	//$ext = end(explode(".", $n));
																			// 	//$insert_name[] = $i.'.'.$ext;
	
 	if(!empty($insert_name))
	{
 		$insert = implode("#", $insert_name);
 		$result = mysql_query("INSERT INTO shuoshuo(picsURL) VALUES('$insert')",$conn);
	}
echo  "SERVER ARR=".$arr."   REQUEST=".$_REQUEST;																			// // 	echo $insert;
// }
