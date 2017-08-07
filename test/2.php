<?php
$str='<li><a href="http://www.yw11.com/html/mi/3-358-0-1.htm" target="_blank" title="汲姓男孩名字大全">   汲</a></li>';
preg_match("/>\s*[\x{4e00}-\x{9fa5}]+\s*</u",$str,$matches);//preg_match_all（“正则表达式”,"截取的字符串","成功之后返回的结果集（是数组）"）
// $s = join('',$regs[0]);//join("可选。规定数组元素之间放置的内容。默认是 ""（空字符串）。","要组合为字符串的数组。")把数组元素组合为一个字符串
// $s=mb_substr($s,0,80,'utf-8');//mb_substr用于字符串截取，可以防止中文乱码的情况
// var_dump($s);
// exit;

var_dump($matches);