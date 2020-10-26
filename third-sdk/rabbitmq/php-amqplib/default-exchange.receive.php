<?php
/**
 * DateTime: 2020/10/26 10:30
 * @author: zhangshengji
 */
require '../../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

/*
 * 使用默认交换机会自动持久化
 */
$no_ack = false;

$connection = new AMQPStreamConnection('rabbit3.7-m', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('test-2', false, false, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function (\PhpAmqpLib\Message\AMQPMessage $msg) {
    echo ' [x] Received ', $msg->body, "\n";
    sleep(5);
    /**
     * @var $channel \PhpAmqpLib\Channel\AMQPChannel
     */
    $channel = &$msg->delivery_info['channel'];
    $channel->basic_ack($msg->delivery_info['delivery_tag']);
};

/*
 * 每次只从队列中取出一条消息
 */
$channel->basic_qos(null, 2, null);

$channel->basic_consume('test-2', '', false, $no_ack, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();