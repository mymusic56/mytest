<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件
// function my_shutdown_function()
// {
// 	$e = error_get_last();
// 	$info = 'type:'.$e['type'].PHP_EOL.'messge:'.$e['message'].PHP_EOL.'FILE:'.$e['file'].PHP_EOL.'LINE: '.$e['line'];
// 	file_put_contents('D:\Workspace-PHP\thinkphp_3.2.3\error.log', $info.PHP_EOL, FILE_APPEND);
// }
// register_shutdown_function('my_shutdown_function');
// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', true);

// 定义应用目录
define('APP_PATH','./Application/');
// define('THINK_PATH','D:/ThinkPHP3.2.3/');
define('THINK_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR.'ThinkPHP'.DIRECTORY_SEPARATOR);
// 引入ThinkPHP入口文件
require THINK_PATH.'ThinkPHP.php';
//测试更新

// 亲^_^ 后面不需要任何代码了 就是如此简单