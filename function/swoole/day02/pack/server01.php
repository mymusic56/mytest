<?php
/**
 * Created by PhpStorm.
 * User: zhangshengji
 * Date: 2019/2/26
 * Time: 21:34
 */
$server = new Swoole\Server('0.0.0.0', 9501);
$server->set([
    'worker_num' => 2,
    'heartbeat_idle_time' => 10,
    'heartbeat_check_interval' => 3,
    'open_eof_check' => true,
    'package_eof' => "\r\n",//必须是双引号
//    'open_eof_split' => true,//效率最低
]);

$server->on('connect', function (swoole_server $serv, int $fd) {
    echo "新的连接：{$fd}".PHP_EOL;
});

$server->on('receive', function (swoole_server $serv, int $fd, int $reactor_id, string $data) {
    $serv->send($fd,'我是服务端 ');
    echo strlen($data).'-------------'.PHP_EOL;

    $data=explode("\r\n",$data);
    foreach ($data as $v){
        echo $v.'-'.PHP_EOL;
    }
});

//消息关闭
$server->on('close',function ($serv,$fd){
    echo "客户端关闭：{$fd}".PHP_EOL;
});
//服务器开启
$server->start();