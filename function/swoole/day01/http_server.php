<?php
// ini_set('date.timezone', 'Asia/Shanghai');
$http = new swoole_http_server('0.0.0.0', 9501);
$http->set([
    //web服务器根目录
    'document_root' => dirname(__FILE__).'/webroot',
    //底层收到Http请求会先判断document_root路径下是否存在此文件，
    //如果存在会直接发送文件内容给客户端，不再触发onRequest回调。
    'enable_static_handler' => true,
    //选项为true时自动将Content-Type为x-www-form-urlencoded的请求包体解析到POST数组
//     'http_parse_post' => false,
]);

/**
 * 访问静态文件：http://swoole.mytest.com:9501/index.html
 */


/**
 * @var $request \Swoole\Http\Request
 * @var $response \Swoole\Http\Response
 */
$http->on('request', function ($request, $response) {
    $response->header('Content-Type', 'application/json; charset=utf-8');
    //cookie时间不对？？？？？
    $response->cookie('username', 'zhangsan', time()+600);
    $response->end(json_encode($request->get));
});

$http->start();