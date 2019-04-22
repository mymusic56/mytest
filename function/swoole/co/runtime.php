<?php
$t1 = time();
\Swoole\Runtime::enableCoroutine(true, SWOOLE_HOOK_SLEEP);
$chan = new Chan();
go(function () use ($chan) {
    sleep(3);
    $chan->push('1234');
});


go(function () use ($chan, $t1) {
    sleep(3);
    $data = $chan->pop();
    var_dump($data, time()- $t1);
});