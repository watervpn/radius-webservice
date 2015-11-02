<?php
namespace Lib\Openvpn\Model;

use Lib\Openvpn\Entity\ClientConfig as ClientConfigEntity;
/**
 * Business rules for the Account 
 */
class ClientConfig extends ClientConfigEntity
{
    // business level constants
    // business level properties
    // business level methods 

    //

    // buildConfig($host, $account)  from config param
       // build key  & buile Param
          // ----- client key
          // $config = $this->getConfigTemplate(); 
          // $this->config = $this->buildKey($host, $account, $config)
          // ----- client Param
          // $this->config = $this->buildParam($host, $this->config);
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

//http://stackoverflow.com/questions/3191131/read-edit-save-config-files-php
    /*$file = file_get_contents('/path/to/config/file');
$matches = array();
preg_match('/^database\.params\.dbname = (.*)$/', $file, $matches);
$file = str_replace($matches[1], $new_value, $file);
file_put_contents('/path/to/config/file', $file);*/

}
