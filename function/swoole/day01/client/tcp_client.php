<?php
$client = new swoole_client(SWOOLE_SOCK_TCP);

if (!$client->connect('127.0.0.1', 9501)) {
    echo "连接失败\n";
    exit;
}

fwrite(STDOUT, '请输入要发送的信息:');
$data = trim(fgets(STDIN));

$client->send($data);

$result = $client->recv();

if ($result === false) {
    echo '错误码:'.$client->errCode."\n";
    exit;
}

echo $result."\n";