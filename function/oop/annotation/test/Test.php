<?php
namespace annotation\test;
$loader = require_once '../../../../vendor/autoload.php';

use annotation\annotation\mapping\ControllerMapping;
use annotation\annotation\mapping\Inject;
use annotation\annotation\mapping\PropertyMappping;
use annotation\annotation\mapping\RequestMapping;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

/*
 *
 * Doctrine\Common\Annotations\DocParse不会自动加载，因为这里不属于Doctrine组件，
 * 可能存在其他自动加载器。
 * swoole是如何加载的？swoole为什么能够直接加载？
 */
//class_exists('annotation\annotation\mapping\PropertyMappping');
//class_exists('annotation\annotation\mapping\ControllerMapping');
//class_exists('annotation\annotation\mapping\RequestMapping');
AnnotationRegistry::registerLoader([$loader, 'loadClass']);


# 获取某个类的反射类对象
$rc = new \ReflectionClass(DemoController::class);
$reader = new AnnotationReader();


# 获取某一个指定的属性
$property = $rc->getProperty('controllerName');

var_dump('property: ', $property);
var_dump('-----------获取 类属性 的注解-------------');
$myAnnotation = $reader->getPropertyAnnotation(
    $property, PropertyMappping::class
);
var_dump($myAnnotation);
var_dump('-----------获取 类属性 的注解-------------');


var_dump('-----------获取指定方法上的注解-------------');

$rm = new \ReflectionMethod(DemoController::class, 'indexAction');
$myAnnotation = $reader->getMethodAnnotation($rm, RequestMapping::class);
var_dump($myAnnotation);

var_dump('-----------获取指定方法上的注解-------------');

var_dump('-----------解析类上的注解-------------');
# 解析控制器，方法

$propertys = $rc->getProperties();


//检查Inject注解
$myAnnotation = $reader->getPropertyAnnotation(
    $property, Inject::class
);

//一个类上可以有多个注解
$classAnnotations = $reader->getClassAnnotations($rc);
foreach ($classAnnotations as $classAnnotation) {
    /**
     * @var $classAnnotation ControllerMapping
     */
    $routePrefix = $classAnnotation->getPrefix();
    var_dump("路由前缀： ".$routePrefix);

    $methods = $rc->getMethods();
    foreach ($methods as $method) {
        //一个方法上可以有多个注解
        $methodAnnotations = $reader->getMethodAnnotations($method);

        foreach ($methodAnnotations as $methodAnnotation) {
            /**
             * @var $methodAnnotation RequestMapping
             */
            $routePath = $methodAnnotation->getRoute();
            var_dump("路由：".$routePath);
        }
    }
}