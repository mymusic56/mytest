<?php


class Output
{
    private $strategy;

    /**
     * Output constructor.
     */
    public function __construct(OutputStrategy $outputStrategy)
    {
        $this->strategy = $outputStrategy;
    }

    public function render(array $data)
    {
        return $this->strategy->render($data);
    }

}