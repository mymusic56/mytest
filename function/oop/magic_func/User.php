<?php
/**
 * Created by PhpStorm.
 * User: zhangshengji
 * Date: 2019/2/14
 * Time: 22:08
 */

class User
{
    /**
     * @var string
     */
    public $name;
    public $age;
    public $gender;

    public function info()
    {
        return "User::info()";
    }

    public function __invoke()
    {
        echo "User::__invoke()" . PHP_EOL;
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
        echo "User::__construct()" . PHP_EOL;
        $this->name = $name;
        $this->age = $age;
        $this->gender = $gender;
    }

    public function __destruct()
    {
        echo "User::__distruct()" . PHP_EOL;
    }

    /**
     * 返回需要序列化的属性
     * @return array
     */
    public function __sleep()
    {
        echo "User::__sleep()" . PHP_EOL;
        return ['name', 'age', 'gender'];
    }

    /**
     * 反序列化会使用
     */
    public function __wakeup()
    {
        echo "User::__wakeup()" . PHP_EOL;
    }

    public function __get($name)
    {
        echo "属性: $name 不存在" . PHP_EOL;
    }

    public function __set($name, $value)
    {
        echo "给不存在的属性: $name ， 赋值：$value" . PHP_EOL;
    }

    public function getName()
    {
        return $this->name;
    }

}