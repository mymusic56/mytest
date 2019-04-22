<?php
function nums()
{
    for ($i = 0; $i < 5; ++$i) {
        //get a value from the caller
//        yield $i;
//        echo $i.'---'.PHP_EOL;
//        echo '+++++'.PHP_EOL;
        $cmd = (yield $i);
        echo $i.'==='.PHP_EOL;
        var_dump($cmd);
        echo '+++++============'.PHP_EOL;
        if ($cmd == 'stop')
            return;//exit the function
    }
}

$gen = nums();
$j = 0;
foreach ($gen as $v) {
    $j++;
    echo "循环第{$j}次\n";
    if ($v == 3)//we are satisfied
        var_dump($gen->send('stop'));

    echo "echo: {$v}\n";
}