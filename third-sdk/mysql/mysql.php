<?php
/**
 * DateTime: 2020/9/23 9:37
 * @author: zhangshengji
 */
function createPDOBy($dbCfg = [])
{
    if (empty($dbCfg)) {
        $dbCfg = [
            'name' => 'test',
            'host' => 'mysql5.6',
            'port' => '3306',
            'charset' => 'utf8mb4',
            'user' => 'root',
            'password' => '123456',
        ];
    }
    $dsn = sprintf('mysql:dbname=%s;host=%s;port=%d',
        $dbCfg['name'],
        isset($dbCfg['host']) ? $dbCfg['host'] : 'localhost',
        isset($dbCfg['port']) ? $dbCfg['port'] : 3306
    );
    $charset = isset($dbCfg['charset']) ? $dbCfg['charset'] : 'UTF8';

    // 支持sql server
    if (!empty($dbCfg['type']) && strtolower($dbCfg['type']) == 'sqlserver') {
        $dsn = sprintf('sqlsrv:Server=%s,%d;Database=%s',
            isset($dbCfg['host']) ? $dbCfg['host'] : 'localhost',
            isset($dbCfg['port']) ? $dbCfg['port'] : 1433,
            $dbCfg['name']
        );
    }

    $pdo = new \PDO(
        $dsn,
        $dbCfg['user'],
        $dbCfg['password']
    );
    $pdo->exec("SET NAMES '{$charset}'");
    $pdo->setAttribute(\PDO::ATTR_STRINGIFY_FETCHES, false);
    $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);

    return $pdo;
}