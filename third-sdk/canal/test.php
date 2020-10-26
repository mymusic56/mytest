<?php
/**
 * DateTime: 2019/12/17 13:37
 * @author: zhangshengji
 */
require '../../vendor/autoload.php';
try {
    $client = \xingwenge\canal_php\CanalConnectorFactory::createClient(\xingwenge\canal_php\CanalClient::TYPE_SOCKET_CLUE);
//    $client = CanalConnectorFactory::createClient(CanalClient::TYPE_SOCKET_CLUE);
    # $client = CanalConnectorFactory::createClient(CanalClient::TYPE_SWOOLE);

    $client->connect("127.0.0.1", 11111);
    $client->checkValid();
//    $client->subscribe("1001", "test", ".*\\..*");
    $client->subscribe("1001", "test", "test.test"); # 设置过滤

    while (true) {
        $message = $client->get(100);
        if ($entries = $message->getEntries()) {
            foreach ($entries as $entry) {
                \xingwenge\canal_php\Fmt::println($entry);
            }
        }
        sleep(1);
    }

    $client->disConnect();
} catch (\Exception $e) {
    echo $e->getMessage(), PHP_EOL;
}