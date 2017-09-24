<?php
/**
 * 闭包测试
 *
 */
class ClosureTest {
	public $calculate = null;
	public function getCount($a, $b){
		
	    if($this->calculate){
	        $data = call_user_func($this->calculate, $a, $b);
	        if($data){
	            return $data['msg'].$data['result'];
	        }
	    }
	    
		return "SUM: $a + $b";
	}
}
$a = new ClosureTest();

$a->calculate = function ($a, $b){
    $data['msg'] = "$a x $b = ";
    $data['result'] = $a*$b;
    return $data;
};
var_dump($a->getCount(3,2));