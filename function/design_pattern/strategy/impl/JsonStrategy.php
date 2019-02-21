<?php


class JsonStrategy implements OutputStrategy
{
    /**
     * @return mixed
     */
    public function render(array $data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

}