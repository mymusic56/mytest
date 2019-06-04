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

$rc = new \ReflectionClass(DemoController::class);
$property = $rc->getProperty('controllerName');
//var_dump($property);die;
$reader = new AnnotationReader();

$myAnnotation = $reader->getPropertyAnnotation(
    $property, PropertyMappping::class
);

var_dump($myAnnotation->propertyName);


$classAnnotation = $reader->getClassAnnotation($rc, ControllerMapping::class);
var_dump($classAnnotation->controllerName);