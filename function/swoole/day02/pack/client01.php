<?php
/**
 * 粘包：发送时多个数据包粘成一个数据包发送，接收时多个数据包粘成一个进行接收
 * 原因：缓冲区
 * 如何处理：
 * Created by PhpStorm.
 * User: zhangshengji
 * Date: 2019/2/26
 * Time: 21:34
 */

$client = new Swoole\Client(SWOOLE_SOCK_TCP);
$client->connect('127.0.0.1', 9501);

//多次发送少量数据
for ($i=0; $i<10;$i++) {//虽然调用send 10次，但是服务器端接收到一次或者多次数据
    $client->send("{$i}\r\n");
}

/*
 * 1. 发送方一次发送大量数据，接收方可能会拆分成多个数据包进行接收
 * 2. 接收多个数据包个数，被合并在一起了，通过recv()一次调用获取，也就是 “粘包问题”
 */
//$data = str_repeat('a', 12*1024*1024);
//$client->send($data);

$result = $client->recv();
if ($result === false) {
    echo $client->errCode.PHP_EOL;
}
echo $result.'-'.PHP_EOL;
//$client->close();
