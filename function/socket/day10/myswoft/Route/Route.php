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
require_once dirname(__DIR__).'/swoft/base.php';

class Route
{
    private $redis;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 6379);
        $this->redis->auth('123456');
    }

    public function run()
    {
        $server = new swoole_websocket_server('0.0.0.0', 9800);
        $server->on('request', [$this, 'onRequest']);
        $server->on('message', [$this, 'onMessage']);
        $server->on('open', [$this, 'onOpen']);
        $server->on('close', [$this, 'onClose']);
        $server->set([
            'log_level' => 2
        ]);
        $server->start();
    }

    private function getIMserver()
    {
        require_once 'Rand.php';
        $data = $this->redis->sMembers('im-server');
        return Rand::randServer($data);
    }

    private function queryUser($username,$pwd)
    {
        $swoole_mysql = \Swoft\Db\MySql::getInstance();
        $res = $swoole_mysql->query("select * from users where `name`='{$username}'");
        var_dump("select * from users where `name`='{$username}'", $res);
        return empty($res) ? null : $res[0];
    }

    /**
     * 获取实际的IM Server
     * @param swoole_http_request $request
     * @param swoole_http_response $response
     * @return bool
     */
    public function onRequest(swoole_http_request $request, swoole_http_response $response)
    {
        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('Content-Type', 'application/json');
        $post = $request->post;
        try {
            if ($post['type'] == 'login') {
                //验证用户
                $username = $post['username'];
                $pwd = isset($post['pwd']) ? $post['pwd'] : '';

                $userinfo = $this->queryUser($username, $pwd);
                if (!$userinfo) {
                    $response->end(json_encode(['status' => -1, 'msg' => '用户不存在']));
                    return false;
                }

                //颁发token
                //iss（签发者）, exp（过期时间戳）, sub（面向的用户）, aud（接收方）, iat（签发时间）。
                $time = time();
                mt_srand();
                $url = $this->getIMserver();
                $token = [
                    "iss" => "http://example.org",
                    "aud" => "http://example.com",
                    "host" => $url,
                    "iat" => $time,
                    "nbf" => $time,
                    "exp" => $time+7200,
                    "data" => $userinfo
                ];
                $key = 'zhang123456';
                $token_jwt = \Firebase\JWT\JWT::encode($token, $key);
                $response->end(json_encode(['status' => 1, 'token' => $token_jwt, 'url' => $url]));
            }

        } catch (\Exception $e) {
            $response->end(json_encode(['status' => -1, 'msg' => $e->getMessage()]));
        } catch (\Throwable $e) {
            $response->end(json_encode(['status' => -1, 'msg' => $e->getMessage()]));
        }
    }

    /**
     * IM Server注册
     * @param swoole_websocket_server $server
     * @param swoole_websocket_frame $frame
     */
    public function onMessage(swoole_websocket_server $server, swoole_websocket_frame $frame)
    {

        $request_data = $frame->data;
        if ($request_data) {
            $request_data = json_decode($request_data, true);
            if ($request_data && $request_data['type'] == 'register') {
                echo "注册IM-server \r\n";
                $key = 'im-server';
                $data = $request_data['data'];
                $member = $data['host'].':'.$data['port'];
                echo "$member\r\n";
                $this->redis->sAdd($key, $member);
                $redis = $this->redis;
                $fd = $frame->fd;
                //swoole_timer_tick的别名
                //创建定时器，自动检测IM-server是否存活(不写在onclose中)
                $server->tick(3000, function ($timer_id) use($server, $fd, $redis, $member) {
                    if (!$server->exist($fd)) {
                        $redis->sRem('im-server', $member);
                        echo "$member 下线\r\n";
                        //清除定时器
                        $server->clearTimer($timer_id);
                    }
                });
                $return = json_encode(['status' => 1, 'msg' => '注册成功']);
                $server->push($fd, $return);
            } elseif ($request_data && $request_data['type'] == 'sendmsg') {
                //将消息发送给其他服务器
                var_dump("接收 server： {$request_data['data']['from_server']} 发来的群发消息");
                echo json_encode($request_data, JSON_UNESCAPED_UNICODE).PHP_EOL;
                go(function () use ($request_data) {
                    //获取服务器列表
                    $serverList = $this->redis->sMembers('im-server');
                    $from_server = $request_data['data']['from_server'];
                    foreach ($serverList as $item) {
                        //过滤掉发送消息的server
                        if ($from_server == $item) {
                            echo "过滤服务器： {$item}".PHP_EOL;
                            continue;
                        }

                        //发送websocket请求
                        list($host, $port) = explode(':', $item);
                        $client = new \Swoole\Coroutine\Http\Client($host, $port);
                        $ret = $client->upgrade('/');
                        if ($ret) {
                            $request_data['data']['from_server'] = '192.168.152.129:9800';
                            $client->push(json_encode($request_data));
                        }

                        echo "发送消息给： {$item}".PHP_EOL;
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

\Swoft\Config::load();
$route = new Route();
$route->run();