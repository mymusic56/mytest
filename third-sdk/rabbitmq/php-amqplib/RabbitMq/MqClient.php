<?php
/**
 * DateTime: 2020/10/28 17:40
 * @author: zhangshengji
 */

namespace S2b2c\Common\Queue\RabbitMq;


use PhpAmqpLib\Connection\AMQPStreamConnection;

class MqClient
{
    private static $instance = null;
    /**
     * @var AMQPStreamConnection
     */
    private $connect = null;

    /**
     * @var MqConfig
     */
    private $config;

    private $lastConnectTime;

    private function __construct($config)
    {
        $this->config = $config;
        $this->connect();
    }

    public static function getInstance($config)
    {
        if (empty($config)) {
            throw new \LogicException('RabbitMQ连接配置信息未为空');
        }
        if (!self::$instance || !(self::$instance instanceof MqClient)) {
            return new MqClient($config);
        }
        return self::$instance;
    }

    private function connect()
    {
        if (!$this->connect || !$this->connect->isConnected()) {
            $this->connect = new AMQPStreamConnection(
                $this->config->getHost(),
                $this->config->getPort(),
                $this->config->getUser(),
                $this->config->getPassword(),
                $this->config->getVhost()
            );
            $this->lastConnectTime = time();
        }
    }

    public function reConnect()
    {
        $this->connect = null;
        $this->connect();
    }

    /**
     * @return \PhpAmqpLib\Channel\AMQPChannel
     */
    public function getChannel()
    {
        return $this->connect->channel();
    }

    public function close()
    {
        try {
            $this->connect->close();
            $this->connect = null;
        } catch (\Exception $e) {
            //todo
            return false;
        }
        return true;
    }

    public function ping()
    {
        if (!$this->connect || !$this->connect->isConnected()) {
            return false;
        }
        return true;
    }
}