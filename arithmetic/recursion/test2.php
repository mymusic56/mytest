<?php
/**
 * DateTime: 2020/6/9 16:17
 * @author: zhangshengji
 */

/**
 * 一个整数可以被分解为多个整数的乘积，例如，6 可以分解为 2x3。
 * 请使用递归编程的方法，为给定的整数 n，找到所有可能的分解（1 在解中最多只能出现 1 次）。
 * 例如，输入 8，输出是可以是 1x8, 8x1, 2x4, 4x2, 1x2x2x2, 1x2x4, ……
 * Class Test
 */
class Test
{
    private $init_num_list = [];
    private $init_num = 1;

    public function get($number, $result=[])
    {
        $num_list = range(1, $number);
        if (!$this->init_num_list) {
            $this->init_num = $number;
            $this->init_num_list = $num_list;
        }
        if ($number == 1) {
            var_dump($result);
            return;
        }
//        $num_list = array_reverse($num_list);
        foreach ($num_list as $num) {
            $new_result = $result;
            $new_result[] = $num;
            if ($this->init_num%$num == 0) {
                continue;
            }
            $this->get($num, $new_result);
        }
    }
}

$test = new Test();
$test->get(5);
