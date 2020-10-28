<?php
/**
 * DateTime: 2020/10/26 15:10
 * @author: zhangshengji
 */

require '../../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exchange\AMQPExchangeType;

$durable = false;

$connection = new AMQPStreamConnection('rabbit3.7-m', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->exchange_declare('topic_logs', AMQPExchangeType::TOPIC, false, $durable, false);

$routing_key = isset($argv[1]) && !empty($argv[1]) ? $argv[1] : 'anonymous.info';
$data = implode(' ', array_slice($argv, 2));
if (empty($data)) {
    $data = "Hello World!";
}

$properties = [];
if ($durable) {
    $properties = array('content_type' => 'text/plain', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT);
}

$msg = new AMQPMessage($data, $properties);

var_dump($routing_key);

$channel->basic_publish($msg, 'topic_logs', $routing_key);

echo ' [x] Sent ', $routing_key, ':', $data, "\n";

$channel->close();
$connection->close();

/**
 * php topic.publish.php "user.error" "user not found"
 * php topic.publish.php "order.info" "order_sn: 123456789"
 * php topic.publish.php "order.error" "order not found"
 * php topic.publish.php "goods.error" "goods not found"
 */

/**
 * 订阅订单、商品错误信息
 * php topic.subscribe.php "order.error" "goods.error"
 *
 * 订阅订单信息
 * php topic.subscribe.php "order.*"
 *
 * 订阅商品信息
 * php topic.subscribe.php "goods.*"
 *
 * 订阅所有错误信息
 * php topic.subscribe.php "*.error"
 *
 * 订阅用户相关错误信息
 * php topic.subscribe.php "user.error"
 */