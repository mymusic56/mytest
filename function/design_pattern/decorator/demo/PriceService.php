<?php

class PriceService
{
    public static function checkOrderPriceNew(&$params, &$combo)
    {
        $t1 = microtime(true);
        $price = new Pirce();

        //普通计算
        $comboCalculator = new ComboCalculator();
        //活动计算
        if (ActivityModel::getComboActivityByComboId($combo['id'])) {
            $comboCalculator = new ActivityCalculator($comboCalculator);
        }
        if (isset($params['team_up']) && $params['team_up'] == 1) {
            //拼团计算
            $comboCalculator = new TeamCalculator($comboCalculator);
        } elseif (isset($params['coupon_id']) && $params['coupon_id'] != 0) {
            //优惠券计算
            $comboCalculator = new CouponCalculator($comboCalculator);
        }

        $comboCalculator = new TeamCalculator($comboCalculator);

        $res = $comboCalculator->calculator($price, $combo, $params);
        if (!$res || $res['status'] != 1) {
            return array('status'=>-1, 'msg' => $res['msg'], 'data'=>array('flag' => '1'));
        }

        if ($price->cashFee != $params['totalFee']) {
            //价格计算错误
            return array('status'=>-1, 'msg' => '金额错误（totalFee:'.$params['totalFee'].',realPrice:'.$price->cashFee, 'data'=>array('flag' => '1'));
            //写日志
            Log::write(json_encode($price->toArray()));
        }


        return array('status'=>1, 'msg' => 'success', 'data'=> $params);
    }

}