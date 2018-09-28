<?php
define('MYNAMESPACE', dirname(__FILE__).DIRECTORY_SEPARATOR);
require MYNAMESPACE.'Think/Think.php';
//注册相关自动加载 停止
Think\Think::start();

//测试类自动加载
Think\Think::testAutoLoad();

//测试静态方法调用
Think\Think::testCallSatic();
