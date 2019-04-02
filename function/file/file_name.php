<?php
/**
 * Created by PhpStorm.
 * Date: 2019/4/2
 * Time: 12:59
 */

$a = '/a/b/abc.php';
var_dump(basename($a));
var_dump(basename($a, '.php'));