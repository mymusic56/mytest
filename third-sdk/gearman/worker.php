<?php
/**
 * Created by PhpStorm.
 * User: zhangshengji
 * Date: 2020/8/22 0022
 * Time: 14:51
 */
require "../mysql/mysql.php";

$gmworker = new \GearmanWorker();
$gmworker->addServer("gearmand", 4730);
//方法一：
$gmworker->addFunction("title", "title_function");
//方法二：
$gmworker->addFunction("title2", 'Worker::title_function');

print "Waiting for job...\n";
while($gmworker->work())
{
    if ($gmworker->returnCode() != GEARMAN_SUCCESS)
    {
        echo "return_code: " . $gmworker->returnCode() . "\n";
        break;
    }
    var_dump($gmworker->returnCode(). ', '.$gmworker->error());
}

/**
 * @param GearmanJob $job
 * @return false|string
 */
function title_function($job)
{

    $data = json_decode($job->workload(), true);
    var_dump($data['id']);
    var_dump($data['user_id']);
    $pdo = createPDOBy();
    $statement = $pdo->prepare("select * from users where id={$data['user_id']}");
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_OBJ);
    if ($result) {
        var_dump($result->name);
    } else {
        var_dump('不存在');
    }

    for ($i = 1; $i <= 1; $i ++) {
        try {
            sleep(1);
            echo "sleep $i, ";
            $info = $pdo->getAttribute(PDO::ATTR_SERVER_INFO);
            if ($info === false) {
                throw new \LogicException('数据库连接失败');
                return;
            }
            $statement = $pdo->prepare("select * from users where id=2");
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                var_dump($result['name']);
            } else {
                var_dump('不存在');
            }
        } catch (\Exception $e) {
            var_dump('----------------------------');
            var_dump($e->getMessage());
            $pdo = createPDOBy();
            $info = $pdo->getAttribute(PDO::ATTR_SERVER_INFO);
            var_dump($info);
            var_dump('----------------------------');
        }
    }
//    $data = json_decode($job->workload(), true);
//    return json_encode(['status' => 1, 'msg' => $data['username']], JSON_UNESCAPED_UNICODE);
}

class Worker
{
    /**
     * @param $job GearmanJob
     * @return mixed
     */
    function title_function($job)
    {
        $res = strrev($job->workload());
        var_dump($res);
        var_dump($job->unique(), $job->handle());
        return $res;
    }
}