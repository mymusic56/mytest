<?php


class OutputFactory
{
    public static function build($class)
    {
        $strategy = null;
        if (class_exists($class)) {
            $strategy = new $class();
            return $strategy;
        }
        throw new Exception($class.' not found.');
    }
}