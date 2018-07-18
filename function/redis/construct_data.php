<?php
function constructData()
{
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);
    $redis->auth('P<zklv8HLIW1_ZCekEErly[MNw)YQh64');
    $redis->select(0);
    $count = 10000000;
    $key = 'user_score';
    $redis->del($key);
    for ($i = 1; $i <= $count; $i++) {
        $redis->zAdd($key, mt_rand(0, 10000), 'user_id:'.$i);
    }
    
    var_dump($redis->zCard($key));
    
}
$t1 = microtime(true);
constructData();

$t2 = microtime(true);

echo '耗时：'.($t2 - $t1);