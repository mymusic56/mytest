<?php
App::uses('B', 'Vendor');
class C extends B{
	public $number = 0;
	public function __construct($param=null){
		var_dump('class C: construct()'.json_encode($param));
	}
	public function test2($username='', $age=''){
		var_dump('class C:test2(), name:'.$username.', age:'.$age);
	}
	/**
	 * 抛了异常就得捕获异常，不然会报错
	 * @throws Exception
	 */
	public function throwException(){
		throw new Exception('test throw exception');
	}
	
	public function classNotFund(){
		$d = new D();
		$d->aaa();
	}
}