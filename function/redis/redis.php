<?php
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->auth('P<zklv8HLIW1_ZCekEErly[MNw)YQh64');
$redis->select(0);