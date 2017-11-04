<?php
namespace Lib\Openvpn\Model;

use Lib\Openvpn\Entity\ClientKey as ClientKeyEntity;
use Lib\Base\Exception as Exception;

/**
 * Business rules for the Account 
 * business level constants, properties, methds
 */
class ClientKey extends ClientKeyEntity
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * build RSA key
     * @param $account (string| account name/id)
     */
    public function buildKey($account)
    {
        // check if Rsa key exist
        try{
            $clientKey = $this->load($account);
            throw new Exception\ObjectAlreadyExistsException(__CLASS__. " RSA key for [$account] is already exist ");
        }
        // build Rsa key if not already exist
        catch(Exception\ObjectNotFoundException $e){
            if( \Lib\Openvpn\Util\EasyRsa::isKeyExist($account) ){
                $op = \Lib\Openvpn\Util\EasyRsa::revoke($account);
            }
            return $this->doBuildKey($account);
        }
    }

    /**
     * execute the  actual build RSA key process
     * @param $account (string| account name/id)
     */
    private function doBuildKey($account)
    {
        try{
            // Build Rsa key 
            $op   = \Lib\Openvpn\Util\EasyRsa::build($account);
            $keys = \Lib\Openvpn\Util\EasyRsa::getKeys($account);

            $this->setAccountId($account);
            $this->setCrt($keys['crt']);
            $this->setKey($keys['key']);
            $this->setCsr($keys['csr']);

            // Clean up Rsa key
            $op   = \Lib\Openvpn\Util\EasyRsa::revoke($account);
            $op   = \Lib\Openvpn\Util\EasyRsa::delete($account);
            return $this;
        }catch(\Exception $e){
            // throw exception
            echo "errer buildKey<br/>";
        }
    }

    /**
     * replace client config file ras key 
     * replaceConfigKey
     */
    //public function buildConfig($config)
    public function replaceConfig($config)
    {
        $config = \Lib\Openvpn\Util\ConfigHelper::replaceKey('cert', $this->getCrtKey(), $config);
        $config = \Lib\Openvpn\Util\ConfigHelper::replaceKey('key', $this->getPrvKey(), $config);
        return $config;
    }

}
