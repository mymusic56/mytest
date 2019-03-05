<?php
/**
 * Created by PhpStorm.
 * User: zhangshengji
 * Date: 2019/2/26
 * Time: 21:34
 */

$client = new swoole_client(SWOOLE_SOCK_TCP);
//$client->on('receive', function (swoole_client $cli, string $data) {
//    echo $data;
//});
//
//$client->on("error", function (swoole_client $cli) {
//    echo "error\n";
//});
//$client->on("close", function (swoole_client $cli) {
//    echo "Connection close\n";
//});

$client->connect('127.0.0.1', 9502);//Fatal error: Swoole\Client::connect(): no 'onConnect' callback function.
$data = str_repeat('a', 1024*1024*3);
//$data = str_repeat('a', 10);

#一次发送大量数量
$data = pack('N', strlen($data)).$data;
$client->send($data);
#多次发送少了数据
//for ($i = 1; $i < 10; $i++) {
//    $data = str_repeat($i, 10);
//    var_dump($data);
//    $data = pack('N', strlen($data)).$data;
//    $client->send($data);
//}

//$client->sendto('127.0.0.1', 9502, $data);//Swoole\Client::sendto(): only supports SWOOLE_SOCK_UDP or SWOOLE_SOCK_UDP6, 4.0.4
//var_dump($data);
$client->close();
