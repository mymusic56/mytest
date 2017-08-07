<?php
define('ROOT', realpath('./'));
define('DS', DIRECTORY_SEPARATOR);//directory separation
define('VENDOR', ROOT.DS.'Vendor');
require ROOT.DS.'Core'.DS.'Bootstrap.php';

App::uses('A', 'Vendor');
$a = new A();
#由于使用了spl_autoload_register('App', 'load')函数， 创建对象的时候， 会自动调用App Class 中的load方法， 并
$a->test();
$a = new A();//不会去重复调用App::load方法。
