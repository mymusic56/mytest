<?php
/**
 * 通过挂载windows共享磁盘的inotify无法生效，无法监测到状态的改变？？？
 */
class FileInotify
{
    public $onEvents;

    public $watchFile;

    private $includeFile = [];

    public $watch_fd;

    private $events = [
//    IN_ACCESS => 'File Accessed',
        IN_MODIFY => 'File Modified',
//    IN_ATTRIB => 'File Metadata Modified',
//    IN_CLOSE_WRITE => 'File Closed, Opened for Writing',
//    IN_CLOSE_NOWRITE => 'File Closed, Opened for Read',
//    IN_OPEN => 'File Opened',
        IN_MOVED_TO => 'File Moved In',
        IN_MOVED_FROM => 'File Moved Out',
        IN_CREATE => 'File Created',
        IN_DELETE => 'File Deleted',
    ];

    private $my_event;
    public function __construct($file='')
    {

        if ($file && !file_exists($file)) {
            exit("{$file} 目录不存在\r\n");
        }
        if (!$file) {
            $file = './';
        }
        $this->watchFile = $file;
        echo "watching {$file} ...", PHP_EOL;

        $this->getIncludeFile();

        $this->my_event = array_sum(array_keys($this->events));
        $this->watch_fd = inotify_init();
    }

    public function getIncludeFile()
    {
        //递归遍历获取目录
        $this->includeFile[] = $this->watchFile;
    }

    public function watch()
    {
        foreach ($this->includeFile as $file) {
            $wd = inotify_add_watch($this->watch_fd, './', $this->my_event);//watch descriptor
        }

        swoole_event_add($this->watch_fd, function ($fd) {
            $event_list = inotify_read($fd);
            $this->writeLog(date('Y-m-d H:i:s'));
            foreach ($event_list as $arr) {
                $ev_mask = $arr['mask'];
                $ev_file = $arr['name'];
                if (isset($this->events[$ev_mask])) {
                    $this->writeLog("{$this->events[$ev_mask]} Filename: $ev_file");
                    if ($this->onEvents && is_callable($this->onEvents)) {
                        call_user_func($this->onEvents, $ev_mask);
                    }
                } else {
                    $this->writeLog("监听事件不存在: $ev_mask, $ev_file");
                }
            }
        });
//        inotify_rm_watch($init, $wd);
    }

    public function unWatch()
    {
        $this->writeLog("移除文件状态监听事件");
        swoole_event_del($this->watch_fd);
    }

    private function writeLog($msg)
    {
        echo "$msg\r\n";
    }
}

