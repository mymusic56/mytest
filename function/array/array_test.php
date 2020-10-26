<?php
/**
 * DateTime: 2020/8/25 11:54
 * @author: zhangshengji
 */

$a = ['a' => 1, 'b' => null, 'c' => 0];
$res = array_key_exists('b', $a);
var_dump($res);//true
var_dump(isset($a['b']));//false
var_dump(isset($a['c']));//true

class User {
    private $a = 1;
    private $b = null;
    private $c;
}

var_dump("=============================");
var_dump(property_exists(User::class, 'b'));
$user = new User();
var_dump(isset($user->b));
var_dump(property_exists(User::class, 'c'));