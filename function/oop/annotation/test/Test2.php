<?php
namespace annotation\test;
$loader = require_once '../../../../vendor/autoload.php';
include 'User.php';

use annotation\annotation\mapping\ControllerMapping;
use annotation\annotation\mapping\Inject;
use annotation\annotation\mapping\PropertyMappping;
use annotation\annotation\mapping\RequestMapping;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use User;

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


var_dump(spl_autoload_functions());

# 获取某个类的反射类对象
$rc = new \ReflectionClass(DemoController::class);
$reader = new AnnotationReader();

$demoController = new DemoController();

//属性注解

$property = new \ReflectionProperty(DemoController::class, 'user');

$properties = $rc->getProperties();
foreach ($properties as $property) {

    //检查Inject注解
    /**
     * @var $injectAnnotation Inject
     */
    $injectAnnotation = $reader->getPropertyAnnotation(
        $property, Inject::class
    );
    if ($injectAnnotation) {
        $className = $injectAnnotation->getName();
        if (!$className) {
            //使用属性名称作为类型
            $className = ucfirst($property->getName());
        }
        var_dump($className);
        $className = "\\annotation\\test\\User";
        var_dump($className);

        $is_private = false;
        if ($property->isPrivate()) {
            $is_private = true;
            $property->setAccessible(true);
        }
        if (!$property->isStatic()) {
            $property->setValue($demoController, new $className(1, 'zhangsan'));
        } else {
            $property->setValue(new $className(1, 'zhangsan'));
        }
        if ($is_private) {
            $property->setAccessible(false);
        }
    }
}
var_dump($demoController->getNameAction());

//一个类上可以有多个注解
$classAnnotations = $reader->getClassAnnotations($rc);
foreach ($classAnnotations as $classAnnotation) {

    if ($classAnnotation instanceof ControllerMapping) {
        /**
         * @var $classAnnotation ControllerMapping
         */
        $routePrefix = $classAnnotation->getPrefix();
        var_dump("路由前缀： ".$routePrefix);
    }

}


//获取方法注解
$methods = $rc->getMethods();
foreach ($methods as $method) {
    //一个方法上可以有多个注解
    $methodAnnotations = $reader->getMethodAnnotations($method);

    foreach ($methodAnnotations as $methodAnnotation) {

        if ($methodAnnotation instanceof RequestMapping) {
            /**
             * @var $methodAnnotation RequestMapping
             */
            $routePath = $methodAnnotation->getRoute();
            var_dump("路由：".$routePath);
        }
    }
}