<?php
namespace Lib\Base\Process;
use Lib\Base\Process\SingleProcess;

class TestProcess extends SingleProcess
{
    public function __construct( $name ){
        parent::__construct( $name );
    }

    public function getPath()
    {
        return __DIR__;
    }

    /**
     * Execute process 
     *
     * @param array
     */
    public function run()
    {
        $time = rand(1,5);
        sleep($time);
        echo "process is running ####### [{$this->getName()}] ###time:[{$time}]####\r\n";
    }
}
