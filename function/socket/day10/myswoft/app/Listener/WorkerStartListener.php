<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/4/2
 * Time: 21:23
 */

namespace App\Listener;
use Swoft\Event\EventInterface;
use Swoole\Coroutine\Http\Client;
use Swoole\WebSocket\Server;

/**
 * Class WorkerStartListener
 * @package App\Listener
 * @Listener(workerstart)
 */
class WorkerStartListener implements EventInterface
{
    public function handler($event)
    {

    }

}