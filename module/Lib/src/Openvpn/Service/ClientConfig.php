<?php
namespace Lib\Openvpn\Service;

use Lib\Base\Exception as Exception;

/**
 * Business rules for the ClientConfig 
 */
class ClientConfig 
{
    private $clientConfig;

    public function __construct($clientConfig)
    {
        $this->clientConfig  = $clientConfig;
    }

    /**
     * Return config that client need use to connect to OpenVpn
     * @param $account string
     * @param $server string (ca1,us2,jp1)
     */
    public function getConfig($account, $server)
    {
        // get exsiting config
        try{
            $clientConfig = $this->clientConfig->load($account);
            $param = $clientConfig->getParam();
            if($param->isDirty()){
                throw new Exception\ObjectNotFoundException("Client param is udpated! rebuild config");
            }
        }
        // build config
        catch( Exception\ObjectNotFoundException $e ){
            $clientConfig = $this->clientConfig->buildConfig($account)->save();
            // remove param dirty flag
            try{
                $param = $clientConfig->getParam()->setDirty(false)->save();
            }
            catch( Exception\ObjectNotFoundException $e ){
            }
        }
        $config = $clientConfig->getConfig();
        // replace config with remote server hostname
        return \Lib\Openvpn\Model\ClientParam::replaceServerParam($server, $config);
    }


    /*public function getParam();
    public function setParam();
    public function deleteParam();*/


}
