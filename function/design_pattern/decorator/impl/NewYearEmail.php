<?php


class NewYearEmail extends EmailBodyDecorator
{
    /**
     * @return mixed
     */
    public function body()
    {
        $this->emailBody->body();
        var_dump('元旦快乐');
    }

}