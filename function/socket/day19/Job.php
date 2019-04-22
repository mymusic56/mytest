<?php

require_once 'worker_server.php';
/**
 * Date: 2019/4/18
 * Time: 9:59
 *
 * 1. 杀死空闲进程的时候： 恰巧这时候该进程又获取到新的任务怎么处理？
 *      1)通知worker进程不能再获取新的任务， 进程间通信
 * 2. manager进程监控主进程是否退出： 但是使用swoole http server, 系统处于挂起状态，无法处理
 * 3. manager进程启动http server显得有点多余， 为什么不将任务直接写入队列，worker进程直接从队列中获取任务？
 * 4. 还看到网上有 这样处理： 主进程负责创建子进程，读取队列中的任务，通过管道再将任务发给子进程。 为什么不直接让子进程读取队列中的任务？
 */
class Job
{
    private $redis;
    private $min_worker_num = 2;
    private $max_worker_num = 4;
    private $manager_num = 1;
    private $master_pid ;

    private $process_name_template = 'php-job :%s';

    /**
     * @var $table swoole_table
     */
    private $taskWorkerTable;//任务进程表，记录进程空闲状态

    private $key_msg_queue = 'queue:task';

    public function __construct()
    {
        $this->master_pid = posix_getpid();
    }

    public function run()
    {
        swoole_set_process_name('php-job: master');
        $this->createTable();//需要在创建子进程之前创建
        $this->createManager();
        for ($i=1; $i <= $this->min_worker_num; $i++) {
            $this->createWorker();
        }

        $this->monitor();
    }

    private function createManager()
    {
        $process = new swoole_process(function (swoole_process $worker) {
            $this->checkMasterExist($worker->pid);
            swoole_set_process_name('php-job : manager');
            //创建tcp客户端
            $server = new HttpServer('0.0.0.0', 9501);
            $server->set([
                'worker_num' => $this->manager_num
            ]);
            $server->onRequest = function (swoole_http_request $request, swoole_http_response $response) {
                $post = $request->get;
                if ($post) {
                    $redis = $this->getRedisClient();
                    echo "接收到任务： ".json_encode($post).PHP_EOL;
                    $redis->lPush($this->key_msg_queue, json_encode($post));
                    $response->header('ContentType', 'application/json');
                    $response->end('{"status":1}');
                }
            };
            $server->start();
        });
        $process->start();
    }

    /**
     * 在工作进程中应当监听SIGTERM信号，当主进程需要终止该进程时，会向此进程发送SIGTERM信号。
     * 如果工作进程未监听SIGTERM信号，底层会强行终止当前进程，造成部分逻辑丢失。
     * @return int
     */
    private function createWorker()
    {
        $process = new swoole_process(function (swoole_process $worker) {

            swoole_set_process_name('php-job : worker');
            $redis = $this->getRedisClient();
            $running = true;

            /*为什么在这里注册的信号无效？？？？*/
            swoole_process::signal(SIGTERM, function () use (&$running) {
                var_dump("任务结束11");
                $running = false;
            });
            while ($running) {
                $msg = $redis->brPop([$this->key_msg_queue], 30);
                pcntl_signal_dispatch();
                if ($msg) {
                    echo "处理任务: PID: {$worker->pid}, msg: ".$msg[1].PHP_EOL;
                    $this->taskWorkerTable->set($worker->pid, ['idel' => 0]);
                    /**
                     * 睡眠模拟任务耗时
                     */

                    sleep(10);
                    $this->taskWorkerTable->set($worker->pid, ['idel' => 1]);
                }
            }

            var_dump("任务结束22222");
            $worker->exit(0);
        });

        $process->start();
        $this->taskWorkerTable->set($process->pid, [
            'pid' => $process->pid,
            'idel' => 1
        ]);

        echo "创建worker进程, PID: {$process->pid}".PHP_EOL;
        return $process->pid;
    }

