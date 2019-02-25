<?php
/**
 * Created by PhpStorm.
 * User: zhangshengji
 * Date: 2019/2/25
 * Time: 22:44
 */

$serv = new Swoole\Server('0.0.0.0', 9501);
$serv->set([
    'worker_num' => 2,
    'heartbeat_idle_time' => 10,
    'heartbeat_check_interval' => 3,
]);

$serv->on('connect', function (swoole_server $server, int $fd, int $reactorId) {
    echo 'client:'.$fd.' connected.'.PHP_EOL;
});

$serv->on('receive', function (swoole_server $server, int $fd, int $reactor_id, string $data) {
    echo 'receive data from client:'.$fd.',data:'.$data.PHP_EOL;
    $client = new Swoole\Client(SWOOLE_SOCK_TCP);
    $client->connect('127.0.0.1', 9502);
    $client->send('aaaa');
    $tmp = $client->recv();
    $server->send($fd, $tmp);
});

$serv->on('close', function (swoole_server $server, int $fd, int $reactor_id) {
    echo 'client:'.$fd.' closed.'.PHP_EOL;
});

$serv->start();