<?php

/**
 * IO多路复用 -》 http服务器
 * http://www.php.cn/php-weizijiaocheng-392398.html
 * 
 */

$servsock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); // 创建一个socket

if (FALSE === $servsock) {
    $errcode = socket_last_error();
    fwrite(STDERR, "socket create fail: " . socket_strerror($errcode));
    exit(- 1);
}

if (! socket_bind($servsock, '192.168.88.131', 8080)) // 绑定ip地址及端口
{
    $errcode = socket_last_error();
    fwrite(STDERR, "socket bind fail: " . socket_strerror($errcode));
    exit(- 1);
}

if (! socket_listen($servsock, 128)) // 允许多少个客户端来排队连接
{
    $errcode = socket_last_error();
    fwrite(STDERR, "socket listen fail: " . socket_strerror($errcode));
    exit(- 1);
}

/* 要监听的三个sockets数组 */
$read_socks = array();
$write_socks = array();
$except_socks = NULL; // 注意 php 不支持直接将NULL作为引用传参，所以这里定义一个变量

$read_socks[] = $servsock;

while (1) {
    /* 这两个数组会被改变，所以用两个临时变量 */
    $tmp_reads = $read_socks;
    $tmp_writes = $write_socks;
    
    // int socket_select ( array &$read , array &$write , array &$except , int $tv_sec [, int $tv_usec = 0 ] )
    //获取$tmp_reads数组中状态发生改变的socket，并删除没有状态没有发生改变的socket
    $count = socket_select($tmp_reads, $tmp_writes, $except_socks, NULL); // timeout 传 NULL 会一直阻塞直到有结果返回
    
    foreach ($tmp_reads as $read) {
        
        if ($read == $servsock) {
            /* 有新的客户端连接请求 */
            $connsock = socket_accept($servsock); // 响应客户端连接， 此时不会造成阻塞
            if ($connsock) {
                socket_getpeername($connsock, $addr, $port); // 获取远程客户端ip地址和端口
                echo "client connect server: ip = $addr, port = $port" . PHP_EOL;
                
                // 把新的连接sokcet加入监听
                $read_socks[] = $connsock;
                $write_socks[] = $connsock;
            }
        } else {
            /* 客户端传输数据 */
            $data = socket_read($read, 1024); // 从客户端读取数据, 此时一定会读到数组而不会产生阻塞
            
            if ($data === '') {
                // 移除对该 socket 监听
                foreach ($read_socks as $key => $val) {
                    if ($val == $read)
                        unset($read_socks[$key]);
                }
                
                foreach ($write_socks as $key => $val) {
                    if ($val == $read)
                        unset($write_socks[$key]);
                }
                
                socket_close($read);
                echo "client close" . PHP_EOL;
            } else {
                socket_getpeername($read, $addr, $port); // 获取远程客户端ip地址和端口
                
                #---------------------------
                echo "read from client # $addr:$port # " . $data;
                $response = "HTTP/1.1 200 OK\r\n";
                $response .= "Server: phphttpserver\r\n";
                $response .= "Content-Type: text/html\r\n";
                $response .= "Content-Length: 3\r\n\r\n";
                $response .= "ok\n";
                if (in_array($read, $tmp_writes))
                {
                    //如果该客户端可写 把数据回写给客户端
                    socket_write($read, $response);
                    socket_close($read);  // 主动关闭客户端连接
                    //移除对该 socket 监听
                    foreach ($read_socks as $key => $val)
                    {
                        if ($val == $read) unset($read_socks[$key]);
                    }
                    
                    foreach ($write_socks as $key => $val)
                    {
                        if ($val == $read) unset($write_socks[$key]);
                    }
                }
                
            }
        }
    }
}

socket_close($servsock);

/**
 * 
E:\wamp64\bin\apache\apache2.4.27\bin>ab -c 100 -n 1000 "http://192.168.88.131:8080/"
This is ApacheBench, Version 2.3 <$Revision: 1796539 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking 192.168.88.131 (be patient)
Completed 100 requests
Completed 200 requests
Completed 300 requests
Completed 400 requests
Completed 500 requests
Completed 600 requests
Completed 700 requests
Completed 800 requests
Completed 900 requests
Completed 1000 requests
Finished 1000 requests


Server Software:        phphttpserver
Server Hostname:        192.168.88.131
Server Port:            8080

Document Path:          /
Document Length:        3 bytes

Concurrency Level:      100
Time taken for tests:   0.911 seconds
Complete requests:      1000
Failed requests:        0
Total transferred:      89000 bytes
HTML transferred:       3000 bytes
Requests per second:    1097.09 [#/sec] (mean)
Time per request:       91.150 [ms] (mean)
Time per request:       0.911 [ms] (mean, across all concurrent requests)
Transfer rate:          95.35 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    1   0.5      1       4
Processing:     3   82  13.7     85      93
Waiting:        2   45  24.1     46      90
Total:          4   83  13.7     86      93

Percentage of the requests served within a certain time (ms)
  50%     86
  66%     87
  75%     88
  80%     89
  90%     90
  95%     91
  98%     92
  99%     93
 100%     93 (longest request)

E:\wamp64\bin\apache\apache2.4.27\bin>
 */
