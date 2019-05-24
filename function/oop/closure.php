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

    public function getCountV2($a, $b, $callable)
    {
        if (is_callable($callable)) {
            $data = call_user_func($callable, $a, $b);
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

$res = $a->getCountV2(3, 2, function ($a, $b) {
    $data['msg'] = "$a x $b = ";
    $data['result'] = $a*$b;
    return $data;
});

var_dump($res);

$func = function ($a, $b) {
    $data['msg'] = "$a x $b = ";
    $data['result'] = $a*$b;
    return $data['msg'].$data['result'];
};

var_dump($func(3,2));

echo "-----------------------bindTo-------------------------".PHP_EOL;
# bindTo
class User{
    private $name ;
    function __construct ( $name ){
        $this ->name = $name ;
    }
}

$func = function () {
    return "Hello " . $this ->name;
};

$obj = new User('admin');

$dataUser = $func->bindTo($obj,'User');
echo $dataUser();//Hello admin
echo PHP_EOL;

$dataObj = $func->bindTo($obj,$obj);
echo $dataObj();//Hello admin

echo "-----------------------invoke-------------------------".PHP_EOL;
# invoke
$func = function (string $a, array $arr) {
    return 'variable: '.$a.', arr'.json_encode($arr);
};

$ref = new ReflectionFunction($func);
$args = ['a', ['name' => 'zhangsan', 'age' => 12]];
$res = $ref->invokeArgs($args);
var_dump($res);

$args = ['args0'=>'a', 'args1' =>['name' => 'zhangsan', 'age' => 12]];
extract($args);
$res = call_user_func($func, $args0, $args1);
var_dump($res);
