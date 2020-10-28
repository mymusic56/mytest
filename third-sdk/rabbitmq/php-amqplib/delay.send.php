<?php

require '../../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

function rbtDelayQueue()
{
    $connection = new AMQPStreamConnection('rabbit3.7-m', 5672, 'guest', 'guest');
    $channel = $connection->channel();

    //缓存队列（仅用于存储消息，让消息过期，然后让消息被重新投递）
    $cache_exchange = 'cache_order_exchange';
    $cache_queue_name = 'cache_order_queue';
    $cache_queue_ttl_milliseconds = 60000;//单位毫秒
    $cache_message_ttl_milliseconds = "10000";

    //真正的队列
    $delay_exchange = 'order';
    //消费者端使用topic主题
    $delay_route_key = 'order.create.error';

    $channel->exchange_declare($cache_exchange, AMQPExchangeType::DIRECT,false, true, false);

    /**
     * 队列上设置TTL失败
     * x-message-ttl: 必須是【数字】,如果message也设置了过期时间，以数字小为准， 注意message时间必须是【字符串】
     */
    $arguments = new AMQPTable();
    $arguments->set('x-dead-letter-exchange', $delay_exchange);
    $arguments->set('x-dead-letter-routing-key', $delay_route_key);
    $arguments->set('x-message-ttl', $cache_queue_ttl_milliseconds);

    /*
     * passive:
     * durable: 队列是否持久化
     * exclusive: 是否排他，false,允许多个客户端监听同一个队列
     *
     */
    $channel->queue_declare($cache_queue_name, false, true, false, false,
        false, $arguments);

    $channel->queue_bind($cache_queue_name, $cache_exchange);


    //设置消息
    $properties = array(
        'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
        'expiration' => strval($cache_message_ttl_milliseconds),//必须是字符串
    );
    $data = [
        'order_id' => rand(100, 999),
        'order_sn' => date('YmdHis'),
        'time' => time(),
        'date' => date('Y-m-d H:i:s'),
        'usr_id' => rand(10, 99)
    ];
    $data = json_encode($data);
    $msg = new AMQPMessage($data, $properties);

    //发送消息
    $channel->basic_publish($msg, $cache_exchange);

    echo ' [x] Exchange ', $cache_exchange, 'queue ', $cache_queue_name, ':', $data, "\n";

    $channel->close();
    $connection->close();
}

rbtDelayQueue();