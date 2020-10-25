<?php
/**
 * Created by PhpStorm.
 * User: zhangshengji
 * Date: 2020/8/22 0022
 * Time: 14:51
 */

$client = new GearmanClient();
$client->addServers('gearmand:4730');
//同步
//print $client->doHigh("reverse", "Hello World!");
//普通异步任务
$job = $client->doBackground("reverse", "Hello World!]1[");
var_dump($job);

//优先级最低的异步任务
$job = $client->doLowBackground("reverse", "Hello World!]2[");
var_dump($job);

//优先级最高的异步任务
$unique = uniqid();//防止重复投递
$job = $client->doHighBackground("reverse", "Hello World!]3[", $unique);
var_dump($job);
$job = $client->doHighBackground("reverse", "Hello World!]3[", $unique);
var_dump($job);

//执行顺序： doHighBackground > doBackground > doLowBackground
//执行结果： 3 1 2

