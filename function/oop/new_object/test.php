<?php
/**
 * static and self
 */
include 'Father.php';
require_once 'Sun1.php';
require_once 'Sun1.php';
require 'Sun2.php';

$sun1 = new Sun1();
$sun2 = new Sun2();

var_dump(get_class($sun1->getNewFather()));
var_dump( get_class($sun1->getNewCaller()));
var_dump(  get_class($sun2->getNewFather()));
var_dump(  get_class($sun2->getNewCaller()));

$redis = new Redis();
$redis->connect('home.mytest.com');
$redis->auth('P<zklv8HLIW1_ZCekEErly[MNw)YQh64');
$redis->select(0);
$arr = ['rank:190215', 'rank:190216'];
$res = $redis->zUnion('rank:last_week2', $arr);
var_dump($res);
$res = $redis->zRevRange('rank:last_week2', 0, 4, 'withscore');
var_dump($res);