    private function createTable()
    {
        $this->taskWorkerTable = new swoole_table(1024);
        $this->taskWorkerTable->column('pid', swoole_table::TYPE_INT);
        $this->taskWorkerTable->column('idel', swoole_table::TYPE_INT);
        $this->taskWorkerTable->create();
    }

    private function monitor()
    {
        //通过信号创建worker进程
        swoole_process::signal(SIGRTMIN+1, function ($signo) {
            $pid = $this->createWorker();
            echo "创建worker进程, PID: {$pid}".PHP_EOL;
        });

        //子进程终止给父进程发送的信号
        swoole_process::signal(SIGCHLD, function ($signo) {
            while ($res = swoole_process::wait(false)){
                var_dump('回收子进程', $res);
                if ($this->taskWorkerTable->exist($res['pid'])) {
                    $this->taskWorkerTable->del($res['pid']);
                }
            }
        });

        //定时检测是否需要创建新的worker进程
        //使用定时器之后，回收子进程可以设置为非阻塞， 让定时器来实现进程挂起的功能
        $redis = $this->getRedisClient();
        swoole_timer_tick(1000, function ($timer_id) use ($redis) {
            $taskCount = $redis->lLen($this->key_msg_queue);
            echo "任务数量： {$taskCount}， worker进程数量：".$this->taskWorkerTable->count().PHP_EOL;
            if ($taskCount > $this->min_worker_num && $this->taskWorkerTable->count() < $this->max_worker_num) {
                //发送自定义信号
                swoole_process::kill($this->master_pid, SIGRTMIN+1);
            }

            if ($this->taskWorkerTable->count() < $this->min_worker_num) {
                swoole_process::kill($this->master_pid, SIGRTMIN+1);
            }
        });


        /*
         * 自动回收空闲进程
         * 1. 任务数量小于设置值时
         * 2. 进程空闲
         */
        swoole_timer_tick(1000, function () use ($redis) {
            $taskCount = $redis->lLen($this->key_msg_queue);
            if ($taskCount < 10) {
                foreach ($this->taskWorkerTable as $k => $task) {
                    if ($task['idel'] == 1 && $this->taskWorkerTable->count() > $this->min_worker_num) {
                        swoole_process::kill($k, SIGTERM);
//                        posix_kill($k, SIGKILL);
                        $this->taskWorkerTable->del($k);
                        echo "回收空闲进程： worker pid: $k".PHP_EOL;
                    }
                }

            }
        });

        //回收子进程
        while ($res = swoole_process::wait(false)) {
            var_dump($res);
        }
    }

    /**
     *
     * @return Redis
     */
    private function getRedisClient()
    {
        $retryLimit = 3;
        $reties = 0;
        retry_redis:
        try {
            $redis = new Redis();
            $redis->connect('127.0.0.1', 6379);
            $redis->auth('123456');
            $redis->select(0);
        } catch (\Exception $e) {
            sleep(1);
            if ($reties <= $retryLimit) {
                $reties++;
                echo "尝试重新连接Redis {$reties}次\r\n";
                goto retry_redis;
            }
            echo "Redis连接失败\r\n";
        }
        return $redis;
    }

    /**
     * 检查master进程是否退出
     * master进程中启动HTTPserver后处于挂起状态， 定时器不能生效
     */
    public function checkMasterExist($manager_pid)
    {
        $redis = $this->getRedisClient();
        swoole_timer_tick(1000, function () use ($redis, $manager_pid) {
            //主进程退出
            if (!swoole_process::kill($this->master_pid, 0)) {
                foreach ($this->taskWorkerTable as $k => $task) {
                    if ($task['idel'] == 1) {
                        swoole_process::kill($k, SIGKILL);
                    }
                }
                //worker进程退出了，manager进程也退出
                if ($this->taskWorkerTable->count() == 0) {
                    swoole_process::kill($manager_pid, SIGKILL);
                }
            } else {
                var_dump('OOOO: '.$manager_pid);
            }
        });
    }
}

$job = new Job();
$job->run();