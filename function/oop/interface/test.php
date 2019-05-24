<?php
/**
 * 测试面向接口的编程
 * 自动注入注解对象
 */

require_once 'Base.php';
require_once 'A.php';
require_once 'B.php';
require_once 'Container.php';
class Test
{
    /**
     * @var $date DateTime
     */
    public $date;
    /**
     * @var $base Base
     * @Autowired("B")
     */
    public $base;

    public function test1 ()
    {
        return $this->base->info();
    }
}

/**
 * @var $test Test
 */
$test = Container::getClass(Test::class);
var_dump($test->test1());