<?php
/**
 * 1. to use this extension, you must compile php with --enable-pcntl to support.
 * 2. pcntl_function only works fine in cli mode. in some php version, it will throw exception of undefined function error.
 */


$pid = pcntl_fork();

if ($pid) {
    //父进程
    echo "This is parent process\n";
    pcntl_waitpid($pid, $status);
//     sleep(30);

} elseif ($pid == 0) {
    //子进程
    echo "This is child process\n";
} else {
    die("fork failed\n");
}