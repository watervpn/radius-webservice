<?php
namespace Lib\Base\Process;

//use Lib\Base\Process\SingleProcess;

Abstract class SingleProcess
{
    protected $name;
    protected $sm;

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

    public function setServiceManager( $sm )
    {
        $this->sm = $sm;
    }

    public function getServiceManager()
    {
        return $this->sm;
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
