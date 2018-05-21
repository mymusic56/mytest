<?php
require '../vendor/autoload.php';

$client = new \GuzzleHttp\Client();
$res = $client->request('GET', 'http://rec.qm.com/test/echoTime');
echo $res->getStatusCode().'\r\n';
// 200
var_dump('----');
echo $res->getHeaderLine('content-type');
// 'application/json; charset=utf8'
var_dump('----');
echo $res->getBody();
// '{"id": 1420053, "name": "guzzle", ...}'


$t1 = microtime(true);
// Send an asynchronous request.
$request = new \GuzzleHttp\Psr7\Request('GET', 'http://rec.qm.com/test/echoTime');
$promise = $client->sendAsync($request)->then(function ($response) {
    echo 'I completed! ' . $response->getBody();
});
$promise->wait();

var_dump(microtime(true) - $t1);