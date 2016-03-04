<?php
namespace Lib\Openvpn\Model;

use Lib\Base\AbstractModel;
use Lib\Openvpn\Model\ServerStatus;
use Lib\Openvpn\Entity\ClientParam as ClientParamEntity;
use Lib\Base\Exception as Exception;
/**
 * Business rules for the ClientParam 
 */
class ClientParam extends AbstractModel
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

    public function __construct($mapper)
    {
        parent::__construct($mapper);
    }

    /**
     * Overwrite create
     * @param $account (string| account name/id)
     */
    public function create(array $data)
    {
        $params = json_decode($data['params'], true);
        $this->validateParams($params);
        return parent::create($data);
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

    public function replaceParams(array $params, $config)
    {
        foreach($params as $key => $value){
            $config = \Lib\Openvpn\Util\ConfigHelper::replaceConfig($key, $value, $config);
        }
        return $config;
    }

    /**
     * Replace the config with client params
     * @param $account (string| account name/id)
     * @return $config (String| client config file)
     */
    public function replaceParamsByAccount($account, $config)
    {
        $params = $this->fetch($account)->getParams();
        return $this->replaceParams($params, $config);
    }

    /**
     * set and replace server remote location
     */
    public function replaceServerParam($server, $config ){
        $config = \Lib\Openvpn\Util\ConfigHelper::replaceConfig('remote', $server.'.'.ServerStatus::VPN_DOMAIN, $config);
        return $config;
    }

    /**
     * if params is set,  pass in params will be used to build config instead of client params from db
     */
    public function buildConfig( $account, $config )
    {
        // build with pass-in params
        /*if(!empty($overwriteParams)){
            return $this->replaceParams($overwriteParams, $config);
        }*/
        // build with saved client params
        try{
            return $this->replaceParamsByAccount($account, $config);
        }
        catch( Exception\ObjectNotFoundException $e ){
            // Do nothing
        }
        return $config;
    }
    
    public function isDirty($account)
    {
        try{
            $entity = $this->fetch($account);
            if($entity->getDirty()){
                return true;
            }
        }
        catch( Exception\ObjectNotFoundException $e ){ 
            return false;
        }
        return false;
    }

}

