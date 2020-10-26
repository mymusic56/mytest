<?php
namespace annotation\test;

use annotation\annotation\mapping\ControllerMapping;
use annotation\annotation\mapping\PropertyMappping;
use annotation\annotation\mapping\RequestMapping;
use annotation\annotation\mapping\Inject;

/**
 * Created by PhpStorm.
 * User: zhang
 * @ControllerMapping("demo")
 */
class DemoController
{
    /**
     * @Inject()
     * @var $user User
     */
    private $user;

    /**
     * @PropertyMappping(propertyName="This is my property name.")
     */
    public $controllerName;

    /**
     * @RequestMapping(route="index", params={"id"="\d+", "name"="lisi"})
     */
    public function indexAction($id, $name='')
    {

    }

    /**
     * @RequestMapping("/demo/view")
     */
    public function viewAction()
    {

    }

    /**
     *
     */
    public function getNameAction()
    {
        return $this->user->getName();
    }
}