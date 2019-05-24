<?php
/**
 * Created by PhpStorm.
 * User: zhangshengji
 * Date: 2019/2/14
 * Time: 22:08
 */

function __autoload($class)
{
    include ucfirst($class).'.php';
}

$user = new User('zhangsan', 21, 1);
$res = $user->info1();
echo "".PHP_EOL;
$res = $user->info();

User::info2();
var_dump($res);
var_dump($user->__toString());

$user_str = serialize($user);
var_dump($user_str);
$user = unserialize($user_str);
echo $user->name;