<?php

require_once 'HTTP.php';

/**
 * 多进程阻塞模型
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
        $this->master = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_bind($this->master, $this->addr, $this->port);
        socket_listen($this->master);

//        $local_socket = "tcp://{$this->addr}:{$this->port}";
//        $this->master = stream_socket_server($local_socket);

        //创建一个新的socket于客户端进行通信
        $this->fork();
    }

    private function fork()
    {
        $count = isset($this->config['worker_num']) ? $this->config['worker_num'] : 1;
        for ($i=1; $i<=$count; $i++) {
            $pid = pcntl_fork();
            if ($pid) {

                if ($this->onWorkerStart) {
                    call_user_func($this->onWorkerStart, $pid);
                }
            } elseif ($pid==0){
                $this->accept();
            } else {
                throw new Exception("进程初始化错误！");
            }
        }

        while (($pid = pcntl_wait($status)) > 0) {
            echo "子进程{$pid}退出,status:".$status."\r\n";
        }

        echo "子进程全部退出\r\n";
    }

    private function accept()
    {
        while (($sock = socket_accept($this->master)) !== false) {
            $pid = posix_getpid();
            call_user_func($this->onConnect, $sock, $pid);

            $bytes = socket_recv($sock, $buf, 1024, 0);

            if ($bytes === false) {
                $this->outPutError($sock);
            }
            call_user_func($this->onReceive, $this, $sock, $pid, $buf);

            socket_close($sock);
        }
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

$server->onClose = function () {

};


$server->start();