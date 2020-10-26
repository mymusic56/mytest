<?php

require '../../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

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
        'time' => time(),
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

function rbtDelayQueue()
{
    $connection = new AMQPStreamConnection('rabbit3.7-m', 5672, 'guest', 'guest');
    $channel = $connection->channel();

    //缓存队列
    $exchange = 'cache_delay';
    $routing_key = 'cache_delay_key';
    $queue_name = 'cache_delay_queue';
    $delay_milli_seconds = 60000;//单位毫秒

    //死信队列
    $delay_exchange = 'order';
    $delay_queue = 'order_consumer';
    $delay_route_key = 'order.#';

    $channel->exchange_declare($exchange, AMQPExchangeType::TOPIC,false, true, false);

    /**
     * 队列上设置TTL失败
     * x-message-ttl: 必須是【数字】,如果message也设置了过期时间，以数字小为准， 注意message时间必须是【字符串】
     */
    $arguments = new AMQPTable();
    $arguments->set('x-dead-letter-exchange', $delay_exchange);
    $arguments->set('x-dead-letter-routing-key', $delay_route_key);
    $arguments->set('x-message-ttl', $delay_milli_seconds);

    /*
     * passive:
     * durable: 队列是否持久化
     * exclusive: 是否排他，false,允许多个客户端监听同一个队列
     *
     */
    $channel->queue_declare($queue_name, false, true, false, false,
        false, $arguments);

    $channel->queue_bind($queue_name, $exchange);


    //设置消息
    $properties = array(
        'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
        'expiration' => strval(5000),//必须是字符串
    );
    $data = [
        'order_id' => rand(100, 999),
        'order_sn' => date('YmdHis'),
        'time' => time(),
        'usr_id' => rand(10, 99)
    ];
    $data = json_encode($data);
    $msg = new AMQPMessage($data, $properties);

    //发送消息
    $channel->basic_publish($msg, $exchange, '');

    echo ' [x] Sent ', $routing_key, ':', $data, "\n";

    $channel->close();
    $connection->close();
}

rbtPublish();