<?php
$a['a'] = ['name' => 'zhangsan'];
$b = ['age' => '10'];
$c = ['name' => '10'];
$a['a'] += $b;
$a['a'] += $c;

var_dump($a);
//array(1) {
//    ["a"]=>
//  array(2) {
//        ["name"]=>
//    string(8) "zhangsan"
//        ["age"]=>
//    string(2) "10"
//  }
//}
