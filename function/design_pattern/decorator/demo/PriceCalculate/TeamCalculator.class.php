<?php

namespace HeadPortrait\Service\PriceCalculate;

/**
 * 拼团价格计算
 * Class TeamCalculator
 * @package HeadPortrait\Service\PriceCalculate
 */
class TeamCalculator extends CalculatorDecorator
{
    public function calculator(Pirce $price, $combo, $param)
    {
        $res = $this->calculator->calculator($price, $combo, $param);
        if (!$res || $res['status'] != 1) {
            return $res;
        }

        $price->calculator['Team'] = [];

        $config = \HeadPortrait\Service\TeamOrderService::getConfig($combo);
        if (!$config) {
            return array('status'=>'-1', 'msg' => '拼团配置信息丢失');
        }
        $realRrice = bcmul($price->cashFee , $config['value'], 1);//APP端保留一位小数
        $discountFee = bcsub($price->cashFee, $realRrice, 2);
        $price->calculator['Team'] = [
            'cash_fee' => $realRrice,
            'discount_fee' => $discountFee,
        ];

        $price->discountFee = bcadd($price->discountFee, $discountFee, 2);
        $price->cashFee = $realRrice;


        return ['status' => 1, 'msg' => 'success'];
    }
}