<?php
/**
 * DateTime: 2020/10/26 15:10
 * @author: zhangshengji
 */

require '../../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;

$durable = false;


$connection = new AMQPStreamConnection('rabbit3.7-m', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->exchange_declare('topic_logs', AMQPExchangeType::TOPIC, false, $durable, false);

$binding_keys = array_slice($argv, 1);
if (empty($binding_keys)) {
    file_put_contents('php://stderr', "Usage: $argv[0] [binding_key]\n");
    exit(1);
}

$queue_name = '';

if (!$durable) {
    list($queue_name, ,) = $channel->queue_declare("", false, $durable, false, false);
}


foreach ($binding_keys as $binding_key) {
    if ($durable) {
        list($queue_name, ,) = $channel->queue_declare("topic_logs.".$binding_key, false, $durable, false, false);
    }
    $channel->queue_bind($queue_name, 'topic_logs', $binding_key);
}

echo " [*] Waiting for logs. To exit press CTRL+C\n";

$callback = function ($msg) {
    echo ' [x] ', $msg->delivery_info['routing_key'], ':', $msg->body, "\n";
};

$channel->basic_consume($queue_name, '', false, false, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();