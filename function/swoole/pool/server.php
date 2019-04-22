<?php
/**
 * MySQL连接池的实现
 * 如果有慢SQL会导致，连接数不够用，连接池处于等待获取状态
 */
$server = new swoole_http_server('0.0.0.0', 9501);
include 'pool.php';
Swoole\Runtime::enableCoroutine(true);
$server->set([
    'worker_num' => 1
]);

$server->on('workerStart', function () {
    /**
     * 每个worker进程中都会产生一个进程池
     */
    Pool::get_instance()->init();
});

$server->on('request', function ($request, $response) {
    $pool = Pool::get_instance();
    $mysql = $pool->getConnection();
    $res = $mysql->query("select * from users where id=1");
    $data = $res->fetchAll();
    $pool->freeConnection($mysql);
    $response->header("Content-Type", "text/plain;charset=utf-8");
    $response->end(json_encode($data));
});

$server->start();