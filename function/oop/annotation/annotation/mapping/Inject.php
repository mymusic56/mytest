<?php
/**
 * DateTime: 2020/8/25 17:45
 * @author: zhangshengji
 */

namespace annotation\annotation\mapping;

use Doctrine\Common\Annotations\Annotation\Attribute;
use Doctrine\Common\Annotations\Annotation\Attributes;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * Class Inject
 * @package annotation\annotation\mapping
 * @Annotation
 * @Target("PROPERTY")
 */
class Inject
{
    /**
     * @var string
     */
    private $name = '';

    public function __construct(array $values)
    {
        if (isset($values['name']) && $values['name']) {
            $this->name = $values['name'];
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


}