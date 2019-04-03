<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/4/3
 * Time: 23:12
 */

namespace Swoft\Db;


class MySql
{
    public static function getInstance()
    {
        $dbConfig = \Swoft\Config::get('database');
        $swoole_mysql = new \Swoole\Coroutine\MySQL();
        $swoole_mysql->connect([
            'host' => $dbConfig['host'],
            'port' => $dbConfig['port'],
            'user' => $dbConfig['user'],
            'password' => $dbConfig['password'],
            'database' => $dbConfig['dbname'],
        ]);
        return $swoole_mysql;
    }
}