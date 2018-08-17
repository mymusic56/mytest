<?php
/**
 * 1 .声明使用某个命名空间中的类
 *  在命名空间中的用法网上资料比较多，手册上讲解的也详细这里就不赘述了
 * 2.用在匿名函数之后给匿名函数增加参数主要讲解use在匿名函数中的用法，
 *  use用在匿名函数中可以达到在函数外部使用函数内部变量的效果，改变变量的作用域。
 */
function test() {
    $ab = 'world';
    $func = function ($param)use($ab) {
        echo $param .$ab;
    };
    $ab = 'php';
    return $func;
}
$b = test();
$b('hello ');//结果是hellohello
echo "</br>";

function index() {
    $a = 1;
    
    return function () use(&$a){
        echo $a;
        $a++;
    };
}

$a = index();
$a();
$a();
$a();
$a();
$a();