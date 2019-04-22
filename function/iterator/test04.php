<?php
/**
 * @return  Generator
 */
function gen4()
{
    $id = 2;
    $id = yield $id;
    echo $id."\r\n";
}

$gen = gen4();
var_dump($gen->current());
$gen->send($gen->current() + 3);
var_dump($gen->current());
