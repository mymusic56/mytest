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
    public $watch_decriptor;

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
        foreach ($this->includeFile as $file) {
            $this->watch_decriptor = inotify_add_watch($this->watch_fd, './', $this->my_event);//watch descriptor
        }
    }

    public function getIncludeFile()
    {
        //递归遍历获取目录
        $this->includeFile[] = $this->watchFile;
    }

    public function watch()
    {
        while ($event_list = inotify_read($this->watch_fd)) {
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
        }
    }

    public function unWatch()
    {
        $this->writeLog("移除文件状态监听事件");
        inotify_rm_watch($this->watch_fd, $this->watch_decriptor);
    }

    private function writeLog($msg)
    {
        echo "$msg\r\n";
    }
}

