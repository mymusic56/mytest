<?php 
//zombieProcess.php
/**
 * 子进程死亡，如果未通知到主进程，就会成为僵尸进程，直到主进程结束，僵尸进程所占资源才会被回收。
 */

$pid = pcntl_fork();

if ($pid) {
    //父进程
    echo "This is parent process\n";
    sleep(30);
} elseif ($pid == 0) {
    //子进程
    echo "This is child process\n";
} else {
    die("fork failed\n");
}