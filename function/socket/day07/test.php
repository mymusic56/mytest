<?php

$key = ftok(__DIR__, '1');
var_dump($key);
$src = msg_get_queue($key);
msg_send($src, 1, '1234567');