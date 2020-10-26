<?php
/**
 * DateTime: 2020/10/26 15:10
 * @author: zhangshengji
 */

require '../../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exchange\AMQPExchangeType;

$connection = new AMQPStreamConnection('rabbit3.7-m', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->exchange_declare('direct_logs', AMQPExchangeType::DIRECT, false, false, false);

$severity = isset($argv[1]) && !empty($argv[1]) ? $argv[1] : 'info';

$data = implode(' ', array_slice($argv, 2));
if (empty($data)) {
    $data = "Hello World!";
}

$msg = new AMQPMessage($data);

$channel->basic_publish($msg, 'direct_logs', $severity);

echo ' [x] Sent ', $severity, ':', $data, "\n";

$channel->close();
$connection->close();

/**
 * php direct.publish.php warning 警告消息
 * php direct.publish.php error 严重错误
 * php direct.publish.php info  日志信息
 */