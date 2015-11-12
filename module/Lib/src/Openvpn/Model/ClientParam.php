<?php
namespace Lib\Openvpn\Model;

use Lib\Openvpn\Entity\ClientParam as ClientParamEntity;
/**
 * Business rules for the ClientParam 
 */
class ClientParam extends ClientParamEntity
{
    // business level constants
    // business level properties
    // business level methods 
    
    private $mapper;
    private $allowParams = array(
        'dev', 
        'client', 
        'dev-node', 
        'remote',
        'remote-random',
        'proto',
        'resolv-retry',
        'verb',
        'cipher',
        'user',
        'group',
        'ns-cert-type',
        'http-proxy',
        'comp-lzo',
    );

    public function __construct($mapper = null)
    {
        $this->mapper = $mapper;
        parent::__construct();
    }

    public function replaceConfigParam($config)
    {
        $params = $this->getParams();
        foreach($params as $key => $value){
            $config = \Lib\Openvpn\Util\ConfigHelper::replaceConfig($key, $value, $config);
        }
        return $config;
    }

    public function validateParams(array $params)
    {
        $paramKeys = array_keys($params);
        $paramDiff = array_diff($paramKeys, $this->allowParams) ;
        if( !empty($paramDiff) ){
            throw new \Exception("Invalid client param: [".implode(', ' ,$paramDiff)."]. Only [".implode(', ', $this->allowParams)."] params are allowed! ");
        }
    }

}

