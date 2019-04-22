<?php
/**
 * 通过setDefer和recv实现并发调用
 */
go(function () {
    $client = new Swoole\Coroutine\Http\Client('127.0.0.1', 9501);
    $client->setHeaders([
        'Host' => '127.0.0.1',
        "User-Agent" => 'Chrome/49.0.2587.3',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
    ] );
    $client->setDefer();
    $res = $client->get("/");

    $mysql = new Swoole\Coroutine\Mysql();
    $mysql->connect([
        'host' => '192.168.1.101',
        'port' => 3306,
        'user' => 'root',
        'password' => '123456',
        'database' => 'mytest'
    ]);
    $mysql->setDefer();
    $res_mysql1 = $mysql->query("select sleep(3)");
//    $res_mysql2 = $mysql->query("select * from users where id=1");


    $redis = new Swoole\Coroutine\Redis();
    $redis->connect('127.0.0.1', 6379);
    $redis->auth('123456');
    $redis->select(0);
    $redis->setDefer();
    $redis->get('test');

    if ($client->recv()) {
        echo $client->body;
    }

    var_dump($mysql->recv(), $redis->recv());

    $client->close();

});

var_dump('start......');