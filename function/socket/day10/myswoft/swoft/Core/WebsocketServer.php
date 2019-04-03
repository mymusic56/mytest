<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/4/2
 * Time: 21:26
 */

namespace Swoft\Core;


use Swoft\Config;
use Swoft\Core\Event;
use Swoft\Core\HttpServer;
use Swoft\Log\Log;

class WebsocketServer extends HttpServer
{
    public function start()
    {
        Log::wirte("Websocket Server start, host: $this->host Port: $this->port");
        $this->server = new \swoole_websocket_server($this->host, $this->port);
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
        if (Config::get('ws.enable_http')) {
            $this->server->on('request', [$this, 'onRequest']);
        }
        $this->server->on('task', [$this, 'onTask']);
        $this->server->on('message', [$this, 'onMessage']);
        $this->server->on('handshake', [$this, 'onHandshake']);
        $this->server->on('open', [$this, 'onOpen']);
        $this->server->on('finish', [$this, 'onFinish']);
    }

    public function onMessage(\swoole_websocket_server $server, \swoole_websocket_frame $frame)
    {

    }

    public function onHandshake(\swoole_http_request $request, \swoole_http_response $response)
    {
        Event::trigger('ws.handler', ['server' => $this->server, 'request' => $request, 'response' => $response]);
    }

    public function onOpen(\swoole_websocket_server $server, \swoole_http_request $request)
    {

    }
}