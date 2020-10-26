<?php

$number = 1234.565;

// english notation (default)
$english_format_number = number_format($number);
// 1,235

var_dump($english_format_number);

// French notation
$nombre_format_francais = number_format($number, 2, '.', ',');
// 1 234,56
var_dump($nombre_format_francais);

$number = 1234.5678;

// english notation without thousands separator
$english_format_number = number_format($number, 2, '.', '');
// 1234.57
var_dump($english_format_number);
