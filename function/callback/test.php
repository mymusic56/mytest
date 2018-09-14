<?php
require 'Server.php';

$server = new Server();
$server->checkLogin = function ($user, $str) {
    return 'execute checkLogin';
};
$server->start();
