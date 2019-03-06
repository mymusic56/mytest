<?php
$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if (socket_connect($sock, '127.0.0.1', 9501)) {
    $buf = str_repeat('a', 1029);
    $bytes = socket_send($sock, $buf, strlen($buf), 0);
    //socket_read(),和socket_recv()的区别？
    $data = socket_read($sock, 1024);
    var_dump($data);
    socket_close($sock);
}
