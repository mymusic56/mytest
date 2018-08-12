<?php
$client = new swoole_client(SWOOLE_SOCK_UDP);
$client->connect('127.0.0.1', 9502);

fwrite(STDOUT, "请输入要发送的内容");
$data = trim(fgets(STDIN));

if ($client->send($data)) {
    echo "发送成功\n";
}

$msg = $client->recv();

echo "服务器返回信息：".$msg."\n";

$client->close();