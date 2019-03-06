<?php
$master = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_bind($master, '0.0.0.0', 9501);
socket_listen($master);
//创建一个新的socket于客户端进行通信
while (($sock = socket_accept($master)) !== false) {
    $bytes = socket_recv($sock, $buf, 1024, 0);
    # flag怎么选择？？？
//    MSG_OOB;
//    MSG_PEEK;
//    MSG_WAITALL;
//    MSG_DONTWAIT;

    if ($bytes === false) {
        echo "socket_recv(): error";
        echo '<pre>';
        $errNo = socket_last_error();
        echo '<pre>';
        echo socket_strerror($errNo);
        die;
    }

    //var_dump($buf);

    $header = "HTTP/1.1 200 OK\r\n";
    $header .= "Content-Type: text/html;charset=utf-8\r\n";
    $header .= "Connection: Keep-Alive\r\n";
    $header .= "Server: MyServer\r\n\r\n";
    $data = $header."123456";

    echo "client ".$sock." connected\r\n";
    socket_write($sock, $data, strlen($data));
//    socket_send($sock, $data, strlen($data), 0);
    socket_close($sock);
}

