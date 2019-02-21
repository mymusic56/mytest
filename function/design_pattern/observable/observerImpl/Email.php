<?php


class Email implements Observer
{
    /**
     * @param Observable $observable
     * @return mixed
     */
    public function update(Observable $observable)
    {
        $state = $observable->getState();
        if ($state) {
            echo '发送邮件：您已经成功下单。</br>';
        } else {
            echo '发送邮件：下单失败，请重试。</br>';
        }
    }
}