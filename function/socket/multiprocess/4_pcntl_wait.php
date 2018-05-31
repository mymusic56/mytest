<?php
$ppid = posix_getpid(); // 记录父进程的进程号

for ($i = 0; $i < 10; $i ++) {
    $pid = pcntl_fork();
    if ($pid == 0) {
        break; // 由于子进程也会执行循环的代码，所以让子进程退出循环
    }
}
if ($ppid == posix_getpid()) {
    // 父进程循环回收收子进程
    while (($id = pcntl_wait($status)) > 0) // 如果没有子进程退出, pcntl_wait 会一直阻塞
    {
        echo "回收子进程：$id, 子进程退出状态值: $status...\n";
    }
    
    exit("父进程退出 $id....\n"); // 当子进程全部结束 pcntl_wait 返回-1
} else {
    // 子进程退出,会成为僵尸进程
    sleep($i);
    exit($i);
}