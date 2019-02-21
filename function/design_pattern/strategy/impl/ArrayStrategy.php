<?php


class ArrayStrategy implements OutputStrategy
{

    /**
     * @param array $data
     * @return mixed
     */
    public function render(array $data)
    {
        return $data;
    }
}