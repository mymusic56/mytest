<?php
$_array = [];
$http = new Swoole\Http\Server("0.0.0.0", 9501);
$http->set([
    'worker_num' => 1,
]);

$http->on("request", function (swoole_http_request $request, swoole_http_response $response) {
    global $_array;
    //请求 /a（协程 1 ）
    if ($request->server['request_uri'] == '/a') {
        $_array['name'] = 'a';
        co::sleep(5);
        echo $_array['name'];
        $response->end($_array['name']);
    }
    //请求 /b（协程 2 ）
    else {
        Co::sleep(3);
        $_array['name'] = 'b';
        $response->end('b');
    }
});

$http->start();