<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/4/2
 * Time: 21:25
 */

namespace App\Listener;
use Swoft\Config;
use Swoft\Event\EventInterface;
use Swoft\Log\Log;
use Swoole\Coroutine\Http\Client;
use Swoole\WebSocket\Server;

/**
 * Class StartListener
 * @package App\Listener
 * @Listener(serverstart)
 */
class StartListener implements EventInterface
{

    public function handler($event)
    {
        Log::wirte("注册IM-server");
        //启动服务时，将信息注册到
        if ($event['server'] instanceof Server) {
            $serv = $event['server'];
            go(function () use ($serv) {
                $host = Config::get('route.host');
                $port = Config::get('route.port');
                $cli = new Client($host, $port);
                $ret = $cli->upgrade("/");
                if ($ret) {
                    $data = [
                        'host' => Config::get('ws.ip'),
                        'port' => Config::get('ws.port'),
                        'type' => 'register'
                    ];
                    $cli->push(json_encode($data));
                    $rec = $cli->recv();
                    $data = json_decode($rec->data, true);
                    if ($data) {
                        Log::wirte("host: $host, port: $port {$data['msg']}");
                    } else {
                        Log::wirte("注册信息返回异常 , host: $host, port: $port");
                    }

                    //发送心跳包
                    $serv->tick(3000, function () use ($cli) {
                        if ($cli->errCode == 0) {
                            $cli->push("",WEBSOCKET_OPCODE_PING);
                        }
                    });
                } else {
                    Log::wirte("注册失败 , host: $host, port: $port");
                }

            });
        }
    }
}