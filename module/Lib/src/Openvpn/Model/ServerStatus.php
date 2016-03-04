<?php
namespace Lib\Openvpn\Model;

//use Lib\Openvpn\Entity\ServerStatus as ServerStatusEntity;
use Lib\Base\AbstractModel;
/**
 * Business rules for the ClientParam 
 * business level constants, properties, methds
 */
class ServerStatus extends AbstractModel
{
    const VPN_DOMAIN = 'watervpn.com';

    public function __construct($statusMapper)
    {
        parent::__construct($statusMapper);
    }
    
    /**
     * Fetch live remote vpn server status
     * @param $host (string| host name ex: ca1, jp1)
     */
    public function fetchServerStatus($host)
    {
        $statusEntity  = $this->fetch($host);
        $fetcher       = new \Lib\Openvpn\Util\ServerStatusFetcher($host.'.'.self::VPN_DOMAIN);
        
        list($dl, $ul) = $fetcher->getBandwidth($statusEntity->getEth());
        $statusEntity->setDownload($dl);
        $statusEntity->setUpload($ul);
        $statusEntity->setTotalUsers($fetcher->getUserCount());
        $statusEntity->setCpu($fetcher->getCpu());
        $statusEntity->setMem($fetcher->getMemory());
        $statusEntity->setModified(date("Y-m-d H:i:s"));
        return $statusEntity;
    }


}

