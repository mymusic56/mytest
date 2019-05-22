<?php
require_once '../../vendor/autoload.php';
$talk = new \Pheanstalk\Pheanstalk('127.0.0.1', 11300, 60);
$state = $talk->getConnection()->isServiceListening();
if (!$state) {
    throw new Exception('连接失败');
}

//将combo队列中处于buried状态的任务唤醒
$flag = $talk->useTube('combo')->kick(10);
var_dump($flag);
