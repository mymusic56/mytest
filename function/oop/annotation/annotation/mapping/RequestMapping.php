<?php
namespace annotation\annotation\mapping;

use Doctrine\Common\Annotations\Annotation\Required;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Class Methord
 * @package annotation\annotation\mapping
 * @Annotation
 * @Target("METHOD")
 */
class RequestMapping
{
    /**
     * Action routing path
     *
     * @var string
     * @Required()
     */
    private $route = '';

    /**
     * Routing supported HTTP method set
     *
     * @var array
     */
    private $method = ['GET', 'POST'];

    /**
     * Routing path params binding. eg. {"id"="\d+"}
     *
     * @var array
     */
    private $params = [];

    /**
     * RequestMapping constructor.
     *
     * @param array $values
     */
    public function __construct(array $values)
    {
        if (isset($values['value'])) {
            $this->route = (string)$values['value'];
        } elseif (isset($values['route'])) {
            $this->route = (string)$values['route'];
        }

        if (isset($values['method'])) {
            $this->method = (array)$values['method'];
        }

        if (isset($values['params'])) {
            $this->params = (array)$values['params'];
        }
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @return array
     */
    public function getMethod(): array
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}