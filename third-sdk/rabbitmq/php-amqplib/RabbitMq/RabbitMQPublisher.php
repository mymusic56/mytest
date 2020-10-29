<?php
/**
 * DateTime: 2020/10/29 14:28
 * @author: zhangshengji
 */

namespace S2b2c\Common\Queue\RabbitMq;

use PhpAmqpLib\Exchange\AMQPExchangeType;

class RabbitMQPublisher extends PublisherBase
{

    /**
     * @param string $cache_exchange
     * @param string $cache_queue_name
     * @param MqConfig $config
     */
    public function __construct($config)
    {
        parent::__construct($config);
    }

    public function delayPublisher($exchange, $queue_name)
    {
        $this->exchange_type = AMQPExchangeType::DIRECT;
        $this->exchange = $exchange;
        $this->queue_name = $queue_name;
        return $this;
    }

    public function directPublisher($exchange, $routing_key)
    {
        $this->exchange_type = AMQPExchangeType::DIRECT;
        $this->exchange = $exchange;
        $this->routing_key = $routing_key;
        return $this;
    }

    public function fanoutPublisher($exchange)
    {
        $this->exchange_type = AMQPExchangeType::FANOUT;
        $this->exchange = $exchange;
        return $this;
    }

    public function topicPublisher($exchange, $routing_key)
    {
        $this->exchange_type = AMQPExchangeType::TOPIC;
        $this->exchange = $exchange;
        $this->routing_key = $routing_key;
        return $this;
    }

    public function setDelayConfig($dead_letter_exchange, $dead_letter_routing_key, $message_ttl)
    {
        if ($message_ttl <= 0) {
            $message_ttl = 1;
        }
        $this->config->setDelayConfig([
            'x-dead-letter-exchange' => $dead_letter_exchange,
            'x-dead-letter-routing-key' => $dead_letter_routing_key,
            'x-message-ttl' => $message_ttl * 1000,
        ]);
        return $this;
    }
}