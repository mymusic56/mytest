<?php
namespace Think\B;
class Bb{
	private static $_instance = null;
	public static function connect($class){
		$class = 'Think\Storage\Driver\\'.$class;
		if(!self::$_instance){
			self::$_instance = new $class();
		}
	}
	public static function __callstatic($method, $option=null){
// 		var_dump(method_exists(self::$_instance, $method));
		if(method_exists(self::$_instance, $method)){
			return call_user_func_array(array(self::$_instance, $method), $option);
		}
	}
}