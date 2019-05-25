<?php
$t1 = microtime(true);
$redis = new Redis();
global $redis;
$redis->pconnect('127.0.0.1',6379);
$redis->auth('123456');
$res = $redis->rawCommand('cl.throttle','user10', 10, 10, 60, 1);
var_dump(microtime(true)- $t1, $res);

/**
 * @param $identifier
 * @param $action
 * @param int $limit
 * @param int $timeInterval
 * @return array
 *       $arr[0]: 状态，
 *       $arr[1]：漏斗容量，
 *       $arr[2]：漏斗剩余容量，
 *       $arr[3]：等待多长时间漏斗可以使用，
 *       $arr[4]：漏斗装满需要多长时间
 */
function rateLimitCheck($identifier, $action, $limit=10, $timeInterval=60)
{
    define('CURR_TIME', time());
    global  $redis;
    $key = 'RL:'.md5($identifier.$action);
    if (!($data = $redis->get($key))) {
        $data = json_encode([$limit, CURR_TIME]);
        $redis->set($key, $data, $timeInterval);
        return [1, $limit, $limit-1, -1, $timeInterval/$limit];
    }
    list($allow, $time) = json_decode($data, true);

    $allow += intval((CURR_TIME - $time)/($timeInterval/$limit));
    if ($allow > $limit) {
        $allow = $limit;
    }
    if ($allow < 1) {
        $redis->set($key, json_encode([0, $time]), $timeInterval);
        $key_2 = 'RLDAY:'.date('md').':'.$action;
        $redis->sAdd($key_2, $identifier);
        $redis->expire($key_2, 86400*7);
        $wait_time = $timeInterval/$limit - (CURR_TIME - $time);
        return [-1, $limit, 0, $wait_time, $limit*$timeInterval/$limit];
    }
    $redis->set($key, json_encode([$allow - 1, CURR_TIME]), $timeInterval);
    return [1, $limit, $allow-1, -1, ($limit - $allow+1)*$timeInterval/$limit];
}

$state = rateLimitCheck('user10', 'user/info');
var_dump($state);