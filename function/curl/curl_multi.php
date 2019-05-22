<?php
$t1 = microtime(true);
$request = [
    [
        'url' => 'http://192.168.152.133:9501/',
        'data' => ['a' => 'b'],
    ],
    [
        'url' => 'http://192.168.152.133:9501/',
        'data' => ['a' => 'c'],
    ]
];

// 创建一对cURL资源
$requestCount = count($request);

// 创建批处理cURL句柄
$mh = curl_multi_init();
$chArr = [];
foreach ($request as $i => $req) {
    $chArr[$i] = $ch = curl_init();
    // 设置URL和相应的选项
    curl_setopt($ch, CURLOPT_URL, $req['url']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // 添加句柄
    curl_multi_add_handle($mh,$ch);
}

$running=null;//判断操作是否仍在执行
// 执行批处理句柄
do {
    usleep(500);
    curl_multi_exec($mh,$running);
} while ($running > 0);

//获取数据
foreach ($chArr as $i => $ch) {
    $request[$i]['content'] = curl_multi_getcontent($ch);
    // 关闭句柄
    curl_multi_remove_handle($mh, $ch);
}

curl_multi_close($mh);


var_dump(microtime(true) - $t1);
var_dump($request);