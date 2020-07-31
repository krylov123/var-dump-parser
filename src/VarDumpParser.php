<?php


namespace Krylov123;


class VarDumpParser
{
    protected $options = [];


    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param  array  $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

}
