<?php
/**
 * DateTime: 2020/10/29 10:19
 * @author: zhangshengji
 */

namespace S2b2c\Common\Queue\RabbitMq\Test;


use S2b2c\Common\Queue\RabbitMq\RabbitMQPublisher;
use S2b2c\Common\Queue\RabbitMq\MqConfig;

class Test
{
    public function consumeOrderCheck()
    {
        $config = new MqConfig('rabbit3.7-m', 5672, 'guest', 'guest');
        $config->setDurable(true);
        $consumer = new OrderCheckConsumer('order_create_check', 'order_create_check', OrderCheckConsumer::DIRECT, $config);
        $consumer->consume('order_create_check');
    }

    public function consumeFanout()
    {
        $config = new MqConfig('rabbit3.7-m', 5672, 'guest', 'guest');

        $config->setDurable(false);
        $config->setAutoDelete(true);

        $consumer = new FanoutConsumer('logs', '', OrderCheckConsumer::FANOUT, $config);
        $consumer->consume('');
    }

    public function consumeTopic1()
    {
        $config = new MqConfig('rabbit3.7-m', 5672, 'guest', 'guest');

        $config->setDurable(false);
        $config->setAutoDelete(true);

        $consumer = new TopicConsumer('topic_logs', 'admin.user.*', OrderCheckConsumer::TOPIC, $config);
        $consumer->consume('');
    }

    public function consumeTopic2()
    {
        $config = new MqConfig('rabbit3.7-m', 5672, 'guest', 'guest');

        $config->setDurable(false);
        $config->setAutoDelete(true);

        $consumer = new TopicConsumer('topic_logs', '*.*.error', OrderCheckConsumer::TOPIC, $config);
        $consumer->consume('');
    }

    public function consumeDirect()
    {
        $config = new MqConfig('rabbit3.7-m', 5672, 'guest', 'guest');
        $config->setDurable(true);

        $consumer = new DirectConsumer('user_logs', 'error', OrderCheckConsumer::DIRECT, $config);
        $consumer->consume('user_logs.error');
    }
    public function consumeDirect2()
    {
        $config = new MqConfig('rabbit3.7-m', 5672, 'guest', 'guest');
        $config->setDurable(true);

        $consumer = new DirectConsumer('user_logs', 'info', OrderCheckConsumer::DIRECT, $config);
        $consumer->consume('user_logs.info');
    }

    public function directPublish()
    {
        $msg = [
            'order_id' => rand(100, 999),
            'order_sn' => date('YmdHis'),
            'time' => time(),
            'date' => date('Y-m-d H:i:s'),
            'usr_id' => rand(10, 99)
        ];

        $config = new MqConfig('rabbit3.7-m', 5672, 'guest', 'guest');

        $config->setDurable(true);

        $publisher = new RabbitMQPublisher($config);
        $msg['error_type'] = 'error';
        $publisher->directPublisher('user_logs', 'error')->publish($msg);
        $msg['error_type'] = 'info';
        $publisher->directPublisher('user_logs', 'info')->publish($msg);
        $msg['error_type'] = 'warning';
        $publisher->directPublisher('user_logs', 'warning')->publish($msg);
    }


    /**
     * 直接投递： 定时检查订单支付状态
     */
    public function consumeOrderCheckDirectPublish()
    {
        $msg = [
            'order_id' => rand(100, 999),
            'order_sn' => date('YmdHis'),
            'time' => time(),
            'date' => date('Y-m-d H:i:s'),
            'usr_id' => rand(10, 99)
        ];

        $config = new MqConfig('rabbit3.7-m', 5672, 'guest', 'guest');

        $config->setDurable(true);

        $publisher = new RabbitMQPublisher($config);
        $msg['error_type'] = 'error';
        $publisher->directPublisher('order_create_check', 'order_create_check')->publish($msg);
    }

    /**
     * 模拟定时检查订单支付状态
     * @param $ttl
     */
    public function delayPublish($ttl = 30)
    {
        $msg = [
            'order_id' => rand(100, 999),
            'order_sn' => date('YmdHis'),
            'time' => time(),
            'date' => date('Y-m-d H:i:s'),
            'usr_id' => rand(10, 99)
        ];

        $config = new MqConfig('rabbit3.7-m', 5672, 'guest', 'guest');

        $config->setDurable(true);

        $publisher = new RabbitMQPublisher($config);
        $publisher->delayPublisher('cache_order_create' . $ttl, 'cache_order_create_' . $ttl)
            ->setDelayConfig('order_create_check', 'order_create_check', $ttl)
            ->publish($msg, $ttl);
    }

    public function fanoutPublish()
    {
        $msg = [
            'order_id' => rand(100, 999),
            'order_sn' => date('YmdHis'),
            'time' => time(),
            'date' => date('Y-m-d H:i:s'),
            'usr_id' => rand(10, 99)
        ];

        $config = new MqConfig('rabbit3.7-m', 5672, 'guest', 'guest');

        $config->setDurable(false);
        $config->setAutoDelete(true);

        $publisher = new RabbitMQPublisher($config);
        $publisher->fanoutPublisher('logs')->publish($msg);
    }

    public function topicPublish()
    {
        $msg = [
            'user_id' => rand(100, 999),
            'order_sn' => date('YmdHis'),
            'time' => time(),
            'date' => date('Y-m-d H:i:s'),
            'usr_id' => rand(10, 99),
            'msg' => ''
        ];
        $config = new MqConfig('rabbit3.7-m', 5672, 'guest', 'guest');

        $config->setDurable(false);
        $config->setAutoDelete(true);

        $publisher = new RabbitMQPublisher($config);
        $msg['error_type'] = 'admin.user.error';
        $publisher->topicPublisher('topic_logs', 'admin.user.error')->publish($msg);
        $msg['error_type'] = 'admin.user.info';
        $publisher->topicPublisher('topic_logs', 'admin.user.info')->publish($msg);
        $msg['error_type'] = 'admin.goods.error';
        $publisher->topicPublisher('topic_logs', 'admin.goods.error')->publish($msg);
        $msg['error_type'] = 'admin.goods.info';
        $publisher->topicPublisher('topic_logs', 'admin.goods.info')->publish($msg);
        $msg['error_type'] = 'buyer.goods.info';
        $publisher->topicPublisher('topic_logs', 'buyer.goods.info')->publish($msg);
    }
}