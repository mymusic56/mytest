<?php

require_once 'HTTP.php';

/**
 * I/O复用： select单进程非阻塞模式
 * Class Server
 */
class Server
{
    private $master;
    private $addr;
    private $port;

    public $onReceive = null;

    public $onConnect = null;

    public $onClose = null;

    public $onWorkerStart = null;

    private $config = [];
    
    private $listenSockets = [];

    public function __construct($addr='0.0.0.0', $port=9501)
    {
        $this->addr = $addr;
        $this->port = $port;
    }

    public function set(array $config)
    {
        $this->config = $config;
    }

    public function start()
    {
        $this->master = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        //设置端口重用， 可以服用还处于TIME_WAIT的端口， socket_stream_create()可以通过添加socket_context_create()上下文实现。
        socket_set_option($this->master, SOL_SOCKET, SO_REUSEADDR, 1);

        socket_bind($this->master, $this->addr, $this->port);
        socket_listen($this->master);
        
        socket_set_nonblock($this->master);//设置非阻塞
        $this->listenSockets[(int)$this->master] = $this->master;
        
		
        //$local_socket = "tcp://{$this->addr}:{$this->port}";
        //$this->master = stream_socket_server($local_socket);
		//stream_set_blocking($this->master, 0);
        //创建一个新的socket于客户端进行通信
        $this->fork();
    }

    private function fork()
    {
        $this->accept();
    }

    private function accept()
    {
        while (true) {
            $read = $this->listenSockets;
        
            socket_select($read, $write, $exception, 60);
            
            foreach($read as $index => $sock){
                $pid = posix_getpid();
                if ($sock == $this->master) {
                    //服务端socket
                    $clientSocket = socket_accept($this->master);
                    $this->listenSockets[(int)$clientSocket] = $clientSocket;
                    if (!empty($clientSocket) && is_callable($this->onConnect)) {
                        call_user_func($this->onConnect, $clientSocket, $pid);
                    };
                    continue;
                } else {
                    if (empty($sock) || !is_resource($sock)) {
                        //取消监听
                        $this->deleteSock($index);
                        continue;
                    }
                    
                    //读取数据
                    //feof为什么提示 supplied resource is not a valid stream resource
                    //feof 需要使用stream_socket
                    $bytes = socket_recv($sock, $buf, 1024, 0);
					
                    if (empty($bytes) /* || feof($sock) */) {//没有数据，关闭连接
                        
                        if (is_callable($this->onClose)) {
                            call_user_func($this->onClose, $this, $sock);
                        }
                        $this->deleteSock($index);
                        continue;
                    }
                    
                    if (is_callable($this->onReceive)) {
                        call_user_func($this->onReceive, $this, $sock, $pid, $bytes);
                    }
                    
                    //关闭连接
                    if (is_callable($this->onClose)) {
                        call_user_func($this->onClose, $this, $sock);
                    }
                    $this->deleteSock($index);
                    socket_close($sock);
                }
            }
        }
    }
    
    private function deleteSock($index){
        unset($this->listenSockets[$index]);
    }

    public function send($sock, $message)
    {
        $data = HTTP::encode($message);
        echo "client ".$sock." connected\r\n";
        socket_write($sock, $data, strlen($data));
//        socket_send($sock, $data, strlen($data), 0);
    }

    private function outPutError($sock)
    {
        echo "socket_recv(): error";
        echo '<pre>';
        $errNo = socket_last_error();
        echo '<pre>';
        echo socket_strerror($errNo);
        $this->send($sock, socket_strerror($errNo).' 错误码:'.$errNo);
    }
}

$server = new Server();
$server->set([
    'worker_num' => 2
]);

$server->onWorkerStart = function ($pid) {
    echo "进程ID ".$pid."启动\r\n";
};

$server->onConnect = function ($sock, $pid) {
    echo "sock ".$sock."连接,处理进程:{$pid}, \r\n";
};

$server->onReceive = function (Server $server, $sock, $pid, $message) {
    echo "sock ".$sock.",处理进程:{$pid}, 接收信息：\r\n\r\n";
    $data = date('Y-m-d H:i:s');
    $server->send($sock, $data);
};

$server->onClose = function (Server $server, $sock) {
    echo "sock {$sock} close\r\n";
};


$server->start();