<?php
/**
 * Swoole配置项
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/3/26
 * Time: 23:54
 */
return [
    'http' => [
        'host' => '0.0.0.0',
        'port' => 9501,
        'swoole_settings' => [
            'worker_num' => 2,
            'task_worker_num' => 2,
            'enable_static_handler' => true,
            'document_root' => ROOT_PATH,
        ]
    ]
];
