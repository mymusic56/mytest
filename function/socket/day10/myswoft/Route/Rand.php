<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/4/2
 * Time: 21:13
 */

class Rand
{

    private static $index = 0;

    public static function randServer($list)
    {
        $index = self::$index;
        $count = count($list);
        if ($index >= $count - 1) {
            self::$index = 0;
        } else {
            self::$index = $index+1;
        }
        return $list[$index];
    }
}