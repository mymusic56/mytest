<?php
/**
 * https://www.php.net/manual/zh/features.gc.refcounting-basics.php
 * 变量的生命周期
 * 1. 不论是对象还是数组，unset()变量后内存会被回收。
 */

$a = array( 'meaning' => 'life', 'number' => 42 );
$a['life'] = $a['meaning'];
xdebug_debug_zval( 'a' );

//a: (refcount=1, is_ref=0)=array ('meaning' => (refcount=3, is_ref=0)='life', 'number' => (refcount=0, is_ref=0)=42, 'life' => (refcount=3, is_ref=0)='life')

# 这里和预想结果有差异？？？ 为什么不是 'meaning' => (refcount=2,


$a2 = 'new string';
$b2 = 1;
xdebug_debug_zval('a2');
xdebug_debug_zval('b2');