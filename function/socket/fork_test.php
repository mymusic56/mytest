<?php
fwrite(STDOUT, "stat>" . PHP_EOL.PHP_EOL);

$count = 3;

for ($i = 0; $i < $count; $i++) {
    $pid = pcntl_fork();
    if($pid == -1) {
        fwrite(STDOUT, "Could not fork worker {$i}" . PHP_EOL);
        die();
    }
    else if(!$pid) {
        fun($i, $count);
        // 如果不使用下面的方式退出，将会出现什么呢，经测试，下面是我们得出的结果。
        // break;
        // exit;
    } else {
        fwrite(STDOUT, "父进程 " . $i . PHP_EOL);
    }
}


function fun($i, $count)
{
    // global $num;
    $num = $i;
    $jc = exec('echo $$');
    $time = date('Y-m-d H:i:s');
    fwrite(STDOUT, "进程：$jc  计数：$num - $count  时间：$time" . PHP_EOL);
    fwrite(STDOUT, "start > " . date('Y-m-d H:i:s') . PHP_EOL);
    fwrite(STDOUT, "~ 3s ~" . PHP_EOL);
    
    sleep(3);
    fwrite(STDOUT, "enddd $i < " . date('Y-m-d H:i:s') . PHP_EOL.PHP_EOL);
}