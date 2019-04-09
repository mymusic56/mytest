<?php
/**
 * Swoole配置项
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/3/26
 * Time: 23:54
 */
return [
    'route' => [
        'host' => '192.168.152.129',
        'port' => 9800
    ],
    'http' => [
        'host' => '0.0.0.0',
        'ip' => '192.168.152.129',
        'port' => 9501,
        'swoole_settings' => [
            'worker_num' => 2,
            'task_worker_num' => 2,
            'enable_static_handler' => true,
            'document_root' => ROOT_PATH,
            //开启请求慢日志
            'request_slowlog_timeout' => 2, //2秒
            'request_slowlog_file' => '/tmp/trace.log',//daemonize=1时生效
            'trace_event_worker' => true, //跟踪 Task 和 Worker 进程
            //日志级别
            'log_level' => 2,//https://wiki.swoole.com/wiki/page/538.html
            'log_file' => '/tmp/swoole.log',
//            'daemonize' => 1,
        ]
    ],
    'ws' => [
        'host' => '0.0.0.0',
        'ip' => '192.168.152.129',
        'port' => 9501,
        'enable_http' => true,//启用HTTP server
        'swoole_settings' => [
            'worker_num' => 2,
            'task_worker_num' => 2,
            'enable_static_handler' => true,
            'document_root' => ROOT_PATH,
            //开启请求慢日志
            'request_slowlog_timeout' => 2, //2秒
            'request_slowlog_file' => '/tmp/trace.log',//daemonize=1时生效
            'trace_event_worker' => true, //跟踪 Task 和 Worker 进程
            //日志级别
            'log_level' => 2,//https://wiki.swoole.com/wiki/page/538.html
            'log_file' => '/tmp/swoole.log',
//            'daemonize' => 1,
        ]
    ]
];
