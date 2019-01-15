<?php


class NewYearEmail extends EmailBodyDecorator
{
    /**
     * @return mixed
     */
    public function body()
    {
        var_dump('元旦快乐');
        $this->emailBody->body();
    }

}