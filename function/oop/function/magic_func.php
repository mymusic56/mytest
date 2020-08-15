<?php
/**
 * Created by PhpStorm.
 * User: zhangshengji
 * Date: 2020/3/3 0003
 * Time: 0:12
 */

class Test
{
    public static function aa()
    {
        var_dump('Test::aa');
    }

    public static function __callStatic(string $method, array $arguments)
    {
        var_dump("__calStatic");
        var_dump($method, $arguments);
        self::aa();
    }

    public function bb()
    {
        var_dump('bb');
    }

    public function __call($name, $arguments)
    {
        var_dump($name, $arguments);
    }
}
Test::cc();
$test = new Test();
$test->dd();