<?php


class SerializeStrategy implements OutputStrategy
{

    /**
     * @param array $data
     * @return mixed
     */
    public function render(array $data)
    {
        return serialize($data);
    }
}