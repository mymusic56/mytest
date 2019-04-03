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
    private static $config = [];

    public static function get($name)
    {
        if (strpos($name, '.') !== false) {
            list($model, $key) = explode('.', $name);
            if (isset(self::$config[$model]) && isset(self::$config[$model][$key])) {
                return self::$config[$model][$key]??false;
            }
        }
        $value = isset(self::$config[$name]) ? self::$config[$name]: false;
        return $value;
    }

    public static function set($name, $value)
    {
        if (strpos($name, '.') !== false) {
            list($model, $key) = explode('.', $name);
            if (isset(self::$config[$model]) && isset(self::$config[$model][$key])) {
                self::$config[$model][$key] = $value;
            }
        }
        self::$config[$name] = $value;
    }

    public static function load($path='')
    {
        if (!$path) $path = CONF_PATH;
        if (is_dir($path)) {
            $files = glob($path.'/*.php');
            foreach ($files as $file) {
                self::$config += include $file;
            }
        } else {
            self::$config += include $path;
        }
    }
}