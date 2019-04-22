<?php
/**
 * Server和Http\Server将为每一个请求创建对应的协程，
 * 开发者可以在onRequet、onReceive、onConnect 事件回调中使用协程客户端
 * 使用协程后onConnect、onReceive、onClose是在不同的协程中并发执行的，需要注意进行状态检测
 */
$http = new Swoole\Http\Server("0.0.0.0", 9501);
$http->set([
    'worker_num' => 1,
]);

$http->on("request", function (swoole_http_request $request, swoole_http_response $response) {
    if ($request->server['request_uri'] == '/favicon.ico') {
        $response->end('');
        return;
    }
    Co::sleep(5);
    $ret = '你好';
    $response->header("Content-Type", "text/plain;charset=utf-8");
    defer(function () {

    });
    $response->end($ret.', 进程ID：'.posix_getpid().', 协程ID:'.Co::getuid());
});

$http->start();