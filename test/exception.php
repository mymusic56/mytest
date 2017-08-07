<?php
define('ROOT', realpath('./'));
define('DS', DIRECTORY_SEPARATOR);//directory separation
define('VENDOR', ROOT.DS.'Vendor');
require ROOT.DS.'Core'.DS.'Bootstrap.php';
App::uses('C', 'Vendor');
/**
 * 测试显示程序执行流程， 错误指定文件位置显示
 * 1、捕获错误
 * 2、如何显示程序执行流程 stack trace
 * 
 * 区分错误和异常的区别：
 */
error_reporting(0);
/**
 * 捕获致命错误
 */
function shutdown_function()
{
	$e = error_get_last();
// 	var_dump($e);
	myErrorHandler($e['type'], $e['message'], $e['file'], $e['line']);
}
register_shutdown_function('shutdown_function');

function myErrorHandler($errno, $errstr, $errfile, $errline, $errcontext='') {
	echo "<b>Custom error:</b> [$errno] $errstr<br>";
	echo " Error on line $errline in $errfile<br><br>";
}
set_error_handler("myErrorHandler", E_ALL|E_STRICT);

$test=2;
// 触发错误
if ($test>1) {
	trigger_error("A custom error has been triggered");
}
$r = 5/0;

$c = new C();
try {
	$c->throwException();
	
}catch (Exception $e){
	var_dump($e->getMessage());
}
$c->classNotFund();
