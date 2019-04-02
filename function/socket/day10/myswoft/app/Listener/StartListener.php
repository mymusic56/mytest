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
        //启动服务时，将信息注册到
        if ($event['server'] instanceof Server) {
            $serv = $event['server'];
            go(function () use ($serv) {
                $cli = new Client(Config::get('route.host'), Config::get('route.port'));
                $ret = $cli->upgrade("/");
                if ($ret) {
                    $data = [
                        'host' => Config::get('ws.host'),
                        'port' => Config::get('ws.port'),
                        'type' => 'register'
                    ];
                    $cli->push(json_encode($data));

                    $serv->tick(3000, function () use ($cli) {
                        if ($cli->errCode == 0) {
                            $cli->push("",WEBSOCKET_OPCODE_PING);
                        }
                    });
                }

            });
        }
    }
}