<?php
/**
 * Created by PhpStorm.
 * User: zhangshengji
 * Date: 2019/2/25
 * Time: 22:44
 */

$serv = new Swoole\Server('0.0.0.0', 9502);
$serv->set([
    'worker_num' => 2,
    'heartbeat_idle_time' => 10,
    'heartbeat_check_interval' => 3,
]);

$serv->on('connect', function (swoole_server $server, int $fd, int $reactorId) {
    echo 'client:'.$fd.' connected.'.PHP_EOL;
});

$serv->on('receive', function (swoole_server $server, int $fd, int $reactor_id, string $data) {
    echo 'receive data:'.$data.' from client_id:'.$fd.PHP_EOL;
    $server->send($fd, str_repeat('helloworld', 10));
});

$serv->on('close', function (swoole_server $server, int $fd, int $reactor_id) {
    echo 'client:'.$fd.' closed.'.PHP_EOL;
});

$serv->start();

