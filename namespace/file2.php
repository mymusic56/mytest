<?php
/**
 * 命名空间
 * 应用场景：
 * 	由于业务需要， 需要在file2.php中引入file1.php， 但是两个文件有相同名称的方法、类、常量
 * 如何实现？
 */
namespace Foo\Bar;
include 'file1.php';

const FOO = 2;
function foo() {}
class foo
{
	static function staticmethod() {}
}

/* 非限定名称 */
foo(); // 解析为 Foo\Bar\foo resolves to function Foo\Bar\foo
foo::staticmethod(); // 解析为类 Foo\Bar\foo的静态方法staticmethod。resolves to class Foo\Bar\foo, method staticmethod
var_dump(FOO) ; // resolves to constant Foo\Bar\FOO


/* 限定名称 */
Abc\foo(); // 解析为函数 Foo\Bar\Abc\foo
Abc\foo::staticmethod(); // 解析为类 Foo\Bar\Abc\foo,
// 以及类的方法 staticmethod
var_dump(Abc\FOO); // 解析为常量 Foo\Bar\Abc\FOO

/* 完全限定名称 */
\Foo\Bar\foo(); // 解析为函数 Foo\Bar\foo
\Foo\Bar\foo::staticmethod(); // 解析为类 Foo\Bar\foo, 以及类的方法 staticmethod
var_dump(\Foo\Bar\FOO); // 解析为常量 Foo\Bar\FOO
?>