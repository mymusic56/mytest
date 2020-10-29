<?php
/**
 * DateTime: 2020/10/29 9:11
 * @author: zhangshengji
 */

namespace S2b2c\Common\Queue\RabbitMq;


use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Exchange\AMQPExchangeType;

abstract class ConsumerBase
{
    /**
     * @var AMQPChannel
     */
    protected $channel;

    protected $exchange = '';

    protected $exchange_type = AMQPExchangeType::DIRECT;

    protected $routing_key = '';

    /**
     * @var MqConfig
     */
    protected $config;

    /**
     * ConsumerBase constructor.
     * @param MqConfig $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @param string $queue_name
     */
    public function consume($queue_name)
    {
        $this->channel = MqClient::getInstance($this->config)->getChannel();

        //申明交换机
        if ($this->exchange) {
            $this->channel->exchange_declare(
                $this->exchange,
                $this->exchange_type,
                false,
                $this->config->isDurable(),
                $this->config->isAutoDelete()
            );
        }

        //申明队列
        list($queue_name, ,) = $this->channel->queue_declare(
            $queue_name,
            false,
            $this->config->isDurable(),
            $this->config->isExclusive(),
            $this->config->isAutoDelete(),
            false
        );

        //绑定交换机和队列
        if ($this->exchange) $this->channel->queue_bind($queue_name, $this->exchange, $this->routing_key);

        //预载入信息设置， 首次连接的时候只从队列中取出N条消息
        $this->channel->basic_qos($this->config->getPrefetchSize(), $this->config->getPrefetchCount(), null);

        $this->waitConsume($queue_name);
    }

    protected function waitConsume($queue_name)
    {
        try {
            $this->channel->basic_consume(
                $queue_name,
                '',
                false,
                $this->config->isNoAck(),
                false,
                false,
                $this->callback()
            );

            while ($this->channel->is_consuming()) {
                $this->channel->wait();
            }

            $this->channel->close();
        } catch (\Exception $e) {
            //todo
        }
    }

    protected function callback()
    {
        return function (\PhpAmqpLib\Message\AMQPMessage $msg) {

            $this->run($msg->body);

            if (!$this->config->isNoAck()) {
                /**
                 * @var $channel \PhpAmqpLib\Channel\AMQPChannel
                 */
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
            }
        };
    }

    /**
     * 业务逻辑
     * @param $data
     * @return mixed
     */
    protected abstract function run($data);
}