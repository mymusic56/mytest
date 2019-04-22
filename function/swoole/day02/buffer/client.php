<?php
/**
 * Created by PhpStorm.
 * User: zhangshengji
 * Date: 2019/2/26
 * Time: 21:34
 */

$client = new swoole_client(SWOOLE_SOCK_TCP);
$client->set([
    'open_length_check'=>1,
    'package_length_type'=>'N',//设置包头的长度
    'package_length_offset'=>0, //包长度从哪里开始计算
    'package_body_offset'=>4,  //包体从第几个字节开始计算
    'package_max_length'=>1024 * 1024 * 2,
    'socket_buffer_size' => 1024 * 1024 * 2,
]);

$client->connect('127.0.0.1', 9502);//Fatal error: Swoole\Client::connect(): no 'onConnect' callback function.
$data = str_repeat('a', 1024*1024*2-4);
//$data = str_repeat('a', 10);
$data = pack('N', strlen($data)).$data;
//$client->sendto('127.0.0.1', 9502, $data);//Swoole\Client::sendto(): only supports SWOOLE_SOCK_UDP or SWOOLE_SOCK_UDP6, 4.0.4
var_dump(strlen($data));
$client->send($data);
//$data = $client->recv();
//$data = $client->recv();
$data = $client->recv();
//var_dump(strlen($data));
//$client->close();
