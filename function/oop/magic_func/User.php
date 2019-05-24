<?php
/**
 * Created by PhpStorm.
 * User: zhangshengji
 * Date: 2019/2/14
 * Time: 22:08
 */

class User
{
    public $name;
    public $age;
    public $gender;

    public function info()
    {
        return "User::info()";
    }

    public function __call($name, $arguments)
    {
        echo "方法: $name 不存在" . PHP_EOL;
    }

    public static function __callStatic($name, $arguments)
    {
        echo "静态方法: $name 不存在" . PHP_EOL;
    }

    public function __construct($name, $age, $gender)
    {
        echo "__construct()" . PHP_EOL;
        $this->name = $name;
        $this->age = $age;
        $this->gender = $gender;
    }

    public function __destruct()
    {
        echo "__distruct()" . PHP_EOL;
    }

    /**
     * 返回需要序列化的属性
     * @return array
     */
    public function __sleep()
    {
        echo "__sleep()" . PHP_EOL;
        return ['name', 'age', 'gender'];
    }

    /**
     * 反序列化会使用
     */
    public function __wakeup()
    {
        echo "__wakeup()" . PHP_EOL;
    }

}