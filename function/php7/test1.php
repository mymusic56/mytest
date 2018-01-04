<?php
// declare(strict_types = 1);

/**
 * http://www.runoob.com/php/php7-new-features.html
 * http://php.net/manual/zh/migration70.new-features.php
 */

function foo($a): int
{
    return $a;
}

function sumOfInts(int ...$ints)
{
    return array_sum($ints);
}

#NULL 合并运算符
$a = $_GET['a'] ?? 1;

var_dump($a, $_GET['b']);

var_dump(sumOfInts(2, '3', 4.1)); 

var_dump(foo(1.0)); 