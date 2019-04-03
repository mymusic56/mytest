<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/4/4
 * Time: 0:22
 */

namespace Swoft\Websocket;


interface WebsockerController
{
    public function index(\swoole_websocket_server $server, \swoole_websocket_frame $frame);
}