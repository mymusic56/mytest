<?php
/**
 * Created by PhpStorm.
 * User: zhangshengji
 * Date: 2020/8/15 0015
 * Time: 18:00
 */

require '../../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

function rbtConsume()
{
    $connection = new AMQPStreamConnection('rabbit3.7-m', 5672, 'guest', 'guest');
    $channel = $connection->channel();

    $channel->exchange_declare('order', AMQPExchangeType::TOPIC, false, true, false);

    /*
     * passive:
     * durable: 队列是否持久化
     * exclusive: 是否排他，false,允许多个客户端监听同一个队列
     *
     */
    list($queue_name, ,) = $channel->queue_declare("order_customer3", false, true, false, false);

    $binding_keys = ['*.*.info'];
    $binding_keys = ['*.*.error'];
    $binding_keys = ['order.#'];
//        $binding_keys = ['*.*.user'];

    foreach ($binding_keys as $binding_key) {
        $channel->queue_bind($queue_name, 'order', $binding_key);
    }

    echo " [*] Waiting for logs. To exit press CTRL+C\n";

    $callback = function (AMQPMessage $msg) {
        $time = time();
        $body = json_decode($msg->body, true);
        if (empty($body['time'])) {
            $body['time'] = $time;
        }
        echo ' [x] ', 'time:['.date('Y-m-dd H:i:s').'] ', '延迟：'.($time - $body['time']).'S, ', $msg->delivery_info['routing_key'], ':', $msg->body, "\n";
        //开启ACK模式，需要主动通知
        /**
         * @var $channel \PhpAmqpLib\Channel\AMQPChannel
         */
        $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
    };

    /*
     * no_ack: ack默认是关闭了的，false: 打开ack，避免消费者执行任务过程中断开，分配到给消费者的任务丢失
     *          订阅模式可以将此参数设置为 true.
     */
    $channel->basic_consume($queue_name, '', false, false, false, false, $callback);

    while ($channel->is_consuming()) {
        $channel->wait();
    }

    $channel->close();
    $connection->close();
}

rbtConsume();