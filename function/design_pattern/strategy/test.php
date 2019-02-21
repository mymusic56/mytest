<?php
require 'OutputFactory.php';
require 'Output.php';
require 'OutputStrategy.php';
require 'impl/ArrayStrategy.php';
require 'impl/JsonStrategy.php';
require 'impl/SerializeStrategy.php';


$data = ['name' => '张三', 'age' => 14];

$strategys = ['JsonStrategy', 'ArrayStrategy', 'SerializeStrategy'];
try {
    foreach ($strategys as $v) {

        //直接用简单工厂模式实现
//        $result = OutputFactory::build($v)->render($data);

        $output = new Output(OutputFactory::build($v));
        $result = $output->render($data);
        var_dump($result);
    }
} catch (Exception $exception) {
    var_dump($exception->getMessage());
}

/**
 * 策略模式 + 工厂模式
 * 特点： 和适配器模式很像，不同的策略也可以理解为不同的适配器
 *
 * 实现这个功能：
 *      1. 简单工厂模式
 *      2. 适配器模式
 *      3. 策略模式 策略模式多了一个中间层
 *
 * 那么这到底是适配器模式还是策略模式？
 */
