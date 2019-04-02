<?php
/**
 * 路由服务器
 * 1. 注册IM-server, 使用Redis（）存储注册信息
 * 2. 客户端获取IM-server，颁发token（JWT）
 * User: zhang
 * Date: 2019/4/2
 * Time: 20:13
 */
require_once '../vendor/autoload.php';

class Route
{
    private $redis;

    public function __construct()
    {
        $this->redis = new Redis();
    }

    public function run()
    {
        $server = new swoole_websocket_server('0.0.0.0', 9800);
        $server->on('request', [$this, 'onRequest']);
        $server->on('message', [$this, 'onMessage']);
        $server->on('open', [$this, 'onOpen']);
        $server->on('close', [$this, 'onClose']);
        $server->set([

        ]);
    }

    private function getIMserver()
    {
        require_once 'Rand.php';
        $data = $this->redis->sMembers('im-server');
        return Rand::randServer($data);
    }

    public function onRequest(swoole_http_request $request, swoole_http_response $response)
    {
        $post = $request->post;
        try {
            if ($request->header['path_info'] == '/im') {
                //验证用户
                $username = $post['username'];
                $pwd = $post['pwd'];
                //颁发token
                //iss（签发者）, exp（过期时间戳）, sub（面向的用户）, aud（接收方）, iat（签发时间）。
                $time = time();
                mt_srand();
                $token = [
                    "iss" => "http://example.org",
                    "aud" => "http://example.com",
                    "iat" => $time,
                    "nbf" => $time,
                    "exp" => $time+7200,
                    "data" => [
                        'user_id' => '',
                        'username' => $username,
                        'age' => mt_rand(10, 50)
                    ]
                ];
                $key = 'zhang123456';
                $token_jwt = \Firebase\JWT\JWT::encode($token, $key);
                $response->header('Content-Type', 'application/json');
                $url = $this->getIMserver();
                $response->end(['status' => 1, 'token' => $token_jwt, 'url' => $url]);
            }

        } catch (\Throwable $e) {
            $response->end($e->getMessage());
        }
    }

    public function onMessage(swoole_websocket_server $server, swoole_websocket_frame $frame)
    {
        $data = $frame->data;
        if ($data) {
            $data = json_decode($data, true);
            if ($data && $data['type'] == 'register') {
                $key = 'im-server';
                $member = $data['host'].':'.$data['port'];
                $this->redis->sAdd($key, $member);
                $redis = $this->redis;
                $fd = $frame->fd;
                //swoole_timer_tick的别名
                //创建定时器，自动检测IM-server是否存活(不写在onclose中)
                $server->tick(3000, function () use($server, $fd, $redis, $member) {
                    if (!$server->exist($fd)) {
                        $redis->sRem('im-server', $member);
                    }
                });
            }
        }
    }

    public function onClose(swoole_server $server, int $fd, int $reactorId)
    {

    }

    public function onOpen(swoole_websocket_server $server, swoole_http_request $request)
    {

    }
}