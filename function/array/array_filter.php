<?php

$entry = [
    0 => 'foo',
    1 => false,
    2 => -1,
    3 => null,
    4 => '',
    5 => '0',
    6 => '01',
    7 => 0,
];

var_dump(array_filter($entry));
//array(3) {
//    [0]=>
//  string(3) "foo"
//    [2]=>
//  int(-1)
//  [6]=>
//  string(2) "01"
//}


$a = array_filter($entry, function ($v) {
    //只返回值为string类型的数据
    if (is_string($v)) {
        return $v;
    }
});

var_dump($a);
//array(2) {
//    [0]=>
//  string(3) "foo"
//    [5]=>
//  string(2) "01"
//}


