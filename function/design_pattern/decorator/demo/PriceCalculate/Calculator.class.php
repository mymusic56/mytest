<?php
namespace HeadPortrait\Service\PriceCalculate;


interface Calculator
{
    public function calculator(Pirce $price, $combo, $param);
}