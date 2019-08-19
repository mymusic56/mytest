<?php
//require_once __DIR__ . '../../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

//Establish connection AMQP
$connection = new AMQPConnection();
try {
    $connection->setHost('127.0.0.1');
    $connection->setLogin('guest');
    $connection->setPassword('guest');
    $connection->connect();

//Create and declare channel
    $channel = new AMQPChannel($connection);
} catch (\Exception $e) {
    var_dump($e->getMessage());
}

$routing_key = 'hello';

$callback_func = function(AMQPEnvelope $message, AMQPQueue $q) use (&$max_jobs) {
    echo " [x] Received: ", $message->getBody(), PHP_EOL;
//    sleep(sleep(substr_count($message->getBody(), '.')));
    echo " [X] Done", PHP_EOL;
    $tag = $message->getDeliveryTag();
    var_dump($tag);
    $q->ack($tag);
};

try{
    $queue = new AMQPQueue($channel);
    $queue->setName($routing_key);
    $queue->setFlags(AMQP_NOPARAM);
    $queue->declareQueue();


    echo ' [*] Waiting for logs. To exit press CTRL+C', PHP_EOL;
    $queue->consume($callback_func);
}catch(AMQPQueueException $ex){
    print_r($ex);
}catch(Exception $ex){
    print_r($ex);
}

$connection->disconnect();