<?php
namespace Lib\Openvpn\Model;

use Lib\Openvpn\Entity\ClientConfig as ClientConfigEntity;
use Lib\Base\Exception as Exception;

/**
 * Business rules for the ClientConfig 
 */
class ClientConfig extends ClientConfigEntity
{
    private $clientKey;
    private $clientParam;

    public function __construct($clientKey, $clientParam)
    {
        $this->clientKey       = $clientKey;
        $this->clientParam     = $clientParam;
        parent::__construct();
    }

    /**
     * build client config
     * @param $account (string| account name/id)
     */
    public function buildConfig($account)
    {
        $config = $this->getConfigTemplate();
        $config = $this->buildKeyConfig($account, $config);
        $config = $this->buildParamConfig($account, $config);

        $this->setAccountId($account);
        $this->setconfig($config);
        return $this;
    }

    /**
     * Build new key if client key dose not already exist
     * @param $account (string| account name/id)
     * @param $config string
     */
    private function buildKeyConfig($account, $config)
    {
        try{
            $clientKey = $this->clientKey->buildKey($account)->save();
            return $config = $clientKey->replaceConfig($config);
        }
        catch( Exception\ObjectAlreadyExistsException $e ){
            return $config  = $this->clientKey->load($account)->replaceConfig($config);
        }
    }

    /**
     * build client config base on client param
     * @param $account (string| account name/id)
     * @param $config string
     */
    private function buildParamConfig($account, $config)
    {
        try{
            return $config = $this->clientParam->load($account)->replaceConfig($config);
        }
        catch( Exception\ObjectNotFoundException $e ){
            return $config;
        }
    }

    /**
     * @return clientKey model
     */
    public function getKey()
    {
        return $this->clientKey->load($this->getAccountId());
    }

    /**
     * @return clientparam model
     */
    public function getParam()
    {
        return $this->clientParam->load($this->getAccountId());
    }

    /**
     * file path to client config template
     */
    private static function getConfigPath()
    {
        return __DIR__.'/../Util/ConfigTemplate/client-config.ovpn';
    }

    /**
     * get client config tempalte
     */
    public static function getConfigTemplate($overwrite = 'default'){
        // TODO: 
        // get default template 
        // overlay example: ca1, us1 or ca, us, xxx schema
        // if overlay not default, get the set of server array and overwrite on default template
        //return $config = file_get_contents(self::CONFIG_TEMPLATE_FILE);
    //http://stackoverflow.com/questions/3191131/read-edit-save-config-files-php
        return $config = file_get_contents( self::getConfigPath() );
    }


}
