<?php
/**
 * https://www.cnblogs.com/tingyugetc/p/6347286.html
 */
require 'MyIterator.php';
$it = new MyIterator();

foreach($it as $key => $value) {
    var_dump($key.'=>'. $value);
}