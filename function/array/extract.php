<?php
$args = ['args0'=>'a', 'args1' =>['name' => 'zhangsan', 'age' => 12]];
extract($args);

var_dump($args0, $args1);