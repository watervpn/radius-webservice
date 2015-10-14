<?php
namespace Lib\Radius\Entity;

use Lib\Base\AbstractEntity;

class GroupReply extends AbstractEntity
{
    public $id;
    public $groupname;
    public $attribute;
    public $op;
    public $value;

    public function __construct($id = null, $groupname = null, $attribute = null, $op = null, $value = null)
    {
        $this->id = $id;
        $this->groupname = $groupname;
        $this->attribute = $attribute;
        $this->op = $op;
        $this->value = $value;
    }

    // Getter
    public function getId()
    {
        return $this->id;
    }
    public function getGroupname()
    {
        return $this->groupname;
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
    public function setGroupname($groupname)
    {
        $this->groupname = $groupname;
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

    public function exchangeArray(array $data)
    {
        $this->id            = (!empty($data['id'])) ? $data['id'] : null;
        $this->groupname     = (!empty($data['groupname'])) ? $data['groupname'] : null;
        $this->attribute     = (!empty($data['attribute'])) ? $data['attribute'] : null;
        $this->op            = (!empty($data['op'])) ? $data['op'] : null;
        $this->value         = (!empty($data['value'])) ? $data['value'] : null;
    }

    public function getArrayCopy()
    {
        return array(
            'id'         => $this->id,
            'groupname'  => $this->groupname,
            'attribute'  => $this->attribute,
            'op'         => $this->op,
            'value'      => $this->value,
        );
    }

}
