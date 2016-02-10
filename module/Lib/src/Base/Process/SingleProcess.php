<?php
namespace Lib\Base\Process;

//use Lib\Base\Process\SingleProcess;

Abstract class SingleProcess
{
    protected $name;

    public function __construct( $name = "unname")
    {
        $this->name = $name;
    }

    public function setName( $name )
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    // __DIR__
    abstract public function getPath();

    /**
     * Execute process 
     *
     * @param array
     */
    abstract public function run();

}
