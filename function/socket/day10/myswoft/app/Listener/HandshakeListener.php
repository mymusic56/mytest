<?php
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/4/2
 * Time: 22:29
 */

namespace App\Listener;

use Firebase\JWT\JWT;
use Swoft\Event\EventInterface;
use Swoft\Log\Log;

/**
 * Class WebsocketHandlerEvent
 * @package App\Listener
 * @Listener(ws.handler)
 */
class HandshakeListener implements EventInterface
{

    private $data;
    private $host;

    public function handler($event)
    {
        Log::wirte("新的连接到达");
        /* @var $response \swoole_http_response */
        /* @var $request \swoole_http_request */
        /* @var $redis \Redis */
        $request = $event['request'];
        $response = $event['response'];
        $redis = $event['redis'];
        // print_r( $request->header );
        //如果不满足我某些自定义的需求条件，那么返回end输出，返回false，握手失败
        //客户端握手，验证token
        if (($msg = $this->checkToken($request->header)) !== true) {
            $response->end($msg);
            return false;
        }

        //存储用户和fd的关系
        //向指定用户发送消息： 根据用户ID，找到用户所在主机、fd
        $flag1 = $redis->hSet('user_fd', $this->data->id, json_encode(['host' => $this->host, 'fd' => $request->fd]));

        //主机 fd 对应的用户ID
        $flag2 = $redis->hSet($this->host, $request->fd, $this->data->id);
        if ($flag1 === false && $flag2 !== false) {
            Log::wirte("用户fd保存失败");
        }
        $this->userinfo = null;

        // websocket握手连接算法验证
        $secWebSocketKey = $request->header['sec-websocket-key'];
        $patten = '#^[+/0-9A-Za-z]{21}[AQgw]==$#';
        if (0 === preg_match($patten, $secWebSocketKey) || 16 !== strlen(base64_decode($secWebSocketKey))) {
            $response->end();
            return false;
        }
        echo $request->header['sec-websocket-key'];
        $key = base64_encode(sha1(
            $request->header['sec-websocket-key'] . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11',
            true
        ));

        $headers = [
            'Upgrade' => 'websocket',
            'Connection' => 'Upgrade',
            'Sec-WebSocket-Accept' => $key,
            'Sec-WebSocket-Version' => '13',
        ];

        // WebSocket connection to 'ws://127.0.0.1:9502/'
        // failed: Error during WebSocket handshake:
        // Response must not include 'Sec-WebSocket-Protocol' header if not present in request: websocket
        if (isset($request->header['sec-websocket-protocol'])) {
            $headers['Sec-WebSocket-Protocol'] = $request->header['sec-websocket-protocol'];
        }

        foreach ($headers as $key => $val) {
            $response->header($key, $val);
        }

        $response->status(101);
        $response->end();
    }

    private function checkToken($header)
    {
        if (!isset($header['sec-websocket-protocol'])) {
            return '请求未授权';
        }

        $token = $header['sec-websocket-protocol'];
        $tokenArr = JWT::decode($token, 'zhang123456',array('HS256'));

        if (!$tokenArr) {
            return '授权内容无效';
        }

        if (!isset($tokenArr->exp) || $tokenArr->exp < time()) {
            return 'token过期';
        }

        $this->data = $tokenArr->data;
        $this->host = $tokenArr->host;

        return true;
    }
}