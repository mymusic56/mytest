<?php
//require '../Observable.php';

class Order implements Observable
{
    private $observers = [];

    private $state;

    /**
     * @param Observer $observer
     * @return mixed
     */
    public function attach(Observer $observer)
    {
        $flag = array_search($observer, $this->observers);
        if (!$flag) {
            $this->observers[] = $observer;
        }
    }

    /**
     * @param Observer $observer
     * @return mixed
     */
    public function detach(Observer $observer)
    {
        $key = array_search($observer, $this->observers);
        if ($key !== false) {
            unset($this->observers[$key]);
        }
    }

    /**
     * @return mixed
     */
    public function notify()
    {
        foreach ($this->observers as $observer) {
            /* @var $observer Observer */
            $observer->update($this);
        }

    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    public function addOrder()
    {
        // TODO create order logic.


        //订单完成创建发送通知
        $this->state = 1;
        $this->notify();
    }
}