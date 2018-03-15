<?php
/**
 * 生成证书：
 * [root@localhost test]# openssl genrsa -out test.rsa_private_key.pem 1024
 *  Generating RSA private key, 1024 bit long modulus
 *  ............++++++
 *  ......++++++
 *  e is 65537 (0x10001)
 *  [root@localhost test]# ls
 *  test.rsa_private_key.pem
 *  [root@localhost test]# openssl rsa -in test.rsa_private_key.pem -pubout -out test.rsa_public_key.pem
 *  writing RSA key
 *  [root@localhost test]# ls
 *  test.rsa_private_key.pem  test.rsa_public_key.pem
 *
 */
/**
 * RSA签名
 * @param $data 待签名数据
 * @param $private_key_path 商户私钥文件路径
 * return 签名结果
 */
function rsaSign($data, $private_key_path) {
    $priKey = file_get_contents($private_key_path);
    $res = openssl_get_privatekey($priKey);
    openssl_sign($data, $sign, $res);
    openssl_free_key($res);
    //base64编码
    $sign = base64_encode($sign);
    return $sign;
}

/**
 * RSA验签
 * @param $data 待签名数据
 * @param $ali_public_key_path 支付宝的公钥文件路径
 * @param $sign 要校对的的签名结果
 * return 验证结果
 */
function rsaVerify($data, $ali_public_key_path, $sign)  {
    $pubKey = file_get_contents($ali_public_key_path);
    $res = openssl_get_publickey($pubKey);
    $result = (bool)openssl_verify($data, base64_decode($sign), $res);
    openssl_free_key($res);
    return $result;
}

$private_key_path = '/windows/www/mytest/function/encrypt/crt/test.rsa_private_key.pem';
$ali_public_key_path = '/windows/www/mytest/function/encrypt/crt/test.rsa_public_key.pem';

$data= '332ikeowapfjieowa';

$sign = rsaSign($data, $private_key_path);
var_dump($sign);

$check = rsaVerify($data, $ali_public_key_path, $sign);
var_dump($check);