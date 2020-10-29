<?php
/**
 * DateTime: 2020/10/29 9:01
 * @author: zhangshengji
 */

namespace S2b2c\Common\Queue\RabbitMq;


use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

abstract class PublisherBase
{
    /**
     * @var AMQPChannel
     */
    protected $channel;

    protected $exchange = '';

    protected $exchange_type = AMQPExchangeType::DIRECT;

    protected $routing_key = '';

    protected $queue_name = '';

    /**
     * @var MqConfig
     */
    protected $config;

    /**
     * @param MqConfig $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }


    /**
     * @param $msg
     * @param int $ttl      秒
     * @param int $priority 数字越大优先级越高,最大值255
     */
    public function publish($msg, $ttl = 0, $priority = 0)
    {
        $this->channel = MqClient::getInstance($this->config)->getChannel();

        $properties = [];
        if ($this->config->isDurable()) {
            $properties['delivery_mode'] = AMQPMessage::DELIVERY_MODE_PERSISTENT;
        }
        if ($ttl > 0) {
            $properties['expiration'] = strval($ttl * 1000);
        }
        if ($priority > 0) {
            $properties['priority'] = $priority;
        }

        if ($this->exchange) {
            $this->channel->exchange_declare(
                $this->exchange,
                $this->exchange_type,
                false,
                $this->config->isDurable(),
                $this->config->isAutoDelete()
            );
        }

        //延迟队列设置
        if ($ttl > 0) {
            $arguments = new AMQPTable();
            $arguments->set('x-dead-letter-exchange', $this->config->getDelayConfig()['x-dead-letter-exchange']);
            $arguments->set('x-dead-letter-routing-key', $this->config->getDelayConfig()['x-dead-letter-routing-key']);
            $arguments->set('x-message-ttl', $this->config->getDelayConfig()['x-message-ttl']);

            list($queue_name, ,) = $this->channel->queue_declare(
                $this->queue_name,
                false,
                $this->config->isDurable(),
                $this->config->isExclusive(),
                $this->config->isAutoDelete(),
                false,
                $arguments
            );

            $this->channel->queue_bind($queue_name, $this->exchange);
        }

        if (!is_string($msg)) $msg = json_encode($msg);
        $msg = new AMQPMessage($msg, $properties);

        $this->channel->basic_publish($msg, $this->exchange, $this->routing_key);
        $this->channel->close();
    }
}