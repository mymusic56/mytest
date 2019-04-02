<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/4/2
 * Time: 22:29
 */

namespace App\Listener;

use Swoft\Event\EventInterface;

/**
 * Class WebsocketHandlerEvent
 * @package App\Listener
 * @Listener(ws.handler)
 */
class HandshakeListener implements EventInterface
{

    public function handler($event)
    {
        //客户端握手，验证token
    }
}