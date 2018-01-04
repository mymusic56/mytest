<?php
$sock = stream_socket_server("tcp://127.0.0.1:8080", $errno, $errstr);

for ( ; ; ) {
    $conn = stream_socket_accept($sock);
    
    $write_buffer = "HTTP/1.0 200 OK\r\nServer: my_server\r\nContent-Type: text/html; charset=utf-8\r\n\r\nhello!world";
    
    fwrite($conn, $write_buffer);
    
    fclose($conn);
}