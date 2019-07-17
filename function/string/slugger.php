<?php
$string = '<html>Hello World,zhagsan</html>';
//不匹配a-z0-9 的字符用-替换掉
$a =  preg_replace(
            '/[^a-z0-9]/', '-', strtolower(trim(strip_tags($string)))
        );
var_dump($a, '-----------');

$string = 'google 123, 456';
$pattern = '/(\w+) (\d+), (\d+)/i';
$replacement = 'runoob ${2},$3';
echo preg_replace($pattern, $replacement, $string);

var_dump(ucwords('hello_world', '_'));