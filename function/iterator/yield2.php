<?php

file_put_contents(__DIR__ . '/log', '');
function logger($fileName) {
    $fileHandle = fopen($fileName, 'a');
    while (true) {
        fwrite($fileHandle, yield . "\n");
    }
}

$logger = logger(__DIR__ . '/log');
$logger->send('Foo');
$logger->send('Bar');

$str = file_get_contents(__DIR__ . '/log');
echo <<<EOF
$str
EOF
;
echo("----------------------- </br>");
/**
 * 当生成器第一次遇到yield时，会被当成类似变量，接收参数。当在此遇到yield时，会中断任务，把值返回给调用者
 * 
 * yield指令，是提供中断的一种方法
 * 
 * @return Generator
 */
function gen() {
    $ret = (yield 'yield1');
    var_dump('send1: '.$ret);
    $ret = (yield 'yield2');
    var_dump('send2: '.$ret);
    $ret = (yield 'yield3');
}

$gen = gen();
// var_dump($gen->current());    // string(6) "yield1"
echo("----------------------- </br>");
var_dump($gen->send('ret1')); // string(4) "ret1"   (the first var_dump in gen)
// string(6) "yield2" (the var_dump; of the ->send() return value)
var_dump($gen->send('ret2')); // string(4) "ret2"   (again from within gen)
// NULL               (the return value of ->send())

