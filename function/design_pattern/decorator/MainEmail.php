<?php


class MainEmail implements EmailBody
{
    /**
     * @return mixed
     */
    public function body()
    {
        echo "公司准备为您加薪50%。\n";
    }

}