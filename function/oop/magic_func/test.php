<?php
/**
 * Created by PhpStorm.
 * User: zhangshengji
 * Date: 2019/2/14
 * Time: 22:08
 */
function __autoload($class)
{
    var_dump("1. __autoload()");
    include ucfirst($class).'.php';
}

function register($class)
{
    var_dump("0. register()");
    $file = ucfirst($class).'.php';
    if (file_exists($file)) {
        include $file;
    }
}
function register2($class)
{
    var_dump("0.1. register2()");
    $file = 'entity'.DIRECTORY_SEPARATOR.ucfirst($class).'.php';
    if (file_exists($file)) {
        include $file;
    }
}

spl_autoload_register('register');
//优先使用: register2
spl_autoload_register('register2', true, true);

var_dump("2. new User()");
$user = new User('zhangsan', 21, 1);
//spl_autoload_unregister('register');

$role = new Role();

var_dump("3. user()");
$user();
var_dump("4. User::info1()");
$res = $user->info1();

var_dump("5. User::getName()");
$user->getName();

var_dump("6. User::firstName");
$user->name = "李四";
$user->firstName = '李';

echo "".PHP_EOL;
$res = $user->info();

var_dump("7. User::info2()");
User::info2();

var_dump("8. User::__toString()");
var_dump($user->__toString());

var_dump("9. 序列化");
$user_str = serialize($user);
var_dump($user_str);
var_dump("10. 反序列化");

/**
 * @var $user User
 */
$user = unserialize($user_str);
var_dump("10. 反序列化结果： ".$user->gender);