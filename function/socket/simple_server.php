<?php
class Ws{
    
    //连接server的客户端
    private $master = null;
    
    //所有的socket
    private $sockets = [];
    
    //是否握手
    private $handShake = false;
    
    public function __construct($host, $port)
    {
        //创建套接字
        $this->master = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die('socket_create() failed.');
        socket_setopt($this->master, SOL_SOCKET, SO_REUSEADDR, 1) or die("socket_setopt() failed");
        
        socket_bind($this->master, $host, $port);
        
        socket_listen($this->master);
        
        $this->sockets[] = $this->master;
        
        for ( ; ; ) {
            // 自动选择来消息的 socket 如果是握手 自动选择主机
            $write = NULL;
            $except = NULL;
            if (socket_select($this->sockets, $write, $except, NULL) < 1) {
                continue;
            };
            
            foreach ($this->sockets as $sock) {
                
            }
            
            
            
            $conn = socket_accept($sock);
            
            
            $write_buffer = "HTTP/1.0 200 OK\r\nServer: my_server\r\nContent-Type: text/html; charset=utf-8\r\n\r\nhello!world";
            
            socket_write($conn, $write_buffer);
            
            socket_close($conn);
        }
    }
}