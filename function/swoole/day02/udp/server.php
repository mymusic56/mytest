<?php
/**
 * Created by PhpStorm.
 * User: zhangshengji
 * Date: 2019/2/26
 * Time: 22:56
 */
$server = new Swoole\Server('0.0.0.0', 9502, SWOOLE_PROCESS, SWOOLE_SOCK_UDP);
$server->set([
    'worker_num'=>2, //设置进程
    'heartbeat_idle_time'=>10,//连接最大的空闲时间
    'heartbeat_check_interval'=>3 //服务器定时检查
]);

//客户端服务端没有任何联系
//制定地址跟端口，不关心消息是否发送成功
//心跳检测不能影响到客户端
//udp建立长连接

//监听事件,
$server->on('packet',function (swoole_server $server,$data,$clientInfo){
    var_dump($data,$clientInfo);
    $server->sendto($clientInfo['address'],$clientInfo['port'],"服务端数据包");
});

//服务器开启
$server->start();
