<?php

/**
 * 装饰器
 */
abstract class EmailBodyDecorator implements EmailBody
{
    protected $emailBody;

    public function __construct(EmailBody $emailBody)
    {
        $this->emailBody = $emailBody;
    }

    /**
     * @return mixed
     */
    abstract public function body();
}