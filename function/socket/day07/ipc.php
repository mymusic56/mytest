<?php
//ipcs  provides  information  on the inter-process communication facilities
// for which the calling process has read access.

//ipcs -a
$key = ftok(__DIR__, '1');
var_dump($key);
$src = msg_get_queue($key);

//$pid = pcntl_fork();
//if ($pid == 0) {
//    msg_send($src, 1, 'nihao.');
//    exit;
//} elseif ($pid > 0) {
    msg_receive($src, 1, $msgtype, 1024, $msg);
    msg_remove_queue($src);
    echo "$msg\r\n";
//    $pid = pcntl_wait($status);

//}

echo "结束\r\n";

/**
 *
[root@localhost-129 day07]# ipcs -a

------ Message Queues --------
key        msqid      owner      perms      used-bytes   messages
0x312f3d69 65536      root       666        0            0

------ Shared Memory Segments --------
key        shmid      owner      perms      bytes      nattch     status

------ Semaphore Arrays --------
key        semid      owner      perms      nsems

[root@localhost-129 day07]#
 */

