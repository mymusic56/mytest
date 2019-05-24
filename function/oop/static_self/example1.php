<?php

/**
 * @class A
 * @version:
 * @datetime: 2019/3/27 10:32
 * @description: 非静态环境调用static,
 *  1.static在被继承的父类中，首先会寻找调用者类中的方法。
 *      如果调用者的方法为private，不能访问私有方法
 *  2.$this
 *      如果调用者是公共方法，而被继承者是私有，优先访问被继承者的私有方法
 *      如果调用者和被调用者都是公共方法，优先访问调用者里面的方法
 * 所以： 访问当前类的方法， 用self
 *        要访问调用者自己的访问，用static
 *        $this , 最好同名方法，修饰符相同。private修饰符，等同于self，先访问当前类； public修饰符，先访问子类。
 */
class A {
    private function foo() {
        echo "class A success!  <br/>".PHP_EOL;
    }
    public function test() {
        $this->foo();
        self::foo();
        static::foo();
    }
}

class B extends A {
    /* foo() will be copied to B, hence its scope will still be A and
     * the call be successful */
}

class C extends A {
    public function foo() {
        echo "public! <br/>".PHP_EOL;
        /* original method is replaced; the scope of the new one is C */
    }
}
$b = new B();
$b->test();


var_dump("--------------------------------------");
$c = new C();
$c->test();   //fails