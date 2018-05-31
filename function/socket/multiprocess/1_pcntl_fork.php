<?php

// 记录父进程pid
$ppid = posix_getpid();

// var_dump($ppid);

for ($i = 0; $i < 5; $i ++) {
    $pid = pcntl_fork(); // 创建子进程，子进程也是从这里开始执行。不同的是父进程执行过程中，得到的fork返回值为子进程号，而子进程得到的是0。
    
//     var_dump($pid);
    
    if ($pid == 0) {
        break; // 由于子进程也会执行循环的代码，所以让子进程退出循环，否则子进程又会创建自己的子进程。
    }
}

sleep($i + 2);  //第一个创建的子进程将睡眠0秒，第二个将睡眠1s，依次类推...主进程会睡眠5秒

if ($i < 5)
{
    exit("第 " . ($i+1) . " 个子进程退出..." . time() . PHP_EOL);
}
else
{
    exit("父进程退出..." . time() . PHP_EOL);
}

// while(1)
// {
//     sleep(1);       //执行死循环不退出
// }


// if ($ppid == posix_getpid()) { //父进程
//     while (1) {
//         sleep(1); // 执行死循环不退出
//     }
// } else {
//     exit("第 " . ($i+1) . " 个子进程".posix_getpid()."退出..." . time() . PHP_EOL);
// }

