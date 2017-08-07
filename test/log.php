<?php
$t1 = microtime(true);
require './Vendor/Monolog/autoload.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

// Create the logger
$logger = new Logger('my_logger');
// Now add some handlers
$logger->pushHandler(new StreamHandler('D:\Workspace-PHP\mytest\test\Temp\Log\my_app.log', Logger::DEBUG));
$logger->pushHandler(new FirePHPHandler());

// You can now use your logger
$logger->addInfo('My logger is now ready 1');


$t2  =microtime(true);
// file_put_contents('D:\Workspace-PHP\charge\webroot\monolog\log\test\20170422.log', 'My logger is now ready',FILE_APPEND);
// require 'Loger.php';
// Mloger::write('test','My logger is now ready');

// $t3  =microtime(true);
var_dump($t2 - $t1);
// var_dump($t3 - $t2);
die;