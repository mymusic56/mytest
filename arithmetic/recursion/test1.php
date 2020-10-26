<?php
/**
 * DateTime: 2020/6/9 8:59
 * @author: zhangshengji
 */

/**
 * Class Test
 */
class Test
{
    private $candidate = [1, 2, 5, 10];

    public function get($tatalValue, $result=[])
    {
        if ($tatalValue == 0) {
            var_dump($result);
            return 1;
        } elseif ($tatalValue < 0) {
            return 0;
        } else {
            $a = 0;
            foreach ($this->candidate as $v) {
                $newCandate = $result;
                $newCandate[] = $v;
                $a = $a + $this->get($tatalValue - $v, $newCandate);
            }

            return $a;
        }
    }
}

$test = new Test();
$a = $test->get(5);
var_dump($a);
