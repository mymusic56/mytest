<?php
/**
 * DateTime: 2020/10/29 9:21
 * @author: zhangshengji
 */

namespace S2b2c\Common\Queue\RabbitMq;

use PhpAmqpLib\Exchange\AMQPExchangeType;

abstract class RabbitMQConsumer extends ConsumerBase
{
    const TOPIC = AMQPExchangeType::TOPIC;
    const FANOUT = AMQPExchangeType::FANOUT;
    const DIRECT = AMQPExchangeType::DIRECT;
    const HEADERS = AMQPExchangeType::HEADERS;
    
    /**
     * DirectConsumer constructor.
     * @param string $exchange 交换机， 为空则使用默认交换机
     * @param string $routing_key
     * @param string $exchange_type
     * @param $config
     */
    public function __construct($exchange, $routing_key, $exchange_type, $config)
    {
        parent::__construct($config);

        if ($exchange_type) {
            $this->exchange = $exchange;
        }
        if ($routing_key) {
            $this->routing_key = $routing_key;
        }
        if ($exchange_type) {
            $this->exchange_type = $exchange_type;
        }
    }
}