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
    public function getServerStatus($host=null, $orderby=null, $sort=null)
    {
        $serverStatus = $this->serverStatus;
        if(empty($host)){
            $entities = $serverStatus->fetchAll($orderby, $sort);
        }else{
            $entities = $serverStatus->load($host);
        }
        return $entities;
    }

    public function getByRegion($region=null, $orderby=null, $sort=null)
    {
        $serverStatus = $this->serverStatus;
        //$models = $serverStatus->getMapper()->findByRegion($region, $orderby, $sort);
        $models = $serverStatus->getByRegion($region, $orderby, $sort);
        return $models;
    }

    public function getRegions()
    {
        $serverStatus = $this->serverStatus;
        $models = $serverStatus->getRegions();
        return $models;
    }

    // TODO:
    //public function getServerStatusByLoad($host=null)

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
