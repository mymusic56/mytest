<?php

require_once '../day03/HTTP.php';

/**
 * epoll(swoole_event_add事件)实现非阻塞模式
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
        $local_socket = "tcp://{$this->addr}:{$this->port}";
        $this->master = stream_socket_server($local_socket);
        $this->fork();
    }

    private function fork()
    {
        $this->accept();
    }

    private function accept()
    {
        //使用swoole_event_add将socket加入到事件监听后，底层会自动将该socket设置为非阻塞模式
        swoole_event_add($this->master, function ($fp) {
            //创建一个新的socket于客户端进行通信
            $clientSocket = stream_socket_accept($fp);//等待超时警告怎么解决？？？
            $pid = posix_getpid();
            if ($clientSocket && is_callable('onConnect')) {
                call_user_func($this->onConnect, $clientSocket, $pid);
            }

            swoole_event_add($clientSocket, function ($fp) {
                $buffer = fread($fp, 65535);
                $pid = posix_getpid();
                if (empty($buffer)) {
                    if (!is_resource($fp) || !feof($fp)) {
                        fclose($fp);
                    }
                } else {
//                    echo $buffer."\r\n";
                    call_user_func($this->onReceive, $this, $fp, $pid, $buffer);
                    swoole_event_del($fp);
                    call_user_func($this->onClose, $this, $fp);
                    fclose($fp);
                }

            });
        });

        echo "异步非阻塞\r\n";
    }

    public function send($sock, $message)
    {
        $data = HTTP::encode($message);
        echo "client ".$sock." connected\r\n";
        fwrite($sock, $data, strlen($data));
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
//    echo "sock ".$sock.",处理进程:{$pid}, 接收信息：\r\n\r\n";
    $data = date('Y-m-d H:i:s');
    $server->send($sock, $data);
};

$server->onClose = function (Server $server, $sock) {
    echo "sock {$sock} close\r\n";
};


$server->start();