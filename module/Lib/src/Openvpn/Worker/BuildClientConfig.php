<?php
namespace Lib\Openvpn\Worker;

use Lib\Base\Exception as Exception;

class BuildClientConfig 
{
    protected $clientConfigMapper;
    protected $clientParamMapper;
    protected $clientKeyMapper;
    protected $clientKey;

    public function __construct($clientConfigMapper, $clientKeyMapper, $clientKey, $clientParamMapper = null)
    {
        $this->clientConfigMapper  = $clientConfigMapper;
        $this->clientKeyMapper     = $clientKeyMapper;
        $this->clientKey           = $clientKey;
        $this->clientParamMapper   = $clientParamMapper;
    }

    public function run( $account, $server, $config )
    {
        $clientKey          = $this->clientKey;
        $clientKeyMapper    = $this->clientKeyMapper;
        $clientConfigMapper = $this->clientConfigMapper;

        try{
            // Crt/Keys process
            $clientKey->buildKey( $account );
            $clientKeyMapper->save( $clientKey );
            $config = $clientKey->replaceConfigKey( $config );

            // Params process

            return $config;

        }
        catch(Exception\ObjectNotFoundException $e){
        }
        catch(\Exception $e){
        }
    }

}

    // buildConfig($host, $account)  from config param
       // build key  & buile Param
          // ----- client key
          // $config = $this->getConfigTemplate(); 
          // $this->config = $this->buildKey($host, $account, $config)
          // ----- client Param
          // $this->config = $this->buildParam($host, $account, $this->config);
          // return $this->config

    // buildKeyConfig( $account, $config)
          // mapper->find($account);
              // check if key not exsit clientKey->exist($account)
                  // $keys = static:clientkey->build($account); return clientKey Objecr
                  // mapper save new build keys
              // else get keys from db
                  // $this->config = $clientKey->replaceConfigKey($keys, $this->getConfigTemplate());
              // if no change return $this->config
   
    // buildParamConfig($host, $account, $config)
          // mapper->find($account);
              // check paramConfig is updated
                  // $this->config = $ClientConfigParam->replaceConfigParam($serverName, $config);
                  // return $this-config
                  // 2 method
                  // $params = clientConfigParamMapper->findByAccount($account);
                  // foreach($params as $params){
                  //    $config = \Lib\Openvpn\Util\ConfigHelper::replaceKey($param->getparam(), $param->getValue(), $config);
                  // }
              // if no change return config
           
    // getConfigTemplate();
    // getConfigFile($serverName, $account) 
          // check if ClientConfig exist 
          // buildConfig if config not exsit 
              // $this->account = $account
              // $this->host    = $host
              // $this->modified = time();
              // $this->config = $this->buildConfig($host, $account);
              // save - configMapper->save($this);
          // if config exist || paramConfig is updated
              // configMapper->find($account)
              // $this->confg = $this->buildParamConfig($host, $account, $config)
              // save - configMapper->save($this);
// call Util/easyRsa::build()
// save key to client key db
// ClientConfig::buildConfig() & saveConfig
