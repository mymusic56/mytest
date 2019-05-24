<?php

class Container
{
    public static function getClass($className)
    {
        $ref = new ReflectionClass($className);
        if ($ref->isInstantiable()) {
            $refObj = $ref->newInstance();
            $propertys = $ref->getProperties();
            foreach ($propertys as $property) {
                $doc = $property->getDocComment();
                //匹配自动注入注解
                preg_match('/@Autowired\(\"(.*)\"\)/', $doc, $match);
                if ($match) {
                    $pro = new ReflectionClass($match[1]);
                    $property->setValue($refObj, $pro->newInstance());
                }
            }
            return $refObj;
        }
        return null;
    }

}