<?php

require_once 'HTTP.php';

/**
 * stream_socket_server
 * 超时问题怎么解决(select、epoll解决)
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

    private $config = ['worker_num' => 1];

    public function __construct($addr='0.0.0.0', $port=9501)
    {
        $this->addr = "tcp://{$addr}:{$port}";
        $this->port = $port;
    }

    public function set(array $config)
    {
        $this->config = $config;
    }

    public function start()
    {
        $this->master = stream_socket_server($this->addr);
        $this->fork();
    }

    private function fork()
    {
        $counts = $this->config['worker_num'];
        for ($i = 1; $i <= $counts; $i++) {
            $pid = pcntl_fork();
            if ($pid > 0) {

            } elseif ($pid === 0) {
                $pid = posix_getpid();
                if ($this->onWorkerStart) {
                    call_user_func($this->onWorkerStart, $pid);
                }
                $this->accept();
            } else {
                echo "进程创建错误！！！\r\n";
            }
        }

        //子进程退出监听
        for ($i = 0; $i < $this->config['worker_num']; $i++) {
            $pid = pcntl_wait($status);
            if ($pid > 0) {
                echo "子进程{$pid}退出,status:".$status."\r\n";
            } elseif ($pid == -1) {
                echo "进程返回error， status: {$status}\r\n";
            } elseif ($pid == 0) {
            }
        }
        echo "子进程全部退出\r\n";
    }

    private function accept()
    {
        while (true) {
            $clientSocket = stream_socket_accept($this->master);
            $pid = posix_getpid();
            if ($clientSocket) {
                call_user_func($this->onConnect, $clientSocket, $pid);
                $buffer = fread($clientSocket, 65535);
                if ($buffer) {
                    call_user_func($this->onReceive, $this, $clientSocket, $pid, $buffer);
                }
                fclose($clientSocket);
            }
        }

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
    'worker_num' => 4
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