<?php
/**
 * 匿名函数
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