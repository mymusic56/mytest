<?php
require 'redis.php';
$key = 'user_score';
$t1 = microtime(true);
var_dump($redis->zScore($key, 'user_id:'.mt_rand(1, 10000000)));
$t2 = microtime(true);
var_dump($t2- $t1);

//获取前多少名
var_dump($redis->zRange($key,10000000-30010, 10000000 -30000, 'withscores'));

$t3 = microtime(true);
var_dump($t3- $t2);

$redis->getDBNum();