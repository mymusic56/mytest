<?php


class Email implements Observer
{
    /**
     * @param Observable $observable
     * @return mixed
     */
    public function update(Observable $observable)
    {
        $state = $observable->notify();
    }

}