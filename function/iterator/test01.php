<?php
function gen()
{
    while (true) {
        yield "gen";
    }
}

$gen = gen();

var_dump($gen instanceof Iterator);
echo "hello, world!";

foreach ($gen as $k => $v) {
    var_dump($k." => ".$v);
}