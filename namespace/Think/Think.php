<?php
namespace Think;
use Think\A\Aa;
use Think\B\Bb;
class Think{
	private static $_map = array();
	public static function autoLoad($class){
		include MYNAMESPACE.$class.'.php';
	}
	public static function start(){
		spl_autoload_register('Think\Think::autoload');
	}
	public static function testAutoLoad(){
		$a = new Aa();
		$a->aaa();
		var_dump('testAutoLoad');
	}
	public static function testCallSatic(){
		Bb::connect('File');
		$filename = MYNAMESPACE.'Think\Think.php';
		var_dump(Bb::isFile($filename));
	}
}