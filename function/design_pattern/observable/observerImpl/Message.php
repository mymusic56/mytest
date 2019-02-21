<?php


class Message implements Observer
{

    /**
     * @param Observable $observable
     * @return mixed
     */
    public function update(Observable $observable)
    {
        $state = $observable->getState();
        if ($state) {
            echo '短信通知：您已下单成功。</br>';
        } else {
            echo '短信通知：下单失败，请重试。</br>';
        }
    }
}