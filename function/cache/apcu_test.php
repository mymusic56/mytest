<?php
/**
 * 缓存是共享的
 */
function test(){
	$key = 'zhangsan';
// 	apcu_add($key, 'ni hao!');//Fatal error: Uncaught Error: Call to undefined function apcu_add() 
	return apcu_fetch($key);
}
var_dump(test());