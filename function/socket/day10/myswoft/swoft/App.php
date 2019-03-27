<?php
namespace Swoft;
use Swoft\Core\HttpServer;

/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/3/26
 * Time: 23:47
 */
Class App
{
    public static function run()
    {
        self::checkEnv();
        self::init();
        self::execute();
    }

    private static function checkEnv()
    {

    }


    private static function init()
    {
        //检查输入参数

        //加载核心配置
        Config::load();
    }

    private static function execute()
    {
        $httpConfig = Config::get('http');
        $http = new HttpServer($httpConfig['host'], $httpConfig['port'], $httpConfig['swoole_settings']);
        $http->start();
    }
}