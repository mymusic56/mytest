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
        $this->server->on('close', [$this, 'onClose']);
    }

    public function onMessage(\swoole_websocket_server $server, \swoole_websocket_frame $frame)
    {
        $controller = isset($frame->data['c']) ? ucfirst($frame->data['c']) : 'Echo';
        $action = isset($frame->data['a']) ? $frame->data['a'] : 'index';
        $class = "App\\Websocket\\{$controller}Controller";

        if (!class_exists($class)) {
            $server->push($frame->fd, json_encode(['status' => -1, 'msg' => '路由不存在(1)', 'result' => []], JSON_UNESCAPED_UNICODE), 1);
        }

        $obj = new $class();
        if (method_exists($obj, $action)) {
            $obj->$action($server, $frame);
        } else {
            $server->push($frame->fd, json_encode(['status' => -1, 'msg' => '路由不存在(2)', 'result' => []], JSON_UNESCAPED_UNICODE), 1);
        }
    }

    public function onHandshake(\swoole_http_request $request, \swoole_http_response $response)
    {
        //通过使用$server->connection_info($fd)获取连接信息，返回的数组中有一项为 websocket_status，根据此状态可以判断是否为WebSocket客户端。
        Event::trigger('ws.handler', ['server' => $this->server, 'request' => $request, 'response' => $response, 'redis' => $this->redis]);
    }

    public function onOpen(\swoole_websocket_server $server, \swoole_http_request $request)
    {
//        设置onHandShake回调函数后不会再触发onOpen事件，需要应用代码自行处理
        $server->push($request->fd, json_encode(['status' => 200, 'msg' => '连接成功', 'result' => []], JSON_UNESCAPED_UNICODE), 1);
    }

    public function onClose(\swoole_server $server, int $fd, int $reactorId)
    {
        Log::wirte("删除fd: $fd");
        $key = Config::get('ws.ip').":".Config::get('ws.port');
        //找到用户ID
        $user_id = $this->redis->hGet($key, $fd);
        if ($user_id) {
            //删除fd 对应的用户
            $flag = $this->redis->hDel($key, $fd);
            //删除用户 对应的主机信息
            $flag = $this->redis->hDel('user_fd', $user_id);
        }
        $server->close($fd);
    }
}