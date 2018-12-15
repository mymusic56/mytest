<?php

function curl_proxy_http($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_PROXY, 'ip:40079');
    curl_setopt($ch, CURLOPT_USERPWD, 'proxy_test_admin:123456');

//    curl_setopt($ch, CURLOPT_PROXY, '192.168.226.130');
//    curl_setopt($ch, CURLOPT_PROXYPORT, '8081');
    $ret = curl_exec($ch);
    curl_getinfo($ch);
    $body = null;
    if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == '200') {
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($ret, 0, $headerSize);
        $body = substr($ret, $headerSize);
        //            MLoger::write('ChinaMobileSecondApi/sendRequest', $data. "\n ".$headerSize. "\n ".$header.$body."\n");
    } else {
        $errno = curl_errno($ch);
        $errmsg = curl_error($ch);
        var_dump($errno, $errmsg);
    }
    curl_close($ch);
    return $body;
}

$url = 'http://home.mytest.com/test.php';
$url = 'http://adminsignature.nineton.cn/test.php';
var_dump($url);
$res = curl_proxy_http($url);
var_dump($res);
