<?php
/**
 * 1. 包含yield关键字的函数会返回一个迭代器
 * 2. 函数内部执行： 每次遍历对象，如果有多个yield表达式，从本次迭代代码执行的位置开始，
 *     遇到第一个yield表达式结束本次迭代，将yield表达式的值返回，并作为下一次迭代代码执行起始位置
 * 3. generate::key()的值为yield出现的次数（关联数组的索引），generate::current()为yield表达式的值（关联数组的值）
 * 4. 迭代器遍历流程：（参考Number）
 *      1）第一次迭代： rewind() --> valid() --> key(), current()
 *      2）除第一次后的每次遍历迭代器： next() --> valid() --> key(), current()
 *
 * @return Generator
 */
function gen1()
{
    yield '22' => 'eee';
    echo "i\n";
    yield 2;
    yield 3 + 1;
}

$gen = gen1();
$i = 0;
foreach ($gen as $key => $value) {
    $i++;
    echo "循环第{$i}次\n";
    echo "{$key} - {$value} -{$gen->key()} - {$gen->current()}\n";
}

//[root@localhost-129 iterator]# php test02.php
//循环第1次
//22 - eee -22 - eee
//i
//循环第2次
//0 - 2 -0 - 2
//循环第3次
//1 - 4 -1 - 4

var_dump("------------");

$gen = gen1();
$i = 0;
foreach ($gen as $key => $value) {
    $i++;
    echo "循环第{$i}次\n";
    echo "{$key} - {$value} -{$gen->key()} - {$gen->current()}\n";
    if ($i==1) {
        break;
    }
}
$gen->next();

