<?php
define('INVITE_USER_ADD_SCORE',100);
define('SHOW_SORT_ARRAY_NUMBER',10);
function arr_sort($array,$key,$order){
	$arr_nums = $arr=array();
	foreach ($array as $k=>$v){
		$arr_nums[$k]=$v[$key];
	}
	if($order == 'asc'){
		asort($arr_nums);
	}
	else{
		arsort($arr_nums);
	}
	$i=0;
	foreach ($arr_nums as $k =>$v){
		$arr[$i++] = $array[$k];
		//	echo $k."*";
	}
	/* for($i=0;$array[$i];$i++){
	 $arr_nums[$i]=$array[$i]['score'];
	} */
	/* 	for($i=0;$arr[$i];$i++){
	 echo $arr[$i]['score']."*";
	if($arr[$i]['uID']==$uID){
	//			return $i;
	}
	} */
	return $arr;
}
