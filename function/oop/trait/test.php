<?php
/**
 * 使用trait实现多继承
 */
require_once 'AnimalTrait.php';
require_once 'Person.php';

$p = new BadPerson();
$p->index();
$p->animalInfo();