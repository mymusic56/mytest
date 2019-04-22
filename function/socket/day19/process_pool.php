<?php
$workerNum = 10;
$pool = new Swoole\Process\Pool($workerNum);

$pool->on("WorkerStart", function ($pool, $workerId) {
    $running = true;
    pcntl_signal(SIGTERM, function () use (&$running) {
        var_dump("杀死进程");
        $running = false;
    });
    echo "Worker#{$workerId} is started\n";
    $redis = new Redis();
    $redis->pconnect('127.0.0.1', 6379);
    $redis->auth('123456');
    $key = "key1";
    while ($running) {
        try {
            $msgs = $redis->brpop($key, 10);
            pcntl_signal_dispatch();
            if ( $msgs == null) continue;
            var_dump($msgs);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
});

$pool->on("WorkerStop", function ($pool, $workerId) {
    echo "Worker#{$workerId} is stopped\n";
});

$pool->start();