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

    /**
     * @var string
     * @Annotation\Required()
     */
    private $prefix = '';

    /**
     * Controller constructor.
     *
     * @param array $values
     */
    public function __construct(array $values)
    {
        if (isset($values['value'])) {
            $this->prefix = $values['value'];
        }
        if (isset($values['prefix'])) {
            $this->prefix = $values['prefix'];
        }
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }
}