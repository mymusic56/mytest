<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/4/19
 * Time: 13:23
 */

function task()
{
    $pid = posix_getpid();
//    echo "子进程: $pid\r\n";
    $running = true;

    pcntl_signal(SIGTERM, function () use (&$running) {
        $running = false;
        $pid = posix_getpid();
        echo "子进程结束信号：PID： {$pid}\r\n";
    });
    while ($running) {
        echo "PID: {$pid}, 开始任务\r\n";
        sleep(30);
        pcntl_signal_dispatch();
    }
    exit(0);
}

for ($i = 0; $i <= 3; $i++) {
    $pid = pcntl_fork();
    if ($pid === 0) {
        task();
    }
}


while ($pid = pcntl_wait($status)) {
    var_dump($pid);
}