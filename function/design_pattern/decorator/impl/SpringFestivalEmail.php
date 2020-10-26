<?php


class SpringFestivalEmail extends EmailBodyDecorator
{
    /**
     * @return mixed
     */
    public function body()
    {
        $this->emailBody->body();
        var_dump('春节快乐');
    }

}