<?php

/**
 * Generator:rewind()
 * Generator:send()
 *
 * @return  Generator
 */
function gen3()
{
    echo "test\n";
    echo (yield 1) . "I\n";
    echo (yield 2) . "II\n";
    echo (yield 3 + 1) . "III\n";

//    yield 1;
//    yield 2;
//    yield 3 + 1;
}
//
//$gen = gen3();
//foreach ($gen as $key => $value) {
//    echo "{$key} - {$value}\n";
//}

var_dump('--------------');

$gen = gen3();
$gen->rewind();
echo $gen->key().' - '.$gen->current()."\n";
echo $gen->send("send value - ")."\n";
echo $gen->key().' - '.$gen->current()."\n";
