<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/4/9
 * Time: 11:00
 */

namespace App\Listener;


use Swoft\Event\EventInterface;

/**
 * 用户下线业务逻辑
 * Class OnlineListener
 * @package App\Listener
 * @Listener(user.offline)
 */
class OfflineListener implements EventInterface
{
    public function handler($event)
    {

    }

}