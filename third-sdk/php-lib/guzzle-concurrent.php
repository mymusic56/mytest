<?php
use GuzzleHttp\Client;
use GuzzleHttp\Promise;

/**
 * 并发请求
 * 中文文档： http://guzzle-cn.readthedocs.io/zh_CN/latest/quickstart.html#id5
 * 实现原理，参考：https://segmentfault.com/p/1210000010203531/read
 */

require '../vendor/autoload.php';
$t1 = microtime(true);
$client = new Client(['base_uri' => 'http://rec.qm.com/']);

$promises = [
    'test1' => $client->getAsync('/test/echoTime'),
    'test2' => $client->getAsync('/test/echoTime'),
    'test3' => $client->getAsync('/test/echoTime'),
    'test4' => $client->getAsync('/test/echoTime'),
];

$results =  Promise\unwrap($promises);

foreach ($results as $key => $item) {
    echo 'body:'.$item->getBody().'<br>';
}

var_dump(microtime(true) - $t1);