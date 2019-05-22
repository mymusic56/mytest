<?php

/**
 * 面向接口编程，实现依赖注入
 * 反射
 */

interface MConfig{
    public function getConfig();
}

interface RConfig
{
    public function getConfig();
}

interface IMysql{}

interface IRedis{}


class MysqlConfig implements MConfig
{
    public function getConfig()
    {
        return ['host', 'name', 'pwd'];
    }
}

class RedisConfig implements RConfig
{
    public function getConfig()
    {
        return ['host', 'name', 'pwd'];
    }
}

class DbMysql implements IMysql
{
    private $config;
    public function __construct(MConfig $config)
    {
        $this->config = $config->getConfig();
    }

    public function query()
    {
        echo __METHOD__ . PHP_EOL;
    }
}

class DbRedis implements IRedis
{
    private $config;
    public function __construct(RConfig $config)
    {
        $this->config = $config->getConfig();
    }

    public function set()
    {
        echo __METHOD__ . PHP_EOL;
    }

    public function get()
    {
        echo __METHOD__ . PHP_EOL;
    }
}

class Request
{
    public static $uri = 'uri';
}

class controller
{
    public $mysql;
    public $redis;

    public function __construct(IMysql $mysql, IRedis $redis)
    {
        var_dump($mysql);
        var_dump($redis);
        $this->mysql = $mysql;
        $this->redis = $redis;
    }

    public function action()
    {
        is_object($this->mysql) && $this->mysql->query();
        is_object($this->redis) && $this->redis->set();
    }
}

class Container
{

    public $bindings = [];

    public function bind($key, $value)
    {
        if (!$value instanceof Closure) {
            $this->bindings[$key] = $this->getClosure($value);
        } else {
            $this->bindings[$key] = $value;
        }
    }

    public function getClosure($value)
    {
        return function () use ($value) {
            return $this->build($value);
        };
    }

    public function make($key)
    {
        if (isset($this->bindings[$key])) {
            return $this->build($this->bindings[$key]);
        }
        return $this->build($key);
    }

    public function build($value)
    {
        if ($value instanceof Closure) {
            return $value();
        }
        // 实例化反射类
        var_dump($value);
        $reflection = new ReflectionClass($value);
        // isInstantiable() 方法判断类是否可以实例化
        $isInstantiable = $reflection->isInstantiable();
        if ($isInstantiable) {
            // getConstructor() 方法获取类的构造函数，为NULL没有构造函数
            $constructor = $reflection->getConstructor();
            if (is_null($constructor)) {
                // 没有构造函数直接实例化对象返回
                return new $value;
            } else {
                // 有构造函数
                $params = $constructor->getParameters();
                if (empty($params)) {
                    // 构造函数没有参数，直接实例化对象返回
                    return new $value;
                } else {
                    $dependencies = [];
                    // 构造函数有参数
                    foreach ($params as $param) {
                        $dependency = $param->getClass();
                        if (is_null($dependency)) {
                            // 构造函数参数不为class，返回NULL
                            $dependencies[] = NULL;
                        } else {
                            // 类存在创建类实例
                            $dependencies[] = $this->make($param->getClass()->name);
                        }
                    }
                    return $reflection->newInstanceArgs($dependencies);
                }
            }
        }
        return null;
    }

}

$app = new Container();
$app->bind('MConfig', 'MysqlConfig');
$app->bind('RConfig', 'RedisConfig');
$app->bind('IMysql', 'DbMysql');
$app->bind('IRedis', 'DbRedis');
$app->bind('controller', 'Controller');
$controller = $app->make('controller');
$request = new Request();
$controller->action();

//$mysql = $app->make('mysql');
//$mysql->query();