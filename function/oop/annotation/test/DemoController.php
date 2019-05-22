<?php
namespace annotation\test;

use annotation\annotation\mapping\ControllerMapping;
use annotation\annotation\mapping\PropertyMappping;
use annotation\annotation\mapping\RequestMapping;

/**
 * Created by PhpStorm.
 * User: zhang
 * @ControllerMapping("Demo")
 */
class DemoController
{
    /**
     * @PropertyMappping(propertyName="This is my property name.")
     */
    public $controllerName;

    public function indexAction()
    {

    }
}