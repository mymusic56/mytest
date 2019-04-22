<?php
$id = Co::create(function () {
    /* @var $db \Swoole\Coroutine\Mysql */
    $db = new Co\MySQL();
    $db->connect([
        'host' => '192.168.1.101',
        'port' => 3306,
        'user' => 'root',
        'password' => '123456',
        'database' => 'mytest'
    ]);
    $res = $db->query("select * from users where address='重庆市区'");
    var_dump($res);
});

var_dump($id);