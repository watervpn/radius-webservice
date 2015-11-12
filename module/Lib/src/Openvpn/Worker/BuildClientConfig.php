<?php
namespace Lib\Openvpn\Worker;

use Lib\Base\Exception as Exception;

class BuildClientConfig 
{
    protected $clientConfigMapper;
    protected $clientParamMapper;
    protected $clientKeyMapper;
    protected $clientKey;
    protected $clientParam;
    protected $clientConfig;

    public function __construct($clientConfigMapper, $clientKeyMapper, $clientParamMapper, $clientKey, $clientParam = null)
    {
        $this->clientConfigMapper  = $clientConfigMapper;
        $this->clientKeyMapper     = $clientKeyMapper;
        $this->clientParamMapper   = $clientParamMapper;
        $this->clientKey           = $clientKey;
        $this->clientParam         = $clientParam;
    }

    /**
     * Build [param] only if client config already exist
     * Build both [key] & [param] if client config not found
     */
    public function run( $account, $config, array $params = null )
    {
        $config =  $this->buildKey($account, $config);
        $config =  $this->buildParam($account, $config, $params);
        return $config;
    }

    /**
     * Build new key if client key dose not already exist
     */
    private function buildKey( $account, $config )
    {
        $clientKey          = $this->clientKey;
        $clientKeyMapper    = $this->clientKeyMapper;
        try{
            $clientKey = $clientKeyMapper->find( $account );
        }
        catch( Exception\ObjectNotFoundException $e ){
            $clientKey->buildKey( $account );
            $clientKeyMapper->save( $clientKey );
        }
        $config = $clientKey->replaceConfigKey( $config );
        return $config;
    }

    /**
     * if params is set,  pass in params will be used to build config instead of client params from db
     */
    private function buildParam( $account, $config, array $params = null )
    {
        $clientParamMapper    = $this->clientParamMapper;
        $clientParam          = $this->clientParam;
        // build with pass-in params
        if(!empty($params)){
            $clientParam->setParams($params);
            return $config = $clientParam->replaceConfigParam($config);
        }
        // build with saved client params
        try{
            $clientParam = $clientParamMapper->find( $account );
            $config = $clientParam->replaceConfigParam( $config );
        }
        catch( Exception\ObjectNotFoundException $e ){
            // Do nothing
        }
        return $config;
    }

}

