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
    public static function formatDir($dir)
    {
        if (substr($dir, -1, 1) != '/') {
            return $dir.'/';
        }
        return $dir;
    }
}