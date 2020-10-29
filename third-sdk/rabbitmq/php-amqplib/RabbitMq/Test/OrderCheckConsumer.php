<?php
/**
 * DateTime: 2020/10/29 10:18
 * @author: zhangshengji
 */

namespace S2b2c\Common\Queue\RabbitMq\Test;


use S2b2c\Common\Queue\RabbitMq\RabbitMQConsumer;

class OrderCheckConsumer extends RabbitMQConsumer
{
    protected function run($data)
    {
        $time = time();
        $body = json_decode($data, true);
        if (empty($body['time'])) {
            $body['time'] = $time;
        }
        echo ' [x] ', 'time:['.date('Y-m-dd H:i:s').'] ', '延迟：'.($time - $body['time']).'S, ', $data, "\n";
    }
}