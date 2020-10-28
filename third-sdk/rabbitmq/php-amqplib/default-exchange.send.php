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

$arguments = new \PhpAmqpLib\Wire\AMQPTable();
$arguments->set('x-max-priority', 255);

/**
 * 默认交换机
 * 1. 交换机类型 direct， durable:    true
 * 2. 绑定交换机到路由名称和队列名称相同
 * 3. 可以在使用的时候才声明  队列
 */
//$channel->queue_declare('test-2', false, false, false, false, false, $arguments);

$priority = 12;
$properties = [
    //权重越大，优先处理
    'priority' => $priority
];
$msg = new AMQPMessage('Hello World!' . date('Y-m-d H:i:s') . ', priority: ' . $priority, $properties);

$channel->basic_publish($msg, '', 'test-2');

echo " [x] Sent 'Hello World!'\n";

$channel->close();
$connection->close();

