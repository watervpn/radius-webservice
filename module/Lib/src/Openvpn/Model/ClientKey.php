<?php
namespace Lib\Openvpn\Model;

use Lib\Openvpn\Entity\ClientKey as ClientKeyEntity;
use Lib\Base\Exception as Exception;
/**
 * Business rules for the Account 
 */
class ClientKey extends ClientKeyEntity
{
    // business level constants
    // business level properties
    // business level methods 

    //buildKey($account) using util::EasyRsa::build() and save it 
    private $mapper;
    public function setMapper($mapper)
    {
        $this->mapper = $mapper;
    }

    public function replaceConfigKey($config)
    {
        $config = \Lib\Openvpn\Util\ConfigHelper::replaceKey('cert', $this->getCrtKey(), $config);
        $config = \Lib\Openvpn\Util\ConfigHelper::replaceKey('key', $this->getKey(), $config);
        return $config;
    }

    public function buildKey($account)
    {
        try{
            // load from db if key already exist on db
            $clientKey = $this->mapper->findByAccount($account);
            $this->exchangeArray( $clientKey->getArrayCopy());
        }catch(Exception\ObjectNotFoundException $e){
            if(\Lib\Openvpn\Util\EasyRsa::isKeyExist($account)){
                $op = \Lib\Openvpn\Util\EasyRsa::revoke($account);
            }
            $this->doBuildKey($account);
        }
    }

    private function doBuildKey($account)
    {
        try{
            // Build key
            $op = \Lib\Openvpn\Util\EasyRsa::build($account);
            $keys = \Lib\Openvpn\Util\EasyRsa::getKeys($account);
            $this->exchangeArrayKeys($account, $keys);
            // Clean up 
            $op = \Lib\Openvpn\Util\EasyRsa::revoke($account);
            $op = \Lib\Openvpn\Util\EasyRsa::delete($account);
        }catch(\Exception $e){
            // throw exception
            echo "errer buildKey<br/>";
        }
    }

    private function exchangeArrayKeys($account, $keys)
    {
        $this->account = $account;
        $this->crt = $keys['crt'];
        $this->key = $keys['key'];
        $this->csr = $keys['csr'];
        $this->modified = date("Y-m-d H:i:s");
    }

    public function getCrtKey()
    {
        $matches = array();
        preg_match('/-----BEGIN CERTIFICATE-----.*-----END CERTIFICATE-----/s', $this->getCrt(), $matches);
        return $matches[0];
    }

}
