<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/4/2
 * Time: 21:26
 */

namespace Swoft;


use Swoft\Core\Event;
use Swoft\Core\HttpServer;

class WebsocketServer extends HttpServer
{
    public function start()
    {
        $this->server = new \swoole_websocket_server($this->host, $this->port);
        $this->server->set($this->config);
        $this->addEventListener();

        //收集自定义监听事件

        $this->server->start();
    }

    public function addEventListener()
    {
        $this->server->on('start', [$this, 'onStart']);
        $this->server->on('workerStart', [$this, 'onWorkerStart']);
        if ($this->config['enable_http']) {
            $this->server->on('request', [$this, 'onRequest']);
        }
        $this->server->on('task', [$this, 'onTask']);
        $this->server->on('message', [$this, 'onMessage']);
        $this->server->on('handshake', [$this, 'onHandshake']);
        $this->server->on('open', [$this, 'open']);
        $this->server->on('finish', [$this, 'onFinish']);
    }

    public function onMessage(\swoole_websocket_server $server, \swoole_websocket_frame $frame)
    {

    }

    public function onHandshake(\swoole_http_request $request, \swoole_http_response $response)
    {
        Event::trigger('ws.handler', ['server' => $this->server, 'request' => $request, 'response' => $response]);
    }
}