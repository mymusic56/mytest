<?php
/*
 * 归并排序
 * 当整个素组无法直接放到内存中的时候，就需要将一个大的数组拆分成多个段，每个块排序后放入临时文件中。
 * 例如内存只有100M，但是需要排序的数据有500M。
 * 最常见的就是MySQL，当数据量超过线程分配的sort_buffer时，就不得不对数据分段，进行归并排序
 *
 * 疑问：因为内存不够，如何实现最终排序的呢？
 *
 * 原理：
 *      1. 逻辑上将数据分成N个分段
 *      2. 从数据中读取一个分段数据，排序并写入临时文件
 *      3. 然后重复此动作2. 整个大数据被分成了N个有序分段
 *
 *
 *      接下来如何进行合并呢？ 假设每个分段都是升序排列。算法猜测如下：
 *          1. 在每个分段上取出1个数据，记录数据的偏移量，方便下次取数据。对取出的数据进行排序，那么一定可以得到大数据中的最小值, 将最小值数据写入另一个临时文件。
 *          2. 在最小值所在的分段上拿出下一个值与之前的值进行比较，找出最小值，操作同第一步
 *          3. 重复第二步。
 *          问题：IO次数较多，MySQL是如何解决的呢？
 *
 * 思考：
 *      分别读取N个分段的值，可以组成一个完全二叉树，将这颗二叉树进行递归合并，就是一个排序的数列了。
 */


/**
 * 这里实现一个两个数组的合并，都取出第一个元素进行比较，哪个值小就放入目标数组中
 * @param $array
 * @param int $part 需要拆分成多少块
 */
function merge_sort($array, $part=2)
{
    $per_length = count($array)/$part;
    $arr1 = array_slice($array, 0, $per_length);
    $arr2 = array_slice($array, $per_length);
    sort($arr1);
    sort($arr2);
    return merge($arr1, $arr2);
}

function merge($arr1, $arr2)
{
    $count_arr1 = count($arr1);
    $count_arr2 = count($arr2);
    $size = $count_arr1 + $count_arr2;
    $return = new SplFixedArray($size);
    for ($index=0,$i=0,$j=0; $index < $size; $index++) {
        if ($i >= $count_arr1) {//$arr1元素已使用完
            $return[$index] = $arr2[$j++];
        } elseif($j >= $count_arr2){//$arr2元素已使用完
            $return[$index] = $arr1[$i++];
        } elseif ($arr1[$i] > $arr2[$j]) {
            echo '3 ';
            $return[$index] = $arr2[$j++];
        } else {
            $return[$index] = $arr1[$i++];
        }
    }

    return $return->toArray();
}

$a = [10,9,8,7,6,5,4,3,2,1];
$res = merge_sort($a, 2);
echo json_encode($res);