<?php
namespace Lib\Openvpn\Entity;

use Lib\Base\AbstractEntity;

class ClientConfig extends AbstractEntity
{
    protected $accountId;
    protected $server;
    protected $config;
    protected $modified;

    public function __construct($accountId = null, $server = null, $config = null, $modified = null)
    {
        $this->accountId  = $accountId;
        $this->server   = $server;
        $this->config   = $config;
        $this->modified = $modified;
    }

    // Getter
    public function getAccountId()
    {
        return $this->accountId;
    }
    public function getServer()
    {
        return $this->server;
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
    public function setServer($server)
    {
        $this->server = $server;
    }
    public function setconfig($config)
    {
        $this->config = $config;
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
        $this->server       = (!empty($data['server'])) ? $data['server'] : null;
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
            'server'     => $this->server,
            'config'     => $this->config,
            'modified'   => $this->modified,
        );
    }
}
