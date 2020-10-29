<?php
/**
 * DateTime: 2020/10/23 14:15
 * @author: zhangshengji
 */
namespace S2b2c\Common\Queue\RabbitMq;

class MqConfig
{
    private $host = '127.0.0.1';
    private $port = '5672';
    private $user = 'guest';
    private $password = 'guest';
    private $vhost = '/';



    private $durable = false;
    private $auto_delete = false;
    private $no_ack = false;
    private $exclusive = false;

    private $prefetch_size = null;
    private $prefetch_count = 1;

    /**
     * 用于延迟队列配置
     * @var array
     */
    private $delayConfig = [
        'x-dead-letter-exchange' => '',
        'x-dead-letter-routing-key' => '',
        'x-message-ttl' => '1',
    ];

    public function __construct($host, $port, $user, $password, $vhost = '/')
    {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
        $this->vhost = $vhost;
    }

    /**
     * @return bool
     */
    public function isDurable()
    {
        return $this->durable;
    }

    /**
     * @param bool $durable
     */
    public function setDurable($durable)
    {
        $this->durable = $durable;
    }

    /**
     * @return bool
     */
    public function isAutoDelete()
    {
        return $this->auto_delete;
    }

    /**
     * @param bool $auto_delete
     */
    public function setAutoDelete($auto_delete)
    {
        $this->auto_delete = $auto_delete;
    }

    /**
     * @return bool
     */
    public function isNoAck()
    {
        return $this->no_ack;
    }

    /**
     * @param bool $no_ack
     */
    public function setNoAck($no_ack)
    {
        $this->no_ack = $no_ack;
    }

    /**
     * @return bool
     */
    public function isExclusive()
    {
        return $this->exclusive;
    }

    /**
     * @param bool $exclusive
     */
    public function setExclusive($exclusive)
    {
        $this->exclusive = $exclusive;
    }

    /**
     * @return null
     */
    public function getPrefetchSize()
    {
        return $this->prefetch_size;
    }

    /**
     * @param null $prefetch_size
     */
    public function setPrefetchSize($prefetch_size)
    {
        $this->prefetch_size = $prefetch_size;
    }

    /**
     * @return int
     */
    public function getPrefetchCount()
    {
        return $this->prefetch_count;
    }

    /**
     * @param int $prefetch_count
     */
    public function setPrefetchCount($prefetch_count)
    {
        $this->prefetch_count = $prefetch_count;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getVhost()
    {
        return $this->vhost;
    }

    /**
     * @return mixed
     */
    public function getDelayConfig()
    {
        return $this->delayConfig;
    }

    /**
     * @param mixed $delayConfig
     */
    public function setDelayConfig($delayConfig)
    {
        $this->delayConfig = $delayConfig;
    }
}