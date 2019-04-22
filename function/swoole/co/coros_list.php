<?php
go(function (){
    $t1 = time();
    $chan = new Chan();
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
            'host' => '192.168.1.101',
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


    for ($i = 0; $i < 2; $i++)
    {
        var_dump($chan->pop());
    }

    var_dump(time() - $t1);


});

$coros = Swoole\Coroutine::listCoroutines();
foreach($coros as $cid)
{
    var_dump($cid);
}