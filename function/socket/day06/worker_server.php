<?php

require_once '../day03/HTTP.php';

/**
 * master-worker模式（多进程监听同一端口）
 * 1. 增加进程信号控制
 *      要用到pcntl、posix进程管理扩展
 * 2. 热重启
 *      文件发生变化--》重启worker进程
 *          - worker进程重启应该在进程执行完请求后重启
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

    protected $pidList = [];

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
        $this->fork();
    }

    private function fork($num=1)
    {
        for ($i = 1; $i <= $num; $i++) {
            $pid = pcntl_fork();
            if ($pid > 0) {
                $this->pidList[] = $pid;
                if ($this->onWorkerStart) {
                    call_user_func($this->onWorkerStart, $pid);
                }
            } elseif ($pid === 0) {
                $this->accept();
                exit(0);//这里的退出是否会结束进程
            } else {
                echo "进程创建错误！！！\r\n";
            }
        }
        //子进程退出监听
        for ($i = 0; $i < $num; $i++) {
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
        require_once 'index.php';
        //https://secure.php.net/manual/en/context.socket.php
        $opt = [
            'socket' => [
                'backlog' => 10240,//成功建立socket连接的等待个数
                'so_reuseport' => 1,//允许重复绑定ip:port
            ]
        ];

        $context = stream_context_create($opt);
        $this->master = stream_socket_server($this->addr, $errno, $errstr, STREAM_SERVER_BIND|STREAM_SERVER_LISTEN, $context);
        //除了使用option，还可以单独设置option
//        stream_context_set_option($context, 'socket', 'so_reuseport', 1);//选项内容和stream_context_create()一致

        //使用swoole_event_add将socket加入到事件监听后，底层会自动将该socket设置为非阻塞模式
        swoole_event_add($this->master, function ($fp) {
            //创建一个新的socket于客户端进行通信
            $clientSocket = stream_socket_accept($fp);
            if ($clientSocket && is_callable('onConnect')) {
                $pid = posix_getpid();
                call_user_func($this->onConnect, $clientSocket, $pid);
            }

            swoole_event_add($clientSocket, function ($fp) {
                $buffer = fread($fp, 65535);
                $pid = posix_getpid();
                if (empty($buffer)) {
                    if (!is_resource($fp) || feof($fp)) {
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

    }

    private function reload()
    {
        foreach ($this->pidList as $k => $pid) {
            posix_kill($pid, SIGKILL);
            unset($this->pidList[$k]);

        }
    }

    private function monitorWorkers()
    {
        pcntl_signal(SIGUSR1, [$this, 'signalHandler'], false);
        pcntl_signal_dispatch();
    }

    private function signalHandler($signo)
    {
        switch ($signo) {
            case SIGUSR1:
                $this->reload();
                echo "接收重启信息号\r\n";
                break;
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