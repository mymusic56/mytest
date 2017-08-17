<?php
function aaa(){
	$para = array(
			'name' => 'zhangsan',
			'pwd' => '123456',
	);
	while (list ($key, $val) = each ($para)){
		var_dump($key, $val);
	}
}
