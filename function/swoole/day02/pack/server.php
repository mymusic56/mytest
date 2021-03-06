<?php
/**
 * Created by PhpStorm.
 * User: zhangshengji
 * Date: 2019/2/26
 * Time: 21:34
 */

$server = new Swoole\Server('0.0.0.0', 9502);
$server->set([
    'worker_num' => 2,
    'open_length_check' => true,//https://wiki.swoole.com/wiki/page/287.html
    'package_length_type' => 'N',//设置包头的长度， https://wiki.swoole.com/wiki/page/463.html
    'package_length_offset'=>0, //包长度从哪里开始计算
    'package_body_offset' => 4,//包体从第几个字节开始计算
    'package_max_length' => 1024*1024*2,//
    'log_file' => __DIR__.'/server.log',
]);

$server->on('connect', function (swoole_server $server, int $fd, int $reactorId) {
    echo "client {$fd} connected.";
});

$server->on('receive', function (swoole_server $server, int $fd, int $reactorId, string $data) {
    $head = unpack('N', $data);
//    var_dump($head);
//    var_dump(strlen($data));
    var_dump(strlen(substr($data, 4)));
//    var_dump(substr($data, 4));
});

$server->on('close', function (swoole_server $server, int $fd, int $reactorId) {

});

$server->start();