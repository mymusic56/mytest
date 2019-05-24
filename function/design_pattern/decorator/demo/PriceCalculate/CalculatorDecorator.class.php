<?php
namespace HeadPortrait\Service\PriceCalculate;


abstract class CalculatorDecorator implements Calculator
{
    public $calculator;
    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
    }

    abstract function calculator(Pirce $price, $combo, $param);
}