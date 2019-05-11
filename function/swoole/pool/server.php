<?php
/**
 * MySQL连接池的实现
 * 如果有慢SQL会导致，连接数不够用，连接池处于等待获取状态
 *
 * 如何自动回收多余的空闲连接？
 */
$server = new swoole_http_server('0.0.0.0', 9501);
include 'pool.php';
Swoole\Runtime::enableCoroutine(true);//一键协程化
$server->set([
    'worker_num' => 1
]);

$server->on('workerStart', function () {
    /**
     * 每个worker进程中都会产生一个进程池
     */
    Pool::get_instance()->init();
});

$server->on('request', function (swoole_http_request $request, swoole_http_response $response) {
    if ($request->server['request_uri'] == '/favicon.ico') {
        $response->end("");
        return;
    }
    $retry = 0;
    $retry_times = 3;
    try {
        RETRY:
        $pool = Pool::get_instance();
        $mysql = $pool->getConnection();
        if (!$mysql) {
            $response->header("Content-Type", "text/plain;charset=utf-8");
            $response->end('mysql connect failed。');
            return;
        }
        $res = $mysql->query("select * from users where id=1");
//    $res = $mysql->query("select sleep(1)");
        $data = $res->fetchAll();
        $pool->freeConnection($mysql);
        $response->header("Content-Type", "text/plain;charset=utf-8");
        $response->end(json_encode($data));
    } catch (\Exception $e) {
        var_dump($e->getMessage());
//        var_dump($mysql->errorInfo());
        if ($retry < $retry_times) {
            $retry++;
            echo "重试第 {$retry} 次".PHP_EOL;
            Co::sleep(1);
            goto RETRY;
        }
        $response->end($e->getMessage());
    }
});

$server->start();