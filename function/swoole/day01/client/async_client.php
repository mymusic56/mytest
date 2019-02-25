<?php
/**
 * Created by PhpStorm.
 * Date: 2019/2/21
 * Time: 20:59
 */
$client = new Swoole\Client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
$client->on("connect", function (swoole_client $cli) {
    $cli->send("GET / HTTP/1.1\r\n\r\n");
});
$client->on("receive", function (swoole_client $cli, $data) {
    echo "Receive: $data".PHP_EOL;
//    $cli->send(str_repeat('A', 100) . "\n");
    sleep(3);
    $cli->close();
});
$client->on("error", function (swoole_client $cli) {
    echo "error\n";
});
$client->on("close", function (swoole_client $cli) {
    echo "Connection close\n";
});

swoole_timer_tick(1000, function () use($client) {
    $t = date('Y-m-d H:i:s');
    $client->send($t);
});

echo "333\r\n";

$client->connect('127.0.0.1', 9501);

echo "4444\r\n";