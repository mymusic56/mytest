<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Created by PhpStorm.
 * User: zhangshengji
 * Date: 2020/8/15 0015
 * Time: 18:00
 */
function rbtPublish()
{
    $connection = new AMQPStreamConnection('rabbit3.7-m', 5672, 'guest', 'guest');
    $channel = $connection->channel();

    $channel->exchange_declare('order', AMQPExchangeType::TOPIC, false, true, false);

    $data = [
        'order_id' => rand(100, 999),
        'order_sn' => date('YmdHis'),
        'usr_id' => rand(10, 99)
    ];
    $data = json_encode($data);

    $routing_key = 'order.dealers.user';

    $properties = array('content_type' => 'text/plain', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT);

    $msg = new AMQPMessage($data, $properties);
    $channel->basic_publish($msg, 'order', $routing_key);

    echo ' [x] Sent ', $routing_key, ':', $data, "\n";

    $channel->close();
    $connection->close();
}

rbtPublish();