<?php
require_once '../../vendor/autoload.php';
$talk = new \Pheanstalk\Pheanstalk('127.0.0.1', 11300, 60);
$state = $talk->getConnection()->isServiceListening();
if (!$state) {
    throw new Exception('连接失败');
}
$order = ['id' => 1, 'order_no' => date('YmdHis')];
$order = json_encode($order);

$combo = json_encode(['id' => 2, 'combo' => '商品名称']);
/*
 * 管道--》队列名称
 * priority: 权重， 值越大优先执行
 * delay: 延迟时间
 * ttr: 处理时间，超过这个时间，会自动release，重新放回队列
 *      对比Redis，一定程度上可以防止数据丢失
 */
$flag = $talk->useTube('orders')->put($order, 1000, 30, 10);
var_dump($flag);

//会优先执行
$flag = $talk->useTube('combo')->put($combo, 1024, 32, 10);
var_dump($flag);