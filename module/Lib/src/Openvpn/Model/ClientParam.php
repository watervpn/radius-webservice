<?php
namespace Lib\Openvpn\Model;

use Lib\Openvpn\Model\ServerStatus;
use Lib\Openvpn\Entity\ClientParam as ClientParamEntity;
use Lib\Base\Exception as Exception;
/**
 * Business rules for the ClientParam 
 */
class ClientParam extends ClientParamEntity
{
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

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Overwrite AbstractEntity save()
     */
    public function save()
    {
        $params = $this->getParams();
        $this->validateParams($params);
        return parent::save();
    }

    /**
     * Validate params before save to db
     * @param $account (array| params)
     */
    public function validateParams(array $params)
    {
        $paramKeys = array_keys($params);
        $paramDiff = array_diff($paramKeys, $this->allowParams) ;
        if( !empty($paramDiff) ){
            throw new \Exception("Invalid client param: [".implode(', ' ,$paramDiff)."]. Only [".implode(', ', $this->allowParams)."] params are allowed! ");
        }
    }

    /**
     * if params is set,  pass in params will be used to build config instead of client params from db
     */
    //private function replaceParams($config)
    public function replaceConfig( $config )
    {
        $params = $this->getParams();
        foreach($params as $key => $value){
            $config = \Lib\Openvpn\Util\ConfigHelper::replaceConfig($key, $value, $config);
        }
        return $config;
    }

    /**
     * set and replace server remote location
     */
    public static function replaceServerParam($server, $config ){
        $config = \Lib\Openvpn\Util\ConfigHelper::replaceConfig('remote', $server.'.'.ServerStatus::VPN_DOMAIN, $config);
        return $config;
    }

    
    public function isDirty()
    {
        if($this->getDirty()){
            return true;
        }
        return false;
    }

}

