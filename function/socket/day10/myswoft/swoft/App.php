<?php
namespace Swoft;
use Swoft\Command\Command;
use Swoft\Core\HttpServer;
use Swoft\Core\WebsocketServer;

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
        //检查输入参数
        $command = Command::parseCommand();

        self::checkEnv();
        self::init();
        self::execute($command['server'], $command['action'], $command['port']);
    }

    private static function checkEnv()
    {

    }


    private static function init()
    {

        //加载核心配置
        Config::load();
    }

    private static function execute($serverType, $action, $port)
    {
        if ($action == 'start') {
            if ($serverType == 'http') {
                if ($port > 0) {
                    Config::set('http.port', $port);
                }
                $config = Config::get('http');
                $server = new HttpServer($config['host'], $config['port'], $config['swoole_settings']);
            } else {
                if ($port > 0) {
                    Config::set('ws.port', $port);
                }
                $config = Config::get('ws');
                $server = new WebsocketServer($config['host'], $config['port'], $config['swoole_settings']);
            }
            $server->start();
        }

        die('命令不存在');
    }
}