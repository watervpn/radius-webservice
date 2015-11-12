<?php
namespace Lib\Openvpn\Entity;

use Lib\Base\AbstractEntity;

class ClientKey extends AbstractEntity
{
    public $accountId;
    public $crt;
    public $key;
    public $csr;
    public $modified;

    public function __construct($accountId = null, $crt = null, $key = null, $csr = null, $modified = null)
    {
        $this->accountId  = $accountId;
        $this->crt      = $crt;
        $this->key      = $key;
        $this->csr      = $csr;
        $this->modified = $modified;
    }

    // Getter
    public function getAccountId()
    {
        return $this->accountId;
    }
    public function getCrt()
    {
        return $this->crt;
    }
    public function getKey()
    {
        return $this->key;
    }
    public function getCsr()
    {
        return $this->csr;
    }
    public function getModified()
    {
        return $this->modified;
    }

    // Setter
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    }
    public function setCrt($crt)
    {
        $this->crt = $crt;
        $this->setModified( date("Y-m-d H:i:s") );
    }
    public function setKey($key)
    {
        $this->key = $key;
        $this->setModified( date("Y-m-d H:i:s") );
    }
    public function setCsr($csr)
    {
        $this->csr = $csr;
        $this->setModified( date("Y-m-d H:i:s") );
    }
    public function setModified($modified)
    {
        $this->modified = $modified;
    }

    /**
     * Implement Abstract exchangearray
     */
    public function exchangeArray(array $data)
    {
        $this->accountId    = (!empty($data['account_id'])) ? $data['account_id'] : null;
        $this->crt          = (!empty($data['crt'])) ? $data['crt'] : null;
        $this->key          = (!empty($data['key'])) ? $data['key'] : null;
        $this->csr          = (!empty($data['csr'])) ? $data['csr'] : null;
        $this->modified     = (!empty($data['modified'])) ? $data['modified'] : null;
    }

    /**
     * Implement Abstract getarraycopy
     */
    public function getArrayCopy()
    {
        return array(
            'account_id' => $this->accountId,
            'crt'        => $this->crt,
            'key'        => $this->key,
            'csr'        => $this->csr,
            'modified'   => $this->modified,
        );
    }
}
