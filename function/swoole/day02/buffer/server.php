<?php
/**
 * Created by PhpStorm.
 * User: zhangshengji
 * Date: 2019/2/26
 * Time: 21:34
 */

$server = new Swoole\Server('0.0.0.0', 9502);
$server->set([
    'open_length_check' => true,
    'package_length_type' => 'N',
    'package_max_length' => 1024*1024*2,
    'package_body_offset' => 4,
    'buffer_output_size' => 1024*1024*2,
]);

$server->on('connect', function (swoole_server $server, int $fd, int $reactorId) {
    echo "client {$fd} connected.";
});

$server->on('receive', function (swoole_server $server, int $fd, int $reactorId, string $data) {
    $head = unpack('N', $data);
    var_dump($head);
    var_dump(strlen($data));
    var_dump(strlen(substr($data, 4)));
    $server->send($fd, $data);
    $server->send($fd, $data);
    $server->send($fd, $data);
//    $server->close($fd);
});

$server->on('close', function (swoole_server $server, int $fd, int $reactorId) {

});

$server->start();