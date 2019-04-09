<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/4/9
 * Time: 11:00
 */

namespace App\Listener;


use Swoft\Config;
use Swoft\Event\EventInterface;
use Swoft\Log\Log;
use Swoole\Http\Client;

/**
 * 用户上线业务逻辑
 * Class OnlineListener
 * @package App\Listener
 * @Listener(user.online)
 */
class OnlineListener implements EventInterface
{
    public function handler($event)
    {
        Log::wirte("--------------Online业务逻辑 start---------------");
        /* @var $response \swoole_http_response */
        /* @var $request \swoole_http_request */
        /* @var $server \swoole_server */
        /* @var $redis \Redis */
        $request = $event['request'];
        $response = $event['response'];
        $redis = $event['redis'];
        $server = $event['server'];

        $key = Config::get('ws.ip').':'.Config::get('ws.port');
        var_dump($redis->hGetAll($key));
        $user_id = $redis->hGet($key, $request->fd);
        var_dump('============2:'.$user_id.'___'.$key.'___'.$request->fd);
        if ($user_id) {
            #给所有用户发送上线通知
            mt_srand();
            $msg_id = mt_rand(1,10);
            //1. 发送消息--》路由服务器--》其他IM-server--》连接到服务器的用户
            $msg = "用户：{$user_id}-fd:{$request->fd}, 上线";
            Log::wirte('发送消息给[路由]服务器...');
            $data = [
                'type' => 'sendmsg',//消息类型
                'data' => [
                    'msg_id' => $msg_id,
                    'task' => 'sendmsgTask',
                    'send_type' => 'group',
                    'from_server' => $key,
                    'from_client' => $request->fd,
                    'from_user' => $user_id,
                    'to_user' => '',
                    'to_group' => 0,//发送分组
                    'msg' => $msg
                ]
            ];
            $flag = $this->sendMsgToRouteServer($data);
            if (!$flag) {
                Log::wirte('发送消息给[路由]服务器失败');
                return false;
            }
            //2. 发送消息给连接到本机的用户(排除自己、异步任务)
            Log::wirte(json_encode($data));
            Log::wirte('发送消息给[本机]服务器...');
            $server->task(json_encode($data));
        } else {
            Log::wirte('Online业务逻辑，用户未找到, fd: '.$request->fd);
        }
        Log::wirte("--------------Online业务逻辑 end---------------");
    }

    protected function sendMsgToRouteServer($data)
    {
        $client = new \Swoole\Coroutine\Http\Client(Config::get('route.host'), Config::get('route.port'));
        $ret = $client->upgrade('/');
        if ($ret) {
            return $client->push(json_encode($data));
        }
    }
}
    