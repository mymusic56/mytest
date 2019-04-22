<?php
/**
 * Created by PhpStorm.
 * User: Sixstar-Peter
 * Date: 2019/4/19
 * Time: 22:28
 */

class Pool
{
    protected $maxConnection = 60; //最大连接
    protected $minConnection = 5; //最小连接
    protected $currentConnection; //当前正在使用的连接

    /**
     * @var $channel SplQueue
     */
    protected $channel; //存放连接的对象
    protected $timeout = 3; //等待连接的时间
    private static $instance;

    private function __construct()
    {
    }

    public static function get_instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function init()
    {
//        $this->channel = new SplQueue();
        $this->channel = new \Swoole\Coroutine\Channel($this->maxConnection);
        for ($i = 0; $i < $this->minConnection; $i++) {
            $connection = $this->createConnection();
            $this->channel->push($connection);
            $this->currentConnection++;
        }
    }

    /**
     * 创建连接
     */
    public function createConnection()
    {
        try {
            $swoole_mysql = new PDO('mysql:host=192.168.1.101;dbname=mytest', 'root', '123456');
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
        return $swoole_mysql;

    }

    /**
     * 获取连接
     */
    public function getConnection()
    {

        $obj = null;
        //1.如果连接不够要添加，判断是否超过最大的连接数，
        if ($this->channel->isEmpty()) {
            if ($this->currentConnection < $this->maxConnection) {
                $obj = $this->createConnection();
                //$this->channel->push($obj);
                $this->currentConnection++;

            } else {
                var_dump("等待获取连接");
                $obj = $this->channel->pop($this->timeout); //等待其它协程归还连接

            }
        } else {
            $obj = $this->channel->pop($this->timeout); //超时
        }
        //2.如果连接超过要等待
        return $obj;
    }

    /**
     * 释放连接（重新回到连接池）
     */
    public function freeConnection($obj)
    {
        $this->channel->push($obj);
    }


}