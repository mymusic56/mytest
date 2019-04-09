<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/4/9
 * Time: 11:45
 */

namespace App\Task;


use Swoft\Config;
use Swoft\Log\Log;

class SendmsgTask
{
    /**
     * @param \swoole_server $server
     * @param $task_id
     * @param $data
     * @param \Redis $redis
     */
    public function handler($server, $task_id, $data, $redis)
    {
        Log::wirte("------------调用Task--------------");
        if ($data['send_type'] == 'group') {
            //获取本机连接的所有用户
            $key = Config::get('ws.ip').':'.Config::get('ws.port');
            $userList = $redis->hGetAll($key);
            if ($userList) {
                Log::wirte("本机用户数量：".count($userList));
                foreach ($userList as $k => $v) {
                    //排除自己
                    $info = $redis->hGet('user_fd', $data['from_user']);
                    $info = json_decode($info, true);
                    if ($info && $info['fd'] == $k) {
                        Log::wirte("过滤fd：{$k} user_id: {$v}");
                        continue;
                    }
                    if ($server->exist($k)) {
                        $server->push($k, json_encode($data, JSON_UNESCAPED_UNICODE));
                        Log::wirte("发送消息： $k => $v");
                    } else {
                        $redis->hDel($k, $k);
                        Log::wirte("删除无效的fd： $k => $v");
                    }
                }
            }
        }
        Log::wirte("------------调用Task end--------------");
    }
}