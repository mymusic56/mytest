<?php


class RaiseSalaryEmail implements EmailBody
{

    /**
     * @return mixed
     */
    public function body()
    {
        var_dump('公司准备为您加薪50%。');
    }

}