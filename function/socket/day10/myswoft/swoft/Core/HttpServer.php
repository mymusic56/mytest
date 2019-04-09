<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/3/26
 * Time: 23:49
 */

namespace Swoft\Core;


use Swoft\Config;
use Swoft\Log\Log;
use Swoft\Reload\FileMd5;
use Swoft\Route;

class HttpServer
{
    /**
     * @var $server \Swoole\Http\Server
     */
    protected $server;
    protected $config;
    protected $host;
    protected $port;

    protected $redis;


    public function __construct($host, $port, $config=null)
    {
        $this->host = $host;
        $this->port = $port;
        if ($config) {
            $this->config = $config;
        }
    }

    public function start()
    {
        $this->server = new \swoole_http_server($this->host, $this->port);
        $this->server->set($this->config);
        $this->addEventListener();

        //收集自定义监听事件
        Event::collectEvent();

        $this->server->start();
    }

    public function addEventListener()
    {
        $this->server->on('start', [$this, 'onStart']);
        $this->server->on('workerStart', [$this, 'onWorkerStart']);
        $this->server->on('request', [$this, 'onRequest']);
        $this->server->on('task', [$this, 'onTask']);
        $this->server->on('finish', [$this, 'onFinish']);
    }

    public function onStart()
    {
        Log::wirte("Http Server start, host: $this->host Port: $this->port");
        $fileMd5 = FileMd5::getInstance();
        $fileMd5->watchDir = [APP_PATH, SWOFT_PATH];
        $fileMd5->reload();

        //热加载代码
        swoole_timer_tick(3000, function () use ($fileMd5) {
            if ($fileMd5->reload()) {
                $this->server->reload();
            }
        });

        Event::trigger('serverstart', ['server' => $this->server]);
    }

    public function onWorkerStart()
    {
        //加载项目配置
        Config::load(APP_PATH.DS.'Config');

        $this->redis = new \Redis();
        $this->redis->connect(Config::get('redis.host'), Config::get('redis.port'));
        $this->redis->auth(Config::get('redis.password'));

        //加载路由
        include_once APP_PATH.DS.'route.php';
    }

    public function onRequest(\Swoole\Http\Request $request, \Swoole\Http\Response $response){
        //解析分发
        try {
            $result = Route::getInstance()->dispatch($request, $response);
            $response->header('Content-Type', 'application/json; charset=utf-8');
            $response->header('Content-Type', 'text/html; charset=utf-8');
            echo $result."\r\n";
            $response->end($result);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            $response->header('Content-Type', 'text/html; charset=utf-8');
            $response->end($e->getMessage());
        }
        //分发
    }
    public function onTask(\swoole_server $serv, int $task_id, int $src_worker_id, $data)
    {
        Log::wirte("Tasker进程接收到数据：");
//        Log::wirte("#{$serv->worker_id}\tonTask: [PID={$serv->worker_pid}]: task_id=$task_id, data_len=".strlen($data).".");
//        $serv->finish($data);
        Log::wirte($data);
        $data = json_decode($data, true);
        if (isset($data['data']['task'])) {
            $class = "App\\Task\\".ucfirst($data['data']['task']);
            $obj = new $class;
            $redis = $this->redis;
            $obj->handler($serv, $task_id, $data['data'], $redis);
        } else {
            Log::wirte("未指定Task任务");
        }

    }
    public function onFinish(){}
}