<?php
namespace HeadPortrait\Service\PriceCalculate;


class ComboCalculator implements Calculator
{
    public function calculator(Pirce $price, $combo, $param)
    {
        $pricePrefix = $param['photoType'] == 1 ? 'full_x' : 'half_x';

        $priceIndex = $pricePrefix.$param['peopleNo'];

        $realRrice = round(floatval($combo[$priceIndex]), 2);
        $price->cashFee = $realRrice;
        $price->totalFee = $realRrice;
        $price->calculator['combo'] = [
            'cash_fee' => $realRrice,
            'total_fee' => $realRrice,
            'discount_fee' => 0
        ];
        return ['status' => 1, 'msg' => 'success'];
    }
}