<?php

class BadPerson2 extends Person
{
    use AnimalTrait {
        AnimalTrait::animalInfo as aInfo;
    }//让坏人继承动物特性
    public function index()
    {
        $a = $this->info(BadPerson2::class);
        var_dump($a);
    }
}