<?php


class SpringFestivalEmail extends EmailBodyDecorator
{
    /**
     * @return mixed
     */
    public function body()
    {
        var_dump('春节快乐');
        $this->emailBody->body();
    }

}