<?php
namespace Lib\Openvpn\Worker;

use Lib\Base\AbstractModel;
use Lib\Base\Process\MultiProcess;
use Lib\Base\Exception as Exception;
use Lib\Openvpn\Process\ServerFetchStatusProcess;

class FetchAllServerStatus 
{
    /**
     * @var Model serverstatus
     */
    private $serverStatus;

    public function __construct(AbstractModel $serverStatus)
    {
        $this->serverStatus = $serverStatus;
    }

    /**
     * Execute process 
     *
     * Implement Singleprocess run()
     */
    public function run($async = false)
    {
        $mutliProc = new MultiProcess();

        // fetch all hosts servers status from db
        $serverStatus = $this->serverStatus;
        $entities     = $serverStatus->fetchAll();

        // create a process for each host
        foreach($entities as $entity){
            $host = $entity->getHost();
            $mutliProc->addProcess( new ServerFetchStatusProcess($host) );
        }

        $op = $mutliProc->run($async);
        return $op;

    }
}
