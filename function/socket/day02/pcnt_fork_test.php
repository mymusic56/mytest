<?php

class PcntlTest
{
    public function start()
    {
        $this->fork(3);
    }

    public function fork($num)
    {
        for ($i= 1; $i <= $num; $i++) {
            $pid = pcntl_fork();
            if ($pid) {
                $this->output("启动子进程：{$pid}");
            } elseif ($pid === 0) {
                $this->deal();
                exit;
            } else {
                $this->output("创建子进程：error");
            }
        }

        for ($i = 1; $i <= $num; $i++) {
            $pid = pcntl_wait($status);
            $this->output("子进程: {$pid}退出");
        }
        $this->output("程序结束");
    }

    private function output($msg)
    {
        echo "$msg\r\n";
    }

    private function deal()
    {
        $a =1;
        while (true) {
            $a++;
            $pid = posix_getpid();
            $this->output("PID: {$pid}, a={$a}");
            sleep(5);
        }
    }
}

$st = new PcntlTest();
$st->start();


