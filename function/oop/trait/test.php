<?php
/**
 * PHP是单继承，使用trait以面向对象的方式实现代码的复用。
 * 1. use traitName之后，可以在类中像调用父类中的发发一样调用trait的中法。
 * 2. 多个同名trait可以使用
 *      use traitName as otherName
 */
require_once 'AnimalTrait.php';
require_once 'Person.php';
require_once 'BadPerson.php';
require_once 'BadPerson2.php';

$p = new BadPerson();
$p->index();
$p->animalInfo();
$p->setName('pig pig');

$p2 = new BadPerson2();
$p2->index();
$p2->aInfo();
