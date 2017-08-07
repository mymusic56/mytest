<?php
define('ROOT', realpath('./'));
define('DS', DIRECTORY_SEPARATOR);//directory separation
define('VENDOR', ROOT.DS.'Vendor');
require ROOT.DS.'Core'.DS.'Bootstrap.php';
App::uses('MyAbstract', 'Vendor');
$reflection = new ReflectionClass('MyAbstract');
var_dump($reflection->isAbstract(), $reflection->isInterface());

App::uses('C', 'Vendor');
$reflection = new ReflectionClass('C');
if(!$reflection->isAbstract()){
	$args = ['name'=>'zhangsan', 'age' => 27];
	$c = $reflection->newInstance($args);
// 	$c->test();
// 	$c->test2();
	var_dump('class C extends B:'.is_subclass_of($c, 'B'));
	//调用C::test2()
	$method = new ReflectionMethod($c, 'test2');
	if(!$method -> isPrivate()){
		$method->invokeArgs($c, array('张三','18'));
	}
	try {
		$method = new ReflectionMethod($c, 'throwException');
		$method->invokeArgs($c, []);
	}catch (RuntimeException $e){
		var_dump($e->getMessage());
	}
	var_dump('class C property: '.json_encode(get_class_vars('C')));
}
