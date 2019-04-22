<?php
/**
 * 测试静态变量
 * @param unknown $id
 * @return string
 */
function a($id){
	static $container = array();
	if(!isset($container[$id])){
		$container[$id] = date('H:i:s');
	}
	return $container[$id];
}

function test(){
	$res1 = a('a');
	sleep(5);
	$res2 = a('a');
	var_dump($res1, $res2,date('H:i:s'));
}

test();