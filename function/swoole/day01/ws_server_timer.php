<?php
/**
 * 测试：
 *  swoole_timer_tick
 *  swoole_timer_after
 */
class Ws{
    
    private $ws;
    public function __construct($host='0.0.0.0', $port=9502)
    {
        $this->ws = new swoole_websocket_server($host, $port);
        $this->ws->set([
            'worker_num' => 2,
            'task_worker_num' => 2,
            'enable_static_handler' => true,
            'document_root' => dirname(__FILE__).'/webroot',
        ]);

        $eventList = [
            'open', 'message', 'request', 'task', 'finish', 'close'
        ];
        foreach ($eventList as $event) {
            $this->ws->on($event, [$this, "on".ucfirst($event)]);
        }
    }
    
    /**
     * 
     * @param swoole_websocket_server $serv
     * @param \Swoole\Http\Request $request
     */
    public function onOpen($serv, $request)
    {
        echo "server: handshake success with fd{$request->fd}\n";
        
        //创建间隔时间执行的定时器
        if ($request->fd == 2) {
            $fd = $request->fd;
            //使用匿名函数的use方法传递参数到回调函数中，
            $id = swoole_timer_tick(2000, function($timerId) use ($fd){
                echo "sleep 2s,timerId:{$timerId},{$fd}";
            });
        }
    }
    
    /**
     * 
     * @param swoole_websocket_server $serv
     * @param swoole_websocket_frame $frame
     */
    public function onMessage($serv, $frame)
    {
        echo "receive from {$frame->fd}, data:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
        
        //执行耗时任务
        $data = [
            'task' => 'eeee',
            'test' => 1
        ];
        
        //$serv->task($data);
        
        //只执行一次
        swoole_timer_after(5000, function() use ($serv, $frame, $data){
            echo "timer_after, 5s:".json_encode($data)."\n";
            $serv->push($frame->fd, "server-timer-after:".json_encode($data));
        });
        
        $serv->push($frame->fd, "this is server");
    }
    
    /**
     * 
     * @param swoole_websocket_server $serv
     * @param int $taskId   $task_id和$src_worker_id组合起来才是全局唯一的，不同的worker进程投递的任务ID可能会有相同
     * @param int $workId   来自于哪个worker进程
     * @param mixed $data   任务的内容
     * @return string       在onTask函数中 return字符串，表示将此内容返回给worker进程。worker进程中会触发onFinish函数，表示投递的task已完成。
     * 1. task进程的onTask事件中没有调用finish方法或者return结果，worker进程不会触发onFinish
     * 2. 函数执行时遇到致命错误退出，或者被外部进程强制kill，当前的任务会被丢弃，但不会影响其他正在排队的Task
     */
    public function onTask($serv, $taskId, $workId, $data)
    {
        echo 'receive task, taskId:'.$taskId.', workId:'.$workId.",data:\n";
        var_dump($data);
        sleep(10);
        return 'deal task success';
    }
    
    /**
     * 
     * @param swoole_websocket_server $serv
     * @param int $taskId   任务ID
     * @param string $data  任务处理的结果内容
     * 1. task进程的onTask事件中没有调用finish方法或者return结果，worker进程不会触发onFinish
     * 2. 执行onFinish逻辑的worker进程与下发task任务的worker进程是同一个进程
     */
    public function onFinish($serv, $taskId, $data)
    {
        echo 'Task finished, taskId:'.$taskId.",return info:\n";
        var_dump($data);
    }
    /**
     * 
     * @param \Swoole\Http\Request $request
     * @param \Swoole\Http\Response $response
     */
    public function onRequest($request, $response)
    {
        $response->header('Content-Type', 'text/html;charset=utf-8');
        $response->end('<h1>页面丢失。。。</h1>');
    }
    
    /**
     * 
     * @param swoole_server $serv
     * @param int $fd
     * @param int $workId
     */
    public function onClose($serv, $fd, $workId)
    {
        echo "client-{$fd} is closed\n";
        //这里回调onClose时表示客户端连接已经关闭，所以无需执行$server->close($fd)。
        //代码中执行$serv->close($fd)会抛出PHP错误告警。
    }
    
    public function start()
    {
        $this->ws->start();
    }
    
}

$ws = new Ws();
$ws->start();