<?php

/**
 * 反射如何判断参数类型？？？
 */
class T
{
    public $t;
}

class X
{
    public $x;

    private function __construct()
    {
    }
}

class Y
{
    public $x;

    public function __construct()
    {
    }
}

interface Is
{
}

class Sis implements Is
{

}

class S
{
    public $s;

    public function __construct(string $s, int $i, array $a=[], Is $object=null)
    {
        $this->s = $s;
    }
}

function reflectionClass($className, array $inParams = [])
{
    $reflection = new ReflectionClass($className);
    // isInstantiable() 方法判断类是否可以实例化
    $isInstantiable = $reflection->isInstantiable();
    if ($isInstantiable) {
        // getConstructor() 方法获取类的构造函数，为NULL没有构造函数
        $constructor = $reflection->getConstructor();
        if (is_null($constructor)) {
            // 没有构造函数直接实例化对象返回
            return new $className;
        } else {
            // 有构造函数
            $params = $constructor->getParameters();
            if (empty($params)) {
                // 构造函数没有参数，直接实例化对象返回
                return new $className;
            } else {

                foreach ($params as $param) {//ReflectionParameter

                }

                // 构造函数有参数，将$inParams传入实例化对象返回
                return $reflection->newInstanceArgs($inParams);
            }
        }
    }
    return null;
}

$t = reflectionClass('T');
var_dump($t instanceof T);
$x = reflectionClass('X');//构造器被私有了
var_dump($x instanceof X);
$x = reflectionClass('Y');
var_dump($x instanceof Y);
$s = reflectionClass('S', ['asdf', 123, [1, 2], (new Sis)]);
var_dump($s instanceof S);