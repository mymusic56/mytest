<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/3/27
 * Time: 0:15
 */

namespace Swoft;


use Swoole\Http\Request;
use Swoole\Http\Response;

class Route
{
    private static $route = [];

    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function __callStatic($method, $param)
    {
        self::$route[strtoupper($method)][strtolower($param[0])] = $param[1];
    }

    public function dispatch(Request $request, Response $response)
    {
        $server = $request->server;
        if ($server['path_info'] == '/favicon.ico') {
            return '1234';
        }

        //判断是否配置自定义路由
        $method = $server['request_method'];
        switch ($method) {
            case 'GET':
                $key = strtolower($server['path_info']);
                if (isset(self::$route['GET'][$key])) {
                    return $this->get($request, $response, self::$route['GET'][$key]);
                } else {
                    return $this->get($request, $response, $key);
                }
        }
    }

    private function parseRoute($path)
    {
        $path = ltrim($path, '/');
        list($c, $a) = explode('/', $path);
        return ['controller' => $c, 'action' => $a];
    }

    private function get(Request $request, Response $response, $path)
    {
        if ($path instanceof \Closure) {
            return $path();
        }
        //解析路由
        $parse = self::parseRoute($path);
        $class = 'App\\Controller\\'.$parse['controller'];
        $result = (new $class)->{$parse['action']}($request);
        return $result;
    }

    private static function post(Request $request, Response $response, $path)
    {

    }
}