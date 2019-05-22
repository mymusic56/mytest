<?php
namespace annotation\annotation\mapping;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class Controller
 * @package App\Annotation\Mapping
 * @Annotation
 * @Annotation\Target("CLASS")
 */
class ControllerMapping
{
    public $controllerName;
}