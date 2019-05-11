<?php
Swoole\Runtime::enableCoroutine(true);
$t1 = time();
//这里需要指定通道容量，默认通道容量为1，当通道容量不足的时候会阻塞
$chan = new Chan(10);
go(function () use($chan) {
    $chan->push("1111");
    echo "1 ";
    $chan->push("1111");
    echo "1 ";
    $a = $chan->pop();
    echo "1 ";
    var_dump($a);
});

//go(function () use ($chan) {
//    sleep(3);
//    $chan->push('1234');
//});
//
//
//go(function () use ($chan, $t1) {
//    sleep(3);
//    $data = $chan->pop();
//    var_dump($data, time()- $t1);
//});


