<?php

class SignalTest
{
    private $workerPids = [];
    private $workerNum = 3;

    public function start()
    {
        $this->fork($this->workerNum);
        $this->monitorWorkers();
    }

    public function monitorWorkers()
    {
        echo "安装信号处理器...\n";
        pcntl_signal(SIGUSR1, [$this, 'signalHandler'], false);

        echo "分发...\n";
        pcntl_signal_dispatch();

        for ($i = 1; $i <= $this->workerNum; $i++) {
            $pid = pcntl_wait($status);
            $this->output("子进程: {$pid}退出");
        }
        $this->output("程序结束");
    }

    public function signalHandler($signo)
    {
        echo "信号处理器被调用\n";
        switch ($signo) {
            case SIGUSR1:
                $this->reload();
                break;
            default:
                $this->output("信号{$signo}没有定义。");
                break;
        }
    }

    private function reload()
    {
        foreach ($this->workerPids as $k => $pid) {

            $flag = posix_kill($pid, SIGKILL);
            if ($flag) {
                unset($this->workerPids[$k]);
                $this->output("关闭进程：{$pid}");
                $this->fork(1);
            } else {
                $this->output("关闭进程FAILED， PID：{$pid}");
            }
        }
    }

    public function fork($num)
    {
        for ($i= 1; $i <= $num; $i++) {
            $pid = pcntl_fork();
            if ($pid) {
                $this->workerPids[] = $pid;
                $this->output("启动子进程：{$pid}");
            } elseif ($pid === 0) {
                $this->deal();
                exit;
            } else {
                $this->output("创建子进程：error");
            }
        }
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

$st = new SignalTest();
$st->start();


