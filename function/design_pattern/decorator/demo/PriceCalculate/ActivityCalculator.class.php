<?php

namespace HeadPortrait\Service\PriceCalculate;


use HeadPortrait\Model\ActivityModel;

class ActivityCalculator extends CalculatorDecorator
{
    public function calculator(Pirce $price, $combo, $param)
    {
        $res = $this->calculator->calculator($price, $combo, $param);
        if (!$res || $res['status'] != 1) {
            return $res;
        }
        $price->calculator[] = 'activity';

        $activity = ActivityModel::getComboActivityByComboId($combo['id']);
        if($activity){
            $price->cashFee -= $activity['price_value'];
            $price->discountFee += $activity['price_value'];
            $price->activity[] = $activity;
            $price->activityIds[] = $activity['id'];
            $price->calculator['activity'] = [
                'cash_fee' => $price->cashFee - $activity['price_value'],
                'total_fee' => $price->totalFee,
                'discount_fee' => 0
            ];
            return ['status'=>1, 'msg' => 'success'];
        }
        return ['status' => 1, 'msg' => '没有活动'];
    }
}