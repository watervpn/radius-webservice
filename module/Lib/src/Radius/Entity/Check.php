<?php
namespace Lib\Radius\Entity;

use Lib\Base\AbstractEntity;

class Check extends AbstractEntity
{
    public $id;
    public $username;
    public $attribute;
    public $op;
    public $value;

    public function __construct($id = null, $username = null, $attribute = null, $op = null, $value = null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->attribute = $attribute;
        $this->op = $op;
        $this->value = $value;
    }

    // Getter
    public function getId()
    {
        return $this->id;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getAttribute()
    {
        return $this->attribute;
    }
    public function getOp()
    {
        return $this->op;
    }
    public function getValue()
    {
        return $this->value;
    }

    // Setter
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setUsername($username)
    {
        $this->username = $username;
    }
    public function setAttribute($attribute)
    {
        $this->attribute = $attribute;
    }
    public function setOp($op)
    {
        $this->op = $op;
    }
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Implement Abstract exchangearray
     */
    public function exchangeArray(array $data)
    {
        $this->id            = (!empty($data['id'])) ? $data['id'] : null;
        $this->username      = (!empty($data['username'])) ? $data['username'] : null;
        $this->attribute     = (!empty($data['attribute'])) ? $data['attribute'] : null;
        $this->op            = (!empty($data['op'])) ? $data['op'] : null;
        $this->value         = (!empty($data['value'])) ? $data['value'] : null;
    }

    /**
     * Implement Abstract getarraycopy
     */
    public function getArrayCopy()
    {
        return array(
            'id'         => $this->id,
            'username'   => $this->username,
            'attribute'  => $this->attribute,
            'op'         => $this->op,
            'value'      => $this->value,
        );
    }

}
