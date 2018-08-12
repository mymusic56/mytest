<?php
//创建UDP server
$serv = new swoole_server('0.0.0.0', 9502, SWOOLE_PROCESS, SWOOLE_SOCK_UDP);

$serv->on('connect', function ($serv, $fd, $from_id) {
    echo "Client: Connect {$fd}, ThreadId: {$from_id}.\n";
});

$serv->on('receive', function ($serv, $fd, $from_id, $data) {
    $serv->send($fd, "Server:  {$fd}, ThreadId: {$from_id} ".$data."\n");
});

$serv->on('close', function ($serv, $fd, $from_id) {
    echo "Client: Close {$fd}, ThreadId: {$from_id} .\n";
});

$argv = $_SERVER['argv'];
$action = isset($argv[1]) ? $argv[1] : '';

switch ($action) {
    case 'start' : $serv->start();break;
    case 'stop' : $serv->stop();break;
    case 'reload' : $serv->reload(true);break;
    case 'close' : $serv->close();break;
    case 'shutdown' : $serv->shutdown();break;
    default : echo "Usage: {start|stop|reload|close|shutdown} \n";break;
}

/**
 * 总结：
 * 1. UDP server不关心客户端状态： 
 *    服务器端监听close事件失效，没有打印出监听客户端关闭的信息：
 * 2. 服务器端可以给客户端返回数据，客户端也能够接收数据
       [root@localhost-129 client]# php udp_client.php 
                请输入要发送的内容rrrrrrrrr
                发送成功
                服务器返回信息：Server:  16777343, ThreadId: 241903 rrrrrrrrr
    3. 接收信息时，文件描述符和工作线程ID明显和tcp server 有很大区别，这是什么原因？
 */