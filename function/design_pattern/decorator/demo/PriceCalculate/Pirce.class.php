<?php
namespace HeadPortrait\Service\PriceCalculate;
/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2019/5/24
 * Time: 17:30
 */

class Pirce
{
    public $num = 1;
    public $totalFee = 0;
    public $cashFee = 0;
    public $discountFee = 0;
    /**
     * @var array
     * 按顺序加入，记录所有的计算器
     */
    public $calculator = [];

    /**
     * @var array
     * 记录所有活动
     */
    public $activity = [];

    public $activityIds = [];

    public function toArray()
    {
        return [
            'num' => $this->num,
            'totalFee' => $this->totalFee,
            'cashFee' => $this->cashFee,
            'discountFee' => $this->discountFee,
            'calculator' => $this->calculator,
            'activity' => $this->activity,
            'activityIds' => $this->activityIds,
        ];
    }
}