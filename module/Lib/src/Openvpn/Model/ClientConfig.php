<?php
namespace Lib\Openvpn\Model;

use Lib\Openvpn\Entity\ClientConfig as ClientConfigEntity;
use Lib\Base\Exception as Exception;
/**
 * Business rules for the ClientConfig 
 */
class ClientConfig extends ClientConfigEntity
{
    const VPN_DOMAIN = 'watervpn.com';

    private $mapper;
    private $buildConfigWorker;
    private $clientParamMapper;

    public function __construct($mapper = null, $buildConfigWorker = null, $clientParamMapper = null)
    {
        $this->mapper = $mapper;
        $this->buildConfigWorker = $buildConfigWorker;
        $this->clientParamMapper = $clientParamMapper;
        parent::__construct();
    }

    private static function getConfigPath()
    {
        return __DIR__.'/../Util/ConfigTemplate/client-config.ovpn';
    }

    /**
     * Determine rebuild or return exist cleint config
     */
    public function getConfigFile($account, $server)
    {
        try{
            // return client config if already exsit
            $clientConfig = $this->mapper->find($account);
            $this->exchangeArray( $clientConfig->getArrayCopy() );

            if( $this->isParamUpdated($account) ){
                throw new Exception\ObjectNotFoundException("Client param is udpated! rebuild config");
            }
            return $this->replaceServerParam($server);
        }
        catch( Exception\ObjectNotFoundException $e ){
            // rebuild config only config not exist or param is updated
            $this->buildConfigFile( $account );
            return $this->replaceServerParam($server);
        }
    }

    /**
     * build client config
     */
    public function buildConfigFile($account, $params = null)
    {
        // call worker to build config
        $configTempalte = $this->getConfigTemplate();
        $config = $this->buildConfigWorker->run($account, $configTempalte, $params);
        
        if(empty($params)){
            $this->saveConfgChange($account, $config);
        }
    }

    /**
     * Update param and save client config
     */
    private function saveConfgChange($account, $config)
    {
        $clientParamMapper = $this->clientParamMapper;

        $this->setAccountId($account);
        $this->setconfig($config);
        // save client config 
        $this->mapper->save($this);
        // remove param updated flag
        try{
            $clientParam = $clientParamMapper->find( $account );
            $clientParam->setUpdated( false );
            $clientParamMapper->save( $clientParam );
        }
        catch( Exception\ObjectNotFoundException $e ){
        }
    }

    /**
     * Check if client param is updated
     */
    private function isParamUpdated( $account )
    {
        try{
            $clientParam = $this->clientParamMapper->find( $account );
            if($clientParam->getUpdated()){
                return true;
            }
        }
        catch( Exception\ObjectNotFoundException $e ){ 
            return false;
        }
        return false;
    }

    /**
     * set and replace server remote location
     */
    public function replaceServerParam( $server ){
        $config =  $this->getConfig();
        $config = \Lib\Openvpn\Util\ConfigHelper::replaceConfig('remote', $server.'.'.self::VPN_DOMAIN, $config);
        return $config;
    }

    public static function getConfigTemplate($overwrite = 'default'){
        // TODO: 
        // get default template 
        // overlay example: ca1, us1 or ca, us, xxx schema
        // if overlay not default, get the set of server array and overwrite on default template
        //return $config = file_get_contents(self::CONFIG_TEMPLATE_FILE);
        return $config = file_get_contents( self::getConfigPath() );
    }

    //http://stackoverflow.com/questions/3191131/read-edit-save-config-files-php

}
