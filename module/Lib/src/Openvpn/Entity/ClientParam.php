<?php
namespace Lib\Openvpn\Entity;

use Lib\Base\AbstractEntity;

class ClientParam extends AbstractEntity
{
    protected $accountId;
    protected $params;
    protected $modified;
    protected $updated;

    public function __construct($accountId = null, $params = null, $modified = null, $updated = null)
    {
        $this->accountId  = $accountId;
        $this->params      = $params;
        $this->modified   = $modified;
        $this->updated    = (bool)$updated;
    }

    public function addParam($key, $value)
    {
        $params = $this->getParams();
        $params[$key] = $value;
        $this->setParams($params);
    }
    public function deleteParam($key)
    {
        $params = $this->getParams();
        unset( $params[$key] );
        $this->setParams($params);
    }

    // Getter
    public function getAccountId()
    {
        return $this->accountId;
    }
    public function getParams()
    {
        return json_decode($this->params, true);
    }
    public function getParam($key)
    {
        $params = $this->getParams();
        return $params[$key];
    }
    public function getModified()
    {
        return $this->modified;
    }
    public function getUpdated()
    {
        return (bool)$this->updated;
    }

    // Setter
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    }
    public function setParams(array $params)
    {
        $this->validateParams($params);
        $this->params =  json_encode($params, true);
        $this->setUpdated(true);
        $this->setModified( date("Y-m-d H:i:s") );
    }
    public function setParam($key, $value)
    {
        $this->addParam($key, $value);
    }
    public function setModified($modified)
    {
        $this->modified = $modified;
    }
    public function setUpdated($updated)
    {
        $this->updated = (bool)$updated;
    }

    /**
     * Implement Abstract exchangearray
     */
    public function exchangeArray(array $data)
    {
        $this->accountId    = (!empty($data['account_id'])) ? $data['account_id'] : null;
        $this->params        = (!empty($data['params'])) ? $data['params'] : null;
        $this->modified     = (!empty($data['modified'])) ? $data['modified'] : null;
        $this->updated      = (!empty($data['updated'])) ? (bool)$data['updated'] : null;
    }

    /**
     * Implement Abstract getarraycopy
     */
    public function getArrayCopy()
    {
        return array(
            'account_id' => $this->accountId,
            'params'      => $this->params,
            'modified'   => $this->modified,
            'updated'    => (bool)$this->updated,
        );
    }
}
