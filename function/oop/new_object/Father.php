<?php


class Father
{
    public function getNewFather() {
        return new self();
    }

    public function getNewCaller() {
        return new static();
    }
}