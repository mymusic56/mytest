<?php
/**
 * 生成10唯一码
 * @return string|number
 */
function function_coupon_create_number() {
    $return_code = '';
    /* 根据毫秒加随机数进行MD5运算并删除字母 */
    $string = preg_replace('/[a-zA-Z]/', '', md5(microtime() . mt_rand(10000, 99999)));
    $string .= time() . mt_rand(10000, 99999);
    $string_length = strlen($string);

    /* 从生成的$string中随机获取10位数字作为消费券号 */
    for ($i = 0; $i < 10; $i ++) {
        $return_code .= intval($string{mt_rand(0, $string_length - 1)});
    }
    return $return_code;
}
$string=strtoupper(md5('123456'));
var_dump($string, $string{3});
function_coupon_create_number();

/**
 * 生成订单号
 * @return string
 */
function generate_order_number(){
    return date('ymdHis').substr(microtime(), 2,6).strtoupper(chr(rand(65,90))).rand(1000, 9999);
}