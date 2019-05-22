<?php
require_once '../../vendor/autoload.php';
$talk = new \Pheanstalk\Pheanstalk('127.0.0.1', 11300, 60);
$state = $talk->getConnection()->isServiceListening();
if (!$state) {
    throw new Exception('连接失败');
}

//监听orders和combo两个管道
$job = $talk->watch('orders')->watch('combo')->ignore('default')->reserve();
var_dump($job->getId());
$data = $job->getData();
var_dump($data);
$deal_status = true;
if ($deal_status == false) {
    //重新将任务放回队列
    $talk->release($job);
}

//删除任务
$talk->delete($job);
