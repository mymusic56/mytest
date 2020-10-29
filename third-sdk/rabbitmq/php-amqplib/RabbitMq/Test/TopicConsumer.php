<?php
/**
 * DateTime: 2020/10/29 10:18
 * @author: zhangshengji
 */

namespace S2b2c\Common\Queue\RabbitMq\Test;


use S2b2c\Common\Queue\RabbitMq\RabbitMQConsumer;

class TopicConsumer extends RabbitMQConsumer
{
    protected function run($data)
    {
        echo ' [x] ', $data, "\n";
    }
}