<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/4/2
 * Time: 11:34
 */

//$cli = new \Swoole\Coroutine\Http\Client('192.168.152.128', 9800);
//$cli->upgrade("/");

glob('/*.php');
$a = [1,2,4,'222' => 1234];
$b = key($a);
var_dump($b);

require_once 'TestController.php';
$reflec = new ReflectionClass(TestController::class);
$data = $reflec->getDocComment();
var_dump($data);

preg_match('/@Route\((.*)\)/i', $data, $match);
var_dump($match);
preg_match('/@Rou(te)/i', $data, $match);
var_dump($match);
