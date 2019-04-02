<?php

namespace Swoft\Event;
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/4/2
 * Time: 21:21
 */

interface EventInterface
{
    public function handler($event);
}