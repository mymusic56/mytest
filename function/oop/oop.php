<?php

/**
 * 对象是引用传值
 * https://www.php.net/manual/zh/features.gc.refcounting-basics.php
 * 1. 不论是对象还是数组，unset()变量后内存会被回收。
 * Class T
 */
class T
{
    public $num = 1;
    protected $name = 'zhangsan';

    public function __construct()
    {
        echo "__construct".PHP_EOL;

    }

    public function __destruct()
    {
        echo "__destruct".PHP_EOL;
    }

    public function a()
    {
        echo "a()".PHP_EOL;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
$t = new T();

$t->a();

class C
{
    function test(T $t)
    {
        $t->num = 22222;
    }

    function test2(T $t)
    {
        $t->setName('lisi');
    }
}

$str = serialize($t);

var_dump($t->num);
# 测试是否为引用传值
$c = new C();
$c->test($t);
$t_2 = $t;
$c->test2($t_2);
var_dump($t->num, $t->getName());

$object = unserialize($str);
var_dump($object->num, $object->getName());

# xdebug分析变量是否为引用变量
xdebug_debug_zval('t');
//t: (refcount=2, is_ref=0)=class T { public $num = (refcount=0, is_ref=0)=22222; protected $name = (refcount=0, is_ref=0)='lisi' }

# 手动引用
$num = &$t->num;
xdebug_debug_zval('t');
//t: (refcount=2, is_ref=0)=class T { public $num = (refcount=2, is_ref=1)=22222; protected $name = (refcount=0, is_ref=0)='lisi' }


# 测试unset之后是否删除变量
var_dump(memory_get_usage());

$arr = function () {
    $arr = [];
    for ($i = 1; $i <= 1000; $i++) {
        $arr[] = new C();
    }
    return $arr;
};

var_dump(memory_get_usage());
call_user_func($arr);
unset($arr);
var_dump(memory_get_usage());

class D
{
    public $arr = [];
    public function test()
    {
        for ($i = 1; $i <= 1000; $i++) {
            $this->arr[] = new C();
        }
    }
}

$d = new D();
var_dump('-----------------------------',memory_get_usage());
$d->test();
var_dump(memory_get_usage());
unset($d);
var_dump(memory_get_usage());

