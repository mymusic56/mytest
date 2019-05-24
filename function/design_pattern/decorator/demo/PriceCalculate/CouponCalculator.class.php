<?php

namespace HeadPortrait\Service\PriceCalculate;

/**
 * 优惠券价格计算
 * Class CouponCalculator
 * @package HeadPortrait\Service\PriceCalculate
 */
class CouponCalculator extends CalculatorDecorator
{
    public function calculator(Pirce $price, $combo, $param)
    {
        $res = $this->calculator->calculator($price, $combo, $param);
        if (!$res || $res['status'] != 1) {
            return $res;
        }

        $price->calculator[] = 'coupon';

        $realRrice = $price->cashFee;
        if (isset($param['coupon_id']) && $param['coupon_id'] != 0){
            $checkRes = \HeadPortrait\Service\CouponService::getCouponV8($param['coupon_id'], $param['userId']);
            if ($checkRes['status'] == -1) {
                return array('status'=>'-1', 'msg' => $checkRes['msg']);
            }
            $coupon = $checkRes['data'];
            $param['coupon_id'] = $coupon['id'];
            //验证套餐类型使用限制
            $limitComboTypes = $coupon['combo_type_id'] ? explode($coupon['combo_type_id'], ',') : [];
            if ($limitComboTypes && !in_array($coupon['combo_type_id'], $limitComboTypes)) {
                return array('status'=>'-1', 'msg' => '当前购买套餐不支持使用此优惠券');
            }

            if($coupon['type'] == 1){
                $realRrice = round($realRrice * $coupon['sell_money']/10, 2);
                $price->discountFee += $price->cashFee - $realRrice;
                $price->calculator['coupon']['cash_fee'] = $realRrice;
                $price->calculator['coupon']['discount_fee'] = $price->cashFee - $realRrice;
            }else{
                if($coupon['use_situation'] <= $realRrice){
                    $realRrice -= $coupon['sell_money'];
                    $price->discountFee += $coupon['sell_money'];

                    $price->calculator['coupon']['cash_fee'] = $realRrice;
                    $price->calculator['coupon']['discount_fee'] = $price->cashFee - $coupon['sell_money'];
                }else{
                    return array('status'=>'-1', 'msg' => "金额不够满减");
                }
            }

            $price->cashFee = $realRrice;
            return ['status' => 1, 'msg' => 'success'];
        }

        return ['status' => -1, 'msg' => '优惠券ID错误'];
    }
}