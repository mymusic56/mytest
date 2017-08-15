<?php
/**
 * 缓存是共享的
 */
function test(){
	$key = 'zhangsan';
// 	apcu_add($key, 'ni hao!');
	return apcu_fetch($key);
}
var_dump(test());