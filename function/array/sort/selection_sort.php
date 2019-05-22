<?php
/*
 * 假设是升序排序
 * 1. 在数组中选出最小的数据，排在第一个位置
 * 2. 重复第一步，在升序的元素中选择最小的值排在上一个值的后面
 * 3. 重复上一步操作，直到全部元素完成排序
 */

$a = [2,1,10,3,6,4,9,3,5];
$count = count($a);
for ($i = 0; $i < $count-1; $i++) {
    $minIndex = $i;
    for ($j = $i; $j < $count; $j++) {
        if ($a[$minIndex] > $a[$j]) {
            $minIndex = $j;
        }
    }
    $tmp = $a[$minIndex];
    $a[$minIndex] = $a[$i];
    $a[$i] = $tmp;
}

var_dump($a);