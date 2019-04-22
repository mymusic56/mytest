<?php

/**
 * generator::send()
 * Value to send into the generator.
 * This value will be the return value of the yield expression the generator is currently at.
 * 将值设置到迭代器，这个将会作为 迭代器当前所在位置的yield表达式的返回值
 *
 * 没明白这个执行流程？？？？？？？？？？
 *
 * @return Generator
 */
function gen()
{
    $a = (yield '111');
    var_dump("a: ".$a,yield, '***********' );
    yield 'foo';
    var_dump(yield, '+++++++++++==' );
    yield 'bar';
}

$gen = gen();
var_dump("key: {$gen->key()}".',current: '.$gen->current(), '----------');


$a = $gen->send('something');
var_dump("send return :".$a);
var_dump("key: {$gen->key()}".',current: '.$gen->current(), '----------');


$a = $gen->send('something');
var_dump("send return :".$a);
var_dump("key: {$gen->key()}".',current: '.$gen->current(), '----------');


$a = $gen->send('something');
var_dump("send return :".$a);
var_dump("key: {$gen->key()}".',current: '.$gen->current(), '----------');


$a = $gen->send('something');
var_dump("send return :".$a);


// 如之前提到的在send之前, 当$gen迭代器被创建的时候一个renwind()方法已经被隐式调用
// 所以实际上发生的应该类似:
//$gen->rewind();
//var_dump($gen->send('something'));

//这样renwind的执行将会导致第一个yield被执行, 并且忽略了他的返回值.
//真正当我们调用yield的时候, 我们得到的是第二个yield的值! 导致第一个yield的值被忽略.