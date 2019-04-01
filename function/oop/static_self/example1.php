<?php

/**
 * @class A
 * @version:
 * @datetime: 2019/3/27 10:32
 * @description: 非静态环境调用static
 */
class A {
    private function foo() {
        echo "success!  <br/>";
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
    private function foo() {
        echo "public! <br/>";
        /* original method is replaced; the scope of the new one is C */
    }
}

$b = new B();
$b->test();
$c = new C();
$c->test();   //fails