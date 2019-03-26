<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/3/26
 * Time: 23:53
 */

namespace Swoft;


class Config
{
    private static $map;

    public static function get($name)
    {
        $value = isset(self::$map[$name]) ? self::$map[$name]: false;
        return $value;
    }

    public static function set($name, $value)
    {
        self::$map[$name] = $value;
    }

    public static function load($path='')
    {

    }
}