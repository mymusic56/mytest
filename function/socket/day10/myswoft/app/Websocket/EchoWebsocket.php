<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/3/27
 * Time: 22:49
 */

namespace App\Websocket;

use Swoft\Websocket\WebsockerController;

class EchoWebsocket implements WebsockerController
{
    public function index(\swoole_websocket_server $server, \swoole_websocket_frame $frame)
    {
        $data = ['a' => 1, 'fd' => $frame->fd];
        $server->push($frame->fd, json_encode(['status' => 1, 'msg' => 'success', 'result' => $data], JSON_UNESCAPED_UNICODE));
    }
}