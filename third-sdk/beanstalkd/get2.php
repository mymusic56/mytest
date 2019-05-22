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

//测试自动release
sleep(10);
die("....");
