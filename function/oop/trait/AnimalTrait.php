<?php

trait AnimalTrait
{
    public $name = 'pig';

    public function animalInfo()
    {
        var_dump("this person has animalInfo, name: ".$this->name);
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }
}