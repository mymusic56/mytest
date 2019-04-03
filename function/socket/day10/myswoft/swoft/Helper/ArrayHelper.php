<?php


namespace Swoft\Helper;


class ArrayHelper
{
    public static function getSplFixedArray($array)
    {
        $size = count($array);
        $splArr = new \SplFixedArray($size);

        foreach ($array as $key => $item) {
            $splArr[$key] = $item;
        }

        return $splArr;
    }
}