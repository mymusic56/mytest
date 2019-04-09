<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/3/27
 * Time: 22:49
 */

namespace App\Websocket;

use Swoft\Log\Log;
use Swoft\Websocket\WebsockerController;

class SendmsgWebsocket implements WebsockerController
{
    public function index(\swoole_websocket_server $server, \swoole_websocket_frame $frame)
    {
        $data = json_decode($frame->data, true);
        if ($data && $data['data']) {
            if ($data['data']['send_type'] == 'group') {
                Log::wirte('收到Route的群发消息通知，投递任务到task');
                $data['data']['task'] = 'sendmsgTask';
                $server->task(json_encode($data));
            }
        }


//        $server->push($frame->fd, json_encode(['status' => 1, 'msg' => 'success', 'result' => $data], JSON_UNESCAPED_UNICODE));
    }
}