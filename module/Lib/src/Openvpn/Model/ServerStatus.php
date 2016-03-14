<?php
namespace Lib\Openvpn\Model;

use Lib\Openvpn\Entity\ServerStatus as ServerStatusEntity;
/**
 * Business rules for the ClientParam 
 * business level constants, properties, methds
 */
class ServerStatus extends ServerStatusEntity
{
    const VPN_DOMAIN = 'watervpn.com';

    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Fetch live remote vpn server status
     * @param $host (string| host name ex: ca1, jp1)
     */
    public function fetchServerStatus()
    {
        if(empty($this->getHost())){
            throw new \Exception(__CLASS__.":".__FUNCTION__.'Mising Host name');
        }
        $fetcher = new \Lib\Openvpn\Util\ServerStatusFetcher($this->getHost().'.'.self::VPN_DOMAIN);

        list($dl, $ul) = $fetcher->getBandwidth($this->getEth());
        $this->setDownload($dl);
        $this->setUpload($ul);
        $this->setTotalUsers($fetcher->getUserCount());
        $this->setCpu($fetcher->getCpu());
        $this->setMem($fetcher->getMemory());
        $this->setModified(date("Y-m-d H:i:s"));
        return $this;
    }


}

