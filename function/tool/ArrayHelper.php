<?php
/**
 * DateTime: 2020/8/27 10:30
 * @author: zhangshengji
 */

class ArrayHelper
{
    /**
     * find similar text from an array|Iterator
     *
     * @param string         $need
     * @param Iterator|array $iterator
     * @param int            $similarPercent
     *
     * @return array
     */
    public static function findSimilar(string $need, $iterator, int $similarPercent = 45): array
    {
        if (!$need) {
            return [];
        }

        // find similar command names by similar_text()
        $similar = [];

        foreach ($iterator as $name) {
            similar_text($need, $name, $percent);

            if ($similarPercent <= (int)$percent) {
                $similar[] = $name;
            }
        }

        return $similar;
    }
}