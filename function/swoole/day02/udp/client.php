<?php
/**
 * Created by PhpStorm.
 * User: zhangshengji
 * Date: 2019/2/26
 * Time: 22:56
 */
$client=new swoole\Client(SWOOLE_SOCK_UDP);
//（fd+id）识别身份
//发数据
$client->sendto('127.0.0.1',9502,"我是客户端");

$result = $client->recv(); //接收消息没有接收

echo $result;
