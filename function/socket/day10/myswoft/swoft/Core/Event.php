<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/4/2
 * Time: 21:41
 */

namespace Swoft\Core;


use Swoft\Helper\DirHelper;
use Swoft\Log\Log;

class Event
{
    private static $events = [];

    public static function register($event, $callback)
    {
        $event = strtolower($event);
        self::$events[$event] = $callback;
    }

    public static function trigger($event, $param)
    {
        $event = strtolower($event);
        if (isset(self::$events[$event])) {
            call_user_func(self::$events[$event], $param);
            return true;
        }

        Log::wirte("$event 事件不存在");

        return false;
    }

    public static function collectEvent()
    {
        $path = [
            'Swoft\\Event'=> SWOFT_PATH.'/Event/',
            'App\\Listener' => APP_PATH.'/Listener',
        ];
        //APP内的事件会覆盖掉Swoft里面的事件
        foreach ($path as $namespace => $p) {
            $p = DirHelper::formatDir($p);
            $tmp = glob($p."*.php");
            foreach ($tmp as $classpath) {
                include $classpath;
                $clasname = basename($classpath, '.php');
                $class = $namespace.'\\'.$clasname;
                if (class_exists($class)) {
                    $obj = new $class();
                    $reflec =new \ReflectionClass($obj);
                    if ($reflec->isInterface()) {
                        continue;
                    }
                    $doc = $reflec->getDocComment();
                    if (!$doc) {
                        continue;
                    }
                    preg_match('/@Listener\((.*)\)/i', $doc, $match);
                    if ($match) {
                        self::$events[$match[1]] = [$obj, 'handler'];
                    }
                } else {
                    Log::wirte("class: $class 不存在");
                }
            }

        }
    }
}