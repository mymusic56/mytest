<?php

/**
 * 1. 对父进程的信号进行处理，实现子进程重启操作
 *  kill -10 $parentPid
 * 2. 单独一个进程监听文件是否被修改
 * Class SignalTest
 */
class SignalTest
{
    private $workerPids = [];
    private $workerNum = 3;
    private $masterPid;

    private $inotify;

    public function start()
    {
        //监控文件变化
        include 'inotify01.php';
        $this->inotify = new FileInotify();

        $pid = pcntl_fork();
        if ($pid == 0) {
            $this->masterPid = posix_getpid();
            $this->fork($this->workerNum);
            //只对父进程安装信号处理， 不会处理子进程的信号
            $this->monitorWorkers();
        }
        $this->inotify->onEvents = function ($ev_mask) use($pid) {
            //文件被修改，重启进程
            posix_kill($pid, SIGUSR1);
        };
        $this->inotify->watch();
    }

    public function monitorWorkers()
    {
        echo "安装信号处理器...\n";
        //注册信息好后，不会自动执行
        pcntl_signal(SIGUSR1, [$this, 'signalHandler'], false);
        //不能注册SIGKILL事件
//        pcntl_signal(SIGKILL, [$this, 'signalHandler'], false);
        pcntl_signal(SIGTERM, [$this, 'signalHandler'], false);
        //ctrl+c
        pcntl_signal(SIGINT, [$this, 'signalHandler'], false);

        while (true) {
            pcntl_signal_dispatch();
            //监听子进程状态
            $pid = pcntl_wait($status);

            //只要是被kill掉都是返回false
            $v = pcntl_wifexited($status) == false ? 0 : 1;
//            echo "pcntl_wait(): $pid, $v\r\n";

            //如何维护子进程数量？
            //向主进程reload信号，kill子进程时，也会监听到子进程退出，
            //这样无论何种原因的子进程退出，都会再次创建新的子进程，导致程序无法关闭
            //哪种情况才是正常退出？？
            //子进程ID列表里存在，表示异常退出
            $index = array_search($pid, $this->workerPids);
            if ($pid > 0 && $this->masterPid != $pid && $index !== false) {
                echo "子进程: {$pid} 意外退出，重新创建进程 \r\n";
                unset($this->workerPids[$index]);
                $this->fork(1);
            }

            if ($pid == 0) {
                break;
            }
            pcntl_signal_dispatch();
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
            case SIGKILL:
            case SIGINT:
            case SIGTERM:
                $this->stop();
                break;
            default:
                $this->output("信号{$signo}没有定义。");
                break;
        }
    }

    private function stop()
    {
        $this->output("关闭程序");
        $this->reload(false);
        //关闭文件监听
        $this->inotify->unWatch();
        posix_kill($this->masterPid, SIGKILL);
    }

    private function reload($reload=true)
    {
        foreach ($this->workerPids as $k => $pid) {
            $flag = posix_kill($pid, SIGKILL);
            if ($flag) {
                unset($this->workerPids[$k]);
                $this->output("关闭进程：{$pid}");
                if ($reload) {
                    $this->fork(1);
                }
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
//            $this->output("PID: {$pid}, a={$a}");
            sleep(5);
        }
    }
}

$st = new SignalTest();
$st->start();


