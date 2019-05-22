<?php
$data = [
    'name' => 'zhangsan',
    'pwd' => '123456'
];
$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Auth: 123456',
        'content' => http_build_query($data),
    ]
]);

$result = file_get_contents('http://home.mytest.com/string.php', false, $context);
echo $result;


//stream_context_create
/*
 * stream_context_create 如果是socket请求，将http换成socket
 */