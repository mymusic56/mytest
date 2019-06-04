<?php
namespace annotation\test;
$loader = require_once '../../../../vendor/autoload.php';

use annotation\annotation\mapping\ControllerMapping;
use annotation\annotation\mapping\PropertyMappping;
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
//var_dump($property);die;
$reader = new AnnotationReader();


# 获取某一个指定的属性
$property = $rc->getProperty('controllerName');
$myAnnotation = $reader->getPropertyAnnotation(
    $property, PropertyMappping::class
);
var_dump($myAnnotation->propertyName);

# 解析控制器，方法
$classAnnotations = $reader->getClassAnnotations($rc);
foreach ($classAnnotations as $classAnnotation) {
    $routePrefix = $classAnnotation->getPrefix();
    var_dump("控制器： ".$routePrefix);
    $methods = $rc->getMethods();
    foreach ($methods as $method) {
        $methodAnnotations = $reader->getMethodAnnotations($method);
        foreach ($methodAnnotations as $methodAnnotation) {
            $routePath = $methodAnnotation->getRoute();
            var_dump("方法：".$routePath);
        }
    }
}