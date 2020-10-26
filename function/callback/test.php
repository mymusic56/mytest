<?php
require 'Server.php';

$server = new Server();
$server->checkLogin = function ($user, $str, $userName) {
    return $userName . ' execute checkLogin';
};
$server->start();
