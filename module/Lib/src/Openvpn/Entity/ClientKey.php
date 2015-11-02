<?php
namespace Lib\Openvpn\Entity;

use Lib\Base\AbstractEntity;

class ClientKey extends AbstractEntity
{
    public $id;
    public $account;
    public $crt;
    public $key;
    public $csr;
    public $modified;

    public function __construct($id = null, $account = null, $crt = null, $key = null, $csr = null, $modified = null)
    {
        $this->id       = $id;
        $this->account  = $account;
        $this->crt      = $crt;
        $this->key      = $key;
        $this->csr      = $csr;
        $this->modified = $modified;
    }

    // Getter
    public function getId()
    {
        return $this->id;
    }
    public function getAccount()
    {
        return $this->account;
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
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setAccount($account)
    {
        $this->account = $account;
    }
    public function setCrt($crt)
    {
        $this->crt = $crt;
    }
    public function setKey($key)
    {
        $this->key = $key;
    }
    public function setCsr($csr)
    {
        $this->csr = $csr;
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
        $this->id           = (!empty($data['id'])) ? $data['id'] : null;
        $this->account      = (!empty($data['account'])) ? $data['account'] : null;
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
            'id'         => $this->id,
            'account'    => $this->account,
            'crt'        => $this->crt,
            'key'        => $this->key,
            'csr'        => $this->csr,
            'modified'   => $this->modified,
        );
    }
}
