<?php

$a ?? $a = 10;
var_dump($a);
$a = [
    'name' => 'eee',
    'age' => 1,
    'data' => new \ArrayObject()
];
$b = json_encode($a);
echo $b;