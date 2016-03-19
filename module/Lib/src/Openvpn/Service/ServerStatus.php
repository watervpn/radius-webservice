<?php
namespace Lib\Openvpn\Service;

use Lib\Base\Exception as Exception;

/**
 * Server Status Service 
 */
class ServerStatus 
{
    private $serverStatus;
    private $serverStatusWorker;

    public function __construct($serverStatus, $serverStatusWorker)
    {
        $this->serverStatus        = $serverStatus;
        $this->serverStatusWorker  = $serverStatusWorker;
    }

    /**
     * Get openvpn servers status
     * @return Model\ServerStatus
     */
    public function getServerStatus($host=null)
    {
        $serverStatus = $this->serverStatus;
        if(empty($host)){
            $entities = $serverStatus->fetchAll();
        }else{
            $entities = $serverStatus->load($host);
        }
        return $entities;
    }

    /**
     * Trigger multiprocess job to fetch openvpn servers status 
     * @return array process info 
     */
    public function fetchServerStatusJob($async = false)
    {
        return $op = $this->serverStatusWorker->run($async);
    }

    /**
     * Trigger multiprocess job to fetch openvpn servers status 
     */
    public function showProcessStatus()
    {

    }

}
