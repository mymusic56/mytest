<?php
/**
 * DateTime: 2020/10/26 10:30
 * @author: zhangshengji
 */
require '../../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('rabbit3.7-m', 5672, 'guest', 'guest');
$channel = $connection->channel();

/**
 * 1. 默认交换机使用 direct， durable:	true
 * 2. 路由名称保持和队列名称相同
 */
$channel->queue_declare('test-2', false, false, false, false);

$msg = new AMQPMessage('Hello World!'.date('Y-m-d H:i:s'));

$channel->basic_publish($msg, '', 'test-2');

echo " [x] Sent 'Hello World!'\n";

$channel->close();
$connection->close();

