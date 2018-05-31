<?php
/**
 * 子进程退出，父进程没有接收到子进程退出信号就会成为僵尸进程， 直到主进程退出，僵尸进程才会从进程列表中删除
 */

$ppid = posix_getpid();
for ($i = 0; $i < 3; $i++){
    $pid = pcntl_fork();
    if ($pid == 0) {
        break;
    }
}

if (posix_getpid() == $ppid) {
    //父进程不退出
    for(;;){
        sleep(1);
    }
} else {
    exit("子进程pid=".posix_getpid().'退出'.PHP_EOL);    
}

