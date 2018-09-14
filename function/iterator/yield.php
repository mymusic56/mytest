<?php
/*
 * http://www.laruence.com/2015/05/28/3038.html
 */
function myrange($start, $limit, $step)
{
    for ($i = $start, $j = 0; $i <= $limit; $i +=$step, $j ++) {
        echo "$i \n";
        yield $j => $i;
    }
}



$generate = myrange(0, 10, 3);

foreach ($generate as $k => $v) {
    var_dump($k.'--'.$v);
    var_dump($generate->current());
}
var_dump($generate);
var_dump($generate instanceof Iterator);
echo ("---------------</br>");


function myrange2($start, $limit)
{
    for ($i = $start; $i <= $limit; $i ++) {
        yield $i;
    }
}
$generate2 = myrange2(0, 5);
foreach ($generate2 as $k => $v) {
    var_dump($k.'--'.$v);
}


echo ("---------------</br>");

function &gen_reference() {
    $value = 3;
    
    while ($value > 0) {
        yield $value;
    }
}

/*
 * 我们可以在循环中修改$number的值，而生成器是使用的引用值来生成，所以gen_reference()内部的$value值也会跟着变化。
 */
foreach (gen_reference() as &$number) {
    echo (--$number).'... ';
}