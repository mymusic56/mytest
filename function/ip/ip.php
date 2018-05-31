<?php
//案例：判断192.168.1.127是否在 (192.168.1.1--192.168.1.255)的范围里面

$ip_start = get_iplong('192.168.1.1'); //起始ip
$ip_end = get_iplong('192.168.1.255');//至ip
$ip = get_iplong('192.168.1.127');//判断的ip
//可以这样简单判断
if($ip>=$ip_start && $ip <=$ip_end){
    echo 'true';
}else{
    echo 'false';
}
/**
 * 将ip地址转换成int型
 * @param string $ip  ip地址
 * @return number 返回数值
 */
function get_iplong($ip){
    //bindec(decbin(ip2long('这里填ip地址')));
    //ip2long();的意思是将IP地址转换成整型 ，
    //之所以要decbin和bindec一下是为了防止IP数值过大int型存储不了出现负数。
//     var_dump(ip2long($ip));
    return bindec(decbin(ip2long($ip)));
}