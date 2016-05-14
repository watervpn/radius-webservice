<?php
namespace Lib\Openvpn\Process;
use Lib\Base\Process\SingleProcess;

class ServerFetchStatusProcess extends SingleProcess
{
    private $host;

    public function __construct( $host ){
        $this->host = $host;
        parent::__construct( $host );
    }

    /**
     * Implement Singleprocess getPath()
     */
    public function getPath()
    {
        return __DIR__;
    }

    private function validate()
    {
        if(empty($this->host)){
            return;
        }
    }

    private function debug($data)
    {
        echo "process {$data->getHost()} running #download[{$data->getDownload()}] #upload:[{$data->getUpload()}] #cpu:[{$data->getCpu()}] #mem:[{$data->getMem()}]\r\n";
    }

    /**
     * Execute process 
     *
     * Implement Singleprocess run()
     * @param array
     */
    public function run()
    {
        $this->validate();

        $serverStatus = \Lib\ServiceManager::getModel('Openvpn', 'ServerStatus')->load($this->host);
        $serverStatus->fetchServerStatus();
        $serverStatus->save();

        $this->debug($serverStatus);
    }

}
