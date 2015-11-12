<?php
namespace Lib\Openvpn\Entity;

use Lib\Base\AbstractEntity;

class ClientConfig extends AbstractEntity
{
    protected $accountId;
    protected $config;
    protected $modified;

    public function __construct($accountId = null, $config = null, $modified = null)
    {
        $this->accountId  = $accountId;
        $this->config   = $config;
        $this->modified = $modified;
    }

    // Getter
    public function getAccountId()
    {
        return $this->accountId;
    }
    public function getConfig()
    {
        return $this->config;
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
    public function setconfig($config)
    {
        $this->config = $config;
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
        $this->config       = (!empty($data['config'])) ? $data['config'] : null;
        $this->modified     = (!empty($data['modified'])) ? $data['modified'] : null;
    }

    /**
     * Implement Abstract getarraycopy
     */
    public function getArrayCopy()
    {
        return array(
            'account_id' => $this->accountId,
            'config'     => $this->config,
            'modified'   => $this->modified,
        );
    }
}
