<?php
//require_once __DIR__ . '../../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

//Establish connection to AMQP
$connection = new AMQPConnection();
try{
    $connection->setHost('127.0.0.1');
    $connection->setLogin('guest');
    $connection->setPort(5672);
    $connection->setPassword('guest');
    $connection->connect();

//Create and declare channel
    $channel = new AMQPChannel($connection);


//AMQPC Exchange is the publishing mechanism
    $exchange = new AMQPExchange($channel);

    $routing_key = 'hello';

    $queue = new AMQPQueue($channel);
    $queue->setName($routing_key);
    $queue->setFlags(AMQP_NOPARAM);
    $queue->declareQueue();


    $message = '{"status":"1","msg":"success", "datetime":"'.date('Y-m-d H:i:s').'"}';
    $res = $exchange->publish($message, $routing_key);
    var_dump($res);

    $connection->disconnect();
}catch(Exception $ex){
    print_r($ex);
}
