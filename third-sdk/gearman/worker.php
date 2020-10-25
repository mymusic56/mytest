<?php
/**
 * Created by PhpStorm.
 * User: zhangshengji
 * Date: 2020/8/22 0022
 * Time: 14:51
 */

/**
 * @param $job GearmanJob
 * @return mixed
 */
function callback($job)
{
    $res = strrev($job->workload());
    var_dump($res);
    var_dump($job->unique(), $job->handle());
    return $res;
}

class Worker
{
    /**
     * @param $job GearmanJob
     * @return mixed
     */
    function call($job)
    {
        $res = strrev($job->workload());
        var_dump($res);
        var_dump($job->unique(), $job->handle());
        return $res;
    }
}

$worker = new GearmanWorker();
$worker->addServer('gearmand');
//方法一：
//$worker->addFunction("reverse", 'callback');
//方法二：
$worker->addFunction("reverse", 'Worker::call');
while ($worker->work());