<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/4/2
 * Time: 22:04
 */

namespace Swoft\Helper;


class DirHelper
{
    /**
     * 将Dir进行格式化，以反斜杠结束
     * @param $dir
     * @return string
     */
    public static function formatDir($dir)
    {
        if (substr($dir, -1, 1) != '/') {
            return $dir.'/';
        }
        return $dir;
    }
}