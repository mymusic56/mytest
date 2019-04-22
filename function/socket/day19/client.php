<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/4/18
 * Time: 18:16
 */


$client = new Swoole\Http\Client('www.runoob.com', 80);
$client->setHeaders([
    'Host' => "www.runoob.com",
    "User-Agent" => 'Chrome/49.0.2587.3',
    'Accept' => 'text/html,application/xhtml+xml,application/xml',
    'Accept-Encoding' => 'gzip',
]);
//for ($i = 0; $i <= 1; $i++) {
$client->get('/redis/redis-lists.html', function (swoole_http_client $cli) {
    echo $cli->body.PHP_EOL;
});
//}
$client->close();