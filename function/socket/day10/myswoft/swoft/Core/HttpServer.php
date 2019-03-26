<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/3/26
 * Time: 23:49
 */

namespace Swoft;


class HttpServer
{
    public $server;
    public $config;
    public $host;
    public $port;


    public function __construct()
    {
        $this->server = new \swoole_http_server($this->host, $this->port);
        $this->server->set($this->config);
        $this->addEventListener();
    }

    public function addEventListener()
    {
        $this->server->on('workStart', [$this, 'onWorkStart']);
        $this->server->on('request', [$this, 'onRequest']);
        $this->server->on('task', [$this, 'onTask']);
        $this->server->on('finish', [$this, 'onFinish']);
    }

    public function onWorkstart()
    {
        echo "Server start...\r\n";
        //加载配置

        //注册路由
    }

    public function onRequest(){
        //解析路由

        //分发
    }
    public function onTask(){}
    public function onFinish(){}
}