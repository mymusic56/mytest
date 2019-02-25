<?php
//https://github.com/swoole/swoole-src
$ws = new swoole_websocket_server('0.0.0.0', 9502);
$ws->set([
    'document_root' => dirname(__FILE__).'/webroot',
    'enable_static_handler' => true,
]);
/**
 * @var $ws swoole_websocket_server
 * @var $request \Swoole\Http\Request
 * @var $response \Swoole\Http\Response
 */
$ws->on('open', 'onOpen');
function onOpen (swoole_websocket_server $ws, $request) {
    echo "server: handshake success with fd{$request->fd}\n";
    $ws->push($request->fd, "hello, welcome\n");
}

$ws->on('message', 'onMessage');
function onMessage(swoole_websocket_server$ws, $frame) {
    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
    $ws->push($frame->fd, "server: {$frame->data} iiiiiiiiiiiiii");
}
/**
 * swoole_websocket_server 继承自 swoole_http_server
 * 设置了onRequest回调，websocket服务器也可以同时作为http服务器
 * 未设置onRequest回调，接收HTTP請求后必须要设置request回调，不然会报400
 */
$ws->on('request', function($request, $response){
    $response->header('Content-Type', 'text/html;charset=utf-8');
    $response->end('<h1>success</h1>');
});

$ws->on('close', function (swoole_websocket_server $ws, $fd) {
    echo "client-{$fd} is closed\n";
});

$ws->start();