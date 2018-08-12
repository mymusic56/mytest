<?php

/**
 * 1.如何平滑重启？
 * 2.完成UDP客户端
 * 
 */


//创建Server对象，监听 127.0.0.1:9501端口
$serv = new swoole_server("0.0.0.0", 9501); 
//设置参数，可设置的参数查询 配置选项

/**
 * 查看实际启动的工作进程
 * ps aft|grep tcp.php
 * 
 * [root@localhost-129 client]# ps aft |grep tcp.php
  1405 pts/1    S+     0:00  \_ grep --color=auto tcp.php
  1354 pts/0    Sl+    0:00  \_ php tcp.php
  1355 pts/0    S+     0:00      \_ php tcp.php
  1358 pts/0    S+     0:00          \_ php tcp.php
  1359 pts/0    S+     0:00          \_ php tcp.php
 */
$serv->set([
    'worker_num' => 2
]);

//监听连接进入事件
//参考事件回调函数
/**
 * $serv
 * $fd 连接的文件描述符，发送数据/关闭连接时需要此参数
 * $from_id 来自哪个Reactor线程
 */
$serv->on('connect', function ($serv, $fd, $from_id) {  
    echo "Client: Connect {$fd}, ThreadId: {$from_id}.\n";
});

//监听数据接收事件
/**
 * $fd，TCP客户端连接的唯一标识符
 * $from_id，TCP连接所在的Reactor线程ID
 * $data，收到的数据内容，可能是文本或者二进制内容
 */
$serv->on('receive', function ($serv, $fd, $from_id, $data) {
    $serv->send($fd, "Server:-------  {$fd}, ThreadId: {$from_id} ".$data);
});

//监听连接关闭事件
/**
 * 1. swoole-1.9.7版本修改了$reactorId参数，当服务器主动关闭连接时，底层会设置此参数为-1，
 * 可以通过判断$from_id < 0来分辨关闭是由服务器端还是客户端发起的。
 * 2. onClose回调函数如果发生了致命错误，会导致连接泄漏。通过netstat命令会看到大量TIME_WAIT状态的TCP连接
 */
$serv->on('close', function ($serv, $fd, $from_id) {
    echo "Client: Close {$fd}, ThreadId: {$from_id} .\n";
});

//启动服务器
$serv->start(); 
