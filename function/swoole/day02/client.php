<?php

$client = new Swoole\Client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
$client->on("connect", function (swoole_client $cli) {
    $cli->send("GET / HTTP/1.1\r\n\r\n");
});
$client->on('receive', function (swoole_client $cli, $data) {
    echo $data.PHP_EOL;
    $cli->close();
});
$client->on("error", function (swoole_client $cli) {
    echo "error\n";
});
$client->on("close", function (swoole_client $cli) {
    echo "Connection close\n";
});
$client->connect('127.0.0.1', 9501);
