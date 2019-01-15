<?php


class Log implements Observer
{

    /**
     * @param Observable $observable
     * @return mixed
     */
    public function update(Observable $observable)
    {
        $state = $observable->getState();
        if ($state) {
            echo '记录日志：生成了一个订单记录。</br>';
        } else {
            echo '记录日志 失败：生成了一个订单记录。</br>';
        }
    }
}