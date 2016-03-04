<?php
namespace Lib\Openvpn\Worker;

use Lib\Base\Exception as Exception;

class GetClientConfig 
{
    /**
     * @var Model clientKey, clientparam, $clientConfig
     */
    protected $clientKey;
    protected $clientParam;
    protected $clientConfig;

    public function __construct($clientKey, $clientParam, $clientConfig)
    {
        $this->clientKey       = $clientKey;
        $this->clientParam     = $clientParam;
        $this->clientConfig    = $clientConfig;
    }

    /**
     * Process worker
     *
     * worker entity point
     */
    public function run($account, $server)
    {
        $config =  $this->getConfigFile($account);
        $config =  $this->clientParam->replaceServerParam($server, $config);
        return $config;
    }

    /**
     * determine rebuild or return exist cleint config
     */
    public function getConfigFile($account)
    {
        $clientParam = $this->clientParam;
        try{
            $entity = $this->clientConfig->fetch($account);
            if( $clientParam->isDirty($account) ){
                throw new Exception\ObjectNotFoundException("Client param is udpated! rebuild config");
            }
            // return existing config file
            return $entity->getConfig();
        }
        // Rebuild (config not exist or param isDirty)
        catch( Exception\ObjectNotFoundException $e ){
            return $this->buildConfig($account);
        }
    }

    /**
     * build client config
     */
    public function buildConfig($account)
    {
        $config =  $this->clientConfig->getConfigTemplate();
        $config =  $this->buildKeyConfig($account, $config);
        $config =  $this->buildParamConfig($account, $config);

        $this->saveConfg($account, $config);
        return $config;
    }

    /**
     * Build new key if client key dose not already exist
     */
    private function buildKeyConfig($account, $config)
    {
        $clientKey = $this->clientKey;
        try{
            $entity = $clientKey->buildKey($account);
            // save ras key
            $clientKey->update($entity->toArray());
        }
        catch( Exception\ObjectAlreadyExistsException $e ){
            // Do nothing
        }
        $config = $clientKey->buildConfig($account, $config); 
        return $config;
    }

    /**
     * build client config base on client param
     */
    private function buildParamConfig($account, $config)
    {
        $clientParam = $this->clientParam;
        return $clientParam->buildConfig($account, $config);
    }

    /**
     * Save rebuild client config
     */
    private function saveConfg($account, $config)
    {
        $clientConfig = $this->clientConfig;
        $clientParam  = $this->clientParam;

        // save client config
        $clientConfigEntity = $clientConfig->getEntity();
        $clientConfigEntity->setAccountId($account);
        $clientConfigEntity->setconfig($config);
        $clientConfig->update($clientConfigEntity->toArray());

        // remove param dirty flag
        try{
            $clientParamEntity = $clientParam->fetch( $account );
            $clientParamEntity->setDirty( false );
            $clientParam->update( $clientParamEntity->toArray() );
        }
        catch( Exception\ObjectNotFoundException $e ){
        }
    }

}

