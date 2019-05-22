<?php

class BadPerson extends Person
{
    use AnimalTrait;//让坏人继承动物特性
    public function index()
    {
        $a = $this->info(BadPerson::class);
        var_dump($a);
    }
}