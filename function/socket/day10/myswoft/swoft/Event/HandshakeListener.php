<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/4/2
 * Time: 22:29
 */

namespace Swoft\Event;

/**
 * Class WebsocketHandlerEvent
 * @package Swoft\Event
 * @Listener(ws.handler)
 */
class HandshakeListener implements EventInterface
{

    public function handler($event)
    {

    }
}