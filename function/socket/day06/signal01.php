<?php

/**
 * 进程信号
 * 用户自定义信息
 */

declare(ticks = 1);

pcntl_signal(SIGUSR1, function ($signal) {
    $pid = posix_getpid();
    echo "PID:{$pid}, HANDLE SIGNAL $signal\r\n";
    if ($signal == SIGUSR1) {
        /*
         * 1.向进程发送指令后，会被pcntl_wait接收
         * 2.处理后没有继续执行接下来的代码？？？
         */
        echo "KILL PID:{$pid}\r\n";
        $flag = posix_kill($pid, SIGKILL);

        echo "KILL PID:{$pid} : $flag \r\n";
    }
});

function fork($num)
{
    for ($i =1 ; $i <=$num; $i++) {

        $pid = pcntl_fork();
        if ($pid===0) {
            $a = 1;
            $pid = posix_getpid();
            echo "PID: $pid start.\r\n";
            while (true) {
                $a++;
                sleep(3);
                echo "PID: $pid $a\r\n";
            }
        }
    }
}

fork(2);

for ($i =1 ; $i <=3; $i++) {

    $pid = pcntl_wait($status);
    echo "进程结束：$pid \r\n";

    pcntl_signal_dispatch();
    //重新创建进程

    echo "重新创建进程 \r\n";
    fork(1);
}

//kill -10 pid

?>


