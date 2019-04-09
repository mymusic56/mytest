<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/4/4
 * Time: 20:28
 */

namespace App\Listener;


use Swoft\Config;
use Swoft\Event\EventInterface;
use Swoft\Log\Log;

/**
 * Class CloseListener
 * @package App\Listener
 * @Listener(ws.close)
 */
class CloseListener implements EventInterface
{

    public function handler($event)
    {
        /* @var $server \swoole_server */
        /* @var $redis \Redis */
        $redis = $event['redis'];
        $server = $event['server'];
        $fd = $event['fd'];
        $reactor_id = $event['reactor_id'];
        Log::wirte("删除fd: $fd");
        $key = Config::get('ws.ip').":".Config::get('ws.port');
        //找到用户ID
        $user_id = $redis->hGet($key, $fd);
        if ($user_id) {
            //删除fd 对应的用户
            $flag = $redis->hDel($key, $fd);
            //删除用户 对应的主机信息
            $flag = $redis->hDel('user_fd', $user_id);
        }
        $server->close($fd);
    }
}