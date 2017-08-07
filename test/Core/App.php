<?php
class App {
	protected static $locationMap = array(
			'Vendor' => VENDOR
	);
	protected  static $_classMap = array();
	public static function load($className){
		if(!isset(self::$_classMap[$className])){
			return false;
		}
		var_dump('is looking for class:'.$className);
		if(!isset(self::$locationMap[self::$_classMap[$className]])){
			return false;
		}
		$filename = self::$locationMap[self::$_classMap[$className]].DS.$className.'.php';
		if(!is_file($filename)){
			return false;
		}
		include $filename;
	}
	public static function uses($className, $location){
		self::$_classMap[$className] = $location;
	}
}