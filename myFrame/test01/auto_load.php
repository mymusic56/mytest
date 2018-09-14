<?php
function __autoload($class){
	$filename = $class.'.php';
	if(is_file($filename)){
		require $filename;
	}
}
$a = new A();
//http://tphome.mytest.com/test/test01/auto_load.php