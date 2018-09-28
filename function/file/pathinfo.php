<?php
$file = __DIR__.'a.txx.sql';
$res = pathinfo($file);
var_dump($res);

$dir = pathinfo($file, PATHINFO_DIRNAME);
var_dump($dir);
$dir = pathinfo($file, PATHINFO_BASENAME);
var_dump($dir);
$dir = pathinfo($file, PATHINFO_EXTENSION);
var_dump($dir);
$dir = pathinfo($file, PATHINFO_FILENAME);
var_dump($dir);
