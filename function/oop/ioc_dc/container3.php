<?php

/**
 *
 * 通过闭包实现依赖注入
 * 面向接口编程，不要显示指定DbMysql 和 DbRedis， 只需指定被实现接口就可以
 */

interface IMysql{}

interface IRedis{}

class DbMysql implements IMysql
{
    public function __construct($host, $name, $pwd)
    {
        // do something
    }

    public function query()
    {
        echo __METHOD__ . PHP_EOL;
    }
}

class DbRedis implements IRedis
{
    public function __construct($host, $name, $pwd)
    {
        // do something
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
$app->bind('IMysql', function () {
    return new DbMysql('host', 'name', 'pwd');
});
$app->bind('IRedis', function () {
    return new DbRedis('host', 'name', 'pwd');
});
$app->bind('controller', 'Controller');
$controller = $app->make('controller');
$controller->action();

//$mysql = $app->make('mysql');
//$mysql->query();

/**
 * 需要显示指定DbMysql 和 DbRedis，
 */