<?php
/**
 * 闭包测试
 *
 */
class ClosureTest {
	private $count = null;
	public function getCount($a, $b){
		$count = function($a, $b){
			return $a+$b;
		};
		return $count($a, $b);
	}
}
$a = new ClosureTest();
var_dump($a->getCount(1,2));