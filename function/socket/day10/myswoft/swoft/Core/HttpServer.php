<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/3/26
 * Time: 23:49
 */

namespace Swoft\Core;


use Swoft\Config;
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
        echo "Server start...\r\n";
        $fileMd5 = FileMd5::getInstance();
        $fileMd5->watchDir = [APP_PATH, SWOFT_PATH];
        $fileMd5->reload();

        //热加载代码
        swoole_timer_tick(3000, function () use ($fileMd5) {
            if ($fileMd5->reload()) {
                $this->server->reload();
            }
        });
    }

    public function onWorkerStart()
    {
        //加载项目配置
        Config::load(APP_PATH.DS.'Config');

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
    public function onTask(){}
    public function onFinish(){}
}