<?php
for ($i = 0; $i < 3; $i ++) {
    $pid = pcntl_fork();
    
    if ($pid == 0) {
        echo "子进程pid = " . posix_getpid() . PHP_EOL;
        $ret = pcntl_exec('/bin/ls'); // 执行 ls 命令, 此处调用成功子进程将不会再回来执行下面的任何代码
        var_dump($ret); // 此处的代码不会再执行
    }
}

sleep(5); // 睡眠5秒以确保子进程执行完毕,原因后面会说

exit("主进程退出...\n");