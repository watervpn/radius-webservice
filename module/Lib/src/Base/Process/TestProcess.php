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

        $ca1 = new \Lib\Openvpn\Util\ServerFetchStatus('ca1.watervpn.com');
        list($dl, $ul) = $ca1->getBandwidth();
        echo "process is running ####### download[{$dl}] ###upload:[{$ul}]####\r\n";

        /*
        $time = rand(1,5);
        sleep($time);

        //error_log("process is running ####### [{$this->getName()}] ###time:[{$time}]####\r\n");
        //file_put_contents('/tmp/alfred/proLog.txt', "process is running ####### [{$this->getName()}] ###time:[{$time}]####\r\n");
        echo "process is running ####### [{$this->getName()}] ###time:[{$time}]####\r\n";
         */
    }
}
