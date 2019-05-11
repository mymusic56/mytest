<?php
/**
 * 使用通道实现并发调用
 * 连续多次$chan->push()会被阻塞
*/
go(function (){
    $t1 = microtime(true);
    //这里需要指定通道容量，默认通道容量为1，当通道容量不足的时候会阻塞
    $chan = new Chan(10);
    go(function () use ($chan){
        $client = new Swoole\Coroutine\Http\Client('127.0.0.1', 9501);
        $client->setHeaders([
            'Host' => '127.0.0.1',
            "User-Agent" => 'Chrome/49.0.2587.3',
            'Accept' => 'text/html,application/xhtml+xml,application/xml',
            'Accept-Encoding' => 'gzip',
        ] );
        $res = $client->get("/");
        $chan->push($client->body);
    });

    go(function () use ($chan){
        $mysql = new Swoole\Coroutine\Mysql();
        $mysql->connect([
            'host' => '192.168.1.102',
            'port' => 3306,
            'user' => 'root',
            'password' => '123456',
            'database' => 'mytest'
        ]);
        $res_mysql1 = $mysql->query("select sleep(3)");
        $chan->push($res_mysql1);
    });

    go(function () use ($chan){
        $mysql = new Swoole\Coroutine\Mysql();
        $mysql->connect([
            'host' => '192.168.1.102',
            'port' => 3306,
            'user' => 'root',
            'password' => '123456',
            'database' => 'mytest'
        ]);
        $res_mysql1 = $mysql->query("select sleep(3)");
        $chan->push($res_mysql1);
    });

    go(function () use($chan) {
        $redis = new Swoole\Coroutine\Redis();
        $redis->connect('127.0.0.1', 6379);
        $redis->auth('123456');
        $redis->select(0);
        $chan->push("Redis Result: ".$redis->get('test'));
    });


    for ($i = 1; $i <= 4; $i++)
    {
        var_dump($chan->pop());
        if ($i==4) {
            $t2 = microtime(true);
            var_dump($t2 - $t1);
        }
    }



});
