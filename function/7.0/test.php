<?php
$a = $_GET['a'] ?? 1;
var_dump($a);

function foo($a): int
{
    return $a;
}

var_dump(foo(1.99));


function sumOfInts(int ...$ints)
{
    var_dump($ints);
    return array_sum($ints);
}

var_dump(sumOfInts(2, '3.3', 4.1));