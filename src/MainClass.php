<?php


namespace Krylov123;


class MainClass
{
    protected $something = null;


    public function __construct(string $something)
    {
        $this->something = $something;
    }

    /**
     * @return string|null
     */
    public function getSomething()
    {
        return $this->something;
    }

    /**
     * @param  string|null  $something
     */
    public function setSomething($something)
    {
        $this->something = $something;
    }



}
