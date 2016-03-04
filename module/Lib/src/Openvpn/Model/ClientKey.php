<?php
namespace Lib\Openvpn\Model;

use Lib\Base\AbstractModel;
use Lib\Openvpn\Entity\ClientKey as ClientKeyEntity;
use Lib\Base\Exception as Exception;

/**
 * Business rules for the Account 
 * business level constants, properties, methds
 */
class ClientKey extends AbstractModel
{
    public function __construct($mapper)
    {
        parent::__construct($mapper);
    }

    /**
     * replace client config file ras key 
     * replaceConfigKey
     */
    public function buildConfig($account, $config)
    {
        $entity = $this->fetch($account);
        $config = \Lib\Openvpn\Util\ConfigHelper::replaceKey('cert', $entity->getCrtKey(), $config);
        $config = \Lib\Openvpn\Util\ConfigHelper::replaceKey('key', $entity->getPrvKey(), $config);
        return $config;
    }

    /**
     * build RSA key
     * @param $account (string| account name/id)
     */
    public function buildKey($account)
    {
        // check if Rsa key exist
        try{
            $clientKeyEntity = $this->fetch($account);
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

            $entity = new ClientKeyEntity($account, $keys['crt'], $keys['key'], $keys['csr'], date("Y-m-d H:i:s"));

            // Clean up Rsa key
            $op   = \Lib\Openvpn\Util\EasyRsa::revoke($account);
            $op   = \Lib\Openvpn\Util\EasyRsa::delete($account);
            return $entity;
        }catch(\Exception $e){
            // throw exception
            echo "errer buildKey<br/>";
        }
    }

}
