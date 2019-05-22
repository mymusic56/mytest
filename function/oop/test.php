<?php

class T
{
    public function __construct()
    {
        echo "__construct".PHP_EOL;

    }

    public function __destruct()
    {
        echo "__destruct".PHP_EOL;
    }

    public function a()
    {
        echo "a()".PHP_EOL;
    }
}

(new T())->a();

var_dump($argc, $argv);