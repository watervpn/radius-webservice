<?php
namespace Lib\Openvpn\Service;

use Lib\Base\Exception as Exception;

/**
 * Business rules for the ClientConfig 
 */
class ClientConfig 
{
    private $clientConfig;
    private $clientParam;

    public function __construct($clientConfig, $clientParam)
    {
        $this->clientConfig  = $clientConfig;
        $this->clientParam  = $clientParam;
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

    public function getConfigs($account, array $servers)
    {
        $files = [];
        foreach($servers as $server){
           $files[$server] = $this->getConfig($account, $server); 
        }
        return $files;
    }

    /**
     * Return clientParam object
     * @param $account string
     */
    public function getParam($accountId)
    {
        return $this->clientParam->load($accountId);
    }

    /**
     * Save a openvpn client param
     * @param $account string
     * @param $key string (remote,dev,user etc..)
     */
    public function setParam($accountId, $key, $value)
    {
        $clientParam = $this->clientParam;
        try{
            $clientParam = $clientParam->load($accountId);
        }
        catch( Exception\ObjectNotFoundException $e ){
            $clientParam->setAccountId($accountId);
        }
        return $clientParam->setParam($key, $value)->save();
    }

    /**
     * Save openvpn client params
     * @param $account string
     * @param $key string (remote,dev,user etc..)
     */
    public function setParams($accountId, array $data)
    {
        $clientParam = $this->clientParam;
        try{
            $clientParam = $clientParam->load($accountId);
        }
        catch( Exception\ObjectNotFoundException $e ){
            $clientParam->setAccountId($accountId);
        }

        foreach($data as $key => $value){
            $clientParam->setParam($key, $value);
        }
        return $clientParam->save();
    }

    /**
     * @param $account string
     * @param $key string (remote,dev,user etc..)
     */
    public function deleteParam($accountId, $key)
    {
        return $this->clientParam
            ->load($accountId)
            ->deleteParam($key)
            ->save();
    }


}
